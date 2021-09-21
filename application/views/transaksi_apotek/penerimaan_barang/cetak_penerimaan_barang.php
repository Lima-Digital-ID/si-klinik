<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Surat Penerimaan Barang</title>

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
  <!--<style>@page { size: A4 }</style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4" onload="window.print()">
<!-- <body style="font-size:9px"> -->

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

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
<br />
<hr />
<h3 style="text-align: center;"><span style="text-decoration: underline;">Surat Penerimaan Barang</span></h3>
<table width="100%" style="padding:0px 0px">
	<thead>
		<tr>
			<td align="left">Nomor : <?=$data[0]->id_inventory?></td>
			<td align="right" style="text-align:left">Nomor PO : <?=$data[0]->kode_purchase?> </td>
		</tr>
		<tr>
			<td align="left">Tanggal : <?=date('d-m-Y')?></td>
			<td align="right" style="text-align:left">Tanggal PO : <?php $date=date_create($data[0]->tanggal_po); echo date_format($date,"d-m-Y")?></td>
		</tr>
		<tr>
			<td align="left">Supplier : <?=$data[0]->nama_supplier?></td>
			<td align="right"></td>
		</tr>
	</thead>
</table>
<br>
<style type="text/css">
	/*#table th, td{
		border-bottom:1px solid black; 
		border-bottom:1px solid black
	}*/
</style>
<table style="border-collapse:collapse; text-align:center;" width="100%">
	<tr style="border-bottom:1px solid black; border-bottom:1px solid black">
	<th align="left">Kode Barang</th>
	<th>Nama Barang</th>
	<th>QTY</th>
	<th align="right">Harga</th>
	<th align="right">Subtotal</th>
	</tr>
		<?php
		$jumlah=0;
            foreach ($data as $key => $value) {
            $total=0;
            $harga=$value->harga - $value->diskon;
            $total=$value->jumlah * $harga;
        ?>
	<tr style="border-bottom:1px solid black; border-bottom:1px solid black">
        <td align="left"><?=$value->kode_barang?></td>
        <td><?=$value->nama_barang?></td>
        <td><?=$value->jumlah?></td>
        <td align="right">Rp. <?=number_format($value->harga, 0, '.', '.')?></td>
        <td align="right">Rp. <?=number_format($total, 0, '.', '.')?></td>
	</tr>
        <?php
        	$jumlah+=$total;
            }
        ?>
	<tr style="border-bottom:1px solid black; border-bottom:1px solid black">
		<th colspan="4">Jumlah</th>
		<th align="right">Rp. <?=number_format($jumlah, 0, '.', '.')?></th>
	</tr>
</table>
<!-- <p><span style="font-style: inherit; font-weight: inherit;">Kepada Yth.&nbsp;<br /> <strong><?php echo $tujuan_surat;?></strong>&nbsp;<br /> di Tempat</span></p>
<p>Yang bertanda tangan dibawah ini menerangkan bahwa :<br /> Nama : <strong><?php echo $nama_pasien;?></strong><br /> Pekerjaan : <strong><?php echo $pekerjaan;?></strong><br /> Alamat : <strong><?php echo $alamat;?></strong></p>
<p>Berdasarkan hasil pemeriksaan yang telah dilakukan, pasien tersebut dalam keadaan sakit, sehingga perlu beristirahat selama <strong><?php echo $lama_istirahat;?></strong> hari, dari tanggal <strong><?php echo $tgl_periksa;?></strong> s/d <strong><?php echo $tgl_periksa2;?></strong></p>
<p>Diagnosa : <strong><?php echo $diagnosa;?></strong></p>-->
<!-- <p>Demikian surat keterangan ini diberikan, untuk diketahui dan dipergunakan sebagaimana mestinya</p> -->
<!-- <div align="right">
<p>Surabaya, <?php echo date('d-m-Y');?></p>
</div> -->
<br>
<table width="100%">
<thead>
	<tr>
		<td align="left"></td>
		<td align="right">Surabaya, <?php echo date('d-m-Y');?></td>
	</tr>
	<tr>
		<td align="left">Pengirim<br><br><br><br></td>
		<td align="right">Apoteker,<br><br><br><br></td>
	</tr>
	<tr style="margin-top:20pxs">
		<td align="left"><p>( <?=$data[0]->pengirim?> )</p></td>
		<td align="right"><p>( <?=$data[0]->nama_apoteker?> )</p></td>
	</tr>
</thead>
</table>
  </section>

</body>

</html>
<script type="text/javascript">
     window.print();
// window.onmousemove = function() {
//   window.close();
// }
  </script>