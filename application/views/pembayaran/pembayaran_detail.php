<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-rekam_medis')); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">DETAIL PERIKSA MEDIS</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
							<div class="col-sm-12"><label>DATA PASIEN</label></div>
                        </div>
						<div class="form-group">
							<div class="col-sm-2">No Rekam Medis</div>
							<div class="col-sm-4"><?php echo $no_rekam_medis;?></div>
							<div class="col-sm-2">No ID Pasien</div>
							<div class="col-sm-4"><?php echo $no_id_pasien;?></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Nama Pasien</div>
							<div class="col-sm-4"><?php echo $nama_pasien;?></div>
							<div class="col-sm-2">Alamat Pasien</div>
							<div class="col-sm-4"><?php echo $alamat;?></div>
                        </div>
                        <hr />
                        <div class="form-group">
							<div class="col-sm-12"><label>DATA PERIKSA MEDIS</label></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">No Periksa</div>
							<div class="col-sm-4"><?php echo $no_periksa;?></div>
							<div class="col-sm-2">Anamnesi</div>
							<div class="col-sm-4"><?php echo $anamnesi;?></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Diagnosa</div>
							<div class="col-sm-4"><?php echo $diagnosa;?></div>
							<div class="col-sm-2">Tindakan</div>
							<div class="col-sm-4"><?php echo $tindakan?></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Nama Dokter</div>
							<div class="col-sm-4"><?php echo $nama_dokter;?></div>
							<div class="col-sm-2">Catatan Dokter</div>
							<div class="col-sm-4"><?php echo $note_dokter != null ? $note_dokter : '-';?></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2">Tanggal Periksa</div>
							<div class="col-sm-4"><?php echo $tgl_periksa;?></div>
                        </div>
                        <hr />
                        <div class="form-group">
							<div class="col-sm-12"><label>DATA PERIKSA FISIK</label></div>
                        </div>
<?php
foreach($periksa_d_fisik as $data){
?>
                        <div class="form-group">
							<div class="col-sm-2"><?php echo $data->nama_periksa_fisik;?></div>
							<div class="col-sm-4"><?php echo $data->nilai_periksa_fisik;?></div>
                        </div>
<?php
}
?>
       <!--                 <hr />-->
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-12"><label>DATA ALAT KESEHATAN</label></div>-->
       <!--                 </div>-->
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-2"><label>Nama Alat Kesehatan</label></div>-->
							<!--<div class="col-sm-2"><label>Jumlah</label></div>-->
							<!--<div class="col-sm-2"><label>Harga</label></div>-->
							<!--<div class="col-sm-2"><label>Total Harga</label></div>-->
       <!--                 </div>-->
<?php
//foreach($periksa_d_alkes as $data){
?>
       <!--                 <div class="form-group">-->
							<!--<div class="col-sm-2"><?php echo $data->nama_barang;?></div>-->
							<!--<div class="col-sm-2"><?php echo $data->jumlah;?></div>-->
							<!--<div class="col-sm-2"><?php echo number_format($data->harga,2,',','.');?></div>-->
							<!--<div class="col-sm-2"><?php echo number_format($data->harga * $data->jumlah,2,',','.');?></div>-->
       <!--                 </div>-->
<?php
//}
?>
                        <hr />
                        <div class="form-group">
							<div class="col-sm-12"><label>DATA OBAT</label></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2"><label>Nama Obat</label></div>
							<div class="col-sm-2"><label>Anjuran</label></div>
							<div class="col-sm-2"><label>Keterangan</label></div>
							<div class="col-sm-2"><label>Jumlah</label></div>
							<div class="col-sm-2"><label>Harga</label></div>
							<div class="col-sm-2"><label>Total Harga</label></div>
                        </div>
                        <?php
foreach($periksa_d_obat as $data){
?>
                        <div class="form-group">
							<div class="col-sm-2"><?php echo $data->nama_barang;?></div>
							<div class="col-sm-2"><?php echo $data->anjuran;?></div>
							<div class="col-sm-2"><?php echo $data->keterangan;?></div>
							<div class="col-sm-2"><?php echo $data->jumlah;?></div>
							<div class="col-sm-2"><?php echo number_format($data->harga,2,',','.');?></div>
							<div class="col-sm-2"><?php echo number_format($data->harga * ceil($data->jumlah),2,',','.');?></div>
                        </div>
<?php
}
?>
                        <hr />
                        <div class="form-group">
							<div class="col-sm-12">
								<div align="right">
									<a href="javascript:close_window();"><span class="btn btn-danger">Tutup</span></a> 
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php echo form_close();?>

<script type="text/javascript">
    function close_window(){
        window.close();
    }
</script>
