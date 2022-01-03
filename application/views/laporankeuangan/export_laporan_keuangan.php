<table class="table table-bordered table-striped" id="mytable" width="100%" border="1">
    <thead>
        <tr>
            <th width="30px">No</th>
            <th>Tanggal Transaksi</th>
            <th>Klinik</th>
            <th>No Transaksi</th>
            <th>Deskripsi Transaksi</th>
            <th>Nominal Transaksi</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 0; 
        foreach ($data as $key => $value) {
            $no++; 
        ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $value->tgl_transaksi ?></td>
                <td><?= $value->klinik ?></td>
                <td><?= $value->no_transaksi ?></td>
                <td><?= $value->deskripsi ?></td>
                <td align="right"><?= $value->amount_transaksi ?></td>
                <td align="right"><?= $value->amount_transaksi ?></td>
                <td align="right"><?= $value->credit ?></td>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>
