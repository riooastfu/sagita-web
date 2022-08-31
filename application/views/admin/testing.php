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
	<?= $this->session->flashdata('message'); ?>
	
	<div class="row">
        <div class="col-lg-8">
        <?php echo form_open_multipart('admin/testing'); ?>

        <div class="form-group row">
		   <div class="col-sm-10">
           	<input type="file" class="form-control" id="file" name="file">
           </div>
        </div>
		<div class="form-group row">
			<div class="col-sm-10">
				<button type="submit" name="submit" class="btn btn-primary">Upload</button>
				<?php if($aktif > 0) { ?>
				<button type="submit" name="testing" class="btn btn-warning">Data Testing</button>
				<?php } ?>
			</div>
         </div>            
         <?php echo form_close(); ?>
		</div>
	</div>
	
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Umur</th>
            <th>Berat</th>
            <th>Jenis Kelamin</th>
            <th>Tinggi</th>
			<th>Status</th>
        </tr>
        <?php
        $no = 1;
        if(isset($training)) {
            foreach ($training as $b) : 		?>
                <!-- buat ressult_array pakenya kaya yang dibawah
                kalo result doang baru pake -> soalnya dia ngasilinya data object bukan data array
                -->
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $b['umur'] ?></td>
                    <td><?= $b['berat'] ?></td>
                    <td><?= $b['jk'] ?></td>
                    <td><?= $b['tinggi'] ?></td>
                    <td><?= $b['status'] ?></td>
                </tr>
            <?php endforeach;
        }?>
    </table>
</div>

<!-- Modal -->

<!-- /.container-fluid -->
</div>
<!-- End of Main Content -- >     