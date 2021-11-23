<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($this->session->flashdata('message')) {
                    if ($this->session->flashdata('message_type') == 'danger')
                        echo alert('alert-danger', 'Perhatian', $this->session->flashdata('message'));
                    else if ($this->session->flashdata('message_type') == 'success')
                        echo alert('alert-success', 'Sukses', $this->session->flashdata('message'));
                    else
                        echo alert('alert-info', 'Info', $this->session->flashdata('message'));
                }
                ?>
            </div>
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">PENYESUAIAN STOK BARANG</h3>
                    </div>
                    <div class="box-body">
                    <?php echo anchor(site_url('dataobat/create_adjustment/'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-success btn-sm"'); ?>
                        <div style="padding-bottom: 10px;">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>Id Inventory</th>
                                        <th>Kode Purchase</th>
                                        <!-- <th>Jumlah</th> -->
                                        <th width="20%">Aksi</th>
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
                    ajax: {"url": "json_adjustment", "type": "POST"},
                    columns: [
                        {
                            "data": "id_inventory"
                        },
                        {
                            "data": "id_inventory"
                        },
                        {
                            "data": "kode_purchase"
                        },
                        
                        {
                            "data" : "action",
                            "orderable": false,
                            "className" : "text-center"
                        }
                    ],
                    order: [[0, 'desc']],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
                
            });
</script>