<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">SETTING GAJI</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            <input type="hidden" class="form-control" name="id_ref_gaji" id="id_ref_gaji" placeholder="Id Jabatan"  />
                <table class='table table-bordered>'        
                       <tr><td width='200'>Nama Jabatan <?php echo form_error('id_pegawai') ?></td><td><?php echo form_dropdown('id_pegawai',$pegawai_option,$id_pegawai,array('id'=>'id_pegawai','class'=>'form-control select2', 'required'=>'required', 'onchange'=>'cekPegawai()'));?></td></tr>
                       <tr><td width='200'>Gaji Pokok <?php echo form_error('gaji_pokok') ?></td><td><input type="number" class="form-control" name="gaji_pokok" id="gaji_pokok" placeholder="Gaji Pokok" value="<?php echo $gaji_pokok; ?>" /></td></tr>
                       <tr><td width='200'>Uang Kehadiran <?php echo form_error('uang_kehadiran') ?></td><td><input type="number" class="form-control" name="uang_kehadiran" id="uang_kehadiran" placeholder="Uang Kehadiran" value="<?php echo $uang_kehadiran; ?>" /></td></tr>
                       <tr><td width='200'>Uang Makan <?php echo form_error('uang_makan') ?></td><td><input type="number" class="form-control" name="uang_makan" id="uang_makan" placeholder="Uang Makan" value="<?php echo $uang_makan; ?>" /></td></tr>
                       <tr><td width='200'>Uang Transport <?php echo form_error('uang_transport') ?></td><td><input type="number" class="form-control" name="uang_transport" id="uang_transport" placeholder="Uang Transport" value="<?php echo $uang_transport; ?>" /></td></tr>
                       <tr><td width='200'>Tunjangan <?php echo form_error('tunjangan') ?></td><td><input type="number" class="form-control" name="tunjangan" id="tunjangan" placeholder="Tunjangan" value="<?php echo $tunjangan; ?>" /></td></tr>
                    <tr><td></td><td>
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('hrms/ref_gaji') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>
<script type="text/javascript">
  function cekPegawai(){
    var pegawai=$('#id_pegawai').val();
    $.ajax({
            type: "GET",
            url: "<?=base_url('hrms/set_gaji/get_referensi/')?>"+pegawai, //json get site
            dataType : 'json',
            success: function(response){
                arrData = response;
                dataPO=arrData;
                $('#gaji_pokok').val(arrData['gaji_pokok']);
                $('#uang_kehadiran').val(arrData['uang_kehadiran']);
                $('#uang_makan').val(arrData['uang_makan']);
                $('#uang_transport').val(arrData['uang_transport']);
            }
        });
  }
</script>