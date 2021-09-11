<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">ABSENSI PEGAWAI</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-inline">
                        <?php echo anchor(site_url('hrms/absensi/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-info btn-sm"'); ?>
                        <?php echo anchor(site_url('hrms/absensi/month'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Log Absensi per Bulan', 'class="btn btn-primary btn-sm"'); ?>
                        <?php echo anchor(site_url('hrms/absensi/lembur'), '<i class="fa fa-clock-o" aria-hidden="true"></i> Tambah Jam Lembur', 'class="btn btn-primary btn-sm"'); ?>
                        <?php echo anchor(site_url('hrms/absensi/import_excel'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Import Absensi', 'class="btn btn-success btn-sm"'); ?>
                        <label style="padding-left:20px">Lihat Tanggal : </label>
                        <input type="date" id="date" class="form-control" >
                        <button class="btn btn-primary"  onclick="cekAbsensiDate()"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
		</div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="30px">No</th>
        		    <th>Nama Pegawai</th>
                    <th>Tanggal</th>
                    <th>Jam Datang</th>
                    <th>Jam Pulang</th>
        		    <th width="100px">Action</th>
                </tr>
            </thead>
	    
        </table>
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
    //         ajax: {"url": "absensi/json", "type": "POST"},
    //         columns: [
    //             {
    //                 "data": "id_pegawai",
    //                 "orderable": false
    //             },{"data": "nama_pegawai"},
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
    t = $('#mytable').DataTable();
        t.clear().draw(false);
        $.ajax({
            type: "GET",
            url: "absensi/json", //json get site
            dataType : 'json',
            success: function(response){
                // console.log(response['data']);
                arrData = response['data'];
                var j=0;
                for(i = 0; i < arrData.length; i++){
                    j+=1;
                    t.row.add([
                        '<div class="text-center">'+j+'</div>',
                        '<div class="text-left">'+arrData[i]['nama_pegawai']+'</div>',
                        '<div class="text-left">'+formatDate(arrData[i]['tanggal'])+'</div>',
                        '<div class="text-left">'+formatTime(arrData[i]['jam_datang'])+'</div>',
                        '<div class="text-left">'+formatTime(arrData[i]['jam_pulang'])+'</div>',
                        '<div class="text-left">'+
                        '<a href="<?=site_url('hrms/absensi/update/')?>'+arrData[i]['id_pegawai']+'/'+arrData[i]['tanggal']+'" class="btn waves-effect waves-light btn-xs btn-success" title="edit"><i class="fa fa-edit"></i></a> '+
                        // '<a href="<?=site_url('hrms/absensi/detail/')?>'+arrData[i]['id_pegawai']+'" class="btn waves-effect waves-light btn-xs btn-info"><i class="fa fa-list"></i></a>'+
                        '</div>'
                    ]).draw(false);
                }
            }
        });
    });
    function cekAbsensiDate(){
        var id=$('#date').val();
        console.log(id);
       t = $('#mytable').DataTable();
        t.clear().draw(false);
        $.ajax({
            type: "post",
            url: "absensi/json", //json get site
            dataType : 'json',
            data :{ date : id},
            success: function(response){
                console.log(response['data']);
                arrData = response['data'];
                var j=0;
                for(i = 0; i < arrData.length; i++){
                    j+=1;
                    t.row.add([
                        '<div class="text-center">'+j+'</div>',
                        '<div class="text-left">'+arrData[i]['nama_pegawai']+'</div>',
                        '<div class="text-left">'+formatDate(arrData[i]['tanggal'])+'</div>',
                        '<div class="text-left">'+formatTime(arrData[i]['jam_datang'])+'</div>',
                        '<div class="text-left">'+formatTime(arrData[i]['jam_pulang'])+'</div>',
                        '<div class="text-center">'+
                        '<a href="<?=site_url('hrms/absensi/update/')?>'+arrData[i]['id_pegawai']+'/'+arrData[i]['tanggal']+'" class="btn waves-effect waves-light btn-xs btn-success"><i class="fa fa-edit"></i></a> '+
                        '<a href="<?=site_url('hrms/absensi/detail/')?>'+arrData[i]['id_pegawai']+'" class="btn waves-effect waves-light btn-xs btn-info"><i class="fa fa-list"></i></a>'+
                        '</div>'
                    ]).draw(false);
                }
            }
        });
    }
    function formatDate(date) {
      var temp=date.split('-');
      return temp[2] + '-' + temp[1] + '-' + temp[0];
    }
    function formatTime(time) {
        if (time != '') {
            var tempTime=time.split(':');
            return tempTime[0] + ':' + tempTime[1];
        }else{
            return '-';
        }
    }
</script>