<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">BUKU KAS PENGELUARAN PETTY CASH</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
        <?php
            function formatCurrency($val){
                return number_format($val, 0, '.', '.');
            }
            function formatDate($date){
                $date=date_create($date);
                return date_format($date, 'd-m-Y');
            }
        ?>
        <div class="table-responsive">
            
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Bukti</th>
                    <th>Keterangan</th>
                    <th>Kode</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $saldo=$kredit=$debit=0;
                foreach ($data=$this->Akuntansi_model->rekapPettyCash($date) as $key => $value) {
                    $a=$key+1;
                ?>
                <tr>
                    <td><?=$a?></td>
                    <td><?=formatDate($value->tanggal)?></td>
                    <td></td>
                    <td><?=$value->deskripsi?></td>
                    <td><?=$value->nama_akun?></td>
                    <?php
                    if($value->tipe == 'DEBIT' && $value->id_akun == 35){
                        $saldo+=$value->jumlah;
                        $debit+=$value->jumlah;
                    ?>
                    <td class="text-right">Rp. <?=formatCurrency($value->jumlah)?></td>
                    <td class="text-right">-</td>
                    <?php
                    }else{
                        $saldo-=$value->jumlah;
                        $kredit+=$value->jumlah;
                    ?>
                    <td class="text-right">-</td>
                    <td class="text-right">Rp. <?=formatCurrency($value->jumlah)?></td>
                    <?php
                    }
                    ?>
                    <td class="text-right">Rp. <?=formatCurrency($saldo)?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
            <tbody style="background-color:#3c8dbc; color:white">
                <th colspan="5"></th>
                <th class="text-right">Rp. <?=formatCurrency($debit)?></th>
                <th class="text-right">Rp. <?=formatCurrency($kredit)?></th>
                <th class="text-right">Rp. <?=formatCurrency($saldo)?></th>
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