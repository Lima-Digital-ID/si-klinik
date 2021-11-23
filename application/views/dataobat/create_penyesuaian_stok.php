<div class="content-wrapper">
    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT ADJUST STOK</h3>
            </div>
            <form action="<?php echo base_url(). 'dataobat/insert_adjustment'; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="box-body">
                <div class="form-control" id="row-stok" data-row='0'>
                    <?php 
                    $this->load->view('dataobat/loop_penyesuaian_stok',['no' => 0])
                    ?>
                </div>
                        <div class=col-sm-12"" align="right">
                            <a href=""<?php echo site_url('pendaftaran') ?>" class="btn btn-info"><i class="fa fa-sign-out">Kembali</i></a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"> Simpan Pendaftaran</i></button>
                        </div>
                </div>
        </form>
    </section>
</div>