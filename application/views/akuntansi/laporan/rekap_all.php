<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
                    <div class="box-header">
                        <h3 class="box-title">REKAP LAPORAN PENGELUARAN</h3>
                    </div>
            
                    <div class="box-body">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Dari Tanggal</label>
                                    <input type="date" name="dari" class="form-control" value="<?= isset($_GET['dari']) ? $_GET['dari'] : '' ?>" >
                                </div>
                                <div class="col-md-6">
                                    <label for="">Sampai Tanggal</label>
                                    <input type="date" name="sampai" class="form-control" value="<?= isset($_GET['sampai']) ? $_GET['sampai'] : '' ?>" >
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <br>
                                    <button type="submit" class='btn btn-primary'><span class="fa fa-filter"></span> Filter</button>
                                    <button type="reset" class='btn btn-default'><span class="fa fa-times"></span> Reset</button>
                                </div>
                            </div>
                        </form>
                        <?php 
                            if(isset($_GET['dari'])){
                        ?>
                        <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover" id="tableLaporan">
                                    <thead>
                                        <tr bgcolor="#3c8dbc" style="color:white">
                                            <td>#</td>
                                            <td>Tanggal</td>
                                            <td>Deskripsi</td>
                                            <td>Jumlah</td>
                                            <td>Opsi</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <!-- <?php 
                                        $no = 0;
                                        foreach ($rekap as $key => $value) {
                                            $no++;
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $value->tanggal ?></td>
                                            <td><?= $value->deskripsi ?></td>
                                            <td><?= number_format($value->jumlah,0,',','.') ?></td>
                                            <td><a href="" class="btn btn-default btn-detail" data-total="<?= number_format($value->jumlah,0,',','.') ?>" data-id="<?= $value->id_trx_akun ?>"><span class="fa fa-table"></span> Detail</a></td>
                                        </tr>
                                    <?php
                                        }
                                    ?> -->
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="table-responsive">
              <table class="table table-hover table-bordered table-striped" id="myTable">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>No Akun</td>
                        <td>Nama Akun</td>
                        <td>Nominal</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script>
    $(document).ready(function() {
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

        var t = $("#tableLaporan").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#tableLaporan_filter input')
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
            ajax: {"url": "json/<?php echo $_GET['dari'].'/'.$_GET['sampai'];?>", "type": "POST"},
            columns: [
                {
                    "data": "id_trx_akun",
                    "orderable": false
                },{"data": "tanggal"},{"data": "deskripsi"},{"data": "jumlah"},
                {
                    "data" : "action",
                    "orderable": false,
                }

            ],
            order: [[1, 'asc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        function rupiah(nominal){
            var	number_string = nominal.toString(),
                sisa 	= number_string.length % 3,
                rupiah 	= number_string.substr(0, sisa),
                ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                    
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }            
            return rupiah
        }
        $('#tableLaporan').on('click', 'td .btn-detail', function (e) {
            e.preventDefault();    
            var table = $('#tableLaporan').DataTable();
            var data = table.row($(this).closest('tr')).data()

            var id = data.id_trx_akun
            var total = data.jumlah
            var dari = $("input[name='dari']").val()
            var sampai = $("input[name='sampai']").val()

            $.ajax({
                type : 'get',
                url : 'rekap_detail',
                data : {dari : dari,sampai : sampai, id_trx : id},
                success : function(data){
                    $('#myModal').modal('show');
                    $("#myTable tbody tr").remove() 
                    $.each(data,function(i,item){
                        i++
                        $("#myTable tbody").append(`
                            <tr>
                                <td>${i}</td>
                                <td>${item.no_akun}</td>
                                <td>${item.nama_akun}</td>
                                <td>${rupiah(item.jumlah)}</td>
                            </tr>
                        `);
                    })

                    $("#myTable tbody").append(`
                        <tr>
                            <th colspan="3" align="center">Total</th>
                            <td>${rupiah(total)}</td>
                        </tr>
                    `);

                }
            })

        });
        
    });
</script>