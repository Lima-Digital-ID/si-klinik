<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">LAPORAN BIAYA TINDAKAN</h3>
                    </div>

                    <div class="box-body">
                        <?php  echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-bayar')); ?>
                        <div class="form-group">
							<div class="col-sm-2"><label>Rekapitulasi Laporan</label></div>
							<div class="col-sm-4"><?php echo form_dropdown('rekap_laporan', array(''=>'Pilih Rekapitulasi Laporan','1'=>'Harian','2'=>'Bulanan','3'=>'Tahunan'),$rekap_laporan,array('id'=>'rekap_laporan','class'=>'form-control','onchange'=>'show()'));?></div>
                        </div>
                        <div class="form-group" id="div_klinik">
							<div class="col-sm-2"><label>Pilih Klinik <?php echo form_error('id_klinik'); ?></label></div>
							<div class="col-sm-4"><?php echo cmb_dinamis('id_klinik', 'tbl_klinik', 'nama', 'id_klinik', $id_klinik) ?></div>
                        </div>
                        <div class="form-group" id="div_tahun" style="display:none;">
							<div class="col-sm-2"><label>Pilih Tahun</label></div>
							<div class="col-sm-4"><?php echo form_dropdown('tahun',$option_tahun,$filter_tahun != null ? $filter_tahun : date('Y'),array('id'=>'tahun','class'=>'form-control'));?></div>
                        </div>
                        <div class="form-group" id="div_bulan" style="display:none;">
							<div class="col-sm-2"><label>Pilih Bulan</label></div>
							<div class="col-sm-4"><?php echo form_dropdown('bulan', array('1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'),$filter_bulan,array('id'=>'bulan','class'=>'form-control'));?></div>
                        </div>
                        <div class="form-group" id="div_tanggal" style="display:none;">
							<div class="col-sm-2"><label>Pilih Tanggal</label></div>
							<div class="col-sm-4"><input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $filter_tanggal != null ? $filter_tanggal : date('Y-m-d', time() + (12*60*60)); ?>" /></div>
                        </div>
                        <div class="form-group" id="div_tombol" style="display:none;">
							<div class="col-sm-2"></div>
							<div class="col-sm-4"><div align="right"><button type="submit" class="btn btn-danger"><i class="fa fa-search"></i> Tampilkan</button></div></div>
                        </div>
                        <?php echo form_close();?>
<?php 
if($id_klinik != ''){
    if($rekap_laporan != null || $rekap_laporan != ''){
        if($rekap_laporan == 1){
            $filters = $rekap_laporan.'_'.$filter_tanggal.'_'.$id_klinik;
        } else if($rekap_laporan == 2){
            $filters = $rekap_laporan.'_'.$filter_bulan.'_'.$id_klinik;
        } else if($rekap_laporan == 3){
            $filters = $rekap_laporan.'_'.$filter_tahun.'_'.$id_klinik;
        }
?>
                        <hr />
                        <div style="padding-bottom: 10px;">
                		<?php //echo anchor(site_url('laporankeuangan/excel/'.$filters), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
                		<?php // echo anchor(site_url('laporankeuangan/pdf'), '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Export PDF', 'class="btn btn-danger btn-sm"'); ?></div>
                        <div style="padding-bottom: 10px;">
                        </div>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Klinik</th>
                                    <th>No Transaksi</th>
                                    <th>Deskripsi Transaksi</th>
                                    <th>Nominal Transaksi</th>
                                    <!-- <th>Debit</th>
                                    <th>Credit</th> -->
                                </tr>
                            </thead>
                        </table>
<?php
    }
}
?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>

<?php 
if($rekap_laporan != null || $rekap_laporan != ''){
?>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
//         $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
//         {
//             return {
//                 "iStart": oSettings._iDisplayStart,
//                 "iEnd": oSettings.fnDisplayEnd(),
//                 "iLength": oSettings._iDisplayLength,
//                 "iTotal": oSettings.fnRecordsTotal(),
//                 "iFilteredTotal": oSettings.fnRecordsDisplay(),
//                 "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
//                 "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
//             };
//         };

//         var t = $("#mytable").dataTable({
//             initComplete: function() {
//                 var api = this.api();
//                 $('#mytable_filter input')
//                 .off('.DT')
//                 .on('keyup.DT', function(e) {
//                     if (e.keyCode == 13) {
//                         api.search(this.value).draw();
//                     }
//                 });
//             },
//             oLanguage: {
//                 sProcessing: "loading..."
//             },
//             processing: true,
//             serverSide: true,
// <?php
// if($id_klinik != ''){
//     if($rekap_laporan == 1){
// ?>
//             ajax: {"url": "json_biaya_tindakan/<?php echo $rekap_laporan.'_'.$filter_tanggal.'_'.$id_klinik;?>", "type": "POST"},
// <?php
//     } else if ($rekap_laporan == 2) {
// ?>
//             ajax: {"url": "json_biaya_tindakan/<?php echo $rekap_laporan.'_'.$filter_bulan.'_'.$id_klinik;?>", "type": "POST"},
// <?php
//     } else if ($rekap_laporan == 3) {
// ?>
//             ajax: {"url": "json_biaya_tindakan/<?php echo $rekap_laporan.'_'.$filter_tahun.'_'.$id_klinik;?>", "type": "POST"},
// <?php
//     }
// }
// ?>
//             columns: [
//                 {
//                     "data": "id_transaksi",
//                     "orderable": false
//                 },{"data": "tgl_transaksi"},{"data": "klinik"},{"data": "no_transaksi"},{"data": "deskripsi"},{"data": "amount_transaksi","className":"text-right"},{"data": "debit","className":"text-right"},
//                 {
//                     "data" : "credit","className":"text-right"
//                 }
//             ],
//             order: [[1, 'asc']],
//             rowCallback: function(row, data, iDisplayIndex) {
//                 var info = this.fnPagingInfo();
//                 var page = info.iPage;
//                 var length = info.iLength;
//                 var index = page * length + (iDisplayIndex + 1);
//                 $('td:eq(0)', row).html(index);
//             }
//         });

        $('#mytable td').remove();
<?php
if($id_klinik != ''){
    if($rekap_laporan == 1){
?>
            // ajax: {"url": "json_biaya_tindakan/<?php echo $rekap_laporan.'_'.$filter_tanggal.'_'.$id_klinik;?>", "type": "POST"},
            $.ajax({
                type: "POST",
                url: "json_biaya_tindakan/<?php echo $rekap_laporan.'_'.$filter_tanggal.'_'.$id_klinik;?>", //json get site
                dataType : 'json',
<?php
    } else if ($rekap_laporan == 2) {
?>
            $.ajax({
                type: "POST",
                url: "json_biaya_tindakan/<?php echo $rekap_laporan.'_'.$filter_bulan.'_'.$id_klinik;?>", //json get site
                dataType : 'json',
            // ajax: {"url": "json_biaya_tindakan/<?php echo $rekap_laporan.'_'.$filter_bulan.'_'.$id_klinik;?>", "type": "POST"},
<?php
    } else if ($rekap_laporan == 3) {
?>          
            $.ajax({
                type: "POST",
                url: "json_biaya_tindakan/<?php echo $rekap_laporan.'_'.$filter_tahun.'_'.$id_klinik;?>", //json get site
                dataType : 'json',
            // ajax: {"url": "json_biaya_tindakan/<?php echo $rekap_laporan.'_'.$filter_tahun.'_'.$id_klinik;?>", "type": "POST"},
<?php
    }
}
?>
        // $.ajax({
        //     type: "GET",
        //     url: "<?=base_url('akuntansi/transaksi_akuntansi/getDetailKas/')?>"+id, //json get site
        //     dataType : 'json',
            success: function(response){
                arrData = response['data'];
                console.log(response);
                var total=0;
                for(i = 0; i < arrData.length; i++){
                    var table=    '<tr><td><div class="">'+arrData[i]['id_transaksi']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['tgl_transaksi']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['klinik']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['no_transaksi']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['deskripsi']+'</div></td>'+
                        '<td><div class="text-left">Rp. '+formatRupiah(arrData[i]['amount_transaksi'])+'</div></td></tr>';
                    $('#mytable').append(table);
                    total+=parseInt(arrData[i]['amount_transaksi']);
                }
                var table=    '<tr><td colspan="5"><div class="text-center"><b>TOTAL</b></div></td>'+
                            '<td><div class="text-left"><b>Rp. '+formatRupiah(total)+'</b></div></td></tr>';
                        $('#mytable').append(table);
            }
        });
        
    });
    
</script>
<?php
}
?>

<script type="text/javascript">
    function formatRupiah(angka, prefix)
      {
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
      }

    $(document).ready(function() {
        show();
    });
    
    function show(){
        var rekap_laporan = $('#rekap_laporan').val();
        // alert(rekap_laporan);
        if(rekap_laporan != ''){
            if(rekap_laporan == 1){
                document.getElementById("div_tanggal").style.display="block";
                document.getElementById("div_bulan").style.display="none";
                document.getElementById("div_tahun").style.display="none";
            } else if(rekap_laporan == 2){
                document.getElementById("div_tanggal").style.display="none";
                document.getElementById("div_bulan").style.display="block";
                document.getElementById("div_tahun").style.display="none";
            } else if(rekap_laporan == 3){
                document.getElementById("div_tanggal").style.display="none";
                document.getElementById("div_bulan").style.display="none";
                document.getElementById("div_tahun").style.display="block";
            }
            document.getElementById("div_tombol").style.display="block";
            document.getElementById("div_klinik").style.display="block";
        } else {
            document.getElementById("div_tanggal").style.display="none";
            document.getElementById("div_bulan").style.display="none";
            document.getElementById("div_tahun").style.display="none";
            document.getElementById("div_tombol").style.display="none";
            document.getElementById("div_klinik").style.display="none";
        }
            
    }

</script>