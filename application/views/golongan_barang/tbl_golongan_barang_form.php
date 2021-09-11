<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA GOLONGAN BARANG</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama Golongan <?php echo form_error('nama_golongan_barang') ?></td><td><input type="text" class="form-control" name="nama_golongan_barang" id="nama_golongan_barang" placeholder="Nama Golongan" value="<?php echo $nama_golongan_barang; ?>" /></td></tr>
        <tr><td width='200'>Keterangan <?php echo form_error('keterangan') ?></td><td><textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_golongan_barang" value="<?php echo $id_golongan_barang; ?>" /> 
	    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('golonganbarang') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>