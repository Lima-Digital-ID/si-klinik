
<div class="row loop-penyesuaian-stok box-body" data-no="<?= $no ?>">
<!-- <br> -->
    <div class="form-group">
        <div class="col-sm-2">Nama Barang</div>
        <div class="col-sm-10">
            <select name="kode_barang[]" id="" class="form-control select2 getStok" style="width:100%">
                <option value="">---Pilih Obat---</option>
                <?php 
                    foreach ($stok as $key => $value) {
                        echo "<option data-stok='".$value->stok_barang."' value='".$value->kode_barang."'>".$value->nama_barang."</option>";
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2">Stok Saat Ini</div>
        <div class="col-sm-10">
            <input type="text" name="stok[]" class="form-control stok" readonly>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2">Stok Setelah Penyesuaian</div>
        <div class="col-sm-10">
            <select name="jumlah[]" class="form-control jumlah select2">
            </select>
        </div>
    </div>
    <?php 
        if($no>0){
    ?>
    <div class="form-group">
        <div class="col-sm-12">
            <a href="" class="btn btn-danger btn-sm remove-stok" data-no="<?= $no ?>"><span class="fa fa-trash"></span></a>
        </div>
    </div>
    <?php } ?>
</div>
