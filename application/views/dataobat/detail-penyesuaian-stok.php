<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
            </div>
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">PENYESUAIAN STOK BARANG</h3>
                    </div>
                    <div class="box-body">
                    <?php echo anchor(site_url('dataobat/stok_adjustment'), '<i class="fa fa-sign-out" aria-hidden="true"></i> Kembali', 'class="btn btn-warning btn-sm"'); ?>
                        <div style="padding-bottom: 10px;">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>Nama Barang</th>
                                        <th>Stok Awal</th>
                                        <th>Stok Setelah Penyesuaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $no=1;
                                foreach($detail as $detail) {  ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $detail->nama_barang ?></td>
                                        <td><?= $detail->from_stok ?></td>
                                        <td><?= $detail->to_stok ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</div>
