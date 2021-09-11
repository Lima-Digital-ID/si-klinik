<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">SETTING GAJI</h3>
            </div>
            <div class="row">
            <div class="col-sm-12">
            <form action="<?php echo $action; ?>" method="post">
                <input type="hidden" class="form-control" name="id_set_gaji" id="id_set_gaji" placeholder="Id Jabatan"  value="<?=$id_set_gaji?>" />
                <div class="row">
                  <div class="col-sm-12">
                  <br>
                  <div class="col-sm-2">
                      <label>
                      Nama Pegawai <?php echo form_error('id_pegawai') ?>
                      </label>
                  </div>
                  <div class="col-sm-10">                    
                      <?php echo form_dropdown('id_pegawai',$pegawai_option,$id_pegawai,array('id'=>'id_pegawai','class'=>'form-control', 'onchange'=>'cekPegawai()', 'disabled'=>'true'));?>
                  </div>
                  </div>
                  <div class="col-sm-12">
                    <br>
                    <div class="col-sm-2">
                      <label>
                      Gaji Pokok <?php echo form_error('gaji_pokok') ?>
                      </label>
                    </div>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="gaji_pokok" id="gaji_pokok" placeholder="Gaji Pokok" value="<?php echo $gaji_pokok; ?>" onkeyup="cekGaji(this)"/>
                    </div>
                  </div>
                  <div class="col-sm-12">
                  <br>
                  <div class="col-sm-2">
                  <label>Tambahan</label>
                  </div>
                  <div class="col-sm-10">
                    <div class="">
                      <div class="checkbox-inline">
                        <label><input type="checkbox" name="check_uk" id="check_uk" onclick="CheckUk(this)" <?=($uang_kehadiran == 0 ? '':'checked') ?>> Uang Kehadiran</label>
                      </div>
                      <div class="checkbox-inline">
                        <label><input type="checkbox" name="check_um" id="check_uk" onclick="CheckUm(this)" <?=($uang_makan == 0 ? '':'checked') ?>> Uang Makan</label>
                      </div>
                      <div class="checkbox-inline">
                        <label><input type="checkbox" name="check_ut" id="check_uk" onclick="CheckUt(this)" <?=($uang_transport == 0 ? '':'checked') ?>> Uang Transport</label>
                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="col-sm-12" id="div_uk" <?=($uang_kehadiran != 0 ? '':'hidden') ?>>
                  <br>
                    <div class="col-sm-2">
                      <label>
                      Uang Kehadiran <?php echo form_error('uang_kehadiran') ?>
                      </label>
                    </div>
                    <div class="col-sm-10">
                      <input type="" class="form-control" name="uang_kehadiran" id="uang_kehadiran" placeholder="Uang Kehadiran" value="<?php echo $uang_kehadiran; ?>" onkeyup="cekUK(this)"/>
                    </div>
                  </div>
                  <div class="col-sm-12" id="div_um" <?= ($uang_makan != 0 ? '':'hidden') ?>>
                  <br>
                    <div class="col-sm-2">
                      <label>
                      Uang Makan <?php echo form_error('uang_makan') ?>
                      </label>
                    </div>
                    <div class="col-sm-10">
                      <input type="" class="form-control" name="uang_makan" id="uang_makan" placeholder="Uang Makan" value="<?php echo $uang_makan; ?>" onkeyup="cekUM(this)"/>
                    </div>
                  </div>
                  <div class="col-sm-12" id="div_ut" <?= ($uang_transport != 0 ? '':'hidden') ?>>
                  <br>
                    <div class="col-sm-2">
                      <label>
                      Uang Transport <?php echo form_error('uang_transport') ?>
                      </label>
                    </div>
                    <div class="col-sm-10">
                      <input type="" class="form-control" name="uang_transport" id="uang_transport" placeholder="Uang Transport" value="<?php echo $uang_transport; ?>" onkeyup="cekUT(this)"/>
                    </div>
                  </div>
                  <div class="col-sm-12">
                  <br>
                    <div class="col-sm-2">
                      <label>
                      Uang Lembur (per jam)* <?php echo form_error('uang_lembur') ?>
                      </label>
                    </div>
                    <div class="col-sm-10">
                      <input type="" class="form-control" name="uang_lembur" id="uang_lembur" placeholder="Uang Lembur" value="<?php echo $uang_lembur; ?>" onkeyup="cekUL(this)"/>
                    </div>
                  </div>
                  <div class="col-sm-12">
                  <br>
                    <div class="col-sm-2">
                      <label>
                      Potongan Telat (per jam)* <?php echo form_error('potongan_telat') ?>
                      </label>
                    </div>
                    <div class="col-sm-10">
                      <input type="" class="form-control" name="potongan_telat" id="potongan_telat" placeholder="Potongan Telat" value="<?php echo $potongan_telat; ?>" onkeyup="cekPL(this)"/>
                    </div>
                  </div>
                  <div class="col-sm-12">
                  <br>
                    <div class="col-sm-2">
                      <label>
                      Tunjangan <?php echo form_error('tunjangan') ?>
                      </label>
                    </div>
                    <div class="col-sm-10">
                      <input type="" class="form-control" name="tunjangan" id="tunjangan" placeholder="Tunjangan" value="<?php echo $tunjangan; ?>" onkeyup="cekTj(this)"/>
                    </div>
                  </div>
                  <div class="col-sm-12">
                  <br>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                      <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                    </div>
                  </div>
                </div>
                </form>        
            </div>
        </div>
        <br>
      </div>
</div>
</div>
<script type="text/javascript">

  function CheckUk(val) {
    if ($(val).is(':checked')) {
      $('#div_uk').show();
    }else{
      $('#div_uk').hide();
    }
  }
  function CheckUt(val) {
    if ($(val).is(':checked')) {
      $('#div_ut').show();
    }else{
      $('#div_ut').hide();
    }
  }
  function CheckUm(val) {
    if ($(val).is(':checked')) {
      $('#div_um').show();
    }else{
      $('#div_um').hide();
    }
  }
  function cekPegawai(){
    var pegawai=$('#id_pegawai').val();
    console.log(pegawai);
    if (pegawai == 0) {
      $('#gaji_pokok').val('');
      $('#uang_kehadiran').val('');
      $('#uang_makan').val('');
      $('#uang_transport').val('');
    }
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
  function cekTj(val){
    $('#tunjangan').val(formatRupiah(val.value));
  }
  function cekPL(val){
    $('#potongan_telat').val(formatRupiah(val.value));
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