<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
       <?= $this->session->flashdata('message');?>
        <?php echo form_open('admin/update'); ?>

        <div class="form-group row">
                <label for="id_produk" class="col-sm-3 col-form-label">Pasien ID</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="id_pasien" name="id_pasien" value="<?= $id ?>" readonly>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="id_kategori" class="col-sm-3 col-form-label">Category Id</label>
                <div class="col-sm-9">
					<select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
					<option value="">--Piih Kategori--</option>
                    <option value="L" <?php if($pasien[0]->jenis_kelamin == 'L') echo 'selected' ?> >Laki - laki</option>
                    <option value="P" <?php if($pasien[0]->jenis_kelamin == 'P') echo 'selected' ?> >Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="judul" class="col-sm-3 col-form-label">Nama Pasien</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_anak" name="nama_anak" value="<?= $pasien[0]->nama_anak ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama Ibu Kandung</label>
                <div class="col-sm-9">
                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="<?= $pasien[0]->nama_ibu ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-9">
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?= date_format(date_create($pasien[0]->tgl_lahir),'Y-m-d') ?>">
                </div>
            </div>
            <div class="form-group row justify-content-end">
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= base_url('admin/listpasien'); ?>"><div class="btn  btn-danger">Cancel</div></a>

                </div>
            </div>
            
            <?php echo form_close(); ?>
         </div>
    </div>
</div>
<!-- /.container-fluid -->