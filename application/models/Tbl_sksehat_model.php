<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_sksehat_model extends CI_Model
{

    public $table = 'tbl_sksehat';
    public $id = 'nomor';

    public function insert($val)
    {
        $this->db->insert($this->table,$val);
    }

    public function getLastNomor()
    {
        $this->db->select('nomor');
        $this->db->order_by('nomor','desc');
        $this->db->limit(1);
        return $this->db->get($this->table,['MONTH(tgl_cetak)' => date('m'),'YEAR(tgl_cetak)' => date('Y')])->result();
    }
    public function skBelumBayar($idKlinik)
    {
        $this->datatables->select('sk.nomor,sk.nama');
        $this->datatables->from($this->table." as sk");
        $this->datatables->join('tbl_transaksi tr','sk.nomor = tr.no_transaksi');
        $this->datatables->where(['tr.id_klinik' => $idKlinik,'tr.status_transaksi'=>'0']);
        $this->datatables->add_column('action',anchor(site_url('pembayaran/sksehat?nomor=$1'),'Bayar','class="btn btn-danger btn-sm"'),'nomor');
        $this->datatables->add_column('status','Belum Membayar');

        return $this->datatables->generate();

    }
    public function getDetail($nomor)
    {
        $this->db->select("sk.*,d.nama_dokter");
        $this->db->join("tbl_dokter d","sk.id_dokter = d.id_dokter");
        $this->db->where('sk.nomor',$nomor);
        return $this->db->get($this->table." sk")->result_array()[0];
    }
}