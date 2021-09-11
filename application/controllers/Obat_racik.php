<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Obat_racik extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_obat_racikan_model');
        $this->load->model('Tbl_obat_alkes_bhp_model');
        $this->load->model('Tbl_jasa_model');
        $this->load->model('Tbl_kategori_barang_model');
        $this->load->model('Tbl_satuan_barang_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->library('upload');
        $this->id_dokter = $this->session->userdata('id_apoteker');
        $this->id_klinik = $this->session->userdata('id_klinik');
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }
    
    function autocomplate(){
        // autocomplate untuk pencarian obat
        $this->db->like('nama_obat_racikan', $_GET['term']);
        $this->db->select('nama_obat_racikan');
        $products = $this->db->get('tbl_obat_racikan')->result();
        foreach ($products as $product) {
            $return_arr[] = $product->nama_obat_racikan;
        }

        echo json_encode($return_arr);
    }

    public function index()
    {
        $this->template->load('template','dataobat/dataobat_racikan/tbl_obat_racikan_list');
    }
    
     public function json(){
        header('Content-Type: application/json');
        echo $this->Tbl_obat_racikan_model->json();
    }
    public function json_detail_obat($id){
        header('Content-Type: application/json');
        echo $this->Tbl_obat_racikan_model->json_detail_obat($id);
    }
    public function json_detail_jasa($id){
        header('Content-Type: application/json');
        echo $this->Tbl_obat_racikan_model->json_detail_jasa($id);
    }

    public function read($id) 
    {
        $row = $this->Tbl_obat_racikan_model->get_by_id($id);
        if ($row) {
            $data = array(
        		'kode_obat_racikan' => $row->kode_obat_racikan,
        		'nama_obat_racikan' => $row->nama_obat_racikan,
        		'id_kategori_barang' => $row->id_kategori_barang,
        		// 'id_satuan_obat_racikan' => $row->id_satuan_obat_racikan,
        		'harga' => $row->harga,
	           ); 
            $this->template->load('template','dataobat/dataobat_racikan/tbl_obat_racikan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('obat_racik'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('obat_racik/create_action'),
            'kode_obat_racikan' => set_value('kode_obat_racikan'),
            'nama_obat_racikan' => set_value('nama_obat_racikan'),
            'id_kategori_barang' => set_value('id_kategori_barang'),
            // 'foto_obat_racikan' => set_value('foto_obat_racikan'),
    );
        $data['obat_option'] = array();
        $data['obat_option'][''] = 'Pilih Obat';
        $obat_opt_js = array();
        $data['kode_obat_option'] = array();
        $data['kode_obat_option'][''] = 'Pilih Kode Obat';
        $kode_obat_opt_js = array();
        foreach ($this->Tbl_obat_alkes_bhp_model->get_all_obat($this->id_klinik) as $obat){
            $data['obat_option'][$obat->kode_barang] = $obat->nama_barang;
            $data['kode_obat_option'][$obat->kode_barang] = $obat->kode_barang;
            $obat_opt_js[] = array(
                'value' => $obat->kode_barang,
                'label' => $obat->nama_barang
            );
            $kode_obat_opt_js[] = array(
                'value' => $obat->kode_barang,
                'label' => $obat->kode_barang
            );
        }
        $data['obat_option_js'] = json_encode($obat_opt_js);
        $data['kode_obat_option_js'] = json_encode($kode_obat_opt_js);
        $data['obat_all'] = json_encode($this->Tbl_obat_alkes_bhp_model->get_data_obat($this->id_klinik));

        $data['jasa_option'] = array();
        $data['jasa_option'][''] = 'Pilih Jasa';
        $jasa_opt_js = array();
        foreach ($this->Tbl_jasa_model->get_data_jasa($this->id_klinik) as $jasa){
            $data['jasa_option'][$jasa->kode_jasa] = $jasa->nama_jasa;
            $jasa_opt_js[] = array(
                'value' => $jasa->kode_jasa,
                'label' => $jasa->nama_jasa
            );
        }
        $data['jasa_option_js'] = json_encode($jasa_opt_js);
        $data['jasa_all'] = json_encode($this->Tbl_jasa_model->get_data_jasa($this->id_klinik));
        // print_r($data['jasa_all']);
        // exit();
        $this->template->load('template','dataobat/dataobat_racikan/tbl_obat_racikan_form', $data);
    }
    
    public function create_action() 
    {
        $kode_barang=$this->input->post('kode_obat',TRUE);
        $kode_jasa=$this->input->post('kode_jasa',TRUE);
        // var_dump($_POST);
        // exit();
        $this->_rules();
        $kode_obat_racikan='RCK'.time();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {            
            $data = array(
                'kode_obat_racikan'=>$kode_obat_racikan,
                'nama_obat_racikan' => $this->input->post('nama_obat_racikan',TRUE),
                'id_kategori_barang' => $this->input->post('id_kategori_barang',TRUE),
            );

            $this->Tbl_obat_racikan_model->insert($data);
            $id_last=$this->db->select_max('kode_obat_racikan')->get('tbl_obat_racikan')->row();
            // $id=$this->db->insert_id();
            // print_r($id_last->kode_obat_racikan);
            // exit();
            for ($i=0; $i < count($kode_barang); $i++) { 
                $data_obat=array(
                    'kode_obat_racikan'   => $id_last->kode_obat_racikan,
                    'kode_barang'   => $kode_barang[$i],
                );
                $this->Tbl_obat_racikan_model->insert_child('tbl_obat_racikan_child_obat',$data_obat);
            }
            for ($i=0; $i < count($kode_jasa); $i++) { 
                $data_jasa=array(
                    'kode_obat_racikan'   => $id_last->kode_obat_racikan,
                    'kode_jasa'   => $kode_jasa[$i],
                );
                $this->Tbl_obat_racikan_model->insert_child('tbl_obat_racikan_child_jasa',$data_jasa);
            }
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('obat_racik'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_obat_racikan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('obat_racik/update_action'),
        		'kode_obat_racikan' => set_value('kode_obat_racikan', $row->kode_obat_racikan),
        		'nama_obat_racikan' => set_value('nama_obat_racikan', $row->nama_obat_racikan),
        		'id_kategori_barang' => set_value('id_kategori_barang', $row->id_kategori_barang),
        		'id_satuan_obat_racikan' => set_value('id_satuan_obat_racikan', $row->id_satuan_obat_racikan),
        		'jenis_obat_racikan' => set_value('jenis_obat_racikan', $row->jenis_obat_racikan),
    	        'stok_obat_racikan' => set_value('stok_obat_racikan',$row->stok_obat_racikan),
        		'harga' => set_value('harga', $row->harga),
        		'id_klinik' => set_value('id_klinik', $row->id_klinik),
                'kode_pabrik' => set_value('kode_pabrik', $row->kode_pabrik),
                'id_golongan_obat_racikan' => set_value('id_golongan_obat_racikan', $row->id_golongan_obat_racikan),
                'minimal_stok' => set_value('minimal_stok', $row->minimal_stok),
                'deskripsi' => set_value('deskripsi', $row->deskripsi),
                'indikasi' => set_value('indikasi', $row->indikasi),
                'kandungan' => set_value('kandungan', $row->kandungan),
                'dosis' => set_value('dosis', $row->dosis),
                'tipe_obat_racikan' => set_value('tipe_obat_racikan', $row->tipe_obat_racikan),
                'kemasan' => set_value('kemasan', $row->kemasan),
                'efek_samping' => set_value('efek_samping', $row->efek_samping),
                'zat_aktif' => set_value('zat_aktif', $row->zat_aktif),
                'tanggal_expired' => set_value('tanggal_expired', $row->tanggal_expired),
                'etiket' => set_value('etiket', $row->etiket),
                'kode_gudang' => set_value('kode_gudang', $row->kode_gudang),
                'id_lokasi_obat_racikan' => set_value('id_lokasi_obat_racikan', $row->id_lokasi_obat_racikan),
                'foto_obat_racikan' => set_value('foto_obat_racikan', $row->foto_obat_racikan),
	        );
            $this->template->load('template','dataobat/dataobat_racikan/tbl_obat_racikan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('obat_racik'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_obat_racikan', TRUE));
        } else {
            $data=array();
            $foto_obat_racikan=null;
            $row = $this->Tbl_obat_racikan_model->get_by_id($this->input->post('kode_obat_racikan', TRUE));
            if ($_FILES['foto_obat_racikan']['name'] != null) {
                // edit foto
                $image= './assets/images/foto_obat_racikan/'.$row->foto_obat_racikan;
                if (file_exists($image)) {
                    unlink($image);
                }
                $config['upload_path']          = './assets/images/foto_obat_racikan/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
         
                $filename = $_FILES['foto_obat_racikan']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                
                $newname='OBT_'.time().'.'.$ext;
                if ($_FILES['foto_obat_racikan']['size'] < 2000000) {
                        $config['file_name']= $newname;
                }
                $this->upload->initialize($config);
                $foto_obat_racikan=$newname;
                if ($this->upload->do_upload('foto_obat_racikan')){
                    if ($_FILES['foto_obat_racikan']['size'] < 2000000) {
                        $this->load->library('upload', $config);
                        echo "Image berhasil diupload";
                        // $data->foto_obat_racikan=$newname;
                    }else{
                        $gbr = $this->upload->data();
                        
                        $config['image_library']='gd2';
                        $config['source_image']='./assets/images/foto_obat_racikan/'.$gbr['file_name'];
                        $config['create_thumb']= FALSE;
                        $config['maintain_ratio']= FALSE;
                        $config['quality']= '50%';
                        $config['width']= 1024;
                        $config['height']= 768;
                        $config['new_image']= './assets/images/foto_obat_racikan/'.$newname;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        // $data->foto_obat_racikan=$newname;
                        @unlink( $config['source_image'] );
                        echo "Image berhasil resize";
                    }
                }
            }else{
                $foto_obat_racikan=$row->foto_obat_racikan;
                echo "Image yang diupload kosong";
            }
            $data = array(
        		'nama_obat_racikan' => $this->input->post('nama_obat_racikan',TRUE),
        		'id_kategori_barang' => $this->input->post('id_kategori_barang',TRUE),
        		'id_satuan_obat_racikan' => $this->input->post('id_satuan_obat_racikan',TRUE),
        		'harga' => $this->input->post('harga',TRUE),
        		'jenis_obat_racikan' => $this->input->post('jenis_obat_racikan',TRUE),
        		'stok_obat_racikan' => $this->input->post('stok_obat_racikan',TRUE),
        		'id_klinik' => $this->input->post('id_klinik',TRUE),
                'id_golongan_obat_racikan' => $this->input->post('id_golongan_obat_racikan'),
                'kode_pabrik' => $this->input->post('kode_pabrik'),
                'minimal_stok' => $this->input->post('minimal_stok'),
                'deskripsi' => $this->input->post('deskripsi'),
                'indikasi' => $this->input->post('indikasi'),
                'kandungan' => $this->input->post('kandungan'),
                'dosis' => $this->input->post('dosis'),
                'tipe_obat_racikan' => $this->input->post('tipe_obat_racikan'),
                'kemasan' => $this->input->post('kemasan'),
                'efek_samping' => $this->input->post('efek_samping'),
                'zat_aktif' => $this->input->post('zat_aktif'),
                'tanggal_expired' => $this->input->post('tanggal_expired'),
                'etiket' => $this->input->post('etiket'),
                'kode_gudang' => $this->input->post('kode_gudang'),
                'id_lokasi_obat_racikan' => $this->input->post('id_lokasi_obat_racikan'),
                'foto_obat_racikan' => $foto_obat_racikan,
                'dtm_upd' => date("Y-m-d H:i:s",  time())
	    );
            $this->Tbl_obat_racikan_model->update($this->input->post('kode_obat_racikan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('obat_racik'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_obat_racikan_model->get_by_id($id);
        $image= './assets/images/foto_obat_racikan/'.$row->foto_obat_racikan;
        if ($row) {
            if (file_exists($image)) {
                unlink($image);
            }
            $this->Tbl_obat_racikan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('obat_racik'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('obat_racik'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_obat_racikan', 'kode_obat_racikan', 'trim');
    $this->form_validation->set_rules('nama_obat_racikan', 'nama obat_racikan', 'trim|required');
    $this->form_validation->set_rules('id_kategori_barang', 'id kategori obat_racikan', 'trim|required');
    // $this->form_validation->set_rules('id_satuan_obat_racikan', 'id satuan obat_racikan', 'trim|required');
    // $this->form_validation->set_rules('harga', 'harga', 'trim|required');
    // $this->form_validation->set_rules('id_klinik', 'klinik', 'trim|required');
    // $this->form_validation->set_rules('kode_pabrik', 'kode_obat_racikan', 'trim');
    // $this->form_validation->set_rules('minimal_stok', 'minimal_stok', 'trim');
    // $this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim');
    // $this->form_validation->set_rules('indikasi', 'indikasi', 'trim');
    // $this->form_validation->set_rules('kandungan', 'kandungan', 'trim');
    // $this->form_validation->set_rules('dosis', 'dosis', 'trim');
    // $this->form_validation->set_rules('tipe_obat_racikan', 'tipe_obat_racikan', 'trim');
    // $this->form_validation->set_rules('kemasan', 'kemasan', 'trim');
    // $this->form_validation->set_rules('efek_samping', 'efek_samping', 'trim');
    // $this->form_validation->set_rules('zat_aktif', 'zat_aktif', 'trim');
    // $this->form_validation->set_rules('etiket', 'etiket', 'trim');
    // $this->form_validation->set_rules('zat_aktif', 'zat_aktif', 'trim');
    // $this->form_validation->set_rules('tanggal_expired', 'tanggal_expired', 'trim');
    // $this->form_validation->set_rules('kode_gudang', 'kode_gudang', 'trim|required');
    // $this->form_validation->set_rules('id_lokasi_obat_racikan', 'id_lokasi_obat_racikan', 'trim|required');

	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_obat_racikan.xls";
        $judul = "tbl_obat_racikan";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama obat_racikan");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Kategori obat_racikan");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Satuan obat_racikan");
	xlsWriteLabel($tablehead, $kolomhead++, "Harga");

	foreach ($this->Tbl_obat_racikan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_obat_racikan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_kategori_barang);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_satuan_obat_racikan);
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
        header("Content-Disposition: attachment;Filename=tbl_obat_racikan.doc");

        $data = array(
            'tbl_obat_racikan_data' => $this->Tbl_obat_racikan_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('dataobat/tbl_obat_racikan_doc',$data);
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
         
        try {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
 
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        
        $data_existing = array();
        $error_data = false;
        $error_desc = '';
        $jmlsukses = 0;
        $jmlgagal = 0;
        for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
                                                 
            //Cek obat_racikan
            $obat_racikan = $this->Tbl_obat_racikan_model->get_by_id($rowData[0][0]);
            //Cek Kategori obat_racikan
            $kategori_obat_racikan = $this->Tbl_kategori_obat_racikan_model->get_by_id($rowData[0][2]);
            if($kategori_obat_racikan == null){
                $error_data = true;
                if($error_desc != '')
                    $error_desc .= ', ';
                $error_desc .= 'ID Kategori obat_racikan ' . $rowData[0][2];
            }
            //Cek Satuan obat_racikan
            $satuan_obat_racikan = $this->Tbl_satuan_obat_racikan_model->get_by_id($rowData[0][3]);
            if($satuan_obat_racikan == null){
                $error_data = true;
                if($error_desc != '')
                    $error_desc .= ', ';
                $error_desc .= 'ID Satuan obat_racikan ' . $rowData[0][3];   
            }
            //Cek Jenis obat_racikan
            if($rowData[0][5] == 1 || $rowData[0][5] == 2){
            } else {
                $error_data = true;
                if($error_desc != '')
                    $error_desc .= ', ';
                $error_desc .= 'Jenis obat_racikan ' . $rowData[0][5];
            }
            //Cek Klinik
            if($rowData[0][7] == 1 || $rowData[0][7] == 2){
            } else {
                $error_data = true;
                if($error_desc != '')
                    $error_desc .= ', ';
                $error_desc .= 'ID Klinik ' . $rowData[0][7];
            }
            
            if($error_desc != '')
                $error_desc .= ' tidak tersedia';
                
            if($obat_racikan == null){
                //Jika tidak ada error maka insert
                if(!$error_data){
                    $jmlsukses += 1;
                    $data = array(
                        'kode_obat_racikan' => $rowData[0][0],
                        'nama_obat_racikan' => $rowData[0][1],
                        'id_kategori_barang' => $rowData[0][2],
                        'id_satuan_obat_racikan' => $rowData[0][3],
                        'stok_obat_racikan' => $rowData[0][4],
                        'jenis_obat_racikan' => $rowData[0][5],
                        'harga' => $rowData[0][6],
                        'id_klinik' => $rowData[0][7]
                    );
                    //sesuaikan nama dengan nama tabel
                    $insert = $this->Tbl_obat_racikan_model->insert($data);
                } else {
                    $jmlgagal += 1;
                    $data_existing[] = array(
                        'kode_obat_racikan' => $rowData[0][0],
                        'nama_obat_racikan' => $rowData[0][1],
                        'id_kategori_barang' => $rowData[0][2],
                        'id_satuan_obat_racikan' => $rowData[0][3],
                        'stok_obat_racikan' => $rowData[0][4],
                        'jenis_obat_racikan' => $rowData[0][5],
                        'harga' => $rowData[0][6],
                        'id_klinik' => $rowData[0][7],
                        'error' => $error_desc
                    );
                }
                     
            } else {
                $jmlgagal += 1;
                $data_existing[] = array(
                    'kode_obat_racikan' => $rowData[0][0],
                    'nama_obat_racikan' => $rowData[0][1],
                    'id_kategori_barang' => $rowData[0][2],
                    'id_satuan_obat_racikan' => $rowData[0][3],
                    'stok_obat_racikan' => $rowData[0][4],
                    'jenis_obat_racikan' => $rowData[0][5],
                    'harga' => $rowData[0][6],
                    'id_klinik' => $rowData[0][7],
                    'error' => 'Kode obat_racikan Sudah Ada'
                );
            }
        }
        
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
    
    // private function get_klinik_by_id

}

/* End of file Dataobat.php */
/* Location: ./application/controllers/Dataobat.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-09 11:24:01 */
/* http://harviacode.com */