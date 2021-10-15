<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jasa_model extends CI_Model
{
    public $table = 'tbl_tipe_periksa_jasa';
    public $id = 'id_tipe';
    public $order = 'DESC';

    public function json()
    {
        $this->datatables->select("id_tipe,item,harga");
        $this->datatables->from($this->table);
        $this->datatables->add_column('action', 
                anchor(site_url('jasa/edit/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-success btn-sm'))." 
                ".anchor(site_url('jasa/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_tipe');
            
        return $this->datatables->generate();
    }
    public function insert($data)
    {
        $this->db->insert($this->table,$data);
    }
    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
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

}