<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_sequence_model extends CI_Model
{

    public $table = 'tbl_master_sequence';
    public $id = 'id_master_sequence';

    function __construct()
    {
        parent::__construct();
    }
	
	function set_code_by_master_seq_code($master_seq_code, $is_save = false){
		//$row = get_master_sequence_by_master_seq_code($master_seq_code);
		$this->db->where('master_seq_code', $master_seq_code);
        $row = $this->db->get($this->table)->row();
		
		$seq_no = $row->seq_no;
		$length_no = $row->length_no;
		
		$code = "";
		for($i = strlen((string)$seq_no); $i<$length_no; $i++){
			$code .= "0";
		}
		$code .= (string)($seq_no+1);
		
		if($is_save){
			$sql = "UPDATE tbl_master_sequence SET seq_no = ". ($seq_no+1) .", dtm_upd = NOW() 
                WHERE master_seq_code = '" . $master_seq_code . "'";
			$result = $this->db->query($sql);
		}
		
		return $code;
	}
}
