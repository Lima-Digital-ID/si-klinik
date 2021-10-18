<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-rekam_medis')); ?>
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
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">FORM SURAT KETERANGAN SEHAT</h3>
                    </div>
                    <div class="box-body">
						<div class="form-group">
							<div class="col-sm-2">Nomor <?php echo form_error('nomor'); ?></div>
							<div class="col-sm-1">
                                    <?php echo form_input(array('id'=>'nomor','name'=>'nomor','type'=>'text','value'=> $nomor,'class'=>'form-control'));?>
							</div>
                            <div class="col-sm-9" style="padding-left:0px">
                                <h4 style="margin-top:5px;"><?= "/".date('m')."/KR/SH/".date('y') ?></h4>
                            </div>
                        </div>
						<div class="form-group">
							<div class="col-sm-2">Nama <?php echo form_error('nama'); ?></div>
							<div class="col-sm-10">
                                    <?php echo form_input(array('id'=>'nama','name'=>'nama','type'=>'text','value'=>'','class'=>'form-control'));?>
							</div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Jenis Kelamin <?php echo form_error('jenis_kelamin'); ?></div>
							<div class="col-sm-10">
                                <div class="radio">
                                    <label>
                                        <?php echo form_radio(array('id'=>'jenis_kelamin','name'=>'jenis_kelamin','value'=>'L'));?>
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <?php echo form_radio(array('id'=>'jenis_kelamin','name'=>'jenis_kelamin','value'=>'P'));?>
                                        Perempuan
                                    </label>
                                </div>
							</div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Umur <?php echo form_error('umur'); ?></div>
                            <div class="col-sm-10">
                                    <?php echo form_input(array('id'=>'umur','name'=>'umur','type'=>'number','value'=>'','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">Pekerjaan <?php echo form_error('pekerjaan'); ?></div>
                            <div class="col-sm-10">
                                    <?php echo form_input(array('id'=>'pekerjaan','name'=>'pekerjaan','type'=>'text','value'=>'','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Tinggi Badan <?php echo form_error('tinggi_badan'); ?></div>
							<div class="col-sm-10">
                                    <?php echo form_input(array('id'=>'tinggi_badan','name'=>'tinggi_badan','type'=>'number','value'=>'','class'=>'form-control'));?>
							</div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Berat Badan <?php echo form_error('berat_badan'); ?></div>
							<div class="col-sm-10">
                                    <?php echo form_input(array('id'=>'berat_badan','name'=>'berat_badan','type'=>'number','value'=>'','class'=>'form-control'));?>
							</div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Golongan Darah <?php echo form_error('golongan_darah'); ?></div>
							<div class="col-sm-10">
                                    <?php echo form_input(array('id'=>'golongan_darah','name'=>'golongan_darah','type'=>'text','value'=>'','class'=>'form-control'));?>
							</div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Buta Warna <?php echo form_error('buta_warna'); ?></div>
							<div class="col-sm-10">
                                    <?php echo form_input(array('id'=>'buta_warna','name'=>'buta_warna','type'=>'text','value'=>'','class'=>'form-control'));?>
							</div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Alamat <?php echo form_error('alamat'); ?></div>
							<div class="col-sm-10">
                                <?php echo form_textarea(array('id'=>'alamat','name'=>'alamat','type'=>'textarea','value'=>'','rows'=>'4','class'=>'form-control'));?>
                            </div>
						</div>
                        <div class="form-group">
							<div class="col-sm-2">Keperluan <?php echo form_error('keperluan'); ?></div>
							<div class="col-sm-10">
                                <?php echo form_textarea(array('id'=>'keperluan','name'=>'keperluan','type'=>'textarea','value'=>'','rows'=>'4','class'=>'form-control'));?>
                            </div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div align="right">
								    <input class="btn btn-warning" type="reset" value="Reset" />
                                    <button type="submit" class="btn btn-danger" onclick="tab1Show();"><i class="fa fa-print"></i> Cetak Surat</button> 
                                    <script type="text/javascript"> 
                                        function tab1Show()
                                        {
                                            // document.location.reload()
                                        //     // var is_cetak = $('#is_cetak_surat:checked').val();
                                        //     // if(is_cetak)
                                        //         window.open('<?php // echo site_url('periksamedis/cetak_sksehat');?>', '_blank');
                                        }
                                    </script>
								</div>
							</div>
						</div>    
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php echo form_close();?>