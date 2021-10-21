<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cetak Struk</title>
  <style type="text/css">
  *{
        /* font-family : "Dot Matrix"; */
        font-size : 15px;
        color: black;
    }
  /* @media print and (width: 58mm) and (height: 80mm) { */
        /* @page {
          margin: 3cm;
        } */
  /* } */
  /* @page {
      size: 58mm 80mm;
      margin: 10%;
  } */
  body{
    width: 58mm;
    min-height: 80mm;
  }
  /* @media print { 
    body{ 
      width: 58mm;
      height: 80mm
    }
  } */
  </style>
  <link rel="shortcut icon" href="{{ asset('public/assets/img/icon2.png') }}" />
</head>
<body>
  <center>
    <p style="margin-bottom:0px">APOTIK</p>
    <p style="margin-bottom:0px;margin-top:0px">NADA FARMA</p>
    <p style="margin-bottom:0px;margin-top:0px">Tibuneneng</p>
    -------------------------------------------
    <?php echo $transaksi[0]->no_transaksi;?>
    <br>        
    -------------------------------------------
  </center>
<!--   <table width="100%">
    <tr>
      <td width="47.5%">
        <?= date('Y-m-d') ?>
        <br>
        <?= date('H:i:s') ?>
      </td>
      <td width="56%"></td>
      <td width="47.5%" align="right"><?= $transaksi[0]->atas_nama ?></td>
    </tr>
  </table>
  -------------------------------------------
 -->  <table width="100%">
    <?php
      $total_transaksi = 0;
      $i = 1;
      foreach($transaksi as $data){
        $total_transaksi+=($data->harga*$data->jumlah);
    ?>
    <tr>
      <td width="47.5%">
        <b><?= $data->nama_barang ?></b>
        <br>
        <?= $data->jumlah." x ".$data->harga ?>
      </td>
      <td width="5%"></td>
      <td width="47.5%" align="right">
        <br>
        Rp.<?php echo number_format(($data->harga*$data->jumlah),2,',','.')?>
      </td>
    </tr>
    <?php } 
        $diskon=$total_transaksi*(($getDiskon != null ? $getDiskon->diskon : 0) / 100);
    ?>
    <tr>
      <td colspan="3">------------------------------------------</td>
    </tr>
    <tr>
      <td width="47.5%">
        <b>Total</b>
      </td>
      <td width="5%"></td>
      <td width="47.5%" align="right">
        Rp. <?php echo number_format($total_transaksi,2,',','.');?>
      </td>
    </tr>    
    <tr>
      <td width="47.5%">
        <b>Diskon</b>
      </td>
      <td width="5%"></td>
      <td width="47.5%" align="right">
        Rp. <?php echo number_format($diskon,2,',','.');?>
      </td>
    </tr>    
    <tr>
      <td width="47.5%">
        <b>Grand Total</b>
      </td>
      <td width="5%"></td>
      <td width="47.5%" align="right">
        Rp. <?php echo number_format($total_transaksi-$diskon,2,',','.');?>
      </td>
    </tr>    
  </table>

</body>
<script>
 window.print();
</script>
</html>

