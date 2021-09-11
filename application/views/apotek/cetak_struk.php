<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Kwitansi Pembayaran</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">-->

  <!-- Load paper.css for happy printing -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">-->
   <!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/paper-css/paper.css"> -->
  
  <style>
	.header img {
	  margin-top: -10px;
	  float: left;
	  width: 50px;
	  height: 50px;
	}

	.header h2 {
	  position: relative;
	  top: -5px;
	  left: 5px;
	  font-size: 10px;
	}
  @media print {
    /* style sheet for print goes here */
    .noprint {
      visibility: hidden;
    }
  }
  </style>

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <!--<style>
  @page { size: A5 landscape }
  </style>-->

</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<!-- <body class="A5 landscape" onload="window.print()"> -->
<body style="font-size:10px; padding-right:10px; padding-left:-10px">
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <div class="header" style="background:#fffff;">
	  <img src="<?php echo base_url()?>assets\images/logo_mitra_sehat_keluarga.png" alt="logo" />
	  <h2 style="text-align: left;">MITRA SEHAT KELUARGA - PRAKTEK DOKTER UMUM
		<br />
		<span style="font-size:10px;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</span>
	  </h2>
	  <!--<h4 style="text-align: left;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</h4>-->
	</div>
<div>
<hr />
<h3 style="text-align: center;"><span style="text-decoration: underline;">KWITANSI PEMBAYARAN</span></h3>
<p>
    Nama Pasien : <?php echo $transaksi[0]->atas_nama;?><br />
    No Transaksi : <?php echo $transaksi[0]->no_transaksi;?></p>
<h3 style="text-align: center;">RINCIAN PEMBAYARAN</h3>
<table>
<?php
$total_transaksi = 0;
$i = 1;
foreach($transaksi as $data){
?>
<tr>
<td><?php echo $i;?></td>
<td><?php echo $data->nama_barang;?></td>
<td align="right">Rp</td>
<td align="right"><?php echo number_format($data->harga,2,',','.');?></td>
</tr>
<?php 
$total_transaksi+=$data->harga;
$i++;
}
?>
<tr>
    <td width="85%" colspan="2" align="center"><b>Total Transaksi</b></td>
    <td width="10%" align="right"><b>Rp</b></td>
    <td width="35%" align="right"><b><?php echo number_format($total_transaksi,2,',','.');?></b></td>
</tr>
</table>
<p style="text-align: right;">Malang, <?php echo date('d-m-Y');?></p>
<!--<br />-->
<p style="text-align: right;">( <?php echo $petugas; ?> )</p>
</div>
  </section>
<a href="<?=base_url('apotek')?>" class="noprint"><button>kembali</button></a>
</body>
<script type="text/javascript">
    window.print();
    // window.onmousemove = function() {
    //   window.location= '<?=base_url("apotek")?>'
    // }  

</script>
</html>

