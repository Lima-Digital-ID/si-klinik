<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <form action="manufaktur_action" method='post'>
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Manufaktur Barang</h3>
                    </div>
                    <div class="box-body">
                            <div class="barang" data-count="0">
                                <?php $this->load->view('dataobat/manufaktur-barang-detail', ['barang' => $barang ,'dataId' => 0]) ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                <br>
                                    <button class="btn btn-sm btn-warning addNew"><span class="fa fa-plus"></span> Tambah Barang</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <br>
                                    <h3 style="padding-right:100px">Total <span id="grandTotal"></span></h3>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="box box-warning box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Barang Baru</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Nama Barang</label>
                                <input type="text" class="form-control" name="nama_barang">
                            </div>
                            <div class="col-md-6">
                                <label for="">Jumlah (Stok)</label>
                                <input type="text" class="form-control" name="jumlah">
                            </div>
                            <div class="col-md-6">
                            <br>
                                <label for="">Harga</label>
                                <input type="text" class="form-control" name="harga">
                            </div>
                            <div class="col-md-6">
                            <br>
                                <label for="">Tanggal Exp</label>
                                <input type="date" class="form-control" name="tgl_exp">
                            </div>
                        </div>
                        <div class="row">
                        <br>
                            <div class="col-md-6">
                                <button type="submit" class='btn btn-success'>Simpan</button>
                                <button type="reset" class='btn btn-default'>Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form> 
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".addNew").click(function(e){
            e.preventDefault();
            var nextId = parseInt($(".barang").attr('data-count')) + 1

            $.ajax({
                type : 'post',
                data : {id : nextId},
                url : "getManufakturDetail",
                success : function(data){
                    $(".barang").attr('data-count', nextId)
                    $(".barang").append(data)
                    $(".select2").select2()

                    $(".remove").click(function(e){
                        e.preventDefault();
                        var thisId = $(this).closest('.row').attr('data-id')

                        $(".row-input[data-id='"+thisId+"']").remove()
                        grandTotal()
                    })
                    $(".kode_barang").change(function(){
                        getStok($(this))
                        grandTotal()
                    })
                    $(".harga").keyup(function(){
                        getTotal($(this),".jumlah")
                        grandTotal()
                    })
                    $(".jumlah").change(function(){
                        getTotal($(this),".harga")
                        grandTotal()
                    })

                }
            })
        })

        function getStok(thisParam){
            var kodeBarang = thisParam.val();
            var id = thisParam.closest('.row-input').attr('data-id')
            var row = ".row-input[data-id='"+id+"'] "
            $(row+" .jumlah option").remove();
            $(row+" .harga").val('0');
            $(row+" .total").val('0');

            if(kodeBarang!=""){
                $.ajax({
                    type  : 'get',
                    data : {kode_barang : kodeBarang},
                    url : 'getStok',
                    success : function(data){
                        $(row+" .jumlah").append("<option value=''>---Pilih Jumlah---</option>");

                        for (let index = 1; index <= data; index++) {
                            $(row+" .jumlah").append("<option>"+index+"</option>");
                        }
                    }
                })
            }
        }

        function getTotal(thisParam,other){
            var thisVal = parseInt(thisParam.val());
            var id = thisParam.closest('.row-input').attr('data-id')
            var row = ".row-input[data-id='"+id+"'] "
            var otherField = $(row+" "+other).val();
            if(otherField!=""){
                otherField = parseInt(otherField);
                var total = thisVal * otherField;

                $(row+" .total").val(total)
            }
        }


        function grandTotal(){
            var grandTotal = 0;
            $(".total").each(function(i,data){
                var total = $(this).val()=="" ? 0 : parseInt($(this).val())
                grandTotal = grandTotal + total;
            })

            $("#grandTotal").html(grandTotal)
        }

        $(".kode_barang").change(function(){
            getStok($(this))
            grandTotal()
        })
        $(".harga").keyup(function(){
            getTotal($(this),".jumlah")
            grandTotal()
        })
        $(".jumlah").change(function(){
            getTotal($(this),".harga")
            grandTotal()
        })


    })
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