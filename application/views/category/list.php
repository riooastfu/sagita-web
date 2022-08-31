<!-- Begin Page Content -->
<div class="container-fluid">
<!-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?= base_url('assets/img/sliders/slider1.jpg');?>" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?= base_url('assets/img/sliders/slider2.jpg');?>" class="d-block w-100" alt="...">
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div> -->
<!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row text-center mt-4">
      <?php foreach($list_data as $f) : ?>
      

        <div class="card ml-3 mb-3" style="width: 16rem;">
          <img src="<?= base_url().'/assets/img/uploads/' .$f->gambar ?>" class="card-img-top">
          <div class="card-body">
            <h5 class="card-title"><?= $f->nama; ?></h5>
            
           
            <span class="badge badge-success mb-3">Rp. <?= number_format($f->harga, 0,',','.' )?></span>
            <br>
            <?php 
				if($this->session->userdata('role_id')==2){
					if($f->stok >0){
                    	echo anchor('dashboard/add_shopping/'.$f->id_produk, '<div class="btn btn-sm btn-primary">Add to shopping cart</div>'); 
                    }else{
                    	echo '<div class="btn btn-sm btn-primary" disabled>Sold Out</div>';
                    }
				}
                ?>
            <?= anchor('dashboard/detail_produk/'.$f->id_produk, '<div class="btn btn-sm btn-success">Detail</div>'); ?>
          </div>
        </div>

      <?php endforeach; ?>
    </div>

    </div>
<!-- /.container-fluid -->
  </div>
<!-- End of Main Content -->



