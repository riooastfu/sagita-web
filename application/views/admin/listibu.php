<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    </div>
<!--    <button class="btn btn-sm btn-primary mb-3 " data-toggle="modal" data-target="#addproduk"> Add Data Pasien</button>-->

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?= $this->session->flashdata('message'); ?>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Ibu</th>
            <th>Email Ibu</th>
            <th>Action</th>
        </tr>
        <?php
        $no = 1;
        if(isset($produk)) {
            foreach ($produk as $b) : ?>
                <!-- buat ressult_array pakenya kaya yang dibawah
                kalo result doang baru pake -> soalnya dia ngasilinya data object bukan data array
                -->
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $b->nama_ibu ?></td>
                    <td><?= $b->email ?></td>
                    <td>
                        <!--<?= anchor('admin/ibu/' . $b->id, '<div class="btn btn-warning btn-sm mt-1"><i class="fa fa-edit"></i></div>') ?>-->
						<?= anchor('admin/anak/' . $b->id, '<div class="btn btn-success btn-sm mt-1"><i class="fa fa-search"></i></div>') ?>
						<!--<?= anchor('admin/delete/' . $b->id, '<div class="btn btn-danger btn-sm mt-1"><i class="fa fa-trash"></i></div>') ?>-->
                    </td>
                </tr>
            <?php endforeach;
        }?>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="addproduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addproduk">Add Pasien</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <?php echo form_open('admin/submit'); ?>
                <div class="form-group">
                    <label>Nama Pasien</label>
                    <input type="text" name="nama_anak" id="nama_anak" class="form-control">
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select class="form-control" id="jeniskelamin" name="jeniskelamin">
                        <option value="">--Piih--</option>
                        <option value="L">Laki - laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Ibu Kandung</label>
                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
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