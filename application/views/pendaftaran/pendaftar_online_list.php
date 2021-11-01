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
                        <h3 class="box-title">LIST PENDAFTAR ONLINE</h3>
                    </div>

                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIK</th>
                                        <th>Nama Dokter</th>
                                        <!-- <th>ID Dokter</th> -->
                                        <th>Tanggal Lahir</th>
                                        <th>Golongan Darah</th>
                                        <th>Status Menikah</th>
                                        <th>Pekerjaan</th>
                                        <th>Alamat</th>
                                        <th>Kabupaten</th>
                                        <th>RT</th>
                                        <th>RW</th>
                                        <th>Nama Orang Tua atau Istri</th>
                                        <th>Nomer Telepon</th>
                                        <th>Tipe Periksa</th>
                                        <th>Aksi</th>
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

<!-- START:Modal -->
<div class="modal fade" id="myModal" abindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Terima Pendaftaran</h5>
                <button type="close" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="update_data_online" method="post" enctype="multipart/form-data"class="form-horizontal" id="form-create_pendaftaran form-online">
                    <div class="box-body">
                        <input type="hidden" class="form-control" id="id_pendaftaran" name="id_pendaftaran" readonly>
                        <input type="hidden" class="form-control" id="id_dokter" name="id_dokter" readonly>
                        <input type="hidden" class="form-control" id="tanggal_lahir" name="tanggal_lahir" readonly>
                        <input type="hidden" class="form-control" id="golongan_darah" name="golongan_darah" readonly>
                        <input type="hidden" class="form-control" id="status_menikah" name="status_menikah" readonly>
                        <input type="hidden" class="form-control" id="pekerjaan" name="pekerjaan" readonly>
                        <input type="hidden" class="form-control" id="alamat" name="alamat" readonly>
                        <input type="hidden" class="form-control" id="kabupaten" name="kabupaten" readonly>
                        <input type="hidden" class="form-control" id="rt" name="rt" readonly>
                        <input type="hidden" class="form-control" id="rw" name="rw" readonly>
                        <input type="hidden" class="form-control" id="nama_orang_tua_atau_istri" name="nama_orang_tua_atau_istri" readonly>
                        <input type="hidden" class="form-control" id="nomer_telepon" name="nomer_telepon" readonly>
                        <input type="hidden" class="form-control" id="tipe_periksa" name="tipe_periksa" readonly>
                        <div class="form-group">
                            <div class="col-sm-2">Nama Lengkap</div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama" name="nama_lengkap" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">NIK</div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nik" name="nik" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">ID Pasien</div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id_pasien" name="no_id">
                            </div>
                        </div>
                    </div>
                    <div align="right">
                        <a href="" class="btn btn-info"><i class="fa fa-sign-out">Kembali</i></a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"> Simpan</i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END:Modal -->

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
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
            ajax: {
                "url": "json_pendaftaran",
                "type": "POST"
            },
            columns: [{
                    "data": "id_pendaftaran",
                    "orderable": false
                }, {
                    "data": "nama_lengkap"
                }, {
                    "data": "nik"
                }, {
                    "data": "nama_dokter"
                },
                // {
                //     "data": "id_dokter"
                // },
                {
                    "data": "tanggal_lahir"
                }, {
                    "data": "golongan_darah"
                }, {
                    "data": "status_menikah"
                }, {
                    "data": "pekerjaan"
                }, {
                    "data": "alamat"
                }, {
                    "data": "kabupaten"
                }, {
                    "data": "rt"
                }, {
                    "data": "rw"
                }, {
                    "data": "nama_orang_tua_atau_istri"
                }, {
                    "data": "nomer_telepon"
                }, {
                    "data": "tipe_periksa"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center"
                }

            ],
            order: [
                [7, 'asc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        $('#mytable').on('click', '.btn-detail', function(e) {
            e.preventDefault();
            var table = $('#mytable').DataTable();
            var data = table.row($(this).closest('tr')).data()
            // console.log(data);
            var id = data.id_pendaftaran
            var dr = data.nama_dokter
            console.log(dr)
            var cr = data.id_dokter
            var nama = data.nama_lengkap
            console.log(cr)
            var id_pasien = $("input[name='id_pasien']").val()
            var nik_pasien = data.nik
            var tanggal_lahir = data.tanggal_lahir
            var golongan_darah = data.golongan_darah
            var status_menikah = data.status_menikah
            var pekerjaan = data.pekerjaan
            var alamat = data.alamat
            var kabupaten = data.kabupaten
            var rt = data.rt
            var rw = data.rw
            var nama_orang_tua_atau_istri = data.nama_orang_tua_atau_istri
            var nomer_telepon = data.nomer_telepon
            var tipe_periksa = data.tipe_periksa
            // $('#formmodalnamadokter').val(nama_dokter);
            // $('#myModal').modal('show');


            $.ajax({
                type: 'get',
                url: 'detail',
                data: {
                    data: cr,
                    data: id,
                    data: nama,
                    data: nik_pasien,
                    data: tanggal_lahir,
                    data: golongan_darah,
                    data: status_menikah,
                    data: pekerjaan,
                    data: alamat,
                    data: kabupaten,
                    data: rt,
                    data: rw,
                    data: nama_orang_tua_atau_istri,
                    data: nomer_telepon,
                    data: tipe_periksa
                },
                success: function(data) {
                    $('#myModal').modal('show');
                    $('#id_pendaftaran').val(id);
                    $('#nama').val(nama);
                    $('#nik').val(nik_pasien);
                    $('#id_dokter').val(cr);
                    $('#tanggal_lahir').val(tanggal_lahir);
                    $('#golongan_darah').val(golongan_darah);
                    $('#status_menikah').val(status_menikah);
                    $('#pekerjaan').val(pekerjaan);
                    $('#alamat').val(alamat);
                    $('#kabupaten').val(kabupaten);
                    $('#rt').val(rt);
                    $('#rw').val(rw);
                    $('#nama_orang_tua_atau_istri').val(nama_orang_tua_atau_istri);
                    $('#nomer_telepon').val(nomer_telepon);
                    $('#tipe_periksa').val(tipe_periksa);

                }

            })
        })


    });
</script>