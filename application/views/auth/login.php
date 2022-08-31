<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card o-hidden border-0 shadow-lg my-5 ">
                <div class="card-body  card border-primary">
                    <!-- Nested Row within Card Body -->
                    <div class="row ">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <img style="width:200px" src="https://1.bp.blogspot.com/-vNcUzj8YRPo/YNaCWN7kmLI/AAAAAAAAFaE/Q0YIFTjsM-kDUxl8VXWNHN86WZtELt8MwCLcBGAsYHQ/s1600/Logo%2BPosyandu.png">
                                    
                                </div>

                                <?= $this->session->flashdata('message'); ?>

                                <form class="user" method="post" action="<?= site_url('auth'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <!-- <a href="<?= site_url("admin");?>" class="btn btn-primary btn-user btn-block">Login</a> -->
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <!-- <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Forgot Password?</a>
                                </div> -->
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/registration'); ?>">Create an Account!</a>
                                </div>
                                
                                <div class="text-center mt-2">
                                    <span class="mr-2"><i class="fa fa-user mr-1" aria-hidden="true"></i>Willyam</span>
                                    <span class="mr-2"><i class="fa fa-user mr-1" aria-hidden="true"></i>Rio</span> 
                                    <span><i class="fa fa-user mr-1" aria-hidden="true"></i>Windy</span>  <br/><br/>
                                    <span class="text-success mt-2">© Pengembangan Aplikasi Diagnosa Status Gizi<br/>Pada Balita dengan Implementasi C4.5   </span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 