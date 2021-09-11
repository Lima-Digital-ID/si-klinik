<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA OBAT ALKES BHP</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div class="col-sm-12">
            <br>
                  <div class="row">
                    <div class="form-group">
                        <!-- <div class="col-sm-6">
                            <label>Kode Barang</label>    
                            <br>
                        </div> -->
                        <div class="col-sm-6">
                            <label>Nama Barang <?php echo form_error('nama_barang') ?></label>    
                            <input type="hidden" placeholder="Kode Barang" name="kode_barang" readonly="" value="<?php echo $kode_barang; ?>" class="form-control" />
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" value="<?php echo $nama_barang; ?>"/>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Pabrik <?php echo form_error('id_pabrik') ?></label>    
                            <?php echo cmb_dinamis('kode_pabrik', 'tbl_pabrik', 'nama_pabrik', 'kode_pabrik',$kode_pabrik)?>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Jenis Barang <?php echo form_error('jenis_barang') ?></label>    
                            <?php echo form_dropdown('jenis_barang', array('1'=>'Obat','2'=>'Alat Kesehatan','3'=>'Obat Tindakan'),$jenis_barang,array('id'=>'jenis_barang','class'=>'select2 form-control', 'onchange'=>'cek(this.value)'));?>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Golongan Barang <?php echo form_error('id_kategori_barang') ?></label>    
                            <?php echo cmb_dinamis('id_golongan_barang', 'tbl_golongan_barang', 'nama_golongan_barang', 'id_golongan_barang',$id_golongan_barang)?>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Kategori Barang <?php echo form_error('id_kategori_barang') ?></label>    
                            <?php echo cmb_dinamis('id_kategori_barang', 'tbl_kategori_barang', 'nama_kategori', 'id_kategori_barang',$id_kategori_barang)?>
                            <br>
                        </div>
                        <!-- <div class="col-sm-6">
                            <label>Tipe Barang <?php echo form_error('tipe_barang') ?></label>    
                            <?php echo form_dropdown('tipe_barang', array('KONSINYASI'=>'KONSINYASI','NON KONSINYASI'=>'NON KONSINYASI'),$jenis_barang,array('id'=>'tipe_barang','class'=>'select2 form-control'));?>
                            <br>
                        </div> -->
                        <div class="col-sm-6">
                            <label>Minimal Stok <?php echo form_error('minimal_stok') ?></label>    
                            <input type="text" class="form-control" name="minimal_stok" id="minimal_stok" placeholder="Minimal Stok" value="<?php echo $minimal_stok; ?>" />
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Deskripsi <?php echo form_error('deskripsi') ?></label>    
                            <textarea class="form-control" name="deskripsi" id="deskripsi" ><?php echo $deskripsi; ?></textarea>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Indikasi <?php echo form_error('indikasi') ?></label>    
                            <textarea class="form-control" name="indikasi" id="indikasi" ><?php echo $indikasi; ?></textarea>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Kandungan <?php echo form_error('kandungan') ?></label>    
                            <textarea class="form-control" name="kandungan" id="kandungan" ><?php echo $kandungan; ?></textarea>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Dosis <?php echo form_error('dosis') ?></label>    
                            <textarea class="form-control" name="dosis" id="dosis" ><?php echo $dosis; ?></textarea>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Kemasan/Bentuk Sediaan <?php echo form_error('kemasan') ?></label>    
                            <textarea class="form-control" name="kemasan" id="kemasan" ><?php echo $kemasan; ?></textarea>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Efek Samping <?php echo form_error('efek_samping') ?></label>    
                            <textarea class="form-control" name="efek_samping" id="efek_samping" ><?php echo $efek_samping; ?></textarea>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Zat Aktif Prekusor <?php echo form_error('zat_aktif') ?></label>    
                            <textarea class="form-control" name="zat_aktif" id="zat_aktif" ><?php echo $zat_aktif; ?></textarea>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Aturan Minum</label>    
                            <textarea class="form-control" name="etiket" id="etiket" ><?php echo $etiket; ?></textarea>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Klinik <?php echo form_error('id_klinik') ?></label>    
                            <?php echo cmb_dinamis('id_klinik', 'tbl_klinik', 'nama', 'id_klinik', $id_klinik) ?>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Satuan Barang <?php echo form_error('id_satuan_barang') ?></label>    
                            <?php echo cmb_dinamis('id_satuan_barang', 'tbl_satuan_barang', 'nama_satuan', 'id_satuan',$id_satuan_barang)?>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Harga <?php echo form_error('harga') ?></label>    
                            <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" onkeyup="setHarga(this)"/>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Barcode <?php echo form_error('barcode') ?></label>    
                            <input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" value="<?php echo $barcode; ?>" />
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <label>Foto Barang <?php echo form_error('foto_barang') ?></label>    
                            <input type="file" class="form-control" name="foto_barang" id="foto_barang" value="<?php echo $foto_barang; ?>"/>
                            <br>
                        </div>
                         <div class="col-sm-6">
                            <?php if ($foto_barang != null) {
                                ?>
                            <img src="<?=base_url('assets/images/foto_barang/')?><?=$foto_barang?>" width="100px">
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('dataobat') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                        </div>
                    </div> 
                    
                  <!-- </div> -->
                  <!-- </div> -->
                  <!-- <div id="menu1" class="tab-pane fade">
                  <br>
                      <div class="row">
                        
                      </div>
                  </div>
                  <div id="menu2" class="tab-pane fade">
                    <br>
                    <div class="row">
                        
                        <br><br>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label>Tanggal Expired <?php echo form_error('tanggal_expired') ?></label>    
                            </div>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="tanggal_expired" id="tanggal_expired" placeholder="tanggal expired" value="<?php echo $tanggal_expired; ?>" />
                            </div>
                        </div> 
                        
                      </div>
                  </div> -->
                </div>
            </div>
            <!-- <div class="col-sm-12"> -->
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-9" style="margin-left:10px">
                    <br><br>
                    
                </div>
            </div>
            <!-- </div> -->
            </form>        
        </div>
</div>
</div>
<script type="text/javascript">
    function cek(num)    {
        if(num == 2){
            document.getElementById("obat").style.display="none";
            console.log(num);
        }else{
            document.getElementById("obat").style.display="block";
            console.log(num);
        }
    }

     function setHarga(val){
        $('#harga').val(formatRupiah(val.value))
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