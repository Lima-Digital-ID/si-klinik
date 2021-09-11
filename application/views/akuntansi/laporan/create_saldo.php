<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT SALDO</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-3">
                                    <label>Tanggal</label>    
                                    <input type="date" class="form-control" name="tgl" value="<?=date('Y-m-d')?>">
                                </div>
                            <div class="col-sm-5">
                                    <label>Akun</label>    
                                    <?php echo form_dropdown('akun', $akun_option , '' ,array('id'=>'akun','class'=>'form-control select2'));?>
                            </div> 
                            <div class="col-sm-4">
                                    <label>Jumlah</label>    
                                    <input class="form-control" name="jumlah" id="jumlah" required type="number">
                            </div> 
                            <div class="col-sm-4">
                            <br>
                                    <button type="submit" class="btn btn-success" id="submit"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                                    <a href="<?php echo site_url('hrms/jabatan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
                            </div>
                            </div> 
                            </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </form>        
        </div>
    </section>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script type="text/javascript">
    
</script>