<!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
<div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <form action="<?= base_url('menu/submenu_update'); ?>" method="post">
            <input type="hidden" name="id" value="<?= $sub_menu->sub_id ?>">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= $sub_menu->title ?>">
                    <?= form_error('title', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                        <label for="title">Menu</label>
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value="">Select Menu</option>
                            <?php foreach ($menu as $m) : ?>
                            <option <?php if($m['id'] == $sub_menu->menu_id){ echo "Selected"; } ?> value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <div class="form-group">
                    <label for="url">Url</label>
                    <input type="text" class="form-control" id="url" name="url" value="<?= $sub_menu->url ?>">
                    <?= form_error('url', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="icon">Icon</label>
                    <input type="text" class="form-control" id="icon" name="icon" value="<?= $sub_menu->icon ?>">
                    <?= form_error('icon', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="icon">Active</label>
                    <input type="checkbox" id="active" name="active"
                     <?php if($sub_menu->is_active == 1){ echo "Checked"; } ?> value="1">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Change</button>
                    <a href="<?= base_url('menu/submenu'); ?>"><div class="btn  btn-danger">Cancel</div></a>
                </div>
                
            </form>
        </div>

</div>
</div>
<!-- /.container-fluid -->
  </div>
<!-- End of Main Content -->