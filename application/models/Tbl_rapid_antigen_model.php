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
        $this->db->where(['MONTH(tgl_pemeriksaan)' => date('m'), 'YEAR(tgl_pemeriksaan)' => date('Y')]);
        $this->db->order_by('id_rapid','desc');
        $this->db->limit(1);
        return $this->db->get($this->table)->result();
    }
    public function listPemeriksaanDokter($id_dokter)
    {
        $this->datatables->select('id_rapid,no_sampel,nama,nik_or_passport');
        $this->datatables->from($this->table);
        $this->datatables->where(['id_dokter' => $id_dokter,'status' => '0']);
        $this->db->order_by('id_rapid','asc');
        $this->datatables->add_column('Periksa', anchor(site_url('rapid_antigen/periksa/$1'),'<i class="fa fa-stethoscope"></i> Periksa','class="btn btn-success btn-sm"'),'id_rapid');

        return $this->datatables->generate();

    }
    public function detailRapid($id)
    {
        $this->db->select("tbl_dokter.nama_dokter,".$this->table.".*");
        $this->db->join('tbl_dokter',$this->table.".id_dokter = tbl_dokter.id_dokter");
        $this->db->where(['id_rapid' => $id]);
        return $this->db->get($this->table)->result()[0];
    }
}