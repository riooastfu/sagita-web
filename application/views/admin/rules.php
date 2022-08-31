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

    
    <div class="row">
        <?php // echo json_encode($rules[0]->fitur);?>
        <div class="col-md-12">
            <div class="tf-tree example" style="overflow-y: scroll; height:500px; font-size:10px;">
                <ul>
                    <li>
                        <span class="tf-nc"><?= $rules[0]->fitur; ?></span>
                        <ul>
                        <?php foreach ($rules as $k => $v): ?>
                            <li>
                                <span class="tf-nc"><?= $v->logika; ?></span>
                                <ul>
                                <?php $data   = $this->db->order_by("feature_idx","DESC")->where(["parents"=>$v->id])->get("rules")->result(); foreach ($data as $key => $val): $obj = "obj[".$val->feature_idx."]"; $logika = str_replace($obj,$val->feature_name,$val->rule);?>
                                <li>
                                    <span class="tf-nc"><?= $logika; ?></span>
                                    <ul>
                                        <?php $data2   = $this->db->order_by("feature_idx","DESC")->where(["parents"=>$val->leaf_id])->get("rules")->result(); foreach ($data2 as $key2 => $val2):$obj = "obj[".$val2->feature_idx."]";$logika = str_replace($obj,$val2->feature_name,$val2->rule);?>
                                        <li>
                                            <span class="tf-nc"><?= $logika; ?></span>
                                            <ul>
                                            <?php $data3   = $this->db->order_by("feature_idx","DESC")->where(["parents"=>$val2->leaf_id])->get("rules")->result(); foreach ($data3 as $key => $val3):$obj = "obj[".$val3->feature_idx."]";$logika = str_replace($obj,$val3->feature_name,$val3->rule);?>
                                            <li>
                                                <span class="tf-nc"><?= $logika; ?></span>
                                                <ul>
                                                <?php $data4   = $this->db->order_by("feature_idx","DESC")->where(["parents"=>$val3->leaf_id])->get("rules")->result(); foreach ($data4 as $key => $val4):$obj = "obj[".$val4->feature_idx."]";$logika = str_replace($obj,$val4->feature_name,$val4->rule);?>
                                                <li>
                                                    <span class="tf-nc"><?= $logika; ?></span>
                                                    <ul>
                                                    <?php $data5   = $this->db->order_by("feature_idx","DESC")->where(["parents"=>$val4->leaf_id])->get("rules")->result(); foreach ($data5 as $key => $val5):$obj = "obj[".$val5->feature_idx."]";$logika = str_replace($obj,$val5->feature_name,$val5->rule);?>
                                                        <li>
                                                            <span class="tf-nc"><?= $logika; ?></span>
                                                        </li>
                                                        <?php endforeach;?>
                                                    </ul>
                                                </li>
                                                <?php endforeach;?>
                                                </ul>
                                            </li>
                                            <?php endforeach;?>
                                            </ul>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </li>
                                <?php endforeach;?>
                                </ul>
                            </li>
                        <?php endforeach;?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>


	<div class="row">
		<div class="col-md-8">
			<div class="card">
			<?php
            foreach ($rules as $k => $v): ?>
            <table class="table table-stripped">
            <tr>
                <td class="pt-0 mt-0 mb-0 pb-0">
                    <span class="badge badge-danger"><?= $v->logika; ?></span>
                    <table class="table table-stripped ml-2">
                        <?php $data   = $this->db->order_by("feature_idx","DESC")->where(["parents"=>$v->id])->get("rules")->result(); 
                        foreach ($data as $key => $val):
                        $obj = "obj[".$val->feature_idx."]";
                        $logika = str_replace($obj,$val->feature_name,$val->rule);
                        ?>
                        <tr>
                            <td class="pt-0 mt-0 mb-0 pb-0">
                                <span class="badge badge-primary"><?= $logika; ?></span>
                                <table class="table table-stripped ml-2">
                                    <?php $data2   = $this->db->order_by("feature_idx","DESC")->where(["parents"=>$val->leaf_id])->get("rules")->result(); 
                                    foreach ($data2 as $key2 => $val2):
                                    $obj = "obj[".$val2->feature_idx."]";
                                    $logika = str_replace($obj,$val2->feature_name,$val2->rule);
                                    ?>
                                    <tr>
                                        <td class="pt-0 mt-0 mb-0 pb-0">
                                            <span class="badge badge-warning"><?= $logika; ?></span>
                                            <table class="table table-stripped ml-2">
                                                <?php $data3   = $this->db->order_by("feature_idx","DESC")->where(["parents"=>$val2->leaf_id])->get("rules")->result(); 
                                                foreach ($data3 as $key => $val3):
                                                $obj = "obj[".$val3->feature_idx."]";
                                                $logika = str_replace($obj,$val3->feature_name,$val3->rule);
                                                ?>
                                                <tr>
                                                  <td class="pt-0 mt-0 mb-0 pb-0">
                                                    <span class="badge badge-success"><?= $logika; ?></span>
                                                        <table class="table table-stripped ml-2">
                                                            <?php $data4   = $this->db->order_by("feature_idx","DESC")->where(["parents"=>$val3->leaf_id])->get("rules")->result(); 
                                                            foreach ($data4 as $key => $val4):
                                                            $obj = "obj[".$val4->feature_idx."]";
                                                            $logika = str_replace($obj,$val4->feature_name,$val4->rule);
                                                            ?>
                                                            <tr>
                                                                <td class="pt-0 mt-0 mb-0 pb-0">
                                                                <span class="badge badge-info"><?= $logika; ?></span>
                                                                    <table class="table table-stripped ml-2">
                                                                        <?php $data5   = $this->db->order_by("feature_idx","DESC")->where(["parents"=>$val4->leaf_id])->get("rules")->result(); 
                                                                        foreach ($data5 as $key => $val5):
                                                                        $obj = "obj[".$val5->feature_idx."]";
                                                                        $logika = str_replace($obj,$val5->feature_name,$val5->rule);
                                                                        ?>
                                                                        <tr>
                                                                            <td class="pt-0 mt-0 mb-0 pb-0">
                                                                                <span class="badge badge-default"><?= $logika; ?></span>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach;
                                                                        ?>

                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach;?>

                                                        </table>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>

                                            </table>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>

                                </table>
                            </td>
                        </tr>
                        <?php endforeach;?>

                    </table>
                </td>
            </tr>
            </table>
            <?php endforeach;?>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->

<!-- /.container-fluid -->
</div>
<!-- End of Main Content -- >     