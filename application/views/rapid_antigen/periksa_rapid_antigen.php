<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">Pemeriksaan Rapid Antigen</h3>
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
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td><b>No Sampel</b></td>
                                    <td>:</td>
                                    <td><?= $detail->no_sampel ?></td>
                                    <td><b>Nama</b></td>
                                    <td>:</td>
                                    <td><?= $detail->nama ?></td>
                                </tr>
                                <tr>
                                    <td><b>NIK / Passport</b></td>
                                    <td>:</td>
                                    <td><?= $detail->nik_or_passport ?></td>
                                    <td><b>No HP</b></td>
                                    <td>:</td>
                                    <td><?= $detail->no_hp ?></td>
                                </tr>
                                <tr>
                                    <td><b>Tanggal Lahir</b></td>
                                    <td>:</td>
                                    <td><?= $detail->tgl_lahir ?></td>
                                    <td><b>Jenis Kelamin</b></td>
                                    <td>:</td>
                                    <td><?= $detail->jenis_kelamin ?></td>
                                </tr>
                                <tr>
                                    <td><b>Email</b></td>
                                    <td>:</td>
                                    <td><?= $detail->email ?></td>
                                    <td><b>No HP</b></td>
                                    <td>:</td>
                                    <td><?= $detail->no_hp ?></td>
                                </tr>
                                <tr>
                                    <td><b>Alamat Domisili</b></td>
                                    <td>:</td>
                                    <td><?= $detail->alamat_domisili ?></td>
                                    <td><b>Pekerjaan</b></td>
                                    <td>:</td>
                                    <td><?= $detail->pekerjaan ?></td>
                                </tr>
                                <tr>
                                    <td><b>Alamat Tempat Bekerja</b></td>
                                    <td>:</td>
                                    <td colspan="3"><?= $detail->alamat_bekerja ?></td>
                                </tr>
                                <tr>
                                    <td><b>Keluhan</b></td>
                                    <td>:</td>
                                    <td colspan="3"><?= $detail->keluhan ?></td>
                                </tr>
                                <tr>
                                    <td><b>Komorbid</b></td>
                                    <td>:</td>
                                    <td colspan="3"><?= $detail->komorbid ?></td>
                                </tr>
                                <tr>
                                    <td><b>Alasan Rapid Test</b></td>
                                    <td>:</td>
                                    <td colspan="3"><?= $detail->alasan ?></td>
                                </tr>
                                <tr>
                                    <td><b>Vaksin Ke-1</b></td>
                                    <td>:</td>
                                    <td><?= $detail->tgl_vaksin_1=="0000-00-00" ? "-" : date('d-m-Y',strtotime($detail->tgl_vaksin_1)) ?></td>
                                    <td><b>Vaksin Ke-2</b></td>
                                    <td>:</td>
                                    <td><?= $detail->tgl_vaksin_2=="0000-00-00" ? "-" : date('d-m-Y',strtotime($detail->tgl_vaksin_2)) ?></td>
                                </tr>
                                <tr>
                                    <td><b>Riwayat Kontak Dengan <br> Pasien Covid-19</b></td>
                                    <td>:</td>
                                    <td colspan="3"><?= $detail->riwayat_kontak ?></td>
                                </tr>
                                <?php 
                                    if($detail->riwayat_kontak=='Ya'){
                                ?>
                                <tr>
                                    <td><b>Tanggal Kontak</b></td>
                                    <td>:</td>
                                    <td><?= date('d-m-Y',strtotime($detail->tgl_kontak)) ?></td>
                                    <td><b>Kontak Di</b></td>
                                    <td>:</td>
                                    <td><?= $detail->kontak_di ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td><b>Riwayat Rapid / Swab <br> Sebelumnya</b></td>
                                    <td>:</td>
                                    <td colspan="3"><?= $detail->riwayat_swab_rapid_sebelumnya ?></td>
                                </tr>

                            </table>
                        </div>
                        <hr>
                        <form action="" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">Parameter Pemeriksaan <?php echo form_error('parameter_pemeriksaan'); ?></div>
                                <div class="col-sm-10">
                                    <input type="text" name="parameter_pemeriksaan" class="form-control">
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Hasil</div>
                                <div class="col-sm-10">
                                    <select name="hasil" class="form-control">
                                        <option>Negatif</option>
                                        <option>Positif</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Nilai Rujukan</div>
                                <div class="col-sm-10">
                                    <select name="nilai_rujukan" class="form-control">
                                        <option>Negatif</option>
                                        <option>Positif</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Saran <?php echo form_error('saran'); ?></div>
                                <div class="col-sm-10">
                                    <div contenteditable="true" class="form-control" id="saran" style="min-height:150px">
- Bila Pemeriksaan Rapid Antigen ini merupakan pemeriksaan yang ke I, ulani pemeriksaan 10 hari lagi.
<br>
- Bila pemeriksaan ini merupakan pemeriksaan yang ke II (ulangan) saat ini belum/tidak terdeteksi.
<br>
- Tetap lakukan Social/Phisycal Distancing
<br>
- Pertahankan perilaku hidup sehat; Cuci tangan, terapkan etika batuk, gunakan masker, dan jaga stamina.
                                    </div>
                                    <input type="hidden" id="saranHidden" name="saran" value='- Bila Pemeriksaan Rapid Antigen ini merupakan pemeriksaan yang ke I, ulani pemeriksaan 10 hari lagi.
<br>
- Bila pemeriksaan ini merupakan pemeriksaan yang ke II (ulangan) saat ini belum/tidak terdeteksi.
<br>
- Tetap lakukan Social/Phisycal Distancing
<br>
- Pertahankan perilaku hidup sehat; Cuci tangan, terapkan etika batuk, gunakan masker, dan jaga stamina.
'>
                                </div>
                            </div>
                            <div class="pull-right" style="margin-top :20px">
                                <button class="btn btn-default" type="reset"><span class="fa fa-times"></span> Reset</button>
                                <button class="btn btn-success" type="submit"><span class="fa fa-save"></span> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const saran = document.getElementById('saran')
    const saranHidden = document.getElementById('saranHidden')

    saran.addEventListener('input',function(){
        saranHidden.value = saran.textContent
    })
</script>