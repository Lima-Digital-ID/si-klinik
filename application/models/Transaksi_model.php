<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{

    public $table = 'tbl_transaksi';
    public $id = 'id_transaksi';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }
    
    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    function get_by_no($no_trans)
    {
        $this->db->where('no_transaksi', $no_trans);
        return $this->db->get($this->table)->row();
    }
    
    function get_detail_all()
    {
        return $this->db->get('tbl_transaksi_d')->result();
    }
    
    function get_detail_by_h_id($h_id)
    {
        $this->db->where('no_transaksi', $h_id);
        return $this->db->get('tbl_transaksi_d')->result();
    }
    
    public function laporanKeuanganStep1($dari,$sampai)
    {
        $this->db->select('no_transaksi');
        $this->db->from('tbl_transaksi');
        $this->db->where(['tgl_transaksi >=' => $dari." 00:00", "tgl_transaksi <=" => $sampai." 23:59"]);

        $query = $this->db->get();
        return $query->result();
    }
    public function sumAmountTrans($inv,$desc)
    {
        $this->db->select('sum(amount_transaksi) ttl');
        $this->db->from('tbl_transaksi_d');
        $this->db->where(['no_transaksi' => $inv, 'deskripsi' => $desc]);

        $query = $this->db->get();
        return $query->result();
    }

    function get_detail_obat_by_h_id($h_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_transaksi_d_obat');
        $this->db->join('tbl_obat_alkes_bhp', 'tbl_transaksi_d_obat.kode_barang = tbl_obat_alkes_bhp.kode_barang');
        $this->db->where('no_transaksi', $h_id);
        return $this->db->get()->result();
    }

    function insert($data = null, $data_d = null)
    {
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();
        for($i = 0; $i < count($data_d); $i++){
            // $data_d[$i]['id_transaksi'] = $insert_id;
            $this->db->insert('tbl_transaksi_d',$data_d[$i]);
        }
    }
    
    function insert_d($data_d){
        $this->db->insert('tbl_transaksi_d', $data_d);
    }
    
    function insert_transaksi_d_obat($data_d_obat)
    {
        for($i = 0; $i < count($data_d_obat); $i++){
            $this->db->insert('tbl_transaksi_d_obat',$data_d_obat[$i]);
        }
    }
    
    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
    
    function update_d($no_transaksi, $data_d){
        $this->db->where('no_transaksi', $no_transaksi);
        $this->db->where('deskripsi', 'Total Obat-obatan');
        $this->db->update('tbl_transaksi_d', $data_d);
    }
    
    function json($id_klinik = null,$tipe) {
        $this->datatables->select('id_transaksi,kode_transaksi,tbl_klinik.nama as id_klinik,no_transaksi,tbl_periksa.dtm_crt as tgl_periksa,tbl_periksa.dtm_upd as tgl_pengambilan, (CASE status_transaksi WHEN 1 THEN "Lunas" ELSE "Belum Dibayar" END) as status_transaksi, tbl_pasien.nama_lengkap as nama_pasien');
        $this->datatables->from('tbl_periksa');
        $this->datatables->join('tbl_transaksi','tbl_periksa.no_periksa=tbl_transaksi.no_transaksi');
        $this->datatables->join('tbl_pasien','tbl_periksa.no_rekam_medis=tbl_pasien.no_rekam_medis');
        $this->datatables->join('tbl_pendaftaran','tbl_pasien.no_rekam_medis=tbl_pendaftaran.no_rekam_medis');
        $this->datatables->join('tbl_klinik','tbl_transaksi.id_klinik=tbl_klinik.id_klinik');
        $this->datatables->where('status_transaksi', 0);
        $this->datatables->where('tbl_periksa.is_ambil_obat', 0);
        if($id_klinik != null)
            $this->datatables->where('tbl_transaksi.id_klinik', $id_klinik);
            
            if($tipe==1 || $tipe==4){
                $this->datatables->where('tbl_pendaftaran.tipe_periksa', '1');
                $this->datatables->or_where('tbl_pendaftaran.tipe_periksa', '4');
        }
        else{
            $this->datatables->where('tbl_pendaftaran.tipe_periksa', $tipe);
        }
        $this->datatables->group_by('tbl_transaksi.no_transaksi');

        $this->datatables->add_column('action',anchor(site_url('pembayaran/bayar/$1?tab=pemeriksaan'),'Bayar','class="btn btn-danger btn-sm"'),'id_transaksi');
            
        return $this->datatables->generate();
    }
    
    function json2($id_klinik = null,$tipe) {
        $this->datatables->select('id_transaksi,kode_transaksi,tbl_klinik.nama as id_klinik,no_transaksi,tbl_periksa.is_surat_ket_sakit,tbl_periksa.no_periksa,tbl_periksa.dtm_crt as tgl_periksa,tbl_periksa.dtm_upd as tgl_pengambilan, (CASE status_transaksi WHEN 1 THEN "Lunas" ELSE "Belum Dibayar" END) as status_transaksi, tbl_transaksi.dtm_upd as tgl_pembayaran, tbl_pasien.nama_lengkap as nama_pasien');
        $this->datatables->from('tbl_periksa');
        $this->datatables->join('tbl_transaksi','tbl_periksa.no_periksa=tbl_transaksi.no_transaksi');
        $this->datatables->join('tbl_pasien','tbl_periksa.no_rekam_medis=tbl_pasien.no_rekam_medis');
        $this->datatables->join('tbl_pendaftaran','tbl_pasien.no_rekam_medis=tbl_pendaftaran.no_rekam_medis');
        $this->datatables->join('tbl_klinik','tbl_transaksi.id_klinik=tbl_klinik.id_klinik');
        $this->datatables->where('status_transaksi', 1);
        if($id_klinik != null)
            $this->datatables->where('tbl_transaksi.id_klinik', $id_klinik);

        $this->datatables->add_column('action',anchor(site_url('pembayaran/cetak_surat/$1'),'Cetak Kwitansi',array('class' => 'btn btn-warning btn-sm','target'=>'_blank')),'id_transaksi');

        if($tipe==1 || $tipe==4){
            $this->datatables->where('tbl_pendaftaran.tipe_periksa', '1');
            $this->datatables->or_where('tbl_pendaftaran.tipe_periksa', '4');
            $this->datatables->add_column('cetak', anchor(site_url('pembayaran/cetak-sksakit?id=$1'),'Cetak SK Sakit','class="btn btn-danger btn-sm"'),'no_periksa');
        }
        else{
            $this->datatables->where('tbl_pendaftaran.tipe_periksa', $tipe);
            $this->datatables->add_column('cetak', anchor(site_url('pembayaran/cetak-sklab?id=$1'),'Cetak SK LAB','class="btn btn-danger btn-sm"'),'no_periksa');
        }
        $this->datatables->group_by('tbl_transaksi.no_transaksi');
            
        return $this->datatables->generate();
    }
    
    function json_apotek($id_klinik = null){
        $this->datatables->select('tbl_periksa.no_periksa,tbl_periksa.no_pendaftaran,tbl_periksa.no_rekam_medis, tbl_pasien.nama_lengkap as nama_pasien,tbl_dokter.nama_dokter as nama_dokter,tbl_periksa.dtm_crt as tgl_periksa,tbl_klinik.nama as klinik');
        $this->datatables->from('tbl_periksa');
        $this->datatables->join('tbl_transaksi','tbl_periksa.no_periksa=tbl_transaksi.no_transaksi');
        $this->datatables->join('tbl_pasien','tbl_periksa.no_rekam_medis=tbl_pasien.no_rekam_medis');
        $this->datatables->join('tbl_dokter','tbl_periksa.id_dokter=tbl_dokter.id_dokter');
        $this->datatables->join('tbl_pendaftaran','tbl_periksa.no_pendaftaran=tbl_pendaftaran.no_pendaftaran','left');
        $this->datatables->join('tbl_klinik','tbl_pendaftaran.id_klinik=tbl_klinik.id_klinik','left');
        $this->datatables->where('tbl_transaksi.status_transaksi', 1);
        $this->datatables->where('tbl_periksa.is_ambil_obat', 0);
        if($id_klinik != null)
            $this->datatables->where('tbl_pendaftaran.id_klinik', $id_klinik);
        $this->datatables->add_column('action',anchor(site_url('apotek/ambilobat?id=$1'),'Ambil','class="btn btn-danger btn-sm"'),'no_periksa');
            
        return $this->datatables->generate();
    }
    
    function json_apotek2($id_klinik = null){
        $this->datatables->select('tbl_periksa.no_periksa,tbl_periksa.no_pendaftaran,tbl_periksa.no_rekam_medis, tbl_pasien.nama_lengkap as nama_pasien,tbl_dokter.nama_dokter as nama_dokter,tbl_periksa.dtm_crt as tgl_periksa, tbl_periksa.dtm_crt as tgl_pengambilan, (CASE status_transaksi WHEN 1 THEN "Lunas" ELSE "Belum Dibayar" END) as status,tbl_klinik.nama as klinik');
        $this->datatables->from('tbl_periksa');
        $this->datatables->join('tbl_transaksi','tbl_periksa.no_periksa=tbl_transaksi.no_transaksi');
        $this->datatables->join('tbl_pasien','tbl_periksa.no_rekam_medis=tbl_pasien.no_rekam_medis');
        $this->datatables->join('tbl_dokter','tbl_periksa.id_dokter=tbl_dokter.id_dokter');
        $this->datatables->join('tbl_pendaftaran','tbl_periksa.no_pendaftaran=tbl_pendaftaran.no_pendaftaran','left');
        $this->datatables->join('tbl_klinik','tbl_pendaftaran.id_klinik=tbl_klinik.id_klinik','left');
        $this->datatables->where('tbl_periksa.is_ambil_obat', 1);
        if($id_klinik != null)
            $this->datatables->where('tbl_pendaftaran.id_klinik', $id_klinik);
        // $this->datatables->where('tbl_transaksi.status_transaksi', 1);
        // $this->datatables->add_column('action',anchor(site_url('apotek/ambilobat?id=$1'),'Ambil','class="btn btn-danger btn-sm"'),'no_periksa');
            
        return $this->datatables->generate();
    }
    
    function json_keuangan($filters){
        // $pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
        $filter = explode("_", $filters);
        $rekap_laporan = $filter[0]; // harian/bulanan/tahunan
        $filter_data = $filter[1]; // data filter
        $id_klinik = $filter[2]; //id klinik
        
        $this->datatables->select('t.id_transaksi,td.dtm_crt as tgl_transaksi,t.no_transaksi,td.deskripsi,td.amount_transaksi,td.dc, (CASE td.dc WHEN "d" THEN td.amount_transaksi ELSE "-" END) as debit, (CASE td.dc WHEN "c" THEN td.amount_transaksi ELSE "-" END) as credit,k.nama as klinik');
        $this->datatables->from('tbl_transaksi t');
        $this->datatables->join('tbl_transaksi_d td','t.no_transaksi=td.no_transaksi');
        $this->datatables->join('tbl_klinik k','t.id_klinik=k.id_klinik');
        $this->datatables->where('t.status_transaksi', 1);
        $this->datatables->where('td.amount_transaksi != ', 0);
        
        if ($rekap_laporan == 1)
            $this->datatables->where('DATE(td.dtm_crt)', $filter_data);
        else if ($rekap_laporan == 2){
            // $this->db->where('MONTH(t.tgl_transaksi)', $filter_data);
            $filter2 = explode("-", $filter_data);
            $this->datatables->where('MONTH(td.dtm_crt)', $filter2[0]);
            $this->datatables->where('YEAR(td.dtm_crt)', $filter2[1]);
        }
        else if ($rekap_laporan == 3)
            $this->datatables->where('YEAR(td.dtm_crt)', $filter_data);
        
        $this->datatables->where('t.id_klinik', $id_klinik);
        
        return $this->datatables->generate();
    }
    function json_biaya_obat($filters){
        // $pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
        $filter = explode("_", $filters);
        $rekap_laporan = $filter[0]; // harian/bulanan/tahunan
        $filter_data = $filter[1]; // data filter
        $id_klinik = $filter[2]; //id klinik
        
        $this->datatables->select('t.id_transaksi,td.dtm_crt as tgl_transaksi,t.no_transaksi,td.deskripsi,td.amount_transaksi,td.dc, (CASE td.dc WHEN "d" THEN td.amount_transaksi ELSE "-" END) as debit, (CASE td.dc WHEN "c" THEN td.amount_transaksi ELSE "-" END) as credit,k.nama as klinik');
        $this->datatables->from('tbl_transaksi t');
        $this->datatables->join('tbl_transaksi_d td','t.no_transaksi=td.no_transaksi');
        $this->datatables->join('tbl_klinik k','t.id_klinik=k.id_klinik');
        $this->datatables->where('t.status_transaksi', 1);
        $this->datatables->where('td.amount_transaksi != ', 0);
        $this->datatables->where('td.deskripsi', 'Total Obat-obatan');
        
        if ($rekap_laporan == 1)
            $this->datatables->where('DATE(td.dtm_crt)', $filter_data);
        else if ($rekap_laporan == 2)
            $this->datatables->where('MONTH(t.tgl_transaksi)', $filter_data);
        else if ($rekap_laporan == 3)
            $this->datatables->where('YEAR(t.tgl_transaksi)', $filter_data);
        
        $this->datatables->where('t.id_klinik', $id_klinik);
        
        return $this->datatables->generate();
    }

    function json_biaya_tindakan($filters){
        // $pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
        $filter = explode("_", $filters);
        $rekap_laporan = $filter[0]; // harian/bulanan/tahunan
        $filter_data = $filter[1]; // data filter
        $id_klinik = $filter[2]; //id klinik
        
        $this->datatables->select('t.id_transaksi,td.dtm_crt as tgl_transaksi,t.no_transaksi,td.deskripsi,td.amount_transaksi,td.dc, (CASE td.dc WHEN "d" THEN td.amount_transaksi ELSE "-" END) as debit, (CASE td.dc WHEN "c" THEN td.amount_transaksi ELSE "-" END) as credit,k.nama as klinik');
        $this->datatables->from('tbl_transaksi t');
        $this->datatables->join('tbl_transaksi_d td','t.no_transaksi=td.no_transaksi');
        $this->datatables->join('tbl_klinik k','t.id_klinik=k.id_klinik');
        $this->datatables->where('t.status_transaksi', 1);
        $this->datatables->where('td.amount_transaksi != ', 0);
        $this->datatables->where('td.deskripsi', 'Biaya Tindakan');
        
        if ($rekap_laporan == 1)
            $this->datatables->where('DATE(td.dtm_crt)', $filter_data);
        else if ($rekap_laporan == 2)
            $this->datatables->where('MONTH(t.tgl_transaksi)', $filter_data);
        else if ($rekap_laporan == 3)
            $this->datatables->where('YEAR(t.tgl_transaksi)', $filter_data);
        
        $this->datatables->where('t.id_klinik', $id_klinik);
        
        return $this->datatables->generate();
    }

    function json_biaya_pemeriksaan($filters){
        // $pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
        $filter = explode("_", $filters);
        $rekap_laporan = $filter[0]; // harian/bulanan/tahunan
        $filter_data = $filter[1]; // data filter
        $id_klinik = $filter[2]; //id klinik
        
        $this->datatables->select('t.id_transaksi,td.dtm_crt as tgl_transaksi,t.no_transaksi,td.deskripsi,td.amount_transaksi,td.dc, (CASE td.dc WHEN "d" THEN td.amount_transaksi ELSE "-" END) as debit, (CASE td.dc WHEN "c" THEN td.amount_transaksi ELSE "-" END) as credit,k.nama as klinik');
        $this->datatables->from('tbl_transaksi t');
        $this->datatables->join('tbl_transaksi_d td','t.no_transaksi=td.no_transaksi');
        $this->datatables->join('tbl_klinik k','t.id_klinik=k.id_klinik');
        $this->datatables->where('t.status_transaksi', 1);
        $this->datatables->where('td.amount_transaksi != ', 0);
        $this->datatables->where('td.deskripsi', 'Biaya Pemeriksaan');
        
        if ($rekap_laporan == 1)
            $this->datatables->where('DATE(td.dtm_crt)', $filter_data);
        else if ($rekap_laporan == 2)
            $this->datatables->where('MONTH(t.tgl_transaksi)', $filter_data);
        else if ($rekap_laporan == 3)
            $this->datatables->where('YEAR(t.tgl_transaksi)', $filter_data);
        
        $this->datatables->where('t.id_klinik', $id_klinik);
        
        return $this->datatables->generate();
    }
    
    function get_laporan_keuangan($filters){
        $filter = explode("_", $filters);
        $rekap_laporan = $filter[0]; // harian/bulanan/tahunan
        $filter_data = $filter[1]; // data filter
        $id_klinik = $filter[2]; //id klinik
        
        $this->db->select('t.id_transaksi,td.dtm_crt as tgl_transaksi,t.no_transaksi,td.deskripsi,td.amount_transaksi,td.dc, (CASE td.dc WHEN "d" THEN td.amount_transaksi ELSE "" END) as debit, (CASE td.dc WHEN "c" THEN td.amount_transaksi ELSE "" END) as credit,k.nama as klinik');
        $this->db->from('tbl_transaksi t');
        $this->db->join('tbl_transaksi_d td','t.id_transaksi=td.id_transaksi');
        $this->db->join('tbl_klinik k','t.id_klinik=k.id_klinik');
        $this->db->where('t.status_transaksi', 1);
        $this->db->where('td.amount_transaksi != ', 0);
        
        if ($rekap_laporan == 1)
            $this->db->where('DATE(td.dtm_crt)', $filter_data);
        else if ($rekap_laporan == 2){
            // $this->db->where('MONTH(t.tgl_transaksi)', $filter_data);
            $filter2 = explode("-", $filter_data);
            $this->db->where('MONTH(td.dtm_crt)', $filter2[0]);
            $this->db->where('YEAR(td.dtm_crt)', $filter2[1]);
        }
        else if ($rekap_laporan == 3)
            $this->db->where('YEAR(td.dtm_crt)', $filter_data);
        
        $this->db->where('t.id_klinik', $id_klinik);
        $this->db->order_by('td.dtm_crt','asc');
        
        return $this->db->get()->result();
    }
    
    function json_asuransi($filters,$idKlinik=""){
        if($filters!=NULL){
            $filter = explode("_", $filters);
            $rekap_laporan = $filter[0]; // harian/bulanan/tahunan
            $filter_data = $filter[1]; // data filter
            $id_klinik = $filter[2]; //id klinik
        }
        
        $this->datatables->select('ra.no_transaksi, ps.nama_lengkap as nama_pasien, ra.amount, ra.dtm_crt as tgl_pembayaran');
        $this->datatables->from('tbl_rekap_asuransi ra');
        $this->datatables->join('tbl_transaksi t','ra.no_transaksi=t.no_transaksi');
        $this->datatables->join('tbl_periksa p','t.no_transaksi=p.no_periksa');
        $this->datatables->join('tbl_pasien ps','p.no_rekam_medis=ps.no_rekam_medis');

        if($filters!=NULL){
        
            if ($rekap_laporan == 1)
                $this->datatables->where('DATE(ra.dtm_crt)', $filter_data);
            else if ($rekap_laporan == 2){
                $filter2 = explode("-", $filter_data);
                $this->datatables->where('MONTH(ra.dtm_crt)', $filter2[0]);
                $this->datatables->where('YEAR(ra.dtm_crt)', $filter2[1]);
            }
            else if ($rekap_laporan == 3)
                $this->datatables->where('YEAR(ra.dtm_crt)', $filter_data);
            
            if($id_klinik != null)
                $this->datatables->where('t.id_klinik', $id_klinik);
        }
        else{
            if($idKlinik!=""){
                $this->datatables->where('t.id_klinik', $idKlinik);
            }
        }
        
        return $this->datatables->generate();
    }
    
    function get_asuransi($filters){
        $filter = explode("_", $filters);
        $rekap_laporan = $filter[0]; // harian/bulanan/tahunan
        $filter_data = $filter[1]; // data filter
        $id_klinik = $filter[2]; //id klinik
        
        $this->db->select('ra.no_transaksi, ps.no_id_pasien, ps.tanggal_lahir, ps.nama_lengkap as nama_pasien, ra.amount, ra.dtm_crt as tgl_pembayaran');
        $this->db->from('tbl_rekap_asuransi ra');
        $this->db->join('tbl_transaksi t','ra.no_transaksi=t.no_transaksi');
        $this->db->join('tbl_periksa p','t.no_transaksi=p.no_periksa');
        $this->db->join('tbl_pasien ps','p.no_rekam_medis=ps.no_rekam_medis');
        
        if ($rekap_laporan == 1)
            $this->db->where('DATE(ra.dtm_crt)', $filter_data);
        else if ($rekap_laporan == 2){
            $filter2 = explode("-", $filter_data);
            $this->db->where('MONTH(ra.dtm_crt)', $filter2[0]);
            $this->db->where('YEAR(ra.dtm_crt)', $filter2[1]);
        }
        else if ($rekap_laporan == 3)
            $this->db->where('YEAR(ra.dtm_crt)', $filter_data);
        
        if($id_klinik != null)
            $this->db->where('t.id_klinik', $id_klinik);
            
        return $this->db->get()->result();
    }
    
    function json_obat($id_klinik = null) {
        $this->datatables->select('tbl_transaksi.id_transaksi,tbl_transaksi.kode_transaksi,tbl_klinik.nama as id_klinik,tbl_transaksi.no_transaksi,tbl_transaksi.dtm_crt as tgl_beli,tbl_transaksi.atas_nama');
        $this->datatables->from('tbl_transaksi');
        $this->datatables->join('tbl_klinik','tbl_transaksi.id_klinik=tbl_klinik.id_klinik');
        $this->datatables->where('tbl_transaksi.status_transaksi', 0);
        $this->datatables->where('tbl_transaksi.kode_transaksi', 'TRXOBAT');
        if($id_klinik != null)
            $this->datatables->where('tbl_transaksi.id_klinik', $id_klinik);
        $this->datatables->add_column('action',anchor(site_url('pembayaran/bayar_obat/$1'),'Bayar','class="btn btn-danger btn-sm"'),'id_transaksi');
            
        return $this->datatables->generate();
    }
    
    function json_obat2($id_klinik = null) {
        $this->datatables->select('tbl_transaksi.id_transaksi,tbl_transaksi.kode_transaksi,tbl_klinik.nama as id_klinik,tbl_transaksi.no_transaksi,tbl_transaksi.dtm_crt as tgl_beli,tbl_transaksi.atas_nama, tbl_transaksi.dtm_upd as tgl_bayar');
        $this->datatables->from('tbl_transaksi');
        $this->datatables->join('tbl_klinik','tbl_transaksi.id_klinik=tbl_klinik.id_klinik');
        $this->datatables->where('tbl_transaksi.status_transaksi', 1);
        $this->datatables->where('tbl_transaksi.kode_transaksi', 'TRXOBAT');
        if($id_klinik != null)
            $this->datatables->where('tbl_transaksi.id_klinik', $id_klinik);
        // $this->datatables->add_column('action',anchor(site_url('pembayaran/bayar_obat/$1'),'Bayar','class="btn btn-danger btn-sm"'),'id_transaksi');
            
        return $this->datatables->generate();
    }
    function getDetailTrxObat($no_transaksi){
        $this->db->select('td.*, tr.atas_nama, to.nama_barang');
        $this->db->from('tbl_transaksi tr');
        $this->db->join('tbl_transaksi_d_obat td','tr.no_transaksi=td.no_transaksi');
        $this->db->join('tbl_obat_alkes_bhp to','to.kode_barang=td.kode_barang');
        $this->db->where('tr.no_transaksi', $no_transaksi);
        return $this->db->get()->result();
    }
}
