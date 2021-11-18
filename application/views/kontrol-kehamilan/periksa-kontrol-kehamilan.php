<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">KONTROL KEHAMILAN</h3>
                    </div>
                    <div class="box-body">
                        <form action="<?php echo base_url()."periksamedis/save_kontrol_kehamilan" ?>" method="post">
						<div class="form-group row">
							<div class="col-sm-2">No Periksa <?php echo form_error('no_periksa'); ?></div>
							<div class="col-sm-10">
                                    <?php echo form_input(array('id'=>'no_periksa','name'=>'no_periksa','type'=>'text','value'=>$no_periksa, 'class'=>'form-control','readonly'=>'readonly'));?>
							</div>
                        </div>
                        <div class="form-group row">
							<div class="col-sm-2">Nomor Rekam Medis</div>
							<div class="col-sm-10">
                                <?php echo form_input(array('id'=>'no_rekam_medis','name'=>'no_rekam_medis','type'=>'text','value'=>$no_rekam_medis,'class'=>'form-control','readonly'=>'readonly'));?>
                            </div>
						</div>
                        <div class="form-group row">
							<div class="col-sm-2">Nama Lengkap</div>
							<div class="col-sm-10">
                                <?php
                                    if(isset($nama_lengkap)) {
                                        echo form_input(array('id'=>'nama_lengkap','name'=>'nama_lengkap','type'=>'text','value'=>$nama_lengkap,'class'=>'form-control','readonly'=>'readonly'));
                                    }
                                    else {
                                        echo form_input(array('id'=>'nama_lengkap','name'=>'nama_lengkap','type'=>'text','value'=>'','class'=>'form-control','readonly'=>'readonly'));
                                    }
                                ?>
                            </div>
						</div>
						<div class="form-group row">
							<div class="col-sm-2">Alamat</div>
							<div class="col-sm-10">
                                <?php
                                    if(isset($alamat)) {
                                        echo form_textarea(array('id'=>'alamat','name'=>'alamat','type'=>'textarea','value'=>$alamat,'rows'=>'4','class'=>'form-control','readonly'=>'readonly'));
                                    }
                                    else {
                                        echo form_textarea(array('id'=>'alamat','name'=>'alamat','type'=>'textarea','value'=>'','rows'=>'4','class'=>'form-control','readonly'=>'readonly'));
                                    }
                                ?>
                            </div>
						</div>
                        <hr>
                        <div class="row col-md-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#register">Register</a></li>
                                <li><a data-toggle="tab" href="#pemeriksaan">Pemeriksaan</a></li>
                                <!-- <li><a data-toggle="tab" href="#imunisasi">Status Imunisasi</a></li> -->
                                <li><a data-toggle="tab" href="#pelayanan">Pelayanan</a></li>
                                <li><a data-toggle="tab" href="#laboratorium">Laboratorium</a></li>
                                <!-- <li><a data-toggle="tab" href="#integrasi">Integrasi Program</a></li> -->
                            </ul>
                            <br>
                            <div class="tab-content  col-md-12">
                            <div id="register" class="tab-pane fade in active">
                                <div class="form-group row">
                                    <div class="col-md-2">Tanggal <?php echo form_error('tanggal'); ?></div>
                                    <div class="col-md-10">
                                        <input type="date" name="tanggal" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Jamkesmas <?php echo form_error('jamkesmas'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" value="1" name="jamkeskmas" id="jamkesYa">
                                        <label for="jamkesYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" value="0" name="jamkeskmas" id="jamkesTidak">
                                        <label for="jamkesTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Cara Masuk <?php echo form_error('cara_masuk'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="cara_masuk" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Usia Klinis <?php echo form_error('usia_klinis'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="usia_klinis" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Trimeter Ke <?php echo form_error('trimeter_ke'); ?></div>
                                    <div class="col-md-10">
                                        <input type="number" name="trimeter_ke" id="" required class="form-control">
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
                                        <input type="text" name="anamsesis" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">BB (Kg) <?php echo form_error('bb'); ?></div>
                                    <div class="col-md-10">
                                        <input type="number" name="bb" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">TD (mmHg) <?php echo form_error('td'); ?></div>
                                    <div class="col-md-10">
                                        <input type="number" name="td" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">LILA (cm) <?php echo form_error('lila'); ?></div>
                                    <div class="col-md-10">
                                        <input type="number" name="lila" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Status Gizi <?php echo form_error('status_gizi'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="status_gizi" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">TFU (cm) <?php echo form_error('tfu'); ?></div>
                                    <div class="col-md-10">
                                        <input type="number" name="tfu" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Refleksi Patela <?php echo form_error('refleksi_patela'); ?></div>
                                    <div class="col-md-10">
                                    <input type="radio" value="1" name="refleksi_patela" id="refleksiPlus">
                                        <label for="refleksiPlus">+</label>
                                        &nbsp;
                                        <input type="radio" value="0" name="refleksi_patela" id="refleksiMin">
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
                                        <input type="number" name="djj" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Kepala Thd PAP <?php echo form_error('kepala_thd'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="kepala_thd" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">TBJ (gram) <?php echo form_error('tbj'); ?></div>
                                    <div class="col-md-10">
                                        <input type="number" name="tbj" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Presentasi <?php echo form_error('presentasi'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="presentasi" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Jumlah Janin <?php echo form_error('jumlah_janin'); ?></div>
                                    <div class="col-md-10">
                                        <input type="number" name="jumlah_janin" id="" required class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div id="pelayanan" class="tab-pane fade in">
                                <div class="form-group row">
                                    <div class="col-md-2">Injeksi TT <?php echo form_error('injeksi_tt'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" value="1" name="injeksi_tt" id="injeksiYa">
                                        <label for="injeksiYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" value="0" name="injeksi_tt" id="injeksiTidak">
                                        <label for="injeksiTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Status Imunisasi <?php echo form_error('status_imunisasi'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="status_imunisasi" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Catatan di Buku KIA <?php echo form_error('catatan_kia'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" value="1" name="catatan_kia" id="catatanKiaYa">
                                        <label for="catatanKiaYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" value="0" name="catatan_kia" id="catatanKiaTidak">
                                        <label for="catatanKiaTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Fe (tab/botol) <?php echo form_error('fe'); ?></div>
                                    <div class="col-md-10">
                                    <select style="width:100%" name="fe" id="" required class="form-control select2 selectObat">
                                            <option value="">---Pilih Obat---</option>
                                            <?php 
                                                foreach($obat as $value){
                                                    echo "<option data-stok='".$value->stok_barang."' value='".$value->kode_barang."'>".$value->nama_barang."</option>";
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Jumlah Fe<?php echo form_error('jml_fe'); ?></div>
                                    <div class="col-md-10">
                                        <select name="jml_fe" class="form-control stokObat" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Tindakan <?php echo form_error('tindakan'); ?></div>
                                    <div class="col-md-10">
                                    <select name="tindakan[]" multiple="multiple" id="biaya_tindakan" style="width:100%" class="select2 form-control" required>
                                        <option value="">---Pilih Tindakan---</option>
                                        <?php 
                                            foreach ($master_tindakan as $key => $value) {
                                                echo "<option value='".$value->kode_tindakan."'>".$value->kode_tindakan." - ".$value->tindakan." ".number_format($value->biaya,0,',','.')."</option>";
                                            }
                                        ?>
                                    </select>
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
                                        <input type="radio" value="1" name="hb_dilakukan" id="hbDilakukanYa">
                                        <label for="hbDilakukanYa">Ya</label>
                                        &nbsp;
                                        <input type="radio" value="0" name="hb_dilakukan" id="hbDilakukanTidak">
                                        <label for="hbDilakukanTidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Hasil (gr/dl) <?php echo form_error('hb_hasil'); ?></div>
                                    <div class="col-md-10">
                                        <input type="number" name="hb_hasil" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Anemia <?php echo form_error('hb_anemia'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" value="1" name="hb_anemia" id="hbAnemiaPlus">
                                        <label for="hbAnemiaPlus">+</label>
                                        &nbsp;
                                        <input type="radio" value="0" name="hb_anemia" id="hbAnemiaMin">
                                        <label for="hbAnemiaMin">-</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-md-2">Protein Uria <?php echo form_error('protein_uria'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" value="1" name="protein_uria" id="proteinUriaPlus">
                                        <label for="proteinUriaPlus">+</label>
                                        &nbsp;
                                        <input type="radio" value="0" name="protein_uria" id="proteinUriaMin">
                                        <label for="proteinUriaMin">-</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Gula Darah <?php echo form_error('gula_darah'); ?></div>
                                    <div class="col-md-10">
                                        <input type="text" name="gula_darah" id="" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Sifilis <?php echo form_error('sifilis'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" value="1" name="sifilis" id="sifilisPlus">
                                        <label for="sifilisPlus">+</label>
                                        &nbsp;
                                        <input type="radio" value="0" name="sifilis" id="sifilisMin">
                                        <label for="sifilisMin">-</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">HbsAg <?php echo form_error('hbsag'); ?></div>
                                    <div class="col-md-10">
                                        <input type="radio" value="1" name="hbsag" id="hbsagPlus">
                                        <label for="hbsagPlus">+</label>
                                        &nbsp;
                                        <input type="radio" value="0" name="hbsag" id="hbsagMin">
                                        <label for="hbsagMin">-</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">Periksa Lab Terpilih <?php echo form_error('periksa_lab'); ?></div>
                                    <div class="col-md-10">
                                        <select name="periksa_lab[]" id="" class="form-control select2" multiple="multiple" style="width:100%" required>
                                            <option value="">---Periksa Lab---</option>
                                            <?php 
                                                foreach ($periksa_lab as $key => $value) {
                                                    echo "<option value='".$value->id_tipe."'>".$value->item."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <button type="reset" class="btn btn-default">Reset</button>
                                            <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>

<script>
    $(document).ready(function(){
        function selectAlkes(thisAttr){
        }

        $(".selectObat").change(function(){
            var stok = $(this).find(':selected').data('stok')
            $(".stokObat option").remove()
            var option = "";
            if(stok==0){
                option = "<option value=''>Habis</option>";
            }
            else{
                for (let s = 1; s <= stok; s++) {
                    option+="<option>"+s+"</option>";
                }
            }
            $(".stokObat").append(option);
        })
    })
</script>
