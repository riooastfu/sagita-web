<!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <table class="table table-bordered table-striped table-hover">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Jumlah</th>
            <th>Price</th>
            <th>Sub-Total</th>
        </tr>

        <?php $no=1;
        foreach($this->cart->contents() as $items) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $items['name'] ?></td>
                <td><?= $items['qty'] ?></td>
                <td align="right">Rp. <?= number_format($items['price'], 0,',','.')  ?></td>
                <td align="right">Rp. <?= number_format ($items['subtotal'], 0,',','.') ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" align="right">Grand Total</td>
            <td align="right">Rp. <?= number_format($this->cart->total(), 0,',','.')?></td>
        </tr>
    </table>

    <div align="right">
        <a href="<?= base_url('dashboard/delete_cart'); ?>"><div class="btn btn-sm btn-danger">Delete</div></a>

        <a href="<?= base_url('dashboard/index'); ?>"><div class="btn btn-sm btn-primary">Cancel</div></a>

        <a href="<?= base_url('dashboard/checkout'); ?>"><div class="btn btn-sm btn-success">Checkout</div></a>
    </div>






</div>
<!-- /.container-fluid -->
  </div>
<!-- End of Main Content -->