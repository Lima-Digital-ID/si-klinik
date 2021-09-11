<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA JABATAN</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            <input type="hidden" class="form-control" name="id_ref_gaji" id="id_ref_gaji" placeholder="Id Jabatan" value="<?php echo $id_ref_gaji; ?>" />
                <table class='table table-bordered>'        
                       <tr><td width='200'>Nama Jabatan <?php echo form_error('id_jabatan') ?></td><td><?php echo form_dropdown('id_jabatan',$jabatan_option,$id_jabatan,array('id'=>'id_jabatan','class'=>'form-control select2', 'required'=>'required'));?></td></tr>
                       <tr><td width='200'>Gaji Pokok <?php echo form_error('gaji_pokok') ?></td><td><input type="" class="form-control" name="gaji_pokok" id="gaji_pokok" placeholder="Gaji Pokok" value="<?php echo $gaji_pokok; ?>" onkeyup="cekGaji(this)" /></td></tr>
                       <tr><td width='200'>Uang Kehadiran <?php echo form_error('uang_kehadiran') ?></td><td><input type="" class="form-control" name="uang_kehadiran" id="uang_kehadiran" placeholder="Uang Kehadiran" value="<?php echo $uang_kehadiran; ?>" onkeyup="cekUK(this)" /></td></tr>
                       <tr><td width='200'>Uang Makan <?php echo form_error('uang_makan') ?></td><td><input type="" class="form-control" name="uang_makan" id="uang_makan" placeholder="Uang Makan" value="<?php echo $uang_makan; ?>" onkeyup="cekUM(this)" onkeyup="cekUM(this)" /></td></tr>
                       <tr><td width='200'>Uang Transport <?php echo form_error('uang_transport') ?></td><td><input type="" class="form-control" name="uang_transport" id="uang_transport" placeholder="Uang Transport" value="<?php echo $uang_transport; ?>" onkeyup="cekUT(this)"/></td></tr>
                       <tr><td width='200'>Uang Lembur <?php echo form_error('uang_lembur') ?></td><td><input type="" class="form-control" name="uang_lembur" id="uang_lembur" placeholder="Uang Lembur" value="<?php echo $uang_lembur; ?>" onkeyup="cekUL(this)"/></td></tr>
                    <tr><td></td><td>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('hrms/ref_gaji') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>
<script type="text/javascript">
  function cekGaji(val){
    $('#gaji_pokok').val(formatRupiah(val.value));
  }
  function cekUM(val){
    $('#uang_makan').val(formatRupiah(val.value));
  }
  function cekUK(val){
    $('#uang_kehadiran').val(formatRupiah(val.value));
  }
  function cekUT(val){
    $('#uang_transport').val(formatRupiah(val.value));
  }
  function cekUL(val){
    $('#uang_lembur').val(formatRupiah(val.value));
  }
  function formatRupiah(angka, prefix)
  {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa  = split[0].length % 3,
      rupiah  = split[0].substr(0, sisa),
      ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
      
    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }
    
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }
</script>