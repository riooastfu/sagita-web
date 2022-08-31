<?php
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        if (!$role_id) {
            redirect('auth/blocked');
        }
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }

}

function format_decimal($value){
    return round($value, 3);
}

function proses_DT($parent, $kasus_cabang1, $kasus_cabang2) {
    $cabang = '';
    echo "cabang 1<br>";
    pembentukan_tree($parent, $kasus_cabang1);
    echo "cabang 2<br>";
    pembentukan_tree($parent, $kasus_cabang2);

}
function pembentukan_tree($N_parent , $kasus)
{
    $return_text = '';
    $ci = get_instance();
    //mengisi kondisi
    if($N_parent!=''){
        $kondisi = $N_parent." AND ".$kasus;
    }else{
        $kondisi = $kasus;
    }
    #$return_text .= $kondisi."<br>";
    //cek data heterogen / homogen???
    $cek = cek_heterohomogen('status',$kondisi);
    if($cek=='homogen'){
        $return_text .= "<br> LEAF || ";
        $sql_keputusan = $ci->db->query("SELECT DISTINCT(status) FROM data_training WHERE 1=1 $kondisi");
        $keputusan = $sql_keputusan->result();
        $this->pangkas($N_parent, $kasus , $keputusan);
    }else if($cek=='heterogen') {
        $kondisi_kelas_asli = '';
        if ($kondisi != '') {
            $kondisi_kelas_asli = $kondisi . " AND ";
        }
        $jml_normal = jumlah_data("$kondisi_kelas_asli status='Normal'");
        $jml_obesitas = jumlah_data("$kondisi_kelas_asli status='Obesitas'");
        $jml_buruk = jumlah_data("$kondisi_kelas_asli status='Gizi Buruk'");
        $jml_kurang = jumlah_data("$kondisi_kelas_asli status='Gizi Kurang'");
        $jml_beresiko = jumlah_data("$kondisi_kelas_asli status='Beresiko Gizi Lebih'");
        $jml_lebih = jumlah_data("$kondisi_kelas_asli status='Gizi Lebih'");

        $jml_total = $jml_normal + $jml_obesitas + $jml_buruk + $jml_kurang + $jml_beresiko + $jml_lebih;
        $return_text .= "Jumlah Data = " . $jml_total . "<br>";
        $return_text .= "Jumlah Normal = " . $jml_normal . "<br>";
        $return_text .= "Jumlah Obesitas = " . $jml_obesitas . "<br>";
        $return_text .= "Jumlah Gizi Buruk = " . $jml_buruk . "<br>";
        $return_text .= "Jumlah Gizi Kurang = " . $jml_kurang . "<br>";
        $return_text .= "Jumlah Gizi Beresiko Lebih = " . $jml_beresiko . "<br>";
        $return_text .= "Jumlah Gizi Lebih = " . $jml_lebih . "<br>";

        $entropy_all = hitung_entropy($jml_normal, $jml_obesitas, $jml_buruk, $jml_kurang, $jml_beresiko, $jml_lebih);
        $return_text .= "Entropy All = " . $entropy_all . "<br>";

        $return_text .= "<br><table class='table table-striped'>";
        $return_text .= "<tr><th>Nilai Atribut</th> <th>Jumlah Data</th> <th>Gizi Buruk</th> <th>Gizi Kurang</th> "
            . "<th>Normal</th> <th>Gizi Lebih</th><th>Gizi Beresiko Lebih</th> <th>Obesitas</th> "
            . "<th>Entropy</th> <th>Gain</th><tr>";

        $ci->db->query("TRUNCATE gain");
        //hitung gain atribut JENIS_KELAMIN
        $return_text .= hitung_gain($ci, $kondisi, "jk", $entropy_all, "jk='L'", "jk='P'", "", "", "");
        //hitung gain atribut UMUR
        $return_text .= hitung_gain_umur($ci, $kondisi, "Umur", $entropy_all);
        $return_text .= hitung_gain_berat($ci, $kondisi, "Berat", $entropy_all);
        $return_text .= hitung_gain_tinggi($ci, $kondisi, "Tinggi", $entropy_all);
        $return_text .= "</table>";

        //ambil nilai gain terBesar
        $sql_max = $ci->db->query("SELECT MAX(gain) as maksimum FROM gain");
        $row_max = $sql_max->result();
        $max_gain = $row_max[0]->maksimum;
        $sql = $ci->db->query("SELECT * FROM gain WHERE gain=$max_gain");
        $row = $sql->result();
        $atribut = $row[0]->atribut;
        $return_text .= "Atribut terpilih = " . $atribut . ", dengan nilai gain = " . $max_gain;
        $return_text .= "<br>=====================================<br>";

        if ($max_gain == 0) {
            $return_text .= "<br>LEAF ";
            $Nnormal = $kondisi . " AND status='Normal'";
            $NObesitas = $kondisi . " AND status='Obesitas'";
            $NBuruk = $kondisi . " AND status='Gizi Buruk'";
            $NKurang = $kondisi . " AND status='Gizi Kurang'";
            $NBeresiko = $kondisi . " AND status='Beresiko Gizi Lebih'";
            $NLebih = $kondisi . " AND status='Gizi Lebih'";
            $jumlahbaik = jumlah_data($ci, "$Nnormal");
            $jumlahobesitas = jumlah_data($ci, "$NObesitas");
            $jumlahburuk = jumlah_data($ci, "$NBuruk");
            $jumlahkurang = jumlah_data($ci, "$NKurang");
            $jumlahberesiko = jumlah_data($ci, "$NBeresiko");
            $jumlahlebih = jumlah_data($ci, "$NLebih");

            if($jumlahburuk >= $jumlahkurang &&
                $jumlahburuk >= $jumlahbaik &&
                $jumlahburuk >= $jumlahberesiko &&
                $jumlahburuk >= $jumlahlebih &&
                $jumlahburuk >= $jumlahobesitas) {
                $keputusan = 'Buruk';
            }
            elseif($jumlahkurang >= $jumlahburuk &&
                $jumlahkurang >= $jumlahbaik &&
                $jumlahkurang >= $jumlahberesiko &&
                $jumlahkurang >= $jumlahlebih &&
                $jumlahkurang >= $jumlahobesitas) {
                $keputusan = 'Kurang';
            }
            elseif($jumlahbaik >= $jumlahburuk &&
                $jumlahbaik >= $jumlahkurang &&
                $jumlahbaik >= $jumlahberesiko &&
                $jumlahbaik >= $jumlahlebih &&
                $jumlahbaik >= $jumlahobesitas) {
                $keputusan = 'Baik';
            }
            elseif($jumlahberesiko >= $jumlahburuk &&
                $jumlahberesiko >= $jumlahkurang &&
                $jumlahberesiko >= $jumlahbaik &&
                $jumlahberesiko >= $jumlahlebih &&
                $jumlahberesiko >= $jumlahobesitas) {
                $keputusan = 'Beresiko';
            }
            elseif($jumlahlebih >= $jumlahburuk &&
                $jumlahlebih >= $jumlahkurang &&
                $jumlahlebih >= $jumlahbaik &&
                $jumlahlebih >= $jumlahberesiko &&
                $jumlahlebih >= $jumlahobesitas) {
                $keputusan = 'Beresiko';
            }
            else {
                $keputusan = 'Obesitas';
            }
            $return_text.= pangkas($N_parent, $kasus, $keputusan);
        }else{
            if ($atribut == "jk") {
                proses_DT($kondisi, "($atribut='L')", "($atribut='P')");
            }
        }
    }
    return $return_text;
}

function pangkas($PARENT, $KASUS, $LEAF){
    $ci = get_instance();

    $ci->db->insert('t_keputusan',['parent'=> $PARENT,'akar'=> $KASUS, 'keputusan'=> $LEAF]);
    return "Keputusan = ".$LEAF."<br>================================<br>";
}

function cek_heterohomogen($field , $kondisi){
    $ci = get_instance();

    if($kondisi==''){
        $sql = $ci->db->query("SELECT DISTINCT($field) FROM data_training");
    }else{
        $sql = $ci->db->query("SELECT DISTINCT($field) FROM data_training WHERE $kondisi");
    }
    if ($sql->num_rows() == 1) {
        $nilai = "homogen";
    }else{
        $nilai = "heterogen";
    }
    return $nilai;
}

function jumlah_data($kondisi){
    $ci = get_instance();

    if($kondisi==''){
        $sql = $ci->db->query("SELECT COUNT(*) as total FROM data_training $kondisi");
    }else{
        $sql = $ci->db->query("SELECT COUNT(*) as total FROM data_training WHERE $kondisi");
    }
    $row = $sql->result();
    $jml = isset($row[0]) ? $row[0]->total : 0;
    return $jml;
}

function hitung_entropy($nilai1, $nilai2, $nilai3, $nilai4, $nilai5, $nilai6) {
    $total = $nilai1 + $nilai2 + $nilai3 + $nilai4 + $nilai5 + $nilai6;
    $atribut1 = (-($nilai1 / $total) * (log(($nilai1 / $total), 2)));
    $atribut2 = (-($nilai2 / $total) * (log(($nilai2 / $total), 2)));
    $atribut3 = (-($nilai3 / $total) * (log(($nilai3 / $total), 2)));
    $atribut4 = (-($nilai4 / $total) * (log(($nilai4 / $total), 2)));
    $atribut5 = (-($nilai5 / $total) * (log(($nilai5 / $total), 2)));
    $atribut6 = (-($nilai6 / $total) * (log(($nilai6 / $total), 2)));

    $atribut1 = is_nan($atribut1)?0:$atribut1;
    $atribut2 = is_nan($atribut2)?0:$atribut2;
    $atribut3 = is_nan($atribut3)?0:$atribut3;
    $atribut4 = is_nan($atribut4)?0:$atribut4;
    $atribut5 = is_nan($atribut5)?0:$atribut5;
    $atribut6 = is_nan($atribut6)?0:$atribut6;

    $entropy = $atribut1 + $atribut2 + $atribut3 + $atribut4 + $atribut5 + $atribut6;
    $entropy = format_decimal($entropy);
    return $entropy;
}

//fungsi menghitung gain
function hitung_gain($db_object, $kasus, $atribut, $ent_all, $kondisi1, $kondisi2, $kondisi3, $kondisi4, $kondisi5) {
    $table = '';
    $data_kasus = '';
    if ($kasus != '') {
        $data_kasus = $kasus . " AND ";
    }
    //untuk atribut 2 nilai atribut
    if ($kondisi3 == '') {
        $jml_normal = jumlah_data( "$data_kasus status='Normal' AND $kondisi1");
        $jml_obesitas = jumlah_data( "$data_kasus status='Obesitas' AND $kondisi1");
        $jml_buruk = jumlah_data( "$data_kasus status='Gizi Buruk' AND $kondisi1");
        $jml_kurang = jumlah_data( "$data_kasus status='Gizi Kurang' AND $kondisi1");
        $jml_beresiko = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND $kondisi1");
        $jml_lebih = jumlah_data( "$data_kasus status='Gizi Lebih' AND $kondisi1");
        $jml1 = $jml_normal + $jml_obesitas + $jml_buruk + $jml_kurang + $jml_beresiko + $jml_lebih;

        $jml_normal2 = jumlah_data( "$data_kasus status='Normal' AND $kondisi2");
        $jml_obesitas2 = jumlah_data( "$data_kasus status='Obesitas' AND $kondisi2");
        $jml_buruk2 = jumlah_data( "$data_kasus status='Gizi Buruk' AND $kondisi2");
        $jml_kurang2 = jumlah_data( "$data_kasus status='Gizi Kurang' AND $kondisi2");
        $jml_beresiko2 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND $kondisi2");
        $jml_lebih2 = jumlah_data( "$data_kasus status='Gizi Lebih' AND $kondisi2");
        $jml2 = $jml_normal2 + $jml_obesitas2 + $jml_buruk2 + $jml_kurang2 + $jml_beresiko2 + $jml_lebih2;

        $jml_total = $jml1 + $jml2;
        $ent1 = hitung_entropy($jml_normal, $jml_obesitas ,$jml_buruk, $jml_kurang, $jml_beresiko, $jml_lebih);
        $ent2 = hitung_entropy($jml_normal2, $jml_obesitas2 ,$jml_buruk2, $jml_kurang2, $jml_beresiko2, $jml_lebih2);

        $gain = $ent_all - ((($jml1 / $jml_total) * $ent1) + (($jml2 / $jml_total) * $ent2));
        //desimal 3 angka dibelakang koma
        $gain = format_decimal($gain);

        $table.=  "<tr><td>Jenis Kelamin</td><td colspan='9'></td></tr>";
        $table.=  "<tr>";
        $table.=  "<td>Laki - laki</td>";
        $table.=  "<td>" . $jml1 . "</td>";
        $table.=  "<td>" . $jml_buruk . "</td>";
        $table.=  "<td>" . $jml_kurang . "</td>";
        $table.=  "<td>" . $jml_normal . "</td>";
        $table.=  "<td>" . $jml_beresiko . "</td>";
        $table.=  "<td>" . $jml_lebih . "</td>";
        $table.=  "<td>" . $jml_obesitas . "</td>";
        $table.=  "<td>" . $ent1 . "</td>";
        $table.=  "<td>&nbsp;</td>";
        $table.=  "</tr>";

        $table.=  "<tr>";
        $table.=  "<td>Perempuan</td>";
        $table.=  "<td>" . $jml2 . "</td>";
        $table.=  "<td>" . $jml_buruk2 . "</td>";
        $table.=  "<td>" . $jml_kurang2 . "</td>";
        $table.=  "<td>" . $jml_normal2 . "</td>";
        $table.=  "<td>" . $jml_beresiko2 . "</td>";
        $table.=  "<td>" . $jml_lebih2 . "</td>";
        $table.=  "<td>" . $jml_obesitas2 . "</td>";
        $table.=  "<td>" . $ent2 . "</td>";
        $table.=  "<td>" . $gain . "</td>";
        $table.=  "</tr>";

        $table.=  "<tr><td colspan='10'>&nbsp;</td></tr>";
    }
    $db_object->db->query("INSERT INTO gain VALUES ('','1','$atribut','$gain')");

    return $table;
}
function hitung_gain_umur($db_object, $kasus, $atribut, $ent_all){
    $table = '';
    $data_kasus = '';
    if ($kasus != '') {
        $data_kasus = $kasus . " AND ";
    }
    $jml_normal1 = jumlah_data( "$data_kasus status='Normal' AND ( Umur between 12 AND 24 )");
    $jml_obesitas1 = jumlah_data( "$data_kasus status='Obesitas' AND ( Umur between 12 AND 24 )");
    $jml_buruk1 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( Umur between 12 AND 24 )");
    $jml_kurang1 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( Umur between 12 AND 24 )");
    $jml_beresiko1 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( Umur between 12 AND 24 )");
    $jml_lebih1 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( Umur between 12 AND 24 )");
    $jml_umur1 = $jml_normal1 + $jml_obesitas1 + $jml_buruk1 + $jml_kurang1 + $jml_beresiko1 + $jml_lebih1;

    $jml_normal2 = jumlah_data( "$data_kasus status='Normal' AND ( Umur between 25 AND 36 )");
    $jml_obesitas2 = jumlah_data( "$data_kasus status='Obesitas' AND ( Umur between 25 AND 36 )");
    $jml_buruk2 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( Umur between 25 AND 36 )");
    $jml_kurang2 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( Umur between 25 AND 36 )");
    $jml_beresiko2 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( Umur between 25 AND 36 )");
    $jml_lebih2 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( Umur between 25 AND 36 )");
    $jml_umur2 = $jml_normal2 + $jml_obesitas2 + $jml_buruk2 + $jml_kurang2 + $jml_beresiko2 + $jml_lebih2;

    $jml_normal3 = jumlah_data( "$data_kasus status='Normal' AND ( Umur between 37 AND 48 )");
    $jml_obesitas3 = jumlah_data( "$data_kasus status='Obesitas' AND ( Umur between 37 AND 48 )");
    $jml_buruk3 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( Umur between 37 AND 48 )");
    $jml_kurang3 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( Umur between 37 AND 48 )");
    $jml_beresiko3 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( Umur between 37 AND 48 )");
    $jml_lebih3 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( Umur between 37 AND 48 )");
    $jml_umur3 = $jml_normal3 + $jml_obesitas3 + $jml_buruk3 + $jml_kurang3 + $jml_beresiko3 + $jml_lebih3;

    $jml_normal4 = jumlah_data( "$data_kasus status='Normal' AND ( Umur between 49 AND 60 )");
    $jml_obesitas4 = jumlah_data( "$data_kasus status='Obesitas' AND ( Umur between 49 AND 60 )");
    $jml_buruk4 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( Umur between 49 AND 60 )");
    $jml_kurang4 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( Umur between 49 AND 60 )");
    $jml_beresiko4 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( Umur between 49 AND 60 )");
    $jml_lebih4 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( Umur between 49 AND 60 )");
    $jml_umur4 = $jml_normal4 + $jml_obesitas4 + $jml_buruk4 + $jml_kurang4 + $jml_beresiko4 + $jml_lebih4;

    #TOTAL SEMUA UMUR
    $jml_total = $jml_umur1 + $jml_umur2 + $jml_umur3 + $jml_umur4;
    $ent1 = hitung_entropy($jml_normal1, $jml_obesitas1, $jml_buruk1, $jml_kurang1, $jml_beresiko1, $jml_lebih1);
    $ent2 = hitung_entropy($jml_normal2, $jml_obesitas2, $jml_buruk2, $jml_kurang2, $jml_beresiko2, $jml_lebih2);
    $ent3 = hitung_entropy($jml_normal3, $jml_obesitas3, $jml_buruk3, $jml_kurang3, $jml_beresiko3, $jml_lebih3);
    $ent4 = hitung_entropy($jml_normal4, $jml_obesitas4, $jml_buruk4, $jml_kurang4, $jml_beresiko4, $jml_lebih4);

    $gain = $ent_all - ((($jml_umur1/$jml_total)*$ent1) + (($jml_umur2/$jml_total)*$ent2) + (($jml_umur3/$jml_total)*$ent3) + (($jml_umur4/$jml_total)*$ent4));
    //desimal 3 angka dibelakang koma
    $gain = format_decimal($gain);

    $table.=  "<tr><td>Umur</td><td colspan='9'></td></tr>";
    $table.=  "<tr>";
    $table.=  "<td> 12 - 24 </td>";
    $table.=  "<td>" . $jml_umur1 . "</td>";
    $table.=  "<td>" . $jml_buruk1 . "</td>";
    $table.=  "<td>" . $jml_kurang1 . "</td>";
    $table.=  "<td>" . $jml_normal1 . "</td>";
    $table.=  "<td>" . $jml_beresiko1 . "</td>";
    $table.=  "<td>" . $jml_lebih1 . "</td>";
    $table.=  "<td>" . $jml_obesitas1 . "</td>";
    $table.=  "<td>" . $ent1 . "</td>";
    $table.=  "<td>&nbsp;</td>";
    $table.=  "</tr>";

    $table.=  "<tr>";
    $table.=  "<td> 25 - 36 </td>";
    $table.=  "<td>" . $jml_umur2 . "</td>";
    $table.=  "<td>" . $jml_buruk2 . "</td>";
    $table.=  "<td>" . $jml_kurang2 . "</td>";
    $table.=  "<td>" . $jml_normal2 . "</td>";
    $table.=  "<td>" . $jml_beresiko2 . "</td>";
    $table.=  "<td>" . $jml_lebih2 . "</td>";
    $table.=  "<td>" . $jml_obesitas2 . "</td>";
    $table.=  "<td>" . $ent2 . "</td>";
    $table.=  "<td>&nbsp;</td>";
    $table.=  "</tr>";

    $table.=  "<tr>";
    $table.=  "<td> 37 - 48 </td>";
    $table.=  "<td>" . $jml_umur3 . "</td>";
    $table.=  "<td>" . $jml_buruk3 . "</td>";
    $table.=  "<td>" . $jml_kurang3 . "</td>";
    $table.=  "<td>" . $jml_normal3 . "</td>";
    $table.=  "<td>" . $jml_beresiko3 . "</td>";
    $table.=  "<td>" . $jml_lebih3 . "</td>";
    $table.=  "<td>" . $jml_obesitas3 . "</td>";
    $table.=  "<td>" . $ent3 . "</td>";
    $table.=  "<td>&nbsp;</td>";
    $table.=  "</tr>";

    $table.=  "<tr>";
    $table.=  "<td> 49 - 60 </td>";
    $table.=  "<td>" . $jml_umur4 . "</td>";
    $table.=  "<td>" . $jml_buruk4 . "</td>";
    $table.=  "<td>" . $jml_kurang4 . "</td>";
    $table.=  "<td>" . $jml_normal4 . "</td>";
    $table.=  "<td>" . $jml_beresiko4 . "</td>";
    $table.=  "<td>" . $jml_lebih4 . "</td>";
    $table.=  "<td>" . $jml_obesitas4 . "</td>";
    $table.=  "<td>" . $ent4 . "</td>";
    $table.=  "<td>" . $gain . "</td>";
    $table.=  "</tr>";
    $table.=  "<tr><td colspan='10'>&nbsp;</td></tr>";

    $db_object->db->query("INSERT INTO gain VALUES ('','1','$atribut','$gain')");

    return $table;
}

function hitung_gain_berat($db_object, $kasus, $atribut, $ent_all){
    $table = '';
    $data_kasus = '';
    if ($kasus != '') {
        $data_kasus = $kasus . " AND ";
    }
    $jml_normal1 = jumlah_data( "$data_kasus status='Normal' AND ( berat between 0 and 9.9 )");
    $jml_obesitas1 = jumlah_data( "$data_kasus status='Obesitas' AND ( berat between 0 and 9.9 )");
    $jml_buruk1 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( berat between 0 and 9.9 )");
    $jml_kurang1 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( berat between 0 and 9.9 )");
    $jml_beresiko1 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( berat between 0 and 9.9 )");
    $jml_lebih1 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( berat between 0 and 9.9 )");
    $jml_umur1 = $jml_normal1 + $jml_obesitas1 + $jml_buruk1 + $jml_kurang1 + $jml_beresiko1 + $jml_lebih1;

    $jml_normal2 = jumlah_data( "$data_kasus status='Normal' AND ( berat between 10 and 14 )");
    $jml_obesitas2 = jumlah_data( "$data_kasus status='Obesitas' AND ( berat between 10 and 14 )");
    $jml_buruk2 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( berat between 10 and 14 )");
    $jml_kurang2 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( berat between 10 and 14 )");
    $jml_beresiko2 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( berat between 10 and 14 )");
    $jml_lebih2 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( berat between 10 and 14 )");
    $jml_umur2 = $jml_normal2 + $jml_obesitas2 + $jml_buruk2 + $jml_kurang2 + $jml_beresiko2 + $jml_lebih2;

    $jml_normal3 = jumlah_data( "$data_kasus status='Normal' AND ( berat between 14.1 and 16.5 )");
    $jml_obesitas3 = jumlah_data( "$data_kasus status='Obesitas' AND ( berat between 14.1 and 16.5 )");
    $jml_buruk3 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( berat between 14.1 and 16.5 )");
    $jml_kurang3 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( berat between 14.1 and 16.5 )");
    $jml_beresiko3 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( berat between 14.1 and 16.5 )");
    $jml_lebih3 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( berat between 14.1 and 16.5 )");
    $jml_umur3 = $jml_normal3 + $jml_obesitas3 + $jml_buruk3 + $jml_kurang3 + $jml_beresiko3 + $jml_lebih3;

    $jml_normal4 = jumlah_data( "$data_kasus status='Normal' AND ( berat > 16.5 )");
    $jml_obesitas4 = jumlah_data( "$data_kasus status='Obesitas' AND ( berat > 16.5 )");
    $jml_buruk4 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( berat > 16.5 )");
    $jml_kurang4 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( berat > 16.5 )");
    $jml_beresiko4 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( berat > 16.5 )");
    $jml_lebih4 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( berat > 16.5 )");
    $jml_umur4 = $jml_normal4 + $jml_obesitas4 + $jml_buruk4 + $jml_kurang4 + $jml_beresiko4 + $jml_lebih4;

    #TOTAL SEMUA UMUR
    $jml_total = $jml_umur1 + $jml_umur2 + $jml_umur3 + $jml_umur4;
    $ent1 = hitung_entropy($jml_normal1, $jml_obesitas1, $jml_buruk1, $jml_kurang1, $jml_beresiko1, $jml_lebih1);
    $ent2 = hitung_entropy($jml_normal2, $jml_obesitas2, $jml_buruk2, $jml_kurang2, $jml_beresiko2, $jml_lebih2);
    $ent3 = hitung_entropy($jml_normal3, $jml_obesitas3, $jml_buruk3, $jml_kurang3, $jml_beresiko3, $jml_lebih3);
    $ent4 = hitung_entropy($jml_normal4, $jml_obesitas4, $jml_buruk4, $jml_kurang4, $jml_beresiko4, $jml_lebih4);

    $gain = $ent_all - ((($jml_umur1/$jml_total)*$ent1) + (($jml_umur2/$jml_total)*$ent2) + (($jml_umur3/$jml_total)*$ent3) + (($jml_umur4/$jml_total)*$ent4));
    //desimal 3 angka dibelakang koma
    $gain = format_decimal($gain);

    $table.=  "<tr><td>Berat</td><td colspan='9'></td></tr>";
    $table.=  "<tr>";
    $table.=  "<td> 0 - 9.9 </td>";
    $table.=  "<td>" . $jml_umur1 . "</td>";
    $table.=  "<td>" . $jml_buruk1 . "</td>";
    $table.=  "<td>" . $jml_kurang1 . "</td>";
    $table.=  "<td>" . $jml_normal1 . "</td>";
    $table.=  "<td>" . $jml_beresiko1 . "</td>";
    $table.=  "<td>" . $jml_lebih1 . "</td>";
    $table.=  "<td>" . $jml_obesitas1 . "</td>";
    $table.=  "<td>" . $ent1 . "</td>";
    $table.=  "<td>&nbsp;</td>";
    $table.=  "</tr>";

    $table.=  "<tr>";
    $table.=  "<td> 10 - 14 </td>";
    $table.=  "<td>" . $jml_umur2 . "</td>";
    $table.=  "<td>" . $jml_buruk2 . "</td>";
    $table.=  "<td>" . $jml_kurang2 . "</td>";
    $table.=  "<td>" . $jml_normal2 . "</td>";
    $table.=  "<td>" . $jml_beresiko2 . "</td>";
    $table.=  "<td>" . $jml_lebih2 . "</td>";
    $table.=  "<td>" . $jml_obesitas2 . "</td>";
    $table.=  "<td>" . $ent2 . "</td>";
    $table.=  "<td>&nbsp;</td>";
    $table.=  "</tr>";

    $table.=  "<tr>";
    $table.=  "<td> 14.1 - 16.5 </td>";
    $table.=  "<td>" . $jml_umur3 . "</td>";
    $table.=  "<td>" . $jml_buruk3 . "</td>";
    $table.=  "<td>" . $jml_kurang3 . "</td>";
    $table.=  "<td>" . $jml_normal3 . "</td>";
    $table.=  "<td>" . $jml_beresiko3 . "</td>";
    $table.=  "<td>" . $jml_lebih3 . "</td>";
    $table.=  "<td>" . $jml_obesitas3 . "</td>";
    $table.=  "<td>" . $ent3 . "</td>";
    $table.=  "<td>&nbsp;</td>";
    $table.=  "</tr>";

    $table.=  "<tr>";
    $table.=  "<td> > 16.5 </td>";
    $table.=  "<td>" . $jml_umur4 . "</td>";
    $table.=  "<td>" . $jml_buruk4 . "</td>";
    $table.=  "<td>" . $jml_kurang4 . "</td>";
    $table.=  "<td>" . $jml_normal4 . "</td>";
    $table.=  "<td>" . $jml_beresiko4 . "</td>";
    $table.=  "<td>" . $jml_lebih4 . "</td>";
    $table.=  "<td>" . $jml_obesitas4 . "</td>";
    $table.=  "<td>" . $ent4 . "</td>";
    $table.=  "<td>" . $gain . "</td>";
    $table.=  "</tr>";
    $table.=  "<tr><td colspan='10'>&nbsp;</td></tr>";

    $db_object->db->query("INSERT INTO gain VALUES ('','1','$atribut','$gain')");

    return $table;
}

function hitung_gain_tinggi($db_object, $kasus, $atribut, $ent_all){
    $table = '';
    $data_kasus = '';
    if ($kasus != '') {
        $data_kasus = $kasus . " AND ";
    }
    $jml_normal1 = jumlah_data( "$data_kasus status='Normal' AND ( tinggi between 0 and 74.5 )");
    $jml_obesitas1 = jumlah_data( "$data_kasus status='Obesitas' AND ( tinggi between 0 and 74.5 )");
    $jml_buruk1 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( tinggi between 0 and 74.5 )");
    $jml_kurang1 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( tinggi between 0 and 74.5 )");
    $jml_beresiko1 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( tinggi between 0 and 74.5 )");
    $jml_lebih1 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( tinggi between 0 and 74.5 )");
    $jml_umur1 = $jml_normal1 + $jml_obesitas1 + $jml_buruk1 + $jml_kurang1 + $jml_beresiko1 + $jml_lebih1;

    $jml_normal2 = jumlah_data( "$data_kasus status='Normal' AND ( tinggi between 74.6 and 94 )");
    $jml_obesitas2 = jumlah_data( "$data_kasus status='Obesitas' AND ( tinggi between 74.6 and 94 )");
    $jml_buruk2 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( tinggi between 74.6 and 94 )");
    $jml_kurang2 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( tinggi between 74.6 and 94 )");
    $jml_beresiko2 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( tinggi between 74.6 and 94 )");
    $jml_lebih2 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( tinggi between 74.6 and 94 )");
    $jml_umur2 = $jml_normal2 + $jml_obesitas2 + $jml_buruk2 + $jml_kurang2 + $jml_beresiko2 + $jml_lebih2;

    $jml_normal3 = jumlah_data( "$data_kasus status='Normal' AND ( tinggi between 94.1 and 103.5 )");
    $jml_obesitas3 = jumlah_data( "$data_kasus status='Obesitas' AND ( tinggi between 94.1 and 103.5 )");
    $jml_buruk3 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( tinggi between 94.1 and 103.5 )");
    $jml_kurang3 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( tinggi between 94.1 and 103.5 )");
    $jml_beresiko3 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( tinggi between 94.1 and 103.5 )");
    $jml_lebih3 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( tinggi between 94.1 and 103.5 )");
    $jml_umur3 = $jml_normal3 + $jml_obesitas3 + $jml_buruk3 + $jml_kurang3 + $jml_beresiko3 + $jml_lebih3;

    $jml_normal4 = jumlah_data( "$data_kasus status='Normal' AND ( tinggi > 103.5 )");
    $jml_obesitas4 = jumlah_data( "$data_kasus status='Obesitas' AND ( tinggi > 103.5 )");
    $jml_buruk4 = jumlah_data( "$data_kasus status='Gizi Buruk' AND ( tinggi > 103.5 )");
    $jml_kurang4 = jumlah_data( "$data_kasus status='Gizi Kurang' AND ( tinggi > 103.5 )");
    $jml_beresiko4 = jumlah_data( "$data_kasus status='Beresiko Gizi Lebih' AND ( tinggi > 103.5 )");
    $jml_lebih4 = jumlah_data( "$data_kasus status='Gizi Lebih' AND ( tinggi > 103.5 )");
    $jml_umur4 = $jml_normal4 + $jml_obesitas4 + $jml_buruk4 + $jml_kurang4 + $jml_beresiko4 + $jml_lebih4;

    #TOTAL SEMUA UMUR
    $jml_total = $jml_umur1 + $jml_umur2 + $jml_umur3 + $jml_umur4;
    $ent1 = hitung_entropy($jml_normal1, $jml_obesitas1, $jml_buruk1, $jml_kurang1, $jml_beresiko1, $jml_lebih1);
    $ent2 = hitung_entropy($jml_normal2, $jml_obesitas2, $jml_buruk2, $jml_kurang2, $jml_beresiko2, $jml_lebih2);
    $ent3 = hitung_entropy($jml_normal3, $jml_obesitas3, $jml_buruk3, $jml_kurang3, $jml_beresiko3, $jml_lebih3);
    $ent4 = hitung_entropy($jml_normal4, $jml_obesitas4, $jml_buruk4, $jml_kurang4, $jml_beresiko4, $jml_lebih4);

    $gain = $ent_all - ((($jml_umur1/$jml_total)*$ent1) + (($jml_umur2/$jml_total)*$ent2) + (($jml_umur3/$jml_total)*$ent3) + (($jml_umur4/$jml_total)*$ent4));
    //desimal 3 angka dibelakang koma
    $gain = format_decimal($gain);

    $table.=  "<tr><td>Tinggi</td><td colspan='9'></td></tr>";
    $table.=  "<tr>";
    $table.=  "<td> 0 - 74.5 </td>";
    $table.=  "<td>" . $jml_umur1 . "</td>";
    $table.=  "<td>" . $jml_buruk1 . "</td>";
    $table.=  "<td>" . $jml_kurang1 . "</td>";
    $table.=  "<td>" . $jml_normal1 . "</td>";
    $table.=  "<td>" . $jml_beresiko1 . "</td>";
    $table.=  "<td>" . $jml_lebih1 . "</td>";
    $table.=  "<td>" . $jml_obesitas1 . "</td>";
    $table.=  "<td>" . $ent1 . "</td>";
    $table.=  "<td>&nbsp;</td>";
    $table.=  "</tr>";

    $table.=  "<tr>";
    $table.=  "<td> 10 - 14 </td>";
    $table.=  "<td>" . $jml_umur2 . "</td>";
    $table.=  "<td>" . $jml_buruk2 . "</td>";
    $table.=  "<td>" . $jml_kurang2 . "</td>";
    $table.=  "<td>" . $jml_normal2 . "</td>";
    $table.=  "<td>" . $jml_beresiko2 . "</td>";
    $table.=  "<td>" . $jml_lebih2 . "</td>";
    $table.=  "<td>" . $jml_obesitas2 . "</td>";
    $table.=  "<td>" . $ent2 . "</td>";
    $table.=  "<td>&nbsp;</td>";
    $table.=  "</tr>";

    $table.=  "<tr>";
    $table.=  "<td> 14.1 - 16.5 </td>";
    $table.=  "<td>" . $jml_umur3 . "</td>";
    $table.=  "<td>" . $jml_buruk3 . "</td>";
    $table.=  "<td>" . $jml_kurang3 . "</td>";
    $table.=  "<td>" . $jml_normal3 . "</td>";
    $table.=  "<td>" . $jml_beresiko3 . "</td>";
    $table.=  "<td>" . $jml_lebih3 . "</td>";
    $table.=  "<td>" . $jml_obesitas3 . "</td>";
    $table.=  "<td>" . $ent3 . "</td>";
    $table.=  "<td>&nbsp;</td>";
    $table.=  "</tr>";

    $table.=  "<tr>";
    $table.=  "<td> > 16.5 </td>";
    $table.=  "<td>" . $jml_umur4 . "</td>";
    $table.=  "<td>" . $jml_buruk4 . "</td>";
    $table.=  "<td>" . $jml_kurang4 . "</td>";
    $table.=  "<td>" . $jml_normal4 . "</td>";
    $table.=  "<td>" . $jml_beresiko4 . "</td>";
    $table.=  "<td>" . $jml_lebih4 . "</td>";
    $table.=  "<td>" . $jml_obesitas4 . "</td>";
    $table.=  "<td>" . $ent4 . "</td>";
    $table.=  "<td>" . $gain . "</td>";
    $table.=  "</tr>";

    $db_object->db->query("INSERT INTO gain VALUES ('','1','$atribut','$gain')");

    return $table;
}
