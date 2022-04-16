<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info box-solid">
                    <div class="box-header">
                        <h3 class="box-title">REKAPITULASI HARIAN</h3>
                    </div>
                    <div class="box-body">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Dari Tanggal</label>
                                    <input type="date" name="dari" value="<?= isset($_GET['dari']) ? $_GET['dari'] : '' ?>" class="form-control" id="">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Sampai Tanggal</label>
                                    <input type="date" name="sampai" value="<?= isset($_GET['sampai']) ? $_GET['sampai'] : '' ?>" class="form-control" id="">
                                </div>
                                <div class="col-md-6">
                                    <br>
                                    <button class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                                    <button type="reset" class="btn btn-default"><i class="fa fa-cancel"></i> Reset</button>
                                </div>
                            </div>
                        </form>
                        <?php if(isset($_GET['dari']) && isset($_GET['sampai'])){?>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr style="background : #3c8dbc;color : white">
                                        <td>Akun</td>
                                        <td>Saldo Awal</td>
                                        <td>Masuk</td>
                                        <td>Keluar</td>
                                        <td>Saldo Akhir</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Bank</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <?php 
                                        foreach ($bank as $key => $value) {
                                            $saldoAwal = $this->Akuntansi_model->rekap_saldo_awal($value->id_akun,$_GET['dari'],$_GET['sampai']);
                                            $masuk = $this->Akuntansi_model->saldo_harian_bank('DEBIT',$value->id_akun,$_GET['dari'],$_GET['sampai']);
                                            $keluar = $this->Akuntansi_model->saldo_harian_bank('KREDIT',$value->id_akun,$_GET['dari'],$_GET['sampai']);
                                            $saldoAkhir = $saldoAwal + $masuk->jumlah - $keluar->jumlah;
                                            ?>
                                    <tr>
                                        <td style="padding-left:20px">-<?= $value->nama_akun ?></td>
                                        <td>Rp <?= number_format($saldoAwal,0,',','.') ?></td>
                                        <td>Rp <?= number_format($masuk->jumlah,0,',','.') ?></td>
                                        <td>Rp <?= number_format($keluar->jumlah,0,',','.') ?></td>
                                        <td>Rp <?= number_format($saldoAkhir,0,',','.') ?></td>
                                    </tr>
                                    <?php } 
                                        $saldoAwalKas = $this->Akuntansi_model->rekap_saldo_awal(20,$_GET['dari'],$_GET['sampai'],$isKas=true);
                                        $kasMasuk = $this->Akuntansi_model->saldo_harian_bank('DEBIT',20,$_GET['dari'],$_GET['sampai'],false,true);
                                        $kasKeluar = $this->Akuntansi_model->saldo_harian_bank('KREDIT',20,$_GET['dari'],$_GET['sampai'],false,true);
                                        $saldoAkhirKas = $saldoAwalKas + $kasMasuk->jumlah - $kasKeluar->jumlah;

                                        $saldoAwalCek = $this->Akuntansi_model->rekap_saldo_awal(137,$_GET['dari'],$_GET['sampai'],$isKas=true);
                                        $cekMasuk = $this->Akuntansi_model->saldo_harian_bank('DEBIT',137,$_GET['dari'],$_GET['sampai'],false,true);
                                        $cekKeluar = $this->Akuntansi_model->saldo_harian_bank('KREDIT',137,$_GET['dari'],$_GET['sampai'],false,true);
                                        $saldoAkhirCek = $saldoAwalCek + $cekMasuk->jumlah - $cekKeluar->jumlah;
                                    ?>
                                    <tr>
                                        <td>Kas</td>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:20px">-Cek</td>
                                        <td>Rp <?= number_format($saldoAwalCek,0,',','.') ?></td>
                                        <td>Rp <?= number_format($cekMasuk->jumlah,0,',','.') ?></td>
                                        <td>Rp <?= number_format($cekKeluar->jumlah,0,',','.') ?></td>
                                        <td>Rp <?= number_format($saldoAkhirCek,0,',','.') ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:20px">-Tunai</td>
                                        <td>Rp <?= number_format($saldoAwalKas,0,',','.') ?></td>
                                        <td>Rp <?= number_format($kasMasuk->jumlah,0,',','.') ?></td>
                                        <td>Rp <?= number_format($kasKeluar->jumlah,0,',','.') ?></td>
                                        <td>Rp <?= number_format($saldoAkhirKas,0,',','.') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr style="background : #3c8dbc;color : white">
                                        <td>Akun</td>
                                        <td>Jumlah</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Pembelian</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:20px">-Obat</td>
                                        <td>Rp <?= number_format($obat->jumlah,0,',','.') ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:20px">-BHP</td>
                                        <td>Rp <?= number_format($bhp->jumlah,0,',','.') ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pendapatan</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:20px">-Pemeriksaan</td>
                                        <td>Rp <?= number_format($pemeriksaan->jumlah,0,',','.') ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:20px">-Tindakan</td>
                                        <td>Rp <?= number_format($tindakan->jumlah,0,',','.') ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:20px">-Penjualan Obat</td>
                                        <td>Rp <?= number_format($penjualan_obat->jumlah,0,',','.') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
