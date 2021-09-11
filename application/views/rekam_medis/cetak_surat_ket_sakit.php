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
	.header img {
	  float: left;
	  width: 100px;
	  height: 100px;
	}

	.header h2 {
	  position: relative;
	  top: 15px;
	  left: 20px;
	  font-size: 20px;
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
  <section class="sheet padding-10mm">

    <!-- Write HTML just like a web page -->
    <!--<article>This is an A5 document.</article>-->
    <div class="header">
	  <img src="<?php echo base_url()?>assets\images/logo_mitra_sehat_keluarga.png" alt="logo" />
	  <h2 style="text-align: left;"><span style="color: #ff0000;">MITRA SEHAT KELUARGA</span>
		<br />
		PRAKTEK DOKTER UMUM
		<br />
		<span style="font-size:12px;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</span>
	  </h2>
	  <!--<h4 style="text-align: left;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</h4>-->
	</div>
<br />
<hr />
<h3 style="text-align: center;"><span style="text-decoration: underline;">Surat Keterangan Sakit</span></h3>
<p><span style="font-style: inherit; font-weight: inherit;">Kepada Yth.&nbsp;<br /> <strong><?php echo $tujuan_surat;?></strong>&nbsp;<br /> di Tempat</span></p>
<p>Yang bertanda tangan dibawah ini menerangkan bahwa :<br /> Nama : <strong><?php echo $nama_pasien;?></strong><br /> Pekerjaan : <strong><?php echo $pekerjaan;?></strong><br /> Alamat : <strong><?php echo $alamat;?></strong></p>
<p>Berdasarkan hasil pemeriksaan yang telah dilakukan, pasien tersebut dalam keadaan sakit, sehingga perlu beristirahat selama <strong><?php echo $lama_istirahat;?></strong> hari, dari tanggal <strong><?php echo $tgl_periksa;?></strong> s/d <strong><?php echo $tgl_periksa2;?></strong></p>
<p>Diagnosa : <strong><?php echo $diagnosa;?></strong></p>
<p>Demikian surat keterangan ini diberikan, untuk diketahui dan dipergunakan sebagaimana mestinya</p>
<div align="right">
<p>Malang, <?php echo $tgl_cetak;?><br /> Dokter Pemeriksa,</p>
<br />
<p>( <strong><?php echo $dokter;?></strong> )</p>
</div>
  </section>

</body>

</html>
