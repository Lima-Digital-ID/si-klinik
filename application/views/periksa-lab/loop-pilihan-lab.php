<div class="row loop-lab" data-no="<?= $no ?>">
<br>
    <div class="col-md-6">
        <select name="periksa_lab[]" class="form-control select2" style="width:100%">
        <option value="">---Pilih Pemeriksaan LAB---</option>
        <?php 
                foreach ($periksa_lab as $key => $value) {
                    echo "<option value='".$value->id_tipe."'>".$value->item."</option>";
                }
                ?>
        </select>
        <br>
        <br>
        <select name="" id="" class="form-control select2">
            <option value="">---Pilih Alat Kesehatan---</option>
            <?php
                    foreach ($alkes as $key => $value) {
                        echo "<option value='".$value->kode_barang."'>".$value->nama_barang."</option>";
                    }
            ?>
        </select>
    </div>
    <div class="col-md-6" style="display:flex">
        <input type="text" name="hasil[]" class="form-control" placeholder="Hasil" id="" style="<?php echo ($no!=0) ? 'margin-right:10px' : '' ?>">
        <?php 
            if($no!=0){
        ?>
        <a href="" class="btn btn-danger btn-sm remove-lab" data-no="<?= $no ?>"><span class="fa fa-trash"></span></a>
        <?php } ?>
    </div>
    <br>
    <br>
    <div class="col-md-6" style="display:flex">
        <?php echo form_dropdown('jml_alkes[]', array(''=>'Pilih Jumlah'),'',array('id'=>'jml_alkes[]','class'=>'form-control select2','onchange'=>'get_obat(this,true)'));?>
    </div>
</div>

<script>
    $(document).ready(function(){
        var jml_alkes   = $("#jml_alkes");
        
    })
    $(jml_alkes).click(function(e){ //on add input button click
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
</script>
<script>
    function get_alkes(selectObject = null, isCheckJml = false) {
        // var value = selectObject selectObject.value;  
        var alkes_length = $("[id^=alkes]").length;
        var alkes = <?php echo $alkes;?>;
        var ket_terbesar = 0;
        //Cek value keterangan terbesar
        for(x = 0; x < alkes_length; x++){
            var temp_ket = $("[id^=ket_alkes]").eq(x).val() != '' ? $("[id^=ket_alkes]").eq(x).val() : 0;
            if(temp_ket > ket_terbesar)
                ket_terbesar = temp_ket;
        }
        
        for(x = 0; x < alkes_length; x++){
            var kode_barang = $("[id^=obat]").eq(x).val();
            var temp_jml_selected = $("[id^=jml_obat]").eq(x).val();
            var temp_ket_selected = $("[id^=ket_alkes]").eq(x).val();

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
</script>
