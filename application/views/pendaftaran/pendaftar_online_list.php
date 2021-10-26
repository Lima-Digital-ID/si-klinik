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
            ajax: {"url": "json_pendaftaran", "type": "POST"},
            columns: [
                {
                    "data": "id_pendaftaran",
                    "orderable": false
                },{"data": "nama_lengkap"},{"data": "nik"},{"data" : "nama_dokter"},{"data": "tanggal_lahir"},{"data": "golongan_darah"},{"data": "status_menikah"},{"data": "pekerjaan"},{"data": "alamat"}, {"data" : "kabupaten"},{"data" : "rt"},{"data" : "rw"}, {"data" : "nama_orang_tua_atau_istri"}, {"data" : "nomer_telepon"}, {"data" : "tipe_periksa"},
                {
                    "data": "action",
                    "orderable": false,
                    "className" : "text-center"
                }
                
            ],
            order: [[7, 'asc']],
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