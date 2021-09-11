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
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">SINKRONISASI DATA</h3>
                    </div>
                    <?php echo form_open('sinkronisasi/sinkronisasi_action', array('class' => 'form-horizontal', 'id' => 'form-sinkronisasi')); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Terakhir sinkronisasi pada <?php echo $last_sync;?></label>
                            </div>
                        </div>
                        <?php 
                        if($this->session->flashdata('message_content')){
                        ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                Response Push Data Sinkronisasi
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php
                                    echo $this->session->flashdata('message_content');
                                ?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <?php 
                        if($this->session->flashdata('message_content2')){
                        ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                Response Pull Data Sinkronisasi
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php
                                    echo $this->session->flashdata('message_content2');
                                ?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="hidden" name="submit" />
                                <button type="submit" class="btn btn-danger"><i class="fa fa-refresh"></i> Sinkronkan</button> 
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </section>
</div>