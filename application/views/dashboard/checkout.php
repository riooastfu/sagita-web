<!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
<div class="row">
        <div class="col-lg-8">
        
        <?= $this->session->flashdata('message'); ?>
            <form method="post" action="<?= ('proses');?>">
            <div class="btn btn-sm btn-success form-group row">
                <?php $grand_total = 0;
                if($keranjang = $this->cart->contents()){
                foreach ($keranjang as $item){
                	$grand_total = $grand_total + $item['subtotal'];
                }
                
                    echo"Total Order : Rp. ".number_format($grand_total,0,',','.');
                
                ?>
            </div>
                   
            <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama" name="nama" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="alamat" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="alamat" name="alamat"  class="form-control">
                </div>
            </div>

             <div class="form-group row">
                <label for="telp" class="col-sm-2 col-form-label">No.Telp</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="telp" name="telp"  class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="jasa" class="col-sm-2 col-form-label">Delivery Service</label>
                <div class="col-sm-10">
                <select class="form-control" name="jasa">
                    <option value="JNE">JNE</option>
                    <option value="INDOMARET">INDOMARET</option>
                     <option value="ALFAMART">ALFAMART</option>
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="bank" class="col-sm-2 col-form-label">Choice Bank</label>
                <div class="col-sm-10">
                <select class="form-control" name="bank">
                    <option value="BRI">BRI</option>
                    <option value="MANDIRI">MANDIRI</option>
                     <option value="BCA">BCA</option>
                </select>
                </div>
            </div>

            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Order</button>
                    <?= anchor('dashboard/detail_cart/','<div class="btn btn-danger">Cancel</div>'); ?>
                </div>
            </div>              
   </form>
   

   <?php
    }else {        
        echo "Your cart is empty";      
    }
    ?> 
</div>
</div>
</div>
<!-- /.container-fluid -->
  </div>
<!-- End of Main Content -->