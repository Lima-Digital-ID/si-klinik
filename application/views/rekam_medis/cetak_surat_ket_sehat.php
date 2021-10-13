<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Surat Keterangan Sehat</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">-->

  <!-- Load paper.css for happy printing -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">-->
  
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/paper-css/paper.css">
  
  <style>
	  .header{
		  display: flex;
	  }
	  .header .right{
		  width: 100%;
	  }
  </style>
  

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A5 }</style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A5" onload="window.print()">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm"  style="padding-top:5mm">

    <!-- Write HTML just like a web page -->
    <!--<article>This is an A5 document.</article>-->
	<div class="header">
		<div class="left">
			<img src="<?php echo base_url()."assets/images/".getInfoRS('logo')?>" alt="logo" width="100" />
		</div>
	  <div class="right">
		  <center>
			  <h2 style="margin-bottom:0"><?= getInfoRS('nama_rumah_sakit') ?></h2>
			  <p style="margin-top:5px;margin-bottom:0"><?= getInfoRS('alamat') ?></p>
			  <p style="margin-top:5px"><?= getInfoRS('no_telpon') ?></p>
			</center>
		</div>
	  <!--<h4 style="text-align: left;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</h4>-->
	</div>
<hr />
	<div style="display:inline-block;position:relative;left:50%;transform:translateX(-50%);-moz-transform:translateX(-50%);-webkit-transform:translateX(-50%)">
		<h3 style="margin-bottom : 0px;margin-top:5"><span style="text-decoration: underline;">SURAT KETERANGAN SEHAT</span></h3>
		<p style="margin-top : 5px;margin-bottom:0;text-align:center;letter-spacing:2px"><b>No. <?= $nomor ?></b></p>
	</div>
<p style="text-indent: 30px;"> Yang bertanda tangan dibawah ini, dokter jaga pada <?= getInfoRS('nama_rumah_sakit') ?> dengan sebenarnya bahwa</p>
<table style="margin-right : 30px;margin-left : 30px">
<tbody>
	<tr>
		<td width="25%">Nama</td>
		<td width="2%">:</td>
		<td colspan="5"><?php echo $nama;?></td>
	</tr>
	<tr>
		<td>Jenis Kelamin</td>
		<td>:</td>
		<td colspan="5"><?php echo $jenis_kelamin;?></td>
	</tr>
	<tr>
		<td>Umur</td>
		<td>:</td>
		<td colspan="5"><?php echo $umur;?> Tahun</td>
	</tr>
	<tr>
		<td>Pekerjaan</td>
		<td>:</td>
		<td colspan="5"><?php echo $pekerjaan;?></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>:</td>
		<td colspan="5"><?php echo $alamat;?></td>
	</tr>
	<tr>
		<td colspan="8">Pada hari ini kami lakukan pemeriksaan terhadap orang tersebut diatas ternyata orang ini berbadan sehat dapat <?= $keperluan ?></td>
	</tr>
</tbody>
</table>
<p style="text-indent: 30px;margin-top:0"> Demikian surat keterangan ini kami buat dengan sebenarnya untuk dapat dipergunakan dimana perlunya. </p>

<p style="margin-bottom:5">Catatan :</p>
<table style="margin-right : 30px;margin-left : 30px">
<tbody>
<tr>
<td>Tinggi Badan</td>
<td>:</td>
<td><?php echo $tinggi_badan;?> cm</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>Berat Badan</td>
<td>:</td>
<td colspan="5"><?php echo $berat_badan;?> kg</td>
</tr>
<tr>
<td>Golongan Darah</td>
<td>:</td>
<td><?php echo $golongan_darah;?></td>
</tr>
<tr>
<td>Buta Warna</td>
<td>:</td>
<td><?php echo $buta_warna;?></td>
</tr>
</tbody>
</table>
<p style="text-align: right;margin-bottom:5"><?= getInfoRS('kabupaten') ?>, <?php echo $tgl_cetak;?></p>
<p style="text-align: right; margin-top:5;margin-bottom:70">Dokter yang memeriksa</p>
<p style="text-align: right;"><u> <?php echo $nama_dokter;?> </u></p>
  </section>

</body>

</html>
