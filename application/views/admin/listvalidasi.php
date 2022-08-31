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
            <th>Nama Ibu</th>
            <th>Nama Anak</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Foto Akta Lahir</th>
            <th colspan="3">Action</th>
        </tr>
        <?php
        $no = 1;
        if(isset($pasien)) {
            foreach ($pasien as $b) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $b->nama_ibu ?></td>
                    <td><?= $b->nama_anak ?></td>
                    <td><?= $b->tgl_lahir ?></td>
                    <td><?= $b->jenis_kelamin ?></td>
                    <td><a href="<?= $b->akta_lahir ?>" target="_blank">Buka file</a></td>
                    <td><?= anchor('admin/valid/' . $b->id, '<div class="btn btn-gray btn-sm mt-1"><i class="fa fa-check"></i></div>') ?></td>
                </tr>
            <?php endforeach;
        }?>
    </table>
</div>

<!-- Modal -->

<!-- /.container-fluid -->
</div>
<!-- End of Main Content -- >     