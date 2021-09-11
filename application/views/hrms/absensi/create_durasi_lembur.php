<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">TAMBAH JAM LEMBUR</h3>
            </div>
            <div class="row">
            <div class="col-sm-12">
            <form action="<?php echo $action; ?>" method="post">
                <input type="hidden" class="form-control" name="id_set_gaji" id="id_set_gaji" placeholder="Id Jabatan"  value="" />
                <div class="row">
                  <div class="col-sm-12">
                  <br>
                    <div class="col-sm-2">
                      <label>
                      Tanggal
                      </label>
                    </div>
                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="tanggal" required value="<?=date('Y-m-d')?>" />
                    </div>
                  </div>
                  <div class="col-sm-12">
                  <br>
                    <div class="col-sm-2">
                      <label>
                      Pegawai
                      </label>
                    </div>
                    <div class="col-sm-10">
                      <?php echo form_dropdown('id_pegawai',$pegawai_option,'',array('id'=>'id_pegawai','class'=>'form-control select2', 'required'=>'required'));?>
                    </div>
                  </div>
                  <div class="col-sm-12">
                  <br>
                    <div class="col-sm-2">
                      <label>
                      Durasi Lembur(jam)
                      </label>
                    </div>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="durasi" id="durasi" placeholder="Durasi" required/>
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