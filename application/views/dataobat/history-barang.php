<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">DATA HISTORY OBAT ALKES BHP</h3>
                    </div>
                    <div class="box-body">
                        <form action="" method='get'>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Barang</label>
                                    <select name="kode_barang" id="" class="form-control select2">
                                        <option value="">---Pilih Barang---</option>
                                        <?php 
                                            foreach ($barang as $key => $value) {
                                                $selected  = isset($_GET['kode_barang']) && $_GET['kode_barang']==$value->kode_barang ? 'selected' : '';
                                                echo "<option value='".$value->kode_barang."' $selected>".$value->nama_barang."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Dari Tanggal</label>
                                    <input type="text" name="dari" class="datepicker form-control" value="<?= isset($_GET['dari']) ? $_GET['dari'] : '' ?>" >
                                </div>
                                <div class="col-md-3">
                                    <label for="">Sampai Tanggal</label>
                                    <input type="text" name="sampai" class="datepicker form-control" value="<?= isset($_GET['sampai']) ? $_GET['sampai'] : '' ?>" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <br>
                                    <button type="submit" class='btn btn-success'>Filter</button>
                                    <button type="reset" class='btn btn-default'>Reset</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <?php 
                            if(isset($history)){
                        ?>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pengeluaran</th>
                            		<th>Pemasukan</th>
                            		<th>Keterangan</th>
                            		<th>Stok</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="5" align='center'>Stok Awal</td>
                                    <td><?= $stokAwal ?></td>
                                </tr>
                                <?php 
                                    $no = 0;
                                    $setStokAwal = $stokAwal;
                                    foreach ($history as $key => $value) {
                                        $no++;
                                        $stokNow = $value->inv_type=='RETURN_STUFF' || $value->inv_type=='RETURN_MONEY' || $value->inv_type=='TRX_STUFF' || $value->inv_type=='MANUFAKTUR_OUT' ?  $setStokAwal - $value->jumlah  : $setStokAwal+$value->jumlah;
                                        $setStokAwal =  $stokNow;
                                ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= date('d-m-Y', strtotime($value->dtm_crt)); ?></td>
                                        <td><?= $value->inv_type=='RETURN_STUFF' || $value->inv_type=='RETURN_MONEY' || $value->inv_type=='TRX_STUFF' || $value->inv_type=='MANUFAKTUR_OUT' ? $value->jumlah : '' ?></td>
                                        <td><?= $value->inv_type=='RECEIPT_ORDER' || $value->inv_type=='MANUFAKTUR_IN' ? $value->jumlah : '' ?></td>
                                        <td><?= $value->inv_type=='RETURN_STUFF' || $value->inv_type=='RETURN_MONEY' || $value->inv_type=='TRX_STUFF' || $value->inv_type=='MANUFAKTUR_OUT' ? 'Obat Keluar' : 'Obat Masuk' ?> dari <?= $value->id_inventory ?></td>
                                        <td><?= $stokNow ?></td>
                                    </tr>
                                <?php
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="5" align='center'>Stok Akhir</td>
                                        <td><?= $stokNow ?></td>
                                    </tr>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
/*     $(document).ready(function() {
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        var t = $("#mytable").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                .off('.DT')
                .on('keyup.DT', function(e) {
                    if (e.keyCode == 13) {
                        api.search(this.value).draw();
                    }
                });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {"url": "jsonStok", "type": "POST"},
            columns: [
                {"data": "kode_barang"},{"data" : "stok_barang"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[0, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('t:eq(0)', row).html(index);
            }
        });
        
    }); */
</script>