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
                if($this->session->flashdata('message_type') == 'danger')
                    echo alert('alert-danger', 'Gagal', $this->session->flashdata('message'));
            ?>
            </div>
            <div class="col-xs-12">
                <div class="box box-success box-solid">

                    <div class="box-header">
                        <h3 class="box-title">IMPORT ABSENSI PEGAWAI</h3>
                    </div>
                    <form action="<?php echo base_url();?>index.php/hrms/absensi/upload" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Pilih Bulan : </label>
                                  <div class="form-inline">
                                    <select class="form-control select2" name="bulan" required>
                                        <option value="">--Pilih Bulan--</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <select class="form-control select2" name="tahun" required>
                                        <option value="">--Pilih Tahun--</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                    </select>
                                </div>
                            </div>
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