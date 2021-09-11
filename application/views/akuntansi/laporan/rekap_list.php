<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">BUKU KAS KECIL</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
        <?php
            function bulan($date){
                $bulan = ['Jan', 'Feb', 'Mar','Apr','Mei','Juni','Juli','Agust','Sept','Okt','Nov','Des'];
                return $bulan[$date-1];
            }
            function formatCurrency($val){
                return number_format($val, 0, '.', '.');
            }
        ?>
        <div class="table-responsive">
            
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="7" class="text-center">Rincian Pengeluaran</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Minggu</th>
                    <th>Petty Cash</th>
                    <th>Rumah Tangga</th>
                    <th>Kasbon</th>
                    <th>ATK</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total=0;
                $minggu=['Minggu Pertama', 'Minggu Kedua', 'Minggu Ketiga', 'Minggu Keempat'];
                $label=['minggu1', 'minggu2', 'minggu3', 'minggu4'];
                for ($i=0; $i < 4; $i++) { 
                    $a=$i+1;
                    $cekLabel=$label[$i];
                    $total+=$rekap[0]->$cekLabel+$rekap[1]->$cekLabel+$rekap[2]->$cekLabel+$rekap[3]->$cekLabel;
                ?>
                <tr>
                    <td><?=$a?></td>
                    <td><?=$minggu[$i]?></td>
                    <td>Rp. <?=formatCurrency($rekap[0]->$cekLabel)?></td>
                    <td>Rp. <?=formatCurrency($rekap[1]->$cekLabel)?></td>
                    <td>Rp. <?=formatCurrency($rekap[2]->$cekLabel)?></td>
                    <td>Rp. <?=formatCurrency($rekap[3]->$cekLabel)?></td>
                    <td>Rp. <?=formatCurrency($rekap[0]->$cekLabel+$rekap[1]->$cekLabel+$rekap[2]->$cekLabel+$rekap[3]->$cekLabel)?></td>
                </tr>
                <?php
                }
                ?>
                <?php
                    $petty=$rt=$kasbon=$atk=0;
                    foreach ($rekap as $key => $value) {
                        if ($value->id_akun == 35) {
                            $petty=$value->minggu1+$value->minggu2+$value->minggu3+$value->minggu4;
                        }else if ($value->id_akun == 36) {
                            $rt=$value->minggu1+$value->minggu2+$value->minggu3+$value->minggu4;
                        }else if ($value->id_akun == 66) {
                            $kasbon=$value->minggu1+$value->minggu2+$value->minggu3+$value->minggu4;
                        }else{
                            $atk=$value->minggu1+$value->minggu2+$value->minggu3+$value->minggu4;
                        }
                    }
                ?>
                <tr style="background-color:#3c8dbc; color:white">
                    <td colspan="2"></td>
                    <td>Rp. <?=formatCurrency($petty)?></td>
                    <td>Rp. <?=formatCurrency($rt)?></td>
                    <td>Rp. <?=formatCurrency($kasbon)?></td>
                    <td>Rp. <?=formatCurrency($atk)?></td>
                    <td>Rp. <?=formatCurrency($total)?></td>
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