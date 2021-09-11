<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT JURNAL RUMAH TANGGA</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-8"> 
                                    <label>Deskripsi</label>    
                                    <textarea class="form-control" name="deskripsi" required></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label>Tanggal</label>    
                                    <input type="date" class="form-control" name="tgl" value="<?=date('Y-m-d')?>">
                                </div>
                            </div> 
                            </div>
                            <hr>
                            <div id="input_lawan_akun">
                            <div class="col-sm-8">
                                    <label>Pilih Akun</label>    
                                    <?php echo form_dropdown('lawan_akun[]', $akun_option , '' ,array('id'=>'lawan_akun[]','class'=>'form-control select2'));?>
                            </div> 
                            <div class="col-sm-4">
                                    <label>Jumlah</label>    
                                    <input class="form-control" name="jumlah_lawan[]" id="jumlah_lawan[]" required type="number" >
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
                                    <button type="submit" class="btn btn-success" id="submit"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
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
            var input_jumlah = '<input class="form-control" name="jumlah_lawan[]" id="jumlah_lawan[]" required type="number">';
            // var input_tipe = '<select class="form-control" name="tipe_akun_lawan[]"><option value="1">Debit</option><option value="0">Kredit</option></select>';
            if (y < max_input) {
                y++;
                $(input_lawan_akun).append('<div class="form-group"><br><div class="col-sm-8"><br><div class="input-group"><span class="input-group-addon"><a href="#" class="remove_field_obat" id="remove_field_obat">X</a></span>'+input_akun+'</div></div><div class="col-sm-4"><br>'+input_jumlah+'</div>'); //add input box
            }
            $('select').select2({
                width: '100%'
            });
        });

        $(input_lawan_akun).on("click","#remove_field_obat", function(e){ //user click on remove text
            e.preventDefault(); 
            $(this).closest('.form-group').remove(); y--;
        });
    });
</script>