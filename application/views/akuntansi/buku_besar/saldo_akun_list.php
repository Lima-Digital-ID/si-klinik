<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">LIST SALDO</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
        <?php echo anchor(site_url('akuntansi/akun/create_saldo'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-info btn-sm"'); ?>
		<?php //echo anchor(site_url('klinik/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
		<?php // echo anchor(site_url('dokter/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?></div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="30px">No</th>
        		    <th>No Akun</th>
                    <th>Nama Akun</th>
                    <th>Jumlah Saldo Awal</th>
        		    <!-- <th width="100px">Action</th> -->
                </tr>
            </thead>
	        
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
                    url: "json_saldo", //json get site
                    dataType : 'json',
                    success: function(response){
                        arrData = response;
                        var j=0;
                        for(i = 0; i < arrData.length; i++){
                            j+=1;
                            t.row.add([
                                '<div class="text-center">'+j+'</div>',
                                '<div class="text-left">'+arrData[i]['no_akun']+'</div>',
                                '<div class="text-left">'+arrData[i]['nama_akun']+'</div>',
                                '<div class="text-left">Rp. '+formatRupiah(arrData[i]['jumlah_saldo'])+'</div>',
                                // '<div class="text-center">'+
                                // '<a href="<?=site_url('akuntansi/akun/update/')?>'+arrData[i]['id_akun']+'" class="btn waves-effect waves-light btn-xs btn-success"><i class="fa fa-edit"></i></a> '+
                                // // '<a href="<?=site_url('akuntansi/akun/delete/')?>'+arrData[i]['id_akun']+'" class="btn waves-effect waves-light btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"><i class="fa fa-trash"></i></a>'+
                                // '</div>'
                            ]).draw(false);
                        }
                    }
                });
            });
            function formatRupiah(angka, prefix)
            {
                var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return ribuan;
            }
        </script>