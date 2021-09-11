<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA PEGAWAI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">

                <table class='table table-bordered>'        
                        <tr><td width='200'>ID Pegawai <?php echo form_error('id_pegawai') ?></td><td><input type="text" class="form-control" name="id_pegawai" id="id_pegawai" placeholder="ID Pegawai Auto Number" readonly="true" value="<?php echo $id_pegawai; ?>" /></td></tr>
                       <tr><td width='200'>Nama Pegawai <?php echo form_error('nama_pegawai') ?></td><td><input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" placeholder="Nama Pegawai" value="<?php echo $nama_pegawai; ?>" /></td></tr>
                    <tr><td width='200'>Shift <?php echo form_error('id_shift') ?></td><td>
                            <?php echo cmb_dinamis('id_shift', 'tbl_shift', 'nama_shift', 'id_shift', $id_shift) ?></td></tr>
                    <tr><td width='200'>Email <?php echo form_error('email') ?></td><td><input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" /></td></tr>
                    <tr><td width='200'>No Hp <?php echo form_error('no_hp') ?></td><td><input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No Hp" value="<?php echo $no_hp; ?>" /></td></tr>

                    <tr><td width='200'>Alamat Tinggal <?php echo form_error('alamat_tinggal') ?></td><td> <textarea class="form-control" rows="3" name="alamat_tinggal" id="alamat_tinggal" placeholder="Alamat Tinggal"><?php echo $alamat_tinggal; ?></textarea></td></tr>

                    <tr><td width='200'>Jabatan <?php echo form_error('id_jabatan') ?></td><td>
                            <?php echo cmb_dinamis('id_jabatan', 'tbl_jabatan', 'nama_jabatan', 'id_jabatan', $id_jabatan) ?>
                            <!--<input type="text" class="form-control" name="id_spesialis" id="id_spesialis" placeholder="Id Spesialis" value="<?php echo $id_spesialis; ?>" />--></td></tr>
                    <tr><td>Tanggal Mulai Tugas <?php echo form_error('tanggal_mulai_tugas') ?></td><td><div class="row"><div class="col-sm-4"><input type="date" class="form-control" name="tanggal_mulai_tugas" id="tanggal_mulai_tugas" placeholder="Tanggal Mulai Tugas" value="<?php echo $tanggal_mulai_tugas; ?>" /></div></div></td></tr>
                    <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('hrms/pegawai') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>