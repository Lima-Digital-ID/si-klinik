<div class="content-wrapper">

    <section class="content">
        <div class="box box-info box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT RETUR BARANG</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Nomor PO
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <?php echo form_dropdown('no_po',$po_option,'',array('id'=>'no_po','class'=>'form-control select2', 'required'=>'required', 'onchange'=>'cekPO()'));?>
                            <input type="hidden" class="form-control" name="id_inventory" id="id_inventory" readonly="" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Jenis Retur
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <?php echo form_dropdown('jenis_retur',array(''=>'Pilih Jenis Retur', '0'=>'Retur Barang', '1'=>'Retur Uang'),'',array('id'=>'jenis_retur','class'=>'form-control select2', 'required'=>'required'));?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Tanggal Retur
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="tgl_retur" id="tgl_retur" value="<?=date('Y-m-d')?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Nama Supplier
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="supplier" id="supplier" readonly="" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Apoteker
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="apoteker" id="apoteker" readonly="" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Jenis Pembayaran
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="jenis_pembayaran" id="jenis_pembayaran" readonly="" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Tanggal PO
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="tgl_po" id="tgl_po" readonly="" />
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-12">
                <div class="row">
                <div class="col-sm-6">
                <br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>
                                Jenis Retur
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <?php echo form_dropdown('jenis_retur',array(''=>'Pilih Jenis Retur', '0'=>'Retur Barang', '1'=>'Retur Uang'),'',array('id'=>'jenis_retur','class'=>'form-control select2', 'required'=>'required'));?>
                        </div>
                    </div>
                </div>
                </div>
                </div> -->
                <div class="col-sm-12">
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataPO" align="center">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah Tersedia</th>
                                <th width="100px">Harga Beli</th>
                                <th>Gudang</th>
                                <th>Lokasi</th>
                                <th>Jumlah Retur</th>
                                <th>Potongan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                </div>
                <div class="col-sm-12">
                <br>
                    <div class="row">
                        <div class="col-sm-9">
                        </div>
                        <div class="col-sm-3">
                            <label>
                                Grand Total 
                            </label>
                            <input type="text" class="form-control" name="totalharga" id="totalharga" readonly="" />
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-left:auto">
                    <div class="col-sm-9">
                <br>
                        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                        <a href="<?php echo site_url('jasa') ?>" class="btn btn-warning"><i class="fa fa-sign-out"></i> Kembali</a>
                    </div>
                </div>
                    <br>

                     
                </form>        
            </div>
</div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script type="text/javascript">
    var dataLength=0;
    var dataPO=[];
    function cekPO(){
        var id=($('#no_po').val() != '' ? $('#no_po').val() : 0);
        dataLength=0;
        dataPO=[];
        $('#dataPO td').remove();
        $.ajax({
            type: "GET",
            url: "<?=base_url('transaksi_apotek/get_detail_po/')?>"+id, //json get site
            dataType : 'json',
            success: function(response){
                arrData = response;
                dataPO=arrData;
                console.log(arrData);
                dataLength=arrData.length;
                if (arrData.length != 0) {    
                    $('#supplier').val(arrData[0]['nama_supplier']);
                    $('#apoteker').val(arrData[0]['nama_apoteker']);
                    $('#jenis_pembayaran').val((arrData[0]['jenis_pembayaran'] == 0 ? 'Cash' : 'Kredit'));
                    $('#tgl_po').val(arrData[0]['tanggal_po']);
                    $('#id_inventory').val(arrData[0]['id_inventory']);
                }else{
                    $('#supplier').val('');
                    $('#apoteker').val('');
                    $('#jenis_pembayaran').val('');
                    $('#tgl_po').val('');
                    $('#id_inventory').val('');
                }
                for(i = 0; i < arrData.length; i++){
                    console.log(arrData[i]['kode_barang']);
                    var table=   '<tr><td><input type="checkbox" id="check'+i+'" onclick="cekList()"></td>' + 
                        '<td>'+arrData[i]['kode_barang']+'</td>'+
                        '<td>'+arrData[i]['nama_barang']+
                        '<input type="hidden" class="form-control" name="id_inventory_detail[]" id="id_inventory_detail'+i+'" readonly/>'+
                        '<input type="hidden" class="form-control" name="kode_barang[]" id="kode'+i+'" readonly/>'+
                        '<input type="hidden" class="form-control" name="harga[]" id="harga'+i+'" readonly/>'+
                        '<input type="hidden" class="form-control" name="nama_gudang[]" id="gudang'+i+'" readonly/>'+
                        '<input type="hidden" class="form-control" name="lokasi[]" id="lokasi'+i+'" readonly/>'+
                        '<input type="hidden" class="form-control" name="tgl_exp[]" id="tgl_exp'+i+'" readonly/>'+
                        '</td>'+
                        '<td>'+arrData[i]['keterangan']+'</td>'+
                        '<td>'+arrData[i]['jumlah']+'</td>'+
                        '<td>Rp. '+formatRupiah(arrData[i]['harga'])+'</td>'+
                        '<td>'+arrData[i]['nama_gudang']+'</td>'+
                        '<td>'+arrData[i]['lokasi']+'</td>'+
                        '<td><input type="number" class="form-control" name="total_retur[]" id="retur'+i+'" onkeyup="cekTotal()" readonly/></td>'+
                        '<td><input type="number" class="form-control" name="diskon[]" id="diskon'+i+'" onkeyup="cekTotal()" readonly/></td></tr>'
                    $('#dataPO').append(table);
                }
            }
        });
        $('#totalharga').val(0);
    }

    function cekList(){
        for (var i = 0; i < dataLength; i++) {
            if($('#check'+i).is(':checked')){
                $('#id_inventory_detail'+i).val(arrData[i]['id_inventory_detail']);
                $('#kode'+i).val(arrData[i]['kode_barang']);
                $('#harga'+i).val(arrData[i]['harga']);
                $('#gudang'+i).val(arrData[i]['kode_gudang']);
                $('#lokasi'+i).val(arrData[i]['id_lokasi_barang']);
                $('#tgl_exp'+i).val(arrData[i]['tgl_exp']);
                $('#retur'+i).attr('readonly', false);
                $('#diskon'+i).attr('readonly', false);
            }else{
                $('#id_inventory_detail'+i).val('');
                $('#kode'+i).val('');
                $('#harga'+i).val('');
                $('#gudang'+i).val('');
                $('#lokasi'+i).val('');
                $('#tgl_exp'+i).val('');
                $('#retur'+i).val('');
                $('#diskon'+i).val('');
                $('#retur'+i).attr('readonly', true);
                $('#diskon'+i).attr('readonly', true);
            }
        };
        cekTotal();
    }
    function cekTotal(){
        var total=0;
        var subtotal=0;
        for (var i = 0; i < dataLength; i++) {
            var harga=($('#harga'+i).val() != '' ? $('#harga'+i).val() : 0);
            if (harga == 0) {
                $('#retur'+i).val('');
                $('#diskon'+i).val('');
            }
            var retur=($('#retur'+i).val() != '' ? $('#retur'+i).val() : 0);
            var diskon=($('#diskon'+i).val() != '' ? $('#diskon'+i).val() : 0);
            if (parseInt(retur) <= arrData[i]['jumlah']) {
                harga=harga - diskon;
                total=retur*harga;
                subtotal=subtotal+total;
            }else{
                $('#retur'+i).val('');
                alert('jumlah retur melebihi stok yang tersisa');
            }
        };
        $('#totalharga').val(subtotal);
    }
    function formatRupiah(angka, prefix)
      {
        var reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
      }
</script>