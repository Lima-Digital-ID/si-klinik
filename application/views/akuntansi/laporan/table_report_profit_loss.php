<?php 
                function formatRupiah($num){
                    return number_format($num, 0, '.', '.');
                }
                function formatDate($date){
                    $date=date_create($date);
                    return date_format($date, 'd-m-Y');
                }

?>
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
                                if ($value->id_akun == 46 || $value->id_akun == 64 || $value->id_akun == 69){
                                    $total=$value->jumlah_debit-$value->jumlah_kredit;  
                                    $sum_pendapatan-=$total;
                            ?>
                                    <td><?=$value->nama_akun?></td>
                                    <td align="right">- Rp. <?=formatRupiah($total)?></td>
                                <?php
                                } else{
                                    $total=$value->jumlah_kredit-$value->jumlah_debit;
                                    $sum_pendapatan+=$total;
                                ?>
                                    <td><?=$value->nama_akun?></td>
                                    <td align="right">Rp. <?=formatRupiah($total)?></td>
                                <?php } ?>
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
