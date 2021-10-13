`<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Surat Pemeriksaan LAB</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">-->

  <!-- Load paper.css for happy printing -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">-->
  
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/paper-css/paper.css">
  
  <style>
	  .header{
          position : relative;
          padding-top : 5mm;
          padding-bottom : 5mm;
	  }
      .header img{
          position : absolute;
          top : 50%;
          transform : translateY(-50%);
          -webkit-transform : translateY(-50%);
          left : 0;
      }
      #table-lab tr th,#table-lab tr td,#table-lab{
          border : 1px solid black;
      }
      #table-lab tr th:last-child,#table-lab tr td:last-child{
        border:none;
      }
      .table-diet td{
          border:none !important;
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
  <section class="sheet padding-10mm" style="padding-top:5mm">

    <!-- Write HTML just like a web page -->
    <!--<article>This is an A5 document.</article>-->
	<div class="header">
        <img src="<?php echo base_url()."assets/images/".getInfoRS('logo')?>" alt="logo" width="100" />
        <center>
            <h2 style="margin-bottom:0"><?= getInfoRS('nama_rumah_sakit') ?></h2>
            <p style="margin-top:5px;margin-bottom:0"><?= getInfoRS('alamat') ?></p>
            <p style="margin-top:5px"><?= getInfoRS('no_telpon') ?></p>
        </center>
	  <!--<h4 style="text-align: left;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</h4>-->
	</div>
    <hr />
	<div style="display:inline-block;position:relative;left:50%;transform:translateX(-50%);-moz-transform:translateX(-50%);-webkit-transform:translateX(-50%)">
		<h3 style="margin-bottom : 0px;margin-top:5">HASIL PEMERIKSAAN LAB</h3>
	</div>
    <table>
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?= $pasien->nama_lengkap ?></td>
      </tr>
      <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?= $umur ?></td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?= $pasien->alamat ?></td>
      </tr>
    </table>
    <br>
    <table width="100%" cellspacing="0px" cellpadding="5px" id="table-lab">
      <tr>
        <th>Tanggal</th>
        <th>Hasil</th>
        <th>Nilai Normal</th>
        <th style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black"></th>
      </tr>
      <?php 
        $count = count($lab);
        foreach($lab as $key => $data){
      ?>
        <tr>
            <?php 
                if($key==0){
            ?>
            <td rowspan="<?= $count ?>"><?= date('d-m-Y',strtotime($data->dtm_crt)) ?></td>
            <?php } ?>
            <td>
                <center>
                    <?= $data->item ?>
                    <br>
                    <?= $data->hasil ?>
                </center>
            </td>
            <td><?= $data->nilai_normal ?></td>
            <td style="padding-left:20px;border-right:1px solid black;border-left:1px solid black"><?= $data->diet ?></td>
        </tr>
      <?php } ?>
    </table>
</section>
</body>
</html>