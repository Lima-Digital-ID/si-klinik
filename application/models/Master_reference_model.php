<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_reference_model extends CI_Model
{

    public $table = 'tbl_master_reference';
    public $id = 'id';
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
    
    function get_all_group_by_mastercode()
    {
        $this->db->select('master_ref_code');
        $this->db->order_by('master_ref_code', 'asc');
        $this->db->group_by('master_ref_code');
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    function get_by_value($value,$code)
    {
        $this->db->where('master_ref_value', $value);
        $this->db->where('master_ref_code', $code);
        return $this->db->get($this->table)->row();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
    
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
    
    function json($filter = null){
        $this->datatables->select('mr.id, mr.*');
        $this->datatables->from('tbl_master_reference mr');
        
        if($filter != null || $filter != '')
            $this->datatables->where('mr.master_ref_code',$filter);
        
        $this->datatables->add_column('action', anchor(site_url('master_ref/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-success btn-sm'))." 
                ".anchor(site_url('master_ref/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
            
        return $this->datatables->generate();
    }
}
