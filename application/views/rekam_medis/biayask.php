<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">Biaya Surat Keterangan</h3>
                    </div>

                    <div class="box-body">
                        <div class="row col-md-12" style="margin-bottom: 10px">
                        <?php 
                            if($this->session->flashdata('success')){
                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-check-circle"></i> Success</h4>
                                <?= $this->session->flashdata('success') ?>
                            </div>                                
                        <?php
                            }
                        ?>
                        
                            <form action="" method="post">
                                <div class="form-group">
                                    <div class="col-sm-2">Surat Keterangan Sehat <?php echo form_error('sksehat'); ?></div>
                                    <div class="col-sm-10">
                                        <input type="number" name="sksehat" class="form-control" value="<?= $sksehat ?>">
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                                <div class="form-group">
                                    <div class="col-sm-2">Surat Keterangan Sakit <?php echo form_error('sksakit'); ?></div>
                                    <div class="col-sm-10">
                                        <input type="number" name="sksakit" class="form-control" value="<?= $sksakit ?>">
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="form-group">
                                    <div class="col-sm-2">Rapid Antigen Covid-19 <?php echo form_error('rapid_antigen'); ?></div>
                                    <div class="col-sm-10">
                                        <input type="number" name="rapid_antigen" class="form-control" value="<?= $rapid_antigen ?>">
                                    </div>
                                </div>
                                <br>
                            <br>
                            <div class="pull-right">
                                <button class="btn btn-default" type="reset"><span class="fa fa-times"></span> Reset</button>
                                <button class="btn btn-success" type="submit"><span class="fa fa-save"></span> Simpan</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>