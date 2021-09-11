<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">Neraca Saldo</h3>
                    </div>
        
                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                            <form action="<?=current_url()?>" method="post">
                            <div class="row">
                                
                                <div class="col-sm-7">
                                    <div class="form-inline">
                                        <label>Pilih Bulan : </label>
                                        <select class="form-control select2" name="bulan" required>
                                            <option value="">--Pilih Bulan--</option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                        <select class="form-control select2" name="tahun" required>
                                            <option value="">--Pilih Tahun--</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                        </select>
                                        <button class="btn btn-primary"  onclick="cekAbsensiDate()"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                                <br>
                            </form>
                        </div>
        
                    <?php
                    function formatRupiah($num){
                        return number_format($num, 0, '.', '.');
                    }
                    ?>
                    <h4 id="bulan">Neraca Saldo Bulan November 2019</h4>
                    <table class="table table-bordered">
                        <thead id="table">
                            <tr>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">No Akun</th>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Nama Akun</th>
                                <th></th>
                                <th></th>
                                <th colspan="2" class="text-center">Saldo</th>
                            </tr>
                            <tr>
                                <th>Debit</th>
                                <th>Kredit</th>
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
                                <td class="text-right">Rp. <?=formatRupiah($value->jumlah_debit)?></td>
                                <td class="text-right">Rp. <?=formatRupiah($value->jumlah_kredit)?></td>
                                <?php
                                    if ($value->jumlah_debit > $value->jumlah_kredit) {
                                        $jumlah_saldo=(($saldo != null ? $saldo->jumlah_saldo : 0) + $value->jumlah_debit) - $value->jumlah_kredit;
                                        $jumlah_debit=($value->jumlah_debit-$value->jumlah_kredit);
                                        $total_debit+=$jumlah_debit;
                                ?>
                                <td class="text-right">Rp. <?=formatRupiah($jumlah_debit)?></td>
                                <td class="text-right">-</td>
                                <?php
                                    }else{
                                        $jumlah_saldo=(($saldo != null ? $saldo->jumlah_saldo : 0) + $value->jumlah_kredit) - $value->jumlah_debit;
                                        $jumlah_kredit=($value->jumlah_kredit-$value->jumlah_debit);
                                        $total_kredit+=$jumlah_kredit;
                                ?>
                                <td class="text-right">-</td>
                                <td class="text-right">Rp. <?=formatRupiah($jumlah_kredit)?></td>
                                <?php
                                    }
                                ?>
                                <!-- 
                                <?php
                                if ($value->id_parent == 3 || $value->id_parent == 7) {
                                    if ($value->id_akun == 20 ) {
                                        // $jumlah_debit+=$saldo->jumlah_saldo-($value->jumlah_debit-$value->jumlah_kredit);
                                        $jumlah_debit+=($value->jumlah_debit-$value->jumlah_kredit);
                                ?>
                                <td class="text-right">Rp. <?=formatRupiah($value->jumlah_debit-$value->jumlah_kredit)?></td>
                                <?php
                                    }else{
                                        $jumlah_debit+=($value->jumlah_debit-$value->jumlah_kredit);
                                ?>
                                <td class="text-right">Rp. <?=formatRupiah($value->jumlah_debit-$value->jumlah_kredit)?></td>
                                <?php
                                    }
                                ?>
                                <td class="text-right">-</td>
                                <?php

                                }else{
                                    $jumlah_kredit+=($value->jumlah_kredit-$value->jumlah_debit);
                                ?>
                                <td class="text-right">-</td>
                                <td class="text-right">Rp. <?=formatRupiah($value->jumlah_kredit-$value->jumlah_debit)?></td>
                                <?php
                                }
                                ?>
                                 -->
                            </tr>
                        <?php  
                        }
                        ?>
                        <tr id="table">
                            <th colspan="4" class="text-center">Total Saldo</th>
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
<script type="text/javascript">
    var bulan=<?=$bulan?>;
    $('#bulan').html('Neraca Saldo Bulan '+formatBulan(bulan));
    function formatBulan(val){
        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        var getMonth=val[1];
        return bulan[getMonth-1]+' '+val[0];
    }
</script>