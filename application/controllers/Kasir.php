<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kasir extends CI_Controller
{
    public $id_klinik;
    
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('akuntansi/Transaksi_akuntansi_model');
        $this->load->model('Transaksi_model');
        $this->load->model('Periksa_model');
        $this->load->model('Transaksi_obat_model');
        $this->load->model('Tbl_pasien_model');
        $this->load->model('Tbl_dokter_model');
		$this->load->model('Tbl_obat_alkes_bhp_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
        $this->load->model('Master_sequence_model');
	    
	    $this->id_klinik = $this->session->userdata('id_klinik');
    }

    public function index()
    {
        $this->template->load('template','apotek/apotek_list');
    } 
    
    public function jual_obat(){
        $this->form_validation->set_rules('no_transaksi', 'No Transaksi', 'trim|required');
        $this->form_validation->set_rules('atas_nama', 'Atas Nama', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        
        if ($this->form_validation->run() == TRUE) {
            
            //TRANSAKSI
            $date_now_trx = date('Y-m-d', time());
            $no_transaksi='TRXOBAT'.$this->Master_sequence_model->set_code_by_master_seq_code("NOTRANSAKSIOBAT", true);
            $data_transkasi = array(
                'kode_transaksi' => 'TRXOBAT',
                'id_klinik' => $this->id_klinik,
                // 'no_transaksi' => 'TRXOBAT'.$this->Master_sequence_model->set_code_by_master_seq_code("NOTRANSAKSIOBAT", true),
                'no_transaksi' => $no_transaksi,
                'tgl_transaksi' => $date_now_trx,
                'status_transaksi' => 0,
                'atas_nama' => $this->input->post('atas_nama')
            );
            
            $data_transaksi_d = array(
                array(
                    'no_transaksi' => $this->input->post('no_transaksi'),
                    'deskripsi' => 'Total Obat-obatan',
                    'amount_transaksi' => $this->input->post('total_harga'),
                    'dc' => 'd'
                ),
            );
            
            $post_obat = $this->input->post('obat');
            $post_obat_jml = $this->input->post('jml_obat');
            $post_obat_harga = $this->input->post('harga_satuan');
            
            //input inventory barang
            $kode_receipt='RCP'.time();
            $data = array(
                    'id_inventory'  => $kode_receipt,
                    'inv_type'      => 'TRX_STUFF',
                    'id_klinik'     => $this->id_klinik,
            );
            $getDiskon=$this->db->where('bulan', date('Y-m'))->get('tbl_diskon_trx')->result_array();
            $insert=$this->Transaksi_obat_model->insert('tbl_inventory',$data);
            $dataobat = array();
            foreach ($this->Tbl_obat_alkes_bhp_model->get_all_obat($this->id_klinik) as $obat){
                $dataobat[] = array(
                    'id' => $obat->kode_barang,
                    'harga' => $obat->harga,
                    'harga_jual' => $obat->harga_jual,
                    'diskon' => $obat->diskon,
                    'tgl_exp' => $obat->tgl_exp,
                );
            }
            $total_jual=$total_beli=0;
            for ($i=0; $i < count($post_obat); $i++) { 
                    $harga_obat=$tgl_exp=$diskon=0;
                    $kode_barang=strval($post_obat[$i]);
                    for ($j=0; $j < count($dataobat); $j++) { 
                        if ($kode_barang == strval($dataobat[$j]['id'])) {
                            $harga_obat=$dataobat[$j]['harga'];
                            $harga_jual=$dataobat[$j]['harga_jual'];
                            $diskon=$dataobat[$j]['diskon'];
                            $tgl_exp=$dataobat[$j]['tgl_exp'];
                        }
                    }
                    
                    $data_detail=array();
                    $data_detail=array(
                        'id_inventory' => $kode_receipt,
                        'kode_barang' => $kode_barang,
                        'jumlah' => $post_obat_jml[$i],
                        'harga' => $harga_jual,
                        'tgl_exp' => $tgl_exp,
                    );
                    $total=$post_obat_jml[$i]*$harga_jual;
                    $total_jual+=$total;

                    $harga_beli=$harga_obat-$diskon;
                    $total_beli+=($post_obat_jml[$i]*$harga_beli);
                    
                    $insert=$this->Transaksi_obat_model->insert('tbl_inventory_detail',$data_detail);
            }

            $this->jurnal_otomatis(39, $total_jual, count($getDiskon)==0 ? 0 : $getDiskon[0]['diskon'], $total_beli, $no_transaksi);//jurnal otomatis akuntansi untuk pendapatan penjualan obat

            $data_transaksi_d_obat = array();
            for($i = 0; $i < count($post_obat); $i++){
                if($post_obat[$i] != null || $post_obat[$i] != ''){
                    $data_transaksi_d_obat[] = array(
                        'no_transaksi' => $this->input->post('no_transaksi'),
                        'kode_barang' => $post_obat[$i],
                        'jumlah' => $post_obat_jml[$i],
                        'harga' => $post_obat_harga[$i]
                    );
                    
                    //Update stok obat
                    // $kode_barang = $post_obat[$i];
                    // $obat = $this->Tbl_obat_alkes_bhp_model->get_by_id($kode_barang);
                    // $stok_sekarang = $obat->stok_barang;
                    // $stok_sisa = $stok_sekarang - ceil($post_obat_jml[$i]);
                    // $this->Tbl_obat_alkes_bhp_model->update($kode_barang,
                    //     array(
                    //         'stok_barang' => $stok_sisa,
                    //         'dtm_upd' => date("Y-m-d H:i:s",  time())
                    //     )
                    // );
                }
            }
            
            //Insert into tbl_transaksi
            $this->Transaksi_model->insert($data_transkasi,$data_transaksi_d);
            $this->Transaksi_model->insert_transaksi_d_obat($data_transaksi_d_obat);
             
            redirect('kasir/jual_obat');
        } else {
        
            $this->data['no_transaksi'] = 'TRXOBAT'.$this->Master_sequence_model->set_code_by_master_seq_code("NOTRANSAKSIOBAT");
            
            $this->data['obat_option'] = array();
            $this->data['obat_option'][''] = 'Pilih Obat';
            $obat_opt_js = array();
            foreach ($this->Tbl_obat_alkes_bhp_model->get_all_obat($this->id_klinik) as $obat){
                $this->data['obat_option'][$obat->kode_barang] = $obat->nama_barang;
                $obat_opt_js[] = array(
                    'value' => $obat->kode_barang,
                    'label' => $obat->nama_barang
                );
            }
            $this->data['obat_option_js'] = json_encode($obat_opt_js);
            
            $this->data['obat'] = $this->get_all_obat();    
            
        }
        
        $this->template->load('template','apotek/jual_obat', $this->data);
    }
    private function jurnal_otomatis($id, $total, $diskon, $total_beli, $no_transaksi){
        $akun=$this->getIdAkun($id);
        $id_akun=$akun->id_akun;
        $nama_akun=$akun->nama_akun;
        $total_diskon=$total*($diskon/100);
        $total_harga=$total-$total_diskon;
        $data_trx=array(
            'deskripsi'     => 'Penjualan Obat dengan Kode Transaksi '.$no_transaksi,
            'tanggal'       => date('Y-m-d'),
        );
        
        $insert=$this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi', $data_trx);
        if ($insert) {
            $id_last=$this->db->select_max('id_trx_akun')->from('tbl_trx_akuntansi')->get()->row();
            //pendapatan masuk
            $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => $id_akun,
                        'jumlah'        => $total,
                        'tipe'          => 'KREDIT',
                        'keterangan'    => 'akun',
                    );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            //persediaan berkurang
            $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 58,
                        'jumlah'        => $total_beli,
                        'tipe'          => 'KREDIT',
                        'keterangan'    => 'akun',
                    );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            //diskon
            $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 46,
                        'jumlah'        => $total_diskon,
                        'tipe'          => 'DEBIT',
                        'keterangan'    => 'akun',
                    );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            //pemasukan kas
            $data=array(
                'id_trx_akun'   => $id_last->id_trx_akun,
                'id_akun'       => 20,
                'jumlah'        => $total_harga,
                'tipe'          => 'DEBIT',
                'keterangan'    => 'lawan',
            );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            //pemasukan kas
            $data=array(
                'id_trx_akun'   => $id_last->id_trx_akun,
                'id_akun'       => 65,
                'jumlah'        => $total_beli,
                'tipe'          => 'DEBIT',
                'keterangan'    => 'lawan',
            );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
        }
    }
    private function getIdAkun($id){
        $getAkun=$this->db->where('id_akun', $id)->get('tbl_akun')->row();
        return $getAkun;
    }
    function get_all_obat(){
        $data_alkes = $this->Tbl_obat_alkes_bhp_model->get_all_obat();
        $projects = array();
        foreach ($data_alkes as $alkes) {
            $projects[] = array(
                'kode_barang'   => $alkes->kode_barang,
                'stok_barang'   => $alkes->stok_barang,
                'harga'         => $alkes->harga_jual,
            );
        }
        return json_encode($projects);
    }
    
    private function hitung_total_alkes_obat($no_periksa){
        //Hitung alkes
        $alkes = $this->Periksa_model->get_d_alkes_by_id($no_periksa);
        $total_alkes_obat = 0;
        foreach($alkes as $data){
            $total_alkes_obat += $data->jumlah * $data->harga;
        }
        
        $obat_tebus = $this->Periksa_model->get_d_obat_tebus_by_id($no_periksa);
        foreach($obat_tebus as $data){
            $total_alkes_obat += ceil($data->jumlah) * $data->harga;
        }
        
        return $total_alkes_obat;
    }
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json_apotek($this->id_klinik);
    }
    
    public function json2() {
        header('Content-Type: application/json');
        echo $this->Transaksi_model->json_apotek2($this->id_klinik);
    }
    
    function get_wilayah($kode){
        $this->db->where('kode', $kode);
        $data = $this->db->get('tbl_wilayah')->row();
        return $data->nama;
    }
    public function cetak_struk_jual($no_transaksi){
        $data['transaksi']=$this->Transaksi_model->getDetailTrxObat($no_transaksi);
        $data['petugas']=$this->session->userdata('full_name');
        $this->load->view('apotek/cetak_struk', $data);
    }
}