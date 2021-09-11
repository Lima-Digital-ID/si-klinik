<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">REKAP PENGELUARAN MINGGUAN</h3>
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
                            <option value="<?=date('Y')?>"><?=date('Y')?></option>
                        </select>
                        <select class="form-control select2" name="minggu" required>
                            <option value="">--Pilih Minggu--</option>
                            <option value="1">Minggu 1</option>
                            <option value="2">Minggu 2</option>
                            <option value="3">Minggu 3</option>
                            <option value="4">Minggu 4</option>
                        </select>
                        <button class="btn btn-primary"  onclick="cekAbsensiDate()"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <br>
        </form>
        <?php
            function formatRupiah($val){
                return number_format($val, 0, '.', '.');
            }
            function formatDate($date){
                $date=date_create($date);
                return date_format($date, 'd-m-Y');
            }
        ?>
        <h4 id="bulan">Neraca Saldo Bulan November 2019</h4>
        <div class="table-responsive">
            
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="8" class="text-center">Rincian Pengeluaran</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Rincian</th>
                    <th>Petty Cash</th>
                    <th>Rumah Tangga</th>
                    <th>Kasbon</th>
                    <th>ATK</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $tgl_start=$tgl_end=0;
                    if ($minggu ==1) {
                        $tgl_start=1;
                        $tgl_end=7;
                    }else if ($minggu == 2) {
                        $tgl_start=8;
                        $tgl_end=14;
                    }else if($minggu == 3){
                        $tgl_start=15;
                        $tgl_end=21;
                    }else{
                        $tgl_start=22;
                        $tgl_end=$jumlah_hari;
                    }
                    $a=0;
                    $subtotal_pc=$subtotal_rt=$subtotal_kasbon=$subtotal_atk=$subtotal_all=0;
                    for ($i=$tgl_start; $i < $tgl_end; $i++) { 
                        $tgl=$date.'-'.$i;
                        $detail=$this->Akuntansi_model->getRekapDay($tgl);
                        if ($detail != null) {
                            $a++;
                        }
                        $total_pc=$total_rt=$total_kasbon=$total_atk=$total=$sub_total=0;
                        foreach ($detail as $key => $value) {
                            $jurnal=$this->Akuntansi_model->detailKreditJurnal($value->id_trx_akun);
                            foreach ($jurnal as $k => $v) {
                    ?>
                    <tr>
                        <?php
                        if ($v->id_akun == 35) {
                            $total_pc+=$v->jumlah;
                            $total+=$v->jumlah;
                            if ($key == 0) {
                        ?>
                        <td><?=$a?></td>
                        <td><?=formatDate($value->tanggal)?></td>
                        <?php
                            }else{
                        ?>
                        <td></td>
                        <td></td>
                        <?php
                            }
                        ?>
                        <td><?=$value->deskripsi?></td>
                        <td class="text-right">Rp. <?=formatRupiah($v->jumlah)?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">Rp. <?=formatRupiah($v->jumlah)?></td>
                        <?php
                        }else if ($v->id_akun == 36){
                            $total_rt+=$v->jumlah;
                            $total+=$v->jumlah;
                            if ($key == 0) {
                        ?>
                        <td><?=$a?></td>
                        <td><?=formatDate($value->tanggal)?></td>
                        <?php
                            }else{
                        ?>
                        <td></td>
                        <td></td>
                        <?php
                            }
                        ?>
                        <td><?=$value->deskripsi?></td>
                        <td></td>
                        <td class="text-right">Rp. <?=formatRupiah($v->jumlah)?></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">Rp. <?=formatRupiah($v->jumlah)?></td>
                        <?php
                        }else if ($v->id_akun == 66){
                            $total_kasbon+=$v->jumlah;
                            $total+=$v->jumlah;
                            if ($key == 0) {
                        ?>
                        <td><?=$a?></td>
                        <td><?=formatDate($value->tanggal)?></td>
                        <?php
                            }else{
                        ?>
                        <td></td>
                        <td></td>
                        <?php
                            }
                        ?>
                        <td><?=$value->deskripsi?></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">Rp. <?=formatRupiah($v->jumlah)?></td>
                        <td></td>
                        <td class="text-right">Rp. <?=formatRupiah($v->jumlah)?></td>
                        <?php
                        }else if ($v->id_akun == 67){
                            $total_atk+=$v->jumlah;
                            $total+=$v->jumlah;
                            if ($key == 0) {
                        ?>
                        <td><?=$a?></td>
                        <td><?=formatDate($value->tanggal)?></td>
                        <?php
                            }else{
                        ?>
                        <td></td>
                        <td></td>
                        <?php
                            }
                        ?>
                        <td><?=$value->deskripsi?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">Rp. <?=formatRupiah($v->jumlah)?></td>
                        <td class="text-right">Rp. <?=formatRupiah($v->jumlah)?></td>
                        <?php
                        }
                        ?>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                    <?php
                        if ($detail != null) {
                    ?>
                    <tr>
                        <th colspan="3" class="text-center">Total</th>
                        <th class="text-right">Rp. <?=formatRupiah($total_pc)?></th>
                        <th class="text-right">Rp. <?=formatRupiah($total_rt)?></th>
                        <th class="text-right">Rp. <?=formatRupiah($total_kasbon)?></th>
                        <th class="text-right">Rp. <?=formatRupiah($total_atk)?></th>
                        <th class="text-right">Rp. <?=formatRupiah($total)?></th>
                    </tr>
                    <?php
                        $subtotal_rt+=$total_rt;
                        $subtotal_pc+=$total_pc;
                        $subtotal_kasbon+=$total_kasbon;
                        $subtotal_atk+=$total_atk;
                        $subtotal_all+=$total;
                        }
                    ?>
                    <?php
                    }
                ?>
                <tr style="background-color:#3c8dbc; color:white">
                    <th colspan="3" class="text-center">Total Pengeluaran Ahir</th>
                    <th class="text-right">Rp. <?=formatRupiah($subtotal_pc)?></th>
                    <th class="text-right">Rp. <?=formatRupiah($subtotal_rt)?></th>
                    <th class="text-right">Rp. <?=formatRupiah($subtotal_kasbon)?></th>
                    <th class="text-right">Rp. <?=formatRupiah($subtotal_atk)?></th>
                    <th class="text-right">Rp. <?=formatRupiah($subtotal_all)?></th>
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
    $('#bulan').html('Laporan Minggu ke-<?=$minggu?> Bulan '+formatBulan(bulan));
    function formatBulan(val){
        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        var getMonth=val[1];
        return bulan[getMonth-1]+' '+val[0];
    }
</script>