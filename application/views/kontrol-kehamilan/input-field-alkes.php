<div class="row loop-alkes" data-no="<?= $no ?>" style="margin-top:20px">
    <div class="col-sm-6">
        Alat Kesehatan Sekali Pakai
        <br>
        <select name="kode_barang[]" class="form-control select selectAlkes">
            <option value=''>---Pilih Alkes---</option>
            <?php 
                foreach ($alkes as $key => $value) {
                    echo "<option data-stok='".$value->stok_barang."' value='".$value->kode_barang."'>".$value->nama_barang."</option>";
                }
            ?>
        </select>
    </div>
    <div class="<?= $no==1 ? 'col-md-5' : 'col-md-6' ?>">
        Jumlah Yang dipakai
        <select name="jml_barang[]" class="form-control stokAlkes"></select> 
        <?php 
            if($no!=0){
        ?>
        <a href="" class="btn btn-danger btn-sm remove-lab" data-no="<?= $no ?>"><span class="fa fa-trash"></span></a>
        <?php } ?>
    </div>
</div>