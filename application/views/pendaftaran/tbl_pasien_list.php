<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">PENCARIAN PASIEN</h3>
                    </div>

                    <div class="box-body">
                        <!--
                        <?php  echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-bayar')); ?>
                        <div class="form-group">
							<div class="col-sm-2"><label>Nama Pasien</label></div>
							<div class="col-sm-4"><?php echo form_input(array('id'=>'nama_lengkap','name'=>'nama_lengkap','type'=>'text','value'=>'','class'=>'form-control'));?></div>
							<div class="col-sm-2"><label>No ID Pasien</label></div>
							<div class="col-sm-4"><?php echo form_input(array('id'=>'no_id','name'=>'no_id','type'=>'text','value'=>'','class'=>'form-control'));?></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2"><label>Tanggal Lahir</label></div>
							<div class="col-sm-4">
							    <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="" />
							</div>
							<div class="col-sm-2"><label>No HP/Telepon</label></div>
							<div class="col-sm-4"><?php echo form_input(array('id'=>'no_id','name'=>'no_id','type'=>'text','value'=>'','class'=>'form-control'));?></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-12"><div align="right"><button type="submit" class="btn btn-danger"><i class="fa fa-search"></i> Cari</button></div></div>
                        </div>
                        <?php echo form_close();?>
                        <hr />
                        -->
                        <div style="padding-bottom: 10px;">
                        <?php echo anchor(site_url('pendaftaran/create'), 'Pendaftaran Baru', 'class="btn btn-success btn-sm"'); ?>
                        </div>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>No Rekam Medis</th>
                                    <th>No ID Pasien</th>
                                    <th>NIK</th>
                                    <th>Nama Pasien</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Nomor HP/Telepon</th>
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
            ajax: {"url": "../pendaftaran/pencarian_json", "type": "POST"},
            columns: [
                {
                    "data": "no_rekam_medis",
                    "orderable": false
                },{"data": "no_rekam_medis"},{"data": "no_id_pasien"},{"data": "nik"},{"data": "nama_pasien"},{"data": "tanggal_lahir"},{"data": "no_hp"},
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
    
    $("#button").click(function() {
      alert( "Coba" );
    });
</script>