<style>
    .col-sm-2{
        font-weight: bold;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">Formulir Rapid Antigen Covid-19</h3>
                    </div>

                    <div class="box-body">
                        <div class="row col-md-12" style="margin-bottom: 10px">
                        <?php 
                            if($this->session->flashdata('success')){
                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-check-circle"></i> Success</h4>
                                <?= $this->session->flashdata('success') ?>
                            </div>                                
                        <?php
                            }
                        ?>
                        
                        <form action="" method="post">
                            <div class="form-group row">
                                <div class="col-sm-2">Nomor <?php echo $errorNomor.form_error('nomor'); ?></div>
                                <div class="col-sm-1" style="padding-right:0px">
                                    <input type="text" name="nomor" class="form-control" value="<?= isset($_POST['nomor']) ? $_POST['nomor'] :  $number ?>">
                                </div>
                                <div class="col-sm-9" style="padding-left:0px">
                                    <h4 style="margin-top:8px">&nbsp; /<?= $bln."/COVID-19/KR/".date('Y') ?></h4>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Nama <?php echo form_error('nama'); ?></div>
                                <div class="col-sm-10">
                                    <input type="text" name="nama" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Email <?php echo form_error('email'); ?></div>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">No Hp <?php echo form_error('no_hp'); ?></div>
                                <div class="col-sm-10">
                                    <input type="text" name="no_hp" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Nik / Passport <?php echo form_error('nik_or_passport'); ?></div>
                                <div class="col-sm-10">
                                    <input type="text" name="nik_or_passport" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Tanggal Lahir <?php echo form_error('tgl_lahir'); ?></div>
                                <div class="col-sm-10">
                                    <input type="date" name="tgl_lahir" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Jenis Kelamin <?php echo form_error('jenis_kelamin'); ?></div>
                                <div class="col-sm-10">
                                    <input type="radio" id="lk" name="jenis_kelamin" value="L">
                                    <label for="lk">Laki Laki</label>
                                    &nbsp;
                                    <input type="radio" id="pr" name="jenis_kelamin" value="P">
                                    <label for="pr">Perempuan</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Alamat Domisili <?php echo form_error('alamat_domisili'); ?></div>
                                <div class="col-sm-10">
                                    <textarea name="alamat_domisili" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Pekerjaan <?php echo form_error('pekerjaan'); ?></div>
                                <div class="col-sm-10">
                                    <input type="text" name="pekerjaan" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Alamat Tempat Bekerja <?php echo form_error('alamat_bekerja'); ?></div>
                                <div class="col-sm-10">
                                    <textarea name="alamat_bekerja" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Keluhan <?php echo form_error('keluhan'); ?></div>
                                <div class="col-sm-10">
                                    <textarea name="keluhan" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Penyakit Komorbid <?php echo form_error('komorbid'); ?></div>
                                <div class="col-sm-10">
                                    <textarea name="komorbid" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Alasan SWAB <?php echo form_error('alasan'); ?></div>
                                <div class="col-sm-10">
                                    <textarea name="alasan" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Riwayat Vaksin Covid-19</div>
                                <div class="col-sm-10">
                                    <input type="radio" class="riwayatVaksin" name="riwayat_vaksin" id="sudah" value="Sudah">
                                    <label for="sudah">Sudah</label>
                                    &nbsp;&nbsp;
                                    <input type="radio" class="riwayatVaksin" name="riwayat_vaksin" id="belum" value="Belum" checked>
                                    <label for="belum">Belum</label>
                                </div>
                            </div>
                            <div id="tanggalVaksin" style="display:none">
                                <div class="form-group row">
                                    <div class="col-sm-2">Tanggal Vaksin</div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Vaksin Ke-1 <?php echo form_error('tgl_vaksin_1'); ?></label>
                                                <input type="date" name="tgl_vaksin_1" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Vaksin Ke-2 <?php echo form_error('tgl_vaksin_2'); ?></label>
                                                <input type="date" name="tgl_vaksin_2" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Riwayat Kontak Dengan Pasien Covid-19</div>
                                <div class="col-sm-10">
                                    <input type="radio" class="riwayatKontak" name="riwayat_kontak" id="ya" value="Ya">
                                    <label for="ya">Ya</label>
                                    &nbsp;&nbsp;
                                    <input type="radio" class="riwayatKontak" name="riwayat_kontak" id="tidak" value="Tidak" checked>
                                    <label for="tidak">Tidak</label>
                                    <div id="kontakCovid" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">Tanggal Kontak <?php echo form_error('tgl_kontak'); ?></label>
                                                <input type="date" name="tgl_kontak" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Kontak Di <?php echo form_error('kontak_di'); ?></label>
                                                <input type="text" name="kontak_di" class="form-control">
                                            </div>
                                        </div>
                                        <br>

                                    </div>   
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">Riwayat SWAB/RAPID Sebelumnya <?php echo form_error('riwayat_swab_rapid_sebelumnya'); ?></div>
                                <div class="col-sm-10">
                                    <textarea name="riwayat_swab_rapid_sebelumnya" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-default" type="reset"><span class="fa fa-times"></span> Reset</button>
                                <button class="btn btn-success" type="submit"><span class="fa fa-save"></span> Simpan</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    const riwayatVaksin = document.querySelectorAll('.riwayatVaksin')
    const tanggalVaksin = document.getElementById('tanggalVaksin')

    const riwayatKontak = document.querySelectorAll('.riwayatKontak')
    const kontakCovid = document.getElementById('kontakCovid')

    for (let i = 0; i < riwayatVaksin.length; i++) {
        riwayatVaksin[i].addEventListener("change", function() {
            if(this.value==='Sudah'){
                tanggalVaksin.style.display = 'block'
            }
            else{
                tanggalVaksin.style.display = 'none'
            }
        });

        riwayatKontak[i].addEventListener("change", function() {
            if(this.value==='Ya'){
                kontakCovid.style.display = 'block'
            }
            else{
                kontakCovid.style.display = 'none'
            }
        });
     }
</script>