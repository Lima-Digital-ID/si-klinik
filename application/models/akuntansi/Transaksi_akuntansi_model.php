<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaksi_akuntansi_model extends CI_Model
{   

    public $table = 'tbl_trx_akuntansi';
    public $id = 'id_trx_akun';
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

    // get data by id
    function get_trx_detail($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get('tbl_trx_akuntansi_detail')->result();
    }

    // insert data
    function insert($table, $data)
    {
        $insert=$this->db->insert($table, $data);
        if (!$insert) {
            return false;
        }
        return true;
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
        $this->datatables->select('*, id_trx_akun');
        $this->datatables->from('tbl_trx_akuntansi');
        $this->datatables->add_column('action', anchor('#','<i class="fa fa-eye" aria-hidden="true"></i>',"class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal' onClick='javasciprt: cekDetail(\"$1\")'")."
                ".anchor(site_url('hrms/ref_gaji/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_trx_akun');
            
                // ".anchor(site_url('hrms/ref_gaji/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." ;
        return $this->datatables->generate();
    }

    function getDetailKas($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_trx_akuntansi tra');
        $this->db->join('tbl_trx_akuntansi_detail trd', 'tra.id_trx_akun=trd.id_trx_akun');
        $this->db->join('tbl_akun ta', 'ta.id_akun=trd.id_akun');
        $this->db->where('tra.id_trx_akun', $id);
        $this->db->order_by('trd.keterangan');
        return $this->db->get()->result();
    }

    function getJurnalByDate($date)
    {
        // $this->db->like('tanggal', $date, 'after');
        $this->db->where('tanggal', $date);
        $this->db->order_by('tanggal');
        return $this->db->get('tbl_trx_akuntansi')->result();
    }
    function getJurnalPettyByDate($date, $id)
    {
        $this->db->select('tra.id_trx_akun');
        $this->db->from('tbl_trx_akuntansi tra');
        $this->db->join('tbl_trx_akuntansi_detail trd', 'tra.id_trx_akun=trd.id_trx_akun');
        $this->db->where('trd.id_akun', 35);
        $this->db->like('tra.tanggal', $date, 'after');
        $this->db->order_by('tra.tanggal');
        return $this->db->get()->result();
    }
    function getJurnalRTByDate($date)
    {
        $this->db->select('tra.id_trx_akun');
        $this->db->from('tbl_trx_akuntansi tra');
        $this->db->join('tbl_trx_akuntansi_detail trd', 'tra.id_trx_akun=trd.id_trx_akun');
        $this->db->where('trd.id_akun', 36);
        $this->db->like('tra.tanggal', $date, 'after');
        $this->db->order_by('tra.tanggal');
        return $this->db->get()->result();
    }

}

/* End of file Tbl_pasien_model.php */
/* Location: ./application/models/Tbl_pasien_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-03 15:02:10 */
/* http://harviacode.com */