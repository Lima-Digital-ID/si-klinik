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
      <!-- <?php echo $script_captcha; ?> -->
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
              <div class="col-sm-2">No RM</div>
              <div class="col-sm-10">
              <?php echo form_input(array('id'=>'no_rekam_medis','name'=>'no_rekam_medis','type'=>'text','value'=>rand(),'class'=>'form-control','readonly'=>'readonly'));?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">No ID</div>
              <div class="col-sm-10">
              <?php echo form_input(array('id'=>'no_id','name'=>'no_id','type'=>'text','value'=>rand(),'class'=>'form-control','onkeyup'=>'autocomplate_no_id()','readonly'=>'readonly'));?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Nik <?php echo form_error('nik'); ?></div>
              <div class="col-sm-10">
                <?php echo form_input(array('id'=>'nik','name'=>'nik','type'=>'text','value'=>$nik,'class'=>'form-control'));?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Nama Lengkap <?php echo form_error('nama_lengkap'); ?></div>
              <div class="col-sm-10">
                <?php echo form_input(array('id'=>'nama_lengkap','name'=>'nama_lengkap','type'=>'text','value'=>$nama_lengkap,'class'=>'form-control'));?>
              </div>
            </div>
            <div class="form-group">
							<div class="col-sm-2">Tanggal Lahir <?php echo form_error('tanggal_lahir'); ?></div>
							<div class="col-sm-10">
							    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?php echo $tanggal_lahir;?>" />
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
              <div class="col-sm-2">Kabupaten/Kota <?php echo form_error('kabupaten') ?></div>
              <div class="col-sm-10">
                <?php echo form_input(array('id'=>'kabupaten','name'=>'kabupaten','type'=>'text','value'=>$kabupaten,'class'=>'form-control'));?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">Alamat <?php echo form_error('alamat'); ?></div>
              <div class="col-sm-10">
                <?php echo form_textarea(array('id'=>'alamat','name'=>'alamat','type'=>'textarea','value'=>$alamat,'rows'=>'2','class'=>'form-control'));?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">RT <?php echo form_error('rt') ?></div>
              <div class="col-sm-10">
                <?php echo form_input(array('id'=>'rt','name'=>'rt','type'=>'text','value'=>$rt,'class'=>'form-control'));?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-2">RW <?php echo form_error('rw') ?></div>
              <div class="col-sm-10">
                <?php echo form_input(array('id'=>'rw','name'=>'rw','type'=>'text','value'=>$rw,'class'=>'form-control'));?>
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
              <div class="col-sm-2">Tipe Pemeriksaan</div>
              <div class="col-sm-10">
                <select name="tipe_periksa" id="tipe_dokter_umum" class="form-control">
                  <option value="1">Periksa Medis</option>
                  <option value="2">Imunisasi Anak</option>
                  <option value="3">Kontrol Kehamilan</option>
                  <option value="5">Jasa Lainnya</option>
                  <option value="6">Pemeriksaan LAB</option>
                </select>
                <select name="tipe_periksa" id="tipe_dokter_gigi" class="form-control" style="display:none" readonly>
                  <option value="4">Pemeriksaan Gigi</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div align="right">
                  <!-- <?php echo $captcha ?> -->
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