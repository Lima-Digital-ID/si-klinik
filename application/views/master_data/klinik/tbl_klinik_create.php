<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA KLINIK</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            <input type="hidden" class="form-control" name="id_klinik" id="id_klinik" placeholder="id Klinik" value="<?php echo $id_klinik; ?>" />
                <table class='table table-bordered>'        
                       <tr><td width='200'>Nama Klinik <?php echo form_error('nama_klinik') ?></td><td><input type="text" class="form-control" name="nama_klinik" id="nama_klinik" placeholder="Nama Klinik" value="<?php echo $nama_klinik; ?>" /></td></tr>
                    <tr><td width='200'>Alamat Klinik <?php echo form_error('alamat_klinik') ?></td><td> <textarea class="form-control" rows="3" name="alamat_klinik" id="alamat_klinik" placeholder="Alamat Klinik"><?php echo $alamat_klinik; ?></textarea></td></tr>
                    <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('klinik') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>