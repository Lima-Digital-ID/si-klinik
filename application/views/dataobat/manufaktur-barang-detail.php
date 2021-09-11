<br>
<div class="row row-input" data-id="<?= $dataId ?>">
    <div class="col-md-3">
        <label for="">Barang</label>
        <select name="m_kode_barang[]" class="kode_barang form-control select2">
            <option value="">---Pilih Barang---</option>
            <?php 
                foreach ($barang as $key => $value) {
                    echo "<option value='".$value->kode_barang."'>".$value->nama_barang."</option>";
                }
            ?>
        </select>
    </div>
    <div class="col-md-2">
        <label for="">Jumlah</label>
        <select name="m_jumlah[]" class="jumlah form-control select2">
            <option value="">---Pilih Jumlah---</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="">Harga</label>
        <input type="number" name="m_harga[]" class="harga form-control">
    </div>
    <div class="col-md-3">
        <label for="">Total</label>
        <input type="number" name="m_total[]" class="total form-control" readonly>
    </div>
    <div class="col-md-1" style="padding-top:5x">
    <br>
        <?php 
            if($dataId>1){
        ?>
        <button class="btn btn-sm btn-danger remove"><span class="fa fa-trash"></span></button>
        <?php } ?>
    </div>
</div>
