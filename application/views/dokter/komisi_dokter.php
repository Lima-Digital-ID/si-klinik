<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">Laporan Komisi Dokter</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <form action="" method="get">
                                <div class="col-md-4">
                                    <label for="">Dokter</label>
                                    <select  name="id_dokter" class="select2 form-control">
                                        <option value="">---Pilih Dokter---</option>
                                        <?php 
                                            foreach ($dokter as $value) {
                                                $s = isset($_GET['id_dokter']) && $_GET['id_dokter']==$value->id_dokter ? 'selected' : '';
                                                echo "<option value='".$value->id_dokter."' $s>".$value->nama_dokter."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Dari Tanggal</label>
                                    <input type="date" name="dari" id="" class="form-control" value="<?= isset($_GET['dari']) ? $_GET['dari'] : '' ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Sampai Tanggal</label>
                                    <input type="date" name="sampai" id="" class="form-control" value="<?= isset($_GET['sampai']) ? $_GET['sampai'] : '' ?>">
                                </div>
                                <div class="col-md-4">
                                    <br>
                                    <button class="btn btn-default">Reset</button>
                                    <button class="btn btn-success">Filter</button>
                                </div>
                            </form>
                        </div>
                        <?php 
                            if(isset($komisi)){
                        ?>
                        <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tanggal</th>
                                                    <th>Nomor Transaksi</th>
                                                    <th>Komisi</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $no = 0;
                                                    $total = 0;
                                                    foreach ($komisi as $value) {
                                                        $no++;
                                                        $total+=$value->komisi;
                                                ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= date('d-m-Y', strtotime($value->tanggal)) ?></td>
                                                        <td><?= $value->no_transaksi ?></td>
                                                        <td><?= number_format($value->komisi,0,',','.') ?></td>
                                                        <td>Komisi Biaya <?= $value->type ?></td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr bgcolor="#3c8dbc">
                                                    <th colspan="3" class="text-center" style="color:white">Total</th>
                                                    <th style="color:white"><?= number_format($total,0,',','.') ?></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
