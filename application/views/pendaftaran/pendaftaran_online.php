<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/jquery-ui/themes/base/minified/jquery-ui.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css"> 
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <title>SIM <?php echo getInfoRS('nama_rumah_sakit') ?></title>
</head>
<body>
<!-- <div class=""> -->
  <!-- <section class=""> -->
    <div class="row">
      <div class="col-md-12">
            <?php 
            if($this->session->flashdata('message')){
                if($this->session->flashdata('message_type') == 'danger')
                    echo alert('alert-danger', 'Perhatian', $this->session->flashdata('message'));
                else if($this->session->flashdata('message_type') == 'success')
                    echo alert('alert-success', 'Sukses', $this->session->flashdata('message')); 
                else
                    echo alert('alert-info', 'Info', $this->session->flashdata('message')); 
            }
            ?>
      </div>
      <?php echo $script_captcha; ?>
      <!-- START:FORM INPUT -->
      <div class="col-md-12">
        <div class="box box-warning box-solid">
          <div class="box-header with-border">
            <h3 class="box-tittle">FORM PENDAFTARAN</h3>
          </div>
          <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-create_pendaftaran')); ?>

          <div class="box-body">
          <div class="form-group">
            <div class="col-sm-2">Nama Dokter <?php echo form_error('nama_dokter'); ?></div>
              <div class="col-sm-10">
                <select name="nama_dokter" id="nama_dokter" class="form-control select2 namaDokter">
                    <option value="">Pilih Dokter</option>
                      <?php 
                        foreach ($dokter as $key => $value) {
                          echo "<option data-tipe='".$value->tipe_dokter."' value='". $value->id_dokter."'>".$value->nama_dokter."</option>";
                        }
                      ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Nik <?php echo form_error('nik'); ?></div>
              <div class="col-sm-10">
                <?php 
                echo form_input(array('id'=>'nik','name'=>'nik','type'=>'text','value'=>$data['nik'],'class'=>'form-control', 'readonly'=>'true'));?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Nama Lengkap <?php echo form_error('nama_lengkap'); ?></div>
              <div class="col-sm-10">
                <?php 
                $inputNamaLengkap = array('id'=>'nama_lengkap','name'=>'nama_lengkap','type'=>'text','value'=>$data['nama_lengkap'],'class'=>'form-control');
                if($data['nama_lengkap']!='') {
                  $inputNamaLengkap['readonly'] = 'true';
                }
                echo form_input($inputNamaLengkap);
                ?>
              </div>
            </div>
            <div class="form-group">
							<div class="col-sm-2">Tanggal Lahir <?php echo form_error('tanggal_lahir'); ?></div>
							<div class="col-sm-10">
                <?php
                $inputTanggalLahir = array('id'=>'tanggal_lahir','name'=>'tanggal_lahir','type'=>'date','value'=>$data['tanggal_lahir'],'class'=>'form-control');
                if($data['tanggal_lahir']!=''){
                  $inputTanggalLahir['readonly'] = 'true';
                }
                echo form_input($inputTanggalLahir);
							  ?>
							</div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Golongan Darah <?php echo form_error('golongan_darah'); ?></div>
              <div class="col-sm-10">
                <?php
                $inputGolonganDarah = array(''=>'Pilih Golongan Darah','A'=>'A','B'=>'B','AB'=>'AB','O'=>'O',$golongan_darah,array('id'=>'golongan_darah','class'=>'form-control'));
                if($data['golongan_darah']!=''){
                  $inputGolonganDarah['readonly'] = 'true';
                }
                echo form_dropdown($inputGolonganDarah);
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Status Menikah <?php echo form_error('status_menikah'); ?></div>
              <div class="col-sm-10">
              <?php 
                $inputStatusMenikah = array(''=>'Pilih Status Menikah','Menikah' => 'Menikah','Belum Menikah'=>'Belum Menikah',$status_menikah,array('id'=>'status_menikah','value' =>$data['status_menikah'],'class'=>'form-control'));
                if($data['status_menikah']!='') {
                  $inputStatusMenikah['readonly'] = 'true';
                }
                echo form_input($inputStatusMenikah);
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Pekerjaan <?php echo form_error('pekerjaan'); ?></div>
              <div class="col-sm-10">
              <?php 
                $inputPekerjaan = array('id'=>'pekerjaan','name'=>'pekerjaan','type'=>'text','value'=>$data['pekerjaan'],'class'=>'form-control');
                if($data['pekerjaan']!='') {
                  $inputPekerjaan['readonly'] = 'true';
                }
                echo form_input($inputPekerjaan);
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Kabupaten/Kota <?php echo form_error('kabupaten') ?></div>
              <div class="col-sm-10">
              <?php 
                $inputKabupaten = array('id'=>'kabupaten','name'=>'kabupaten','type'=>'text','value'=>$data['kabupaten'],'class'=>'form-control');
                if($data['kabupaten']!='') {
                  $inputKabupaten['readonly'] = 'true';
                }
                echo form_input($inputKabupaten);
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Alamat <?php echo form_error('alamat'); ?></div>
              <div class="col-sm-10">
              <?php 
                $inputAlamat = array('id'=>'alamat','name'=>'alamat','type'=>'textarea','value'=>$data['alamat'],'class'=>'form-control');
                if($data['alamat']!='') {
                  $inputAlamat['readonly'] = 'true';
                }
                echo form_textarea($inputAlamat);
                ?>
                </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">RT <?php echo form_error('rt') ?></div>
              <div class="col-sm-10">
              <?php 
                $inputRT = array('id'=>'rt','name'=>'rt','type'=>'text','value'=>$data['rt'],'class'=>'form-control');
                if($data['rt']!='') {
                  $inputRT['readonly'] = 'true';
                }
                echo form_input($inputRT);
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">RW <?php echo form_error('rw') ?></div>
              <div class="col-sm-10">
              <?php 
                $inputRW = array('id'=>'rw','name'=>'rw','type'=>'text','value'=>$data['rw'],'class'=>'form-control');
                if($data['rw']!='') {
                  $inputRW['readonly'] = 'true';
                }
                echo form_input($inputRW);
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Nama Orang Tua / Istri <?php echo form_error('nama_orangtua_atau_istri'); ?></div>
              <div class="col-sm-10">
              <?php 
                $inputNamaOrangTuaAtauIstri = array('id'=>'nama_orang_tua_atau_istri','name'=>'nama_orang_tua_atau_istri','type'=>'text','value'=>$data['nama_orang_tua_atau_istri'],'class'=>'form-control');
                if($data['nama_orang_tua_atau_istri']!='') {
                  $inputNamaOrangTuaAtauIstri['readonly'] = 'true';
                }
                echo form_input($inputNamaOrangTuaAtauIstri);
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Nomor Telepon <?php echo form_error('nomor_telepon'); ?></div>
              <div class="col-sm-10">
              <?php 
                $inputNoTelepon = array('id'=>'nomer_telepon','name'=>'nomer_telepon','type'=>'text','value'=>$data['nomer_telepon'],'class'=>'form-control');
                if($data['nomer_telepon']!='') {
                  $inputNoTelepon['readonly'] = 'true';
                }
                echo form_input($inputNoTelepon);
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Tipe Pemeriksaan</div>
              <div class="col-sm-10">
                <select name="tipe_periksa" id="tipe_dokter_umum" class="form-control">
                  <option value="1">Periksa Medis</option>
                  <option value="2">Imunisasi Anak</option>
                  <option value="3">Kontrol Kehamilan</option>
                  <option value="5">Jasa Lainnya</option>
                  <option value="6">Pemeriksaan LAB</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div align="right">
                  <?php echo $captcha  ?>
                  <?php echo form_error($captcha); ?>
                  <br>
                  <a href=""<?php echo site_url('pendaftaran') ?>" class="btn btn-info"><i class="fa fa-sign-out">Kembali</i></a>
                  <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"> Simpan Pendaftaran</i></button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
      <!-- END:FORM INPUT -->
    <!-- </div> -->
  <!-- </section> -->
<!-- </div> -->

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>

</body>
</html>