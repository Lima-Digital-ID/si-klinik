<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Periksamedis extends CI_Controller
{
    
    public $id_dokter;
    public $id_klinik;
    public $no_pendaftaran;
    public $master_ref_code_anamnesi = 'ANAMNESI';
    public $master_ref_code_alergiobat = 'ALERGIOBAT';
    public $master_ref_code_diagnosa = 'DIAGNOSA';
    public $master_ref_code_tindakan = 'TINDAKAN';
    public $master_ref_code_anjuranobat = 'ANJURANOBAT';
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Pendaftaran_model');
		$this->load->model('Tbl_pasien_model');
		$this->load->model('Tbl_obat_alkes_bhp_model');
        $this->load->model('akuntansi/Transaksi_akuntansi_model');
// 		$this->load->model('Tbl_tindakan_model');
        $this->load->model('Transaksi_obat_model');
		$this->load->model('Periksa_model');
		$this->load->model('Transaksi_model');
		$this->load->model('Tbl_dokter_model');
		$this->load->model('Master_reference_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->model('Master_sequence_model');
        
        $this->id_dokter = $this->session->userdata('id_dokter');
        $this->id_klinik = $this->session->userdata('id_klinik');
        $dokter = $this->Tbl_dokter_model->get_by_id($this->id_dokter);
        $this->no_pendaftaran = $dokter != null ? $dokter->no_pendaftaran : null;
    }

    public function index()
    {
        if($this->no_pendaftaran == null){
            $this->session->set_flashdata('message', 'Tidak ada pemeriksaan, silahkan pilih di Daftar Antrian');
            $this->session->set_flashdata('message_type', 'danger');
            redirect(site_url('periksamedis/antrian'));
        }
            
        $this->_rules();
        $data_pendaftaran = $this->Pendaftaran_model->get_by_id($this->no_pendaftaran);
        $data_pasien = $this->Tbl_pasien_model->get_by_id($data_pendaftaran->no_rekam_medis);
        $date_now = date('Ymd', time());
        $data_antrian = $this->Pendaftaran_model->get_next_antrian($this->id_dokter);
        
        if ($this->form_validation->run() == TRUE) {
                        
            $obat_detail_value = '';
            $obat_detail = $this->input->post('obat');
            if($obat_detail != null){
                for($i=0;$i<count($obat_detail);$i++){
                    if($obat_detail[$i] != '') {
                        $nama_obat = $this->Tbl_obat_alkes_bhp_model->get_by_id($obat_detail[$i])->nama_barang;
                        
                        $obat_detail_value .= $nama_obat . ', ';
                    }
                }
            }
            $data_periksa = array(
                'no_periksa' => $this->input->post('no_periksa'),
                'no_pendaftaran' => $data_pendaftaran->no_pendaftaran,
                'no_rekam_medis' => $data_pendaftaran->no_rekam_medis,
                'anamnesi' => rtrim($this->input->post('anamnesi'),", "),
                'diagnosa' => rtrim($this->input->post('diagnosa'),", "),
                'tindakan' => rtrim($this->input->post('tindakan'),", "),
                'is_surat_ket_sakit' => $this->input->post('is_cetak_surat') != null ? $this->input->post('is_cetak_surat') : 0,
                'tujuan_surat' => $this->input->post('is_cetak_surat') == 1 ? $this->input->post('tujuan_surat') : '',
                'tanggal_mulai' => $this->input->post('is_cetak_surat') == 1 ? $this->input->post('tanggal_mulai') : null,
                'lama_istirahat_surat' => $this->input->post('is_cetak_surat') == 1 ? $this->input->post('lama_istirahat_surat') : 0,
                'id_dokter' => $this->id_dokter,
                'note_dokter' => $this->input->post('note_dokter'),
                'obat_detail' => rtrim($obat_detail_value,", "),
            );
            
            $post_alkes = $this->input->post('alat_kesehatan');
            $post_alkes_jml = $this->input->post('jml_alat_kesehatan');
            $data_periksa_d_alkes = array();
            
            if($post_alkes != null){
                for($i = 0; $i < count; $i++){
                    if($post_alkes[$i] != null || $post_alkes[$i] != ''){
                        $data_periksa_d_alkes[] = array(
                            'no_periksa' => $this->input->post('no_periksa'),
                            'kode_barang' => $post_alkes[$i],
                            'jumlah' => $post_alkes_jml[$i],
                        );
                        
                        //Update stok alkes
                        // $kode_barang = $post_alkes[$i];
                        // $alkes = $this->Tbl_obat_alkes_bhp_model->get_by_id($kode_barang);
                        // $stok_sekarang = $alkes->stok_barang;
                        // $stok_sisa = $stok_sekarang - $post_alkes_jml[$i];
                        // $this->Tbl_obat_alkes_bhp_model->update($kode_barang,
                        //     array(
                        //         'stok_barang' => $stok_sisa
                        //     )
                        // );
                    }
                }
            }
            //input inventory barang
            $kode_receipt='RCP'.time();
            $data = array(
                    'id_inventory'  => $kode_receipt,
                    'inv_type'      => 'TRX_STUFF',
                    'id_klinik'     => $this->id_klinik,
            );
            
            $insert=$this->Transaksi_obat_model->insert('tbl_inventory',$data);
            $dataobat = array();
            foreach ($this->Tbl_obat_alkes_bhp_model->get_all_obat($this->id_klinik) as $obat){
                $dataobat[] = array(
                    'id' => $obat->kode_barang,
                    'harga' => $obat->harga,
                    'diskon' => $obat->diskon,
                    'tgl_exp' => $obat->tgl_exp,
                );
            }

            $post_obat = $this->input->post('obat');
            $post_obat_jml = $this->input->post('jml_obat');
            $post_obat_anjuran = $this->input->post('anjuran_obat');
            $post_obat_ket = $this->input->post('ket_obat');
            $post_obat_penggunaan = $this->input->post('kegunaan_obat');
            $total_jual=0;
            for ($i=0; $i < count($post_obat); $i++) { 
                    $harga_obat=$tgl_exp=$diskon=0;
                    $kode_barang=$post_obat[$i];
                    for ($j=0; $j < count($dataobat); $j++) { 
                        if ($kode_barang == $dataobat[$j]['id']) {
                            $harga_obat=$dataobat[$j]['harga'];
                            $diskon=$dataobat[$j]['diskon'];
                            $tgl_exp=$dataobat[$j]['tgl_exp'];
                        }
                    }
                    $data_detail=array();
                    $data_detail=array(
                        'id_inventory' => $kode_receipt,
                        'kode_barang' => $kode_barang,
                        'jumlah' => $post_obat_jml[$i],
                        'harga' => $harga_obat,
                        'diskon' => $diskon,
                        'tgl_exp' => $tgl_exp,
                    );
                    $harga=$harga_obat-$diskon;
                    $total=$post_obat_jml[$i]*$harga;
                    $total_jual+=$total;
                    $insert=$this->Transaksi_obat_model->insert('tbl_inventory_detail',$data_detail);
            }
            $no_periksa=$this->input->post('no_periksa');
            $grand_total_obat=$this->input->post('grandtotal_harga');
            $subsidi_obat=$this->input->post('subsidi_harga');
            $total_jual_obat=$this->input->post('total_harga');

            $this->jurnal_otomatis_obat($total_jual_obat, $subsidi_obat, $grand_total_obat, $no_periksa, $total_jual);//jurnal otomatis akuntansi untuk pendapatan

            // $biaya_pemeriksaan=$this->input->post('biaya_pemeriksaan');
            // $biaya_tindakan=$this->input->post('biaya_tindakan');
            // $this->jurnal_otomatis_pemeriksaan($biaya_tindakan, $biaya_pemeriksaan, $no_periksa);//jurnal otomatis akuntansi untuk pendapatan pemeriksaan
            // $this->jurnal_otomatis(39, $total_jual);

            $data_periksa_d_obat = array();
            for($i = 0; $i < count($post_obat); $i++){
                if($post_obat[$i] != null || $post_obat[$i] != ''){
                    $data_periksa_d_obat[] = array(
                        'no_periksa' => $this->input->post('no_periksa'),
                        'kode_barang' => $post_obat[$i],
                        'jumlah' => $post_obat_jml[$i],
                        'anjuran' => $post_obat_anjuran[$i],
                        'keterangan' => $post_obat_ket[$i],
                        'penggunaan_obat' => $post_obat_penggunaan[$i]
                    );
                }
            }
            
            $post_cek_fisik = $this->input->post('cek_fisik');
            $post_cek_fisik_value = $this->input->post('cek_fisik_value');
            $data_periksa_d_fisik = array(
                array(
                    'no_periksa' => $this->input->post('no_periksa'),
                    'nama_periksa_fisik' => 'Berat Badan',
                    'nilai_periksa_fisik' => $this->input->post('berat_badan'),
                ),
                array(
                    'no_periksa' => $this->input->post('no_periksa'),
                    'nama_periksa_fisik' => 'Tinggi Badan',
                    'nilai_periksa_fisik' => $this->input->post('tinggi_badan'),
                ),
                array(
                    'no_periksa' => $this->input->post('no_periksa'),
                    'nama_periksa_fisik' => 'Tekanan Darah',
                    'nilai_periksa_fisik' => $this->input->post('tekanan_darah'),
                ),
                array(
                    'no_periksa' => $this->input->post('no_periksa'),
                    'nama_periksa_fisik' => 'Suhu Tubuh',
                    'nilai_periksa_fisik' => $this->input->post('suhu_tubuh'),
                ),
            );
            for($i = 0; $i < count($post_cek_fisik); $i++){
                if($post_cek_fisik[$i] != null || $post_cek_fisik[$i] != ''){
                    $data_periksa_d_fisik[] = array(
                        'no_periksa' => $this->input->post('no_periksa'),
                        'nama_periksa_fisik' => $post_cek_fisik[$i],
                        'nilai_periksa_fisik' => $post_cek_fisik_value[$i],
                    );
                }
            }
            
            //Insert into tbl_periksa
            $this->Periksa_model->insert($data_periksa, $data_periksa_d_alkes, $data_periksa_d_obat, $data_periksa_d_fisik);
            
            //TRANSAKSI
            $date_now_trx = date('Y-m-d', time());
            $data_transkasi = array(
                'kode_transaksi' => 'PRKS',
                'id_klinik' => $data_pendaftaran->id_klinik,
                'no_transaksi' => $this->input->post('no_periksa'),
                'tgl_transaksi' => $date_now_trx,
                'status_transaksi' => 0,
            );
            
            $data_transaksi_d = array(
                array(
                    'no_transaksi' => $this->input->post('no_periksa'),
                    'deskripsi' => 'Total Obat-obatan',
                    'amount_transaksi' => $this->input->post('total_harga'),
                    'dc' => 'd'
                ),
                array(
                    'no_transaksi' => $this->input->post('no_periksa'),
                    'deskripsi' => 'Subsidi Obat-obatan',
                    'amount_transaksi' => $this->input->post('ket_obat_obatan') == 0 ? ($this->input->post('subsidi_harga') != '' ? $this->input->post('subsidi_harga') : 0) : $this->input->post('total_harga'),
                    'dc' => 'c'
                ),
                array(
                    'no_transaksi' => $this->input->post('no_periksa'),
                    'deskripsi' => 'Biaya Pemeriksaan',
                    'amount_transaksi' => $this->input->post('biaya_pemeriksaan') != '' ? $this->input->post('biaya_pemeriksaan') : 0,
                    'dc' => 'd'
                ),
                array(
                    'no_transaksi' => $this->input->post('no_periksa'),
                    'deskripsi' => 'Biaya Tindakan',
                    'amount_transaksi' => $this->input->post('biaya_tindakan') != '' ? $this->input->post('biaya_tindakan') : 0,
                    'dc' => 'd'
                ),
                // array(
                //     'no_transaksi' => $this->input->post('no_periksa'),
                //     'deskripsi' => 'Biaya Administrasi',
                //     'amount_transaksi' => $this->input->post('biaya_administrasi') != '' ? $this->input->post('biaya_administrasi') : 0,
                //     'dc' => 'd'
                // ),
            );
            
            //Insert into tbl_transaksi
            $this->Transaksi_model->insert($data_transkasi,$data_transaksi_d);
            
            //Set status pendaftaran is_periksa = 1
            $this->Pendaftaran_model->update($this->no_pendaftaran, array(
                'is_periksa' => 1,
                'dtm_upd' => date("Y-m-d H:i:s",  time())
            ));
            
            //Set Riwayat Alergi Obat Pasien
            $pasien = $this->Tbl_pasien_model->get_by_id($data_pendaftaran->no_rekam_medis);
            if($pasien != null){
                $this->Tbl_pasien_model->update($data_pendaftaran->no_rekam_medis, array(
                    'riwayat_alergi_obat' => $this->input->post('riwayat_alergi_obat'),
                    'dtm_upd' => date("Y-m-d H:i:s",  time())
                ));
            }
                
            //Get Next Antrian
            $data_antrian = $this->Pendaftaran_model->get_next_antrian($this->id_dokter);
            $next_antrian = $data_antrian != null ? $data_antrian->no_pendaftaran : null;
            $this->Tbl_dokter_model->update($this->id_dokter, array(
                "no_pendaftaran" => $next_antrian,
                "dtm_upd" => date("Y-m-d H:i:s",  time())
            ));
            
            //Insert Master Ref Anamnesi
            $master_ref_anamnesi = $this->split_string($this->input->post('anamnesi'), ',');
            for($i=0;$i<count($master_ref_anamnesi);$i++){
                $master_ref = $this->Master_reference_model->get_by_value($master_ref_anamnesi[$i]['value'],$this->master_ref_code_anamnesi);
                if($master_ref == null){
                    $this->Master_reference_model->insert(array(
                        'master_ref_code' => $this->master_ref_code_anamnesi,
                        'master_ref_value' => $master_ref_anamnesi[$i]['value'],
                        'master_ref_name' => $master_ref_anamnesi[$i]['name']
                    ));
                }
            }
            //Insert Master Ref Alergi Obat
            $master_ref_alergiobat = $this->split_string($this->input->post('riwayat_alergi_obat'), ',');
            for($i=0;$i<count($master_ref_alergiobat);$i++){
                $master_ref = $this->Master_reference_model->get_by_value($master_ref_alergiobat[$i]['value'],$this->master_ref_code_alergiobat);
                if($master_ref == null){
                    $this->Master_reference_model->insert(array(
                        'master_ref_code' => $this->master_ref_code_alergiobat,
                        'master_ref_value' => $master_ref_alergiobat[$i]['value'],
                        'master_ref_name' => $master_ref_alergiobat[$i]['name']
                    ));
                }
            }
            //Insert Master Ref Diagnosa
            $master_ref_diagnosa = $this->split_string($this->input->post('diagnosa'), ',');
            for($i=0;$i<count($master_ref_diagnosa);$i++){
                $master_ref = $this->Master_reference_model->get_by_value($master_ref_diagnosa[$i]['value'],$this->master_ref_code_diagnosa);
                if($master_ref == null){
                    $this->Master_reference_model->insert(array(
                        'master_ref_code' => $this->master_ref_code_diagnosa,
                        'master_ref_value' => $master_ref_diagnosa[$i]['value'],
                        'master_ref_name' => $master_ref_diagnosa[$i]['name']
                    ));
                }
            }
            //Insert Master Ref Tindakan
            $master_ref_tindakan = $this->split_string($this->input->post('tindakan'), ',');
            for($i=0;$i<count($master_ref_tindakan);$i++){
                $master_ref = $this->Master_reference_model->get_by_value($master_ref_tindakan[$i]['value'],$this->master_ref_code_tindakan);
                if($master_ref == null){
                    $this->Master_reference_model->insert(array(
                        'master_ref_code' => $this->master_ref_code_tindakan,
                        'master_ref_value' => $master_ref_tindakan[$i]['value'],
                        'master_ref_name' => $master_ref_tindakan[$i]['name']
                    ));
                }
            }
            
            //Set session sukses
            $this->session->set_flashdata('message', 'Data pemeriksaan berhasil disimpan, No Pendaftaran ' . $this->no_pendaftaran);
            $this->session->set_flashdata('message_type', 'success');
            
            redirect(site_url('periksamedis'));
        } else {
    		$this->data['no_periksa'] = $data_pendaftaran->no_pendaftaran.'/'.$date_now.'/'.$data_pendaftaran->no_rekam_medis;
    		$this->data['nama_lengkap'] = $data_pasien->nama_lengkap;
    		$this->data['alamat'] = $data_pasien->alamat.' '.$data_pasien->kabupaten.' '.'RT '.$data_pasien->rt.' '.'RW '.$data_pasien->rw;
    		$this->data['anamnesies'] = $this->get_master_ref($this->master_ref_code_anamnesi);
    		$this->data['alergi_obat'] = $this->get_master_ref($this->master_ref_code_alergiobat);
    		$this->data['diagnosa'] = $this->get_master_ref($this->master_ref_code_diagnosa);
    // 		$this->data['tindakan'] = $this->get_all_tindakan();
            $this->data['tindakan'] = $this->get_master_ref($this->master_ref_code_tindakan);
            $this->data['riwayat_alergi_obat'] = $data_pasien->riwayat_alergi_obat;
    		
    		$this->data['alkes_option'] = array();
    		$this->data['alkes_option'][''] = 'Pilih Alat Kesehatan';
    		$alkes_opt_js = array();
    		foreach ($this->Tbl_obat_alkes_bhp_model->get_all_alkes($this->id_klinik) as $alkes){
                $this->data['alkes_option'][$alkes->kode_barang] = $alkes->nama_barang;
                $alkes_opt_js[] = array(
                    'value' => $alkes->kode_barang,
                    'label' => $alkes->nama_barang
                );
            }
            $this->data['alkes_option_js'] = json_encode($alkes_opt_js);
    		
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
            // for ($i=0; $i < count($obat_opt_js); $i++) { 
            //     echo $obat_opt_js[$i]['value'];
            // }
            // print_r($obat_opt_js);
            // exit();
            $this->data['obat_option_js'] = json_encode($obat_opt_js);
            
            $this->data['anjuran_obat'] = $this->get_master_ref($this->master_ref_code_anjuranobat);
            
            $this->data['alkes'] = $this->get_all_alkes();
            $this->data['obat'] = $this->get_all_obat();    
            //Set session error
            if($this->input->post('no_periksa')){
                $this->session->set_flashdata('message', 'Terdapat error input, silahkan cek ulang');
                $this->session->set_flashdata('message_type', 'danger');
            }
        }
		
        $this->template->load('template','rekam_medis/form_rekam_medis', $this->data);
    }
    private function jurnal_otomatis_obat($total_jual_obat, $subsidi_obat, $grand, $no_periksa, $total_jual){
        $data_trx=array(
            'deskripsi'     => 'Penjualan Obat dari Nomor Pemeriksaan '.$no_periksa,
            'tanggal'       => date('Y-m-d'),
        );
        $insert=$this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi', $data_trx);
        if ($insert) {
            $id_last=$this->db->select_max('id_trx_akun')->from('tbl_trx_akuntansi')->get()->row();
            //kas bertambah
            $data=array(
                'id_trx_akun'   => $id_last->id_trx_akun,
                'id_akun'       => 20,
                'jumlah'        => $grand,
                'tipe'          => 'DEBIT',
                'keterangan'    => 'lawan',
            );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            //hpp 
            $data=array(
                'id_trx_akun'   => $id_last->id_trx_akun,
                'id_akun'       => 65,
                'jumlah'        => $total_jual,
                'tipe'          => 'DEBIT',
                'keterangan'    => 'lawan',
            );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            //persediaan obat berkurang
            $data=array(
                'id_trx_akun'   => $id_last->id_trx_akun,
                'id_akun'       => 58,
                'jumlah'        => $total_jual,
                'tipe'          => 'KREDIT',
                'keterangan'    => 'akun',
            );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            //pendapatan dari penjualan obat
            $data=array(
                'id_trx_akun'   => $id_last->id_trx_akun,
                'id_akun'       => 39,
                'jumlah'        => $total_jual_obat,
                'tipe'          => 'KREDIT',
                'keterangan'    => 'akun',
            );
            //diskon untuk penjualan obat
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            $data=array(
                'id_trx_akun'   => $id_last->id_trx_akun,
                'id_akun'       => 64,
                'jumlah'        => $subsidi_obat,
                'tipe'          => 'DEBIT',
                'keterangan'    => 'akun',
            );
            $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
        }
    }
    private function jurnal_otomatis_pemeriksaan($biaya_tindakan, $biaya_pemeriksaan, $no_periksa){
        if ($biaya_pemeriksaan != 0 || $biaya_tindakan != 0) {
            $total=($biaya_pemeriksaan != null ? $biaya_pemeriksaan : 0) + ($biaya_tindakan != null ? $biaya_tindakan : 0);
            $data_trx=array(
                'deskripsi'     => 'Pendapatan dari Nomor Pemeriksaan '.$no_periksa,
                'tanggal'       => date('Y-m-d'),
            );
            $insert=$this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi', $data_trx);
            if ($insert) {
                $id_last=$this->db->select_max('id_trx_akun')->from('tbl_trx_akuntansi')->get()->row();
                if ($biaya_tindakan != 0) {
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 63,
                        'jumlah'        => $biaya_tindakan,
                        'tipe'          => 'KREDIT',
                        'keterangan'    => 'akun',
                    );
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                }
                if ($biaya_pemeriksaan != 0) {
                    $data=array(
                        'id_trx_akun'   => $id_last->id_trx_akun,
                        'id_akun'       => 62,
                        'jumlah'        => $biaya_pemeriksaan,
                        'tipe'          => 'KREDIT',
                        'keterangan'    => 'akun',
                    );
                    $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                }
                $data=array(
                    'id_trx_akun'   => $id_last->id_trx_akun,
                    'id_akun'       => 20,
                    'jumlah'        => $total,
                    'tipe'          => 'DEBIT',
                    'keterangan'    => 'lawan',
                );
                // $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
                // $data=array(
                //     'id_trx_akun'   => $id_last->id_trx_akun,
                //     'id_akun'       => 62,
                //     'jumlah'        => $biaya_pemeriksaan,
                //     'tipe'          => 'KREDIT',
                //     'keterangan'    => 'lawan',
                // );
                $this->Transaksi_akuntansi_model->insert('tbl_trx_akuntansi_detail', $data);
            }
        }
    }
    private function getIdAkun($id){
        $getAkun=$this->db->where('id_akun', $id)->get('tbl_akun')->row();
        return $getAkun;
    }
    public function antrian(){
        $this->template->load('template','rekam_medis/antrian_list');
    }
    
    public function riwayat(){
        $this->template->load('template','rekam_medis/riwayat_periksamedis');
    }
    
    public function riwayat_detail($no_rekam_medis){
        $data['no_rekam_medis'] = $no_rekam_medis;
        $this->template->load('template','rekam_medis/riwayat_periksamedis_detail', $data);
    }
    
    public function sksehat(){
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('umur', 'Umur', 'trim|required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
        $this->form_validation->set_rules('tinggi_badan', 'Tinggi Badan', 'trim|required');
        $this->form_validation->set_rules('berat_badan', 'Berat Badan', 'trim|required');
        $this->form_validation->set_rules('golongan_darah', 'Golongan Darah', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('buta_warna', 'Buta Warna', 'trim|required');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        if ($this->form_validation->run() == TRUE) {
            //Get Data Dokter
            $data_dokter = $this->Tbl_dokter_model->get_by_id($this->id_dokter);
            
            $data = array(
                'nama' => $this->input->post('nama'),  
                'umur' => $this->input->post('umur'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tinggi_badan' => $this->input->post('tinggi_badan'),
                'berat_badan' => $this->input->post('berat_badan'),
                'golongan_darah' => $this->input->post('golongan_darah'),
                'alamat' => $this->input->post('alamat'),
                'buta_warna' => $this->input->post('buta_warna'),
                'keperluan' => $this->input->post('keperluan'),
                'tgl_cetak' => date("d M Y",  time()),
                'nama_dokter' => $data_dokter->nama_dokter
            );
            $this->load->view('rekam_medis/cetak_surat_ket_sehat', $data);
        } else {
            $this->template->load('template','rekam_medis/sksehat_form');
        }
        
        // $this->load->view('rekam_medis/cetak_surat_ket_sehat');
    }
    
    public function periksa($no_pend){
        $this->Tbl_dokter_model->update($this->id_dokter, array(
            "no_pendaftaran" => $no_pend,
            "dtm_upd" => date("Y-m-d H:i:s",  time())
        ));
        redirect(site_url('periksamedis'));
    }
    
    function split_string($string, $delimiter){
        $string_split = explode($delimiter, $string);
        $return = array();
        for($i=0;$i<count($string_split);$i++){
            if(trim($string_split[$i]) != ''){
                $return[] = array(
                    'value' => strtolower(trim(str_replace(' ', '', $string_split[$i]))),
                    'name' => trim($string_split[$i])
                );
            }
        }
        return $return;
    }
    
    function get_wilayah($kode){
        $this->db->where('kode', $kode);
        $data = $this->db->get('tbl_wilayah')->row();
        return $data->nama;
    }
    
	function get_master_ref($master_code){
        $this->db->where('master_ref_code', $master_code);
        $this->db->select('master_ref_value, master_ref_name');
        $datas = $this->db->get('tbl_master_reference')->result();
		$projects = array();
        foreach ($datas as $data) {
			$projects[] = array(
				'value' => $data->master_ref_value,
				'label' => $data->master_ref_name
			);
        }
		return json_encode($projects);
    }
    
    function get_all_tindakan(){
        $datas = $this->Tbl_tindakan_model->get_all();
		$projects = array();
        foreach ($datas as $data) {
			$projects[] = array(
				'value' => $data->kode_tindakan,
				'label' => $data->nama_tindakan
			);
        }
		return json_encode($projects);
    }
    
    function get_all_alkes(){
        $data_alkes = $this->Tbl_obat_alkes_bhp_model->get_all_alkes();
		$projects = array();
        foreach ($data_alkes as $alkes) {
			$projects[] = array(
				'kode_barang'   => $alkes->kode_barang,
                // 'stok_barang'   => $alkes->stok_barang,
                'harga'         => $alkes->harga,
			);
        }
		return json_encode($projects);
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
    
    function _rules() 
    {
        $this->form_validation->set_rules('no_periksa', 'No Periksa', 'trim|required');
        $this->form_validation->set_rules('anamnesi', 'Anamnesi', 'trim|required');
        $this->form_validation->set_rules('riwayat_alergi_obat', 'Riwayat Alergi Obat', 'trim|required');
        $this->form_validation->set_rules('diagnosa', 'Diagnosa', 'trim|required');
        $this->form_validation->set_rules('tindakan', 'Tindakan', 'trim|required');
        
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    
    public function json_by_id(){
        $data_pendaftaran = $this->Pendaftaran_model->get_by_id($this->no_pendaftaran);
        
        header('Content-Type: application/json');
        echo $this->Periksa_model->json($data_pendaftaran->no_rekam_medis);
    }
    
    public function json_antrian(){
        header('Content-Type: application/json');
        echo $this->Pendaftaran_model->json_antrian($this->id_dokter);
    }
    
    public function json_riwayat(){
        header('Content-Type: application/json');
        // echo $this->Periksa_model->json_riwayat($this->id_dokter);
        echo json_encode($this->Periksa_model->json_riwayat($this->id_dokter));
    }
    
    public function json_riwayat_detail($no_rekam_medis){
        header('Content-Type: application/json');
        echo $this->Periksa_model->json_riwayat_detail($this->id_dokter, $no_rekam_medis);
    }
    
    public function detail(){
        $no_periksa = $_GET['id'];
        $data_periksa = $this->Periksa_model->get_by_id($no_periksa);
        if(is_null($data_periksa))
            redirect(site_url('periksamedis'));
            
        //Data Periksa
        $this->data['no_periksa'] = $data_periksa->no_periksa;
        $this->data['anamnesi'] = $data_periksa->anamnesi;
        $this->data['diagnosa'] = $data_periksa->diagnosa;
        $this->data['tindakan'] = $data_periksa->tindakan;
        // $this->data['nama_dokter'] = $data_periksa->id_dokter;
        $this->data['note_dokter'] = $data_periksa->note_dokter;
        $this->data['tgl_periksa'] = $data_periksa->dtm_crt;
        
        //Get Data Pasien
        $data_pasien = $this->Tbl_pasien_model->get_by_id($data_periksa->no_rekam_medis);
        //Data Pasien
        $this->data['no_rekam_medis'] = $data_pasien->no_rekam_medis;
        $this->data['no_id_pasien'] = $data_pasien->no_id_pasien;
        $this->data['nama_pasien'] = $data_pasien->nama_lengkap;
        $this->data['alamat'] = $data_pasien->alamat.', '.$data_pasien->kelurahan.', '.$data_pasien->kecamatan.', '.$data_pasien->kabupaten;
        
        //Get Data Periksa D Fisik
        $data_periksa_d_fisik = $this->Periksa_model->get_d_fisik_by_id($data_periksa->no_periksa);
        $this->data['periksa_d_fisik'] = $data_periksa_d_fisik;
        
        //Get Data Periksa D Alkes
        $data_periksa_d_alkes = $this->Periksa_model->get_d_alkes_by_id($data_periksa->no_periksa);
        $this->data['periksa_d_alkes'] = $data_periksa_d_alkes;
        
        //Get Data Periksa D Obat
        $data_periksa_d_obat = $this->Periksa_model->get_d_obat_by_id($data_periksa->no_periksa);
        $this->data['periksa_d_obat'] = $data_periksa_d_obat;
        
        //Get Data Dokter
        $data_dokter = $this->Tbl_dokter_model->get_by_id($data_periksa->id_dokter);
        $this->data['nama_dokter'] = $data_dokter->nama_dokter;
        
        $this->template->load('template','rekam_medis/periksamedis_detail', $this->data);
    }
    
    public function cetak_surat_ket_sakit(){
        $id = $_GET['id'];
        $this->db->select('tbl_periksa.no_rekam_medis as nomor_rekam_medis,tbl_periksa.*,tbl_pasien.*,tbl_transaksi.*,tbl_periksa.dtm_crt as tgl_periksa,tbl_dokter.nama_dokter,tbl_klinik.nama as klinik,tbl_klinik.alamat as alamat_klinik');
        $this->db->from('tbl_transaksi');
        $this->db->join('tbl_periksa', 'tbl_transaksi.no_transaksi=tbl_periksa.no_periksa', 'left');
        $this->db->join('tbl_pasien', 'tbl_periksa.no_rekam_medis=tbl_pasien.no_rekam_medis', 'left');
        $this->db->join('tbl_dokter', 'tbl_periksa.id_dokter=tbl_dokter.id_dokter', 'left');
        $this->db->join('tbl_klinik', 'tbl_transaksi.id_klinik=tbl_klinik.id_klinik', 'left');
        
        $this->db->where('tbl_periksa.no_periksa',$id);
        $data = $this->db->get()->row();
        //Get Data Pasien
        $data_pasien = $this->Tbl_pasien_model->get_by_id($data->nomor_rekam_medis);
        
        
        $this->data['nama_klinik'] = $data->klinik;
        $this->data['alamat_klinik'] = $data->alamat_klinik;
        $this->data['no_transaksi'] = $data->no_transaksi;
        $this->data['tujuan_surat'] = $data->tujuan_surat;
        $this->data['nama_pasien'] = $data->nama_lengkap;
        $this->data['pekerjaan'] = $data->pekerjaan;
        $this->data['alamat'] = $data_pasien->alamat.' '.$data_pasien->kabupaten.' '.'RT '.$data_pasien->rt.' '.'RW '.$data_pasien->rw;
        $this->data['lama_istirahat'] = $data->lama_istirahat_surat;
        
        $date = new DateTime($data->tanggal_mulai);
        $tgl_periksa = $date->format('d/m/Y');
        $date2 = new DateTime($data->tanggal_mulai);
        $date2->add(new DateInterval('P'.($data->lama_istirahat_surat-1).'D'));
        $tgl_periksa2 = $date2->format('d/m/Y');
        $this->data['tgl_periksa'] = $tgl_periksa;
        $this->data['tgl_periksa2'] = $tgl_periksa2;
        $this->data['diagnosa'] = $data->diagnosa;
        $this->data['tgl_cetak'] = date("d M Y",  time());
        $this->data['dokter'] = $data->nama_dokter;
        $this->load->view('rekam_medis/cetak_surat_ket_sakit', $this->data);
    }
    
    public function daftar_baru(){
        $this->_rules_daftar_baru();
        
        if ($this->form_validation->run() == TRUE) {
            $no_pendaftaran = $this->Master_sequence_model->set_code_by_master_seq_code("NOPENDAFTARAN");
            
			$data_pasien = array(
				'no_rekam_medis'    => $this->input->post('no_rekam_medis'),
				'no_id_pasien'		=> $this->input->post('no_id'),
				'nama_lengkap'      => $this->input->post('nama_lengkap'),
				'tanggal_lahir'     => $this->input->post('tanggal_lahir'),
				'golongan_darah'    => $this->input->post('golongan_darah'),
				'status_menikah'    => $this->input->post('status_menikah'),
				'pekerjaan'      	=> $this->input->post('pekerjaan'),
				'alamat'      		=> $this->input->post('alamat'),
				'kabupaten' 		=> $this->input->post('kabupaten'),
				'rt' 		=> $this->input->post('rt'),
				'rw' 		=> $this->input->post('rw'),
				'nama_orang_tua_atau_istri'      =>  $this->input->post('nama_orangtua_atau_istri'),
				'nomer_telepon'     =>  $this->input->post('nomor_telepon'),
			);
			
            $data_pendaftaran = array(
				'no_pendaftaran' => $this->Master_sequence_model->set_code_by_master_seq_code("NOPENDAFTARAN", true),
				'no_rekam_medis' => $this->input->post('no_rekam_medis'),
				'id_dokter' => $this->input->post('nama_dokter'),
				'id_klinik' => $this->id_klinik,
	        );
			
			$row = $this->Tbl_pasien_model->get_by_id($this->input->post('no_rekam_medis'));
			if($row == null)
			{
				$this->Tbl_pasien_model->insert($data_pasien);
				$master_code = $this->Master_sequence_model->set_code_by_master_seq_code("NOREKAMMEDIS", true);
			} else {
			    $this->Tbl_pasien_model->update($row->no_rekam_medis, $data_pasien);
			}
			$this->Pendaftaran_model->insert($data_pendaftaran);
			
			//Cek status dokter, jika kosong maka isi no_pendaftaran
			$dokter = $this->Tbl_dokter_model->get_by_id($this->input->post('nama_dokter'));
			if($dokter->no_pendaftaran == null || trim($dokter->no_pendaftaran) == '' ){
			    $this->Tbl_dokter_model->update($this->input->post('nama_dokter'), array(
			        'no_pendaftaran' => $no_pendaftaran,
			        'dtm_upd' => date("Y-m-d H:i:s",  time())
			    ));
			}
			
			//Set session sukses
            $this->session->set_flashdata('message', 'Data pendaftaran berhasil disimpan, No Rekam Medis ' . $this->input->post('no_rekam_medis'));
            $this->session->set_flashdata('message_type', 'success');
            
			redirect(site_url('periksamedis'));
        } else {	
            $pasien_existing = null;
            if($this->session->flashdata('no_rekam_medis') != null)
                $pasien_existing = $this->Tbl_pasien_model->get_by_id($this->session->flashdata('no_rekam_medis'));
			
			$this->data['message'] = $this->session->flashdata('message');
			
			$this->db->where('no_id_pasien', set_value('no_id'));
			$dataPasien = $this->db->get('tbl_pasien')->row();
			$this->data['no_rekam_medis_default'] = $this->Master_sequence_model->set_code_by_master_seq_code("NOREKAMMEDIS");
			
			$this->data['no_rekam_medis'] = $pasien_existing != null ? $pasien_existing->no_rekam_medis : ($dataPasien != null ? set_value('no_rekam_medis') : $this->data['no_rekam_medis_default']);
			$this->data['no_id'] = $pasien_existing != null ? $pasien_existing->no_id_pasien : set_value('no_id');
			$this->data['nama_lengkap'] = $pasien_existing != null ? $pasien_existing->nama_lengkap : set_value('nama_lengkap');
			$this->data['tanggal_lahir'] = $pasien_existing != null ? $pasien_existing->tanggal_lahir : set_value('tanggal_lahir');
			$this->data['golongan_darah'] = $pasien_existing != null ? $pasien_existing->golongan_darah : set_value('golongan_darah');
			$this->data['status_menikah'] = $pasien_existing != null ? $pasien_existing->status_menikah : set_value('status_menikah');
			$this->data['pekerjaan'] = $pasien_existing != null ? $pasien_existing->pekerjaan : set_value('pekerjaan');
			$this->data['alamat'] = $pasien_existing != null ? $pasien_existing->alamat : set_value('alamat');
			$this->data['kabupaten'] = $pasien_existing != null ? $pasien_existing->kabupaten : set_value('kabupaten');
			$this->data['rt'] = $pasien_existing != null ? $pasien_existing->rt : set_value('rt');
			$this->data['rw'] = $pasien_existing != null ? $pasien_existing->rw : set_value('rw');
			$this->data['nama_orangtua_atau_istri'] = $pasien_existing != null ? $pasien_existing->nama_orang_tua_atau_istri : set_value('nama_orangtua_atau_istri');
			$this->data['nomor_telepon'] = $pasien_existing != null ? $pasien_existing->nomer_telepon : set_value('nomor_telepon');
			$this->data['nama_dokter'] = $this->id_dokter;	
			
			$this->data['option_dokter'] = array();
			$dokter = $this->Tbl_dokter_model->get_by_id($this->id_dokter);
			$this->data['option_dokter'][$dokter->id_dokter] = $dokter->nama_dokter;
			
			//Set session error
            if($this->input->post('no_rekam_medis')){
                $this->session->set_flashdata('message', 'Terdapat error input, silahkan cek ulang');
                $this->session->set_flashdata('message_type', 'danger');
            }
		}
        
        $this->template->load('template','rekam_medis/daftar_baru', $this->data);
    }
    
    public function pencarian(){
        $this->template->load('template','rekam_medis/tbl_pasien_list');
    }
    
    public function existing($no_rekam_medis){
        $this->session->set_flashdata('no_rekam_medis', $no_rekam_medis);
        
        //Set session sukses
        $this->session->set_flashdata('message', 'Pencarian Berhasil dengan No Rekam Medis : ' . $no_rekam_medis . ', Tekan Tombol Simpan Pendaftaran untuk melanjutkan pendaftaran');
        $this->session->set_flashdata('message_type', 'success');
        
        redirect(site_url('periksamedis/daftar_baru'));
    }
    
    public function pencarian_json(){
        header('Content-Type: application/json');
        echo $this->Pendaftaran_model->json_pencarian_by_dokter();
    }
    
    public function _rules_daftar_baru() 
    {
        $this->form_validation->set_rules('no_rekam_medis', 'No Rekam Medis', 'trim|required');
    	$this->form_validation->set_rules('no_id', 'No ID Pasien', 'trim|required');
    	$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
    	$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
    // 	$this->form_validation->set_rules('golongan_darah', 'Golongan Darah', 'trim|required');
    	$this->form_validation->set_rules('status_menikah', 'Status Menikah', 'trim|required');
    	$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required');
    	$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
    	$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'trim|required');
    	$this->form_validation->set_rules('rt', 'RT', 'trim|required');
    	$this->form_validation->set_rules('rw', 'RW', 'trim|required');
    	$this->form_validation->set_rules('nama_orangtua_atau_istri', 'Nama Orantua atau Istri', 'trim|required');
    	$this->form_validation->set_rules('nomor_telepon', 'Nomor Telepon', 'trim|required');
		$this->form_validation->set_rules('nama_dokter', 'Nama Dokter', 'trim|required');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}