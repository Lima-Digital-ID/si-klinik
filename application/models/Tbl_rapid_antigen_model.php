<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_rapid_antigen_model extends CI_Model
{

    public $table = 'tbl_rapid_antigen';

    public function insert($val)
    {
        $this->db->insert($this->table,$val);
    }
    public function update($val,$id)
    {
        $this->db->update($this->table,$val,['id_rapid' => $id]);
    }
    public function getNoSampel($id)
    {
        $this->db->select('no_sampel');
        return $this->db->get_where($this->table,['id_rapid' => $id])->result()[0];
    }
    public function getKode()
    {
        $this->db->select('no_sampel');
        $this->db->where(['MONTH(tgl_buat)' => date('m'), 'YEAR(tgl_buat)' => date('Y')]);
        $this->db->order_by('id_rapid','desc');
        $this->db->limit(1);
        return $this->db->get($this->table)->result();
    }
    public function listPemeriksaanDokter()
    {
        $this->datatables->select('id_rapid,no_sampel,nama,nik_or_passport');
        $this->datatables->from($this->table);
        $this->datatables->where(['status' => '0']);
        $this->db->order_by('id_rapid','asc');
        $this->datatables->add_column('Periksa', anchor(site_url('rapid_antigen/periksa/$1'),'<i class="fa fa-stethoscope"></i> Periksa','class="btn btn-success btn-sm"'),'id_rapid');

        return $this->datatables->generate();

    }
    public function jsonRapid($id_klinik,$status)
    {
        $this->datatables->select('r.no_sampel,r.nama,r.nik_or_passport,tr.id_transaksi');
        $this->datatables->from($this->table." as r");
        $this->datatables->join('tbl_transaksi tr','r.no_sampel = tr.no_transaksi');
        $this->datatables->where(['tr.id_klinik' => $id_klinik,'status_transaksi' => $status]);
        if($status=='0'){
            $this->datatables->add_column('action',anchor(site_url('pembayaran/bayar/$1?tab=rapid'),'Bayar','class="btn btn-danger btn-sm"'),'id_transaksi');
        }
        else{
            $this->datatables->add_column('action',anchor(site_url('pembayaran/cetak_surat/$1?tab=rapid'),'Cetak Kwitansi','class="btn btn-warning btn-sm"'),'id_transaksi');
            $this->datatables->add_column('cetak',anchor(site_url('rapid_antigen/preview?sampel=$1'),'Cetak Surat Rapid Antigen','class="btn btn-danger btn-sm"'),'no_sampel');
        }
        $this->datatables->add_column('status',$status=='0' ? 'Belum Membayar' : 'Lunas');

        return $this->datatables->generate();
    }    
    public function detailRapid($id,$select="")
    {
        $s = $select!="" ? $select : "tbl_dokter.nama_dokter,".$this->table.".*";
        $this->db->select($s);
        $this->db->join('tbl_dokter',$this->table.".id_dokter = tbl_dokter.id_dokter",'left');
        $this->db->where(['id_rapid' => $id]);
        return $this->db->get($this->table)->result()[0];
    }
    public function cekPeriksa($id)
    {
        return $this->db->get_where($this->table,['id_rapid' => $id,'status' => '1'])->num_rows();
    }
}