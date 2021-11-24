<div class="content-wrapper">
    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT ADJUST STOK</h3>
            </div>
            <form action="<?php echo base_url(). 'dataobat/insert_adjustment'; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="" id="row-stok" data-row='0'>
                                <?php 
                                    $this->load->view('dataobat/loop_penyesuaian_stok',['no' => 0])
                                ?>
                            </div>
                    <div class="col-sm-16">
                        <a href="" class="btn btn-info btn-sm" id="addItemLab">Tambah Item</a>
                    </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <a href=""<?php echo site_url('dataobat/stok_adjustment') ?>" class="btn btn-warning"><i class="fa fa-sign-out">Kembali</i></a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"> Simpan Adjustmen</i></button>
                                </div>
                            </div>
                        </div>
                </div>
        </form>
    </section>
</div>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>

<script>
     $(document).ready(function(){

        $("#addItemLab").click(function(e){
            e.preventDefault();
            var dataRow = parseInt($('#row-stok').attr('data-row'))
            $.ajax({
                type : 'get',
                url : '<?= base_url().'dataobat/newItemAdj' ?>',
                data : {no : dataRow+1},
                success : function(data){
                    $('#row-stok').append(data)
                    $('#row-stok').attr('data-row',dataRow + 1)

                    $(".remove-stok").click(function(e){
                        e.preventDefault();
                        var dataNo = $(this).attr('data-no')
                        var dataRow = parseInt($('#row-stok').attr('data-row'))
                        $('.loop-penyesuaian-stok[data-no="'+dataNo+'"]').remove()
                        $('#row-stok').attr('data-row',dataRow-1)
                    })
                    $(".select2").select2()
                }
            })
        })
    })
</script>