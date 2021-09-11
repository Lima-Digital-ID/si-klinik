<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
            <?php 
                if($this->session->flashdata('message_type') == 'success')
                    echo alert('alert-success', 'Sukses', $this->session->flashdata('message')); 
            ?>
            </div>
            <div class="col-md-12">
            <?php 
                if($this->session->flashdata('message_type2') == 'danger')
                    echo alert('alert-danger', 'Gagal', $this->session->flashdata('message2'));
            ?>
            </div>
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">IMPORT DATA OBAT DAN ALKES BHP</h3>
                    </div>
                    <form action="<?php echo base_url();?>index.php/dataobat/upload" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                  <label for="exampleInputFile">File input</label>
                                  <input type="file" name="file" />
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-12">
                                  <button type="submit" class="btn btn-primary">Upload File</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>