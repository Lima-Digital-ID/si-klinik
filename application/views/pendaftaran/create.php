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
            <div class="col-md-6">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">FORM PENDAFTARAN</h3>
                    </div>
                    <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-create_pendaftaran')); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-4">Nama Dokter <?php echo form_error('nama_dokter'); ?></div>
                            <div class="col-sm-8">
                                <select name="nama_dokter" id="nama_dokter" class="form-control select2 namaDokter">
                                    <option value="">Pilih Dokter</option>
                                <?php 
                                    foreach ($dokter as $key => $value) {
                                        echo "<option data-tipe='".$value->tipe_dokter."' value='".$value->id_dokter."'>".$value->nama_dokter."</option>";
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">No Rekam Medis <?php echo form_error('no_rekam_medis'); ?></div>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id'=>'no_rekam_medis','name'=>'no_rekam_medis','type'=>'text','value'=>$no_rekam_medis,'class'=>'form-control','readonly'=>'readonly'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">No ID <?php echo form_error('no_id'); ?></div>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id'=>'no_id','name'=>'no_id','type'=>'text','value'=>$no_id,'class'=>'form-control','onkeyup'=>'autocomplate_no_id()'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">Nik <?php echo form_error('nik'); ?></div>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id'=>'nik','name'=>'nik','type'=>'text','value'=>$nik,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">Nama Lengkap <?php echo form_error('nama_lengkap'); ?></div>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id'=>'nama_lengkap','name'=>'nama_lengkap','type'=>'text','value'=>$nama_lengkap,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-4">Tanggal Lahir <?php echo form_error('tanggal_lahir'); ?></div>
							<div class="col-sm-8">
							    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?php echo $tanggal_lahir;?>" />
							</div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">Golongan Darah <?php echo form_error('golongan_darah'); ?></div>
                            <div class="col-sm-8">
                                <?php echo form_dropdown('golongan_darah', array(''=>'Pilih Golongan Darah','A'=>'A','B'=>'B','AB'=>'AB','O'=>'O'),$golongan_darah,array('id'=>'golongan_darah','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">Status Menikah <?php echo form_error('status_menikah'); ?></div>
                            <div class="col-sm-8">
                                <?php echo form_dropdown('status_menikah', array(''=>'Pilih Status Menikah','Menikah'=>'Menikah','Belum Menikah'=>'Belum Menikah'),$status_menikah,array('id'=>'status_menikah','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">Pekerjaan <?php echo form_error('pekerjaan'); ?></div>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id'=>'pekerjaan','name'=>'pekerjaan','type'=>'text','value'=>$pekerjaan,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">Kabupaten/Kota <?php echo form_error('kabupaten') ?></div>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id'=>'kabupaten','name'=>'kabupaten','type'=>'text','value'=>$kabupaten,'class'=>'form-control'));?>
                                <?php // echo form_dropdown('kabupaten',$kabupaten_opt,$kabupaten,array('id'=>'kabupaten','class'=>'form-control select2','onchange'=>'get_kecamatan(this)'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">Alamat <?php echo form_error('alamat'); ?></div>
                            <div class="col-sm-8">
                                <?php echo form_textarea(array('id'=>'alamat','name'=>'alamat','type'=>'textarea','value'=>$alamat,'rows'=>'2','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">RT <?php echo form_error('rt') ?></div>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id'=>'rt','name'=>'rt','type'=>'text','value'=>$rt,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">RW <?php echo form_error('rw') ?></div>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id'=>'rw','name'=>'rw','type'=>'text','value'=>$rw,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <div class="col-sm-4">Kecamatan <?php echo form_error('kecamatan'); ?></div>-->
                        <!--    <div class="col-sm-8">-->
                                <?php // echo form_input(array('id'=>'kecamatan','name'=>'kecamatan','type'=>'text','value'=>$kecamatan,'class'=>'form-control'));?>
                        <!--        <?php echo form_dropdown('kecamatan',$kecamatan_opt,'',array('id'=>'kecamatan','class'=>'form-control select2','onchange'=>'get_kelurahan(this)'));?>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!--<div class="form-group">-->
                        <!--    <div class="col-sm-4">Kelurahan/Desa <?php echo form_error('kelurahan'); ?></div>-->
                        <!--    <div class="col-sm-8">-->
                                <?php // echo form_input(array('id'=>'kelurahan','name'=>'kelurahan','type'=>'text','value'=>$kelurahan,'class'=>'form-control'));?>
                        <!--        <?php echo form_dropdown('kelurahan',$kelurahan_opt,'',array('id'=>'kelurahan','class'=>'form-control select2'));?>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="form-group">
                            <div class="col-sm-4">Nama Orang Tua / Istri <?php echo form_error('nama_orangtua_atau_istri'); ?></div>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id'=>'nama_orangtua_atau_istri','name'=>'nama_orangtua_atau_istri','type'=>'text','value'=>$nama_orangtua_atau_istri,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">Nomor Telepon <?php echo form_error('nomor_telepon'); ?></div>
                            <div class="col-sm-8">
                                <?php echo form_input(array('id'=>'nomor_telepon','name'=>'nomor_telepon','type'=>'text','value'=>$nomor_telepon,'class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">Tipe Pemeriksaan</div>
                            <div class="col-sm-8">
                                <select name="tipe_periksa" id="tipe_dokter_umum" class="form-control">
                                    <option value="1">Periksa Medis</option>
                                    <option value="2">Imunisasi Anak</option>
                                    <option value="3">Kontrol Kehamilan</option>
                                    <option value="5">Jasa Lainnya</option>
                                    <option value="6">Pemeriksaan LAB</option>
                                </select>
                                <select name="tipe_periksa" id="tipe_dokter_gigi" class="form-control" style="display:none" readonly>
                                    <option value="4">Pemeriksaan Gigi</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group" id="jasa_lainnya" style="display:none">
                            <div class="col-sm-4">Jasa Lainnya</div>
                            <div class="col-sm-8">
                                <select name="periksa_jasa[]" class="form-control select2" multiple="multiple" style="width:100%" disabled>
                                    <?php 
                                        foreach ($jasa_lainnya as $key => $value) {
                                            echo "<option value='".$value->id_tipe."'>".$value->item."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="pemeriksaan_lab" style="display:none">
                            <div class="col-sm-4">Pemeriksaan LAB</div>
                            <div class="col-sm-8">
                                <select name="periksa_lab[]" class="form-control select2" multiple="multiple" style="width:100%" disabled>
                                    <?php 
                                        foreach ($periksa_lab as $key => $value) {
                                            echo "<option value='".$value->id_tipe."'>".$value->item."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div align="right">
                                    <a href="<?php echo site_url('pendaftaran') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Simpan Pendaftaran</button> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">STATUS PEMERIKSAAN DOKTER</h3>
                    </div>
                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Nama Dokter</th>
                                    <th>No Pendaftaran</th>
                                    <th>Status Dokter</th>
                                    <th>Sisa Antrian</th>
                                    <!--<th width="100px">Action</th>-->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">ATUR STATUS DOKTER DAN KLINIK PERIKSA</h3>
                    </div>
                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <table class="table table-bordered table-striped" id="mytable2">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Nama Dokter</th>
                                    <th>Status Dokter</th>
                                    <th>Nama Klinik</th>
                                    <th>Action</th>
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
        $(".namaDokter").change(function(){
            var tipe = $(this).find(":selected").attr('data-tipe')

            if(tipe=='2'){
                $("#tipe_dokter_gigi").show()
                $("#tipe_dokter_gigi").attr('disabled',false)
                $("#tipe_dokter_umum").hide()
                $("#tipe_dokter_umum").attr('disabled',true)
            }
            else{
                $("#tipe_dokter_gigi").hide()
                $("#tipe_dokter_gigi").attr('disabled',true)
                $("#tipe_dokter_umum").show()
                $("#tipe_dokter_umum").attr('disabled',false)
            }
        })
        // $("#tipe_dokter_umum").change(function(){
        //     var thisVal = $(this).val()

        //     if(thisVal=='5'){
        //         $("#jasa_lainnya").show();
        //         $("#jasa_lainnya select").attr('disabled',false);

        //         $("#pemeriksaan_lab").hide();
        //         $("#pemeriksaan_lab select").attr('disabled',true);
        //     }
        //     else if(thisVal=='6'){
        //         $("#jasa_lainnya").hide();
        //         $("#jasa_lainnya select").attr('disabled',true);

        //         $("#pemeriksaan_lab").show();
        //         $("#pemeriksaan_lab select").attr('disabled',false);
        //     }
        //     else{
        //         $("#jasa_lainnya").hide();
        //         $("#jasa_lainnya select").attr('disabled',true);

        //         $("#pemeriksaan_lab").hide();
        //         $("#pemeriksaan_lab select").attr('disabled',true);
        //     }
        // })
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
            ajax: {"url": "../pendaftaran/json_status_dokter", "type": "POST"},
            columns: [
                {
                    "data": "id_dokter",
                    "orderable": false
                },{"data": "nama_dokter"},{"data": "no_pendaftaran"},{"data": "status"},{"data": "sisa_antrian"}
            ],
            order: [[3, 'asc']],
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
            ajax: {"url": "../pendaftaran/json_status_dokter2", "type": "POST"},
            columns: [
                {
                    "data": "id_dokter",
                    "orderable": false
                },{"data": "nama_dokter"},{"data": "status"},{"data": "klinik"},{"data": "action","className":"text-center"}
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
        
    });
</script>
<script type="text/javascript">
    
    // $(document).ready(function() {
    //     alert('coba');
    // });
    
    function autocomplate_no_id(){
        //autocomplete
        $("#no_id").autocomplete({
            source: "<?php echo base_url() ?>index.php/pendaftaran/autocomplate_no_id_pasien",
            minLength: 1
        });
        autoFill();
    }
    
    function autoFill(){
        var no_id = $("#no_id").val();
        $.ajax({
            url: "<?php echo base_url() ?>index.php/pendaftaran/autofill",
            data:"no_id="+no_id ,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#no_rekam_medis').val(obj.no_rekam_medis);
            $('#nama_lengkap').val(obj.nama_lengkap);
			$('#pekerjaan').val(obj.pekerjaan);
			$('#alamat').val(obj.alamat);
			$('#kabupaten').val(obj.kabupaten);
			$('#kecamatan').val(obj.kecamatan);
			$('#kelurahan').val(obj.kelurahan);
			$('#nama_orangtua_atau_istri').val(obj.nama_orangtua_atau_istri);
			$('#nomor_telepon').val(obj.nomor_telepon);
			$('#golongan_darah').val(obj.golongan_darah);
			$('#status_menikah').val(obj.status_menikah);
			
			if(obj.no_rekam_medis == null)
			    $('#no_rekam_medis').val("<?php echo $no_rekam_medis_default;?>");
        });
    }
    
    
    
</script>



