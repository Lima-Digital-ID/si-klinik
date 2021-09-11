<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">BUKU KAS</h3>
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
                    <th>No</th>
                    <th>No Akun</th>
                    <th>Keterangan</th>
                    <th>No. Cek</th>
            <?php
                for ($i=1; $i <= $jumlah_hari; $i++) { 
            ?>
                 <th style="min-width:110px" class="text-center"><?=(strlen($i) == 1 ? '0'.$i : $i).'-'.$bulan.'-'.$tahun?></th>   
            <?php
                }
            ?>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color:#3c8dbc; color:white">
                    <th></th>
                    <th></th>
                    <th>
                    Pemasukan
                    </th>
                    <td></td>
                    <td colspan="<?=$jumlah_hari?>"></td>
                </tr>
                <?php
                    for ($j=0; $j < count($akun_asset); $j++) { 
                        $a=$j+1;
                ?>
                <tr>
                    <td><?=$a?></td>
                    <td><?=$akun_asset[$j]['no_akun']?></td>
                    <td><?=$akun_asset[$j]['nama_akun']?></td>
                    <td></td>
                    <?php
                        for ($i=1; $i <= $jumlah_hari; $i++) { 
                            $date=$tahun.'-'.$bulan.'-'.$i;
                            $id_akun=$akun_asset[$j]['id_akun'];
                            $query=$this->db->query('SELECT SUM(jumlah) as jumlah FROM `tbl_trx_akuntansi` 
                                JOIN tbl_trx_akuntansi_detail ON tbl_trx_akuntansi.id_trx_akun=tbl_trx_akuntansi_detail.id_trx_akun 
                                WHERE tbl_trx_akuntansi.tanggal="'.$date.'" AND tbl_trx_akuntansi_detail.id_akun="'.$id_akun.'" AND tbl_trx_akuntansi_detail.tipe="DEBIT"')->row();
                    ?>
                    <td class="text-right"><?=( $query->jumlah != null ? 'Rp. '.formatCurrency($query->jumlah) : '')?></td>
                <?php
                        }
                    }
                ?>
                </tr>
                <tr>
                    <th colspan="4" class="text-center">Total Pemasukan per Hari</th>
                <?php
                    for ($i=1; $i <= $jumlah_hari; $i++) { 
                        $total=0;
                        $date=$tahun.'-'.$bulan.'-'.$i;
                        for ($j=0; $j < count($akun_asset); $j++) { 
                            $id_akun=$akun_asset[$j]['id_akun'];
                            $query=$this->db->query('SELECT SUM(jumlah) as jumlah FROM `tbl_trx_akuntansi` JOIN tbl_trx_akuntansi_detail 
                                ON tbl_trx_akuntansi.id_trx_akun=tbl_trx_akuntansi_detail.id_trx_akun WHERE 
                                tbl_trx_akuntansi.tanggal="'.$date.'" AND tbl_trx_akuntansi_detail.id_akun="'.$id_akun.'" AND tbl_trx_akuntansi_detail.tipe="DEBIT"')->row();
                            $total+=$query->jumlah;
                        }
                ?>
                <th class="text-right"><?=( $total != 0 ? 'Rp. '.formatCurrency($total) : '')?></th>
                <?php
                    }
                ?>
                </tr>
                <tr style="background-color:#3c8dbc; color:white">
                    <th></th>
                    <th></th>
                    <th>
                    Pengeluaran
                    </th>
                    <td></td>
                    <td colspan="<?=$jumlah_hari?>"></td>
                </tr>
                <?php
                    $temp=array();
                    foreach ($akun_pengeluaran as $key => $value) {
                        $a=$key+1;
                ?>
                <tr>
                    <td><?=$a?></td>
                    <td><?=$value->no_akun?></td>
                    <td><?=$value->nama_akun?></td>
                    <td></td>
                    <?php
                        for ($i=1; $i <= $jumlah_hari; $i++) { 
                            $date=$tahun.'-'.$bulan.'-'.$i;
                            $query=$this->db->query('SELECT SUM(jumlah) as jumlah FROM `tbl_trx_akuntansi` JOIN tbl_trx_akuntansi_detail 
                                ON tbl_trx_akuntansi.id_trx_akun=tbl_trx_akuntansi_detail.id_trx_akun WHERE 
                                tbl_trx_akuntansi.tanggal="'.$date.'" AND tbl_trx_akuntansi_detail.id_akun="'.$value->id_akun.'" AND tbl_trx_akuntansi_detail.tipe="DEBIT"')->row();
                    ?>
                    <td class="text-right"><?=( $query->jumlah != null ? 'Rp. '.formatCurrency($query->jumlah) : '')?></td>
                <?php
                        }
                    }
                ?>
                </tr>
                <tr>
                    <th colspan="4" class="text-center">Total Pengeluaran per Hari</th>
                <?php
                    for ($i=1; $i <= $jumlah_hari; $i++) { 
                        $date=$tahun.'-'.$bulan.'-'.$i;
                        $query=$this->db->query('SELECT SUM(jumlah) as jumlah FROM `tbl_trx_akuntansi` JOIN tbl_trx_akuntansi_detail 
                            ON tbl_trx_akuntansi.id_trx_akun=tbl_trx_akuntansi_detail.id_trx_akun WHERE 
                            tbl_trx_akuntansi.tanggal="'.$date.'" AND tbl_trx_akuntansi_detail.id_akun IN (SELECT id_akun FROM tbl_akun_detail WHERE id_parent=7) AND tbl_trx_akuntansi_detail.tipe="DEBIT"')->row();
                ?>
                <th class="text-right"><?=( $query->jumlah != null ? 'Rp. '.formatCurrency($query->jumlah) : '')?></th>
                <?php
                    }
                ?>
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