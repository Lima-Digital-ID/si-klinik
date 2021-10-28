<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT PENERIMAAN BARANG</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class="col-sm-12">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Nama Ekspedisi/Driver
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input class="form-control" name="pengirim" required/>
                            <input type="hidden" class="form-control" name="no_po" required value="<?=$data[0]->kode_purchase?>" />
                            <!-- <input type="hidden" class="form-control" name="supplier" required value="<?=$data[0]->kode_supplier?>" /> -->
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                <br>
                    <div class="table-responsive">    
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>PO Number</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Gudang</th>
                                <th>Lokasi</th>
                                <th>Tanggal Expired</th>
                            </tr>
                                <?php
                                    foreach ($data as $key => $value) {
                                ?>
                            <tr>
                                <td><?=$value->kode_purchase?></td>
                                <td>
                                    <?=$value->kode_barang?>
                                    <input type="hidden" class="form-control" name="kode_barang[]" value="<?=$value->kode_barang?>" />
                                    <input type="hidden" class="form-control" name="harga[]" value="<?=$value->harga?>" />
                                    <input type="hidden" class="form-control" name="diskon[]" value="<?=$value->diskon?>" />
                                </td>
                                <td><?=$value->nama_barang?></td>
                                <td>
                                    <?=$value->jumlah?>
                                    <input type="hidden" class="form-control" name="jumlah[]" value="<?=$value->jumlah?>" />
                                </td>
                                <td><?=$value->keterangan?></td>
                                <td>
                                <?php echo form_dropdown('gudang[]',$gudang_option,'',array('id'=>'gudang[]','class'=>'form-control select2', 'required'=>'required'));?>
                                </td>
                                <td>
                                <?php echo form_dropdown('lokasi[]',$lokasi_option,'',array('id'=>'lokasi[]','class'=>'form-control select2', 'required'=>'required'));?>
                                </td>
                                <td><input type="date" class="form-control" name="tgl_exp[]" required/></td>
                            </tr>
                                <?php
                                    }
                                ?>
                        </table>
                    </div>
                </div>
                <div class="form-group row" style="margin-left:auto">
                    <div class="col-sm-9">
                <br>
                        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                        <a href="<?php echo site_url('transaksi_apotek/receipt') ?>" class="btn btn-warning"><i class="fa fa-sign-out"></i> Kembali</a>
                    </div>
                </div>
                    <br>

                     
                </form>        
            </div>
</div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>