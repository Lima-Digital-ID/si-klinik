<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA OBAT RACIKAN</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class="col-sm-12">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Kode Obat Racikan <?php echo form_error('kode_obat_racikan') ?>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="kode_obat_racikan" placeholder="kode Obat Racikan Auto Number" readonly="true" value="<?php echo $kode_obat_racikan; ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Nama Obat Racikan <?php echo form_error('nama_obat_racikan') ?>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_obat_racikan" placeholder="Nama Obat Racikan" value="<?php echo $nama_obat_racikan; ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Kategori Obat Racikan <?php echo form_error('id_kategori_barang') ?>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <?php echo cmb_dinamis('id_kategori_barang', 'tbl_kategori_barang', 'nama_kategori', 'id_kategori_barang', $id_kategori_barang) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>                                
                                Obat
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div id="input_fields_wrap_obat">
                                <div class="col-sm-3">
                                <input type="text" class="form-control" id="kode_obat[]" name="kode_obat[]" placeholder="Kode Obat" onchange="cekObat()" />
                                </div>
                                <div class="col-sm-3">
                                <?php echo form_dropdown('obat[]',$obat_option,'',array('id'=>'obat[]','class'=>'form-control select2','onchange'=>'get_obat()','style'=>'width:100%;'));?>
                                 <?php //echo form_dropdown('kode_obat[]',$kode_obat_option,'',array('id'=>'kode_obat[]','class'=>'form-control select2','onchange'=>'get_obat_kode(this)','style'=>'width:100%;'));?>
                                </div>
                                <div class="col-sm-3">
                                <input type="text" class="form-control" id="pabrik[]" placeholder="Pabrik" readonly="" />
                                </div>
                                <div class="col-sm-3">
                                <input type="text" class="form-control" id="ket[]" placeholder="Deskripsi" readonly="" />
                                </div>
                                </div>
                                <div class="col-sm-12">
                                    <div align="right">
                                        <br>
                                        <button id="add_field_button_obat"><i class="fa fa-plus"></i>Tambah</button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>                                
                                Jasa
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div id="input_fields_wrap_jasa">
                                <div class="col-sm-4">
                                <input type="text" class="form-control" id="kode_jasa[]" name="kode_jasa[]" placeholder="Kode Jasa" />
                                </div>
                                <div class="col-sm-4">
                                <?php echo form_dropdown('jasa[]',$jasa_option,'',array('id'=>'jasa[]','class'=>'form-control select2','onchange'=>'get_jasa()','style'=>'width:100%;'));?>
                                 <?php //echo form_dropdown('kode_obat[]',$kode_obat_option,'',array('id'=>'kode_obat[]','class'=>'form-control select2','onchange'=>'get_obat_kode(this)','style'=>'width:100%;'));?>
                                </div>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" id="hna[]" placeholder="HNA" />
                                </div>
                                </div>
                                <div class="col-sm-12">
                                    <div align="right">
                                        <br>
                                        <button id="add_field_button_jasa"><i class="fa fa-plus"></i>Tambah</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-left:auto">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                        <a href="<?php echo site_url('jasa') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                    </div>
                </div>

                     
                </form>        
            </div>
</div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var max_fields      = 10; //maximum input boxes allowed
    
    var wrapper_obat          = $("#input_fields_wrap_obat");
    var add_button_obat      = $("#add_field_button_obat");
    
    var y = 1; //initlal text box count
    
    $(add_button_obat).click(function(e){ //on add input button click
        e.preventDefault();
        
        var option_alkes = '<option value="">Pilih Obat</option>';
        var alkes_option_js = <?php echo $obat_option_js;?>;
        for(i=0;i<alkes_option_js.length;i++){
            option_alkes += '<option value="'+alkes_option_js[i].value+'">'+alkes_option_js[i].label+'</option>';
        }

        var input_kode = '<input type="text" class="form-control" id="kode_obat[]" name="kode_obat[]" placeholder="Kode Obat" onchange="cekObat()" />';
        var input_obat = '<select id="obat[]" name="obat[]" class="form-control select2" onchange="get_obat(this)">'+option_alkes+'</select>';
        var input_anjuran_obat = '<input type="text" class="form-control" id="pabrik[]" name="pabrik[]" placeholder="Pabrik" readonly/>';
        var input_harga_obat = '<input type="text" class="form-control" id="ket[]" placeholder="Deskripsi" readonly/>';
        
        if(y < max_fields){ //max input box allowed
            y++; //text box increment
            $(wrapper_obat).append('<div class="form-group"><br><br><div class="col-sm-3"><div class="input-group"><span class="input-group-addon"><a href="#" class="remove_field_obat" id="remove_field_obat">X</a></span>'+input_kode+'</div></div><div class="col-sm-3">'+input_obat+'</div><div class="col-sm-3">'+input_anjuran_obat+'</div><div class="col-sm-3">'+input_harga_obat+'</div>'); //add input box
        }
    });
    
    $(wrapper_obat).on("click","#remove_field_obat", function(e){ //user click on remove text
        e.preventDefault(); 
        $(this).closest('.form-group').remove(); y--;
        // get_obat(null);
    });

    var wrapper_jasa          = $("#input_fields_wrap_jasa");
    var add_button_jasa      = $("#add_field_button_jasa");

    var v = 1; //initlal text box count
    
    $(add_button_jasa).click(function(e){ //on add input button click
        e.preventDefault();
        
        var option_jasa = '<option value="">Pilih Jasa</option>';
        var jasa_option_js = <?php echo $jasa_option_js;?>;
        for(i=0;i<jasa_option_js.length;i++){
            option_jasa += '<option value="'+jasa_option_js[i].value+'">'+jasa_option_js[i].label+'</option>';
        }

        var input_alkes = '<input type="text" class="form-control" id="kode_jasa[]" name="kode_jasa[]" placeholder="Kode Jasa" />';
        var input_jml_obat = '<select id="jasa[]" name="jasa[]" class="form-control select2" onchange="get_jasa(this)">'+option_jasa+'</select>';
        var input_anjuran_obat = '<input type="text" class="form-control" id="hna[]" name="hna[]" placeholder="HNA" />';
        
        if(v < max_fields){ //max input box allowed
            v++; //text box increment
            $(wrapper_jasa).append('<div class="form-group"><br><br><div class="col-sm-4"><div class="input-group"><span class="input-group-addon"><a href="#" class="remove_field_jasa" id="remove_field_jasa">X</a></span>'+input_alkes+'</div></div><div class="col-sm-4">'+input_jml_obat+'</div><div class="col-sm-4">'+input_anjuran_obat+'</div>'); //add input box
        }
    });
    
    $(wrapper_jasa).on("click","#remove_field_jasa", function(e){ //user click on remove text
        e.preventDefault(); 
        $(this).closest('.form-group').remove(); v--;
        // get_obat(null);
    });
});
    function get_obat(selectObject = null, isCheckJml = false) {
        // var value = selectObject selectObject.value;  
            // var kode = $("[id^=obat]").length;
        var obat_length = $("[id^=obat]").length;
        var obat_all=<?=$obat_all?>;
        // console.log($("[id^=ket]").length);
        for (var x = 0; x < obat_length; x++) {
            var obat = $("[id^=obat]").eq(x).val();
            var kode='';
            var pabrik='';
            $.each(obat_all, function(i, item) {
                if(obat_all[i].kode_barang == obat){
                    // $("[id^=kode_obat]").eq(x).val(obat);
                    // $("[id^=pabrik]").eq(x).val(obat_all[i].nama_pabrik);
                    // $("[id^=ket]").eq(x).val(obat);
                    pabrik=obat_all[i].nama_pabrik;
                    // console.log(obat_all[i].harga);
                }
                    kode=obat;
            });
            $("[id^=kode_obat]").eq(x).val(kode);
            $("[id^=pabrik]").eq(x).val(pabrik);
            $("[id^=ket]").eq(x).val(kode);
        };
        
    }

    function cekObat(selectObject = null, isCheckJml = false) {
        var kode_length = $("[id^=kode_obat]").length;
        var obat_all=<?=$obat_all?>;
        for (var x = 0; x < kode_length; x++) {
            var kode_obat = $("[id^=kode_obat]").eq(x).val();
            // console.log(kode_obat);
            var kode='';
            $.each(obat_all, function(i, item) {
                if(obat_all[i].kode_barang == kode_obat){
                    kode=kode_obat;
                }
            });
            console.log(kode);
            $("[id^=obat]").eq(x).val(kode).change();
        };
        
    }

    function get_jasa(selectObject = null, isCheckJml = false) {
        // var value = selectObject selectObject.value;  
            // var kode = $("[id^=obat]").length;
            // console.log(kode);
        var jasa_length = $("[id^=jasa]").length;
        var jasa_all=<?=$jasa_all?>;
        for (var x = 0; x < jasa_length; x++) {
            var jasa = $("[id^=jasa]").eq(x).val();
            var kode='';
            var hna='';
            $.each(jasa_all, function(i, item) {
                console.log(jasa);
                if(jasa_all[i].kode_jasa == jasa){
                    kode=jasa;
                    hna=jasa_all[i].hna;
                }
            });
            $("[id^=kode_jasa]").eq(x).val(kode);
            $("[id^=hna]").eq(x).val(hna);
            // if (obat == obat_all[i].kode_barang) {
            //     console.log(obat_all[i].kode_barang);
            // }

        };
        
    }

</script>