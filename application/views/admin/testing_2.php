<!-- Begin Page Content -->


<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    </div>
    <button class="btn btn-sm btn-primary mb-3 " data-toggle="modal" data-target="#addData"> Add Data Pasien</button>
    <button class="btn btn-sm btn-danger mb-3 ml-2 " onclick="javascript:hapus()"> Clear Data</button>
    <button class="btn btn-sm btn-info mb-3 ml-2 "  onclick='document.getElementById("myfile").click();'> Upload Data Testing</button>
    <button class="btn btn-sm btn-success mb-3 ml-2 "  onclick='javascript:hitung()'> Hitung</button>
    <input type="file" id="myfile" name="myfile"   onchange="Javascript:SetDatatesting()" style="display:none">
    
    <script>

            function hitung(){
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                     
                        location.reload();
                    }
                };
                xhttp.open("POST", "<?=base_url("admin/hitung_testing");?>", true);
                xhttp.send();
            }

            function hapus(){
                
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                     
                        if (Number(xhttp.responseText)===1){
                            location.reload();
                        }
                    }
                };
                xhttp.open("POST", "<?=base_url("admin/hapus_testing");?>", true);
                xhttp.send();
            }

            function UploadData(data){
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                     
                        if (Number(xhttp.responseText)===1){
                            location.reload();
                        }
                    }
                };
                xhttp.open("POST", "<?=base_url("admin/upload_testing/?data=");?>"+data, true);
                xhttp.send();
            }

            function SetDatatesting(){
                var sumber=document.getElementById("myfile");
                let selected = sumber.files[0]; 
                let reader = new FileReader();
                reader.addEventListener("loadend", () => {
                         let data = reader.result.split("\r\n");
                        for (let i in data) {
                            data[i] = data[i].split(",");
                        }
                        const myJSON = window.btoa (JSON.stringify(data)); 
                        UploadData(myJSON);
                });
                reader.readAsText(selected);
            }
    </script>

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
        <?= $this->session->flashdata('message'); ?>
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
                    <?php if(empty($data) or is_null($data)): ?> 
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-light dark text-center">Data Masih Kosong</div>
                        </td>
                    </tr> 
                    <?php else: ?> 
                    <?php $no=1; foreach ($data as $key => $val):?> 
                    <tr>
                        <td> <?= $no++; ?> </td>
                        <td> <?= $val->jk; ?></td>
                        <td> <?= $val->umur; ?></td>
                        <td> <?= $val->berat; ?></td>
                        <td> <?= $val->tinggi; ?></td>
                        <td> <?= $val->status; ?></td>
                    </tr> 
                    <?php endforeach; ?> 
                    <?php endif; ?> 
                </tbody>
        
    </table>

        </div>
    </div>

    
</div>

<!-- Modal -->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addproduk">Add Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?php echo form_open('admin/testing'); ?>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select class="form-control" name="jk">
                        <option value="">--Piih--</option>
                        <option value="L">Laki - laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Umur</label>
                    <input type="text" name="umur" class="form-control">
                </div>
                <div class="form-group">
                    <label>Berat</label>
                    <input type="text" name="berat"class="form-control">
                </div>
                <div class="form-group">
                    <label>Tinggi</label>
                    <input type="text" name="tinggi"class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -- >     