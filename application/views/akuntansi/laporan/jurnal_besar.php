<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">JURNAL BESAR</h3>
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
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($data as $key => $value) {
                        $total_saldo=0;
                        $total_saldo1=$total_saldo2=$total_saldo3=0;
                        // $dataLevel1=$this->db->where('level', 1)->where('id_main_akun', $value->id_akun)->get('tbl_akun')->result();
                        $this->db->select('tbl_akun.*, tbl_saldo_akun.jumlah_saldo');
                        $this->db->from('tbl_akun');
                        $this->db->join('tbl_saldo_akun', 'tbl_akun.id_akun=tbl_saldo_akun.id_akun');
                        $this->db->where('tbl_akun.level', 1);
                        $this->db->where('tbl_akun.id_main_akun', $value->id_akun);
                        $dataLevel1=$this->db->get()->result();
                        foreach ($dataLevel1 as $k => $v) {
                            // $dataLevel2=$this->db->where('level', 2)->where('id_main_akun', $v->id_akun)->get('tbl_akun')->result();
                                $this->db->select('tbl_akun.*, tbl_saldo_akun.jumlah_saldo');
                                $this->db->from('tbl_akun');
                                $this->db->join('tbl_saldo_akun', 'tbl_akun.id_akun=tbl_saldo_akun.id_akun');
                                $this->db->where('tbl_akun.level', 2);
                                $this->db->where('tbl_akun.id_main_akun', $v->id_akun);
                                $dataLevel2=$this->db->get()->result();
                            foreach ($dataLevel2 as $k2 => $v2) {
                                $this->db->select('tbl_akun.*, tbl_saldo_akun.jumlah_saldo');
                                $this->db->from('tbl_akun');
                                $this->db->join('tbl_saldo_akun', 'tbl_akun.id_akun=tbl_saldo_akun.id_akun');
                                $this->db->where('tbl_akun.level', 3);
                                $this->db->where('tbl_akun.id_main_akun', $v2->id_akun);
                                $dataLevel3=$this->db->get()->result();
                                foreach ($dataLevel3 as $k3 => $v3) {
                                    $total_saldo3+=$v3->jumlah_saldo;
                                }
                                echo 'total saldo '.$v2->nama_akun.' = '.$total_saldo3;
                                echo "<br>";
                                $total_saldo2+=$v2->jumlah_saldo;
                                // echo 'total saldo '. $v2->jumlah_saldo;
                            }
                            echo 'total saldo '.$v->nama_akun.' = '.$total_saldo2;
                            echo "<br>";
                            $saldo=$v->jumlah_saldo;
                            $total_saldo1+=$saldo;
                        }
                        $total_saldo=$total_saldo1+$total_saldo2+$total_saldo3;
                        echo $value->nama_akun.' = '.$total_saldo1;
                        echo "<br>";
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