<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi_apotek extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Transaksi_obat_model');
        $this->load->model('akuntansi/Transaksi_akuntansi_model');
        $this->load->model('Tbl_supplier_model');
        $this->load->model('Tbl_apoteker_model');
        $this->load->model('Tbl_gudang_model');
        $this->load->model('Tbl_lokasi_barang_model');
        $this->load->model('Tbl_obat_alkes_bhp_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->id_klinik = $this->session->userdata('id_klinik');
    }

    public function index()
    {
        redirect('transaksi_apotek/po');
    }
    public function po(){
        $this->template->load('template','transaksi_apotek/purchase_order/purchase_order_list');
    }
    public function json_po(){
        header('Content-Type: application/json');
        echo $this->Transaksi_obat_model->json($this->id_klinik);
    }
    public function json_detail_po($id){
        header('Content-Type: application/json');
        echo json_encode($this->Transaksi_obat_model->json_detail_po($id));
    }

    public function create_po() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('transaksi_apotek/save_po'),
            'kode_transaksi_apotek' => set_value('kode_transaksi_apotek'),
            'nama_transaksi_apotek' => set_value('nama_transaksi_apotek'),
            'alamat_transaksi_apotek' => set_value('jenis_kelamin'),
            'kota' => set_value('kota'),
            'telp' => set_value('telp'),
        );
        $data['supplier_option'] = array();
        $data['supplier_option'][''] = 'Pilih Supplier';
        foreach ($this->Tbl_supplier_model->get_all() as $supplier){
            $data['supplier_option'][$supplier->kode_supplier] = $supplier->nama_supplier;
        }
        $data['apoteker_option'] = array();
        $data['apoteker_option'][''] = 'Pilih Apoteker';
        foreach ($this->Tbl_apoteker_model->get_all() as $apoteker){
            $data['apoteker_option'][$apoteker->id_apoteker] = $apoteker->nama_apoteker;
        }

        $data['obat_option'] = array();
        $data['obat_option'][''] = 'Pilih Barang';
        $obat_opt_js = array();
        foreach ($this->Tbl_obat_alkes_bhp_model->get_barang_all() as $obat){
            $data['obat_option'][$obat->kode_barang] = $obat->barcode .' | '.$obat->nama_barang .' | '.$obat->deskripsi .' | '.$obat->nama_pabrik;
            $obat_opt_js[] = array(
                'value' => $obat->kode_barang,
                'label' => $obat->barcode .' | '.$obat->nama_barang .' | '.$obat->deskripsi .' | '.$obat->nama_pabrik,
            );
        }
        $data['obat_option_js'] = json_encode($obat_opt_js);
        $data['obat_all'] = json_encode($this->Tbl_obat_alkes_bhp_model->get_barang_all());
        
        $this->template->load('template','transaksi_apotek/purchase_order/purchase_order_form', $data);
    }
    
    public function save_po() 
    {
        $kode_po='PO'.time();
        $obat=$this->input->post('obat',TRUE);
        $harga=$this->input->post('harga',TRUE);
        $stok=$this->input->post('stok',TRUE);
        $diskon=$this->input->post('diskon',TRUE);
        $tgl_exp=$this->input->post('tgl_exp',TRUE);
        $data = array(
                'kode_purchase' => $kode_po,
                'kode_supplier' => $this->input->post('kode_supplier',TRUE),
                'id_apoteker' => $this->input->post('id_apoteker',TRUE),
                'jenis_pembayaran' => $this->input->post('jenis_pembayaran',TRUE),
                'id_klinik'=>$this->id_klinik,
                'tanggal_po'=>$this->input->post('tgl_po'),
                'is_closed'=>FALSE,
                'is_receive'=>FALSE,
                'keterangan' => $this->input->post('keterangan',TRUE),
                'total_harga' => $this->input->post('totalharga',TRUE),
        );
        $insert=$this->Transaksi_obat_model->insert('tbl_purchases',$data);
        if ($insert) {
            for ($i=0; $i < count($obat); $i++) { 
                if ($obat[$i] != '' || $obat[$i] != null) {
                    $data_detail=array();
                    $data_detail=array(
                        'kode_purchase' => $kode_po,
                        'kode_barang' => $obat[$i],
                        'jumlah' => $stok[$i],
                        'harga' => $harga[$i],
                        'diskon' => $diskon[$i],
                        // 'tgl_exp' => $tgl_exp[$i],
                    );
                    // print_r($data_detail);
                    $insert=$this->Transaksi_obat_model->insert('tbl_purchase_d',$data_detail);
                }
            }
            // print_r(count($_POST['obat']));
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('transaksi_apotek/po'));
        }else{
            
        }
    }

    public function delete_po($id) 
    {
        $where=array('kode_purchase'=>$id);
        $row = $this->Transaksi_obat_model->get_by_id($where, 'tbl_purchases');
        if ($row) {
            $this->Transaksi_obat_model->delete($where, 'tbl_purchases');
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('transaksi_apotek/po'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('transaksi_apotek/po'));
        }
    }


    public function receipt(){
        $this->template->load('template','transaksi_apotek/penerimaan_barang/penerimaan_barang_list');
    }

    public function json_receipt(){
        $data=$this->Transaksi_obat_model->json_receipt($this->id_klinik);
        $data1=array();
        foreach ($data as $key => $value) {
            $row=array();
            $row['kode_purchase']= $value->kode_purchase;
            $row['nama_supplier']= $value->nama_supplier;
            $row['nama_apoteker']= $value->nama_apoteker;
            $row['total_harga']  = $value->total_harga;
            $row['keterangan']   = $value->keterangan;
            $row['status']   = ($value->is_closed != TRUE ? 'Open' : 'Closed');
            $row['action']       = ($value->is_closed != TRUE ? anchor(site_url('transaksi_apotek/receipt_order/').$value->kode_purchase ,'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')
                                    : anchor(site_url('transaksi_apotek/print_receipt/').$value->kode_purchase,'<i class="fa fa-print" aria-hidden="true"></i>', array('target'=>'_blank' , 'class'=>'btn btn-primary btn-sm')));
                // ." ".anchor(site_url('dataobat/delete/').$value->kode_purchase,'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"')
            $data1[]=$row;
        }
        $output = array(
                        "draw" => 0,
                        "recordsTotal" => count($data1),
                        "recordsFiltered" => count($data1),
                        "data" => $data1,
                );
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function receipt_order($id) 
    {
        $data['data']=$this->Transaksi_obat_model->get_detail_po($id);
        $data['button'] = 'Create';
        $data['action'] = site_url('transaksi_apotek/save_receipt');
        $data['gudang_option'] = array();
        $data['gudang_option'][''] = 'Pilih Gudang';
        foreach ($this->Tbl_gudang_model->get_all() as $gudang){
            $data['gudang_option'][$gudang->kode_gudang] = $gudang->nama_gudang;
        }
        $data['lokasi_option'] = array();
        $data['lokasi_option'][''] = 'Pilih Lokasi';
        foreach ($this->Tbl_lokasi_barang_model->get_all() as $lokasi){
            $data['lokasi_option'][$lokasi->id_lokasi_barang] = $lokasi->lokasi;
        }
        $this->template->load('template','transaksi_apotek/penerimaan_barang/penerimaan_barang_receipt', $data);
    }
    public function save_receipt(){
        $barang=$this->input->post('kode_barang',TRUE);
        $jumlah=$this->input->post('jumlah',TRUE);
        $gudang=$this->input->post('gudang',TRUE);
        $lokasi=$this->input->post('lokasi',TRUE);
        $harga=$this->input->post('harga',TRUE);
        $diskon=$this->input->post('diskon',TRUE);
        $tgl_exp=$this->input->post('tgl_exp',TRUE);
        $kode_purchase=$this->input->post('no_po',TRUE);
        $kode_receipt='RCP'.time();
        $data = array(
                'id_inventory'  => $kode_receipt,
                'kode_purchase' => $kode_purchase,
                'inv_type'      => 'RECEIPT_ORDER',
                'id_klinik'     => $this->id_klinik,
        );
        $insert=$this->Transaksi_obat_model->insert('tbl_inventory',$data);
        $insert=1;
        if ($insert=1) {
            //update po -> close
            $data_update=array(
                'pengirim'      => $this->input->post('pengirim',TRUE),
                'is_closed'     => TRUE, 
                'is_receive'    => TRUE
            );
            $where=array('kode_purchase'=>$kode_purchase);
            $update_po=$this->Transaksi_obat_model->update($where, 'tbl_purchases', $data_update);
            $total_bersih=$total=$total_diskon=0;
            $total_bersih_alkes=$total_alkes=$total_diskon_alkes=0;
            for ($i=0; $i < count($barang); $i++) { 
                $data_detail=array();
                $data_detail=array(
                    'id_inventory' => $kode_receipt,
                    'kode_barang' => $barang[$i],
                    'kode_gudang' => $gudang[$i],
                    'id_lokasi_barang' => $lokasi[$i],
                    'jumlah' => $jumlah[$i],
                    'harga' => $harga[$i],
                    'diskon' => $diskon[$i],
                    'tgl_exp' => $tgl_exp[$i],
                );
                $insert=$this->Transaksi_obat_model->insert('tbl_inventory_detail',$data_detail);
                $row=$this->db->where('kode_barang', $barang[$i])->get('tbl_obat_alkes_bhp')->row();
                if ($row->jenis_barang == 2) {
                    $tempTotalAlkes=$jumlah[$i] * $harga[$i];
                    $total_alkes+=$tempTotalAlkes;
                    $temptotal_diskonAlkes=$jumlah[$i] * $diskon[$i];
                    $total_diskon_alkes+=$temptotal_diskonAlkes;
                }else{
                    $temptotal=$jumlah[$i] * $harga[$i];
                    $total+=$temptotal;
                    $temptotal_diskon=$jumlah[$i] * $diskon[$i];
                    $total_diskon+=$temptotal_diskon;
                }
            }
            $total_bersih=$total - $total_diskon;
            $total_bersih_alkes=$total_alkes - $total_diskon_alkes;

            $data_akun=array(
                'total'         => $total,
                'total_diskon'         => $total_diskon,
                'total_bersih'         => $total_bersih,
                'total_alkes'         => $total_alkes,
                'total_diskon_alkes'         => $total_diskon_alkes,
                'total_bersih_alkes'         => $total_bersih_alkes,
                'kode_purchase'         => $kode_purchase,
            );

            $this->jurnal_otomatis($data_akun);//jurnal otomatis akuntansi untuk modal persediaan obat

            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('transaksi_apotek/receipt'));
        }else{
            
        }
    }
    // private function jurnal_otomatis($jenis_barang, $kode_receipt, $total, $total_diskon, $total_bersih){
    private function jurnal_otomatis($data_akun){
        // $akun=$this->getIdAkun($jenis_barang);
        // $id_akun=$akun->id_akun;
        // $nama_akun=$akun->nama_akun;
        // $total=$jumlah * ($harga-$diskon);
        // $total=$jumlah * $harga;
        // $total_diskon=$jumlah * $diskon;
        // $total_bersih=$total - $total_diskon;
        $data_trx=array(
            'deskripsi'     => 'Pembelian Barang dengan Kode '. $data_akun['kode_purchase'],
            'tanggal'       => date('Y-m-d'),
        );
        $insert=$this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi', $data_trx);
        if ($insert) {
            $id_last=$this->db->select_max('id_trx_akun')->from('tbl_trx_akuntansi')->get()->row();
            if ($data_akun['total'] != 0) {
                $data=array(
                            'id_trx_akun'   => $id_last->id_trx_akun,
                            'id_akun'       => 58,
                            'jumlah'        => $data_akun['total'],
                            'tipe'          => 'DEBIT',
                            'keterangan'    => 'akun',
                        );
                $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                $data=array(
                            'id_trx_akun'   => $id_last->id_trx_akun,
                            'id_akun'       => 45,
                            'jumlah'        => $data_akun['total_diskon'],
                            'tipe'          => 'KREDIT',
                            'keterangan'    => 'akun',
                        );
                $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            }
            if ($data_akun['total_alkes'] != 0) {
                $data=array(
                            'id_trx_akun'   => $id_last->id_trx_akun,
                            'id_akun'       => 59,
                            'jumlah'        => $data_akun['total_alkes'],
                            'tipe'          => 'DEBIT',
                            'keterangan'    => 'akun',
                        );
                $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                $data=array(
                            'id_trx_akun'   => $id_last->id_trx_akun,
                            'id_akun'       => 47,
                            'jumlah'        => $data_akun['total_diskon_alkes'],
                            'tipe'          => 'KREDIT',
                            'keterangan'    => 'akun',
                        );
                $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            }
            $kredit_kas=($data_akun['total_bersih']+$data_akun['total_bersih_alkes']);
            $data=array(
                'id_trx_akun'   => $id_last->id_trx_akun,
                'id_akun'       => 20,
                'jumlah'        => $kredit_kas,
                'tipe'          => 'KREDIT',
                'keterangan'    => 'lawan',
            );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
        }
    }
    private function getIdAkun($jenis_barang){
        // $barang=$this->db->where('kode_barang', $id)->get('Tbl_obat_alkes_bhp')->row();
        if ($jenis_barang == 1) {
            $getAkun=$this->db->where('id_akun', 24)->get('tbl_akun')->row();
        }else if ($jenis_barang == 2) {
            $getAkun=$this->db->where('id_akun', 23)->get('tbl_akun')->row();
        }else{
            $getAkun=$this->db->where('id_akun', 37)->get('tbl_akun')->row();
        }
        return $getAkun;
        // $data=$this->db->where('kode_barang', $id)->get('tbl_akun')->row();
        // if ($data == null) {
        //     $barang=$this->db->where('kode_barang', $id)->get('Tbl_obat_alkes_bhp')->row();
        //     $no_akun_new=0;
        //     $main_akun=0;
        //     if ($barang->jenis_barang == 1) {
        //         // $row_main=$this->db->where('id_akun', 24)->get('tbl_akun')->row();
        //         // $row=$this->getNoAkun(24);
        //         // $main_akun=24;
        //         // $no_akun=explode('.', $row_main->no_akun);
        //         // if ($row->no_akun == null) {
        //         //     $no_akun_new=$no_akun[0].'.'.$no_akun[1].'.1.'.$no_akun[3];
        //         // }else{
        //         //     $set_akun=explode('.', $row->no_akun);
        //         //     $iterate=$set_akun[2]+1;
        //         //     $no_akun_new=$no_akun[0].'.'.$no_akun[1].'.'.$iterate.'.'.$no_akun[3];
        //         // }
        //         $no_akun_new=24;

        //     }else{
        //         // $row_main=$this->db->where('id_akun', 23)->get('tbl_akun')->row();
        //         // $row=$this->getNoAkun(23);
        //         // $main_akun=23;
        //         // $no_akun=explode('.', $row_main->no_akun);
        //         // if ($row->no_akun == null) {
        //         //     $no_akun_new=$no_akun[0].'.'.$no_akun[1].'.1.'.$no_akun[3];
        //         // }else{
        //         //     $set_akun=explode('.', $row->no_akun);
        //         //     $iterate=$set_akun[2]+1;
        //         //     $no_akun_new=$no_akun[0].'.'.$no_akun[1].'.'.$iterate.'.'.$no_akun[3];
        //         // }
        //         $no_akun_new=23;
        //     }
        //     $data_akun=array(
        //         'no_akun'       => $no_akun_new,
        //         'nama_akun'     => 'Stok '.$barang->nama_barang,
        //         'level'         => 2, 
        //         'id_main_akun'  => $main_akun, 
        //         'sifat_debit'   => 0,
        //         'sifat_kredit'  => 1,
        //         'kode_barang'   => $id,
        //     );
        //     $this->db->insert('tbl_akun', $data_akun);
        //     $getAkun=$this->db->where('kode_barang', $id)->get('tbl_akun')->row();
        //     return $getAkun;
        // }else{
        //     $getAkun=$this->db->where('kode_barang', $id)->get('tbl_akun')->row();
        //     return $getAkun;
        // }
    }
    public function print_receipt($id){
        $data['data']=$this->Transaksi_obat_model->get_detail_receipt($id);
        $this->load->view('transaksi_apotek/penerimaan_barang/cetak_penerimaan_barang', $data);
    }

    public function create_retur(){
        $data = array(
            'button' => 'Create',
            'action' => site_url('transaksi_apotek/save_retur'),
        );

        $po=$this->Transaksi_obat_model->get_po($this->id_klinik);
        
        $data['po_option'] = array();
        $data['po_option'][''] = 'Pilih No Purchase Order';
        foreach ($this->Transaksi_obat_model->get_po($this->id_klinik) as $po){
            $data['po_option'][$po->kode_purchase] = $po->kode_purchase;
        }
        
        $this->template->load('template','transaksi_apotek/retur_barang/retur_barang_form', $data);
    }
    public function save_retur(){
        $barang=$this->input->post('kode_barang',TRUE);
        $jumlah=$this->input->post('total_retur',TRUE);
        $gudang=$this->input->post('nama_gudang',TRUE);
        $lokasi=$this->input->post('lokasi',TRUE);
        $harga=$this->input->post('harga',TRUE);
        $diskon=$this->input->post('diskon',TRUE);
        $tgl_exp=$this->input->post('tgl_exp',TRUE);
        $no_po=$this->input->post('no_po',TRUE);
        $kode_receipt='RTR'.time();
        $inv_type=0;
        if ($this->jenis_retur == '0') {
            $inv_type='RETURN_STUFF';
        }else{
            $inv_type='RETURN_MONEY';
        }
        $data = array(
                'id_inventory'  => $kode_receipt,
                'kode_purchase' => $no_po,
                'inv_type'      => $inv_type,
                'id_klinik'     => $this->id_klinik,
        );
        $insert=$this->Transaksi_obat_model->insert('tbl_inventory',$data);
        if ($insert) {
            for ($i=0; $i < count($barang); $i++) {
                if ($barang[$i] != '' || $barang[$i] != null) {
                    $data_detail=array();
                    $data_detail=array(
                        'id_inventory' => $kode_receipt,
                        'kode_barang' => $barang[$i],
                        'kode_gudang' => $gudang[$i],
                        'id_lokasi_barang' => $lokasi[$i],
                        'jumlah' => $jumlah[$i],
                        'harga' => $harga[$i],
                        'diskon' => $diskon[$i],
                        'tgl_exp' => $tgl_exp[$i],
                    );
                    $insert=$this->Transaksi_obat_model->insert('tbl_inventory_detail',$data_detail);
                 } 
            }
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('transaksi_apotek/retur_list'));
        }else{
            
        }
    }

    public function retur_list(){
        $this->template->load('template','transaksi_apotek/retur_barang/retur_barang_list');
    }

    public function get_detail_po($id){
        $data=$this->Transaksi_obat_model->get_data_receipt($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function json_retur(){
        $data=$this->Transaksi_obat_model->get_retur($this->id_klinik);
        $data1=array();
        foreach ($data as $key => $value) {
            $row=array();
            $row['kode_purchase']= $value->kode_purchase;
            $row['nama_supplier']= $value->nama_supplier;
            $row['nama_apoteker']= $value->nama_apoteker;
            $id_inventory=$value->id_inventory;
            $row['action']       = anchor('#',"<i class='fa fa-eye' aria-hidden='true'></i>","class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal' onClick='cekDetail(\"$id_inventory\")'");
            $data1[]=$row;
        }
        $output = array(
                        "draw" => 0,
                        "recordsTotal" => count($data1),
                        "recordsFiltered" => count($data1),
                        "data" => $data1,
                );
        header('Content-Type: application/json');
        echo json_encode($output);
    }
    public function get_detail_retur($id){
        $data=$this->Transaksi_obat_model->get_detail_retur($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function _rules() 
    {
        $this->form_validation->set_rules('kode_transaksi_apotek', 'kode transaksi_apotek', 'trim');
        $this->form_validation->set_rules('nama_transaksi_apotek', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('alamat_transaksi_apotek', 'Alamat transaksi_apotek', 'trim|required');
        $this->form_validation->set_rules('kota', 'kota', 'trim|required');
        $this->form_validation->set_rules('telp', 'telp', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pasien.php */
/* Location: ./application/controllers/Pasien.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-03 15:02:10 */
/* http://harviacode.com */