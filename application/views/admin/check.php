<input type="hidden" id="base_url" value="<?= base_url(); ?>">
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<div class="row">
		<div class="col-lg-8">
		<?php echo form_open(''); ?>
			<div class="form-group">
				<input type="text" name="keyword" id="keyword" class="form-control col-sm-8" value="">
				<div class="col-sm-8">
					<button class="btn btn-sm btn-primary" type="submit" name="cari"> Cari Pasien</button>
				</div>
			</div>
		<?php echo form_close(); ?>
		</div>
	</div>
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->		
		<?php 
			if($pasien) {
			foreach($pasien as $i=>$a) { 			
		?>
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2"  data-toggle="modal" data-target="#myModal-<?= $i ?>">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= $a->nama_anak ?></div>
                        	<div class="text-xs text-primary mb-1">
								<?= date_format(date_create($a->tgl_lahir),'Y-m-d') ?><br>
								<?= $a->nama_ibu ?>
							</div>
						</div>
						<div class="col-auto">
							<?php if($a->validasi_anak == 1) { ?>
								<a href="<?php echo base_url('admin/gizi?id='.$a->id) ?>"><i class="fas fa-check-circle fa-2x text-success"></i></a>
							<?php } else { ?>
								<i class="fas fa-times-circle fa-2x text-disabled"></i>
							<?php } ?>
								<a href="<?php echo base_url('admin/listpengecekan/'.$a->id) ?>"><i class="fas fa-search fa-2x text-info"></i></a>
                        </div>
                    </div>
                </div>
				<div class="modal" id="myModal-<?= $i ?>">
					  <div class="modal-dialog modal-lg">
						<div class="modal-content">

						  <!-- Modal Header -->
						  <div class="modal-header">
							<h4 class="modal-title font-weight-bold text-primary text-uppercase"><?= $a->nama_anak ?></h4>
							<button type="button" class="close" data-dismiss="modal">×</button>
						  </div>
						  <!-- Modal body -->
						  <div class="modal-body">
						  	<div class="row">
								<div class="col-lg-8">
									<div class="form-group row">
									   <div class="col-sm-10">
										Email : <?= $a->email ?><br>
										Nama Ibu : <?= $a->nama_ibu ?><br>
										Nama Anak : <?= $a->nama_anak ?><br>
										Jenis Kelamin : <?= $a->jenis_kelamin ?>
									   </div>										
									</div>
								</div>
								<!--<div class="col-lg-12">
									<table class="table table-bordered">
										<tr>
											<th>No</th>
											<th>Tanggal Pengecekan</th>
											<th>Berat Badan</th>
											<th>Tinggi</th>
											<th>Umur</th>
											<th>IMT</th>
											<th>Status</th>
										</tr>
									</table>
								</div>-->
							</div>
						  </div>
						  <!-- Modal footer -->
						  <div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						  </div>

						</div>
					  </div>
					</div>
				
				<div class="modal" id="editModal-<?= $i ?>">
				  <div class="modal-dialog modal-lg">
					<div class="modal-content">
					  <!-- Modal Header -->
					  <div class="modal-header">
						<h4 class="modal-title font-weight-bold text-primary text-uppercase"><?= $a->nama_anak ?></h4>
						<button type="button" class="close" data-dismiss="modal">×</button>
					  </div>
					  <!-- Modal body -->
					  <div class="modal-body">
						<div class="row">								
							<div class="col-lg-8">
							<?php echo form_open('admin/updategizi'); ?>
								<div class="form-group row">
									<label for="judul" class="col-sm-4 col-form-label">Nama Pasien</label>
									<div class="col-sm-8">
										<label class="col-form-label"><?= $a->nama_anak ?></label>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Nama Ibu Kandung</label>
									<div class="col-sm-8">
										<label class="col-form-label"><?= $a->nama_ibu ?></label>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Tanggal Lahir</label>
									<div class="col-sm-8">
										<label class="col-form-label"><?= date_format(date_create($a->tgl_lahir),'Y-m-d') ?></label>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Berat Badan (kg)</label>
									<div class="col-sm-8">
										<input type="number" name="berat" id="berat" class="form-control" value="<?= $berat ?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Tinggi Badan (cm)</label><br>
									<div class="col-sm-8">
										<input type="number" name="tinggi" id="tinggi" class="form-control" value="<?= $tinggi ?>">
									</div>
								</div>            
								<div class="form-group row">
									<label for="judul" class="col-sm-4 col-form-label">Tanggal Pengecekan</label>
									<div class="col-sm-8">
										<input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
									</div>
								</div>
								<?php
									$date_past = new DateTime($a->tgl_lahir);
									$date_now = new DateTime('now');
									$date_diff = $date_past->diff($date_now);
									$yearsInMonths = $date_diff->format('%r%y') * 12;
									$months = $date_diff->format('%r%m');
									$totalMonths = $yearsInMonths + $months;
									// $imt = (isset($pasien->berat_badan)) ? pow(($pasien->berat_badan/$pasien->tinggi_badan)*$pasien->berat_badan, 2) : 0;
								?>
								<input type="hidden" name="pasien_id" id="pasien_id" value="<?= $a->id ?>">
								<input type="hidden" name="nama_anak" id="nama_anak" value="<?= $a->nama_anak ?>">
								<input type="hidden" name="jk" id="jk" value="<?= $a->jenis_kelamin ?>">
								<div class="form-group row">
									<label for="judul" class="col-sm-4 col-form-label">Usia Saat Pengecekan (bl)</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" readonly id="usia" name="usia" placeholder="Usia saat pengecekan" value="<?= $totalMonths ?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Indeks Massa Tubuh (IMT)</label>
									<div class="col-sm-8">
										<input type="text" name="imt" id="imt" readonly class="form-control" value="<?= round($imt,2) ?>" placeholder="IMT">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Status</label>
									<div class="col-sm-8">
										<input type="text" name="status_gizi" readonly id="status_gizi" class="form-control" value="<?= $status ?>" placeholder="Status Gizi">
									</div>
								</div>
								<div class="form-group row justify-content-end">
									<div class="col-sm-8">
										<button type="submit" class="btn btn-primary" name="hitung">Hitung</button>
										<button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
									</div>
								</div>
								<?php echo form_close(); ?>
							 </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
            </div>
        </div>
		<?php } 
			} ?>
    </div>
    <!-- Content Row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

