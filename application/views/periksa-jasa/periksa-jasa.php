<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">PERIKSA JASA</h3>
                    </div>
                    <div class="box-body">
                        <div class="row col-md-12">
                            <form action="<?php echo base_url()."periksamedis/save_periksa_jasa" ?>" method="post">

                                <div class="form-group row">
                                    <div class="col-md-2">No Periksa </div>
                                <div class="col-md-10">
                                    <input type="text" name="no_periksa" value="<?= $no_periksa ?>" readonly id="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">Nama Lengkap</div>
                                <div class="col-md-10">
                                    <input type="text" name="nama_lengkap" value="<?= $nama_lengkap ?>" readonly id="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">Alamat</div>
                                <div class="col-md-10">
                                    <textarea name="alamat" class="form-control" rows="6" readonly><?= $alamat ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row" id="jasa_lainnya">
                                <div class="col-md-2">Pilih Jasa</div>
                                <div class="col-md-10">
                                    <select name="periksa_jasa[]" class="form-control select2" multiple="multiple" style="width:100%" required>
                                        <?php 
                                            foreach ($jasa_lainnya as $key => $value) {
                                                echo "<option value='".$value->id_tipe."'>".$value->item."</option>";
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <button type="reset" class="btn btn-default"><span class="fa fa-times"></span> Batal</button>
                                        <button type="submit" class="btn btn-warning"><span class="fa fa-save"></span> Periksa</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>