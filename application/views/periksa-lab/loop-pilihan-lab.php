<div class="row loop-lab" data-no="<?= $no ?>">
<br>
    <div class="col-md-6">
        <select name="periksa_lab[]" class="form-control select2" style="width:100%">
        <option value="">---Pilih Pemeriksaan LAB---</option>
        <?php 
                foreach ($periksa_lab as $key => $value) {
                    echo "<option value='".$value->id_tipe."'>".$value->item."</option>";
                }
                ?>
        </select>
    </div>
    <div class="col-md-6" style="display:flex">
        <input type="text" name="hasil[]" class="form-control" placeholder="Hasil" id="" style="<?php echo ($no!=0) ? 'margin-right:10px' : '' ?>">
        <?php 
            if($no!=0){
        ?>
        <a href="" class="btn btn-danger btn-sm remove-lab" data-no="<?= $no ?>"><span class="fa fa-trash"></span></a>
        <?php } ?>
    </div>
</div>
