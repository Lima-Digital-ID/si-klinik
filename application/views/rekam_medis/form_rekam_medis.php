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
<div class="content-wrapper"  id="tab1">
    <section class="content-header">
        <h1>
        Rekam Medis
        <small>| Tindakan</small>
      </h1>
    </section>
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
                        <h3 class="box-title">DATA SEBELUMNYA</h3>
                    </div>
                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Tanggal Periksa</th>
                                    <th>Anamnesi</th>
                                    <th>Diagnosa</th>
                                    <th>Obat Detail</th>
                                    <!--<th width="100px">Action</th>-->
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
            <?php
            if(trim($riwayat_alergi_obat) != '')
                echo alert('alert-info', 'Info', 'Pasien memiliki riwayat alergi obat : ' . '<b>' . $riwayat_alergi_obat . '</b>'); 
            ?>
            </div>
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">FORM PEMERIKSAAN MEDIS</h3>
                    </div>
                    <div class="box-body">
						<div class="form-group">
							<div class="col-sm-2">No Periksa <?php echo form_error('no_periksa'); ?></div>
							<div class="col-sm-10">
                                    <?php echo form_input(array('id'=>'no_periksa','name'=>'no_periksa','type'=>'text','value'=>$no_periksa,'class'=>'form-control','readonly'=>'readonly'));?>
							</div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Nama Lengkap</div>
							<div class="col-sm-10">
                                <?php echo form_input(array('id'=>'nama_lengkap','name'=>'nama_lengkap','type'=>'text','value'=>$nama_lengkap,'class'=>'form-control','readonly'=>'readonly'));?>
                            </div>
						</div>
						<div class="form-group">
							<div class="col-sm-2">Alamat</div>
							<div class="col-sm-10">
                                <?php echo form_textarea(array('id'=>'alamat','name'=>'alamat','type'=>'textarea','value'=>$alamat,'rows'=>'4','class'=>'form-control','readonly'=>'readonly'));?>
                            </div>
						</div>
						<div class="form-group">
							<div class="col-sm-2">Anamnesi <?php echo form_error('anamnesi'); ?></div>
							<div class="col-sm-10">
                                <?php echo form_textarea(array('id'=>'anamnesi','name'=>'anamnesi','type'=>'textarea','value'=>'','rows'=>'4','class'=>'form-control'));?>
                            </div>
						</div>
						<div class="form-group">
							<div class="col-sm-2">Riwayat Alergi Obat <?php echo form_error('riwayat_alergi_obat'); ?></div>
							<div class="col-sm-10">
                                <?php echo form_textarea(array('id'=>'riwayat_alergi_obat','name'=>'riwayat_alergi_obat','type'=>'textarea','value'=>$riwayat_alergi_obat,'rows'=>'4','class'=>'form-control','onchange'=>'riwayat_alergi()'));?>
                            </div>
						</div>
						<hr />
						<div class="form-group">
							<div class="col-sm-2">Berat Badan</div>
							<div class="col-sm-4">
                                <?php echo form_input(array('id'=>'berat_badan','name'=>'berat_badan','type'=>'text','value'=>'','class'=>'form-control'));?>
                            </div>
							<div class="col-sm-2">Tekanan Darah</div>
							<div class="col-sm-4">
                                <?php echo form_input(array('id'=>'tekanan_darah','name'=>'tekanan_darah','type'=>'text','value'=>'','class'=>'form-control'));?>
                            </div>
						</div>
						<div class="form-group">
							<div class="col-sm-2">Tinggi Badan</div>
							<div class="col-sm-4">
                                <?php echo form_input(array('id'=>'tinggi_badan','name'=>'tinggi_badan','type'=>'text','value'=>'','class'=>'form-control'));?>
                            </div>
							<div class="col-sm-2">Suhu Tubuh</div>
							<div class="col-sm-4">
                                <?php echo form_input(array('id'=>'suhu_tubuh','name'=>'suhu_tubuh','type'=>'text','value'=>'','class'=>'form-control'));?>
                            </div>
						</div>
						<div id="input_fields_wrap_cek_fisik">
							<div class="form-group">
								<div class="col-sm-2"><input type="text" name="cek_fisik[]" class="form-control"></div>
								<div class="col-sm-4">
									<input type="text" name="cek_fisik_value[]" class="form-control">
								</div>
								<div class="col-sm-2"><input type="text" name="cek_fisik[]" class="form-control"></div>
								<div class="col-sm-4">
									<input type="text" name="cek_fisik_value[]" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div align="right">
									<button id="add_field_button_cek_fisik"><i class="fa fa-plus"></i>Tambah</button>
								</div>
							</div>
						</div>
						<hr />
						<div class="form-group">
							<div class="col-sm-2">Diagnosa <?php echo form_error('diagnosa'); ?></div>
							<div class="col-sm-10">
                                <?php echo form_textarea(array('id'=>'diagnosa','name'=>'diagnosa','type'=>'textarea','value'=>'','rows'=>'4','class'=>'form-control'));?>
                            </div>
						</div>
						<div class="form-group">
							<div class="col-sm-2">Diagnosa ICD 10 <?php echo form_error('id_diagnosa'); ?></div>
							<div class="col-sm-10">
                                <select name="id_diagnosa[]" class="form-control select2" multiple="multiple" id="">
                                    <?php
                                        foreach ($diagnosa_icd10 as $value) {
                                            echo "<option value='".$value->id_diagnosa."'>".$value->code." - ".$value->diagnosa."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
						</div>
						<!--
						<div class="form-group">
							<div class="col-sm-2">Diagnosa</div>
							<div class="col-sm-4">
								<input type="text" name="diagnosa_value[]" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-4">
								<input type="text" name="diagnosa_value[]" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-4">
								<input type="text" name="diagnosa_value[]" class="form-control">
							</div>
						</div>
						<div id="input_fields_wrap_diagnosa">
							<div class="form-group">
								<div class="col-sm-2"></div>
								<div class="col-sm-4">
									<input type="text" name="diagnosa_value[]" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6">
								<div align="right">
									<button id="add_field_button_diagnosa"><i class="fa fa-plus"></i>Tambah</button>
								</div>
							</div>
						</div>
						-->
						<div class="form-group">
							<div class="col-sm-12">
								<div align="right">
									<input type="button" class="btn btn-info" onclick="tab2Show();" value="Lanjut" />
                                    <script type="text/javascript"> 
                                        function tab2Show()
                                        {
                                            document.getElementById("tab1"    ).style.display="none";
                                            document.getElementById("tab2").style.display="block";
                                            $('#tindakan').focus();
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
<div class="content-wrapper"  id="tab2" style = "display:none;">
    <section class="content-header">
        <h1>
        <small>Rekam Medis |</small>
        Tindakan
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">FORM TINDAKAN MEDIS</h3>
                    </div>
                    <div class="box-body">
      <!--                  <div class="form-group">-->
						<!--	<div class="col-sm-2">Riwayat Alergi Obat</div>-->
						<!--	<div class="col-sm-10">-->
      <!--                          <?php echo form_textarea(array('id'=>'riwayat_alergi_obat2','name'=>'riwayat_alergi_obat2','type'=>'textarea','value'=>'','rows'=>'4','class'=>'form-control', 'readonly'=>''));?>-->
      <!--                      </div>-->
						<!--</div>  -->
						<!--<hr />-->
						<div class="form-group">
							<div class="col-sm-2">Tindakan</div>
							<div class="col-sm-10">
                                <?php echo form_textarea(array('id'=>'tindakan','name'=>'tindakan','type'=>'textarea','value'=>'','rows'=>'4','class'=>'form-control'));?>
                            </div>
						</div>
						<hr />
						<!--<div id="input_fields_wrap_alkes">-->
    		<!--				<div class="form-group">-->
    		<!--					<div class="col-sm-2">Alat Kesehatan</div>-->
    		<!--					<div class="col-sm-6">-->
      <!--                              <div class="input-group">-->
      <!--                                  <span class="input-group-addon">1</span>-->
      <!--                                  <?php echo form_dropdown('alat_kesehatan[]',$alkes_option,'',array('id'=>'alat_kesehatan[]','class'=>'form-control select2','onchange'=>'get_alkes(this)','style'=>'width:100%;'));?>-->
      <!--                                  </div>-->
      <!--                          </div>-->
    		<!--					<div class="col-sm-2">-->
      <!--                              <?php echo form_dropdown('jml_alat_kesehatan[]', array(''=>'Pilih Jumlah'),'',array('id'=>'jml_alat_kesehatan[]','class'=>'form-control','onchange'=>'get_alkes(this, true)'));?>-->
      <!--                          </div>-->
    		<!--					<div class="col-sm-2">-->
      <!--                              <?php echo form_input(array('id'=>'harga_alkes[]','name'=>'harga_alkes[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>-->
      <!--                          </div>-->
    		<!--				</div>-->
    		<!--				<div class="form-group">-->
    		<!--					<div class="col-sm-2"></div>-->
    		<!--					<div class="col-sm-6">-->
      <!--                              <div class="input-group">-->
      <!--                                  <span class="input-group-addon">2</span>-->
      <!--                                  <?php echo form_dropdown('alat_kesehatan[]',$alkes_option,'',array('id'=>'alat_kesehatan[]','class'=>'form-control select2','onchange'=>'get_alkes(this)','style'=>'width:100%;'));?>-->
      <!--                                  </div>-->
      <!--                          </div>-->
    		<!--					<div class="col-sm-2">-->
      <!--                              <?php echo form_dropdown('jml_alat_kesehatan[]', array(''=>'Pilih Jumlah'),'',array('id'=>'jml_alat_kesehatan[]','class'=>'form-control','onchange'=>'get_alkes(this, true)'));?>-->
      <!--                          </div>-->
    		<!--					<div class="col-sm-2">-->
      <!--                              <?php echo form_input(array('id'=>'harga_alkes[]','name'=>'harga_alkes[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>-->
      <!--                          </div>-->
    		<!--				</div>-->
    					<!--	<div class="form-group">-->
    					<!--		<div class="col-sm-2"></div>-->
    					<!--		<div class="col-sm-6">-->
         <!--                           <div class="input-group">-->
         <!--                               <span class="input-group-addon">3</span>-->
         <!--                               <?php echo form_dropdown('alat_kesehatan[]',$alkes_option,'',array('id'=>'alat_kesehatan[]','class'=>'form-control select2','onchange'=>'get_alkes(this)','style'=>'width:100%;'));?>-->
         <!--                               </div>-->
         <!--                       </div>-->
    					<!--		<div class="col-sm-2">-->
         <!--                           <?php echo form_dropdown('jml_alat_kesehatan[]', array(''=>'Pilih Jumlah'),'',array('id'=>'jml_alat_kesehatan[]','class'=>'form-control','onchange'=>'get_alkes(this, true)'));?>-->
         <!--                       </div>-->
    					<!--		<div class="col-sm-2">-->
         <!--                           <?php echo form_input(array('id'=>'harga_alkes[]','name'=>'harga_alkes[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>-->
         <!--                       </div>-->
    					<!--	</div>-->
    					<!--	<div class="form-group">-->
    					<!--		<div class="col-sm-2"></div>-->
    					<!--		<div class="col-sm-6">-->
         <!--                           <div class="input-group">-->
         <!--                               <span class="input-group-addon">4</span>-->
         <!--                               <?php echo form_dropdown('alat_kesehatan[]',$alkes_option,'',array('id'=>'alat_kesehatan[]','class'=>'form-control select2','onchange'=>'get_alkes(this)','style'=>'width:100%;'));?>-->
         <!--                               </div>-->
         <!--                       </div>-->
    					<!--		<div class="col-sm-2">-->
         <!--                           <?php echo form_dropdown('jml_alat_kesehatan[]', array(''=>'Pilih Jumlah'),'',array('id'=>'jml_alat_kesehatan[]','class'=>'form-control','onchange'=>'get_alkes(this, true)'));?>-->
         <!--                       </div>-->
    					<!--		<div class="col-sm-2">-->
         <!--                           <?php echo form_input(array('id'=>'harga_alkes[]','name'=>'harga_alkes[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>-->
         <!--                       </div>-->
    					<!--	</div>-->
    					<!--</div>-->
						<!--<div class="form-group">-->
						<!--	<div class="col-sm-12">-->
						<!--		<div align="right">-->
						<!--			<button id="add_field_button_alkes"><i class="fa fa-plus"></i>Tambah</button>-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->
						<!--<hr />-->
						<div class="form-group">
    							<div class="col-sm-2"></div>
    							<div class="col-sm-2" align="center">
                                    <label>Nama Obat</label>
                                </div>
    							<div class="col-sm-2" align="center">
                                    <label>Ket (Puyer/Non Puyer)</label>
                                </div>
    							<div class="col-sm-2" align="center">
                                    <label>Jumlah Obat</label>
                                </div>
    							<div class="col-sm-2" align="center">
                                    <label>Anjuran Obat</label>
                                </div>
                                <div class="col-sm-2" align="center">
                                    <label>Penggunaan Obat</label>
                                </div>
    						</div>
						<div id="input_fields_wrap_obat">
    						<div class="form-group">
    							<div class="col-sm-2">Obat</div>
    							<div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">1</span>
                                        <?php echo form_dropdown('obat[]',$obat_option,'',array('id'=>'obat[]','class'=>'form-control select2','onchange'=>'get_obat(this)','style'=>'width:100%;'));?>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo form_dropdown('ket_obat[]', array(''=>'Pilih Keterangan'),'',array('id'=>'ket_obat[]','class'=>'form-control','onchange'=>'get_obat(this)'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('jml_obat[]', array(''=>'Pilih Jumlah'),'',array('id'=>'jml_obat[]','class'=>'form-control select2','onchange'=>'get_obat(this,true)'));?>
                                </div>
    							<div class="col-sm-2">
                                    <input type="text" id="anjuran_obat[]" name="anjuran_obat[]" class="form-control">
                                    <!-- <?php echo form_dropdown('anjuran_obat[]',array(''=>'Pilih Anjuran'),'',array('id'=>'anjuran_obat[]','class'=>'form-control'));?> -->
                                </div>
                                <div class="col-sm-2">
                                    <?php echo form_input(array('id'=>'kegunaan_obat[]','name'=>'kegunaan_obat[]','type'=>'text','value'=>'','class'=>'form-control'));?>
                                </div>
    							<div style="display:none;">
                                    <?php echo form_input(array('id'=>'harga_obat[]','name'=>'harga_obat[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                                </div>
                                <!-- <div class="col-sm-2">
                                    <?php echo form_input(array('id'=>'harga_obat_real[]','name'=>'harga_obat_real[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                                </div> -->
                </div>
    						<!-- <div class="form-group">
    							<div class="col-sm-2"></div>
    							<div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">2</span>
                                        <?php echo form_dropdown('obat[]',$obat_option,'',array('id'=>'obat[]','class'=>'form-control select2','onchange'=>'get_obat(this)','style'=>'width:100%;'));?>
                                        </div>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('ket_obat[]', array(''=>'Pilih Keterangan'),'',array('id'=>'ket_obat[]','class'=>'form-control','onchange'=>'get_obat(this)'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('jml_obat[]', array(''=>'Pilih Jumlah'),'',array('id'=>'jml_obat[]','class'=>'form-control','onchange'=>'get_obat(this,true)'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('anjuran_obat[]',array(''=>'Pilih Anjuran'),'',array('id'=>'anjuran_obat[]','class'=>'form-control'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_input(array('id'=>'kegunaan_obat[]','name'=>'kegunaan_obat[]','type'=>'text','value'=>'','class'=>'form-control'));?>
                                </div>
    							<div style="display:;">
                                    <?php echo form_input(array('id'=>'harga_obat[]','name'=>'harga_obat[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo form_input(array('id'=>'harga_obat_real[]','name'=>'harga_obat_real[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                                </div>
    						</div>
    						<div class="form-group">
    							<div class="col-sm-2"></div>
    							<div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">3</span>
                                        <?php echo form_dropdown('obat[]',$obat_option,'',array('id'=>'obat[]','class'=>'form-control select2','onchange'=>'get_obat(this)','style'=>'width:100%;'));?>
                                        </div>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('ket_obat[]', array(''=>'Pilih Keterangan'),'',array('id'=>'ket_obat[]','class'=>'form-control','onchange'=>'get_obat(this)'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('jml_obat[]', array(''=>'Pilih Jumlah'),'',array('id'=>'jml_obat[]','class'=>'form-control','onchange'=>'get_obat(this,true)'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('anjuran_obat[]',array(''=>'Pilih Anjuran'),'',array('id'=>'anjuran_obat[]','class'=>'form-control'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_input(array('id'=>'kegunaan_obat[]','name'=>'kegunaan_obat[]','type'=>'text','value'=>'','class'=>'form-control'));?>
                                </div>
    							<div style="display:;">
                                    <?php echo form_input(array('id'=>'harga_obat[]','name'=>'harga_obat[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo form_input(array('id'=>'harga_obat_real[]','name'=>'harga_obat_real[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                                </div>
    						</div>
    						<div class="form-group">
    							<div class="col-sm-2"></div>
    							<div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">4</span>
                                        <?php echo form_dropdown('obat[]',$obat_option,'',array('id'=>'obat[]','class'=>'form-control select2','onchange'=>'get_obat(this)','style'=>'width:100%;'));?>
                                        </div>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('ket_obat[]', array(''=>'Pilih Keterangan'),'',array('id'=>'ket_obat[]','class'=>'form-control','onchange'=>'get_obat(this)'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('jml_obat[]', array(''=>'Pilih Jumlah'),'',array('id'=>'jml_obat[]','class'=>'form-control','onchange'=>'get_obat(this,true)'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('anjuran_obat[]',array(''=>'Pilih Anjuran'),'',array('id'=>'anjuran_obat[]','class'=>'form-control'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_input(array('id'=>'kegunaan_obat[]','name'=>'kegunaan_obat[]','type'=>'text','value'=>'','class'=>'form-control'));?>
                                </div>
    							<div style="display:;">
                                    <?php echo form_input(array('id'=>'harga_obat[]','name'=>'harga_obat[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo form_input(array('id'=>'harga_obat_real[]','name'=>'harga_obat_real[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                                </div>
    						</div> -->
    					</div>
						<div class="form-group">
							<div class="col-sm-2">Catatan Apoteker</div>
							<div class="col-sm-10">
								<?php echo form_textarea(array('id'=>'note_apoteker','name'=>'note_apoteker','type'=>'textarea','value'=>'','rows'=>'4','class'=>'form-control'));?>
							</div>
						</div>

    					<div class="form-group">
							<div class="col-sm-12">
								<div align="right">
									<button id="add_field_button_obat"><i class="fa fa-plus"></i>Tambah</button>
								</div>
							</div>
						</div>
						<hr />
						<div class="form-group">
							<div class="col-sm-8"></div>
							<div class="col-sm-2">Total</div>
							<div class="col-sm-2">
                                <?php echo form_input(array('id'=>'total_harga','name'=>'total_harga','type'=>'text','value'=>'','class'=>'form-control','readonly'=>'readonly','style'=>'text-align:right;'));?>
                            </div>
						</div>
						<div class="form-group">
							<div class="col-sm-8"></div>
							<div class="col-sm-2">Subsidi</div>
							<div class="col-sm-2">
                                <?php echo form_input(array('id'=>'subsidi_harga','name'=>'subsidi_harga','type'=>'number','value'=>'0','class'=>'form-control','onchange'=>'display_total_harga()','style'=>'text-align:right;'));?>
                            </div>
						</div>
						<div class="form-group">
							<div class="col-sm-8"></div>
							<div class="col-sm-2">Grand Total</div>
							<div class="col-sm-2">
                                <?php echo form_input(array('id'=>'grandtotal_harga','name'=>'grandtotal_harga','type'=>'text','value'=>'','class'=>'form-control','readonly'=>'readonly','style'=>'text-align:right;'));?>
                            </div>
						</div>
						<hr />
						<div class="form-group">
							<div class="col-sm-2">Surat Keterangan Sakit</div>
							<div class="col-sm-4"><?php echo form_checkbox(array('id' => 'is_cetak_surat','name' => 'is_cetak_surat','value'=>1,'checked'=>false,'onchange'=>'cek_surat()'));?></div>
							<script type="text/javascript"> 
                            function cek_surat(){
                                document.getElementById("show_surat").style.display="none";
                                var is_cetak_surat = $('#is_cetak_surat:checked').val();
                                if(is_cetak_surat == 1)
                                    document.getElementById("show_surat").style.display="block";
                                    
                            }
                            </script>
						</div>
						<div id="show_surat" style="display:none;">
                            <div class="form-group">
                                <div class="col-sm-2">Nomor <?php echo form_error('nomor_skt'); ?></div>
                                <div class="col-sm-1">
                                        <?php echo form_input(array('id'=>'nomor_skt','name'=>'nomor_skt','type'=>'text','value'=> $nomor_skt,'class'=>'form-control'));?>
                                </div>
                                <div class="col-sm-9" style="padding-left:0px">
                                    <h4 style="margin-top:5px;"><?= "/".date('m')."/KR/SK/".date('y') ?></h4>
                                </div>
                            </div>
    						<div class="form-group">
    							<div class="col-sm-2">Kepada/Pekerjaan</div>
    							<div class="col-sm-4">
    								<?php echo form_input(array('id'=>'tujuan_surat','name'=>'tujuan_surat','type'=>'text','value'=>'','class'=>'form-control'));?>
    							</div>
    						</div>
    						<div class="form-group">
    							<div class="col-sm-2">Tanggal Mulai</div>
    							<div class="col-sm-4">
    								<input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" value="<?php echo date("Y-m-d",  time());?>" />
    							</div>
    						</div>
    						<div class="form-group">
    							<div class="col-sm-2">Lama Istirahat</div>
    							<div class="col-sm-4">
    								<div class="input-group">
                                        <?php echo form_input(array('id'=>'lama_istirahat_surat','name'=>'lama_istirahat_surat','type'=>'number','value'=>'','class'=>'form-control'));?>
                                        <span class="input-group-addon">Hari</span>
                                        </div>
    							</div>
    						</div>
						</div>
						<hr />
						<div class="form-group">
							<div class="col-sm-2">Catatan Dokter</div>
							<div class="col-sm-10">
								<?php echo form_textarea(array('id'=>'note_dokter','name'=>'note_dokter','type'=>'textarea','value'=>'','rows'=>'4','class'=>'form-control'));?>
							</div>
						</div>
						<hr />
						<div class="form-group">
							<div class="col-sm-2">Biaya</div>
							<div class="col-sm-4">
								<div class="input-group">
                                    <span class="input-group-addon" style="background-color: #fcffc4;">Pemeriksaan</span>
                                    <?php echo form_input(array('id'=>'biaya_pemeriksaan','name'=>'biaya_pemeriksaan','type'=>'number','value'=>'','class'=>'form-control','style'=>'text-align:right;', 'onchange'=>'hitung_biaya()','placeholder'=>'0'));?>
                                </div>
							</div>
							<div class="col-sm-6">
								<?php // echo form_dropdown('ket_pemeriksaan', array('1'=>'Subsidi','0'=>'Non Subsidi'),'0',array('id'=>'ket_pemeriksaan','class'=>'form-control', 'onchange'=>'hitung_biaya()'));?>
                                  <input type="radio" name="ket_pemeriksaan" id="ket_pemeriksaan" value="1">
                                  Subsidi
                                  &nbsp
                                  <input type="radio" name="ket_pemeriksaan" id="ket_pemeriksaan" value="0" checked onchange="hitung_biaya();">
                                  Non Subsidi
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-4">
								<div class="input-group">
                                    <span class="input-group-addon" style="background-color: #fcffc4;">Tindakan</span>
                                    <input type="hidden" name="tindakan" id="nameTindakan">
                                    <select name="biaya_tindakan" id="biaya_tindakan" style="width:100%" class="select2 form-control" onchange="hitung_biaya()">
                                        <option value="0">---Pilih Tindakan---</option>
                                        <?php 
                                            foreach ($master_tindakan as $key => $value) {
                                                echo "<option data-tindakan='".$value->tindakan."' value='".$value->biaya."'>".$value->kode_tindakan." - ".$value->tindakan." ".number_format($value->biaya,0,',','.')."</option>";
                                            }
                                        ?>
                                    </select>
                                    <?php //echo form_input(array('id'=>'biaya_tindakan','name'=>'biaya_tindakan','type'=>'number','value'=>'','class'=>'form-control','style'=>'text-align:right;', 'onchange'=>'hitung_biaya()','placeholder'=>'0'));?>
                                </div>
							</div>
							<div class="col-sm-6">
								<?php // echo form_dropdown('ket_tindakan', array('1'=>'Subsidi','0'=>'Non Subsidi'),'0',array('id'=>'ket_tindakan','class'=>'form-control', 'onchange'=>'hitung_biaya()'));?>
								  <input type="radio" name="ket_tindakan" id="ket_tindakan" value="1">
                                  Subsidi
                                  &nbsp
                                  <input type="radio" name="ket_tindakan" id="ket_tindakan" value="0" checked onchange="hitung_biaya();">
                                  Non Subsidi
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-4">
								<div class="input-group">
                                    <span class="input-group-addon" style="background-color: #fcffc4;">Obat-obatan</span>
                                    <?php echo form_input(array('id'=>'biaya_obat_obatan','name'=>'biaya_obat_obatan','type'=>'number','value'=>'','class'=>'form-control','style'=>'text-align:right;', 'onchange'=>'hitung_biaya()','placeholder'=>'0'));?>
                                </div>
							</div>
							<div class="col-sm-6">
								<?php // echo form_dropdown('ket_obat_obatan', array('1'=>'Subsidi','0'=>'Non Subsidi'),'0',array('id'=>'ket_obat_obatan','class'=>'form-control', 'onchange'=>'hitung_biaya()'));?>
								<input type="radio" name="ket_obat_obatan" id="ket_obat_obatan" value="1">
                                  Subsidi
                                  &nbsp
                                  <input type="radio" name="ket_obat_obatan" id="ket_obat_obatan" value="0" checked onchange="hitung_biaya();">
                                  Non Subsidi
							</div>
						</div>
						<!--<div class="form-group">-->
						<!--	<div class="col-sm-2"></div>-->
						<!--	<div class="col-sm-4">-->
						<!--		<div class="input-group">-->
      <!--                              <span class="input-group-addon" style="background-color: #fcffc4;">Administrasi</span>-->
      <!--                              <?php echo form_input(array('id'=>'biaya_administrasi','name'=>'biaya_administrasi','type'=>'number','value'=>'','class'=>'form-control','style'=>'text-align:right;', 'onchange'=>'hitung_biaya()','placeholder'=>'0'));?>-->
      <!--                              </div>-->
						<!--	</div>-->
						<!--	<div class="col-sm-6">-->
								<?php // echo form_dropdown('ket_administrasi', array('1'=>'Subsidi','0'=>'Non Subsidi'),'0',array('id'=>'ket_administrasi','class'=>'form-control', 'onchange'=>'hitung_biaya()'));?>
						<!--		<input type="radio" name="ket_administrasi" id="ket_administrasi" value="1" onchange="hitung_biaya();">-->
      <!--                            Subsidi-->
      <!--                            &nbsp-->
      <!--                            <input type="radio" name="ket_administrasi" id="ket_administrasi" value="0" checked onchange="hitung_biaya();">-->
      <!--                            Non Subsidi-->
						<!--	</div>-->
						<!--</div>-->
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-4">
								<div class="input-group">
                                    <span class="input-group-addon" style="background-color: #fcffc4;">Total Biaya</span>
                                    <?php echo form_input(array('id'=>'biaya_total','name'=>'biaya_total','type'=>'number','value'=>'','class'=>'form-control','readonly'=>'readonly','style'=>'text-align:right;','placeholder'=>'0'));?>
                                </div>
							</div>
						</div>
						<hr />
                        <div class="form-group">
							<div class="col-sm-12">
								<div align="right">
									<input type="button" class="btn btn-info" onclick="tab1Show();" value="Kembali" />
                                    <script type="text/javascript"> 
                                        function tab1Show()
                                        {
                                            document.getElementById("tab2").style.display="none";
                                            document.getElementById("tab1").style.display="block";
                                        }
                                    </script>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Simpan Pemeriksaan Medis</button> 
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

<script type="text/javascript">
    $(document).ready(function() {
        $("#biaya_tindakan").change(function(){
            var tindakan = $(this).find(":selected").data('tindakan')
            $("#nameTindakan").val(tindakan)
        })
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
            ajax: {"url": "periksamedis/json_by_id", "type": "POST"},
            columns: [
                {
                    "data": "no_periksa",
                    "orderable": false
                },{"data": "tgl_periksa"},{"data": "anamnesi"},{"data": "diagnosa"},{"data": "obat_detail"}
                ,/*{
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }*/
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
        
        cek_surat();
    });
	
	$(function() {
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}
			 
		var anamnesies = <?php echo $anamnesies;?>;
		var alergi_obat = <?php echo $alergi_obat;?>;
		var diagnosa = <?php echo $diagnosa;?>;
		var tindakan = <?php echo $tindakan;?>;
			 
		$( "#anamnesi" )
		 // don't navigate away from the field on tab when selecting an item
		.bind( "keydown", function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
				event.preventDefault();
			}
		})
		.autocomplete({
			minLength: 0,
			source: function( request, response ) {
				// delegate back to autocomplete, but extract the last term
				response( $.ui.autocomplete.filter(
				anamnesies, extractLast( request.term ) ) );
			},
			//    source:anamnesies,    
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push( ui.item.label );
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				this.value = terms.join( ", " );
			
				return false;
			}
		});
		
		$( "#riwayat_alergi_obat" )
		 // don't navigate away from the field on tab when selecting an item
		.bind( "keydown", function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
				event.preventDefault();
			}
		})
		.autocomplete({
			minLength: 0,
			source: function( request, response ) {
				// delegate back to autocomplete, but extract the last term
				response( $.ui.autocomplete.filter(
				alergi_obat, extractLast( request.term ) ) );
			},
			//    source:anamnesies,    
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push( ui.item.label );
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				this.value = terms.join( ", " );
			
				return false;
			}
		});
		
		$( "#diagnosa" )
		 // don't navigate away from the field on tab when selecting an item
		.bind( "keydown", function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
				event.preventDefault();
			}
		})
		.autocomplete({
			minLength: 0,
			source: function( request, response ) {
				// delegate back to autocomplete, but extract the last term
				response( $.ui.autocomplete.filter(
				diagnosa, extractLast( request.term ) ) );
			},
			//    source:anamnesies,    
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push( ui.item.label );
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				this.value = terms.join( ", " );
			
				return false;
			}
		});
		
		$( "#tindakan" )
		 // don't navigate away from the field on tab when selecting an item
		.bind( "keydown", function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
				event.preventDefault();
			}
		})
		.autocomplete({
			minLength: 0,
			source: function( request, response ) {
				// delegate back to autocomplete, but extract the last term
				response( $.ui.autocomplete.filter(
				tindakan, extractLast( request.term ) ) );
			},
			//    source:anamnesies,    
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push( ui.item.label );
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				this.value = terms.join( ", " );
			
				return false;
			}
		});

    });     

</script>

<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper_cek_fisik         = $("#input_fields_wrap_cek_fisik"); //Fields wrapper
    var add_button_cek_fisik      = $("#add_field_button_cek_fisik"); //Add button ID
	var wrapper_diagnosa		  = $("#input_fields_wrap_diagnosa");
	var add_button_diagnosa       = $("#add_field_button_diagnosa");
	
	var wrapper_alkes		  = $("#input_fields_wrap_alkes");
	var add_button_alkes       = $("#add_field_button_alkes");
	
	var wrapper_obat		  = $("#input_fields_wrap_obat");
	var add_button_obat      = $("#add_field_button_obat");
    
    var x = 1; //initlal text box count
    $(add_button_cek_fisik).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper_cek_fisik).append('<div class="form-group"><div class="col-sm-2"><input type="text" name="cek_fisik[]" class="form-control"></div><div class="col-sm-4"><input type="text" name="cek_fisik_value[]" class="form-control"></div><div class="col-sm-2"><input type="text" name="cek_fisik[]" class="form-control"></div><div class="col-sm-4"><div class="input-group"><input type="text" name="cek_fisik_value[]" class="form-control"><span class="input-group-addon"><a href="#" class="remove_field_cek_fisik">X</a></span></div></div></div>'); //add input box
        }
    });
    
    $(wrapper_cek_fisik).on("click",".remove_field_cek_fisik", function(e){ //user click on remove text
        e.preventDefault(); $(this).closest('.form-group').remove(); x--;
    });
    
    var z = 1; //initlal text box count
    
	$(add_button_alkes).click(function(e){ //on add input button click
        e.preventDefault();
        
        var option_alkes = '<option value="">Pilih Alat Kesehatan</option>';
        var alkes_option_js = <?php echo $alkes_option_js;?>;
        for(i=0;i<alkes_option_js.length;i++){
            option_alkes += '<option value="'+alkes_option_js[i].value+'">'+alkes_option_js[i].label+'</option>';
        }

        var input_alkes = '<select id="alat_kesehatan[]" name="alat_kesehatan[]" class="form-control select2" onchange="get_alkes(this)" style="width:100%;">'+option_alkes+'</select>';
        var input_jml_alkes = '<select id="jml_alat_kesehatan[]" name="jml_alat_kesehatan[]" class="form-control" onchange="get_alkes(this, true)"><option value="">Pilih Jumlah</option></select>';
        var input_harga_alkes = '<input id="harga_alkes[]" name="harga_alkes[]" type="text" value="" class="form-control" readonly="readonly" style="text-align:right;" />';
        
        if(z < max_fields){ //max input box allowed
            z++; //text box increment
            $(wrapper_alkes).append('<div class="form-group"><div class="col-sm-2"></div><div class="col-sm-6"><div class="input-group"><span class="input-group-addon"><a href="#" class="remove_field_alkes">X</a></span>'+input_alkes+'</div></div><div class="col-sm-2">'+input_jml_alkes+'</div><div class="col-sm-2">'+input_harga_alkes+'</div></div>'); //add input box
        }
    });
    
    $(wrapper_alkes).on("click",".remove_field_alkes", function(e){ //user click on remove text
        e.preventDefault(); $(this).closest('.form-group').remove(); z--;
    });
    
    var y = 1; //initlal text box count
    
	$(add_button_obat).click(function(e){ //on add input button click
        e.preventDefault();
        
        var option_alkes = '<option value="">Pilih Obat</option>';
        var alkes_option_js = <?php echo $obat_option_js;?>;
        for(i=0;i<alkes_option_js.length;i++){
            option_alkes += '<option value="'+alkes_option_js[i].value+'">'+alkes_option_js[i].label+'</option>';
        }

        var input_alkes = '<select id="obat[]" name="obat[]" class="form-control select2" onchange="get_obat(this)" style="width:100%;">'+option_alkes+'</select>';
        var input_jml_obat = '<select id="jml_obat[]" name="jml_obat[]" class="form-control select2" onchange="get_obat(this, true)"><option value="">Pilih Jumlah</option></select>';
        // var input_anjuran_obat = '<select id="anjuran_obat[]" name="anjuran_obat[]" class="form-control"><option value="">Pilih Anjuran</option></select>';
        var input_anjuran_obat = '<input type="text" id="anjuran_obat[]" name="anjuran_obat[]" class="form-control">';
        var input_ket_obat = '<select id="ket_obat[]" name="ket_obat[]" class="form-control"><option value="">Pilih Keterangan</option></select>';
        var input_harga_obat = '<input id="harga_obat[]" name="harga_obat[]" type="text" value="" class="form-control" readonly="readonly" style="text-align:right;" />';
        // var input_harga_obat_real = '<input id="harga_obat_real[]" name="harga_obat_real[]" type="text" value="" class="form-control" readonly="readonly" style="text-align:right;" />';
        var input_kegunaan_obat = '<input id="kegunaan_obat[]" name="kegunaan_obat[]" type="text" value="" class="form-control" />';
        
        if(y < max_fields){ //max input box allowed
            y++; //text box increment
            $(wrapper_obat).append('<div class="form-group"><div class="col-sm-2"></div><div class="col-sm-2"><div class="input-group"><span class="input-group-addon"><a href="#" class="remove_field_obat">X</a></span>'+input_alkes+'</div></div><div class="col-sm-2">'+input_ket_obat+'</div><div class="col-sm-2">'+input_jml_obat+'</div><div class="col-sm-2">'+input_anjuran_obat+'</div><div class="col-sm-2">'+input_kegunaan_obat+'</div><div style="display:none;">'
                +input_harga_obat+'</div>'); //add input box
        }
        $('select').select2({
            // dropdownAutoWidth : false,
            width: '100%'
        })
    });
    
    $(wrapper_obat).on("click",".remove_field_obat", function(e){ //user click on remove text
        e.preventDefault(); 
        $(this).closest('.form-group').remove(); y--;
        get_obat(null);
    });
    
    display_total_harga();
    hitung_biaya();
});

	function riwayat_alergi(){
        $('#riwayat_alergi_obat2').val($('#riwayat_alergi_obat').val());
        // alert($('#riwayat_alergi_obat').val());
    }
    
    function get_alkes(selectObject = null, isCheckJml = false) {
        var value = selectObject.value;  
        var alkes_length = $("[id^=alat_kesehatan]").length;
        var alkes = <?php echo $alkes;?>;
        
        for(x = 0; x < alkes_length; x++){
            var kode_barang = $("[id^=alat_kesehatan]").eq(x).val();
            var temp_jml_selected = $("[id^=jml_alat_kesehatan]").eq(x).val();
            
            $.each(alkes, function(i, item) {
                if(alkes[i].kode_barang == kode_barang){
                    if (!isCheckJml)
                        $("[id^=jml_alat_kesehatan]").eq(x).empty();
                        
                    var option = '';
                    var harga = 0;
                    if(alkes[i].stok_barang > 0){
                        if (!isCheckJml){
                            for(y = 0; y < alkes[i].stok_barang; y++){
                                if((y+1) == temp_jml_selected)
                                    option += '<option value="'+(y+1)+'" selected = "selected">'+(y+1)+'</option>';
                                else
                                    option += '<option value="'+(y+1)+'">'+(y+1)+'</option>';
                            }
                        }
                        harga = parseInt(alkes[i].harga);
                    }else{
                        if (!isCheckJml)
                            option += '<option value="">Habis<option>';
                        harga = 0;
                    }
                    
                    if (!isCheckJml)
                        $("[id^=jml_alat_kesehatan]").eq(x).append(option);
                        
                    var jml_barang = $("[id^=jml_alat_kesehatan]").eq(x).val() != '' ? parseInt($("[id^=jml_alat_kesehatan]").eq(x).val()) : 0;
                    $("[id^=harga_alkes]").eq(x).val(jml_barang * harga);
                }
            });
            
            if(kode_barang == ''){
                $("[id^=harga_alkes]").eq(x).val('');
                $("[id^=jml_alat_kesehatan]").eq(x).empty();
                var option = '<option value="">Pilih Jumlah</option>';
                $("[id^=jml_alat_kesehatan]").eq(x).append(option);
            }
        }
        
        display_total_harga();
    }
    
    function get_obat(selectObject = null, isCheckJml = false) {
        // var value = selectObject selectObject.value;  
        var obat_length = $("[id^=obat]").length;
        var obat = <?php echo $obat;?>;
        // var anjuran_obat = <?php echo $anjuran_obat;?>;
        var ket_terbesar = 0;
               
        //Cek value keterangan terbesar
        for(x = 0; x < obat_length; x++){
            var temp_ket = $("[id^=ket_obat]").eq(x).val() != '' ? $("[id^=ket_obat]").eq(x).val() : 0;
            if(temp_ket > ket_terbesar)
                ket_terbesar = temp_ket;
        }
        
        for(x = 0; x < obat_length; x++){
            var kode_barang = $("[id^=obat]").eq(x).val();
            var temp_jml_selected = $("[id^=jml_obat]").eq(x).val();
            // var temp_anjuran_selected = $("[id^=anjuran_obat]").eq(x).val();
            var temp_ket_selected = $("[id^=ket_obat]").eq(x).val();
            
            // console.log($("[id^=anjuran_obat]").length);
            // console.log($("[id^=jml_obat]").length);
            // console.log($("[id^=ket_obat]").length);
            // console.log($("[id^=harga_obat]").length);
            // console.log($("[id^=harga_obat_real]").length);
            $.each(obat, function(i, item) {
                if(obat[i].kode_barang == kode_barang){
                    
                    if (!isCheckJml)
                        $("[id^=jml_obat]").eq(x).empty();
                    // $("[id^=anjuran_obat]").eq(x).empty();
                    $("[id^=ket_obat]").eq(x).empty();
                    
                    var option = '';
                    // var option_anjuran = '';
                    var option_ket = '';
                    var harga = 0;
                    console.log(obat[i].stok_barang);

                    if(obat[i].stok_barang > 0){
                        //Set Jumlah Option
                        if (!isCheckJml){
                            for(y = 0; y < obat[i].stok_barang; y++){
                                if((y+1) == temp_jml_selected || (y+0.5) == temp_jml_selected)
                                    // option += '<option value="'+((y+1)/2)+'">'+(y) + ' 1/2' +'</option>';
                                    // option += '<option value="'+(y+1)+'" selected = "selected">'+(y+1)+'</option>';
                                    if(temp_ket_selected == 0){
                                        // if((y+1) % 5 == 0 || (y+1) % 6 == 0)
                                        option += '<option value="'+(y+1)+'" selected = "selected">'+(y+1)+'</option>';
                                    } else {
                                        if((y+0.5) == temp_jml_selected)
                                            option += '<option value="'+(y+0.5)+'" selected = "selected">'+(y) + ' + 1/2' +'</option>';
                                        else
                                            option += '<option value="'+(y+1)+'" selected = "selected">'+(y+1)+'</option>';
                                    }
                                else
                                    if(temp_ket_selected == 0){
                                        // if((y+1) % 5 == 0 || (y+1) % 6 == 0)
                                        option += '<option value="'+(y+1)+'">'+(y+1)+'</option>';
                                    } else {
                                        option += '<option value="'+(y+0.5)+'">'+(y) + ' + 1/2' +'</option>';
                                        option += '<option value="'+(y+1)+'">'+(y+1)+'</option>';
                                    }
                            }
                        }
                        // //Set Anjuran Option
                        // for(j = 0; j < anjuran_obat.length; j++){
                        //     if (anjuran_obat[j].value == temp_anjuran_selected)
                        //         option_anjuran += '<option value="'+anjuran_obat[j].value+'" selected="selected">'+anjuran_obat[j].label+'</option>';
                        //     else
                        //         option_anjuran += '<option value="'+anjuran_obat[j].value+'">'+anjuran_obat[j].label+'</option>';
                        // }
                        //Set Keterangan Option
                        for(j = 0; j <= (parseInt(ket_terbesar) + 1); j++){
                            var nama_ket = j == 0 ? 'Non Puyer' : 'Puyer ' + j;
                            if (j == temp_ket_selected)
                                option_ket += '<option value="'+j+'" selected="selected">'+ nama_ket +'</option>';
                            else
                                option_ket += '<option value="'+j+'">'+ nama_ket +'</option>';
                        }
                        
                        harga = parseInt(obat[i].harga);
                    }else{
                        if (!isCheckJml)
                            option += '<option value="">Habis</option>';
                        // option_anjuran += '<option value="">Pilih Anjuran</option>';
                        option_ket += '<option value="">Pilih Keterangan</option>';
                        harga = 0;
                    }
                    
                    // if (!isCheckJml)
                        $("[id^=jml_obat]").eq(x).append(option);
                        // $("[id^=anjuran_obat]").eq(x).append(option_anjuran);
                        $("[id^=ket_obat]").eq(x).append(option_ket);
                        
                        var jml_barang = $("[id^=jml_obat]").eq(x).val() != '' ? parseInt(Math.ceil($("[id^=jml_obat]").eq(x).val())) : 0;
                        $("[id^=harga_obat]").eq(x).val(jml_barang * harga);
                        // $("[id^=harga_obat_real]").eq(x).val(harga);
                        // console.log('jml_barang');
                }
            });
            
            if(kode_barang == ''){
                $("[id^=harga_obat]").eq(x).val('');
                // $("[id^=harga_obat_real]").eq(x).val('');
                $("[id^=jml_obat]").eq(x).empty();
                // $("[id^=anjuran_obat]").eq(x).empty();
                $("[id^=ket_obat]").eq(x).empty();
                var option = '<option value="">Pilih Jumlah</option>';
                // var option_anjuran = '<option value="">Pilih Anjuran</option>';
                var option_ket = '<option value="">Pilih Keterangan</option>';
                $("[id^=jml_obat]").eq(x).append(option);
                // $("[id^=anjuran_obat]").eq(x).append(option_anjuran);
                $("[id^=ket_obat]").eq(x).append(option_ket);
            }
        }
        
        display_total_harga();
    }
    
    function display_total_harga(){
        var alkes_length = $("[id^=alat_kesehatan]").length;
        var obat_length = $("[id^=obat]").length;
        var total_harga = 0;
        var subsidi = parseInt($('#subsidi_harga').val() != '' ? $('#subsidi_harga').val() : 0);
        
        //Menghitung dari alat kesehatan
        for(x = 0; x < alkes_length; x++){
            var harga = $("[id^=harga_alkes]").eq(x).val() != '' ? $("[id^=harga_alkes]").eq(x).val() : 0;
            total_harga += parseInt(harga);
        }
        
        //Menghitung dari obat
        for(x = 0; x < obat_length; x++){
            var harga = $("[id^=harga_obat]").eq(x).val() != '' ? $("[id^=harga_obat]").eq(x).val() : 0;
            total_harga += parseInt(harga);
        }
        
        //menghitung subsidi
        if(subsidi > total_harga){
            subsidi = total_harga;
            $('#subsidi_harga').val(total_harga);
        } else if (subsidi < 0){
            subsidi = 0;
            $('#subsidi_harga').val(0);
        }
        
        $('#total_harga').val(total_harga);
        $('#grandtotal_harga').val(total_harga - subsidi);
        hitung_biaya();
    }
    
    function hitung_biaya(){
        
        $('#ket_pemeriksaan:checked').val() == 0 ? $('#biaya_pemeriksaan').val() : $('#biaya_pemeriksaan').val(0);
        $('#ket_tindakan:checked').val() == 0 ? $('#biaya_tindakan').val() : $('#biaya_tindakan').val(0);
        $('#ket_obat_obatan:checked').val() == 0 ? $('#biaya_obat_obatan').val($('#grandtotal_harga').val()) : $('#biaya_obat_obatan').val(0);
        //  $('#ket_administrasi:checked').val() == 0 ? $('#biaya_administrasi').val() : $('#biaya_administrasi').val(0);
        
        // $('input[name=ket_administrasi]:checked').val() == 0 ? alert('0') : alert('1');
        
        //Get Biaya
        var pemeriksaan = $('#biaya_pemeriksaan').val() != '' ? $('#biaya_pemeriksaan').val() : 0;
        var tindakan = $('#biaya_tindakan').val() != '' ? $('#biaya_tindakan').val() : 0;
        var obat_obatan = $('#biaya_obat_obatan').val() != '' ? $('#biaya_obat_obatan').val() : 0;
        // var administrasi = $('#biaya_administrasi').val() != '' ? $('#biaya_administrasi').val() : 0;
        $('#biaya_total').val(parseInt(pemeriksaan) + parseInt(tindakan) + parseInt(obat_obatan)/* + parseInt(administrasi)*/);
    }
    
    $(document).on("change","input[type=radio]",function(){
        hitung_biaya();
    });
    
</script>
