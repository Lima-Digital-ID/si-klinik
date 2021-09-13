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
                            <div class="form-group">
                                <div class="col-sm-2">Nama</div>
                                <div class="col-sm-10">
                                    <input type="text" name="nama" class="form-control">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Email</div>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">No Hp</div>
                                <div class="col-sm-10">
                                    <input type="no_hp" name="no_hp" class="form-control">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Alamat Domisili</div>
                                <div class="col-sm-10">
                                    <textarea name="alamat_domisili" class="form-control"></textarea>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Pekerjaan</div>
                                <div class="col-sm-10">
                                    <input type="text" name="pekerjaan" class="form-control">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Alamat Tempat Bekerja</div>
                                <div class="col-sm-10">
                                    <textarea name="alamat_bekerja" class="form-control"></textarea>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Keluhan</div>
                                <div class="col-sm-10">
                                    <textarea name="keluhan" class="form-control"></textarea>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Penyakit Komorbid</div>
                                <div class="col-sm-10">
                                    <textarea name="komorbid" class="form-control"></textarea>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Alasan SWAB</div>
                                <div class="col-sm-10">
                                    <textarea name="alasan" class="form-control"></textarea>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Riwayat Vaksin Covid-19</div>
                                <div class="col-sm-10">
                                    <input type="radio" class="riwayatVaksin" name="riwayat_vaksin" id="sudah" value="Sudah">
                                    <label for="sudah">Sudah</label>
                                    &nbsp;&nbsp;
                                    <input type="radio" class="riwayatVaksin" name="riwayat_vaksin" id="belum" value="Belum">
                                    <label for="belum">Belum</label>
                                </div>
                            </div>
                            <br>
                            <div id="tanggalVaksin" style="display:none">
                                <div class="form-group">
                                    <div class="col-sm-2">Tanggal Vaksin</div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Vaksin Ke-1</label>
                                                <input type="date" name="tgl_vaksin_1" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Vaksin Ke-2</label>
                                                <input type="date" name="tgl_vaksin_2" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">Riwayat Kontak Dengan Pasien Covid-19</div>
                                <div class="col-sm-10">
                                    <input type="radio" class="riwayatKontak" name="riwayat_kontak" id="ya" value="Ya">
                                    <label for="ya">Ya</label>
                                    &nbsp;&nbsp;
                                    <input type="radio" class="riwayatKontak" name="riwayat_kontak" id="tidak" value="Tidak">
                                    <label for="tidak">Tidak</label>
                                    <div id="kontakCovid" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">Tanggal Kontak</label>
                                                <input type="date" name="tgl_kontak" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Kontak Di</label>
                                                <input type="text" name="kontak_di" class="form-control">
                                            </div>
                                        </div>
                                        <br>

                                    </div>   
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Riwayat SWAB/RAPID Sebelumnya</div>
                                <div class="col-sm-10">
                                    <textarea name="riwayat_swab_rapid_sebelumnya" class="form-control"></textarea>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="form-group">
                                <div class="col-sm-2">Pilih Dokter</div>
                                <div class="col-sm-10">
                                    <select name="id_dokter" id="" class="form-control">
                                        <option value="">--Pilih Dokter--</option>
                                        <?php 
                                            foreach ($data_dokter as $key => $value) {
                                                echo "<option value='".$value->id_dokter."'>".$value->nama_dokter."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="pull-right">
                                <button class="btn btn-default"><span class="fa fa-times"></span> Reset</button>
                                <button class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
                            </div>
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