<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    </div>

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <form action="<?= site_url("admin/upload_data_training"); ?>" method="post" enctype="multipart/form-data">
                                <!-- <button class="btn btn-info mb-3 ml-2 " onclick='document.getElementById("myfile").click();'> Pilih Data Training</button> -->
                                <div class="form-group">
                                    <label for="" class="control-label">Pilih Data Training</label>
                                    <!-- <input type="file" name="userfile" size="20" /> -->
                                    <input type="file" id="myfile" name="myfile" class="form-control" placeholder="Pilih Data Training">
                                </div>
                                <button type="submit" class="btn btn-primary mb-3">Upload Data Training</button>
                            </form>
                            <form method="post">
                                <button class="btn btn-danger mb-3 ml-2 " onclick="javascript:hapus()"> Clear Data</button>
                                <button name="btnTraining" type="submit" class="btn btn-success mb-3 ml-2">Proses Training</button>
                            </form>
                        </div>





                        <script>
                            function hapus() {
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {

                                        if (Number(xhttp.responseText) === 1) {
                                            location.reload();
                                        }
                                    }
                                };
                                xhttp.open("POST", "<?= base_url("admin/hapus_training"); ?>", true);
                                xhttp.send();
                            }

                            function UploadData(data) {
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {

                                        if (Number(xhttp.responseText) === 1) {
                                            location.reload();
                                        }
                                    }
                                };
                                xhttp.open("POST", "<?= base_url("admin/upload_training/?data="); ?>" + data, true);
                                xhttp.send();
                            }

                            function SetDatatraining() {
                                var sumber = document.getElementById("myfile");
                                let selected = sumber.files[0];
                                let reader = new FileReader();
                                reader.addEventListener("loadend", () => {
                                    let data = reader.result.split("\r\n");
                                    for (let i in data) {
                                        data[i] = data[i].split(",");
                                    }
                                    const myJSON = window.btoa(JSON.stringify(data));
                                    UploadData(myJSON);
                                });
                                reader.readAsText(selected);
                            }
                        </script>

                        <div class="col-md-12 ">
                            <?php if (!is_null($rules)) {  ?>
                                <hr>
                                <a href="<?= site_url("admin/display_rules"); ?>" class="btn btn-success">LIHAT RULES</a>
                            <?php    } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?= $this->session->flashdata('message'); ?>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <th>No</th>
                    <th>Jenis Kelamin</th>
                    <th>Umur</th>
                    <th>Berat Badan</th>
                    <th>Tinggi Badan</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <?php if (empty($data) or is_null($data)) : ?>
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-light dark text-center">Data Masih Kosong</div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1;
                        foreach ($data as $key => $val) : ?>
                            <tr>
                                <td> <?= $no++; ?> </td>
                                <td> <?= $val->jk_normal; ?></td>
                                <td> <?= $val->umur_normal; ?></td>
                                <td> <?= $val->berat_normal; ?></td>
                                <td> <?= $val->tinggi_normal; ?></td>
                                <td> <?= $val->status_normal; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal -->

<!-- /.container-fluid -->
</div>
<!-- End of Main Content -- >     