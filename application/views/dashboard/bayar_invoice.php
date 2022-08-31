<!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>  
	<div class="row">
		<div class="col-md-6">
			<label>No. Invoice : </label> <?= $invoice->id_invoice ?>
		</div>
		<div class="col-md-6">
			<label>Tanggal Pesan : </label> <?= $invoice->tgl_pesan ?>
		</div>
		<div class="col-md-6">
			<label>Nama Pemesan : </label> <?= $invoice->nama ?>
		</div>
		<div class="col-md-6">
			<label>Alamat Pemesan : </label> <?= $invoice->alamat ?>
		</div>
		<div class="col-md-3">
			<label>Nama Bank : </label> <?= $invoice->nama_bank ?>
		</div>
		<div class="col-md-3">
			<label>Jasa Pengirim : </label> <?= $invoice->nama_jasa ?>
		</div>
		<div class="col-md-6">
			<label>Status : </label> <span class="btn btn-sm <?= ($invoice->status == 'unpaid') ? 'btn-danger' :  'btn-success' ?>"><?= strtoupper($invoice->status) ?></span>
		</div>
    </div>
	<br>
	<table class="table table-bordered table-hover table-striped">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Sub-Total</th>
        </tr>
        <?php $total = 0;
        if($pesanan){
            foreach ($pesanan as $psn) :
            $subtotal = $psn->jumlah * $psn->harga;
            $total += $subtotal;

        ?>
        <tr>
            <td><?= $psn->id_produk ?></td>
            <td><?= $psn->nama ?></td>
            <td><?= $psn->jumlah ?></td>
            <td class="text-right" ><?= number_format($psn->harga,0,',','.')?></td>
            <td class="text-right" ><?= number_format($subtotal,0,',','.') ?></td>
        </tr>

        <?php endforeach; } ?>

        <tr>
            <td colspan="4" align="right">Grand Total</td>
            <td align="right">Rp. <?= number_format($total,0,',','.') ?></td>
        </tr>
    </table>
	
	<div class="row">
		<div class="col-lg-8">        
		<?= $this->session->flashdata('message'); ?>
		<form method="post" action="<?= ('../payment');?>">
			<div class="form-group row">
			<label for="nama" class="col-sm-3 col-form-label">No. Rekening</label>
			<div class="col-sm-6">
				<input type="hidden" id="id_invoice" name="id_invoice" value="<?= $invoice->id_invoice ?>">
				<input type="hidden" id="total_belanja" name="total_belanja" value="<?= $invoice->total_belanja ?>">
				<input type="text" class="form-control" id="no_rekening" name="no_rekening" class="form-control" maxlength="20" required>
			</div>
			</div>

			<div class="form-group row">
			<label for="alamat" class="col-sm-3 col-form-label">Nama Pemilik</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik"  class="form-control" maxlength="100" required>
			</div>
			</div>

			<div class="form-group row">
			<label for="telp" class="col-sm-3 col-form-label">Jumlah Transfer</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="jumlah_transfer" name="jumlah_transfer"  class="form-control" maxlength="10" required>
			</div>
			</div>
			
			<div class="form-group row">
			<label for="telp" class="col-sm-3 col-form-label">Bukti Transfer</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="bukti_transfer" name="bukti_transfer" class="form-control" maxlength="100">
			</div>
			</div>
			
			<div class="form-group row">
			<label for="telp" class="col-sm-3 col-form-label">Tanggal Bayar</label>
			<div class="col-sm-6">
				<input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar" class="form-control" required>
			</div>
			</div>

			<div class="form-group row justify-content-end">
			<div class="col-sm-9">
				<button type="submit" id="payment" class="btn btn-primary">Payment</button>
				<a href="<?= base_url('dashboard/invoice'); ?>"><div class="btn btn-danger">Cancel</div></a>
			</div>
			</div>              
		</form>    
		</div>
	</div>
</div>
<!-- /.container-fluid -->
  </div>
<!-- End of Main Content -->
<script language="javascript">
	$("#jumlah_transfer").on('change', function(){
		if ($("#jumlah_transfer").val() > 0 && ($("#jumlah_transfer").val() != $('#total_belanja').val())) {	
			alert('Jumlah transfer tidak sesuai dengan total belanja');
			$("#payment").attr('disabled', true);
		}else{
			$("#payment").attr('disabled', false);			
		}
	});
	
</script>