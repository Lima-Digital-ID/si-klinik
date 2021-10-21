<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">PERIKSA IMUNISASI ANAK</h3>
                    </div>
                    <div class="box-body">
                        <div class="row col-md-12">
                            <form action="<?= base_url()."periksamedis/save_imunisasi" ?>" method="post">
                            <div class="form-group row">
                                <div class="col-md-2">Nama Pasien Ke <?php echo form_error('nama'); ?></div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="<?= $nama_lengkap ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">No Rekam Medis <?php echo form_error('no_rekam_medis'); ?></div>
                                <div class="col-md-10">
                                    <input type="text" name="no_rekam_medis" class="form-control" value="<?= $no_rekam_medis ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">No ID<?php echo form_error('no_id_pasien'); ?></div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="<?= $no_id_pasien ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">Macam Persalinan <?php echo form_error('macam_persalinan'); ?></div>
                                <div class="col-md-10">
                                    <select name="macam_persalinan" id="" class="select2 form-control">
                                        <option value="1" <?= $macam_persalinan!="" && $macam_persalinan==1 ? 'selected' : '' ?>>Normal</option>
                                        <option value="2" <?= $macam_persalinan!="" && $macam_persalinan==2 ? 'selected' : '' ?>>SC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">Pelayanan Persalinan Oleh <?php echo form_error('pelayanan_persalinan'); ?></div>
                                <div class="col-md-10">
                                    <select name="pelayanan_persalinan" id="" class="select2 form-control">
                                        <option value="1" <?= $pelayanan_persalinan!='' && $pelayanan_persalinan==1 ? 'selected' : '' ?>>Dokter</option>
                                        <option value="2" <?= $pelayanan_persalinan!='' && $pelayanan_persalinan==2 ? 'selected' : '' ?>>Bidan</option>
                                        <option value="3" <?= $pelayanan_persalinan!='' && $pelayanan_persalinan==3 ? 'selected' : '' ?>>Tenaga Puskesmas (Selain Bidan)</option>
                                        <option value="4" <?= $pelayanan_persalinan!='' && $pelayanan_persalinan==4 ? 'selected' : '' ?>>Dukun Terlatih</option>
                                        <option value="5" <?= $pelayanan_persalinan!='' && $pelayanan_persalinan==5 ? 'selected' : '' ?>>Dukun</option>
                                        <option value="6" <?= $pelayanan_persalinan!='' && $pelayanan_persalinan==6 ? 'selected' : '' ?>>Sendiri</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">Anak Ke <?php echo form_error('anak_ke'); ?></div>
                                <div class="col-md-10">
                                    <input type="text" name="anak_ke" class="form-control" value="<?= $anak_ke ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">Tempat Persalinan <?php echo form_error('tempat_persalinan'); ?></div>
                                <div class="col-md-10">
                                    <select name="tempat_persalinan" id="" class="form-control">
                                        <option value="1" <?= $tempat_persalinan!='' && $tempat_persalinan==1 ? 'selected' : '' ?>>Rumah</option>
                                        <option value="2" <?= $tempat_persalinan!='' && $tempat_persalinan==2 ? 'selected' : '' ?>>Rumah Sakit</option>
                                        <option value="3" <?= $tempat_persalinan!='' && $tempat_persalinan==3 ? 'selected' : '' ?>>Puskesmas</option>
                                        <option value="4" <?= $tempat_persalinan!='' && $tempat_persalinan==4 ? 'selected' : '' ?>>Rumah Bersalin</option>
                                        <option value="5" <?= $tempat_persalinan!='' && $tempat_persalinan==5 ? 'selected' : '' ?>>Rumah Bidan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    ASI <?= form_error('asi') ?>
                                </div>
                                <div class="col-md-10">
                                    <label for="asi">ASI</label> <input type="radio" value='1' name="asi" <?= $asi!='' && $asi==1 ? 'checked' : 'checked' ?> id="asi"> 
                                    &nbsp;
                                    <label for="sufor">SuFor</label> <input type="radio" value='2' name="asi" <?= $asi!='' && $asi==2 ? 'checked' : '' ?> id="sufor"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>Imunisasi</th>
                                            <th>Tanggal</th>
                                        </tr>
                                        <tr>
                                            <td>HB 0</td>
                                            <td><input type="date" class="form-control" name="hb0" id="" value="<?= $hb0 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>BCG</td>
                                            <td><input type="date" class="form-control" name="bcg" id="" value="<?= $bcg ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Polio I</td>
                                            <td><input type="date" class="form-control" name="polio1" id="" value="<?= $polio1 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Pentabio I</td>
                                            <td><input type="date" class="form-control" name="pentabio1" id="" value="<?= $pentabio1 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Polio II</td>
                                            <td><input type="date" class="form-control" name="polio2" id="" value="<?= $polio2 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Pentabio II</td>
                                            <td><input type="date" class="form-control" name="pentabio2" id="" value="<?= $pentabio2 ?>"></td>
                                        </tr>


                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>Imunisasi</th>
                                            <th>Tanggal</th>
                                        </tr>
                                        <tr>
                                            <td>Polio III</td>
                                            <td><input type="date" class="form-control" name="polio3" id="" value="<?= $polio3 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Pentabio III</td>
                                            <td><input type="date" class="form-control" name="pentabio3" id="" value="<?= $pentabio3 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Polio IV</td>
                                            <td><input type="date" class="form-control" name="polio4" id="" value="<?= $polio4 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Campak (9-11 bln)</td>
                                            <td><input type="date" class="form-control" name="campak" id="" value="<?= $campak ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>JE</td>
                                            <td><input type="date" class="form-control" name="je" id="" value="<?= $je ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Pentabio Booster (18-35 bln)</td>
                                            <td><input type="date" class="form-control" name="pentabio_booster" id="" value="<?= $pentabio_booster ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Campak Booster (24-35 bln)</td>
                                            <td><input type="date" class="form-control" name="campak_booster" id="" value="<?= $campak_booster ?>"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th rowspan="2">Vit A,</th>
                                            <?php 
                                                for ($i=1; $i <= 10 ; $i++) { 
                                            ?>
                                                <th><?= $i ?></th>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <?php 
                                                $fieldVit = ['',$obat_cacing1,$vitA2,$vitA3,$vitA4,$vitA5,$vitA6,$vitA7,$vitA8,$vitA9,$vitA10];
                                                for ($i=1; $i <= 10 ; $i++) { 
                                                    ?>
                                                <td><input type="text" class="form-control" name="vitA<?= $i ?>" value="<?= $fieldVit[$i] ?>"></td>
                                                <?php
                                                }
                                                ?>
                                        </tr>
                                        <tr>
                                            <th>Obat Cacing</th>
                                            <?php 
                                                $fieldObatCacing = ['',$obat_cacing1,$obat_cacing2,$obat_cacing3,$obat_cacing4,$obat_cacing5];
                                                for ($i=1; $i <= 5 ; $i++) { 
                                            ?>
                                                <td colspan="2"><input type="text" class="form-control" name="obat_cacing<?= $i ?>" value="<?= $fieldObatCacing[$i] ?>"></td>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                    </table>                                    
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
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <button class="btn btn-warning"><span class="fa fa-save"></span> Simpan</button>
                                        <button class="btn btn-default" type="reset"><span class="fa fa-reset"></span> Batal</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
