<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">KONTROL KEHAMILAN</h3>
                    </div>
                    <div class="box-body">
                        <div class="row col-md-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#register">Register</a></li>
                                <li><a data-toggle="tab" href="#pemeriksaan">Pemeriksaan</a></li>
                                <li><a data-toggle="tab" href="#imunisasi">Status Imunisasi</a></li>
                                <li><a data-toggle="tab" href="#pelayanan">Pelayanan</a></li>
                                <li><a data-toggle="tab" href="#laboratorium">Laboratorium</a></li>
                                <li><a data-toggle="tab" href="#integrasi">Integrasi Program</a></li>
                            </ul>
                            <br>
                            <div class="tab-content  col-md-12">
                            <div id="register" class="tab-pane fade in active">
                                <div class="form-group row">
                                    <div class="col-md-2">Tanggal <?php echo form_error('tanggal'); ?></div>
                                    <div class="col-md-10">
                                        <input type="date" name="tanggal" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Jamkesmas <?php echo form_error('jamkesmas'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="jamkeskmas" id="jamkesYa">
                                        <label for="jamkesYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" name="jamkeskmas" id="jamkesTidak">
                                        <label for="jamkesTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Cara Masuk <?php echo form_error('cara_masuk'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="cara_masuk" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Usia Klinis <?php echo form_error('usia_klinis'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="usia_klinis" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Trimeter Ke <?php echo form_error('trimeter_ke'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="trimeter_ke" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div id="pemeriksaan" class="tab-pane fade in">
                                <div class="row col-md-12">
                                    <h4><b>Ibu</b></h4>
                                    <hr>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Anamsesis <?php echo form_error('anamsesis'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="anamsesis" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">BB (Kg) <?php echo form_error('bb'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="bb" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">TD (mmHg) <?php echo form_error('td'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="td" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">LILA (cm) <?php echo form_error('lila'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="lila" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Status Gizi <?php echo form_error('status_gizi'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="status_gizi" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">TFU (cm) <?php echo form_error('tfu'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="tfu" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Refleksi Patela <?php echo form_error('refleksi_patela'); ?></div>
                                    <div class="col-md-10">
                                    <input type="radio" name="refleksi_patela" id="refleksiPlus">
                                        <label for="refleksiPlus">+</label>
                                        &nbsp;
                                        <input type="radio" name="refleksi_patela" id="refleksiMin">
                                        <label for="refleksiMin">-</label>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <h4><b>Bayi</b></h4>
                                    <hr>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">DJJ (x/menit) <?php echo form_error('djj'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="djj" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Kepala Thd PAP <?php echo form_error('kepala_thd'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="kepala_thd" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">TBJ (gram) <?php echo form_error('tbj'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="tbj" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Presentasi <?php echo form_error('presentasi'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="presentasi" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Jumlah Janin <?php echo form_error('jumlah_janin'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="jumlah_janin" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div id="imunisasi" class="tab-pane fade in">
                                <div class="form-group row">
                                    <div class="col-md-2">Status Imunisasi <?php echo form_error('status_imunisasi'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="status_imunisasi" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div id="pelayanan" class="tab-pane fade in">
                                <div class="form-group row">
                                    <div class="col-md-2">Injeksi TT <?php echo form_error('injeksi_tt'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="injeksi_tt" id="injeksiYa">
                                        <label for="injeksiYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" name="injeksi_tt" id="injeksiTidak">
                                        <label for="injeksiTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Catatan di Buku KIA <?php echo form_error('catatan_kia'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="catatan_kia" id="catatanKiaYa">
                                        <label for="catatanKiaYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" name="catatan_kia" id="catatanKiaTidak">
                                        <label for="catatanKiaTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Fe (tab/botol) <?php echo form_error('fe'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="fe" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div id="laboratorium" class="tab-pane fade in">
                                <div class="row col-md-12">
                                    <h4><b>Periksa HB</b></h4>
                                    <hr>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Dilakukan <?php echo form_error('hb_dilakukan'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="hb_dilakukan" id="hbDilakukanYa">
                                        <label for="hbDilakukanYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" name="hb_dilakukan" id="hbDilakukanTidak">
                                        <label for="hbDilakukanTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Hasil (gr/dl) <?php echo form_error('hb_hasil'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="hb_hasil" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Anemia <?php echo form_error('hb_anemia'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="hb_anemia" id="hbAnemiaPlus">
                                        <label for="hbAnemiaPlus">+</label>
                                        &nbsp;
                                        <input type="radio" name="hb_anemia" id="hbAnemiaMin">
                                        <label for="hbAnemiaMin">-</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-md-2">Protein Uria <?php echo form_error('protein_uria'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="protein_uria" id="proteinUriaPlus">
                                        <label for="proteinUriaPlus">+</label>
                                        &nbsp;
                                        <input type="radio" name="protein_uria" id="proteinUriaMin">
                                        <label for="proteinUriaMin">-</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Gula Darah <?php echo form_error('gula_darah'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="gula_darah" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Sifilis <?php echo form_error('sifilis'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="sifilis" id="sifilisPlus">
                                        <label for="sifilisPlus">+</label>
                                        &nbsp;
                                        <input type="radio" name="sifilis" id="sifilisMin">
                                        <label for="sifilisMin">-</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">HbsAg <?php echo form_error('hbsag'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="hbsag" id="hbsagPlus">
                                        <label for="hbsagPlus">+</label>
                                        &nbsp;
                                        <input type="radio" name="hbsag" id="hbsagMin">
                                        <label for="hbsagMin">-</label>
                                    </div>
                                </div>
                            </div>
                            <div id="integrasi" class="tab-pane fade in">
                                <div class="row col-md-12">
                                    <h4><b>PMTCT</b></h4>
                                    <hr>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">VCT <?php echo form_error('vct'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="vct" id="vctYa">
                                        <label for="vctYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" name="vct" id="vctTidak">
                                        <label for="vctTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Periksa Darah <?php echo form_error('pmtct_periksa_darah'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="pmtct_periksa_darah" id="pmtct_periksa_darahYa">
                                        <label for="pmtct_periksa_darahYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" name="pmtct_periksa_darah" id="pmtct_periksa_darahTidak">
                                        <label for="pmtct_periksa_darahTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Serologi <?php echo form_error('serologi'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="serologi" id="serologiPlus">
                                        <label for="serologiPlus">+</label>
                                        &nbsp;
                                        <input type="radio" name="serologi" id="serologiMin">
                                        <label for="serologiMin">-</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">ARC Profilaksis <?php echo form_error('arv_profilaksis'); ?></div>
                                    <div class="col-md-10">
                                        <select style="width:100%" name="arv_profilaksis" id="" class="form-control select2">
                                            <option value="">---Pilih Obat---</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <h4><b>MALARIA</b></h4>
                                    <hr>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Periksa Darah <?php echo form_error('malaria_periksa_darah'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="malaria_periksa_darah" id="malaria_periksa_darahYa">
                                        <label for="malaria_periksa_darahYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" name="malaria_periksa_darah" id="malaria_periksa_darahTidak">
                                        <label for="malaria_periksa_darahTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Malaria <?php echo form_error('malaria'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="malaria" id="malariaPlus">
                                        <label for="malariaPlus">+</label>
                                        &nbsp;
                                        <input type="radio" name="malaria" id="malariaMin">
                                        <label for="malariaMin">-</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Obat <?php echo form_error('malaria_obat'); ?></div>
                                    <div class="col-md-10">
                                        <select style="width:100%" name="malaria_obat" id="" class="form-control select2">
                                            <option value="">---Pilih Obat---</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Kelambu Berinsektisida <?php echo form_error('kelambu_berinsektisida'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="kelambu_berinsektisida" id="kelambu_berinsektisidaYa">
                                        <label for="kelambu_berinsektisidaYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" name="kelambu_berinsektisida" id="kelambu_berinsektisidaTidak">
                                        <label for="kelambu_berinsektisidaTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <h4><b>TB</b></h4>
                                    <hr>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Periksa Dahak <?php echo form_error('periksa_dahak'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="periksa_dahak" id="periksa_dahakYa">
                                        <label for="periksa_dahakYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" name="periksa_dahak" id="periksa_dahakTidak">
                                        <label for="periksa_dahakTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">TBC <?php echo form_error('tbc'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" name="tbc" id="tbcPlus">
                                        <label for="tbcPlus">+</label>
                                        &nbsp;
                                        <input type="radio" name="tbc" id="tbcMin">
                                        <label for="tbcMin">-</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Obat <?php echo form_error('tbs_obat'); ?></div>
                                    <div class="col-md-10">
                                        <select style="width:100%" name="tb_obat" id="" class="form-control select2">
                                            <option value="">---Pilih Obat---</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="reset" class="btn btn-default">Reset</button>
                                        <button type="reset" class="btn btn-default">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
