<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">ABSENSI PEGAWAI</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
        <div class="row">
        <form accept="<?=current_url()?>" method="post">
        <!-- <div class="col-sm-2">
        <?php echo anchor(site_url('hrms/absensi/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-info btn-sm"'); ?>
        <?php //echo anchor(site_url('hrms/absensi/month'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-info btn-sm"'); ?>
        </div> -->
        <?php
        function formatTime($time){
            if ($time != '') {
                $timeTemp=explode(':', $time);
                return $timeTemp[0].':'.$timeTemp[1]. ' WIB';
            }else{
                return '-';
            }
        }
        ?>
        <div class="col-sm-2"></div>
            
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
                <label>Pilih Pegawai : </label>
                <?php echo form_dropdown('id_pegawai',$pegawai_option,$id_pegawai,array('id'=>'id_pegawai','class'=>'form-control select2', 'required'=>'required'));?>
                <button class="btn btn-primary"  onclick="cekAbsensiDate()"><i class="fa fa-search"></i></button>
            </div>
        </div>
        </div>
        </form>
        <br>
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                        <th>tanggal</th>
                <?php 
                for ($i=0; $i < 10; $i++) { 
                ?>
                        <th  class="text-center"><?php print_r($absensi['data'][$i]['tanggal']) ?></th>
                <?php
                }
                ?>
                    </tr>
                    <tr>
                        <th>jam datang</th>
                <?php 
                for ($i=0; $i < 10; $i++) { 
                ?>
                        <th  class="text-center"><?=formatTime($absensi['data'][$i]['jam_datang']) ?></th>
                <?php
                }
                ?>
                    </tr>
                    <tr>
                        <th>jam pulang</th>
                <?php 
                for ($i=0; $i < 10; $i++) { 
                ?>
                        <th  class="text-center"><?=formatTime($absensi['data'][$i]['jam_pulang']) ?></th>
                <?php
                }
                ?>
                </tr>
                <tr>
                        <th>Action</th>
                <?php 
                for ($i=0; $i < 10; $i++) { 
                ?>
                        <th  class="text-center"><?=anchor('hrms/absensi/update/'.$id_pegawai.'/'.$absensi['data'][$i]['date'], '<i class="fa fa-edit"></i>', array('class'=>'btn btn-sm btn-success', 'title'=>'edit')) ?></th>
                <?php
                }
                ?>
                </tr>
            </thead>            
        </table>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                        <th>tanggal</th>
                <?php 
                for ($i=10; $i < 20; $i++) { 
                ?>
                        <th  class="text-center"><?php print_r($absensi['data'][$i]['tanggal']) ?></th>
                <?php
                }
                ?>
                    </tr>
                    <tr>
                        <th>jam datang</th>
                <?php 
                for ($i=10; $i < 20; $i++) { 
                ?>
                        <th  class="text-center"><?=formatTime($absensi['data'][$i]['jam_datang']) ?></th>
                <?php
                }
                ?>
                    </tr>
                    <tr>
                        <th>jam pulang</th>
                <?php 
                for ($i=10; $i < 20; $i++) { 
                ?>
                        <th class="text-center"><?=formatTime($absensi['data'][$i]['jam_pulang']) ?></th>
                <?php
                }
                ?>
                </tr>
                <tr>
                        <th>Action</th>
                <?php 
                for ($i=10; $i < 20; $i++) { 
                ?>
                        <th  class="text-center"><?=anchor('hrms/absensi/update/'.$id_pegawai.'/'.$absensi['data'][$i]['date'], '<i class="fa fa-edit"></i>', array('class'=>'btn btn-sm btn-success', 'title'=>'edit')) ?></th>
                <?php
                }
                ?>
                </tr>
            </thead>            
        </table>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                        <th>tanggal</th>
                <?php 
                for ($i=20; $i < $jumlah_hari; $i++) { 
                ?>
                        <th  class="text-center"><?php print_r($absensi['data'][$i]['tanggal']) ?></th>
                <?php
                }
                ?>
                    </tr>
                    <tr>
                        <th>jam datang</th>
                <?php 
                for ($i=20; $i < $jumlah_hari; $i++) { 
                ?>
                        <th  class="text-center"><?=formatTime($absensi['data'][$i]['jam_datang']) ?></th>
                <?php
                }
                ?>
                    </tr>
                    <tr>
                        <th>jam pulang</th>
                <?php 
                for ($i=20; $i < $jumlah_hari; $i++) { 
                ?>
                        <th class="text-center"><?=formatTime($absensi['data'][$i]['jam_pulang']) ?></th>
                <?php
                }
                ?>
                </tr>
                <tr>
                        <th>Action</th>
                <?php 
                for ($i=20; $i < $jumlah_hari; $i++) { 
                ?>
                        <th  class="text-center"><?=anchor('hrms/absensi/update/'.$id_pegawai.'/'.$absensi['data'][$i]['date'], '<i class="fa fa-edit"></i>', array('class'=>'btn btn-sm btn-success', 'title'=>'edit')) ?></th>
                <?php
                }
                ?>
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
                console.log(response['data']);
                arrData = response['data'];
                var j=0;
                for(i = 0; i < arrData.length; i++){
                    j+=1;
                    t.row.add([
                        '<div class="text-center">'+j+'</div>',
                        '<div class="text-left">'+arrData[i]['nama_pegawai']+'</div>',
                        '<div class="text-left">'+formatDate(arrData[i]['tanggal'])+'</div>',
                        '<div class="text-left">'+arrData[i]['jam_datang']+'</div>',
                        '<div class="text-left">'+arrData[i]['jam_pulang']+'</div>',
                        '<div class="text-center">'+
                        '<a href="<?=site_url('hrms/absensi/update/')?>'+arrData[i]['id_pegawai']+'/'+arrData[i]['tanggal']+'" class="btn waves-effect waves-light btn-xs btn-success"><i class="fa fa-edit"></i></a> '+
                        '<a href="<?=site_url('hrms/absensi/detail/')?>'+arrData[i]['id_pegawai']+'" class="btn waves-effect waves-light btn-xs btn-info"><i class="fa fa-list"></i></a>'+
                        '</div>'
                    ]).draw(false);
                }
            }
        });
    });
    function cekAbsensiDate(){
        var id=$('#date').val();
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
                        '<div class="text-left">'+arrData[i]['jam_datang']+'</div>',
                        '<div class="text-left">'+arrData[i]['jam_pulang']+'</div>',
                        '<div class="text-center">'+
                        '<a href="<?=site_url('hrms/absensi/update/')?>'+arrData[i]['id_pegawai']+'/'+arrData[i]['tanggal']+'" class="btn waves-effect waves-light btn-xs btn-success"><i class="fa fa-edit"></i></a> '+
                        '<a href="<?=site_url('hrms/absensi/detail/')?>'+arrData[i]['id_pegawai']+'" class="btn waves-effect waves-light btn-xs btn-info"><i class="fa fa-list"></i></a>'+
                        '</div>'
                    ]).draw(false);
                }
            }
        });
    }
    console.log(date);
    function formatDate(date) {
      var temp=date.split('-');

      return temp[2] + '-' + temp[1] + '-' + temp[0];
    }

</script>