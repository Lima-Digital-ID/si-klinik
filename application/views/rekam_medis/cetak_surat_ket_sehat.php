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
  <section class="sheet padding-10mm"">

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
<h3 style="text-align: center;"><span style="text-decoration: underline;">Surat Keterangan Sehat</span></h3>
<p>Dengan ini, saya menerangkan bahwa yang dibawah ini :</p>
<table>
<tbody>
<tr>
<td>Nama</td>
<td>:</td>
<td colspan="5"><?php echo $nama;?></td>
</tr>
<tr>
<td>Umur</td>
<td>:</td>
<td colspan="5"><?php echo $umur;?> Tahun</td>
</tr>
<tr>
<td>Jenis Kelamin</td>
<td>:</td>
<td colspan="5"><?php echo $jenis_kelamin;?></td>
</tr>
<tr>
<td>Tinggi Badan</td>
<td>:</td>
<td><?php echo $tinggi_badan;?> cm</td>
<td>&nbsp;</td>
<td>Tekanan Darah</td>
<td>:</td>
<td><?php echo $tekanan_darah;?> mmHg</td>
</tr>
<tr>
<td>Berat Badan</td>
<td>:</td>
<td colspan="5"><?php echo $berat_badan;?> kg</td>
</tr>
<tr>
<td>Alamat</td>
<td>:</td>
<td colspan="5"><?php echo $alamat;?></td>
</tr>
<tr>
<td>Keperluan</td>
<td>:</td>
<td colspan="5"><?php echo $keperluan;?></td>
</tr>
</tbody>
</table>
<p>Secara General saat ini dalam keadaan sehat.</p>
<p>Demikian surat keterangan ini dibuat dengan sebenar-benarnya. Atas perhatiaannya saya ucapkan Terima Kasih.</p>
<p style="text-align: right;">Malang, <?php echo $tgl_cetak;?></p>
<p style="text-align: right;">&nbsp;</p>
<p style="text-align: right;">( <?php echo $nama_dokter;?> )</p>

  </section>

</body>

</html>
