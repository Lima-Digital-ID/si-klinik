<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-rekam_medis')); ?>
<input type="hidden" name="no_periksa" value="<?php echo $no_periksa;?>" />
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">FORM PENGAMBILAN OBAT</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
							<div class="col-sm-12"><label>DATA PASIEN</label></div>
                        </div>
						<div class="form-group">
							<div class="col-sm-2">No Rekam Medis</div>
							<div class="col-sm-4"><?php echo $no_rekam_medis;?></div>
							<div class="col-sm-2">No Periksa</div>
							<div class="col-sm-4"><?php echo $no_periksa;?></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Nama Pasien</div>
							<div class="col-sm-4"><?php echo $nama_pasien;?></div>
							<div class="col-sm-2">Alamat Pasien</div>
							<div class="col-sm-4"><?php echo $alamat;?></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Note Dokter</div>
							<div class="col-sm-10"><?php echo $note_apoteker;?></div>
                        </div>
                        <!--<hr />-->
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-12"><label>DATA PERIKSA MEDIS</label></div>-->
       <!--                 </div>-->
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-2">No Periksa</div>-->
							<!--<div class="col-sm-4"><?php echo $no_periksa;?></div>-->
							<!--<div class="col-sm-2">Anamnesi</div>-->
							<!--<div class="col-sm-4"><?php echo $anamnesi;?></div>-->
       <!--                 </div>-->
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-2">Diagnosa</div>-->
							<!--<div class="col-sm-4"><?php echo $diagnosa;?></div>-->
							<!--<div class="col-sm-2">Tindakan</div>-->
							<!--<div class="col-sm-4"><?php echo $tindakan?></div>-->
       <!--                 </div>-->
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-2">Nama Dokter</div>-->
							<!--<div class="col-sm-4"><?php echo $nama_dokter;?></div>-->
							<!--<div class="col-sm-2">Catatan Dokter</div>-->
							<!--<div class="col-sm-4"><?php echo $note_dokter != null ? $note_dokter : '-';?></div>-->
       <!--                 </div>-->
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-2">Tanggal Periksa</div>-->
							<!--<div class="col-sm-4"><?php echo $tgl_periksa;?></div>-->
       <!--                 </div>-->
       <!--                 <hr />-->
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-12"><label>DATA PERIKSA FISIK</label></div>-->
       <!--                 </div>-->
<?php
//foreach($periksa_d_fisik as $data){
?>
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-2"><?php echo $data->nama_periksa_fisik;?></div>-->
							<!--<div class="col-sm-4"><?php echo $data->nilai_periksa_fisik;?></div>-->
       <!--                 </div>-->
<?php
//}
?>
       <!--                 <hr />-->
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-12"><label>DATA ALAT KESEHATAN</label></div>-->
       <!--                 </div>-->
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-2"><label>Nama Alat Kesehatan</label></div>-->
							<!--<div class="col-sm-2"><label>Jumlah</label></div>-->
							<!--<div class="col-sm-2"><label>Harga</label></div>-->
							<!--<div class="col-sm-2"><label>Total Harga</label></div>-->
       <!--                 </div>-->
<?php
// foreach($periksa_d_alkes as $data){
?>
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-2"><?php echo $data->nama_barang;?></div>-->
							<!--<div class="col-sm-2"><?php echo $data->jumlah;?></div>-->
							<!--<div class="col-sm-2"><?php echo number_format($data->harga,2,',','.');?></div>-->
							<!--<div class="col-sm-2"><?php echo number_format($data->harga * $data->jumlah,2,',','.');?></div>-->
       <!--                 </div>-->
<?php
//}
?>
                        <hr />
                        <div class="form-group">
							<div class="col-sm-12"><label>DATA OBAT - Centang Obat yang Akan Ditebus</label></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1"><div align="center"><input type="checkbox" id="select_all" /></div></div>
							<div class="col-sm-2"><label>Nama Obat</label></div>
							<div class="col-sm-2"><label>Anjuran</label></div>
							<div class="col-sm-2"><label>Keterangan</label></div>
							<div class="col-sm-1"><label>Jumlah</label></div>
							<div class="col-sm-4"><label>Penggunaan Obat</label></div>
							<!--<div class="col-sm-2"><label>Harga</label></div>-->
							<!--<div class="col-sm-2"><label>Total Harga</label></div>-->
                        </div>
                        <?php
foreach($periksa_d_obat as $data){
?>
                        <input type="hidden" name="obat[]" value="<?php echo $data->kode_barang;?>" />
                        <div class="form-group">
                            <div class="col-sm-1">
                                <div align="center">
                                    <input id="check[]" class="checkbox" type="checkbox" name="check[]" value="<?php echo $data->id_periksa_d_obat;?>" onchange="check1()">
                                    <input class="check_hidden" type="hidden" name="check_hidden[]" value="<?php echo $data->id_periksa_d_obat;?>" />
                                </div>
                            </div>
							<div class="col-sm-2"><?php echo $data->nama_barang;?></div>
    						<div class="col-sm-2"><?php echo $data->anjuran;?></div>
							<div class="col-sm-2"><?php echo $data->keterangan != 0 ? "Puyer" . $data->keterangan : "Non Puyer";?></div>
                            <div class="col-sm-1">
                                <?php echo $data->jumlah;?>
                                <input type="hidden" name="jml_obat[]" value="<?php echo $data->jumlah;?>" />
                            <?php 
                            // $stok = $data->stok_barang;
                            // $option_jml = array();
                            // for($i = 1;$i <= $stok; $i++){
                            //     $option_jml[$i] = $i;
                            // }
                            
                            // echo form_dropdown('jml_obat[]', $option_jml,$data->jumlah,array('id'=>'jml_obat[]','class'=>'form-control','onchange'=>'get_harga(this)'));
                             ?>
                            </div>
                            <div class="col-sm-2"><?php echo $data->penggunaan_obat;?></div>
    						<div style="display:none;">
                                    <?php echo form_input(array('id'=>'harga_obat[]','name'=>'harga_obat[]','type'=>'text','value'=>$data->harga,'class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                            </div>
                            <div style="display:none;">
                                    <?php echo form_input(array('id'=>'total_harga_obat[]','name'=>'total_harga_obat[]','type'=>'text','value'=>$data->harga * $data->jumlah,'class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                            </div>
                        </div>
<?php
}
?>
                        <hr />
                        <div class="form-group">
							<div class="col-sm-12">
								<div align="right">
									<button type="submit" class="btn btn-success"><i class="fa fa-medkit"></i> Ambil Obat Sekarang</button> 
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

    var select_all = document.getElementById("select_all"); //select all checkbox
    var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items
    var check_hidden = document.getElementsByClassName("check_hidden"); //checkbox items
    
    //select all checkboxes
    select_all.addEventListener("change", function(e){
        for (i = 0; i < checkboxes.length; i++) { 
            checkboxes[i].checked = select_all.checked;
        }
    });
    
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function(e){ //".checkbox" change 
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(this.checked == false){
                select_all.checked = false;
            }
            //check "select all" if all checkbox items are checked
            if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
                select_all.checked = true;
            }
        });
        
        // check_hidden[i].value = 0;
        // if(checkboxes[i].checked == false){
        //     alert(check_hidden[i].value);
        // }
    }


    function check1(){
        var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items
        var check_hidden = document.getElementsByClassName("check_hidden");
        
        for (var i = 0; i < checkboxes.length; i++) {
            if(checkboxes[i].checked == false){
                check_hidden[i].value = 0;
            } else {
                check_hidden[i].value = checkboxes[i].value;
            }
        }
    }

    function get_harga(selectObject){
        var obat_length = $("[id^=jml_obat]").length;
        for(x = 0; x < obat_length; x++){
            var jml_obat = parseInt($("[id^=jml_obat]").eq(x).val());
            var harga_bat = parseInt($("[id^=harga_obat]").eq(x).val());
            $("[id^=total_harga_obat]").eq(x).val(jml_obat*harga_bat);
        }
    }
</script>
