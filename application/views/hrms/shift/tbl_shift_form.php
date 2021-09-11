<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA SHIFT</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">

                <table class='table table-bordered>'        
                        <tr><td width='200'>ID SHIFT <?php echo form_error('id_SHIFT') ?></td><td><input type="text" class="form-control" name="id_shift" id="id_shift" placeholder="ID SHIFT Auto Number" readonly="true" value="<?php echo $id_shift; ?>" /></td></tr>
                       <tr><td width='200'>Nama SHIFT <?php echo form_error('nama_SHIFT') ?></td><td><input type="text" class="form-control" name="nama_shift" id="nama_shift" placeholder="Nama SHIFT" value="<?php echo $nama_shift; ?>" /></td></tr>
                        <tr><td width='200'>Jam Datang <?php echo form_error('jam_datang') ?></td><td><input type="time" class="form-control" name="jam_datang" id="jam_datang" placeholder="Jam Datang" value="<?php echo $jam_datang; ?>" /></td></tr>
                        <tr><td width='200'>Jam Pulang <?php echo form_error('jam_pulang') ?></td><td><input type="time" class="form-control" name="jam_pulang" id="jam_pulang" placeholder="Jam Pulang" value="<?php echo $jam_pulang; ?>" /></td></tr>
                        <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('hrms/shift') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>