<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Cetak Asuransi</title>

  <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/jquery-ui/themes/base/minified/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/paper-css/paper.css">
  
  <style>
	.header img {
	  margin-top: -40px;
	  float: left;
	  width: 100px;
	  height: 100px;
	}

	.header h2 {
	  position: relative;
	  top: -15px;
	  left: 20px;
	  font-size: 20px;
	}
  </style>

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }</style>

</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4" onload="window.print()">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <div class="header" style="background:#fffff;">
	  <img src="<?php echo base_url()?>assets\images/logo_mitra_sehat_keluarga.png" alt="logo" />
	  <h2 style="text-align: left;">MITRA SEHAT KELUARGA - PRAKTEK DOKTER UMUM
		<br />
		<span style="font-size:12px;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</span>
	  </h2>
	  <!--<h4 style="text-align: left;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</h4>-->
	</div>
<div>
<hr />
<h4 style="text-align: center;"><span style="text-decoration: underline;">REKAPITULASI PEMBAYARAN MENGGUNAKAN ASURANSI</span></h4>
<br />
<table class="table">
    <tr>
        <th width="3%">No</th>
        <th width="22%">Tanggal</th>
        <th width="20%">No ID Pasien</th>
        <th width="20%">Nama Pasien</th>
        <th width="17%">Tanggal Lahir</th>
        <th width="18%">Nominal</th>
    </tr>
<?php
$i = 1;
if(count($asuransi) > 0){
foreach($asuransi as $data){
?>
    <tr>
        <td><?php echo $i;?></td>
        <td><?php echo $data->tgl_pembayaran;?></td>
        <td><?php echo $data->no_id_pasien;?></td>
        <td><?php echo $data->nama_pasien;?></td>
        <td><?php echo $data->tanggal_lahir;?></td>
        <td><?php echo number_format($data->amount,2,',','.');?></td>
    </tr>
<?php
$i++;
}
} else {
?>
    <tr>
        <td colspan=6 style="text-align:center;">
            Tidak ada data
        </td>
    </tr>
<?php
}
?>
</table>
</div>
  </section>

</body>

</html>

