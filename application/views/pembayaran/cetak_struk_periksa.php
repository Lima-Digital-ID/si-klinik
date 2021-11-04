<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>STRUK</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">-->

  <!-- Load paper.css for happy printing -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">-->
  
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/paper-css/paper.css">
  
  <style>
	  .header, .header .left{
		  display: flex;
	  }
    .header .left{
      width:55%;
    }
	  .header .right{
		  width: 45%;
      padding-left:40px;
      padding-top:30px;
	  }
  </style>

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <!--<style>@page { size: A4 }</style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">
<!-- <body style="font-size:9px"> -->

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <!-- Write HTML just like a web page -->
    <!--<article>This is an A5 document.</article>-->
	<div class="header">
		<div class="left">
      <div class="img">
        <img src="<?php echo base_url()."assets/images/".getInfoRS('logo')?>" alt="logo" width="70" />
      </div>
      <div class="address" style="margin-left:15px">
          <h2 style="font-family:times-new-roman;margin-top:0;margin-bottom:0px"><?= getInfoRS('nama_rumah_sakit') ?></h2>
          <p style="margin-top:5px;margin-bottom:0px"><?= getInfoRS('alamat') ?></p>
          <p style="margin-top:5px;margin-bottom:0px"><?= getInfoRS('no_telpon') ?></p>
      </div>
		</div>
	  <div class="right">
      <table>
        <tr>
          <td>Number</td>
          <td>:</td>
          <td><u><?= $id_transaksi ?></u></td>
        </tr>
        <tr>
          <td>Date</td>
          <td>:</td>
          <td><u><?= date('d-m-Y') ?></u></td>
        </tr>
      </table>
		</div>
	  <!--<h4 style="text-align: left;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</h4>-->
	</div>
<br />
<hr />
<table width="100%" style="padding:0px 0px">
	<thead>
		<tr>
			<td align="left">Nomor : <?= $id_transaksi ?></td>
			<td align="right" style="text-align:left">Name : <?= $nama_pasien ?> </td>
		</tr>
		<tr>
			<td align="left">Tanggal : <?=date('d-m-Y')?></td>
			<td align="right" style="text-align:left">Sex : <?= $jk=='P' ? 'Perempuan' : 'Laki-Laki' ?></td>
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
        <th align="left">Item</th>
        <th align="right">Jumlah</th>
	</tr>
    <?php
            $total_transaksi = 0;
            $i = 1;
            foreach($transaksi_d as $data){
              if(strpos($data->deskripsi, 'Pembayaran Biaya Medis') === false){
                if($data->amount_transaksi > 0){
    ?>
                    <tr style="border-bottom:1px solid black; border-bottom:1px solid black">
                        <td align="left"><?php echo $data->deskripsi;?></td>
                        <td align="right">Rp.<?php echo $data->dc == 'd' ? number_format($data->amount_transaksi,2,',','.') : ($data->amount_transaksi != 0 ? '-'.number_format($data->amount_transaksi,2,',','.') : number_format(0,2,',','.'));?></td>
                    </tr>
                <?php 
                    $i++;
                }
                    if($data->dc == 'd')
                        $total_transaksi += $data->amount_transaksi;
                    else
                        $total_transaksi -= $data->amount_transaksi;
                }
            }
    ?>
	<tr style="border-bottom:1px solid black; border-bottom:1px solid black">
		<th align="left">Total</th>
		<th align="right">Rp. <?=number_format($total_transaksi, 0, '.', '.')?></th>
	</tr>
</table>
<br>
<table width="100%">
<thead>
	<tr>
		<td align="left"></td>
		<td align="right">Denpasar, <?php echo date('d-m-Y');?></td>
	</tr>
	<tr>
		<td align="left">Guest Signature<br><br><br><br><br></td>
		<td align="right">Attending Physician<br><br><br><br><br></td>
	</tr>
	<tr style="margin-top:20pxs">
		<td align="left">(...................)</td>
		<td align="right">(...................)</td>
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