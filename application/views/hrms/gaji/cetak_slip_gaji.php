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
  <style>@page { size: A4 }</style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<!-- <body class="A5 landscape" onload="window.print()"> -->
<!-- <body class="A4" onload="window.print()"> -->
<body class="A4 landscape" onload="window.print()">
<?php 
$kehadiran=count($absensi);
$total_kehadiran=$gaji[0]->uang_kehadiran * $kehadiran;
$total_makan=$gaji[0]->uang_makan * $tepat_waktu;
$total_transport=$gaji[0]->uang_transport * 25;
$total_lembur=$gaji[0]->uang_lembur * $durasi_lembur;
$potongan_telat=$gaji[0]->potongan_telat * $durasi_telat;
$grand_total=($gaji[0]->gaji_pokok+$gaji[0]->tunjangan+$total_kehadiran+$total_transport+$total_makan+$total_lembur)-($potongan+$potongan+$cicilan+$kasbon);
$total_pendapatan=($gaji[0]->gaji_pokok+$gaji[0]->tunjangan+$total_kehadiran+$total_transport+$total_makan+$total_lembur);
$total_potongan=($potongan+$potongan+$cicilan+$kasbon);
?>
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">
<?php
    function bulan($date){
        $bulan = ['Jan', 'Feb', 'Mar','Apr','Mei','Juni','Juli','Agust','Sept','Okt','Nov','Des'];
        return $bulan[$date-1];
    }
    function formatCurrency($val){
        return number_format($val, 0, '.', '.');
    }
?>

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
<h3 style="text-align: center;"><span style="text-decoration: underline;">Slip Gaji</span></h3>
<table width="100%" style="padding:0px 0px">
	<thead>
        <tr>
            <td>Nama Pegawai</td>
            <td>:</td>
            <td><?=$gaji[0]->nama_pegawai?></td>
            <td width="50px"></td>
            <td>Nomor Telepon/HP</td>
            <td>:</td>
            <td><?=$gaji[0]->no_hp?></td>
        </tr>
		<tr>
            <td>Jabatan</td>
            <td>:</td>
            <td><?=$gaji[0]->nama_jabatan?></td>
            <td width="50px"></td>
            <td>Bulan</td>
            <td>:</td>
            <td><span id="date"></span></td>
        </tr>
	</thead>
</table>
<br>
<style>
#table {
  border-collapse: collapse;
  width: 100%;
}

#table_th{
  padding-bottom: 5px;
  padding-top: 5px;
  /*text-align: left;*/
  border-bottom: 1px solid #000;
}
#tbl_padding{
  padding-top: 8px;
}
</style>
<table id="table">
    <thead style="border-top: 1px solid #000">
        <tr>
            <th colspan="6" align="left" id="table_th">Pendapatan</th>
            <th width="30px" id="table_th"></th>
            <th colspan="6" align="left" id="table_th">Potongan</th>
        </tr>
        <tr>
            <th id="table_th" align="left">Tipe</th>
            <th id="table_th" colspan="2">Fee</th>
            <th id="table_th">Kehadiran</th>
            <th id="table_th" align="right" colspan="2">Sub total</th>
            <th id="table_th"></th>
            <th id="table_th" align="left">Tipe</th>
            <th id="table_th" colspan="2">Fee</th>
            <th id="table_th">Kehadiran</th>
            <th id="table_th" colspan="2" align="right">Sub total</th>
        </tr>
        <tr>
            <th align="left" id="tbl_padding">Gaji Pokok</th>
            <td id="tbl_padding">Rp. </td>
            <td id="tbl_padding" align="right"><span id="gaji_pokok"></span></td>
            <td id="tbl_padding"></td>
            <td id="tbl_padding" align="right">Rp. </td>
            <td id="tbl_padding" align="right"><span id="gaji_pokok1"></span></td>
            <th id="tbl_padding"></th>
            <th id="tbl_padding" align="left">Potongan Telat</th>
            <td id="tbl_padding">Rp. </td>
            <td id="tbl_padding" align="right"><span id="potongan_telat"></span></td>
            <td id="tbl_padding" align="center">x <?=$durasi_telat?> Jam</td>
            <td id="tbl_padding" align="right">Rp. </td>
            <td id="tbl_padding" align="right"><span id="sum_potongan_telat"></td>
        </tr>
        <tr>
            <th align="left">Uang Kehadiran</th>
            <td>Rp. </td>
            <td align="right"><span id="uang_kehadiran"></span></td>
            <td align="center">x <?=$kehadiran?> hari</td>
            <td align="right">Rp. </td>
            <td align="right"><span id="total_kehadiran"></span></td>
            <td></td>
            <th align="left">Potongan BPJS</th>
            <td>Rp. </td>
            <td align="right"><span id="potongan"></span></td>
            <td></td>
            <td align="right">Rp. </td>
            <td align="right"><span id="potongan1"></span></td>
        </tr>
        <tr>
            <th align="left">Uang Makan</th>
            <td>Rp. </td>
            <td align="right"><span id="uang_makan"></span></td>
            <td align="center">x <?=$tepat_waktu?> hari</td>
            <td align="right">Rp. </td>
            <td align="right"><span id="total_makan"></span></td>
            <th></th>
            <th align="left">Cicilan</th>
            <td>Rp. </td>
            <td align="right"><span id="cicilan"></span></td>
            <td></td>
            <td align="right">Rp. </td>
            <td align="right"><span id="sum_cicilan"></td>
        </tr>
        <tr>
            <th align="left">Uang Transport</th>
            <td>Rp. </td>
            <td align="right"><span id="uang_transport"></span></td>
            <td align="center">x 25 hari</td>
            <td align="right">Rp. </td>
            <td align="right"><span id="total_transport"></span></td>
            <th></th>
            <th align="left">Kasbon</th>
            <td>Rp. </td>
            <td align="right"><span id="kasbon"></span></td>
            <td></td>
            <td align="right">Rp. </td>
            <td align="right"><span id="sum_kasbon"></span></td>
        </tr>
        <tr>
            <th align="left">Uang Lembur</th>
            <td>Rp. </td>
            <td align="right"><span id="uang_lembur"></span></td>
            <td align="center">x <?=$durasi_lembur?> Jam</td>
            <td align="right">Rp. </td>
            <td align="right"><span id="total_lembur"></span></td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <th align="left" style="border-bottom: 1px solid #000; padding-bottom:10px">Tunjangan</th>
            <td style="border-bottom: 1px solid #000; padding-bottom:10px">Rp. </td>
            <td align="right" style="border-bottom: 1px solid #000; padding-bottom:10px"><span id="tunjangan"></span></td>
            <th style="border-bottom: 1px solid #000; padding-bottom:10px"></th>
            <td style="border-bottom: 1px solid #000; padding-bottom:10px" align="right">Rp. </td>
            <td align="right" style="border-bottom: 1px solid #000; padding-bottom:10px"><span id="tunjangan1"></span></td>
            <th style="border-bottom: 2px solid #fff"></th>
            <th style="border-bottom: 1px solid #000; padding-bottom:10px" colspan="6"></th>
        </tr>
        <tr>
            <th colspan="5" align="left" id="table_th">Total Pendapatan</th>
            <th align="right">Rp. <?=formatCurrency($total_pendapatan)?></th>
            <th style="border-bottom: 2px solid #fff">-</th>
            <th colspan="5" align="left" id="table_th">Total Potongan</th>
            <th align="right" id="table_th">Rp. <?=formatCurrency($total_potongan)?></th>
        </tr>
        <tr>
            <th colspan="12" align="left" id="table_th">Gaji Bersih</th>
            <th align="right" id="table_th">Rp. <span id="grand"></span></th>
        </tr>
    </thead>
</table>
<table id="table">
	<thead>
		
	</thead>
</table>
<br>
<table width="100%">
<thead>
	<tr>
		<td align="left"></td>
		<td align="right">Surabaya, <?php echo date('d-m-Y');?></td>
	</tr>
	<tr>
		<td align="left">Penerima<br><br><br><br></td>
		<td align="right"><br><br><br><br><br></td>
	</tr>
	<tr style="margin-top:20pxs">
		<td align="left"><p>( <?=$gaji[0]->nama_pegawai?> )</p></td>
		<td align="right"><p>( Mitra Sehat Keluarga )</p></td>
	</tr>
</thead>
</table>
  </section>

</body>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var a='<?=$bulan?>';
        var str=a.split('-');
        $('#date').html(getMonth(str[1])+' '+str[0]);
        $('#gaji_pokok').html(formatRupiah(<?=$gaji[0]->gaji_pokok?>));
        $('#gaji_pokok1').html(formatRupiah(<?=$gaji[0]->gaji_pokok?>));
        $('#uang_kehadiran').html(formatRupiah(<?=$gaji[0]->uang_kehadiran?>));
        $('#uang_makan').html(formatRupiah(<?=$gaji[0]->uang_makan?>));
        $('#uang_transport').html(formatRupiah(<?=$gaji[0]->uang_transport?>));
        $('#uang_lembur').html(formatRupiah(<?=$gaji[0]->uang_lembur?>));
        $('#tunjangan').html(formatRupiah(<?=$gaji[0]->tunjangan?>));
        $('#total_kehadiran').html(formatRupiah(<?=$total_kehadiran?>));
        $('#total_makan').html(formatRupiah(<?=$total_makan?>));
        $('#total_transport').html(formatRupiah(<?=$total_transport?>));
        $('#total_lembur').html(formatRupiah(<?=$total_lembur?>));
        $('#tunjangan1').html(formatRupiah(<?=$gaji[0]->tunjangan?>));
        $('#potongan_telat').html(formatRupiah(<?=$gaji[0]->potongan_telat ?>));
        $('#sum_potongan_telat').html(formatRupiah(<?=$potongan_telat ?>));
        $('#potongan').html(formatRupiah(<?=$potongan?>));
        $('#potongan1').html(formatRupiah(<?=$potongan?>));
        $('#cicilan').html(formatRupiah(<?=$cicilan?>));
        $('#sum_cicilan').html(formatRupiah(<?=$cicilan?>));
        $('#kasbon').html(formatRupiah(<?=$kasbon?>));
        $('#sum_kasbon').html(formatRupiah(<?=$kasbon?>));
        $('#grand').html(formatRupiah(<?=$grand_total?>));

    });
    function formatRupiah(angka, prefix)
    {
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }
    function getMonth(month){
        var bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return bulan[month-1];
    }
    function cekPotongan(val){
        $('#jml_potongan').val(formatCurrency(val.value));
    }
    function cekCicilan(val){
        $('#jml_cicilan').val(formatCurrency(val.value));
    }
    function cekKasbon(val){
        $('#jml_kasbon').val(formatCurrency(val.value));
    }
    function formatCurrency(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split = number_string.split(','),
          sisa  = split[0].length % 3,
          rupiah  = split[0].substr(0, sisa),
          ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
          
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
</html>
