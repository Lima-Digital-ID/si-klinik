<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT PURCHASE ORDER</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Tanggal PO
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="tgl_po" required value="<?=date('Y-m-d')?>" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Pilih Supplier
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <?php echo form_dropdown('kode_supplier',$supplier_option,'',array('id'=>'kode_supplier','class'=>'form-control select2','required'=>'required','style'=>'width:100%;'));?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Apoteker
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <?php echo form_dropdown('id_apoteker',$apoteker_option,'',array('id'=>'id_apoteker','class'=>'form-control select2','required'=>'required','style'=>'width:100%;'));?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Jenis Pembayaran
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <?php echo form_dropdown('jenis_pembayaran',array(''=>'Pilih Jenis Pembayaran','0'=>'Cash','1'=>'Utang'),'',array('id'=>'jenis_pembayaran','class'=>'form-control select2','required'=>'required','style'=>'width:100%;'));?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Keterangan
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="keterangan" required/>
                        </div>
                    </div>
                <br>
                </div>
                <div class="col-sm-12">
                <hr>
                        
                        <div class="row">
                            <div class="col-sm-4">
                            <label>
                                Barang
                            </label>
                            </div>
                            <div class="col-sm-2">
                            <label>
                                Harga
                            </label>
                            </div>
                            <div class="col-sm-2">
                            <label>
                                Jumlah
                            </label>
                            </div>
                            <div class="col-sm-2">
                            <label>
                                Diskon
                            </label>
                            </div>
                            <div class="col-sm-2">
                            <label>
                                Sub Total
                            </label>
                            </div>
                            <!-- <div class="col-sm-2">
                            <label>
                                Tanggal Expired
                            </label>
                            </div> -->
                        </div>
                            
                            <div class="row">
                                <div id="input_fields_wrap_obat">
                                <!-- <div class="col-sm-3">
                                <input type="text" class="form-control" id="kode_obat[]" name="kode_obat[]" placeholder="Kode Obat" onchange="cekObat()" />
                                </div> -->
                                <div class="col-sm-4">
                                <?php echo form_dropdown('obat[]',$obat_option,'',array('id'=>'obat[]','class'=>'form-control select2','onchange'=>'get_obat()','style'=>'width:100%;'));?>
                                </div>
                                <div class="col-sm-2">
                                <!-- <input type="text" class="form-control" id="total[]" placeholder="Harga" name="total[]" readonly="" /> -->
                                <input type="" class="form-control" id="harga[]" placeholder="Harga" name="harga[]" onkeyup="hitungHarga()"/>
                                </div>
                                <div class="col-sm-2">
                                <input type="number" class="form-control" id="stok[]" placeholder="Jumlah" onkeyup="hitungHarga()" name="stok[]" />
                                </div>
                                <div class="col-sm-2">
                                <input type="number" class="form-control" id="diskon[]" placeholder="Diskon" name="diskon[]" onkeyup="hitungHarga()" />
                                </div>
                                <div class="col-sm-2">
                                <input type="text" class="form-control" id="total[]" placeholder="Harga" name="total[]" readonly="" />
                                <!-- <input type="" class="form-control" id="harga[]" placeholder="Harga" name="harga[]" /> -->
                                </div>
                                <!-- <div class="col-sm-2">
                                <input type="date" class="form-control" id="tgl_exp[]" placeholder="Tgl Expired" name="tgl_exp[]"/>
                                </div> -->
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
                <div class="col-sm-12">
                <br>
                    <div class="row">
                        <div class="col-sm-9">
                        </div>
                        <div class="col-sm-3">
                            <label>
                                Total Harga
                            </label>
                            <input type="text" class="form-control" name="totalharga" id="totalharga" readonly="" />
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-left:auto">
                    <div class="col-sm-9">
                <br>
                        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                        <a href="<?php echo site_url('jasa') ?>" class="btn btn-warning"><i class="fa fa-sign-out"></i> Kembali</a>
                    </div>
                </div>
                    <br>

                     
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
        
        var option_alkes = '<option value="">Pilih Barang</option>';
        var alkes_option_js = <?php echo $obat_option_js;?>;
        for(i=0;i<alkes_option_js.length;i++){
            option_alkes += '<option value="'+alkes_option_js[i].value+'">'+alkes_option_js[i].label+'</option>';
        }

        // var input_kode = '<input type="text" class="form-control" id="kode_obat[]" name="kode_obat[]" placeholder="Kode Obat" onchange="cekObat()" />';
        var input_obat = '<select id="obat[]" name="obat[]" class="form-control select2" onchange="get_obat(this)">'+option_alkes+'</select>';
        var input_jumlah = '<input type="number" class="form-control" id="stok[]" placeholder="Jumlah" onkeyup="hitungHarga()" name="stok[]"/>';
        var input_harga_obat = '<input type="number" class="form-control" id="harga[]" placeholder="Harga" name="harga[]" onkeyup="hitungHarga()"/>';
        var input_diskon = '<input type="number" class="form-control" id="diskon[]" placeholder="Diskon" name="diskon[]" onkeyup="hitungHarga()"/>';
        var input_total = '<input type="text" class="form-control" id="total[]" placeholder="subtotal" name="total[]" readonly />';
        
        if(y < max_fields){ //max input box allowed
            y++; //text box increment
            $(wrapper_obat).append('<div class="form-group"><br><br><div class="col-sm-4"><div class="input-group"><span class="input-group-addon"><a href="#" class="remove_field_obat" id="remove_field_obat">X</a></span>'+input_obat+'</div></div><div class="col-sm-2">'+input_harga_obat+'</div><div class="col-sm-2">'+input_jumlah+'</div><div class="col-sm-2">'+input_diskon+'</div><div class="col-sm-2">'+input_total+'</div>'); //add input box
        }
        $('.select2').select2(); 
    });
    
    $(wrapper_obat).on("click","#remove_field_obat", function(e){ //user click on remove text
        e.preventDefault(); 
        $(this).closest('.form-group').remove(); y--;
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
            var harga = $("[id^=harga]").eq(x).val();
            var kode='';
            var pabrik='';
            // var harga='';
            // $.each(obat_all, function(i, item) {
            //     if(obat_all[i].kode_barang == obat){
            //         // $("[id^=kode_obat]").eq(x).val(obat);
            //         // $("[id^=pabrik]").eq(x).val(obat_all[i].nama_pabrik);
            //         // $("[id^=ket]").eq(x).val(obat);
            //         pabrik=obat_all[i].nama_pabrik;
            //         harga=obat_all[i].harga;
            //         // console.log(obat_all[i].harga);
            //     }
            //         kode=obat;
            // });
            if (obat == '') {
                $("[id^=kode_obat]").eq(x).val('');
                $("[id^=harga]").eq(x).val('');
            }else{
                $("[id^=kode_obat]").eq(x).val(kode);
                $("[id^=harga]").eq(x).val(harga);
            }
        };
        hitungHarga();
    }

    function hitungHarga(selectObject = null, isCheckJml = false) {
        var kode_length = $("[id^=stok]").length;
        var total=0;
        var subtotal=0;
        for (var x = 0; x < kode_length; x++) {
            var harga = ($("[id^=harga]").eq(x).val() != '' ? parseInt($("[id^=harga]").eq(x).val()) : 0);
            if (harga == 0) {
                $("[id^=diskon]").eq(x).val('');
                $("[id^=stok]").eq(x).val('');
            }
            var stok = ($("[id^=stok]").eq(x).val() != '' ? parseInt($("[id^=stok]").eq(x).val()) : 0);
            var diskon = ($("[id^=diskon]").eq(x).val() != '' ? parseInt($("[id^=diskon]").eq(x).val()) : 0);
            if (diskon > harga) {
                $("[id^=diskon]").eq(x).val('');
                diskon = 0;
            }
            harga=harga - diskon;
            total=stok*harga;
            $("[id^=total]").eq(x).val(total);
            subtotal=subtotal+total;

            var obat = $("[id^=obat]").eq(x).val();
            var harga = $("[id^=harga]").eq(x).val();
            if (obat == '') {
                $("[id^=obat]").eq(x).val('');
                $("[id^=harga]").eq(x).val('');
            }else{
                $("[id^=obat]").eq(x).val(obat);
                $("[id^=harga]").eq(x).val(harga);
            }
        };
        $('#totalharga').val(subtotal);
    }

</script>