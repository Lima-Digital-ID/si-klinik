<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">BUKU BESAR</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
        <?php //echo anchor(site_url('akuntansi/akun/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-info btn-sm"'); ?>
		<?php //echo anchor(site_url('klinik/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
		<?php // echo anchor(site_url('dokter/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?></div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="30px">No</th>
        		    <th>No Akun</th>
                    <th>Nama Akun</th>
                    <th>Saldo Debit</th>
                    <th>Saldo Kredit</th>
        		    <th width="100px">Action</th>
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
                    ajax: {"url": "listAkunJson", "type": "POST"},
                    columns: [
                        {
                            "data": "id_akun",
                            "orderable": true
                        },{"data": "no_akun"},{"data": "nama_akun"},{"render": function(data, type, row){
                            return (row.sifat_debit == 1 ? 'Bertambah' : 'Berkurang');
                        }},{"render": function(data, type, row){
                            return (row.sifat_kredit == 1 ? 'Bertambah' : 'Berkurang');
                        }},
                        {
                            "data" : "action",
                            "orderable": false,
                            "className" : "text-center"
                        }
                    ],
                    order: [[0, 'desc']],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                    }
                });
                // t = $('#mytable').DataTable();
                // t.clear().draw(false);
                // $.ajax({
                //     type: "GET",
                //     url: "akun/json", //json get site
                //     dataType : 'json',
                //     success: function(response){
                //         console.log(response['data']);
                //         arrData = response['data'];
                //         var j=0;
                //         for(i = 0; i < arrData.length; i++){
                //             j+=1;
                //             t.row.add([
                //                 '<div class="text-center">'+j+'</div>',
                //                 '<div class="text-left">'+arrData[i]['no_akun']+'</div>',
                //                 '<div class="text-left">'+arrData[i]['nama_akun']+'</div>',
                //                 '<div class="text-left">'+arrData[i]['level']+'</div>',
                //                 '<div class="text-left">'+arrData[i]['main']+'</div>',
                //                 '<div class="text-center">'+
                //                 '<a href="<?=site_url('akuntansi/akun/update/')?>'+arrData[i]['id_akun']+'" class="btn waves-effect waves-light btn-xs btn-success"><i class="fa fa-edit"></i></a> '+
                //                 '<a href="<?=site_url('akuntansi/akun/delete/')?>'+arrData[i]['id_akun']+'" class="btn waves-effect waves-light btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"><i class="fa fa-trash"></i></a>'+
                //                 '</div>'
                //             ]).draw(false);
                //         }
                //     }
                // });
            });
        </script>