<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
            <?php 
            if($this->session->flashdata('message')){
                if($this->session->flashdata('message_type') == 'danger')
                    echo alert('alert-danger', 'Perhatian', $this->session->flashdata('message'));
                else if($this->session->flashdata('message_type') == 'success')
                    echo alert('alert-success', 'Sukses', $this->session->flashdata('message')); 
                else
                    echo alert('alert-info', 'Info', $this->session->flashdata('message')); 
            }
            ?>
            </div>
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">REKAM MEDIS</h3>
                    </div>
                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                        </div>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>No Periksa</th>
                                    <th>No Rekam Medis</th>
                                    <th>Nama Pasien</th>
                                    <!--<th>Klinik</th>-->
                                    <!--<th>Nama Dokter</th>-->
                                    <!--<th>Diagnosa</th>-->
                                    <!--<th>Tgl Periksa</th>-->
                                    <!--<th>Status</th>-->
                                    <th>Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
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
        //         .off('.DT')
        //         .on('keyup.DT', function(e) {
        //             if (e.keyCode == 13) {
        //                 api.search(this.value).draw();
        //             }
        //         });
        //     },
        //     oLanguage: {
        //         sProcessing: "loading..."
        //     },
        //     processing: true,
        //     serverSide: true,
        //     ajax: {"url": "../periksamedis/json_riwayat", "type": "POST"},
        //     columns: [
        //         {
        //             "data": "no_periksa",
        //             "orderable": false
        //         },{"data": "no_periksa"},{"data": "no_rekam_medis"},{"data": "nama_pasien"}/*,{"data": "klinik"},{"data": "nama_dokter"},{"data": "diagnosa"},{"data": "tgl_periksa"},{"data": "status"},*/,{"data": "action", "className" : "text-center"}
        //     ],
        //     order: [[0, 'asc']],
        //     rowCallback: function(row, data, iDisplayIndex) {
        //         var info = this.fnPagingInfo();
        //         var page = info.iPage;
        //         var length = info.iLength;
        //         var index = page * length + (iDisplayIndex + 1);
        //         $('td:eq(0)', row).html(index);
        //     }
        // });
        t = $('#mytable').DataTable();
        t.clear().draw(false);
        $.ajax({
            url : 'json_riwayat',
            type : 'GET',
            dataType : 'json',
            success : function(response){
                arrData=response;
                var j=0;
                for (var i = 0; i < arrData.length; i++) {
                    j++;
                    var tanggal=arrData[i]['dtm_crt'];
                    // var tanggal=tanggal.split(' ');
                    t.row.add([
                        '<div class="text-center">'+j+'</div>',
                        '<div class="text-left">'+arrData[i]['no_periksa']+'</div>',
                        '<div class="text-left">'+arrData[i]['no_rekam_medis']+'</div>',
                        '<div class="text-left">'+arrData[i]['nama_pasien']+'</div>',
                        '<div class="text-left">'+
                                '<a href="<?=site_url('periksamedis/riwayat_detail/')?>'+arrData[i]['no_rekam_medis']+'" class="btn waves-effect waves-light btn-xs btn-success"><i class="fa fa-money"></i></a> '+
                                '</div>'
                    ]).draw(false);
                }
            }
        });
    });
</script>
