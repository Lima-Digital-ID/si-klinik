<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">JURNAL RUMAH TANGGA</h3>
                    </div>
        
                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                            <form action="<?=current_url()?>" method="post">
                            <div class="row">
                                <div class="col-sm-2">    
                                <?php echo anchor(site_url('akuntansi/transaksi_akuntansi/create_rt'), '<i class="fa fa-plus" aria-hidden="true"></i> Tambah Jurnal Manual', 'class="btn btn-info btn-sm"'); ?>
                                </div>
                                
                                <div class="col-sm-9" align="right">
                                    <div class="form-inline">
                                        <label>Pilih Tanggal : </label>
                                        <input type="date" name="date" class="form-control">
                                        <button class="btn btn-primary"><i class="fa fa-search"></i></button>
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
                    <table class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th width="100px">Tanggal</th>
                                <th>Keterangan</th>
                                <th>Reff</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        <?php
                        // print_r($data);
                        // exit();
                            foreach ($data as $key => $value) {
                            $detail=($this->Transaksi_akuntansi_model->getDetailKas($value->id_trx_akun));
                                foreach ($detail as $k => $v) {
                                    if ($k == 0) {
                        ?>
                            <tr style="background-color:#3c8dbc; color:white">
                            <td><div class=""><?=formatDate($v->tanggal)?></div></td>
                            <td><div class=""><?=$v->nama_akun?></div></td>
                            <td><div class="text-left"><?=$v->no_akun?></div></td>
                        <?php   
                                        if ($v->tipe == 'KREDIT') {
                        ?>
                            <td><div class="text-left"></div></td>
                            <td><div class="text-left">Rp. <?=formatRupiah($v->jumlah)?></div></td></tr>
                        <?php
                                        }else{
                        ?>
                            <td><div class="text-left">Rp. <?=formatRupiah($v->jumlah)?></div></td>
                            <td><div class="text-left"></div></td></tr>
                        <?php
                                        }
                                    }else{
                                        if ($v->keterangan == 'akun') {
                        ?>
                            <tr>
                            <td><div class="text-center"></div></td>
                            <td><div class="text-left"><?=$v->nama_akun?></div></td>
                            <td><div class="text-left"><?=$v->no_akun?></div></td>
                        <?php
                                        }else{
                        ?>
                            <tr>
                            <td><div class="text-center"></div></td>
                            <td><div class="text-center"><?=$v->nama_akun?></div></td>
                            <td><div class="text-left"><?=$v->no_akun?></div></td>
                        <?php
                                        }
                                        if ($v->tipe == 'KREDIT') {
                        ?>
                            <td><div class="text-left"></div></td>
                            <td><div class="text-left">Rp. <?=formatRupiah($v->jumlah)?></div></td></tr>
                        <?php
                                        }else{
                        ?>
                            <td><div class="text-left">Rp. <?=formatRupiah($v->jumlah)?></div></td>
                            <td><div class="text-left"></div></td></tr>
                        <?php
                                        }
                        ?>

                        <?php 
                                    }
                        ?>
                        <?php 
                                }   
                        ?>
                        <tr>
                            <td><div class="text-center"></div></td>
                            <td><div class="text-left"><strong>(<?=$v->deskripsi?>)</strong></div></td>
                            <td><div class="text-left"></div></td>
                            <td><div class="text-left"></div></td>
                            <td><div class="text-left"></div></td>
                        </tr>
                        <?php
                            }
                        ?>
                        </tbody>
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
$(document).ready(function() {
            //     $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
            //     {
            //         return {
            //             "iStart": oSettings._iDisplayStart,
            //             "iEnd": oSettings.fnDisplayEnd(),
            //             "iLength": oSettings._iDisplayLength,
            //             "iTotal": oSettings.fnRecordsTotal(),
            //             "iFilteredTotal": oSettings.fnRecordsDisplay(),
            //             "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            //             "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            //         };
            //     };

            //     var t = $("#mytable").dataTable({
            //         initComplete: function() {
            //             var api = this.api();
            //             $('#mytable_filter input')
            //                     .off('.DT')
            //                     .on('keyup.DT', function(e) {
            //                         if (e.keyCode == 13) {
            //                             api.search(this.value).draw();
            //                 }
            //             });
            //         },
            //         oLanguage: {
            //             sProcessing: "loading..."
            //         },
            //         processing: true,
            //         serverSide: true,
            //         ajax: {"url": "transaksi_akuntansi/json", "type": "POST"},
            //         columns: [
            //             {
            //                 "data": "id_trx_akun",
            //                 "orderable": true
            //             },{"data": "deskripsi"},{"render": function(data, type, row){
            //                 return formatDate(row.tanggal);
            //             }},
            //             {
            //                 "data" : "action",
            //                 "orderable": false,
            //                 "className" : "text-center"
            //             }
            //         ],
            //         order: [[0, 'desc']],
            //         rowCallback: function(row, data, iDisplayIndex) {
            //             var info = this.fnPagingInfo();
            //             var page = info.iPage;
            //             var length = info.iLength;
            //             var index = page * length + (iDisplayIndex + 1);
            //             $('td:eq(0)', row).html(index);
            //         }
            //     });
                // t = $('#mytable').DataTable();
                // t.clear().draw(false);
                // $.ajax({
                //     type: "GET",
                //     url: "transaksi_akuntansi/json", //json get site
                //     dataType : 'json',
                //     success: function(response){
                //         console.log(response['data']);
                //         arrData = response['data'];
                //         var j=0;
                //         for(i = 0; i < arrData.length; i++){
                //             j+=1;
                //             t.row.add([
                //                 '<div class="text-center">'+j+'</div>',
                //                 '<div class="text-left">'+arrData[i]['no_akun']+'</div>',
                //                 '<div class="text-left">'+arrData[i]['nama_akun']+'</div>',
                //                 '<div class="text-left">'+arrData[i]['level']+'</div>',
                //                 '<div class="text-left">'+arrData[i]['main']+'</div>',
                //                 '<div class="text-center">'+
                //                 '<a href="<?=site_url('akuntansi/akun/update/')?>'+arrData[i]['id_akun']+'" class="btn waves-effect waves-light btn-xs btn-success"><i class="fa fa-edit"></i></a> '+
                //                 '<a href="<?=site_url('akuntansi/akun/delete/')?>'+arrData[i]['id_akun']+'" class="btn waves-effect waves-light btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"><i class="fa fa-trash"></i></a>'+
                //                 '</div>'
                //             ]).draw(false);
                //         }
                //     }
                // });
            <?php
                foreach ($data as $key => $value) {
            ?>
            var id=<?=$value->id_trx_akun?>;
            $.ajax({
            type: "GET",
            url: "<?=base_url('akuntansi/transaksi_akuntansi/getDetailKas/')?>"+id, //json get site
            dataType : 'json',
            success: function(response){
                arrData = response;
                // console.log(response);
                var total_kredit=0;
                var total_debit=0;
                for(i = 0; i < arrData.length; i++){
                    if (i==0) {
                        var table=    '<tr><td><div class="">'+formatDate(arrData[i]['tanggal'])+'</div></td>'+
                            '<td><div class="">'+arrData[i]['nama_akun']+'</div></td>'+'<td><div class="text-left">'+arrData[i]['no_akun']+'</div></td>';
                        if (arrData[i]['tipe'] == 'KREDIT') {
                            table+='<td><div class="text-left"></div></td>'+
                            '<td><div class="text-left">'+arrData[i]['jumlah']+'</div></td></tr>';
                            total_kredit+=parseInt(arrData[i]['harga']);
                        }else{
                            table+='<td><div class="text-left">'+arrData[i]['jumlah']+'</div></td>'+
                            '<td><div class="text-left"></div></td></tr>';
                            total_debit+=parseInt(arrData[i]['harga']);
                        }
                        $('#detailKas').append(table);
                    }else{
                        if (arrData[i]['keterangan'] == 'akun') {
                            var table=    '<tr><td><div class="text-center"></div></td>'+
                                '<td><div class="text-left">'+arrData[i]['nama_akun']+'</div></td>'+'<td><div class="text-left">'+arrData[i]['no_akun']+'</div></td>';
                        }else{
                            var table=    '<tr><td><div class="text-center"></div></td>'+
                                '<td><div class="text-center">'+arrData[i]['nama_akun']+'</div></td>'+'<td><div class="text-left">'+arrData[i]['no_akun']+'</div></td>';
                        }
                        if (arrData[i]['tipe'] == 'KREDIT') {
                            table+='<td><div class="text-left"></div></td>'+
                            '<td><div class="text-left">'+arrData[i]['jumlah']+'</div></td></tr>';
                            total_kredit+=parseInt(arrData[i]['harga']);
                        }else{
                            table+='<td><div class="text-left">'+arrData[i]['jumlah']+'</div></td>'+
                            '<td><div class="text-left"></div></td></tr>';
                            total_debit+=parseInt(arrData[i]['harga']);
                        }
                        $('#detailKas').append(table);
                    }
                }
                var table=    '<tr><td><div class="text-center"></div></td>'+
                    '<td><div class="text-left"><strong>('+arrData[0]['deskripsi']+')</strong></div></td>'+
                    '<td><div class="text-left"></div></td>'+
                    '<td><div class="text-left"></div></td>'+
                    '<td><div class="text-left"></div></td></tr>';
                // table+=    '<tr><td colspan="3"><div class="text-center"><b>TOTAL</b></div></td>'+
                //     '<td><div class="text-left"></div>Rp. '+formatRupiah(total_debit)+'</td>'+
                //     '<td><div class="text-left"></div>Rp. '+formatRupiah(total_kredit)+'</td></tr>';
                $('#detailKas').append(table);
                // $('#title').html('Detail Kas : '+arrData[0]['deskripsi']);
            }
        });
        <?php
                }
            ?>
});
        var bulan=<?=$bulan?>;
        $('#titleJurnal').html('Jurnal Umum Bulan '+formatBulan(bulan));
    function formatBulan(val){
        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        var getMonth=val[1];
        return bulan[getMonth-1]+' '+val[0];
    }
    // function cekDetail(id){
    //     $('#myModal').show();
    //     // t = $('#detailObat').DataTable();
    //     // t.clear().draw(false);
    //     $('#detailKas td').remove();
    //     $.ajax({
    //         type: "GET",
    //         url: "<?=base_url('akuntansi/transaksi_akuntansi/getDetailKas/')?>"+id, //json get site
    //         dataType : 'json',
    //         success: function(response){
    //             arrData = response;
    //             // console.log(response);
    //             var total_kredit=0;
    //             var total_debit=0;
    //             for(i = 0; i < arrData.length; i++){
    //                 if (i==0) {
    //                     var table=    '<tr><td><div class="">'+formatDate(arrData[i]['tanggal'])+'</div></td>'+
    //                         '<td><div class="">'+arrData[i]['nama_akun']+'</div></td>'+'<td><div class="text-left">'+arrData[i]['no_akun']+'</div></td>';
    //                     if (arrData[i]['tipe'] == 'KREDIT') {
    //                         table+='<td><div class="text-left"></div></td>'+
    //                         '<td><div class="text-left">'+arrData[i]['jumlah']+'</div></td></tr>';
    //                         total_kredit+=parseInt(arrData[i]['harga']);
    //                     }else{
    //                         table+='<td><div class="text-left">'+arrData[i]['jumlah']+'</div></td>'+
    //                         '<td><div class="text-left"></div></td></tr>';
    //                         total_debit+=parseInt(arrData[i]['harga']);
    //                     }
    //                     $('#detailKas').append(table);
    //                 }else{
    //                     if (arrData[i]['keterangan'] == 'akun') {
    //                         var table=    '<tr><td><div class="text-center"></div></td>'+
    //                             '<td><div class="text-left">'+arrData[i]['nama_akun']+'</div></td>'+'<td><div class="text-left">'+arrData[i]['no_akun']+'</div></td>';
    //                     }else{
    //                         var table=    '<tr><td><div class="text-center"></div></td>'+
    //                             '<td><div class="text-center">'+arrData[i]['nama_akun']+'</div></td>'+'<td><div class="text-left">'+arrData[i]['no_akun']+'</div></td>';
    //                     }
    //                     if (arrData[i]['tipe'] == 'KREDIT') {
    //                         table+='<td><div class="text-left"></div></td>'+
    //                         '<td><div class="text-left">'+arrData[i]['jumlah']+'</div></td></tr>';
    //                         total_kredit+=parseInt(arrData[i]['harga']);
    //                     }else{
    //                         table+='<td><div class="text-left">'+arrData[i]['jumlah']+'</div></td>'+
    //                         '<td><div class="text-left"></div></td></tr>';
    //                         total_debit+=parseInt(arrData[i]['harga']);
    //                     }
    //                     $('#detailKas').append(table);
    //                 }
    //             }
    //             var table=    '<tr><td><div class="text-center"></div></td>'+
    //                 '<td><div class="text-left"><strong>('+arrData[0]['deskripsi']+')</strong></div></td>'+
    //                 '<td><div class="text-left"></div></td>'+
    //                 '<td><div class="text-left"></div></td>'+
    //                 '<td><div class="text-left"></div></td></tr>';
    //             // table+=    '<tr><td colspan="3"><div class="text-center"><b>TOTAL</b></div></td>'+
    //             //     '<td><div class="text-left"></div>Rp. '+formatRupiah(total_debit)+'</td>'+
    //             //     '<td><div class="text-left"></div>Rp. '+formatRupiah(total_kredit)+'</td></tr>';
    //             $('#detailKas').append(table);
    //             $('#title').html('Detail Kas : '+arrData[0]['deskripsi']);
    //         }
    //     });
        
    // }
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
