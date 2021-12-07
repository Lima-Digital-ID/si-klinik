<center>
    <h4 id="bulan">Neraca Saldo Bulan <?= tglIndo($date) ?></h4>
</center>
<table width="100%" border="1">
    <tr>
        <th rowspan="2">No Akun</th>
        <th rowspan="2">Nama Akun</th>
        <th colspan="2">Saldo</th>
    </tr>
    <tr>
        <th>Debit</th>
        <th>Kredit</th>
    </tr>
    <?php 
    function formatRupiah($num){
        return number_format($num, 0, '.', '.');
    }
    function tglIndo($date){
        $ex = explode('-',$date);
        $bulan = ['','Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        return $bulan[$ex[1]]." ".$ex[0];
    }

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
</table>
