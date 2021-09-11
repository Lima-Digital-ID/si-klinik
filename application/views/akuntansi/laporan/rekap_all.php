<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">REKAP LAPORAN PENGELUARAN</h3>
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
        <h4 class="box-title" id="bulan"></h4>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr id="table">
                    <th>No</th>
                    <th>Rincian</th>
                    <th>Golongan</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $saldo=0;
                foreach ($data=$this->Akuntansi_model->rekap_all($date) as $key => $value) {
                    $a=$key+1;
                    $saldo+=$value->jumlah;
                ?>
                <tr>
                    <td><?=$a?></td>
                    <td><?=$value->rincian?></td>
                    <td><?=$value->nama_akun?></td>
                    <td class="text-right">Rp. <?=formatCurrency($value->jumlah)?></td>
                    <td></td>
                </tr>
                <?php
                }
                ?>
                <tr id="table">
                    <th class="text-center" colspan="3">Total</th>
                    <th class="text-center"> Rp. <?=formatCurrency($saldo)?></th>
                    <th></th>
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
        console.log(bulan);
        $('#bulan').html('Bulan '+formatBulan(bulan));
        function formatBulan(val){
            var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            var getMonth=val[1];
            return bulan[getMonth-1]+' '+val[0];
        }
        </script>
        <style type="text/css">
        #table{
            background-color:#3c8dbc; color:white
        }
        </style>