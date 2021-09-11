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
                        <h3 class="box-title">PENERIMAAN BARANG</h3>
                    </div>
                    <div class="box-body">
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <?php //echo anchor(site_url('transaksi_apotek/create_po'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-success btn-sm"'); ?>
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
                                    <th>Nomor PO</th>
                            		<th>Nama Supplier</th>
                            		<th>Apoteker</th>
                                    <th>Total Harga</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
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
                    <th>Harga</th>
                    <th>Jumlah PO</th>
                    <th>Diskon</th>
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
            ajax: {"url": "json_receipt", "type": "POST"},
            columns: [
                {
                    "data": "kode_purchase",
                    "orderable": false
                },{"data": "kode_purchase"},{"data": "nama_supplier"},{"data": "nama_apoteker"},{"render": function (data, type, row){
                 return 'Rp. '+formatRupiah(row.total_harga);
                }},{"data": "keterangan"},{"data": "status"},
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
        $('#detailObat td').remove();
        $.ajax({
            type: "GET",
            url: "<?=base_url('transaksi_apotek/json_detail_po/')?>"+id, //json get site
            dataType : 'json',
            success: function(response){
                arrData = response['data'];
                console.log(arrData);
                $('#title').html('Purchase Order Nomor : '+id)
                for(i = 0; i < arrData.length; i++){
                    // t.row.add([
                    var table=    '<tr><td><div class="text-center">'+arrData[i]['kode_barang']+'</div></td>'+
                        '<td><div class="text-center">'+arrData[i]['nama_barang']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['harga']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['jumlah']+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i]['diskon']+'</div></td></tr>';
                    $('#detailObat').append(table);
                    // ]).draw(false);
                }
            }
        });
        
    }
    function formatRupiah(angka, prefix)
      {
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
      }
</script>