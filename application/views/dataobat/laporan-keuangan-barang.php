<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Laporan Keuangan</h3>
                    </div>
                    <div class="box-body">
                        <form action="" method='get'>
                            <div class="row">
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
                            if(isset($laporan)){
                            foreach ($laporan as $key => $value) {
                        ?>
                        <div class="panel panel-info">
                        <div class="panel-heading">
                        INV <?= $value['no_transaksi'] ?>
                        </div>
                        <div class="panel-body" style="padding:0">
                        <table style="margin-bottom:0" class="table table-bordered table-striped" id="mytable">
                            <tr>
                                <td width="30%">Biaya Obat</td>
                                <td><?= number_format($value['biaya_obat'],0,',','.') ?></td>
                            </tr>
                            <tr>
                                <td width="30%">Biaya Pemeriksaan</td>
                                <td><?= number_format($value['biaya_pemeriksaan'],0,',','.') ?></td>
                            </tr>
                            <tr>
                                <td width="30%">Biaya Tindakan</td>
                                <td><?= number_format($value['biaya_tindakan'],0,',','.') ?></td>
                            </tr>
                            <tr>
                                <td width="30%">Biaya Admin</td>
                                <td><?= number_format($value['biaya_admin'],0,',','.') ?></td>
                            </tr>
                            <tr>
                                <td>Total Biaya</td>
                                <td><?= number_format($value['biaya_obat'] + $value['biaya_pemeriksaan'] + $value['biaya_tindakan'] + $value['biaya_admin'],0,',','.') ?></td>
                            </tr>
                        </table>
                        </div>
                        </div>
                        <?php } } ?>
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