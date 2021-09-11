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
                        <h3 class="box-title">Tutup Buku</h3>
                    </div>
        
                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                            <form action="<?=base_url('akuntansi/transaksi_akuntansi/tutup_buku')?>" method="post">
                            <div class="row">                                
                                <div class="col-sm-12">
                                    <div class="form-inline">
                                        <label>Pilih Bulan : </label>
                                        <select class="form-control select2" name="bulan" required id="bulan">
                                            <option value="">--Pilih Bulan--</option>
                                            <option value="01">Januari</option>
                                            <option value="02">Februari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                        <select class="form-control select2" name="tahun" required id="tahun">
                                            <option value="">--Pilih Tahun--</option>
                                            <?php
                                                for ($i=3; $i >= 0; $i--) { 
                                                    $temp=$tahun-$i;
                                            ?>
                                            <option value="<?=$temp?>"><?=$temp?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                        <button class="btn btn-primary"  onclick="cekAbsensiDate()"><i class="fa fa-save"></i></button>
                                    </div>
                                </div>
                            </div>
                                <br>
                            </form>
                        </div>
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
$('#bulan').val('<?=$bulan?>');
$('#tahun').val('<?=$tahun?>');
</script> 
