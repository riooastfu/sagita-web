<?php
defined('BASEPATH') or exit('No direct script access allowed');
use GuzzleHttp\Client;

class Mining extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('Excel'); //load librari excel
        $this->load->model('model_training');
    }

    public function index()
    {
        $data['title'] = 'Data Training';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['training'] = $this->db->get('data_training')->result_array();
        $data['aktif'] = $this->db->query('select * from data_upload')->num_rows();

        if(isset($_POST['submit'])){
            $fileName = $_FILES['file']['name'];

            $config['upload_path'] = './uploads/'; //path upload
            $config['file_name'] = $fileName;  // nama file
            $config['allowed_types'] = 'xls|xlsx'; //tipe file yang diperbolehkan
            $config['max_size'] = 10000; // maksimal size

            $this->load->library('upload'); //meload librari upload
            $this->upload->initialize($config);

            if(! $this->upload->do_upload('file') ){
                echo $this->upload->display_errors();exit();
            }

            $inputFileName = './uploads/'.$fileName;
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $this->db->truncate('data_training');
            for ($row = 2; $row <= $highestRow; $row++){//  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE);

                // Sesuaikan key array dengan nama kolom di database
                $data = array(
                    "umur"=> $rowData[0][0],
                    "berat"=> $rowData[0][1],
                    "jk"=> $rowData[0][2],
                    "tinggi"=> $rowData[0][3],
                    "status"=> $rowData[0][4]
                );

                $this->db->insert("data_training",$data);
            }

            $this->db->insert("data_upload",['nama_file'=> $fileName]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data training telah ditambahkan </div>');
            redirect('mining?status=table');
        }

        if(isset($_POST['proses'])) {
            redirect('mining/training?status=update');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mining/index', $data);
        $this->load->view('templates/footer');
    }

    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pasien'] = $data['imt'] = $data['berat'] = $data['tinggi'] = $data['status'] = null;

        $nama_keyword =  isset($_POST['keyword']) ?  $_POST['keyword'] : null ;
        try {
            $client = new Client([
                'base_uri' => 'http://localhost:3000', 'timeout' => 5,
            ]);

            $response = $client->request('GET', '/gizi/checkgizi',['query'=>['name' => $nama_keyword]]);
            $body = $response->getBody();
            $data['pasien'] = json_decode($body)->data;
        }catch (Exception $e){
            $data['pasien'] = $data['imt'] = $data['berat'] = $data['tinggi'] = $data['status'] = null;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/check', $data);
        $this->load->view('templates/footer');
    }

    public function training()
    {
        $data['title'] = 'Data Training';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['hasil'] = pembentukan_tree("","");
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Proses mining telah diproses</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mining/index', $data);
    }
}
