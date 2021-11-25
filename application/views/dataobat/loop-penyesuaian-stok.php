
<div class="row loop-penyesuaian-stok box-body" data-no="<?= $no ?>">
<!-- <br> -->
<?php 
        if($no!=0){
    ?>
<div class="form-group">
                        <div class="col-sm-2">Nama Barang</div>
                        <div class="col-sm-10">
                            <select name="kode_barang[]" id="" class="form-control select2" style="width:100%">
                                <option value="">---Pilih Obat---</option>
                                <?php 
                                    foreach ($stok as $key => $value) {
                                        echo "<option data-stok='".$value->jumlah."' value='".$value->kode_barang."'>".$value->nama_barang."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2">Jumlah Barang Adjust</div>
                        <div class="col-sm-10">
                            <!-- <select name="jumlah[]" class="form-control select2 stockBarang">
                            </select> -->
                            <input type="text" name="jumlah[]" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <a href="" class="btn btn-danger btn-sm remove-stok" data-no="<?= $no ?>"><span class="fa fa-trash"></span></a>
                        </div>
                    </div>

        <!-- <div class="col-md-1">
            <a href="" class="btn btn-danger btn-sm remove-lab" data-no="<?= $no ?>"><span class="fa fa-trash"></span></a>
        </div> -->
    <?php } ?>
<!-- <br> -->