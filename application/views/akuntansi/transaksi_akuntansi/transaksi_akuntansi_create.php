<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT TRANSAKSI AKUNTANSI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-3">
                                    <label>Tanggal</label>    
                                    <input type="date" class="form-control" name="tgl" value="<?=date('Y-m-d')?>">
                                </div>
                                <div class="col-sm-9"> 
                                    <label>Deskripsi</label>    
                                    <textarea class="form-control" name="deskripsi" required></textarea>
                                </div>
                            </div> 
                            </div>
                            <hr>
                            <div class="col-sm-5">
                                    <label>Akun</label>    
                                    <?php echo form_dropdown('akun', $akun_option , '' ,array('id'=>'akun','class'=>'form-control select2'));?>
                            </div> 
                            <div class="col-sm-4">
                                    <label>Jumlah</label>    
                                    <input class="form-control" name="jumlah_akun" id="jumlah_akun" required type="number" onkeyup="cekJumlahLawan()">
                            </div> 
                            <div class="col-sm-3">
                                    <label>Tipe </label>    
                                    <select class="form-control select2" name="tipe_akun">
                                        <option value="1">Debit</option>
                                        <option value="0">Kredit</option>
                                    </select>
                            </div> 
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div id="input_lawan_akun">
                            <div class="col-sm-5">
                                    <label>Lawan Akun</label>    
                                    <?php echo form_dropdown('lawan_akun[]', $akun_option , '' ,array('id'=>'lawan_akun[]','class'=>'form-control select2', 'onchange'=>'cekLawan()'));?>
                            </div> 
                            <div class="col-sm-4">
                                    <label>Jumlah</label>    
                                    <input class="form-control" name="jumlah_lawan[]" id="jumlah_lawan[]" required type="number" onkeyup="cekJumlahLawan()" >
                            </div> 
                            <div class="col-sm-3">
                                    <label>Tipe </label>    
                                    <select class="form-control select2" name="tipe_akun_lawan[]">
                                        <option value="1">Debit</option>
                                        <option value="0">Kredit</option>
                                    </select>
                            </div> 
                            </div>
                            <div class="col-sm-12">
                                    <div align="right">
                                        <br>
                                        <button id="add_lawan_akun"><i class="fa fa-plus"></i>Tambah</button>
                                    </div>
                                </div>
                            <div class="col-sm-12">
                            <br>
                                    <button type="submit" class="btn btn-success" id="submit" disabled=""><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                                    <a href="<?php echo site_url('hrms/jabatan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                            </div> 
                        </div>
                    </div>
                </div>
            </form>        
        </div>
    </section>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var max_input=10;
        var add_lawan_akun=$('#add_lawan_akun');
        var input_lawan_akun=$('#input_lawan_akun');
        var y = 1; //initlal text box count
        $(add_lawan_akun).click(function(e){
            e.preventDefault();

            var akun_option='<option value="">Pilih Akun / No Akun</option>';
            var akun_lawan=<?=$akun_option_js?>;

            for (var i = 0; i < akun_lawan.length; i++) {
                akun_option+='<option value="'+akun_lawan[i].label+'">'+akun_lawan[i].value+'</option>';
            }

            var input_akun = '<select id="lawan_akun[]" name="lawan_akun[]" required class="form-control select2">'+akun_option+'</select>';
            var input_jumlah = '<input class="form-control" name="jumlah_lawan[]" id="jumlah_lawan[]" required type="number" onkeyup="cekJumlahLawan()">';
            var input_tipe = '<select class="form-control" name="tipe_akun_lawan[]"><option value="1">Debit</option><option value="0">Kredit</option></select>';
            if (y < max_input) {
                y++;
                $(input_lawan_akun).append('<div class="form-group"><br><div class="col-sm-5"><br><div class="input-group"><span class="input-group-addon"><a href="#" class="remove_field_obat" id="remove_field_obat">X</a></span>'+input_akun+'</div></div><div class="col-sm-4"><br>'+input_jumlah+'</div><div class="col-sm-3"><br>'+input_tipe+'</div>'); //add input box
            }
            $('select').select2({
                // dropdownAutoWidth : false,
                width: '100%'
            });
        });
        $(input_lawan_akun).on("click","#remove_field_obat", function(e){ //user click on remove text
            e.preventDefault(); 
            $(this).closest('.form-group').remove(); y--;
            // get_obat(null);
        });
    });
    function cekJumlahLawan(selectObject = null, isCheckJml = false) {
        var jumlah_length = $("[id^=jumlah_lawan]").length;
        var jumlah_akun = $("[id^=jumlah_akun]").val();
        if (jumlah_akun == '') {
            alert('jumlah akun belum terisi');
            $('#jumlah_akun').focus();
        }
            console.log(jumlah_akun);
        var total=0;
        for (var x = 0; x < jumlah_length; x++) {
            var lawan = parseInt($("[id^=jumlah_lawan]").eq(x).val());
            total+=lawan;
            console.log(total);
        }
        if (total == parseInt(jumlah_akun)) {
            $('#submit').attr('disabled', false);
        }else{
            $('#submit').attr('disabled', true);
        }
    }
    function cekLawan(){
        var lawan_length = $("[id^=lawan_akun]").length;
        var jumlah=$("[id^=jumlah_akun]").val()
        for (var x = 0; x < lawan_length; x++) {
            if ($("[id^=lawan_akun]").eq(x).val() == 15) {
                console.log($("[id^=jumlah_lawan]").eq(x).val());
                $('#add_lawan_akun').attr('disabled', true);
                $("[id^=jumlah_lawan]").eq(x).val(jumlah);
                $('#submit').attr('disabled', false);
            }else{
                $('#add_lawan_akun').attr('disabled', false);
            }
        };
    }
</script>