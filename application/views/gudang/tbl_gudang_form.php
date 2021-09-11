<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA GUDANG</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">

                <table class='table table-bordered>'        
                        <tr><td width='200'>Kode Gudang <?php echo form_error('kode_gudang') ?></td><td><input type="text" class="form-control" name="kode_gudang" id="kode_gudang" placeholder="ID Gudang Auto Number" readonly="true" value="<?php echo $kode_gudang; ?>" /></td></tr>
                        <tr><td width='200'>Nama Gudang <?php echo form_error('nama_gudang') ?></td><td><input type="text" class="form-control" name="nama_gudang" id="nama_gudang" placeholder="Nama gudang" value="<?php echo $nama_gudang; ?>" /></td></tr>
                        <tr><td width='200'>No Hp/Telp <?php echo form_error('telp') ?></td><td><input type="text" class="form-control" name="telp" id="telp" placeholder="No Hp" value="<?php echo $telp; ?>" /></td></tr>
                        <tr><td width='200'>Alamat Gudang <?php echo form_error('alamat_gudang') ?></td><td> <textarea class="form-control" rows="3" name="alamat_gudang" id="alamat_gudang" placeholder="Alamat gudang"><?php echo $alamat_gudang; ?></textarea></td></tr>
                        <tr><td width='200'>Kota <?php echo form_error('kota') ?></td><td><input type="text" class="form-control" name="kota" id="kota" placeholder="Kota" value="<?php echo $kota; ?>" /></td></tr>


                        <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('gudang') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>