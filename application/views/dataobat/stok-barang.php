<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">DATA STOK OBAT ALKES BHP</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Barang</th>
                            		<th>Nama Barang</th>
                            		<th>Minimum Stok</th>
                            		<th>Stok</th>
                            		<th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
<!--                                 <?php 
                                    // foreach ($stok as $key => $value) {
                                ?>
                                <tr>
                                    <td><?= $value['kode_barang'] ?></td>
                                    <td><?= $value['nama_barang'] ?></td>
                                    <td><?= $value['stok'] ?></td>
                                </tr>
                                <?php
                                    // }
                                ?>
 -->                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="historyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="title">History Pembelian</h4>
      </div>
      <div class="modal-body">
        <h4 style="margin-top:0px">Harga Jual : <span id="harga"></span></h4>
        <table class="table table-bordered table-striped" id="history">
            <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Kode PO</th>
                    <th>Tanggal PO</th>
                    <th>Harga Beli</th>
                    <th>Diskon</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
  </div>
  </div>
</div><script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
     $(document).ready(function() {
        t = $('#mytable').DataTable();
        t.clear().draw(false);
        $.ajax({
            type: "GET",
            url: "<?= isset($jsonURL) ? $jsonURL : 'getStokJson' ?>", //json get site
            dataType : 'json',
            beforeSend : function(){
                $(".dataTables_empty").html('Loading...')
            },
            success: function(response){
                // console.log(response['data']);
                arrData = response['data'];
                var j=0;
                for(i = 0; i < arrData.length; i++){
                    j+=1;
                    t.row.add([
                        '<div class="text-center">'+j+'</div>',
                        '<div class="text-left">'+arrData[i]['kode_barang']+'</div>',
                        '<div class="text-left">'+arrData[i]['nama_barang']+'</div>',
                        '<div class="text-left">'+arrData[i]['minimum_stok']+'</div>',
                        '<div class="text-left">'+arrData[i]['stok']+'</div>',
                        '<div class="text-left"><button class="btn btn-primary btn-sm btn-history" data-kodebarang="'+arrData[i]['kode_barang']+'" data-harga="'+arrData[i]['harga']+'">History Pembelian</button></div>',
                    ]).draw(false);
                }
            }
        });

        function formatRupiah(angka){
            var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }
        function tglIndo(tgl){
            var split = tgl.split('-')
            return split[2]+'-'+split[1]+'-'+split[0]
        }


        $("#mytable tbody").on('click', '.btn-history', function(){
            var kodeBarang = $(this).data('kodebarang')
            var harga = $(this).data('harga')
            $.ajax({
                type : 'get',
                url : 'historyPembelian',
                data : {kode_barang : kodeBarang},
                success : function(res){
                    $("#historyModal").modal('show')
                    $("#harga").html(formatRupiah(harga))

                    $("#history tbody tr").remove()
                    res = JSON.parse(res)
                    $.each(res,function(i,v){
                        i++
                        $("#history tbody").append(`<tr>
                            <td>${i}</td>
                            <td>${v.kode_purchase}</td>
                            <td>${tglIndo(v.dtm_crt)}</td>
                            <td>${formatRupiah(v.harga)}</td>
                            <td>${formatRupiah(v.diskon)}</td>
                        </tr>`)
                    })
                }
            })
        })
        
    }); 

</script>