<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
    
                    <div class="box-header">
                        <h3 class="box-title">GAJI PEGAWAI</h3>
                    </div>
        
        <div class="box-body">
        <div style="padding-bottom: 10px;">
        <div class="form-inline">
            <div class="col-sm-6">
                <div class="row">
                <form action="<?=site_url('hrms/gaji/cetak_slip')?>" method="post" target="_blank">
                    <input type="hidden" value="<?=$gaji[0]->id_pegawai?>" name="id_pegawai">
                    <?php
                    if (isset($_POST['bulan'])) {
                        
                    ?>
                    <input type="hidden" value="<?=$_POST['bulan']?>" name="bulan">
                    <input type="hidden" value="<?=$_POST['tahun']?>" name="tahun">
                    <?php
                    }else{
                    ?>
                    <input type="hidden" value="<?=date('d')?>" name="bulan">
                    <input type="hidden" value="<?=date('Y')?>" name="tahun">
                    <?php
                    }
                    ?>
                    <button class="btn btn-info btn-sm"><i class="fa fa-wpforms"></i>Cetak Slip Gaji</button>
                <?php 
                // echo anchor(site_url('hrms/gaji/cetak_slip/').$gaji[0]->id_pegawai, '<i class="fa fa-wpforms" aria-hidden="true"></i> Cetak Slip Gaji', 'class="btn btn-info btn-sm"'); 
                $kehadiran=count($absensi);
                $total_kehadiran=$gaji[0]->uang_kehadiran * $kehadiran;
                $total_makan=$gaji[0]->uang_makan * $tepat_waktu;
                $total_transport=$gaji[0]->uang_transport * 25;
                $total_lembur=$gaji[0]->uang_lembur * $durasi_lembur;
                $potongan_telat=$gaji[0]->potongan_telat * $durasi_telat;
                $grand_total=($gaji[0]->gaji_pokok+$gaji[0]->tunjangan+$total_kehadiran+$total_transport+$total_makan+$total_lembur)-($potongan+$potongan+$cicilan+$kasbon);
                ?>
                </form>                    
                </div>
            </div>
            <div class="col-sm-6" align="right">
                <div class="row">
                <form accept="<?=current_url()?>" method="post">
                    <label>Tampilkan Gaji : </label>
                    <select class="form-control select2" name="bulan" required>
                        <option value="">--Pilih Bulan--</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                    <select class="form-control select2" name="tahun" required>
                        <option value="">--Pilih Tahun--</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                    </select>
                    <button class="btn btn-success"><i class="fa fa-search"></i></button>
                </form>
                </div>
            </div>
        </div>
            <br>
        </div>
        <br>
        <div class="col-sm-4">
            <div class="row">
                <table>
                <tr>
                    <td>Bulan</td>
                    <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                    <td><span id="date"></span></td>
                </tr>
                <tr>
                    <td>Nama Pegawai</td>
                    <td> &nbsp;&nbsp;: &nbsp;&nbsp;</td>
                    <td><?=$gaji[0]->nama_pegawai?></td>
                </tr>
                </table>
                <br>
            </div>
        </div>
        <div class="col-sm-8" align="right">
            <div class="row form-inline">
            <form action="<?=site_url('hrms/gaji/inputPotongan')?>" method="post">
            <label>Input Potongan : </label>
                <input class="form-control" name="potongan" id="jml_potongan" placeholder="Potongan Bpjs"  onkeyup="cekPotongan(this)">
                <input class="form-control" name="cicilan" id="jml_cicilan" placeholder="Cicilan"  onkeyup="cekCicilan(this)">
                <input class="form-control" name="kasbon" id="jml_kasbon" placeholder="Kasbon"  onkeyup="cekKasbon(this)">
                <input class="form-control" type="hidden" name="id_pegawai" value="<?=$gaji[0]->id_pegawai?>">
                <input class="form-control" type="hidden" name="bulan" value="<?=$bulan?>">
                <button class="btn btn-success">Input</button>
                <br>
            </div>
            </form>
        </div>
        <br>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th>Tipe</th>
                    <th class="text-right">Fee</th>
                    <th class="text-center">Kehadiran</th>
                    <th class="text-right">sub total</th>
                </tr>
                <tr>
                    <th>Gaji Pokok</th>
                    <td class="text-right">Rp. <span id="gaji_pokok"></span></td>
                    <td colspan="2" class="text-right">Rp. <span id="gaji_pokok1"></span></td>
                </tr>
                <tr>
                    <th>Uang Kehadiran</th>
                    <td class="text-right">Rp. <span id="uang_kehadiran"></span></td>
                    <td class="text-center"><?=$kehadiran?></td>
                    <td class="text-right">Rp. <span id="total_kehadiran"></span></td>
                </tr>
                <tr>
                    <th>Uang Makan</th>
                    <td class="text-right">Rp. <span id="uang_makan"></span></td>
                    <td class="text-center"><?=$tepat_waktu?></td>
                    <td class="text-right">Rp. <span id="total_makan"></span></td>
                </tr>
                <tr>
                    <th>Uang Transport</th>
                    <td class="text-right">Rp. <span id="uang_transport"></span></td>
                    <td class="text-center">25</td>
                    <td class="text-right">Rp. <span id="total_transport"></span></td>
                </tr>
                <tr>
                    <th>Uang Lembur</th>
                    <td class="text-right">Rp. <span id="uang_lembur"></span></td>
                    <td class="text-center"><?=$durasi_lembur?> Jam</td>
                    <td class="text-right">Rp. <span id="total_lembur"></span></td>
                </tr>
                <tr>
                    <th>Tunjangan</th>
                    <td class="text-right">Rp. <span id="tunjangan"></span></td>
                    <td colspan="2" class="text-right">Rp. <span id="tunjangan1"></span></td>
                </tr>
                <tr>
                    <th colspan="4" class="text-center">Potongan</th>
                </tr>
                <tr>
                    <th>Potongan Telat</th>
                    <td class="text-right">Rp. <span id="potongan_telat"></span></td>
                    <td class="text-center"><?=$durasi_telat?> Jam</td>
                    <td colspan="2" class="text-right">Rp. <span id="sum_potongan_telat"></td>
                </tr>
                <tr>
                    <th>Potongan BPJS</th>
                    <td class="text-right">Rp. <span id="potongan"></span></td>
                    <td colspan="2" class="text-right">Rp. <span id="potongan1"></span></td>
                </tr>
                <tr>
                    <th>Cicilan</th>
                    <td class="text-right">Rp. <span id="cicilan"></span></td>
                    <td colspan="2" class="text-right">Rp. <span id="sum_cicilan"></td>
                </tr>
                <tr>
                    <th>Kasbon</th>
                    <td class="text-right">Rp. <span id="kasbon"></span></td>
                    <td colspan="2" class="text-right">Rp. <span id="sum_kasbon"></span></td>
                </tr>
                <tr>
                    <th colspan="3" class="text-center">Total</th>
                    <th class="text-right">Rp. <span id="grand"></span></th>
                </tr>
            </thead>
	    
        </table>
        </div>
                    </div>
            </div>
            </div>
    </section>
</div>
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