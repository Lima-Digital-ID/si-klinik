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
                            <div class="form-group row">
                                <div class="col-md-2">Macam Persalinan <?php echo form_error('macam_persalinan'); ?></div>
                                <div class="col-md-10">
                                    <select name="macam_persalinan" id="" class="select2 form-control">
                                        <option value="1">Normal</option>
                                        <option value="2">SC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">Pelayanan Persalinan Oleh <?php echo form_error('pelayanan_persalinan'); ?></div>
                                <div class="col-md-10">
                                    <select name="pelayanan_persalinan" id="" class="select2 form-control">
                                        <option value="1">Dokter</option>
                                        <option value="2">Bidan</option>
                                        <option value="3">Tenaga Puskesmas (Selain Bidan)</option>
                                        <option value="4">Dukun Terlatih</option>
                                        <option value="5">Dukun</option>
                                        <option value="6">Sendiri</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">Anak Ke <?php echo form_error('anak_ke'); ?></div>
                                <div class="col-md-10">
                                    <input type="text" name="anak_ke" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">Tempat Persalinan <?php echo form_error('tempat_persalinan'); ?></div>
                                <div class="col-md-10">
                                    <select name="tempat_persalinan" id="" class="form-control">
                                        <option value="1">Rumah</option>
                                        <option value="2">Rumah Sakit</option>
                                        <option value="3">Puskesmas</option>
                                        <option value="4">Rumah Bersalin</option>
                                        <option value="5">Rumah Bidan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    ASI <?= form_error('asi') ?>
                                </div>
                                <div class="col-md-10">
                                    <label for="asi">ASI</label> <input type="radio" value='1' name="asi" id="asi"> 
                                    &nbsp;
                                    <label for="sufor">SuFor</label> <input type="radio" value='2' name="asi" id="sufor"> 
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
                                            <td><input type="date" class="form-control" name="hb0" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>BCG</td>
                                            <td><input type="date" class="form-control" name="bcg" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>Polio I</td>
                                            <td><input type="date" class="form-control" name="polio1" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>Pentabio I</td>
                                            <td><input type="date" class="form-control" name="pentabio1" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>Polio II</td>
                                            <td><input type="date" class="form-control" name="polio2" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>Pentabio II</td>
                                            <td><input type="date" class="form-control" name="pentabio2" id=""></td>
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
                                            <td><input type="date" class="form-control" name="polio3" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>Pentabio III</td>
                                            <td><input type="date" class="form-control" name="pentabio3" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>Polio IV</td>
                                            <td><input type="date" class="form-control" name="polio4" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>Campak (9-11 bln)</td>
                                            <td><input type="date" class="form-control" name="campak" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>JE</td>
                                            <td><input type="date" class="form-control" name="je" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>Pentabio Booster (18-35 bln)</td>
                                            <td><input type="date" class="form-control" name="pentabio_booster" id=""></td>
                                        </tr>
                                        <tr>
                                            <td>Campak Booster (24-35 bln)</td>
                                            <td><input type="date" class="form-control" name="campak_booster" id=""></td>
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
                                                for ($i=1; $i <= 10 ; $i++) { 
                                            ?>
                                                <td><input type="text" class="form-control" name="vitA<?= $i ?>"></td>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <th>Obat Cacing</th>
                                            <?php 
                                                for ($i=1; $i <= 5 ; $i++) { 
                                            ?>
                                                <td colspan="2"><input type="text" class="form-control" name="obat_cacing<?= $i ?>"></td>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                    </table>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
