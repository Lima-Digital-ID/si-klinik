<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA JASA</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

                <table class='table table-bordered>'        
                        <tr><td width='200'>Kode Jasa <?php echo form_error('kode_jasa') ?></td><td><input type="text" class="form-control" name="kode_jasa" id="kode_jasa" placeholder="Kode Jasa Auto Number" readonly="true" value="<?php echo $kode_jasa; ?>" /></td></tr>
                        <tr><td width='200'>Nama Jasa <?php echo form_error('nama_jasa') ?></td><td><input type="text" class="form-control" name="nama_jasa" id="nama_jasa" placeholder="Nama Jasa" value="<?php echo $nama_jasa; ?>" /></td></tr>
                        <tr><td width='200'>Kategori Jasa <?php echo form_error('id_kategori_barang') ?></td><td>
                                <?php echo cmb_dinamis('id_kategori_barang', 'tbl_kategori_barang', 'nama_kategori', 'id_kategori_barang', $id_kategori_barang) ?></td></tr>
                        <tr><td width='200'>Satuan <?php echo form_error('id_satuan') ?></td><td>
                                <?php echo cmb_dinamis('id_satuan_barang', 'tbl_satuan_barang', 'nama_satuan', 'id_satuan', $id_satuan_barang) ?></td></tr>
                        <tr><td width='200'>Harga <?php echo form_error('harga') ?></td><td><input type="number" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" /></td></tr>
                        <tr><td width='200'>HNA <?php echo form_error('hna') ?></td><td><input type="number" class="form-control" name="hna" id="hna" placeholder="hna" value="<?php echo $hna; ?>" /></td></tr>
                        <tr><td width='200'>Barcode Jasa <?php echo form_error('barcode_jasa') ?></td><td><input type="text" class="form-control" name="barcode_jasa" id="barcode_jasa" placeholder="Barcode Jasa" value="<?php echo $barcode_jasa; ?>" /></td></tr>
                        <tr><td width='200'>Klinik <?php echo form_error('id_klinik') ?></td><td>
                                <?php echo cmb_dinamis('id_klinik', 'tbl_klinik', 'nama', 'id_klinik', $id_klinik) ?></td></tr>
                        <tr><td width='200'>Foto Barang <?php echo form_error('foto_jasa') ?></td><td><input type="file" class="form-control" name="foto_jasa" id="foto_jasa" value="<?php echo $foto_jasa; ?>"/></td></tr>
                        <tr><td width='200'></td><td>
                        <?php if ($foto_jasa != null) {
                            ?>
                        <img src="<?=base_url('assets/images/foto_jasa/')?><?=$foto_jasa?>" width="100px">
                        <?php
                        }
                        ?>
                        </td></tr>
                        <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('jasa') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>