<?php
        $newTime = (int)time() + 1;
        $kode_trx_ajd='RCP'.$newTime;
        $kode_trx_po = 'PO'.$newTime;
?>
<div class="row loop_penyesuaian_stok box-body" data-no="<?= $no ?>">
<!-- <br> -->
            <input type="hidden" class="form-control" name=id_inventory[] value="<?php echo $kode_trx_ajd ?>" readonly>
            <input type="hidden" class="form-control" name=inv_type[] value="STOCK_ADJ" readonly>
            <input type="hidden" class="form-control" name=id_klinik[] value="1" readonly>
<div class="form-group">
                        <div class="col-sm-2">Nama Barang</div>
                        <div class="col-sm-10">
                            <select name="kode_barang[]" id="" class="form-control select" style="width:100%">
                                <option value="">---Pilih Obat---</option>
                                <?php 
                                    foreach ($stok as $key => $value) {
                                        echo "<option value='".$value->kode_barang."'>".$value->nama_barang."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Nama Gudang</div>
                        <div class="col-sm-10">
                            <select name="kode_gudang[]" id="" class="form-control select" style="width:100%">
                                <option value="">---Pilih Gudang---</option>
                                <?php 
                                    foreach ($gudang as $key => $value) {
                                        echo "<option value='".$value->kode_gudang."'>".$value->nama_gudang."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Lokasi Barang</div>
                        <div class="col-sm-10">
                            <select name="id_lokasi_barang[]" id="" class="form-control select" style="width:100%">
                                <option value="">---Pilih Lokasi---</option>
                                <?php 
                                    foreach ($lokasi as $key => $value) {
                                        echo "<option value='".$value->id_lokasi_barang."'>".$value->lokasi."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Jumlah Barang</div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name=jumlah[]>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Harga Barang</div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name=harga[]>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Diskon</div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name=diskon[]>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Tanggal Kadaluarsa</div>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name=tgl_exp[]>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Notes</div>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" name=notes[]></textarea>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <div class="col-sm-12">
                            <a href="" class="btn btn-danger btn-sm remove-stok" data-no="<?= $no ?>"><span class="fa fa-trash"></span></a>
                        </div>
                    </div> -->
<!-- <br> -->