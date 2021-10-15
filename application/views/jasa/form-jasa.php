<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PERIKSA JASA</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered'>        

	    <tr><td width='200'>Jasa <?php echo form_error('item') ?></td><td><input type="text" class="form-control" name="item" id="item" placeholder="Jasa" value="<?php echo $item; ?>" /></td></tr>
	    <tr><td width='200'>Harga <?php echo form_error('harga') ?></td><td><input type="number" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_tipe" value="<?php echo $id_tipe; ?>" /></td></tr>
        <tr>
            <td>
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('jasa') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>