<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-rekam_medis')); ?>
<input type="hidden" name="no_transaksi" value="<?php echo $no_transaksi;?>" />
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">FORM JUAL OBAT</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
							<div class="col-sm-2">Nama Pembeli / Pasien <?php echo form_error('atas_nama'); ?></div>
    						<div class="col-sm-4">
    							<?php echo form_input(array('id'=>'atas_nama','name'=>'atas_nama','type'=>'text','value'=>'','class'=>'form-control'));?>
    						</div>
						</div>
						<hr />
						<div class="form-group">
    							<div class="col-sm-2"></div>
    							<div class="col-sm-4" align="center">
                                    <label>Nama Obat</label>
                                </div>
    							<div class="col-sm-2" align="center">
                                    <label>Jumlah Obat</label>
                                </div>
                                <div class="col-sm-2" align="center">
                                    <label>Harga Satuan</label>
                                </div>
                                <div class="col-sm-2" align="center">
                                    <label>Total Harga</label>
                                </div>
    						</div>
						<div id="input_fields_wrap_obat">
    						<div class="form-group">
    							<div class="col-sm-2">Obat</div>
    							<div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <?php echo form_dropdown('obat[]',$obat_option,'',array('id'=>'obat[]','class'=>'form-control select2','onchange'=>'get_obat(this)','style'=>'width:100%;'));?>
                                        </div>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_dropdown('jml_obat[]', array(''=>'Pilih Jumlah'),'',array('id'=>'jml_obat[]','class'=>'form-control select2','onchange'=>'get_obat(this,true)'));?>
                                </div>
    							<div class="col-sm-2">
                                    <?php echo form_input(array('id'=>'harga_satuan[]','name'=>'harga_satuan[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                                </div>
                                <div class="col-sm-2">
                                    <?php echo form_input(array('id'=>'harga_obat[]','name'=>'harga_obat[]','type'=>'text','value'=>'','class'=>'form-control', 'readonly'=>'readonly','style'=>'text-align:right;'));?>
                                </div>
    						</div>
    					</div>
    					<div class="form-group">
							<div class="col-sm-12">
								<div align="right">
									<button id="add_field_button_obat"><i class="fa fa-plus"></i>Tambah</button>
								</div>
							</div>
						</div>
						<div style="display:none;">
                            <?php echo form_input(array('id'=>'total_harga','name'=>'total_harga','type'=>'text','value'=>'','class'=>'form-control','readonly'=>'readonly','style'=>'text-align:right;'));?>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                            </div>
							<div class="col-sm-10">
								<div align="left">
									<button type="submit" class="btn btn-success"><i class="fa fa-medkit"></i> Jual Obat </button> 
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
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var max_fields      = 20; //maximum input boxes allowed
        var wrapper_obat		  = $("#input_fields_wrap_obat");
	    var add_button_obat      = $("#add_field_button_obat");
	    
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
            var input_harga_satuan = '<input id="harga_satuan[]" name="harga_satuan[]" type="text" value="" class="form-control" readonly="readonly" style="text-align:right;" />';
            var input_harga_obat = '<input id="harga_obat[]" name="harga_obat[]" type="text" value="" class="form-control" readonly="readonly" style="text-align:right;" />';
            
            if(y < max_fields){ //max input box allowed
                y++; //text box increment
                $(wrapper_obat).append('<div class="form-group"><div class="col-sm-2"></div><div class="col-sm-4"><div class="input-group"><span class="input-group-addon"><a href="#" class="remove_field_obat">X</a></span>'+input_alkes+'</div></div><div class="col-sm-2">'+input_jml_obat+'</div><div class="col-sm-2">'+input_harga_satuan+'</div><div class="col-sm-2">'+input_harga_obat+'</div></div>'); //add input box
            }
            $('.select2').select2({
                width : '100%'
            }); 
        });
        
        $(wrapper_obat).on("click",".remove_field_obat", function(e){ //user click on remove text
            e.preventDefault(); 
            $(this).closest('.form-group').remove(); y--;
            get_obat(null);
        });
    });
    
    // function get_obat(selectObject = null, isCheckJml = false){
    //     var value = selectObject.value;  
    //     var obat_length = $("[id^=obat]").length;
    //     var obat = <?php echo $obat;?>;
        
    //     for(x = 0; x < obat_length; x++){
    //         var kode_barang = $("[id^=obat]").eq(x).val();
    //         var temp_jml_selected = $("[id^=jml_obat]").eq(x).val();
            
    //         $.each(obat, function(i, item) {
    //             if(obat[i].kode_barang == kode_barang){
                    
    //                 if (!isCheckJml)
    //                     $("[id^=jml_obat]").eq(x).empty();
                    
    //                 var option = '';
    //                 var harga = 0;
    //                 if(obat[i].stok_barang > 0){
    //                     //Set Jumlah Option
    //                     if (!isCheckJml){
    //                         for(y = 0; y < obat[i].stok_barang; y++){
    //                             if((y+1) == temp_jml_selected)
    //                                 option += '<option value="'+(y+1)+'" selected = "selected">'+(y+1)+'</option>';
    //                             else
    //                                 option += '<option value="'+(y+1)+'">'+(y+1)+'</option>';
    //                         }
    //                     }
                        
    //                     harga = parseInt(obat[i].harga);
    //                 }else{
    //                     if (!isCheckJml)
    //                         option += '<option value="">Habis</option>';
    //                     harga = 0;
    //                 }
                    
    //                 if (!isCheckJml)
    //                     $("[id^=jml_obat]").eq(x).append(option);
                    
    //                 var jml_barang = $("[id^=jml_obat]").eq(x).val() != '' ? parseInt(Math.ceil($("[id^=jml_obat]").eq(x).val())) : 0;
    //                 $("[id^=harga_obat]").eq(x).val(jml_barang * harga);
                    
    //             } else {
    //                 if (!isCheckJml)
    //                     option += '<option value="">Habis</option>';
    //                 harga = 0;
    //             }
                
    //             if (!isCheckJml)
    //                 $("[id^=jml_obat]").eq(x).append(option);
                    
    //             var jml_barang = $("[id^=jml_obat]").eq(x).val() != '' ? parseInt(Math.ceil($("[id^=jml_obat]").eq(x).val())) : 0;
    //             $("[id^=harga_obat]").eq(x).val(jml_barang * harga);
    //         });
            
    //         if(kode_barang == ''){
    //             $("[id^=harga_obat]").eq(x).val('');
    //             $("[id^=jml_obat]").eq(x).empty();
    //             var option = '<option value="">Pilih Jumlah</option>';
    //             $("[id^=jml_obat]").eq(x).append(option);
    //         }
    //     }
    // }
    
    function get_obat(selectObject = null, isCheckJml = false) {
        // var value = selectObject selectObject.value;  
        var obat_length = $("[id^=obat]").length;
        var obat = <?php echo $obat;?>;
        
        for(x = 0; x < obat_length; x++){
            var kode_barang = $("[id^=obat]").eq(x).val();
            var temp_jml_selected = $("[id^=jml_obat]").eq(x).val();
            // var temp_anjuran_selected = $("[id^=anjuran_obat]").eq(x).val();
            // var temp_ket_selected = $("[id^=ket_obat]").eq(x).val();
            $.each(obat, function(i, item) {
                if(obat[i].kode_barang == kode_barang){
                    
                    if (!isCheckJml)
                        $("[id^=jml_obat]").eq(x).empty();
                    // $("[id^=anjuran_obat]").eq(x).empty();
                    // $("[id^=ket_obat]").eq(x).empty();
                    
                    var option = '';
                    // var option_anjuran = '';
                    // var option_ket = '';
                    var harga = 0;
                    if(obat[i].stok_barang > 0){
                        //Set Jumlah Option
                        if (!isCheckJml){
                            for(y = 0; y < obat[i].stok_barang; y++){
                                if((y+1) == temp_jml_selected) 
                                    option += '<option value="'+(y+1)+'" selected = "selected">'+(y+1)+'</option>';
                                else
                                    option += '<option value="'+(y+1)+'">'+(y+1)+'</option>';
                            }
                        }
                        
                        harga = parseInt(obat[i].harga);
                    }else{
                        if (!isCheckJml)
                            option += '<option value="">Habis</option>';
                        harga = 0;
                    }
                    
                    if (!isCheckJml)
                        $("[id^=jml_obat]").eq(x).append(option);
                    
                    var jml_barang = $("[id^=jml_obat]").eq(x).val() != '' ? parseInt(Math.ceil($("[id^=jml_obat]").eq(x).val())) : 0;
                    $("[id^=harga_obat]").eq(x).val(jml_barang * harga);
                    $("[id^=harga_satuan]").eq(x).val(harga);
                }
            });
            
            if(kode_barang == ''){
                $("[id^=harga_obat]").eq(x).val('');
                $("[id^=harga_satuan]").eq(x).val('');
                $("[id^=jml_obat]").eq(x).empty();
                var option = '<option value="">Pilih Jumlah</option>';
                $("[id^=jml_obat]").eq(x).append(option);
            }
        }
        
        display_total_harga();
    }
    
    function display_total_harga(){
        var obat_length = $("[id^=obat]").length;
        var total_harga = 0;
        
        //Menghitung dari obat
        for(x = 0; x < obat_length; x++){
            var harga = $("[id^=harga_obat]").eq(x).val() != '' ? $("[id^=harga_obat]").eq(x).val() : 0;
            total_harga += parseInt(harga);
        }
        
        $('#total_harga').val(total_harga);
    }
    
</script>
