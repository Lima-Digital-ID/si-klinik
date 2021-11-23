<div class="content-wrapper">
    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT PURCHASE ORDER</h3>
            </div>
            <form action="<?php echo base_url(). 'dataobat/insert_adjustment'; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-sm-2">Id Inventory</div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="id_inventory">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Kode Purchase</div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="kode_purchase">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Kode Barang</div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="kode_barang">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Kode Gudang</div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="kode_gudang">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">Jumlah Barang</div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name=jumlah>
                        </div>
                    </div>
                        <div class=col-sm-12"" align="right">
                            <a href=""<?php echo site_url('pendaftaran') ?>" class="btn btn-info"><i class="fa fa-sign-out">Kembali</i></a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"> Simpan Pendaftaran</i></button>
                        </div>
                </div>
        </form>
    </section>
</div>