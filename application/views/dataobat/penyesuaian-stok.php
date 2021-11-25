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
                    <?php echo anchor(site_url('dataobat/create_adjustment/'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
                        <div style="padding-bottom: 10px;">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>Id Inventory</th>
                                        <!-- <th>Kode Purchase</th> -->
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

<!-- START: MODAL -->
<div class="modal fade" id="myModal" abindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Detail Stok Adjustment</h5>
                <button type="close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped"  id="Mtable">
                    <thead>
                        <tr>
                            <th width="30px">No</th>
                            <th id="id_inventory">Id Inventory</th>
                            <th id="kode_barang">Kode Barang</th>
                            <th>Kode Gudang</th>
                            <th>Lokasi Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Tanggal Expired</th>
                            <th>Notes</th>
                            <!-- <th width="20%">Aksi</th> -->
                        </tr>
                    </thead>
                    <!-- <tbody>
                        <tr>
                            <th>tes</th>
                            <th>tes</th>
                            <th>tes</th>
                            <th>tes</th>
                            <th>tes</th>
                        </tr>
                    </tbody> -->
                </table>
                <div class="form-group" align="right">
                    <a href="" data-dismiss="modal" class="btn btn-info">
                        <i class="fa fa-sign-out">Kembali</i>    
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: MODAL -->

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

                // var t = $("#Mtable").dataTable({
                //     initComplete: function() {
                //         var api = this.api();
                //         $('#mytable_filter input')
                //                 .off('.DT')
                //                 .on('keyup.DT', function(e) {
                //                     if (e.keyCode == 13) {
                //                         api.search(this.value).draw();
                //             }
                //         });
                //     },
                //     oLanguage: {
                //         sProcessing: "loading..."
                //     },
                //     processing: true,
                //     serverSide: true,
                //     ajax: {"url": "d_json_adjustment", "type": "POST"},
                //     columns: [
                //         {
                //             "data": "id_inventory_detail"
                //         },
                //         {
                //             "data": "id_inventory"
                //         },
                //         {
                //             "data": "nama_barang"
                //         },
                //         {
                //             "data": "nama_gudang"
                //         },
                //         {
                //             "data": "lokasi"
                //         },
                //         {
                //             "data": "jumlah"
                //         },
                //         {
                //             "data": "harga"
                //         },
                //         {
                //             "data": "diskon"
                //         },
                //         {
                //             "data": "tgl_exp"
                //         },
                //         {
                //             "data": "notes"
                //         },
                //         // {
                //         //     "data": "kode_purchase"
                //         // },
                //     ],
                //     order: [[0, 'desc']],
                //     rowCallback: function(row, data, iDisplayIndex) {
                //         var info = this.fnPagingInfo();
                //         var page = info.iPage;
                //         var length = info.iLength;
                //         var index = page * length + (iDisplayIndex + 1);
                //         $('td:eq(0)', row).html(index);
                //     }
                // });

                    $('#myModal').on('click', '.btn-detail', function(e) {
                    e.preventDefault();
                    var table = $('#Mtable').DataTable();
                    var data = table.row($(this).closest('tr')).data()
                    var id = data.id_inventory_detail
                    var id_inv = data.id_inventory
                    var kd_brg = data.nama_barang
                    var kd_gdg = data.kode_gudang
                    var id_lok_brg = data.id_lokasi_barang
                    var jml_brg = data.jumlah
                    var hrg = data.harga
                    var disc = data.diskon
                    var exp = data.tgl_exp
                    var nts = data.notes


                    $.ajax({
                        type: 'get',
                        url: 'd_json_adjustment',
                        data: {
                            data: id,
                            data: id_inv,
                            data: kd_brg,
                            data: kd_gdg,
                            data: id_lok_brg,
                            data: jml_brg,
                            data: hrg,
                            data: disc,
                            data: exp,
                            data: nts,
                        },
                        success: function(data) {
                            $('#myModal').modal('show');
                            $('#id_inventory_detail').val(id);
                            $('#id_inventory').val(id_inv);
                            $('#kode_barang').val(kd_brg);
                            $('#kode_gudang').val(kd_gdg);
                            $('#id_lokasi_barang').val(id_lok_brg);
                            $('#jumlah').val(jml_brg);
                            $('#harga').val(hrg);
                            $('#diskon').val(disc);
                            $('#tgl_exp').val(exp);
                            $('#notes').val(nts);
                            }
                })  
                })  
            });
</script>