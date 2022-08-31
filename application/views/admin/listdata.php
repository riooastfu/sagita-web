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
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Pasien</th>
            <th>Tanggal Pengecekan</th>
            <th>Usia</th>
            <th>TB</th>
			<th>BB</th>
			<th>Indeks Massa</th>
			<th>Status Gizi</th>
			<th>Action</th>
        </tr>
        <?php
        $no = 1;
        if(isset($riwayat)) {
            foreach ($riwayat as $b) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $b->nama_anak ?></td>
                    <td><?= $b->tanggal_check ?></td>
                    <td><?= $b->usia ?></td>
                    <td><?= $b->berat_badan ?></td>
					<td><?= $b->tinggi_badan ?></td>
					<td><?= $b->indeks_massa ?></td>
					<td><?= $b->status_gizi ?></td>
                    <td>
                        <?= anchor('admin/hapuscheck/' . $b->id.'/'.$b->id_anak, '<div class="btn btn-danger btn-sm mt-1"><i class="fa fa-trash"></i></div>') ?>
                    </td>
                </tr>
            <?php endforeach;
        }?>
    </table>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -- >     