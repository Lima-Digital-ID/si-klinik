<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA TINDAKAN</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <table class='table table-bordered>'        
                        <tr><td width='200'>Kode Tindakan <?php echo form_error('kode_tindakan') ?></td><td><input type="text" class="form-control" name="kode_tindakan" id="kode_tindakan" placeholder="Kode Tindakan" value="<?php echo $kode_tindakan; ?>" 
                        <?php if(isset($kode_tindakan)) echo 'readonly'; else ''; ?> /></td></tr>
                        <tr><td width='200'>Tindakan <?php echo form_error('tindakan') ?></td><td><input type="text" class="form-control" name="tindakan" id="tindakan" placeholder="Tindakan" value="<?php echo $tindakan; ?>" /></td></tr>
                        <tr><td width='200'>Biaya <?php echo form_error('biaya') ?></td><td><input type="number" class="form-control" name="biaya" id="biaya" placeholder="Biaya" value="<?php echo $biaya; ?>" /></td></tr>
                        <tr><td width='200'>Tipe <?php echo form_error('tipe') ?></td><td>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="0">Pilih Tipe</option>
                                <option value="1" <?php if($tipe == 1) echo 'selected'; else echo ''; ?> >Umum</option>
                                <option value="2" <?php if($tipe == 2) echo 'selected'; else echo ''; ?> >Gigi</option>
                            </select>
                        </td></tr>
                        <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('tindakan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>