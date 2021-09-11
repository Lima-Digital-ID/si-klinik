<div class="content-wrapper">
    <section class="content">
        <div class="row">
        <div class="col-md-12">
            <?php 
            if($this->session->flashdata('message')){
                if($this->session->flashdata('message_type') == 'danger')
                    echo alert('alert-danger', 'Perhatian', $this->session->flashdata('message'));
                else if($this->session->flashdata('message_type') == 'success')
                    echo alert('alert-success', 'Sukses', $this->session->flashdata('message')); 
                else
                    echo alert('alert-info', 'Info', $this->session->flashdata('message')); 
            }
            ?>
            </div>
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">Detail Buku Besar</h3>
                    </div>
        
                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                            <form action="<?=current_url()?>" method="post">
                            <div class="row">                                
                                <!-- <div class="col-sm-12">
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
                                </div> -->
                            </div>
                                <br>
                            </form>
                        </div>
                    <?php
                    function formatTanggal($time){
                        $tanggal=date_create($time);
                        return date_format($tanggal, 'd-m-Y');
                    }
                        $saldo=($data_saldo != null ? $data_saldo->jumlah_saldo : 0);
                    ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">Tanggal</th>
                                <th colspan="2" class="text-center">Akun <?=$akun->no_akun. ' '. $akun->nama_akun?></th>
                                <th rowspan="2" class="text-center">Saldo</th>
                            </tr>
                            <tr>
                                <th class="text-center">Debit</th>
                                <th class="text-center">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- <td><?=($data_saldo != null ? formatTanggal($data_saldo->tanggal) : '')?></td> -->
                                <td></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"><?= 'Rp. '.number_format($saldo, 0, '.', '.')?></td>
                            </tr>
                        <?php 
                        foreach ($data as $key => $value) {
                            if ($akun->sifat_debit == 1) {
                                $saldo+=$value->jumlah_debit;
                                $saldo-=$value->jumlah_kredit;
                            }else{
                                $saldo-=$value->jumlah_debit;
                                $saldo+=$value->jumlah_kredit;
                            }
                        ?>
                            <tr>
                                <td>
                                <form action="<?=site_url('akuntansi/transaksi_akuntansi')?>" method="post">
                                <?=formatTanggal($value->tanggal)?>
                                    <input type="hidden" name="date" value="<?=$value->tanggal?>">
                                    <button class="btn btn-sm btn-default"><i class="fa fa-external-link"></i></button>
                                </form>
                                </td>
                                <td class="text-right"><?=($value->jumlah_debit != 0 ? 'Rp. '.number_format($value->jumlah_debit, 0, '.', '.') : '-')?></td>
                                <td class="text-right"><?=($value->jumlah_kredit != 0 ? 'Rp. '.number_format($value->jumlah_kredit, 0, '.', '.') : '-')?></td>
                                <td class="text-right"><?= 'Rp. '.number_format($saldo, 0, '.', '.')?></td>
                            </tr>
                        <?php 
                        }
                        ?>
                        </tbody>
                    </table>
                    <!-- <br>
                    <form action="<?=site_url('akuntansi/akun/tutup_buku')?>" method="post">
                        <input type="" value="<?=$saldo?>" name="saldo">
                        <input type="" value="<?=$akun->id_akun?>" name="id_akun">
                        <input type="" value="<?=date('Y-m')?>" name="tanggal">
                        <button class="btn btn-success">Tutup Buku</button>
                    </form> -->
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

</script> 
