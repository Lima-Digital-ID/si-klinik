<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Kwitansi Pembayaran</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">-->

  <!-- Load paper.css for happy printing -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">-->
   <link rel="stylesheet" href="<?php echo base_url() ?>assets/paper-css/paper.css">
  
  <style>
	  body{
      font-family : "Arial";
	  }
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
  <!--<style>
  @page { size: A5 landscape }
  </style>-->
  <style>@page { size: A5 }</style>

</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<!-- <body class="A5 landscape" onload="window.print()"> -->
<body class="A5 landscape" onload="window.print()">
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

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
<h3 style="text-align: center;margin-bottom:0px"><span style="text-decoration: underline;"><i>BILL</i></span></h3>
<center>
    <table width="90%">
      <tr>
        <td width="50%">
          <h3 style="margin-bottom:5px"><u>IDENTITY</u></h3>
          <table>
            <tr>
              <td>Name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
              <td>:</td>
              <td><?= $nama_pasien ?></td>
            </tr>
            <tr>
              <td>Age</td>
              <td>:</td>
              <td><?= $umur ?></td>
            </tr>
            <tr>
              <td>Address</td>
              <td>:</td>
              <td><?= $alamat ?></td>
            </tr>
          </table>
        </td>
        <td width="5%"></td>
        <td width="45%">
        <table style="margin-top:30px">
            <tr>
              <td>Sex &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
              <td>:</td>
              <td><?= $jk=='P' ? 'Perempuan' : 'Laki-Laki' ?></td>
            </tr>
            <tr>
              <td>Nationality</td>
              <td>:</td>
              <td>.....</td>
            </tr>
            <tr>
              <td>Room Number</td>
              <td>:</td>
              <td>.....</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
</center>
<center>
  <table width="90%">
    <tr>
      <td width="45%">
        <h3 style="margin-bottom:5px"><u>FOR PAYMENT</u></h3>
          <table width="100%">
            <?php
            $total_transaksi = 0;
            $i = 1;
            foreach($transaksi_d as $data){
              if(strpos($data->deskripsi, 'Pembayaran Biaya Medis') === false){
                if($data->amount_transaksi > 0){
                  ?>
            <tr>
            <td><?php echo $data->deskripsi;?></td>
            <td>:</td>
            <td>Rp.<?php echo $data->dc == 'd' ? number_format($data->amount_transaksi,2,',','.') : ($data->amount_transaksi != 0 ? '-'.number_format($data->amount_transaksi,2,',','.') : number_format(0,2,',','.'));?></td>
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
            <tr>
              <td colspan="3"><hr></td>
            </tr>
            <tr>
                <td width="85%"><b>Amount</b></td>
                <td width="10%"><b>Rp</b></td>
                <td width="35%"><b><?php echo number_format($total_transaksi,2,',','.');?></b></td>
            </tr>
          </table>
      </td>
      <td width="10%"></td>
      <td width="45%">
        <table width="100%">
          <tr>
            <td><span style="margin-left:50px"></span> Denpasar, <?php echo $tgl_cetak;?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>
</center>
<div style="width:55%;margin-left:auto">
  <span>(Guest Signature)</span>
  <span style="margin-left:70px">(Attending Physician)</span>
</div>
</div>
  </section>

</body>

</html>

