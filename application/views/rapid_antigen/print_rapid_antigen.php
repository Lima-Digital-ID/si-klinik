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
  body{
      line-height : 1.3;
  }
	  .header{
		  display: flex;
		  position: relative;
	  }
	  .header img{
		  position: absolute;
		  width: 100px;
		  left : 0;
		  top : 0;
	  }
	  .header .right{
		  margin-top:15px;
		  width: 100%;
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

    <!-- Write HTML just like a web page -->
    <!--<article>This is an A5 document.</article>-->
	<div class="header">
    	<img src="<?php echo base_url()."assets/images/".getInfoRS('logo')?>" alt="logo" class="img-logo" />
        <div class="right">
            <center>
                <h2 style="margin-bottom:0;margin-top:0"><?= getInfoRS('nama_rumah_sakit') ?></h2>
                <p style="margin-bottom:0;margin-top:5px"><?= getInfoRS('alamat') ?></p>
                <p style="margin-bottom:0;margin-top:5px"><?= getInfoRS('no_telpon') ?></p>
                </center>
            </div>
        <!--<h4 style="text-align: left;">Ruko Atrani 24 - Sukorahayu - Wagir - Telp. (0341) 806305</h4>-->
        </div>
        <br>
        <hr />
        <center>
            <h4><b>HASIL PEMERIKSAAN RAPID ANTIGEN COVID-19</b></h4>
        </center>
        <table width="100%" border="1" cellspacing="0" cellpadding="3">
            <tr>
                <td colspan="3" bgcolor="#875774">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>DOKTER PEMERIKSA : <?= $detail->nama_dokter?></b>
                </td>
                <td width="25%" rowspan="2">
                    <?php 
                        $tgl = date('d M Y',strtotime($detail->tgl_pemeriksaan));
                        $waktu = date('H.i',strtotime($detail->tgl_pemeriksaan));
                    ?>
                    Tgl :  <?= $tgl ?>
                    <br>
                    Jam :  <?= $waktu ?> WITA
                </td>
            </tr>
            <tr>
                <td colspan="3">No. ID Sampel : <?=  $detail->no_sampel ?></td>
            </tr>
            <tr>
                <td colspan="3">
                    <table width="100%">
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td><?= $detail->nama ?></td>
                        </tr>
                        <tr>
                            <td width="18%">NIK / Passport</td>
                            <td width="2%">:</td>
                            <td><?= $detail->nik_or_passport?></td>
                        </tr>
                        <tr>
                            <td>Tgl Lahir</td>
                            <td>:</td>
                            <td><?= date("d/m/Y", strtotime($detail->tgl_lahir)) ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?= $detail->jenis_kelamin=='P' ? 'Perempuan' : 'Laki Laki' ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?= $detail->alamat_domisili ?></td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
            <tr bgcolor="#875774">
                <th>Paremeter Pemeriksaan</th>
                <th>Hasil</th>
                <th>Nilai Rujukan</th>
            </tr>
            <tr>
                <td>
                    <center><?= $detail->parameter_pemeriksaan ?></center>
                </td>
                <td>
                    <center><?= $detail->hasil ?></center>
                </td>
                <td>
                    <center><?= $detail->nilai_rujukan ?></center>
                </td>
            </tr>
            <tr>
                <td>Saran :</td>
                <td colspan="2"><?= $detail->saran  ?></td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <table width="100%">
            <tr>
                <td width="45%">
                    <img src="<?= base_url()."assets/images/qr_code/".$detail->qr_code ?>" width="60%" alt="" srcset="">
                </td>
                <td width="10%"></td>
                <td width="45%">
                    <table width="100%" border="1" cellspacing="0">
                        <tr>
                            <th bgcolor="#875774">Pemeriksa</th>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                <img src="<?= base_url()."assets/images/ttd.png" ?>" width="150px" alt="" srcset="">
                                <br>
                                    dr. Ni Nyoman Ermy Setiari, M.Kes
                                </center>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </section>
</body>
</html>
