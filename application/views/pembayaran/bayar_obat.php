<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
</style>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<?php  echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-bayar')); ?>
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
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">FORM PEMBAYARAN</h3>
                    </div>
                    <div class="box-body">
						<!--<div class="form-group">-->
						<!--	<div class="col-sm-3"><label>Kode Transaksi</label></div>-->
						<!--	<div class="col-sm-3"><?php // echo $kode_transaksi;?></div>-->
						<!--	<div class="col-sm-3"><label>Klinik</label></div>-->
						<!--	<div class="col-sm-3"><?php // echo $klinik;?></div>-->
      <!--                  </div>-->
                        <div class="form-group">
							<div class="col-sm-3"><label>No Transaksi</label></div>
							<div class="col-sm-3">
							    <a target="_blank" href="<?php echo site_url('pembayaran/detail?id=').$no_transaksi;?>">
							        <?php echo $no_transaksi;?>
							    </a>
							</div>
							<div class="col-sm-3"><label>Tanggal Transaksi</label></div>
							<div class="col-sm-3"><?php echo $tgl_transaksi;?></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-3"><label>Status Transaksi</label></div>
							<div class="col-sm-3"><?php echo $status_transaksi == 0 ? 'Belum Dibayar' : 'Lunas';?></div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <div class="col-sm-3"><label>Deskripsi Transaksi</label></div>
							<div class="col-sm-3"><label>Nominal Transaksi</label></div>
						</div>
                    <?php
                    foreach($transaksi_d as $data){
                    ?>
                        <div class="form-group">
                            <div class="col-sm-3"><?php echo $data->deskripsi;?></div>
							<div class="col-sm-3"><?php echo $data->dc == 'd' ? number_format($data->amount_transaksi,2,',','.') : ($data->amount_transaksi != 0 ? '-'.number_format($data->amount_transaksi,2,',','.') : number_format(0,2,',','.'));?></div>
						</div>
                    <?php
                        if($data->dc == 'd')
                            $total_transaksi += $data->amount_transaksi;
                        else
                            $total_transaksi -= $data->amount_transaksi;
                    }
                    ?>
                        <hr />
                        <div class="form-group">
							<div class="col-sm-12"><label>DATA OBAT</label></div>
                        </div>
                        <div class="form-group">
							<div class="col-sm-2"><label>Nama Obat</label></div>
							<div class="col-sm-2"><label>Jumlah</label></div>
							<div class="col-sm-2"><label>Harga</label></div>
							<div class="col-sm-2"><label>Total Harga</label></div>
                        </div>
                        <?php
foreach($transaksi_d_obat as $data){
?>
                        <div class="form-group">
							<div class="col-sm-2"><?php echo $data->nama_barang;?></div>
							<div class="col-sm-2"><?php echo $data->jumlah;?></div>
							<div class="col-sm-2"><?php echo number_format($data->harga,2,',','.');?></div>
							<div class="col-sm-2"><?php echo number_format($data->harga * ceil($data->jumlah),2,',','.');?></div>
                        </div>
<?php
}
$diskon=$total_transaksi*(($getDiskon != null ? $getDiskon->diskon : 0) / 100);
?>
                        
                        Subsidi Bulanan :<b> <?php echo $getDiskon != null ?  $getDiskon->diskon : 0;?> % </b>
                        
                        <hr />
                        <div class="form-group">
							<div class="col-sm-3">Total Transaksi</div>
    						<div class="col-sm-3">
    							<?php echo form_input(array('id'=>'total_transaksi','name'=>'total_transaksi','type'=>'number','value'=>$total_transaksi,'class'=>'form-control','readonly'=>'readonly','style'=>'text-align:right;','placeholder'=>'0'));?>
    						</div>
						</div> 
						<div class="form-group">
							<div class="col-sm-3">Total Subsidi</div>
    						<div class="col-sm-3">
    							<?php echo form_input(array('id'=>'subsidi_transaksi','name'=>'subsidi_transaksi','type'=>'number','value'=>$diskon,'class'=>'form-control','style'=>'text-align:right;','readonly'=>'readonly','placeholder'=>'0','onchange'=>'hitung_bayar()'));?>
    						</div>
						</div>
						<div class="form-group">
							<div class="col-sm-3">Total yang Harus Dibayar</div>
    						<div class="col-sm-3">
    							<?php echo form_input(array('id'=>'total_pembayaran','name'=>'total_pembayaran','type'=>'number','value'=>($total_transaksi-$diskon),'class'=>'form-control','readonly'=>'readonly','style'=>'text-align:right;','placeholder'=>'0'));?>
    						</div>
						</div>
						<hr />
						<div class="form-group">
							<div class="col-sm-12">
								<div align="right">
									<button id="bayar" type="submit" class="btn btn-danger" onclick="tab1Show();"><i class="fa  fa-dollar"></i> Bayar Sekarang</button>
                                    <script type="text/javascript"> 
                                        // function tab1Show()
                                        // {
                                        //     // var is_cetak = $('#is_cetak_surat:checked').val();
                                        //     // if(is_cetak)
                                        //     // var atas_nama = $('#atas_nama').val();
                                        //     // alert(atas_nama);
                                        //     window.open('<?php // echo site_url('pembayaran/cetak_surat/' . $id_transaksi);?>', '_blank');
                                        // }
                                    </script>
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
    
    function hitung_bayar(){
        var total_transaksi = parseInt($('#total_transaksi').val());
        var subsidi_transaksi = parseInt($('#subsidi_transaksi').val() != '' ? $('#subsidi_transaksi').val() : 0);
        
        //menghitung subsidi
        if(subsidi_transaksi > total_transaksi){
            subsidi_transaksi = total_transaksi;
            $('#subsidi_transaksi').val(total_transaksi);
        } else if (subsidi_transaksi < 0){
            subsidi_transaksi = 0;
            $('#subsidi_transaksi').val(0);
        }
        
        $('#total_pembayaran').val(parseInt(total_transaksi) - parseInt(subsidi_transaksi));
    }
    
    function hitung_total(){
        var biaya_administrasi = parseInt($('#biaya_administrasi').val());
        var total_sebelum = <?php echo $total_transaksi;?>;
        
        //menghitung total
        $('#total_transaksi').val(parseInt(biaya_administrasi) + parseInt(total_sebelum));
        hitung_bayar();
    }


</script>
