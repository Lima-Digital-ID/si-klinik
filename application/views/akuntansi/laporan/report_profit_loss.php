<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">LAPORAN LABA RUGI</h3>
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
        function formatDate($date){
            $date=date_create($date);
            return date_format($date, 'd-m-Y');
        }
        ?>
                <h4 class="box-title" id="bulan"></h4>
                    <table class="table table-bordered" id="detailKas">
                        <thead style="background-color:#3c8dbc; color:white">
                            <tr>
                                <th>Pendapatan dari Penjualan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sum_pendapatan=0;
                            foreach ($pendapatan as $key => $value) {
                            ?>
                            <tr>
                                <?php
                                if ($value->id_akun == 39 || $value->id_akun == 62 || $value->id_akun == 63 || $value->id_akun == 68) {
                                    $total=$value->jumlah_kredit-$value->jumlah_debit;
                                    $sum_pendapatan+=$total;
                                ?>
                                    <td><?=$value->nama_akun?></td>
                                    <td align="right">Rp. <?=formatRupiah($total)?></td>
                                <?php
                                }else if ($value->id_akun == 46 || $value->id_akun == 64 || $value->id_akun == 69){
                                    $total=$value->jumlah_debit-$value->jumlah_kredit;  
                                    $sum_pendapatan-=$total;
                                ?>
                                    <td><?=$value->nama_akun?></td>
                                    <td align="right">- Rp. <?=formatRupiah($total)?></td>
                                <?php
                                }
                                ?>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr style="background-color:#ddd">
                                <th>Total Pendapatan dari Penjualan</th>
                                <th class="text-right">Rp. <?=formatRupiah($sum_pendapatan)?></th>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </tbody>
                        <thead style="background-color:#3c8dbc; color:white">
                            <tr>
                                <th>Harga Pokok Penjualan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sum_hpp=0;
                            foreach ($beban as $key => $value) {
                                if ($value->id_akun == 65) {
                                    $total=$value->jumlah_debit-$value->jumlah_kredit;
                                    $sum_hpp+=$total;
                            ?>
                            <tr>
                                <td><?=$value->nama_akun?></td>
                                <td align="right">Rp. <?=formatRupiah($total)?></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                            <?php
                            foreach ($pendapatan as $key => $value) {
                                if ($value->id_akun == 45) {
                                    $total=$value->jumlah_kredit-$value->jumlah_debit;
                                    $sum_hpp-=$total;
                            ?>
                            <tr>
                                <td><?=$value->nama_akun?></td>
                                <td align="right">- Rp. <?=formatRupiah($total)?></td>
                            </tr>
                            <?php
                                }
                            }
                            $bruto=$sum_pendapatan-$sum_hpp;
                            ?>
                            <tr style="color:red;background-color:#ddd">
                                <th>Total Harga Pokok Penjualan</th>
                                <th class="text-right">Rp. <?=formatRupiah($sum_hpp)?></th>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </tbody>
                        <tbody style="background-color:#3c8dbc; color:white">
                            <tr style="padding-top:10px">
                                <th>PENDAPATAN KOTOR</th>
                                <th class="text-right">Rp. <?=formatRupiah($bruto)?></th>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </tbody>
                        <thead style="background-color:#3c8dbc; color:white">
                            <tr>
                                <th>Pengeluaran Beban</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sum_beban=0;
                            foreach ($beban as $key => $value) {
                                if ($value->id_akun != 65) {
                                    $total=$value->jumlah_debit-$value->jumlah_kredit;
                                    $sum_beban+=$total;
                            ?>
                            <tr>
                                <td><?=$value->nama_akun?></td>
                                <td align="right">Rp. <?=formatRupiah($total)?></td>
                            </tr>
                            <?php
                                }
                            }
                            $netto=$bruto-$sum_beban;
                            ?>
                            <tr style="color:red;background-color:#ddd">
                                <th>Total Pengeluaran Beban</th>
                                <th class="text-right">Rp. <?=formatRupiah($sum_beban)?></th>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </tbody>
                        <tbody style="background-color:#3c8dbc; color:white">
                            <tr style="padding-top:10px">
                                <th>PENDAPATAN BERSIH</th>
                                <th class="text-right">Rp. <?=formatRupiah($netto)?></th>
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
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
    var bulan=<?=$bulan?>;
    $('#bulan').html('Bulan '+formatBulan(bulan));
    function formatBulan(val){
        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        var getMonth=val[1];
        return bulan[getMonth-1]+' '+val[0];
    }
</script>