<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PABRIK</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">

                <table class='table table-bordered>'        
                        <tr><td width='200'>Kode Pabrik <?php echo form_error('kode_pabrik') ?></td><td><input type="text" class="form-control" name="kode_pabrik" id="kode_pabrik" placeholder="ID Pabrik Auto Number" readonly="true" value="<?php echo $kode_pabrik; ?>" /></td></tr>
                        <tr><td width='200'>Nama Pabrik <?php echo form_error('nama_pabrik') ?></td><td><input type="text" class="form-control" name="nama_pabrik" id="nama_pabrik" placeholder="Nama Pabrik" value="<?php echo $nama_pabrik; ?>" /></td></tr>
                        <tr><td width='200'>No Hp/Telp <?php echo form_error('telp') ?></td><td><input type="text" class="form-control" name="telp" id="telp" placeholder="No Hp" value="<?php echo $telp; ?>" /></td></tr>
                        <tr><td width='200'>Alamat Pabrik <?php echo form_error('alamat_pabrik') ?></td><td> <textarea class="form-control" rows="3" name="alamat_pabrik" id="alamat_pabrik" placeholder="Alamat Pabrik"><?php echo $alamat_pabrik; ?></textarea></td></tr>
                        <tr><td width='200'>Kota <?php echo form_error('kota') ?></td><td><input type="text" class="form-control" name="kota" id="kota" placeholder="Kota" value="<?php echo $kota; ?>" /></td></tr>
                        <tr><td width='200'>NPWP <?php echo form_error('npwp') ?></td><td><input type="text" class="form-control" name="npwp" id="npwp" placeholder="NPWP" value="<?php echo $npwp; ?>" /></td></tr>


                        <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('pabrik') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>