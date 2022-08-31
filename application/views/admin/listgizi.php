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
	
    <div class="row">
        <div class="col-lg-8">
       	<?= $this->session->flashdata('message');?>
        <?php echo form_open('admin/updategizi'); ?>
            <?php if($pasien) { ?>
                <div class="form-group row">
                    <label for="judul" class="col-sm-4 col-form-label">Nama Pasien</label>
                    <div class="col-sm-8">
                        <label class="col-form-label"><?= $pasien->nama_anak ?></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Ibu Kandung</label>
                    <div class="col-sm-8">
                        <label class="col-form-label"><?= $pasien->nama_ibu ?></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-8">
                        <label class="col-form-label"><?= $pasien->tgl_lahir ?></label>
                    </div>
                </div>
            <?php } ?>
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
            <?php if($pasien) {
                $date_past = new DateTime($pasien->tgl_lahir);
                $date_now = new DateTime('now');
                $date_diff = $date_past->diff($date_now);
				$yearsInMonths = $date_diff->format('%r%y') * 12;
				$months = $date_diff->format('%r%m');
				$totalMonths = $yearsInMonths + $months;
                // $imt = (isset($pasien->berat_badan)) ? pow(($pasien->berat_badan/$pasien->tinggi_badan)*$pasien->berat_badan, 2) : 0;
            ?>
            <input type="hidden" name="pasien_id" id="pasien_id" value="<?= $pasien->id ?>">
            <input type="hidden" name="nama_anak" id="nama_anak" value="<?= $pasien->nama_anak ?>">
            <input type="hidden" name="jk" id="jk" value="<?= $pasien->jenis_kelamin ?>">
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
            <?php } ?>
            
            <?php echo form_close(); ?>
         </div>
    </div>
</div>

<!-- Modal -->

<!-- /.container-fluid -->
</div>
<!-- End of Main Content -- >     