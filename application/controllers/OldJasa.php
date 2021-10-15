<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jasa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_jasa_model');
        $this->load->model('Tbl_kategori_barang_model');
        $this->load->model('Tbl_satuan_barang_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->library('upload');
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }
    
    function autocomplate(){
        // autocomplate untuk pencarian obat
        $this->db->like('nama_jasa', $_GET['term']);
        $this->db->select('nama_jasa');
        $products = $this->db->get('tbl_jasa')->result();
        foreach ($products as $product) {
            $return_arr[] = $product->nama_jasa;
        }

        echo json_encode($return_arr);
    }

    public function index()
    {
        $this->template->load('template','master_data/jasa/tbl_jasa_list');
    }
    
     public function json(){
        header('Content-Type: application/json');
        echo $this->Tbl_jasa_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_jasa_model->get_by_id($id);
        if ($row) {
            $data = array(
		'kode_jasa' => $row->kode_jasa,
		'nama_jasa' => $row->nama_jasa,
		'id_kategori_barang' => $row->id_kategori_barang,
		'id_satuan_barang' => $row->id_satuan_barang,
		'harga' => $row->harga,
	    );
            $this->template->load('template','master_data/jasa/tbl_jasa_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jasa'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('jasa/create_action'),
    	    'kode_jasa' => set_value('kode_jasa'),
    	    'nama_jasa' => set_value('nama_jasa'),
    	    'id_kategori_barang' => set_value('id_kategori_barang'),
    	    'id_satuan_barang' => set_value('id_satuan_barang'),
            'harga' => set_value('harga'),
            'hna' => set_value('hna'),
            'barcode_jasa' => set_value('barcode_jasa'),
            'foto_jasa' => set_value('foto_jasa'),
            'id_klinik' => set_value('id_klinik'),
	);
        $this->template->load('template','master_data/jasa/tbl_jasa_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();
        
        $kode_jasa='JSA'.time();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $foto_jasa=null;
            if ($_FILES['foto_jasa']['name'] != null) {
                $config['upload_path']          = './assets/images/foto_jasa/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
         
                $filename = $_FILES['foto_jasa']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                
                $newname='OBT_'.time().'.'.$ext;
                if ($_FILES['foto_jasa']['size'] < 2000000) {
                        $config['file_name']= $newname;
                }
                $this->upload->initialize($config);
                $foto_jasa=$newname;
                if ($this->upload->do_upload('foto_jasa')){
                    if ($_FILES['foto_jasa']['size'] < 2000000) {
                        $this->load->library('upload', $config);
                        echo "Image berhasil diupload";
                        // $data->foto_jasa=$newname;
                    }else{
                        $gbr = $this->upload->data();
                        
                        $config['image_library']='gd2';
                        $config['source_image']='./assets/images/foto_jasa/'.$gbr['file_name'];
                        $config['create_thumb']= FALSE;
                        $config['maintain_ratio']= FALSE;
                        $config['quality']= '50%';
                        $config['width']= 1024;
                        $config['height']= 768;
                        $config['new_image']= './assets/images/foto_jasa/'.$newname;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        // $data->foto_jasa=$newname;
                        @unlink( $config['source_image'] );
                        echo "Image berhasil resize";
                    }
                }
            }else{
                $foto_jasa=null;
                echo "Image yang diupload kosong";
            }
            $data = array(
                'kode_jasa'=>$kode_jasa,
        		'nama_jasa' => $this->input->post('nama_jasa',TRUE),
        		'id_kategori_barang' => $this->input->post('id_kategori_barang',TRUE),
        		'id_satuan_barang' => $this->input->post('id_satuan_barang',TRUE),
        		'harga' => $this->input->post('harga',TRUE),
                'hna' => $this->input->post('hna'),
                'foto_jasa' => $foto_jasa,
                'id_klinik' => $this->input->post('id_klinik',TRUE),
                'barcode_jasa' => $this->input->post('barcode_jasa',TRUE),
	    );

            $this->Tbl_jasa_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('jasa'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_jasa_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('jasa/update_action'),
        		'kode_jasa' => set_value('kode_jasa', $row->kode_jasa),
        		'nama_jasa' => set_value('nama_jasa', $row->nama_jasa),
        		'id_kategori_barang' => set_value('id_kategori_barang', $row->id_kategori_barang),
        		'id_satuan_barang' => set_value('id_satuan_barang', $row->id_satuan_barang),
        		'barcode_jasa' => set_value('barcode_jasa', $row->barcode_jasa),
                'harga' => set_value('harga', $row->harga),
                'hna' => set_value('hna', $row->hna),
                'id_klinik' => set_value('id_klinik', $row->id_klinik),
                'foto_jasa' => set_value('foto_jasa', $row->foto_jasa),
	        );
            $this->template->load('template','master_data/jasa/tbl_jasa_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jasa'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('kode_jasa', TRUE));
        } else {
            $data=array();
            $foto_jasa=null;
            $row = $this->Tbl_jasa_model->get_by_id($this->input->post('kode_jasa', TRUE));
            if ($_FILES['foto_jasa']['name'] != null) {
                // edit foto
                $image= './assets/images/foto_jasa/'.$row->foto_jasa;
                if (file_exists($image)) {
                    unlink($image);
                }
                $config['upload_path']          = './assets/images/foto_jasa/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
         
                $filename = $_FILES['foto_jasa']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                
                $newname='OBT_'.time().'.'.$ext;
                if ($_FILES['foto_jasa']['size'] < 2000000) {
                        $config['file_name']= $newname;
                }
                $this->upload->initialize($config);
                $foto_jasa=$newname;
                if ($this->upload->do_upload('foto_jasa')){
                    if ($_FILES['foto_jasa']['size'] < 2000000) {
                        $this->load->library('upload', $config);
                        echo "Image berhasil diupload";
                        // $data->foto_jasa=$newname;
                    }else{
                        $gbr = $this->upload->data();
                        
                        $config['image_library']='gd2';
                        $config['source_image']='./assets/images/foto_jasa/'.$gbr['file_name'];
                        $config['create_thumb']= FALSE;
                        $config['maintain_ratio']= FALSE;
                        $config['quality']= '50%';
                        $config['width']= 1024;
                        $config['height']= 768;
                        $config['new_image']= './assets/images/foto_jasa/'.$newname;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();
                        // $data->foto_jasa=$newname;
                        @unlink( $config['source_image'] );
                        echo "Image berhasil resize";
                    }
                }
            }else{
                $foto_jasa=$row->foto_jasa;
                echo "Image yang diupload kosong";
            }
            $data = array(
        		'nama_jasa' => $this->input->post('nama_jasa',TRUE),
        		'id_kategori_barang' => $this->input->post('id_kategori_barang',TRUE),
        		'id_satuan_barang' => $this->input->post('id_satuan_barang',TRUE),
                'harga' => $this->input->post('harga',TRUE),
                'hna' => $this->input->post('hna'),
                'barcode_jasa' => $this->input->post('barcode_jasa',TRUE),
                'foto_jasa' => $foto_jasa,
                'id_klinik' => $this->input->post('id_klinik',TRUE),
                'dtm_upd' => date("Y-m-d H:i:s",  time())
	    );
            $this->Tbl_jasa_model->update($this->input->post('kode_jasa', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('jasa'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_jasa_model->get_by_id($id);
        $image= './assets/images/foto_jasa/'.$row->foto_jasa;
        if ($row) {
            if (file_exists($image)) {
                unlink($image);
            }
            $this->Tbl_jasa_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('jasa'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('jasa'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_jasa', 'kode_jasa', 'trim');
    $this->form_validation->set_rules('nama_jasa', 'nama barang', 'trim|required');
    $this->form_validation->set_rules('id_kategori_barang', 'id kategori barang', 'trim|required');
    $this->form_validation->set_rules('id_satuan_barang', 'id satuan barang', 'trim|required');
    $this->form_validation->set_rules('harga', 'harga', 'trim|required');
    $this->form_validation->set_rules('hna', 'hna', 'trim|required');
    $this->form_validation->set_rules('barcode_jasa', 'barcode_jasa', 'trim|required');
    $this->form_validation->set_rules('id_klinik', 'id_klinik', 'trim|required');

	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_jasa.xls";
        $judul = "tbl_jasa";
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

	foreach ($this->Tbl_jasa_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_jasa);
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
        header("Content-Disposition: attachment;Filename=tbl_jasa.doc");

        $data = array(
            'tbl_jasa_data' => $this->Tbl_jasa_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('jasa/tbl_jasa_doc',$data);
    }
    
    public function import_excel(){
        $this->template->load('template','jasa/import_excel');
        // $this->load->view('jasa/import_excel');
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
                                                 
            //Cek Barang
            $barang = $this->Tbl_jasa_model->get_by_id($rowData[0][0]);
            //Cek Kategori Barang
            $kategori_barang = $this->Tbl_kategori_barang_model->get_by_id($rowData[0][2]);
            if($kategori_barang == null){
                $error_data = true;
                if($error_desc != '')
                    $error_desc .= ', ';
                $error_desc .= 'ID Kategori Barang ' . $rowData[0][2];
            }
            //Cek Satuan Barang
            $satuan_barang = $this->Tbl_satuan_barang_model->get_by_id($rowData[0][3]);
            if($satuan_barang == null){
                $error_data = true;
                if($error_desc != '')
                    $error_desc .= ', ';
                $error_desc .= 'ID Satuan Barang ' . $rowData[0][3];   
            }
            //Cek Jenis Barang
            if($rowData[0][5] == 1 || $rowData[0][5] == 2){
            } else {
                $error_data = true;
                if($error_desc != '')
                    $error_desc .= ', ';
                $error_desc .= 'Jenis Barang ' . $rowData[0][5];
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
                
            if($barang == null){
                //Jika tidak ada error maka insert
                if(!$error_data){
                    $jmlsukses += 1;
                    $data = array(
                        'kode_jasa' => $rowData[0][0],
                        'nama_jasa' => $rowData[0][1],
                        'id_kategori_barang' => $rowData[0][2],
                        'id_satuan_barang' => $rowData[0][3],
                        'stok_barang' => $rowData[0][4],
                        'barcode_jasa' => $rowData[0][5],
                        'harga' => $rowData[0][6],
                        'id_klinik' => $rowData[0][7]
                    );
                    //sesuaikan nama dengan nama tabel
                    $insert = $this->Tbl_jasa_model->insert($data);
                } else {
                    $jmlgagal += 1;
                    $data_existing[] = array(
                        'kode_jasa' => $rowData[0][0],
                        'nama_jasa' => $rowData[0][1],
                        'id_kategori_barang' => $rowData[0][2],
                        'id_satuan_barang' => $rowData[0][3],
                        'stok_barang' => $rowData[0][4],
                        'barcode_jasa' => $rowData[0][5],
                        'harga' => $rowData[0][6],
                        'id_klinik' => $rowData[0][7],
                        'error' => $error_desc
                    );
                }
                     
            } else {
                $jmlgagal += 1;
                $data_existing[] = array(
                    'kode_jasa' => $rowData[0][0],
                    'nama_jasa' => $rowData[0][1],
                    'id_kategori_barang' => $rowData[0][2],
                    'id_satuan_barang' => $rowData[0][3],
                    'stok_barang' => $rowData[0][4],
                    'barcode_jasa' => $rowData[0][5],
                    'harga' => $rowData[0][6],
                    'id_klinik' => $rowData[0][7],
                    'error' => 'Kode Barang Sudah Ada'
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
            
            $this->template->load('template','jasa/import_excel_existing',$data);
        } else {
            //Set session sukses
            $this->session->set_flashdata('message', 'Import ' . $jmlsukses . ' data sukses');
            $this->session->set_flashdata('message_type', 'success');
            
            redirect('jasa');
        }
            
        // echo json_encode($data_existing);
            
        // 
    }
    
    // private function get_klinik_by_id

}

/* End of file jasa.php */
/* Location: ./application/controllers/jasa.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-09 11:24:01 */
/* http://harviacode.com */