<table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                            		<th>Nama Barang</th>
                            		<th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach ($stok as $key => $value) {
                                ?>
                                <tr>
                                    <td><?= $value['kode_barang'] ?></td>
                                    <td><?= $value['nama_barang'] ?></td>
                                    <td><?= $value['stok'] ?></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
<?php 
    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=stok_obat.xls");
?>