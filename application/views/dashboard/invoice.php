<!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
</div>
        
<table class="table table-bordered table-hover table-striped">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Address</th>
        <th>Order Date</th>
        <th>Last Payment</th>
        <th>Invoice Status</th>
        <th>Action</th>
    </tr>
    
    <?php if($invoice){
        foreach ($invoice as $inv) : ?>
        <tr>
            <td><?= $inv->id_invoice ?></td>
            <td><?= $inv->nama ?></td>
            <td><?= $inv->alamat ?></td>
            <td><?= $inv->tgl_pesan ?></td>
            <td><?= $inv->batas_bayar ?></td>
            <td><span class="btn btn-sm <?= ($inv->status == 'unpaid') ? 'btn-danger' :  'btn-success' ?>"><?= strtoupper($inv->status) ?></span></td>
            <td><?= anchor('dashboard/detail/'.$inv->id_invoice, '<div class="btn btn-sm btn-primary">Detail</div>') ?>
			<?= ($inv->status == 'unpaid') ? anchor('dashboard/bayar/'.$inv->id_invoice, '<div class="btn btn-sm btn-primary">Bayar</div>') : '' ?></td>
        </tr>
        
    <?php endforeach; }?>
</table>

</div>
<!-- /.container-fluid -->
  </div>
<!-- End of Main Content -->