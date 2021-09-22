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
    public function jsonSk($idKlinik,$status)
    {
        $this->datatables->select('sk.nomor,sk.nama,tr.id_transaksi');
        $this->datatables->from($this->table." as sk");
        $this->datatables->join('tbl_transaksi tr','sk.nomor = tr.no_transaksi');
        $this->datatables->where(['tr.id_klinik' => $idKlinik,'tr.status_transaksi'=>$status]);
        if($status=='0'){
            $this->datatables->add_column('action',anchor(site_url('pembayaran/bayar/$1?tab=sks'),'Bayar','class="btn btn-danger btn-sm"'),'id_transaksi');
        }
        else{
            $this->datatables->add_column('action',anchor(site_url('pembayaran/cetak_surat/$1?tab=sks'),'Cetak Kwitansi','class="btn btn-warning btn-sm"'),'id_transaksi');
            $this->datatables->add_column('cetak',anchor(site_url('pembayaran/cetak-sksehat?nomor=$1'),'Cetak SK Sehat','class="btn btn-danger btn-sm"'),'nomor');
        }
        $this->datatables->add_column('status',$status=='0' ? 'Belum Membayar' : 'Lunas');

        return $this->datatables->generate();

    }
    public function getDetail($nomor,$select="")
    {
        $s = $select!="" ? $select : "sk.*,d.nama_dokter";
        $this->db->select($s);
        $this->db->join("tbl_dokter d","sk.id_dokter = d.id_dokter");
        $this->db->where('sk.nomor',$nomor);
        return $this->db->get($this->table." sk")->result_array()[0];
    }
}