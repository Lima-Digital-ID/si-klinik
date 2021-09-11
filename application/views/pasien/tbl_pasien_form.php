<?php echo form_open('pasien/update_action', array('class' => 'form-horizontal', 'id' => 'form-create_pendaftaran')); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">FORM DATA PASIEN</h3>
                    </div>
    
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-2">No Rekam Medis <?php echo form_error('no_rekam_medis'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id'=>'no_rekam_medis','name'=>'no_rekam_medis','type'=>'text','value'=>$no_rekam_medis,'class'=>'form-control','readonly'=>'readonly'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">No ID <?php echo form_error('no_id'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id'=>'no_id','name'=>'no_id','type'=>'text','value'=>$no_id,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Nama Lengkap <?php echo form_error('nama_lengkap'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id'=>'nama_lengkap','name'=>'nama_lengkap','type'=>'text','value'=>$nama_lengkap,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Golongan Darah <?php echo form_error('golongan_darah'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_dropdown('golongan_darah', array(''=>'Pilih Golongan Darah','A'=>'A','B'=>'B','AB'=>'AB','O'=>'O'),$golongan_darah,array('id'=>'golongan_darah','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Status Menikah <?php echo form_error('status_menikah'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_dropdown('status_menikah', array(''=>'Pilih Status Menikah','Menikah'=>'Menikah','Belum Menikah'=>'Belum Menikah'),$status_menikah,array('id'=>'status_menikah','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Pekerjaan <?php echo form_error('pekerjaan'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id'=>'pekerjaan','name'=>'pekerjaan','type'=>'text','value'=>$pekerjaan,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Alamat <?php echo form_error('alamat'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_textarea(array('id'=>'alamat','name'=>'alamat','type'=>'textarea','value'=>$alamat,'rows'=>'2','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Kabupaten/Kota <?php echo form_error('kabupaten') ?></div>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id'=>'kabupaten','name'=>'kabupaten','type'=>'text','value'=>$kabupaten,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Kecamatan <?php echo form_error('kecamatan'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id'=>'kecamatan','name'=>'kecamatan','type'=>'text','value'=>$kecamatan,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Kelurahan/Desa <?php echo form_error('kelurahan'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id'=>'kelurahan','name'=>'kelurahan','type'=>'text','value'=>$kelurahan,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Nama Orang Tua / Istri <?php echo form_error('nama_orangtua_atau_istri'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id'=>'nama_orangtua_atau_istri','name'=>'nama_orangtua_atau_istri','type'=>'text','value'=>$nama_orangtua_atau_istri,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Nomor Telepon <?php echo form_error('nomor_telepon'); ?></div>
                            <div class="col-sm-10">
                                <?php echo form_input(array('id'=>'nomor_telepon','name'=>'nomor_telepon','type'=>'text','value'=>$nomor_telepon,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> Update</button>
                                <a href="<?php echo site_url('pasien') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                            </div>
                        </div>
            </div>   
                </div>
            </div>
        </div>
    </section>
</div>
<?php echo form_close();?>