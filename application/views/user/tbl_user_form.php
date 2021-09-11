<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA USER</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

            <div class="box-body">
                <div class="form-group">
                    <div class="col-sm-2">Nama Lengkap <?php echo form_error('full_name') ?></div>
					<div class="col-sm-10">
					    <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" value="<?php echo $full_name; ?>" />
					</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Email <?php echo form_error('email') ?></div>
					<div class="col-sm-10">
					    <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
					</div>
                </div>
                <?php
                if($this->uri->segment(2)=='create'){
                ?>
                <div class="form-group">
                    <div class="col-sm-2">Password <?php echo form_error('password') ?></div>
					<div class="col-sm-10">
					    <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
					</div>
                </div>
                <?php
                }
                ?>
                <div class="form-group">
                    <div class="col-sm-2">Level User <?php echo form_error('id_user_level') ?></div>
					<div class="col-sm-10">
					    <?php echo cmb_dinamis('id_user_level', 'tbl_user_level', 'nama_level', 'id_user_level', $id_user_level, 'onchange="cek_user_level();" id="id_user_level"') ?>
					</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Status Aktif <?php echo form_error('is_aktif') ?></div>
					<div class="col-sm-10">
					    <?php echo form_dropdown('is_aktif', array('y' => 'AKTIF', 'n' => 'TIDAK AKTIF'), $is_aktif, array('class' => 'form-control')); ?>
					</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">Foto Profile <?php echo form_error('images') ?></div>
					<div class="col-sm-10">
					    <input type="file" name="images">
					</div>
                </div>
                <div id="dokter" style="display:none;">
                    <div class="form-group">
                        <div class="col-sm-2">Dokter</div>
    					<div class="col-sm-10">
    					    <?php echo cmb_dinamis('id_dokter', 'tbl_dokter', 'nama_dokter', 'id_dokter', $id_dokter) ?>
    					</div>
                    </div>
                </div>
                <div id="klinik" style="display:none;">
                    <div class="form-group">
                        <div class="col-sm-2">Klinik</div>
    					<div class="col-sm-10">
    					    <?php echo cmb_dinamis('id_klinik', 'tbl_klinik', 'nama', 'id_klinik', $id_klinik) ?>
    					</div>
                    </div>
                </div>
                <div class="form-group">
					<div class="col-sm-12">
					    <input type="hidden" name="id_users" value="<?php echo $id_users; ?>" /> 
					    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                        <a href="<?php echo site_url('user') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
					</div>
                </div>
            </div>   
        </div>
    </section>
</div>
<script type="text/javascript"> 
$(document).ready(function() {
    cek_user_level();
});
                            function cek_user_level(){
                                var user_level = $('#id_user_level').val();
                                // alert(user_level);
                                if (user_level == 5){
                                    document.getElementById("klinik").style.display="block";
                                    document.getElementById("dokter").style.display="block";
                                }else if (user_level == 1){
                                    document.getElementById("klinik").style.display="none";
                                    document.getElementById("dokter").style.display="none";
                                }else{
                                    document.getElementById("klinik").style.display="block";
                                    document.getElementById("dokter").style.display="none";
                                }
                                    
                            }
                            </script>