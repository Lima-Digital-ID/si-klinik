<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">CHART OF ACCOUNT</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
        <?php //echo anchor(site_url('akuntansi/akun/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-info btn-sm"'); ?>
		<?php //echo anchor(site_url('klinik/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
		<?php // echo anchor(site_url('dokter/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?></div>
        <table width="100%" class="table table-bordered">
            <thead>
                <tr>
        		    <th>No Akun</th>
                    <th>Nama Akun</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Kategori Akun</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($data as $key => $value) {
                ?>
                <tr style="background-color:#3c8dbc; color:white">
                    <td><b><?=$value->no_akun?></b></td>
                    <td><b><?=$value->nama_akun?></b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                    <?php
                        $dataLevel1=$this->db->where('level', 1)->where('id_main_akun', $value->id_akun)->get('tbl_akun')->result();
                        foreach ($dataLevel1 as $k => $v) {
                    ?>
                    <tr>
                        <td><?=$v->no_akun?></td>
                        <td><span style="padding-left:20px"><?=$v->nama_akun?></span></td>
                        <td><?=($v->sifat_debit == 1 ? 'Bertambah' : 'Berkurang')?></td>
                        <td><?=($v->sifat_kredit == 0 ? 'Bertambah' : 'Berkurang')?></td>
                        <td><?=$value->nama_akun?></td>
                    </tr>
                        <?php
                            $dataLevel2=$this->db->where('level', 2)->where('id_main_akun', $v->id_akun)->get('tbl_akun')->result();
                            foreach ($dataLevel2 as $k2 => $v2) {
                        ?>
                        <tr>
                            <td><?=$v2->no_akun?></td>
                            <td><span style="padding-left:40px"><?=$v2->nama_akun?></span></td>
                            <td><?=($v2->sifat_debit == 1 ? 'Bertambah' : 'Berkurang')?></td>
                            <td><?=($v2->sifat_kredit == 0 ? 'Bertambah' : 'Berkurang')?></td>
                            <td><?=$value->nama_akun?></td>
                        </tr>
                            <?php
                                $dataLevel3=$this->db->where('level', 3)->where('id_main_akun', $v2->id_akun)->get('tbl_akun')->result();
                                foreach ($dataLevel3 as $k3 => $v3) {
                            ?>
                            <tr>
                                <td><?=$v3->no_akun?></td>
                                <td><span style="padding-left:60px"><?=$v3->nama_akun?></span></td>
                                <td><?=($v3->sifat_debit == 1 ? 'Bertambah' : 'Berkurang')?></td>
                                <td><?=($v3->sifat_kredit == 0 ? 'Bertambah' : 'Berkurang')?></td>
                                <td><?=$value->nama_akun?></td>
                            </tr>
                            
                            <?php
                                }
                            ?>
                        <?php
                            }
                        ?>
                    <?php
                        }
                    ?>
                <tr style="height:40px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
	    
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
                // $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
                // {
                //     return {
                //         "iStart": oSettings._iDisplayStart,
                //         "iEnd": oSettings.fnDisplayEnd(),
                //         "iLength": oSettings._iDisplayLength,
                //         "iTotal": oSettings.fnRecordsTotal(),
                //         "iFilteredTotal": oSettings.fnRecordsDisplay(),
                //         "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                //         "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                //     };
                // };

                // var t = $("#mytable").dataTable({
                //     initComplete: function() {
                //         var api = this.api();
                //         $('#mytable_filter input')
                //                 .off('.DT')
                //                 .on('keyup.DT', function(e) {
                //                     if (e.keyCode == 13) {
                //                         api.search(this.value).draw();
                //             }
                //         });
                //     },
                //     oLanguage: {
                //         sProcessing: "loading..."
                //     },
                //     processing: true,
                //     serverSide: true,
                //     ajax: {"url": "listAkunJson", "type": "POST"},
                //     columns: [
                //         {
                //             "data": "id_akun",
                //             "orderable": true
                //         },{"data": "no_akun"},{"data": "nama_akun"},{"render": function(data, type, row){
                //             return (row.sifat_debit == 1 ? 'Bertambah' : 'Berkurang');
                //         }},{"render": function(data, type, row){
                //             return (row.sifat_kredit == 1 ? 'Bertambah' : 'Berkurang');
                //         }},
                //         {
                //             "data" : "action",
                //             "orderable": false,
                //             "className" : "text-center"
                //         }
                //     ],
                //     order: [[0, 'desc']],
                //     rowCallback: function(row, data, iDisplayIndex) {
                //         var info = this.fnPagingInfo();
                //         var page = info.iPage;
                //         var length = info.iLength;
                //         var index = page * length + (iDisplayIndex + 1);
                //         $('td:eq(0)', row).html(index);
                //     }
                // });
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