<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dataobat extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_obat_alkes_bhp_model');
        $this->load->model('Tbl_kategori_barang_model');
        $this->load->model('Tbl_satuan_barang_model');
        $this->load->model('Transaksi_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->library('upload');
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $this->id_klinik = $this->session->userdata('id_klinik');
    }
    
    function autocomplate(){
        // autocomplate untuk pencarian obat
        $this->db->like('nama_barang', $_GET['term']);
        $this->db->select('nama_barang');
        $products = $this->db->get('tbl_obat_alkes_bhp')->result();
        foreach ($products as $product) {
            $return_arr[] = $product->nama_barang;
        }

        echo json_encode($return_arr);
    }

    public function index()
    {
        $this->template->load('template','dataobat/tbl_obat_alkes_bhp_list');
    }
    
    public function stok()
    {
        $step1 = $this->Tbl_obat_alkes_bhp_model->getStokStep1();
        $stok = [];
        foreach ($step1 as $key => $value) {
            $cek = $this->Tbl_obat_alkes_bhp_model->getStokStep2($value->kode_barang);
            if($cek==0){
                $getStok = 0;
            }
            else{
                $getStok = $this->Tbl_obat_alkes_bhp_model->getStokStep3($value->kode_barang);
            }
            $stok[$key] = array(
                'kode_barang' => $value->kode_barang,
                'nama_barang' => $value->nama_barang,
                'stok' => $getStok 
            );
        }
        $this->template->load('template','dataobat/stok-barang', ['stok' => $stok]);
    }
    
    public function history()
    {
        $data['barang'] = $this->Tbl_obat_alkes_bhp_model->getStokStep1();

        if(isset($_GET['kode_barang'])){
            $dari = date('Y-m-d', strtotime($_GET['dari']));
            $sampai = date('Y-m-d', strtotime($_GET['sampai']));
            $data['stokAwal'] = $this->Tbl_obat_alkes_bhp_model->getStokStep3($_GET['kode_barang'],$dari);
            $data['history'] = $this->Tbl_obat_alkes_bhp_model->historyBarang($_GET['kode_barang'],$dari,$sampai);
        }
        $this->template->load('template','dataobat/history-barang', $data);
    }
    
    public function laporankeuangan()
    {
        $laporan = [];
        if(isset($_GET['dari'])){
            $dari = date('Y-m-d', strtotime($_GET['dari']));
            $sampai = date('Y-m-d', strtotime($_GET['sampai']));
            $step1 = $this->Transaksi_model->laporanKeuanganStep1($dari,$sampai);
            foreach ($step1 as $key => $value) {
                $laporan[$key] = array(
                    'no_transaksi' => $value->no_transaksi,
                    'biaya_obat' => $this->Transaksi_model->sumAmountTrans($value->no_transaksi,"Total Obat-obatan")[0]->ttl,
                    'biaya_pemeriksaan' => $this->Transaksi_model->sumAmountTrans($value->no_transaksi,"Biaya Pemeriksaan")[0]->ttl,
                    'biaya_tindakan' => $this->Transaksi_model->sumAmountTrans($value->no_transaksi,"Biaya Tindakan")[0]->ttl,
                    'biaya_admin' => $this->Transaksi_model->sumAmountTrans($value->no_transaksi,"Biaya Administrasi")[0]->ttl,
                );
            }
        }
       $this->template->load('template','dataobat/laporan-keuangan-barang', ['laporan' => $laporan]);
    }
    
    public function manufaktur()
    {
        $data['barang'] = $this->Tbl_obat_alkes_bhp_model->get_all();
        $this->template->load('template','dataobat/manufaktur-barang', $data);
    }


    public function getManufakturDetail()
    {
        $data['barang'] = $this->Tbl_obat_alkes_bhp_model->get_all();
        $data['dataId'] = $_POST['id'];
        $this->load->view('dataobat/manufaktur-barang-detail', $data);
    }

    public function getStok()
    {
        $cek = $this->Tbl_obat_alkes_bhp_model->getStokStep2($_GET['kode_barang']);
        if($cek==0){
            $getStok = 0;
        }
        else{
            $getStok = $this->Tbl_obat_alkes_bhp_model->getStokStep3($_GET['kode_barang']);
        }

        echo $getStok;

    }

    public function manufaktur_action()
    {
        $getKode = $this->Tbl_obat_alkes_bhp_model->lastKodeManufaktur();
        $kode = count($getKode)==0 ? "0001" :  sprintf("%04s",(int)$getKode[0]['kode_manufaktur']+1);

        $kodeBarang='BRG'.time();


        $manufaktur = array(
            'kode_manufaktur' => $kode, 
            'kode_barang' => $kodeBarang,
            'jumlah' => $_POST['jumlah'],
            'harga' => $_POST['harga'],
        );
       $this->db->insert("tbl_manufaktur",$manufaktur);
        
        $barang = array(
            'kode_barang' => $kodeBarang,
            'nama_barang' => $_POST['nama_barang'],
            'harga' => $_POST['harga'],
        );
        $this->db->insert("tbl_obat_alkes_bhp",$barang);
        $kode_receipt='RCP'.time();
        
        $inventoryBJadi = array( //barang jadi
            'id_inventory'  => $kode_receipt,
            'inv_type'      => 'MANUFAKTUR_IN',
            'id_klinik'     => $this->id_klinik,
        );
        $this->db->insert("tbl_inventory",$inventoryBJadi);
        
        $detailInventoryBJadi = array( //barang jadi
            'id_inventory'  => $kode_receipt,
            "kode_barang" => $kodeBarang,
            "jumlah" => $_POST['jumlah'],
            "harga" => $_POST['harga'],
            "kode_gudang" => "",
            "id_lokasi_barang" => 0,
            "tgl_exp" => $_POST['tgl_exp']
        );
        $this->db->insert("tbl_inventory_detail",$detailInventoryBJadi);
        
        $newTime = (int)time() + 1;
        $kode_receipt2='RCP'.$newTime;
    
        $inventoryBBerkurang = array( //barang berkurang
            'id_inventory'  => $kode_receipt2,
            'inv_type'      => 'MANUFAKTUR_OUT',
            'id_klinik'     => $this->id_klinik,
        );
        $this->db->insert("tbl_inventory",$inventoryBBerkurang);
        

        foreach ($_POST['m_kode_barang'] as $key => $value) {
            $detailInventoryBJadi = array( //barang berkurang
                'id_inventory'  => $kode_receipt2,
                "kode_barang" => $value,
                "jumlah" => $_POST['m_jumlah'][$key],
                "harga" => $_POST['m_harga'][$key],
                "kode_gudang" => "",
                "id_lokasi_barang" => 0,
                "tgl_exp" => $_POST['tgl_exp'][$key]
            );
            $this->db->insert("tbl_inventory_detail",$detailInventoryBJadi);
    
            $detail = array(
                'kode_manufaktur' => $kode, 
                'kode_barang' => $value,
                'jumlah' => $_POST['m_jumlah'][$key],
                'harga' => $_POST['m_harga'][$key],
            );
            $this->db->insert("tbl_manufaktur_detail",$detail);
        }

        redirect(base_url()."dataobat/update/".$kodeBarang);
    }

    public function jsonStok(){
       header('Content-Type: application/json');
        echo $this->Tbl_obat_alkes_bhp_model->get_all_obat(null,true);
    }

    public function json(){
        header('Content-Type: application/json');
        echo $this->Tbl_obat_alkes_bhp_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_obat_alkes_bhp_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kode_barang' => $row->kode_barang,
		'nama_barang' => $row->nama_barang,
		'id_kategori_barang' => $row->id_kategori_barang,
		'id_satuan_barang' => $row->id_satuan_barang,
		'harga' => $row->harga,
	    );
            $this->template->load('template','dataobat/tbl_obat_alkes_bhp_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dataobat'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('dataobat/create_action'),
    	    'kode_barang' => set_value('kode_barang'),
    	    'nama_barang' => set_value('nama_barang'),
    	    'id_kategori_barang' => set_value('id_kategori_barang'),
    	    'id_satuan_barang' => set_value('id_satuan_barang'),
    	    'jenis_barang' => set_value('jenis_barang'),
    	    // 'stok_barang' => set_value('stok_barang'),
            'harga' => set_value('harga'),
            'id_klinik' => set_value('id_klinik'),
            'kode_pabrik' => set_value('kode_pabrik'),
    	    'id_golongan_barang' => set_value('id_golongan_barang'),
            'minimal_stok' => set_value('minimal_stok'),
            'deskripsi' => set_value('deskripsi'),
            'indikasi' => set_value('indikasi'),
            'kandungan' => set_value('kandungan'),
            'dosis' => set_value('dosis'),
            // 'tipe_barang' => set_value('tipe_barang'),
            'kemasan' => set_value('kemasan'),
            'efek_samping' => set_value('efek_samping'),
            'zat_aktif' => set_value('zat_aktif'),
            // 'tanggal_expired' => set_value('tanggal_expired'),
            'etiket' => set_value('etiket'),
            'foto_barang' => set_value('foto_barang'),
            'barcode' => set_value('barcode'),
	);
        $this->template->load('template','dataobat/tbl_obat_alkes_bhp_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        $kode_barang='BRG'.time();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $foto_barang=null;
            if ($_FILES['foto_barang']['name'] != null) {
                $config['upload_path']          = './assets/images/foto_barang/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
         
                $filename = $_FILES['foto_barang']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                
                $newname='OBT_'.time().'.'.$ext;
                if ($_FILES['foto_barang']['size'] < 2000000) {
                        $config['file_name']= $newname;
                }
                $this->upload->initialize($config);
                $foto_barang=$newname;
                if ($this->upload->do_upload('foto_barang')){
                    if ($_FILES['foto_barang']['size'] < 2000000) {
                        $this->load->library('upload', $config);
                        // echo "Image berhasil diupload";
                        // $data->foto_barang=$newname;
                    }else{
                        $gbr = $this->upload->data();
                        
                        $config['image_library']='gd2';
                        $config['source_image']='./assets/images/foto_barang/'.$gbr['file_name'];
                        $config['create_thumb']= FALSE;
                        $config['maintain_ratio']= FALSE;
                        $config['quality']= '50%';
                        $config['width']= 1024;
                        $config['height']= 768;
                        $config['new_image']= './assets/images/foto_barang/'.$newname;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        // $data->foto_barang=$newname;
                        @unlink( $config['source_image'] );
                        // echo "Image berhasil resize";
                    }
                }
            }else{
                $foto_barang=null;
                // echo "Image yang diupload kosong";
            }
            $harga=$this->input->post('harga',TRUE);
            $data = array(
                'kode_barang'=>$kode_barang,
        		'nama_barang' => $this->input->post('nama_barang',TRUE),
        		'id_kategori_barang' => $this->input->post('id_kategori_barang',TRUE),
        		'id_satuan_barang' => $this->input->post('id_satuan_barang',TRUE),
        		'harga' => $this->currency($harga),
        		'jenis_barang' => $this->input->post('jenis_barang',TRUE),
        		// 'stok_barang' => $this->input->post('stok_barang',TRUE),
        		'id_klinik' => $this->input->post('id_klinik',TRUE),
                'id_golongan_barang' => $this->input->post('id_golongan_barang'),
                'kode_pabrik' => $this->input->post('kode_pabrik'),
                'minimal_stok' => $this->input->post('minimal_stok'),
                'deskripsi' => $this->input->post('deskripsi'),
                'indikasi' => $this->input->post('indikasi'),
                'kandungan' => $this->input->post('kandungan'),
                'dosis' => $this->input->post('dosis'),
                // 'tipe_barang' => $this->input->post('tipe_barang'),
                'kemasan' => $this->input->post('kemasan'),
                'efek_samping' => $this->input->post('efek_samping'),
                'zat_aktif' => $this->input->post('zat_aktif'),
                'etiket' => $this->input->post('etiket'),
                'foto_barang' => $foto_barang,
                'barcode' => $this->input->post('barcode'),
	    );
        
        //relasi ke table akuntansi
        // $no_akun_new=0;
        // $main_akun=0;
        // if ($this->input->post('jenis_barang',TRUE) == 1) {
        //     $row_main=$this->db->where('id_akun', 24)->get('tbl_akun')->row();
        //     $row=$this->getNoAkun(24);
        //     $main_akun=24;
        //     $no_akun=explode('.', $row_main->no_akun);
        //     if ($row->no_akun == null) {
        //         $no_akun_new=$no_akun[0].'.'.$no_akun[1].'.1.'.$no_akun[3];
        //     }else{
        //         $set_akun=explode('.', $row->no_akun);
        //         $iterate=$set_akun[2]+1;
        //         $no_akun_new=$no_akun[0].'.'.$no_akun[1].'.'.$iterate.'.'.$no_akun[3];
        //     }

        // }else{
        //     $row_main=$this->db->where('id_akun', 23)->get('tbl_akun')->row();
        //     $row=$this->getNoAkun(23);
        //     $main_akun=23;
        //     $no_akun=explode('.', $row_main->no_akun);
        //     if ($row->no_akun == null) {
        //         $no_akun_new=$no_akun[0].'.'.$no_akun[1].'.1.'.$no_akun[3];
        //     }else{
        //         $set_akun=explode('.', $row->no_akun);
        //         $iterate=$set_akun[2]+1;
        //         $no_akun_new=$no_akun[0].'.'.$no_akun[1].'.'.$iterate.'.'.$no_akun[3];
        //     }
        // }
            // $data_akun=array(
            //     'no_akun'       => $no_akun_new,
            //     'nama_akun'     => 'Stok '.$this->input->post('nama_barang',TRUE),
            //     'level'         => 2, 
            //     'id_main_akun'  => $main_akun, 
            //     'sifat_debit'   => 0,
            //     'sifat_kredit'  => 1,
            //     'kode_barang'   => $kode_barang,
            // );
            // $this->db->insert('tbl_akun', $data_akun);
            // exit();
            $this->Tbl_obat_alkes_bhp_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('dataobat'));
        }
    }
    private function getNoAkun($id){
        $this->db->select_max('no_akun');
        $this->db->from('tbl_akun');
        $this->db->where('id_main_akun', $id);
        return $this->db->get()->row();
    }
    public function update($id) 
    {
        $row = $this->Tbl_obat_alkes_bhp_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('dataobat/update_action'),
        		'kode_barang' => set_value('kode_barang', $row->kode_barang),
        		'nama_barang' => set_value('nama_barang', $row->nama_barang),
        		'id_kategori_barang' => set_value('id_kategori_barang', $row->id_kategori_barang),
        		'id_satuan_barang' => set_value('id_satuan_barang', $row->id_satuan_barang),
        		'jenis_barang' => set_value('jenis_barang', $row->jenis_barang),
    	        // 'stok_barang' => set_value('stok_barang',$row->stok_barang),
        		'harga' => set_value('harga', $row->harga),
        		'id_klinik' => set_value('id_klinik', $row->id_klinik),
                'kode_pabrik' => set_value('kode_pabrik', $row->kode_pabrik),
                'id_golongan_barang' => set_value('id_golongan_barang', $row->id_golongan_barang),
                'minimal_stok' => set_value('minimal_stok', $row->minimal_stok),
                'deskripsi' => set_value('deskripsi', $row->deskripsi),
                'indikasi' => set_value('indikasi', $row->indikasi),
                'kandungan' => set_value('kandungan', $row->kandungan),
                'dosis' => set_value('dosis', $row->dosis),
                // 'tipe_barang' => set_value('tipe_barang', $row->tipe_barang),
                'kemasan' => set_value('kemasan', $row->kemasan),
                'efek_samping' => set_value('efek_samping', $row->efek_samping),
                'zat_aktif' => set_value('zat_aktif', $row->zat_aktif),
                // 'tanggal_expired' => set_value('tanggal_expired', $row->tanggal_expired),
                'etiket' => set_value('etiket', $row->etiket),
                'foto_barang' => set_value('foto_barang', $row->foto_barang),
                'barcode' => set_value('barcode', $row->barcode),
	        );
            $this->template->load('template','dataobat/tbl_obat_alkes_bhp_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dataobat'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_barang', TRUE));
        } else {
            $data=array();
            $foto_barang=null;
            $row = $this->Tbl_obat_alkes_bhp_model->get_by_id($this->input->post('kode_barang', TRUE));
            if ($_FILES['foto_barang']['name'] != null) {
                // edit foto
                $image= './assets/images/foto_barang/'.$row->foto_barang;
                if (file_exists($image)) {
                    unlink($image);
                }
                $config['upload_path']          = './assets/images/foto_barang/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
         
                $filename = $_FILES['foto_barang']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                
                $newname='OBT_'.time().'.'.$ext;
                if ($_FILES['foto_barang']['size'] < 2000000) {
                        $config['file_name']= $newname;
                }
                $this->upload->initialize($config);
                $foto_barang=$newname;
                if ($this->upload->do_upload('foto_barang')){
                    if ($_FILES['foto_barang']['size'] < 2000000) {
                        $this->load->library('upload', $config);
                        echo "Image berhasil diupload";
                        // $data->foto_barang=$newname;
                    }else{
                        $gbr = $this->upload->data();
                        
                        $config['image_library']='gd2';
                        $config['source_image']='./assets/images/foto_barang/'.$gbr['file_name'];
                        $config['create_thumb']= FALSE;
                        $config['maintain_ratio']= FALSE;
                        $config['quality']= '50%';
                        $config['width']= 1024;
                        $config['height']= 768;
                        $config['new_image']= './assets/images/foto_barang/'.$newname;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        // $data->foto_barang=$newname;
                        @unlink( $config['source_image'] );
                        echo "Image berhasil resize";
                    }
                }
            }else{
                $foto_barang=$row->foto_barang;
                echo "Image yang diupload kosong";
            }
            $harga=$this->input->post('harga',TRUE);
            $data = array(
        		'nama_barang' => $this->input->post('nama_barang',TRUE),
        		'id_kategori_barang' => $this->input->post('id_kategori_barang',TRUE),
        		'id_satuan_barang' => $this->input->post('id_satuan_barang',TRUE),
        		'harga' => $this->currency($harga),
        		'jenis_barang' => $this->input->post('jenis_barang',TRUE),
        		// 'stok_barang' => $this->input->post('stok_barang',TRUE),
        		'id_klinik' => $this->input->post('id_klinik',TRUE),
                'id_golongan_barang' => $this->input->post('id_golongan_barang'),
                'kode_pabrik' => $this->input->post('kode_pabrik'),
                'minimal_stok' => $this->input->post('minimal_stok'),
                'deskripsi' => $this->input->post('deskripsi'),
                'indikasi' => $this->input->post('indikasi'),
                'kandungan' => $this->input->post('kandungan'),
                'dosis' => $this->input->post('dosis'),
                // 'tipe_barang' => $this->input->post('tipe_barang'),
                'kemasan' => $this->input->post('kemasan'),
                'efek_samping' => $this->input->post('efek_samping'),
                'zat_aktif' => $this->input->post('zat_aktif'),
                // 'tanggal_expired' => $this->input->post('tanggal_expired'),
                'etiket' => $this->input->post('etiket'),
                'foto_barang' => $foto_barang,
                'barcode' => $this->input->post('barcode'),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
	    );
            $this->Tbl_obat_alkes_bhp_model->update($this->input->post('kode_barang', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('dataobat'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_obat_alkes_bhp_model->get_by_id($id);
        $image= './assets/images/foto_barang/'.$row->foto_barang;
        if ($row) {
            if (file_exists($image)) {
                unlink($image);
            }
            $this->Tbl_obat_alkes_bhp_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('dataobat'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('dataobat'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_barang', 'kode_barang', 'trim');
    $this->form_validation->set_rules('nama_barang', 'nama barang', 'trim|required');
    $this->form_validation->set_rules('id_kategori_barang', 'id kategori barang', 'trim|required');
    $this->form_validation->set_rules('id_satuan_barang', 'id satuan barang', 'trim|required');
    $this->form_validation->set_rules('harga', 'harga', 'trim|required');
    $this->form_validation->set_rules('id_klinik', 'klinik', 'trim|required');
    $this->form_validation->set_rules('kode_pabrik', 'kode_barang', 'trim');
    $this->form_validation->set_rules('minimal_stok', 'minimal_stok', 'trim');
    $this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim');
    $this->form_validation->set_rules('indikasi', 'indikasi', 'trim');
    $this->form_validation->set_rules('kandungan', 'kandungan', 'trim');
    $this->form_validation->set_rules('dosis', 'dosis', 'trim');
    // $this->form_validation->set_rules('tipe_barang', 'tipe_barang', 'trim');
    $this->form_validation->set_rules('kemasan', 'kemasan', 'trim');
    $this->form_validation->set_rules('efek_samping', 'efek_samping', 'trim');
    $this->form_validation->set_rules('zat_aktif', 'zat_aktif', 'trim');
    $this->form_validation->set_rules('etiket', 'etiket', 'trim');
    $this->form_validation->set_rules('zat_aktif', 'zat_aktif', 'trim');
    // $this->form_validation->set_rules('tanggal_expired', 'tanggal_expired', 'trim');
    $this->form_validation->set_rules('barcode', 'barcode', 'trim');

	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_obat_alkes_bhp.xls";
        $judul = "tbl_obat_alkes_bhp";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Kategori Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Satuan Barang");
	xlsWriteLabel($tablehead, $kolomhead++, "Harga");

	foreach ($this->Tbl_obat_alkes_bhp_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_barang);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_kategori_barang);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_satuan_barang);
	    xlsWriteNumber($tablebody, $kolombody++, $data->harga);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_obat_alkes_bhp.doc");

        $data = array(
            'tbl_obat_alkes_bhp_data' => $this->Tbl_obat_alkes_bhp_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('dataobat/tbl_obat_alkes_bhp_doc',$data);
    }
    
    public function import_excel(){
        $this->template->load('template','dataobat/import_excel');
        // $this->load->view('dataobat/import_excel');
    }
    
    public function upload(){
        $fileName = time().$_FILES['file']['name'];
         
        $config['upload_path'] = 'assets/import_excel/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('file') )
        $this->upload->display_errors();
             
        // $media = $this->upload->data('file');
        $inputFileName = 'assets/import_excel/'.$fileName;
        
        // echo $media['file_name'];
         
        // try {
        if (is_readable($inputFileName)) {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        }else{
            echo "string";
        }
        // } catch(Exception $e) {
        //     die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        // }
 
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        
        $data_existing = array();
        $error_data = false;
        $error_desc = '';
        $jmlsukses = 0;
        $jmlgagal = 0;
        for ($row = 5; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
            $data=$this->db->where('nama_pegawai', $rowData[0][1])->get('tbl_pegawai')->row();
            $absen=0;
            for ($i=0; $i < count($rowData[0]); $i++) { 
                if($rowData[0][$i] != null){
                    $absen=explode(' ', $rowData[0][$i]);
                }else{
                    $absen=['', ''];
                }
                print_r($absen);
            }
                echo('<br>');

            // for ($i=0; $i < ; $i++) { 
            //     # code...
            // }
            
            //Cek Barang
            // $barang = $this->Tbl_obat_alkes_bhp_model->get_by_id($rowData[0][0]);
            // //Cek Kategori Barang
            // $kategori_barang = $this->Tbl_kategori_barang_model->get_by_id($rowData[0][2]);
            // if($kategori_barang == null){
            //     $error_data = true;
            //     if($error_desc != '')
            //         $error_desc .= ', ';
            //     $error_desc .= 'ID Kategori Barang ' . $rowData[0][2];
            // }
            // //Cek Satuan Barang
            // $satuan_barang = $this->Tbl_satuan_barang_model->get_by_id($rowData[0][3]);
            // if($satuan_barang == null){
            //     $error_data = true;
            //     if($error_desc != '')
            //         $error_desc .= ', ';
            //     $error_desc .= 'ID Satuan Barang ' . $rowData[0][3];   
            // }
            // //Cek Jenis Barang
            // if($rowData[0][5] == 1 || $rowData[0][5] == 2){
            // } else {
            //     $error_data = true;
            //     if($error_desc != '')
            //         $error_desc .= ', ';
            //     $error_desc .= 'Jenis Barang ' . $rowData[0][5];
            // }
            // //Cek Klinik
            // if($rowData[0][7] == 1 || $rowData[0][7] == 2){
            // } else {
            //     $error_data = true;
            //     if($error_desc != '')
            //         $error_desc .= ', ';
            //     $error_desc .= 'ID Klinik ' . $rowData[0][7];
            // }
            
            // if($error_desc != '')
            //     $error_desc .= ' tidak tersedia';
                
            // if($barang == null){
            //     //Jika tidak ada error maka insert
            //     if(!$error_data){
            //         $jmlsukses += 1;
            //         $data = array(
            //             'kode_barang' => $rowData[0][0],
            //             'nama_barang' => $rowData[0][1],
            //             'id_kategori_barang' => $rowData[0][2],
            //             'id_satuan_barang' => $rowData[0][3],
            //             'stok_barang' => $rowData[0][4],
            //             'jenis_barang' => $rowData[0][5],
            //             'harga' => $rowData[0][6],
            //             'id_klinik' => $rowData[0][7]
            //         );
            //         //sesuaikan nama dengan nama tabel
            //         $insert = $this->Tbl_obat_alkes_bhp_model->insert($data);
            //     } else {
            //         $jmlgagal += 1;
            //         $data_existing[] = array(
            //             'kode_barang' => $rowData[0][0],
            //             'nama_barang' => $rowData[0][1],
            //             'id_kategori_barang' => $rowData[0][2],
            //             'id_satuan_barang' => $rowData[0][3],
            //             'stok_barang' => $rowData[0][4],
            //             'jenis_barang' => $rowData[0][5],
            //             'harga' => $rowData[0][6],
            //             'id_klinik' => $rowData[0][7],
            //             'error' => $error_desc
            //         );
            //     }
                     
            // } else {
            //     $jmlgagal += 1;
            //     $data_existing[] = array(
            //         'kode_barang' => $rowData[0][0],
            //         'nama_barang' => $rowData[0][1],
            //         'id_kategori_barang' => $rowData[0][2],
            //         'id_satuan_barang' => $rowData[0][3],
            //         'stok_barang' => $rowData[0][4],
            //         'jenis_barang' => $rowData[0][5],
            //         'harga' => $rowData[0][6],
            //         'id_klinik' => $rowData[0][7],
            //         'error' => 'Kode Barang Sudah Ada'
            //     );
            // }
        }
        exit();
        //Hapus file import
        $this->load->helper("file");
        delete_files($config['upload_path']); 
        
        if(count($data_existing) > 0){
            $data['data_existing'] = $data_existing;
            
            //Set session sukses
            $this->session->set_flashdata('message', 'Import ' . $jmlsukses . ' data sukses');
            $this->session->set_flashdata('message_type', 'success');
            
            //Set session gagal
            $this->session->set_flashdata('message2', 'Import ' . $jmlgagal . ' data gagal');
            $this->session->set_flashdata('message_type2', 'danger');
            
            $this->template->load('template','dataobat/import_excel_existing',$data);
        } else {
            //Set session sukses
            $this->session->set_flashdata('message', 'Import ' . $jmlsukses . ' data sukses');
            $this->session->set_flashdata('message_type', 'success');
            
            redirect('dataobat');
        }
            
        // echo json_encode($data_existing);
            
        // 
    }
    private function currency($val){
        $data=explode('.', $val);
        $new=implode('', $data);
        return $new;
    }

}

/* End of file Dataobat.php */
/* Location: ./application/controllers/Dataobat.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-09 11:24:01 */
/* http://harviacode.com */