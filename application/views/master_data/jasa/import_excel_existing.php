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
                        <h3 class="box-title">INFORMASI DATA YANG GAGAL DI IMPORT</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                            		<th>Nama Barang</th>
                            		<th>ID Kategori Barang</th>
                            		<th>ID Satuan Barang</th>
                            		<th>Stok Barang</th>
                            		<th>Jenis Barang</th>
                            		<th>Harga</th>
                            		<th>ID Klinik</th>
                            		<th>Error Desc</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
for($i = 0; $i < count($data_existing); $i++){
?>
                                <tr>
                                    <td><?php echo $i+1;?></td>
                                    <td><?php echo $data_existing[$i]['kode_barang'];?></td>
                                    <td><?php echo $data_existing[$i]['nama_barang'];?></td>
                                    <td><?php echo $data_existing[$i]['id_kategori_barang'];?></td>
                                    <td><?php echo $data_existing[$i]['id_satuan_barang'];?></td>
                                    <td><?php echo $data_existing[$i]['stok_barang'];?></td>
                                    <td><?php echo $data_existing[$i]['jenis_barang'];?></td>
                                    <td><?php echo $data_existing[0]['harga'];?></td>
                                    <td><?php echo $data_existing[$i]['id_klinik'];?></td>
                                    <td style="color:red;"><?php echo $data_existing[$i]['error'];?></td>
                                </tr>
<?php  
}
?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="col-sm-12">
                                  <?php echo anchor(site_url('dataobat'), 'Kembali', 'class="btn btn-danger btn-sm"'); ?>
                            </div>
                        </div>
                    </div>
                    <!--</form>-->
                </div>
            </div>
        </div>
    </section>
</div>