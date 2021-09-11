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
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">KELOLA DATA OBAT RACIKAN</h3>
                    </div>
                    <div class="box-body">
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <?php echo anchor(site_url('obat_racik/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-success btn-sm"'); ?>
		<?php //echo anchor(site_url('obat_racik/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
		<?php //echo anchor(site_url('obat_racik/import_excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Import Ms Excel', 'class="btn btn-success btn-sm"'); ?>
		<?php // echo anchor(site_url('obat_racikan/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?>
                            </div>
                            <div class="col-md-4 text-center">
                                <div style="margin-top: 8px" id="message">
                                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                                </div>
                            </div>
                            <div class="col-md-1 text-right">
                            </div>
                            <div class="col-md-3 text-right">

                            </div>
                        </div>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Kode Barang</th>
                            		<th>Nama Barang</th>
                            		<th>Kategori Barang</th>
                            		<th width="150px">Action</th>
                                </tr>
                            </thead>
                        </table>
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
        <h3>Detail Obat</h3>
        <table class="table table-bordered table-striped" id="detailObat">
            <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Pabrik</th>
                    <th>Dosis</th>
                </tr>
            </thead>
        </table>
        <br>
        <h3>Detail Jasa</h3>
        <table class="table table-bordered table-striped" id="detailJasa">
            <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Pabrik</th>
                    <th>Dosis</th>
                </tr>
            </thead>
        </table>
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
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        var t = $("#mytable").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                .off('.DT')
                .on('keyup.DT', function(e) {
                    if (e.keyCode == 13) {
                        api.search(this.value).draw();
                    }
                });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {"url": "obat_racik/json", "type": "POST"},
            columns: [
                {
                    "data": "kode_obat_racikan",
                    "orderable": false
                },{"data": "kode_obat_racikan"},{"data": "nama_obat_racikan"},{"data": "nama_kategori"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[0, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        
    });
    function cekDetail(id){
        $('#myModal').show();
        // t = $('#detailObat').DataTable();
        // t.clear().draw(false);
        $.ajax({
            type: "GET",
            url: "<?=base_url('obat_racik/json_detail_obat/')?>"+id, //json get site
            dataType : 'json',
            success: function(response){
                arrData = response['data'];
                console.log(arrData);
                $('#title').html('Nama Obat Racikan : '+arrData[0]['nama_obat_racikan'])
                for(i = 0; i < arrData.length; i++){
                    // t.row.add([
                    var table=    '<tr><td><div class="text-center">'+arrData[i]['kode_barang']+'</div></td>'+
                        '<td><div class="text-center">'+arrData[i]['nama_barang']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['nama_kategori']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['nama_pabrik']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['dosis']+'</div></td></tr>';
                    $('#detailObat').append(table);
                    // ]).draw(false);
                }
            }
        });
        // m = $('#detailJasa').DataTable();
        // m.clear().draw(false);
        $.ajax({
            type: "GET",
            url: "<?=base_url('obat_racik/json_detail_jasa/')?>"+id, //json get site
            dataType : 'json',
            success: function(response){
                arrData = response['data'];
                console.log(arrData);
                for(i = 0; i < arrData.length; i++){
                    // m.row.add([
                    //     '<div class="text-center">'+arrData[i]['kode_jasa']+'</div>',
                    //     '<div class="text-center">'+arrData[i]['nama_jasa']+'</div>',
                    //     '<div class="text-left">'+arrData[i]['nama_kategori']+'</div>',
                    //     '<div class="text-left">'+arrData[i]['hna']+'</div>',
                    //     '<div class="text-left">'+arrData[i]['harga']+'</div>',
                    //     // '<div class="text-center"><a href="'+urlEdit+'" class="btn waves-effect waves-light btn-xs btn-warning"><i class="fas fa-pencil-alt"></i></a> <a href="'+urlDelete+'" class="btn waves-effect waves-light btn-xs btn-danger" onclick="return confirm("Are you sure to delete item?")"><i class="fas fa-trash-alt"></i></a></div>'
                    // ]).draw(false);
                    var table=    '<tr><td><div class="text-center">'+arrData[i]['kode_jasa']+'</div></td>'+
                        '<td><div class="text-center">'+arrData[i]['nama_jasa']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['nama_kategori']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['hna']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['harga']+'</div></td></tr>';
                    $('#detailJasa').append(table);
                }
            }
        });
    }
</script>