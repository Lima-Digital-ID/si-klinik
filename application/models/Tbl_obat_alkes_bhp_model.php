<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_obat_alkes_bhp_model extends CI_Model
{

    public $table = 'tbl_obat_alkes_bhp';
    public $id = 'kode_barang';
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

    function get_list()
    {
        $this->db->select('kode_barang, nama_barang');
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
	
	function get_all_alkes($id_klinik = null)
    {
        $this->db->where('jenis_barang', '2'); //Get jenis barang = alat kesehatan
        if($id_klinik != null)
            $this->db->where('id_klinik', $id_klinik);
        
        return $this->db->get($this->table)->result();
    }
	
	function get_all_obat($id_klinik = null,$json=false)
    {
        // $this->db->where('jenis_barang', '1'); //Get jenis barang = obat
        // if($id_klinik != null)
        //     $this->db->where('id_klinik', $id_klinik);
        
        // return $this->db->get($this->table)->result();

        // $query=$tipeGetData->query("SELECT SUM(tid1.jumlah) - COALESCE((SELECT SUM(tid2.jumlah) as jumlah_stok FROM `tbl_inventory_detail` tid2 JOIN tbl_inventory ti2 ON tid2.id_inventory=ti2.id_inventory WHERE ti2.inv_type='TRX_STUFF' AND ti2.id_klinik=MAX(ti.id_klinik) AND tid2.kode_barang=tid1.kode_barang), 0) - COALESCE((SELECT SUM(tid2.jumlah) as jumlah_stok FROM `tbl_inventory_detail` tid2 JOIN tbl_inventory ti2 ON tid2.id_inventory=ti2.id_inventory WHERE ti2.inv_type='RETURN_MONEY' AND ti2.id_klinik=MAX(ti.id_klinik) AND tid2.kode_barang=tid1.kode_barang), 0) as stok_barang, MAX(tid1.kode_barang) AS kode_barang, MAX(tid1.harga) AS harga, MAX(toa.harga) AS harga_jual, MAX(tid1.diskon) AS diskon, MAX(tid1.tgl_exp) AS tgl_exp, MAX(toa.nama_barang) AS nama_barang FROM `tbl_inventory_detail` tid1 JOIN tbl_inventory ti ON tid1.id_inventory=ti.id_inventory JOIN tbl_obat_alkes_bhp toa ON tid1.kode_barang=toa.kode_barang WHERE ti.inv_type='RECEIPT_ORDER' OR ti.inv_type='RETURN_STUFF' AND ti.id_klinik=1 AND toa.jenis_barang=1 GROUP BY tid1.kode_barang");

        $tipeGetData = $json ? $this->datatables : $this->db;

        $tipeGetData->select("SUM(tid1.jumlah) - COALESCE((SELECT SUM(tid2.jumlah) as jumlah_stok FROM `tbl_inventory_detail` tid2 JOIN tbl_inventory ti2 ON tid2.id_inventory=ti2.id_inventory WHERE ti2.inv_type='TRX_STUFF' AND ti2.id_klinik=MAX(ti.id_klinik) AND tid2.kode_barang=tid1.kode_barang), 0) - COALESCE((SELECT SUM(tid2.jumlah) as jumlah_stok FROM `tbl_inventory_detail` tid2 JOIN tbl_inventory ti2 ON tid2.id_inventory=ti2.id_inventory WHERE ti2.inv_type='RETURN_MONEY' AND ti2.id_klinik=MAX(ti.id_klinik) AND tid2.kode_barang=tid1.kode_barang), 0) as stok_barang, MAX(tid1.kode_barang) AS kode_barang, MAX(tid1.harga) AS harga, MAX(toa.harga) AS harga_jual, MAX(tid1.diskon) AS diskon, MAX(tid1.tgl_exp) AS tgl_exp, MAX(toa.nama_barang) AS nama_barang");
        $tipeGetData->from("tbl_inventory_detail tid1");
        $tipeGetData->join('tbl_inventory ti','tid1.id_inventory=ti.id_inventory');
        $tipeGetData->join('tbl_obat_alkes_bhp toa','tid1.kode_barang=toa.kode_barang');
        $tipeGetData->where("ti.inv_type='RECEIPT_ORDER' OR ti.inv_type='RETURN_STUFF' AND ti.id_klinik=1 AND toa.jenis_barang=1");
        $tipeGetData->group_by("tid1.kode_barang");

        if($json){
            $this->datatables->generate();
        }
        else{
            $query = $this->db->get();
            return $query->result();
        }


        // SELECT SUM(tid1.jumlah) - COALESCE((SELECT SUM(tid2.jumlah) as jumlah_stok FROM `tbl_inventory_detail` tid2 JOIN tbl_inventory ti2 ON tid2.id_inventory=ti2.id_inventory JOIN tbl_obat_alkes_bhp toa1 ON tid2.kode_barang=toa1.kode_barang WHERE ti2.inv_type='TRX_STUFF' OR ti2.inv_type='RETURN_MONEY' AND ti2.id_klinik=1 AND tid2.kode_barang=tid1.kode_barang), 0) as jumlah_stok, tid1.kode_barang, toa.nama_barang FROM `tbl_inventory_detail` tid1 JOIN tbl_inventory ti ON tid1.id_inventory=ti.id_inventory JOIN tbl_obat_alkes_bhp toa ON tid1.kode_barang=toa.kode_barang WHERE ti.inv_type='RECEIPT_ORDER' OR ti.inv_type='RETURN_STUFF' AND ti.id_klinik=1 AND toa.jenis_barang=1 GROUP BY tid1.kode_barang
    }

    public function getStokStep1()
    {
        $this->db->select('kode_barang, nama_barang');
        $this->db->from("tbl_obat_alkes_bhp");
        $query = $this->db->get();
        return $query->result();
    }
    public function getStokStep2($kodeBarang)
    {
        $this->db->select('id_inventory_detail');
        $this->db->from("tbl_inventory_detail");
        $this->db->where('kode_barang',$kodeBarang);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getStokByInvType($kodeBarang,$invType,$tglDari=null)
    {
        $this->db->select('sum(tid.jumlah) ttl');
        $this->db->from("tbl_inventory_detail tid");
        $this->db->join("tbl_inventory ti","tid.id_inventory = ti.id_inventory");
        $this->db->where('ti.inv_type',$invType);
        $this->db->where('tid.kode_barang',$kodeBarang);
        if($tglDari){
            $this->db->where('tid.dtm_crt <=',$tglDari);
        }
        $pembelian = $this->db->get();
        return $pembelian->result();
    }
    public function getStokStep3($kodeBarang,$tglDari=null)
    {
        $pembelian = $this->getStokByInvType($kodeBarang,'RECEIPT_ORDER',$tglDari)[0]->ttl;
        $retur = $this->getStokByInvType($kodeBarang,'RETURN_STUFF',$tglDari)[0]->ttl;
        $retur2 = $this->getStokByInvType($kodeBarang,'RETURN_MONEY',$tglDari)[0]->ttl;
        $penjualan = $this->getStokByInvType($kodeBarang,'TRX_STUFF',$tglDari)[0]->ttl;
        $manufaktur_out = $this->getStokByInvType($kodeBarang,'MANUFAKTUR_OUT',$tglDari)[0]->ttl;
        $manufaktur_in = $this->getStokByInvType($kodeBarang,'MANUFAKTUR_IN',$tglDari)[0]->ttl;

        $stok = $pembelian - $retur - $retur2 - $penjualan - $manufaktur_out + $manufaktur_in;


       return $stok;
    }

    public function lastKodeManufaktur()
    {
        $this->db->select('kode_manufaktur');
        $this->db->from('tbl_manufaktur');
        $this->db->order_by('kode_manufaktur','desc');
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->result_array();
    
    }

    public function historyBarang($kodeBarang,$dari,$sampai)
    {
        $this->db->select('tid.dtm_crt,tid.jumlah,ti.inv_type,tid.id_inventory,ti.kode_purchase');
        $this->db->from('tbl_inventory_detail tid');
        $this->db->join('tbl_inventory ti','tid.id_inventory=ti.id_inventory');
        $this->db->where("tid.kode_barang = '$kodeBarang' and ti.dtm_crt between '$dari 00:00' and '$sampai 23:59' and ti.inv_type = 'RECEIPT_ORDER' or tid.kode_barang = '$kodeBarang' and ti.dtm_crt between '$dari 00:00' and '$sampai 23:59' and ti.inv_type = 'TRX_STUFF' or tid.kode_barang = '$kodeBarang' and ti.dtm_crt between '$dari 00:00' and '$sampai 23:59' and ti.inv_type = 'MANUFAKTUR_IN' or tid.kode_barang = '$kodeBarang' and ti.dtm_crt between '$dari 00:00' and '$sampai 23:59' and ti.inv_type = 'MANUFAKTUR_OUT' or tid.kode_barang = '$kodeBarang' and ti.dtm_crt between '$dari 00:00' and '$sampai 23:59' and ti.inv_type = 'RETURN_STUFF' or tid.kode_barang = '$kodeBarang' and ti.dtm_crt between '$dari 00:00' and '$sampai 23:59' and ti.inv_type = 'RETURN_MONEY' ");
        // $this->db->where(['tid.kode_barang' => $kodeBarang, 'tia.dtm_crt >=' => $dari." 00:00", "ti.dtm_crt <=" => $sampai." 23:59", "ti.inv_type" => 'RECEIPT_ORDER']);
        // $this->db->or_where(['tid.kode_barang' => $kodeBarang, 'ti.dtm_crt >=' => $dari." 00:00", "ti.dtm_crt <=" => $sampai." 23:59", "ti.inv_type" => 'TRX_STUFF']);
        $query = $this->db->get();
        return $query->result();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('kode_barang', $q);
	$this->db->or_like('nama_barang', $q);
	$this->db->or_like('id_kategori_barang', $q);
	$this->db->or_like('id_satuan_barang', $q);
	$this->db->or_like('harga', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('tbl_obat_alkes_bhp.kode_barang', $q);
	$this->db->or_like('tbl_obat_alkes_bhp.nama_barang', $q);
	$this->db->or_like('tbl_obat_alkes_bhp.id_kategori_barang', $q);
	$this->db->or_like('tbl_obat_alkes_bhp.id_satuan_barang', $q);
	$this->db->or_like('tbl_obat_alkes_bhp.harga', $q);
        $this->db->join('tbl_kategori_barang','tbl_kategori_barang.id_kategori_barang=tbl_obat_alkes_bhp.id_kategori_barang');
        $this->db->join('tbl_satuan_barang','tbl_satuan_barang.id_satuan=tbl_obat_alkes_bhp.id_satuan_barang');
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
    
    function json(){
        $this->datatables->select('kode_barang,nama_barang,nama_kategori as kategori_barang,nama_satuan as satuan_barang, barcode ,(CASE jenis_barang WHEN 1 THEN "Obat" WHEN 2 THEN "Alat Kesehatan" ELSE "BHP" END) as jenis_barang,harga,tbl_klinik.nama as klinik,(SELECT avg(pod.harga) AS hpp FROM tbl_purchase_d pod WHERE pod.kode_barang = tbl_obat_alkes_bhp.kode_barang) AS hpp');
        $this->datatables->from('tbl_obat_alkes_bhp');
        $this->datatables->join('tbl_kategori_barang', 'tbl_obat_alkes_bhp.id_kategori_barang=tbl_kategori_barang.id_kategori_barang','left');
        $this->datatables->join('tbl_satuan_barang', 'tbl_obat_alkes_bhp.id_satuan_barang=tbl_satuan_barang.id_satuan','left');
        $this->datatables->join('tbl_klinik','tbl_obat_alkes_bhp.id_klinik=tbl_klinik.id_klinik','left');
        $this->datatables->add_column('action', anchor(site_url('dataobat/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
                ".anchor(site_url('dataobat/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kode_barang');
            
        return $this->datatables->generate();
    }

    function get_data_obat($id_klinik = null)
    {
        $this->db->select('tbl_obat_alkes_bhp.*, tbl_pabrik.nama_pabrik');
        $this->db->join('tbl_pabrik','tbl_obat_alkes_bhp.kode_pabrik=tbl_pabrik.kode_pabrik', 'left');
        $this->db->where('tbl_obat_alkes_bhp.jenis_barang', '1'); //Get jenis barang = obat
        if($id_klinik != null)
            $this->db->where('tbl_obat_alkes_bhp.id_klinik', $id_klinik);
        
        return $this->db->get($this->table)->result();
    }
    function get_barang_all()
    {
        $this->db->select('tbl_obat_alkes_bhp.*, tbl_pabrik.nama_pabrik,nama_kategori as kategori_barang,nama_satuan as satuan_barang');
        $this->db->join('tbl_pabrik','tbl_obat_alkes_bhp.kode_pabrik=tbl_pabrik.kode_pabrik', 'left');
        $this->db->join('tbl_kategori_barang', 'tbl_obat_alkes_bhp.id_kategori_barang=tbl_kategori_barang.id_kategori_barang');
        $this->db->join('tbl_satuan_barang', 'tbl_obat_alkes_bhp.id_satuan_barang=tbl_satuan_barang.id_satuan');
        // $this->db->where('tbl_obat_alkes_bhp.jenis_barang', '1'); //Get jenis barang = obat

        return $this->db->get($this->table)->result();
    }

}

/* End of file Tbl_obat_alkes_bhp_model.php */
/* Location: ./application/models/Tbl_obat_alkes_bhp_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-09 11:24:01 */
/* http://harviacode.com */