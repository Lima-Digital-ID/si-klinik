<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
            <?php 
            if($this->session->flashdata('message')){
                echo alert('alert-success', 'Sukses', $this->session->flashdata('message')); 
            }
            ?>

            </div>
             <div class="col-xs-12">
                <div class="box box-warning box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">Hutang PO Obat</h3>
                    </div>
        
                    <div class="box-body">
                        <form action="" method="get">
                            <label for="">Supplier</label>
                            <select name="supplier" id="" class="form-control select2">
                                <option value="">---Pilih Supplier---</option>
                                <?php 
                                    foreach ($supplier as $key => $value) {
                                        $selected = isset($_GET['supplier']) && $value->kode_supplier==$_GET['supplier'] ? 'selected' : '';
                                        echo "<option value='".$value->kode_supplier."' $selected>".$value->nama_supplier."</option>";
                                    }
                                ?>
                            </select>
                            <br>
                            <br>
                            <button class="btn btn-info" type="submit"><span class="fa fa-filter"></span> Filter</button>
                            <button class="btn btn-warning" type="reset"><span class="fa fa-times"></span> Reset</button>
                        </form>
                        <?php 
                            if(isset($_GET['supplier'])){
                        ?>
                        <hr>
                        <form action="">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Nomor PO</th>
                            		<th>Nama Supplier</th>
                            		<th>Apoteker</th>
                                    <th>Total Harga</th>
                                    <th>Keterangan</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Sisa Hutang</th>
                            		<th width="150px">Action</th>
                                </tr>
                            </thead>
                        </table>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <h3>Detail Obat</h3>
        <table class="table table-bordered table-striped" id="detailObat">
            <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah PO</th>
                    <th>Diskon</th>
                </tr>
            </thead>
        </table>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
  </div>
  </div>
</div>
<div id="modalBayar" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title">Bayar Hutang</h4>
      </div>
      <div class="modal-body">
      <form action="<?php echo base_url()."supplier/bayar_hutang" ?>" method="post">
        <input type="hidden" name="kode_supplier" value='<?= $_GET['supplier'] ?>'>
        <label for="">Kode Purchase</label>
        <input type="text" name="kode_purchase" class="form-control" readonly id="kodePO">
        <br>
        <label for="">Sisa Hutang</label>
        <input type="text" class="form-control" readonly id="sisaHutang">
        <br>
        <label for="">Nominal Bayar</label>
        <input type="text" name="bayar" class="form-control" id="nominalBayar">
        <br>
        <button class="btn btn-primary">Bayar</button>
      </form>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
  </div>
  </div>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#nominalBayar").keyup(function(){
            var value = $(this).val().split('.').join('')
            var reverse = value.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            // return ribuan;
            $(this).val(ribuan)
        })

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
        <?php
            $filter = isset($_GET['supplier']) && $_GET['supplier']!='' ? '?supplier='.$_GET['supplier'].'&jenis_bayar=1&is_closed=0' : '' 
        ?>

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
            ajax: {"url": "<?= base_url()."Transaksi_apotek/json_po".$filter ?>", "type": "POST"},
            columns: [
                {
                    "data": "kode_purchase",
                    "orderable": false
                },{"data": "kode_purchase"},{"data": "nama_supplier"},{"data": "nama_apoteker"},
                {"data":"total_harga","render":function(data, type, row){
                    return 'Rp. '+formatRupiah(row.total_harga);
                }}
                ,{"data": "keterangan"}
                ,{"data":"jenis_pembayaran","render" : function(data, type, row){
                    return (row.jenis_pembayaran == 0 ? 'Cash' : 'Kredit');
                }},
                {"data":"sisa_hutang","render":function(data, type, row){
                    return 'Rp. '+formatRupiah(row.sisa_hutang);
                }},
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
                $('td:eq(0)', row).html(index);
            }
        });
        
    });
    function modalBayar(kodePo,sisa_hutang){
        $('#modalBayar').show();
        $("#kodePO").val(kodePo)
        $("#sisaHutang").val(formatRupiah(sisa_hutang))
    }
    function cekDetail(id){
        $('#myModal').show();
        // t = $('#detailObat').DataTable();
        // t.clear().draw(false);
        $('#detailObat td').remove();
        $.ajax({
            type: "GET",
            url: "<?=base_url('transaksi_apotek/json_detail_po/')?>"+id, //json get site
            dataType : 'json',
            success: function(response){
                arrData = response;
                $('#title').html('Purchase Order Nomor : '+id)
                for(i = 0; i < arrData.length; i++){
                    // t.row.add([
                    var table=    '<tr><td><div class="text-center">'+arrData[i].kode_barang+'</div></td>'+
                        '<td><div class="text-center">'+arrData[i].nama_barang+'</div></td>'+
                        '<td><div class="text-left">Rp. '+formatRupiah(arrData[i].harga)+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i].jumlah+'</div></td>'+
                        '<td><div class="text-left">'+arrData[i].diskon+'</div></td></tr>';
                    $('#detailObat').append(table);
                    // ]).draw(false);
                }
            }
        });
        
    }
    function formatRupiah(angka, prefix)
      {
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
      }

</script>