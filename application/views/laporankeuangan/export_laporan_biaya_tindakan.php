<table border="1" width="100%">
    <thead>
        <tr>
            <th width="30px">No</th>
            <th>Tanggal Transaksi</th>
            <th>Klinik</th>
            <th>No Transaksi</th>
            <th>Deskripsi Transaksi</th>
            <th>Nominal Transaksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no = 1;
            $ttl = 0;
            foreach ($tindakan as $key => $value) {
                $ttl+=$value->amount_transaksi;
        ?>
            <tr>
                <td><?= $no ?></td>      
                <td><?= $value->tgl_transaksi ?></td>      
                <td><?= $value->klinik ?></td>      
                <td><?= $value->no_transaksi ?></td>      
                <td><?= $value->deskripsi ?></td>      
                <td><?= $value->amount_transaksi ?></td>      
            </tr>
            <?php
            $no++;
        }
        ?>
        <tr>
            <td colspan="5" align="center">Total</td>
            <td><?= $ttl ?></td>      
        </tr>
    </tbody>
</table>
