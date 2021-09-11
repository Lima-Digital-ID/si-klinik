<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">UPDATE ABSENSI PEGAWAI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            <input type="hidden" class="form-control" name="id_absensi" id="id_absensi" placeholder="Id Jabatan" value="<?php echo $id_absensi; ?>" />
            <input type="hidden" class="form-control" name="id_pegawai" id="id_pegawai" placeholder="Id Jabatan" value="<?php echo $id_pegawai; ?>" />
                <table class='table table-bordered>'        
                       <tr><td width='200'>Nama Pegawai <?php echo form_error('nama_pegawai') ?></td><td><input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai"  value="<?php echo $nama_pegawai; ?>" readonly /></td></tr>
                       <tr><td width='200'>Tanggal <?php echo form_error('tanggal') ?></td><td><input type="date" class="form-control" name="tanggal" id="tanggal"  value="<?php echo $tanggal; ?>" readonly/></td></tr>
                       <tr><td width='200'>Jam Datang <?php echo form_error('jam_datang') ?></td><td><input type="time" class="form-control" name="jam_datang" id="jam_datang"  value="<?php echo $jam_datang; ?>" required/></td></tr>
                       <tr><td width='200'>Jam Pulang <?php echo form_error('jam_pulang') ?></td><td><input type="time" class="form-control" name="jam_pulang" id="jam_pulang"  value="<?php echo $jam_pulang; ?>" required/></td></tr>
                    <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo $_SERVER['HTTP_REFERER']?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>