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
    <a href="<?= base_url('dashboard/invoice'); ?>"><div class="btn btn-sm btn-primary">Back</div></a>






</div>
<!-- /.container-fluid -->
  </div>
<!-- End of Main Content -->