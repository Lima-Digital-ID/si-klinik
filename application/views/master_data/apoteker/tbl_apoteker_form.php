<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA APOTEKER</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">

                <table class='table table-bordered>'        
                        <tr><td width='200'>ID Apoteker <?php echo form_error('id_apoteker') ?></td><td><input type="text" class="form-control" name="id_apoteker" id="id_apoteker" placeholder="ID Apoteker Auto Number" readonly="true" value="<?php echo $id_apoteker; ?>" /></td></tr>
                        <tr><td width='200'>Nama Apoteker <?php echo form_error('nama_apoteker') ?></td><td><input type="text" class="form-control" name="nama_apoteker" id="nama_apoteker" placeholder="Nama apoteker" value="<?php echo $nama_apoteker; ?>" /></td></tr>
                        <tr><td width='200'>Email <?php echo form_error('email') ?></td><td><input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" /></td></tr>
                        <tr><td width='200'>No HP/Telepon <?php echo form_error('telp') ?></td><td><input type="text" class="form-control" name="telp" id="telp" placeholder="No Hp/Telepon" value="<?php echo $telp; ?>" /></td></tr>
                        <tr><td width='200'>No SIK/SIPA <?php echo form_error('no_sik_sipa') ?></td><td><input type="text" class="form-control" name="no_sik_sipa" id="no_sik_sipa" placeholder="No SIK/SIPA" value="<?php echo $no_sik_sipa; ?>" /></td></tr>
                        <tr><td width='200'>No STRA <?php echo form_error('no_stra') ?></td><td><input type="text" class="form-control" name="no_stra" id="no_stra" placeholder="No STRA" value="<?php echo $no_stra; ?>" /></td></tr>
                        <tr><td width='200'>Alamat Tinggal <?php echo form_error('alamat') ?></td><td> <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat Tinggal"><?php echo $alamat; ?></textarea></td></tr>
                        <tr><td>Tanggal Mulai Tugas <?php echo form_error('tanggal_mulai_tugas') ?></td><td><div class="row"><div class="col-sm-4"><input type="date" class="form-control" name="tanggal_mulai_tugas" id="tanggal_mulai_tugas" placeholder="Tanggal Mulai Tugas" value="<?php echo $tanggal_mulai_tugas; ?>" /></div></div></td></tr>
                        <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('dokter') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>