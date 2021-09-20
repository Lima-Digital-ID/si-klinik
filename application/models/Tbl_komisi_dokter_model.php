<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_komisi_dokter_model extends CI_Model
{

    public $table = 'tbl_komisi_dokter';

    public function insert($val)
    {
        $this->db->insert($this->table,$val);
    }
    public function getMasterKomisi($idDokter)
    {
        $this->db->select('komisi_biaya_pemeriksaan,komisi_biaya_tindakan,komisi_biaya_obat');
        return $this->db->get_where('tbl_dokter',['id_dokter' => $idDokter])->row();
    }
    public function getKomisi($idDokter,$dari,$sampai)
    {
        return $this->db->get_where($this->table,['id_dokter' => $idDokter, 'tanggal >=' => $dari, 'tanggal <=' => $sampai])->result();
    }
}