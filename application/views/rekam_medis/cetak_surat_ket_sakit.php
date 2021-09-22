<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Surat Keterangan Sakit</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">-->

  <!-- Load paper.css for happy printing -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">-->
  
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/paper-css/paper.css">
  
  <style>
	  .body{
		  line-height: 1.3;
	  }
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
  <section class="sheet padding-10mm" style="padding-top:5mm">

    <!-- Write HTML just like a web page -->
    <!--<article>This is an A5 document.</article>-->
	<div class="header">
		<div class="left">
			<img src="<?php echo base_url()."assets/images/".getInfoRS('logo')?>" alt="logo" width="100" />
		</div>
	  <div class="right">
		  <center>
			  <h2><?= getInfoRS('nama_rumah_sakit') ?></h2>
			  <p><?= getInfoRS('alamat') ?></p>
			  <p><?= getInfoRS('no_telpon') ?></p>
			</center>
		</div>
	  <!--<h4 style="text-align: left;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</h4>-->
	</div>
	<br>
<hr />
<div style="display:inline-block;position:relative;left:50%;transform:translateX(-50%);-moz-transform:translateX(-50%);-webkit-transform:translateX(-50%)">
		<h3 style="margin-bottom : 0px;margin-top:0"><span style="text-decoration: underline;">SURAT KETERANGAN SAKIT</span></h3>
		<p style="margin-top : 5px;margin-bottom:0;text-align:center;letter-spacing:2px"><b>No. <?= $nomor ?></b></p>
	</div>
<div class="body">
	<p style="margin-bottom:0px" >Yang bertanda tangan dibawah ini, Dokter yang bertugas di <?= ucwords(strtolower(getInfoRS('nama_rumah_sakit'))) ?> menerangkan dengan sebenarnya, mengingat sumpah jabatan bahwa  : </p>
	<table style="margin-right : 30px;margin-left : 30px">
	  <tr>
		  <td>Nama</td>
		  <td>:</td>
		  <td><?php echo $nama_pasien;?></td>
	  </tr>
	  <tr>
		  <td>Umur</td>
		  <td>:</td>
		  <td><?php echo $umur;?> Tahun</td>
	  </tr>
	  <tr>
		  <td>Pekerjaan</td>
		  <td>:</td>
		  <td><?php echo $pekerjaan;?></td>
	  </tr>
	  <tr>
		  <td>Alamat</td>
		  <td>:</td>
		  <td><?php echo $alamat;?></td>
	  </tr>
	</table>
	<p style="margin-top:0px">Berdasarkan hasil pemeriksaan fisik memang benar yang bersangkutan diatas dalam keadaan sakit, dipandang perlu diberikan istirahat selama <?= $lama_istirahat ?> hari, terhitung mulai tanggal <?= $tgl_periksa ?> sd <?= $tgl_periksa2 ?> 
	<br>
Demikian surat keterangan sakit ini kami buat agar dapat dipergunakan dimana perlu.
</p>
<p style="text-align: right;margin-bottom:0"><?= getInfoRS('kabupaten') ?>, <?php echo $tgl_cetak;?></p>
<p style="text-align: right; margin-top:3px;margin-bottom:50px">Dokter yang memeriksa</p>
<p style="text-align: right;"><u> <?php echo $dokter;?> </u></p></div>
  </section>

</body>

</html>
