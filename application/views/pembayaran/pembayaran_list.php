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
                        <h3 class="box-title">PEMBAYARAN AKTIF</h3>
                    </div>

                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#menu1">Pemeriksaan</a></li>
                            <li><a data-toggle="tab" href="#menu2">Surat Keterangan Sehat</a></li>
                            <li><a data-toggle="tab" href="#menu3">Rapid Antigen</a></li>
                            <li><a data-toggle="tab" href="#anak">Imunisasi Anak</a></li>
                            <li><a data-toggle="tab" href="#hamil">Kontrol Kehamilan</a></li>
                            <li><a data-toggle="tab" href="#jasa">Jasa Lainnya</a></li>
                            <li><a data-toggle="tab" href="#lab">Periksa LAB</a></li>
                        </ul>
                        <br>
                        <div class="tab-content">
                        <div id="menu1" class="tab-pane fade in active">
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>No Transaksi</th>
                                        <th>Nama Pasien</th>
                                        <th>Klinik Periksa</th>
                                        <th>Tgl Periksa</th>
                                        <th>Tgl Pengambilan Obat</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <table class="table table-bordered table-striped" id="sksehat" width="100%">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>Nomor SKS</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div id="menu3" class="tab-pane fade">
                            <table class="table table-bordered table-striped" width="100%" id="rapid">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>No Sampel</th>
                                        <th>NIK / Passport</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div id="hamil" class="tab-pane fade">
                            <table class="table table-bordered table-striped" width="100%" id="tableHamil">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>No Transaksi</th>
                                        <th>Nama Pasien</th>
                                        <th>Klinik Periksa</th>
                                        <th>Tgl Periksa</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div id="anak" class="tab-pane fade">
                            <table class="table table-bordered table-striped" width="100%" id="tableAnak">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>No Transaksi</th>
                                        <th>Nama Pasien</th>
                                        <th>Klinik Periksa</th>
                                        <th>Tgl Periksa</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div id="jasa" class="tab-pane fade">
                            <table class="table table-bordered table-striped" width="100%" id="tableJasa">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>No Transaksi</th>
                                        <th>Nama Pasien</th>
                                        <th>Klinik Periksa</th>
                                        <th>Tgl Periksa</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div id="lab" class="tab-pane fade">
                            <table class="table table-bordered table-striped" width="100%" id="tableLab">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>No Transaksi</th>
                                        <th>Nama Pasien</th>
                                        <th>Klinik Periksa</th>
                                        <th>Tgl Periksa</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        </div>                        
                    </div>
                </div>
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">RIWAYAT PEMBAYARAN</h3>
                    </div>

                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#list1">Pemeriksaan</a></li>
                            <li><a data-toggle="tab" href="#list2">Surat Keterangan Sehat</a></li>
                            <li><a data-toggle="tab" href="#list3">Rapid Antigen</a></li>
                            <li><a data-toggle="tab" href="#listAnak">Imunisasi Anak</a></li>
                            <li><a data-toggle="tab" href="#listHamil">Kontrol Kehamilan</a></li>
                            <li><a data-toggle="tab" href="#listJasa">Jasa Lainnya</a></li>
                            <li><a data-toggle="tab" href="#listLab">Periksa LAB</a></li>

                        </ul>
                        <br>
                        <div class="tab-content">
                            <div id="list1" class="tab-pane fade in active">
                                <table class="table table-bordered table-striped" id="mytable2">
                                    <thead>
                                        <tr>
                                            <th width="30px">No</th>
                                            <th>No Transaksi</th>
                                            <th>Nama Pasien</th>
                                            <th>Klinik Periksa</th>
                                            <th>Tgl Periksa</th>
                                            <th>Tgl Pembayaran</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="list2" class="tab-pane fade in">
                                <table class="table table-bordered table-striped" id="sksehat2" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="30px">No</th>
                                            <th>Nomor SKS</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="list3" class="tab-pane fade in">
                                <table class="table table-bordered table-striped" width="100%" id="rapid2">
                                    <thead>
                                        <tr>
                                            <th width="30px">No</th>
                                            <th>No Sampel</th>
                                            <th>NIK / Passport</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="listHamil" class="tab-pane fade">
                                <table class="table table-bordered table-striped" width="100%" id="tableListHamil">
                                    <thead>
                                        <tr>
                                            <th width="30px">No</th>
                                            <th>No Transaksi</th>
                                            <th>Nama Pasien</th>
                                            <th>Klinik Periksa</th>
                                            <th>Tgl Periksa</th>
                                            <th>Tgl Pembayaran</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="listAnak" class="tab-pane fade">
                                <table class="table table-bordered table-striped" width="100%" id="tableListAnak">
                                    <thead>
                                        <tr>
                                            <th width="30px">No</th>
                                            <th>No Transaksi</th>
                                            <th>Nama Pasien</th>
                                            <th>Klinik Periksa</th>
                                            <th>Tgl Periksa</th>
                                            <th>Tgl Pembayaran</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="listJasa" class="tab-pane fade">
                                <table class="table table-bordered table-striped" width="100%" id="tableListJasa">
                                    <thead>
                                        <tr>
                                            <th width="30px">No</th>
                                            <th>No Transaksi</th>
                                            <th>Nama Pasien</th>
                                            <th>Klinik Periksa</th>
                                            <th>Tgl Periksa</th>
                                            <th>Tgl Pembayaran</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="listLab" class="tab-pane fade">
                                <table class="table table-bordered table-striped" width="100%" id="tableListLab">
                                    <thead>
                                        <tr>
                                            <th width="30px">No</th>
                                            <th>No Transaksi</th>
                                            <th>Nama Pasien</th>
                                            <th>Klinik Periksa</th>
                                            <th>Tgl Periksa</th>
                                            <th>Tgl Pembayaran</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

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
            ajax: {"url": "pembayaran/json", "type": "POST"},
            columns: [
                {
                    "data": "id_transaksi",
                    "orderable": false
                },{"data": "no_transaksi"},{"data": "nama_pasien"},{"data": "id_klinik"},{"data": "tgl_periksa"},{"data": "tgl_pengambilan"},{"data": "status_transaksi"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[4, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t = $("#sksehat").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#sksehat_filter input')
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
            ajax: {"url": "pembayaran/jsonSksehat", "type": "POST"},
            columns: [
                {
                    "data": "nomor",
                    "orderable": false
                },{"data": "nomor"},{"data": "nama"},{"data": "status"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[1, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t = $("#tableJasa").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tableJasa_filter input')
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
            ajax: {"url": "pembayaran/json/5", "type": "POST"},
            columns: [
                {
                    "data": "id_transaksi",
                    "orderable": false
                },{"data": "no_transaksi"},{"data": "nama_pasien"},{"data": "id_klinik"},{"data": "tgl_periksa"},{"data": "status_transaksi"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[4, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t = $("#tableHamil").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tableHamil_filter input')
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
            ajax: {"url": "pembayaran/json/3", "type": "POST"},
            columns: [
                {
                    "data": "id_transaksi",
                    "orderable": false
                },{"data": "no_transaksi"},{"data": "nama_pasien"},{"data": "id_klinik"},{"data": "tgl_periksa"},{"data": "status_transaksi"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[4, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t = $("#tableAnak").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tableAnak_filter input')
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
            ajax: {"url": "pembayaran/json/2", "type": "POST"},
            columns: [
                {
                    "data": "id_transaksi",
                    "orderable": false
                },{"data": "no_transaksi"},{"data": "nama_pasien"},{"data": "id_klinik"},{"data": "tgl_periksa"},{"data": "status_transaksi"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[4, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t = $("#tableLab").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tableLab_filter input')
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
            ajax: {"url": "pembayaran/json/6", "type": "POST"},
            columns: [
                {
                    "data": "id_transaksi",
                    "orderable": false
                },{"data": "no_transaksi"},{"data": "nama_pasien"},{"data": "id_klinik"},{"data": "tgl_periksa"},{"data": "status_transaksi"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[4, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        var t = $("#sksehat2").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#sksehat2_filter input')
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
            ajax: {"url": "pembayaran/jsonSksehatLunas", "type": "POST"},
            columns: [
                {
                    "data": "nomor",
                    "orderable": false
                },{"data": "nomor"},{"data": "nama"},{"data": "status"},
                {
                    "render" : function(data,type,row){
                        return row.action+"&nbsp;"+row.cetak
                    },
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[1, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t = $("#rapid").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#rapid_filter input')
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
            ajax: {"url": "pembayaran/jsonRapid", "type": "POST"},
            columns: [
                {
                    "data": "no_sampel",
                    "orderable": false
                },{"data": "no_sampel"},{"data": "nik_or_passport"},{"data": "nama"},{"data": "status"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[1, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t = $("#rapid2").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#rapid2_filter input')
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
            ajax: {"url": "pembayaran/jsonRapidLunas", "type": "POST"},
            columns: [
                {
                    "data": "no_sampel",
                    "orderable": false
                },{"data": "no_sampel"},{"data": "nik_or_passport"},{"data": "nama"},{"data": "status"},
                {
                    "render" : function(data,type,row){
                        return row.action+"&nbsp;"+row.cetak
                    },
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[1, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        
        var t2 = $("#mytable2").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable2_filter input')
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
            ajax: {"url": "pembayaran/json2", "type": "POST"},
            columns: [
                {
                    "data": "id_transaksi",
                    "orderable": false
                },{"data": "no_transaksi"},{"data": "nama_pasien"},{"data": "id_klinik"},{"data": "tgl_periksa"},{"data": "tgl_pembayaran"},{"data": "status_transaksi"},
                {
                    "render" : function(data,type,row){
                        var cetak = row.is_surat_ket_sakit=='1' ? row.cetak : ''
                        return row.action+"&nbsp;"+cetak
                    },
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[5, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t2 = $("#tableListHamil").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tableListHamil_filter input')
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
            ajax: {"url": "pembayaran/json2/3", "type": "POST"},
            columns: [
                {
                    "data": "id_transaksi",
                    "orderable": false
                },{"data": "no_transaksi"},{"data": "nama_pasien"},{"data": "id_klinik"},{"data": "tgl_periksa"},{"data": "tgl_pembayaran"},{"data": "status_transaksi"},
                {
                    "render" : function(data,type,row){
                        var cetak = row.is_surat_ket_sakit=='1' ? row.cetak : ''
                        return row.action+"&nbsp;"+cetak
                    },
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[5, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t2 = $("#tableListAnak").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tableListAnak_filter input')
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
            ajax: {"url": "pembayaran/json2/2", "type": "POST"},
            columns: [
                {
                    "data": "id_transaksi",
                    "orderable": false
                },{"data": "no_transaksi"},{"data": "nama_pasien"},{"data": "id_klinik"},{"data": "tgl_periksa"},{"data": "tgl_pembayaran"},{"data": "status_transaksi"},
                {
                    "render" : function(data,type,row){
                        var cetak = row.is_surat_ket_sakit=='1' ? row.cetak : ''
                        return row.action+"&nbsp;"+cetak
                    },
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[5, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t2 = $("#tableListJasa").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tableListJasa_filter input')
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
            ajax: {"url": "pembayaran/json2/5", "type": "POST"},
            columns: [
                {
                    "data": "id_transaksi",
                    "orderable": false
                },{"data": "no_transaksi"},{"data": "nama_pasien"},{"data": "id_klinik"},{"data": "tgl_periksa"},{"data": "tgl_pembayaran"},{"data": "status_transaksi"},
                {
                    "render" : function(data,type,row){
                        var cetak = row.is_surat_ket_sakit=='1' ? row.cetak : ''
                        return row.action+"&nbsp;"+cetak
                    },
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[5, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        var t2 = $("#tableListLab").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tableListLab_filter input')
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
            ajax: {"url": "pembayaran/json2/6", "type": "POST"},
            columns: [
                {
                    "data": "id_transaksi",
                    "orderable": false
                },{"data": "no_transaksi"},{"data": "nama_pasien"},{"data": "id_klinik"},{"data": "tgl_periksa"},{"data": "tgl_pembayaran"},{"data": "status_transaksi"},
                {
                    "render" : function(data,type,row){
                        return row.action+"&nbsp;"+row.cetak
                    },
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[5, 'desc']],
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