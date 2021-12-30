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
                            <form action="<?=current_url()?>" method="get">
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
                                        <?php 
                                        $starting_year  = 2017;
                                        $current_year = date("Y") * 1;
                                        echo '<select class="form-control select2" name="tahun" required>';
                                        echo '<option value="">--Pilih Tahun--</option>';
                                        do {
                                            echo '<option value="'.$starting_year.'">'.$starting_year.'</option>';
                                            $starting_year++;
                                        }
                                        while ($current_year >= $starting_year);
                                        echo '</select>';
                                    ?>
                                        <button class="btn btn-primary"  onclick="cekAbsensiDate()"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                                <br>
                            </form>
                        </div>
                <?php
                $param = isset($_GET['bulan']) ? "?bulan=$_GET[bulan]&tahun=$_GET[tahun]" : '';
                ?>
                <a href="<?= base_url()."akuntansi/laporan/laba_rugi/export$param" ?>" class="btn btn-success"><span class="fa fa-file-excel-o"></span> Export</a>
                <h4 class="box-title" id="bulan"></h4>
                <?php 
                    $this->load->view('akuntansi/laporan/table_report_profit_loss')
                ?>
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