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
    <pre>
	<?php 
		echo $formula;
	?>
	</pre>
	<div class="row">
		<div class="col-md-4">
			<div class="card">
			<pre>
				<?= print_r($testing_1) ?>
			</pre>
			<?= $result_1 ?>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
			<pre>
				<?= print_r($testing_2) ?>
			</pre>
			<?= $result_2 ?>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->

<!-- /.container-fluid -->
</div>
<!-- End of Main Content -- >     