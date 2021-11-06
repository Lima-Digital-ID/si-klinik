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

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
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
                            ]).draw(false);
                        }
                    }
                });
        
        
    }); 
</script>