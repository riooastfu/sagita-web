<!-- Sidebar -->
<ul class="navbar-nav navbar-fixed bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  
  <!-- Sidebar - Brand --> 
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#" >
  <div class="sidebar-brand-icon "> <i class="fas fa-hospital"></i> </div>
  <div class="sidebar-brand-text mx-3">Patient Management</div>
  </a> 
  <!-- Divider -->
  <hr class="sidebar-divider">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item <?php if($this->uri->segment(2)=="dashboard") { echo "active"; } ?>"> <a class="nav-link" href="<?php echo base_url('mining/dashboard') ?>" > <i class="fas fa-fw fa-tachometer-alt"></i> <span>Dashboard</span></a> </li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  
  <!-- Heading -->
	<div class="sidebar-heading"> Activity </div>
	  <!--<li class="nav-item  <?php if($this->uri->segment(2)=="gizi"){echo "active";}?>"> <a class="nav-link" href="<?php echo base_url('admin/gizi') ?>"> <i class="fas fa-fw fa-table"></i> <span>Pengecekan Gizi</span></a> </li>-->
	<li class="nav-item  <?php if($this->uri->segment(2)=="validasi"){echo "active";}?>"> <a class="nav-link" href="<?php echo base_url('admin/validasi') ?>"> <i class="fas fa-fw fa-table"></i> <span>Validasi Data</span></a> </li>
	<hr class="sidebar-divider">

  <div class="sidebar-heading"> Input Data </div>
  <li class="nav-item  <?php if($this->uri->segment(2)=="listpasien"){echo "active";}?>"> <a class="nav-link" href="<?php echo base_url('admin/listpasien') ?>"> <i class="fas fa-fw fa-table"></i> <span>List Data Ibu</span></a> </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading"> Klasifikasi C4.5 </div>
  
  <!-- Nav Item - Tables -->
  <li class="nav-item  <?php if($this->uri->segment(1)=="mining"){echo "active";}?>"> <a class="nav-link" href="<?php echo base_url('admin/training') ?>"> <i class="fas fa-fw fa-table"></i> <span>Data Training</span></a> </li>
  <li class="nav-item  <?php if($this->uri->segment(2)=="testing"){echo "active";}?>"> <a class="nav-link" href="<?php echo base_url('admin/testing') ?>"> <i class="fas fa-fw fa-table"></i> <span>Data Testing</span></a> </li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  <li class="nav-item"> <a class="nav-link" href="<?= base_url('admin/aboutus'); ?>"> <i  class="fas fa-fw fa-info"></i> <span>Tentang Kami</span></a> </li>
  <li class="nav-item"> <a class="nav-link" href="<?= base_url('auth/logout'); ?>"> <i  class="fas fa-fw fa-sign-out-alt"></i> <span>Logout</span></a> </li>
  
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>
<!-- End of Sidebar --> 

