<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">BUAT DISKON PENJUALAN</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            <input type="hidden" class="form-control" name="id_diskon_trx" id="id_diskon_trx" placeholder="id Klinik" value="<?php echo $id_diskon_trx; ?>" />
                <table class='table table-bordered>'        
                       <tr><td width='200'>Diskon (%)<?php echo form_error('diskon') ?></td><td><input type="text" class="form-control" name="diskon" id="diskon" placeholder="Diskon" value="<?php echo $diskon; ?>" /></td></tr>
                    <tr><td width='200'>Bulan</td><td>
                    <div class="form-inline">
                        <select class="form-control select2" name="bulan" id="bulan" required>
                            <option value="">--Pilih Bulan--</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <select class="form-control" name="tahun" required>
                            <option value="<?=date('Y')?>"><?=date('Y')?></option>
                        </select>
                    </div>
                    </td></tr>
                    <tr><td></td><td>
                            <!--<input type="hidden" name="kode_dokter" value="<?php echo $kode_dokter; ?>" /> -->
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                            <a href="<?php echo site_url('diskon_trx') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>
                </form>        
            </div>
</div>
</div>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script type="text/javascript">
    $('#bulan').val(<?=$bulan[1]?>).change();
</script>