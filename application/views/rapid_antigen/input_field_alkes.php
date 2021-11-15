<div class="row loop-alkes" data-id="<?= $no ?>">
    <div class="col-sm-6">
        Alat Kesehatan Sekali Pakai
        <br>
        <select name="kode_barang[]" class="form-control select2 selectAlkes">
            <option value=''>---Pilih Alkes---</option>
            <?php 
                foreach ($alkes as $key => $value) {
                    echo "<option data-stok='".$value->stok_barang."' value='".$value->kode_barang."'>".$value->nama_barang."</option>";
                }
            ?>
        </select>
    </div>
    <div class="col-sm-6">
        Jumlah Yang Dipakai
        <select name="jml_barang[]" class="form-control stokAlkes">
        </select>
    </div>
</div>
