<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA MASTER REFERENCE</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">

                <table class='table table-bordered'>
                    <input type="hidden" name="id" value="<?php echo $id;?>" />
                    <tr><td width='200'>Master Ref Code <?php echo form_error('master_ref_code') ?></td><td><?php echo form_dropdown('master_ref_code', $master_ref_code_opt,$master_ref_code,array('id'=>'master_ref_code','class'=>'form-control','onchange'=>'show()'));?></td></tr>
                    <tr><td width='200'>Master Ref Value <?php echo form_error('master_ref_value') ?></td><td><input type="text" class="form-control" name="master_ref_value" id="master_ref_value" placeholder="Master Ref Value" value="<?php echo $master_ref_value; ?>" /></td></tr>
                    <tr><td width='200'>Master Ref Name <?php echo form_error('master_ref_name') ?></td><td><input type="text" class="form-control" name="master_ref_name" id="master_ref_value" placeholder="Master Ref Name" value="<?php echo $master_ref_name; ?>" /></td></tr>
                    <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('master_ref') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>