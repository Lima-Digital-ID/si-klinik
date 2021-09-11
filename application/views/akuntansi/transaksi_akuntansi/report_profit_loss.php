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
                            <form action="<?=current_url()?>" method="post">
                            <div class="row">
                                <div class="col-sm-2">    
                                <?php echo anchor(site_url('akuntansi/transaksi_akuntansi/create_pc'), '<i class="fa fa-plus" aria-hidden="true"></i> Tambah Jurnal Manual', 'class="btn btn-info btn-sm"'); ?>
                                </div>
                                
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
                                            <option value="">--Pilih Tahun--</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                        </select>
                                        <button class="btn btn-primary"  onclick="cekAbsensiDate()"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                                <br>
                            </form>
                        </div>
        <!-- <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
        		    <th width="150px">Action</th>
                </tr>
            </thead>
	    
        </table> -->
        <?php
        function formatRupiah($num){
            return number_format($num, 0, '.', '.');
        }
        function formatDate($date){
            $date=date_create($date);
            return date_format($date, 'd-m-Y');
        }
        ?>
                    <h4 id="titleJurnal">Jurnal Umum Bulan November 2019</h4>
                    <table class="table table-bordered table-striped" id="detailKas">
                        <thead>
                            <tr>
                                <th width="100px">Tanggal</th>
                                <th>Keterangan</th>
                                <th>Reff</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                    </table>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <h3>Detail Kas</h3>
        <!-- <table class="table table-bordered table-striped" id="detailKas">
            <thead>
                <tr>
                    <th width="100px">Tanggal</th>
                    <th>Keterangan</th>
                    <th>Reff</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                </tr>
            </thead>
        </table> -->
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
  </div>
  </div>
</div>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">

    var bulan=<?=$bulan?>;
    $('#titleJurnal').html('Jurnal Umum Bulan '+formatBulan(bulan));
    function formatBulan(val){
        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        var getMonth=val[1];
        return bulan[getMonth-1]+' '+val[0];
    }
    function formatDate(date){
        var myDate = new Date(date);
        var output = myDate.getDate() + "-" +  (myDate.getMonth()+1) + "-" + myDate.getFullYear();
        return output;
    }
    function formatRupiah(angka, prefix)
      {
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
      }
</script> 
