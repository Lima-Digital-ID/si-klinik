<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">Neraca Saldo</h3>
                    </div>
        
                    <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                        <form action="<?=current_url()?>" method="get">
                                    <div class="form-inline">
                                        <label>Pilih Bulan : </label>
                                        <select class="form-control select2" name="bulan" required>
                                            <option value="">--Pilih Bulan--</option>
                                            <option value="01">Januari</option>
                                            <option value="02">Februari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                        <?php 
                                            $starting_year  = 2017;
                                            $current_year = date("Y") * 1;
                                            echo '<select class="form-control select2" name="tahun" required>';
                                            echo '<option value="">--Pilih Tahun--</option>';
                                            do {
                                                echo '<option value="'.$starting_year.'">'.$starting_year.'</option>';
                                                $starting_year++;
                                            }
                                            while ($current_year >= $starting_year);
                                            echo '</select>';
                                        ?>
                                        <button class="btn btn-primary"  onclick="cekAbsensiDate()"><i class="fa fa-search"></i></button>
                                    </div>
                                <br>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= isset($_GET['bulan']) ? '?bulan='.$_GET['bulan'].'&tahun='.$_GET['tahun'].'&export=true' : '?export=true' ?>" class="btn btn-success"><span class="fa fa-file-excel-o"></span> Export Excel</a>
                        </div>
                    </div>
        
                    <?php
                    function formatRupiah($num){
                        return number_format($num, 0, '.', '.');
                    }
                    function tglIndo($date){
                        $ex = explode('-',$date);
                        $bulan = ['','Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        return $bulan[(int)$ex[1]]." ".$ex[0];
                    }

                    ?>
                    <h4 id="bulan">Neraca Saldo Bulan <?= tglIndo($date) ?></h4>
                    <table class="table table-bordered">
                        <thead id="table">
                            <tr>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">No Akun</th>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Nama Akun</th>
                                <!-- <th></th>
                                <th></th> -->
                                <th colspan="2" class="text-center">Saldo</th>
                            </tr>
                            <tr>
                                <!-- <th>Debit</th>
                                <th>Kredit</th> -->
                                <th>Debit</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $jumlah_debit=$jumlah_kredit=$total_debit=$total_kredit=0;
                        foreach ($data_saldo as $key => $value) {
                            $saldo=$this->db->where('id_akun', $value->id_akun)->where('tanggal', $date)->get('tbl_saldo_akun')->row();
                        ?>
                            <tr>
                                <td><?=$value->no_akun?></td>
                                <td><?=$value->nama_akun?></td>
                                <!-- <td class="text-right">Rp. <?=formatRupiah($value->jumlah_debit)?></td>
                                <td class="text-right">Rp. <?=formatRupiah($value->jumlah_kredit)?></td> -->
                                <?php
                                if ($value->id_parent == 3 || $value->id_parent == 7) {
                                    $a=(($saldo != null ? $saldo->jumlah_saldo : 0) + $value->jumlah_debit) - $value->jumlah_kredit;
                                    // $a=($saldo != null ? $saldo->jumlah_saldo : 0);
                                    $total_debit+=$a;
                                    if ($a < 0) {
                                        $a=abs($a);
                                        ?>
                                <td class="text-right">-</td>
                                <td class="text-right">Rp. <?=formatRupiah($a)?></td>
                                <?php
                                    }else{
                                ?>
                                <td class="text-right">Rp. <?=formatRupiah($a)?></td>
                                <td class="text-right">-</td>
                                <?php
                                    }
                                }else{
                                    $b=(($saldo != null ? $saldo->jumlah_saldo : 0) + $value->jumlah_kredit) - $value->jumlah_debit;
                                    // $b=($saldo != null ? $saldo->jumlah_saldo : 0);
                                    $total_kredit+=$b;
                                    if ($b < 0) {
                                        $b=abs($b);
                                    ?>
                                <td class="text-right">Rp. <?=formatRupiah($b)?></td>    
                                <td class="text-right">-</td>
                                <?php
                                    }else{
                                ?>
                                <td class="text-right">-</td>
                                <td class="text-right">Rp. <?=formatRupiah($b)?></td>
                                <?php
                                    }
                                }
                                ?>
                                
                            </tr>
                        <?php  
                        }
                        ?>
                        <tr id="table">
                            <th colspan="2" class="text-center">Total Saldo</th>
                            <th class="text-right">Rp. <?=formatRupiah($total_debit)?></th>
                            <th class="text-right">Rp. <?=formatRupiah($total_kredit)?></th>
                        </tr>
                        </tbody>
                    </table>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<style type="text/css">
    #table {
        background-color:#3c8dbc; color:white;
    }
</style>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
