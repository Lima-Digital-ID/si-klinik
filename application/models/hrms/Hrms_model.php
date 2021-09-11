<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hrms_model extends CI_Model
{

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

    // insert data
    function insert_setting($table, $data)
    {
        $this->db->insert($table, $data);
    }

    // update data
    function update($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    // delete data
    function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
    
    // function json_setting_gaji($id_klinik){
    //     $this->datatables->select('tbl_setting_gaji.*, tbl_pegawai.nama_pegawai, tbl_jabatan.nama_jabatan, tbl_setting_gaji.id_setting_gaji');
    //     $this->datatables->from('tbl_setting_gaji');
    //     $this->datatables->join('tbl_pegawai', 'tbl_pegawai.id_pegawai=tbl_setting_gaji.id_pegawai');
    //     $this->datatables->join('tbl_jabatan', 'tbl_jabatan.id_jabatan=tbl_pegawai.id_jabatan');
    //     if ($id_klinik != null) {
    //         $this->datatables->where('tbl_pegawai.id_klinik', $id_klinik);
    //     }
    //     $this->datatables->add_column('action', anchor(site_url('hrms/ref_gaji/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','class="btn btn-success btn-sm"')." 
    //             ".anchor(site_url('hrms/ref_gaji/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_ref_gaji');
            
    //     return $this->datatables->generate();
    // }
    function get_setting_by_id($id)
    {
        $this->db->where('id_setting_gaji', $id);
        return $this->db->get('tbl_setting_gaji')->row();
    }
    function json_setting_gaji($id_klinik){
        $this->db->select('tbl_setting_gaji.*, tbl_pegawai.nama_pegawai, tbl_jabatan.nama_jabatan, tbl_setting_gaji.id_setting_gaji');
        $this->db->from('tbl_setting_gaji');
        $this->db->join('tbl_pegawai', 'tbl_pegawai.id_pegawai=tbl_setting_gaji.id_pegawai');
        $this->db->join('tbl_jabatan', 'tbl_jabatan.id_jabatan=tbl_pegawai.id_jabatan');
        if ($id_klinik != null) {
            $this->db->where('tbl_pegawai.id_klinik', $id_klinik);
        }

        return $this->db->get()->result();
    }

    function get_by_jabatan($id)
    {
        $this->db->where('id_jabatan', $id);
        return $this->db->get($this->table)->row();
    }
    function get_absensi($date, $id_klinik)
    {
        $this->db->select('tbl_absensi_pegawai.*, tbl_pegawai.nama_pegawai');
        $this->db->from('tbl_absensi_pegawai');
        $this->db->join('tbl_pegawai', 'tbl_pegawai.id_pegawai=tbl_absensi_pegawai.id_pegawai', 'right');
        $this->db->where('tanggal', date('Y-m-d'));
        if ($id_klinik != null) {
            $this->db->where('tbl_pegawai.id_klinik', $id_klinik);
        }
        return $this->db->get()->result();
    }
    function get_absensi_by_id_pegawai($id, $date)
    {
        $this->db->select('tbl_absensi_pegawai.*, tbl_pegawai.nama_pegawai');
        $this->db->from('tbl_absensi_pegawai');
        $this->db->join('tbl_pegawai', 'tbl_pegawai.id_pegawai=tbl_absensi_pegawai.id_pegawai', 'right');
        $this->db->where('tbl_pegawai.id_pegawai', $id);
        $this->db->where('tbl_absensi_pegawai.tanggal', $date);
        return $this->db->get()->row();
    }
    function get_absensi_pegawai_by_day($id, $date){
        $this->db->select('tbl_absensi_pegawai.*, tbl_pegawai.nama_pegawai');
        $this->db->from('tbl_absensi_pegawai');
        $this->db->join('tbl_pegawai', 'tbl_pegawai.id_pegawai=tbl_absensi_pegawai.id_pegawai', 'right');
        $this->db->where('tbl_pegawai.id_pegawai', $id);
        $this->db->where('tbl_absensi_pegawai.tanggal', $date);
        return $this->db->get()->row();
    }

    function get_absensi_pegawai_by_month($id, $date){
        $this->db->select('tbl_absensi_pegawai.*, tbl_pegawai.nama_pegawai, tbl_shift.jam_datang as jadwal_datang_shift, tbl_shift.jam_pulang as jadwal_pulang_shift');
        $this->db->from('tbl_absensi_pegawai');
        $this->db->join('tbl_pegawai', 'tbl_pegawai.id_pegawai=tbl_absensi_pegawai.id_pegawai', 'right');
        $this->db->join('tbl_shift', 'tbl_shift.id_shift=tbl_absensi_pegawai.id_shift', 'right');
        $this->db->where('tbl_pegawai.id_pegawai', $id);
        $this->db->where('tbl_absensi_pegawai.jam_datang !=', '00:00:00');
        $this->db->like('tbl_absensi_pegawai.tanggal', $date, 'after');
        return $this->db->get()->result();
    }
    function get_gaji_by_pegawai($id){
        $this->db->select('*');
        $this->db->from('tbl_setting_gaji');
        $this->db->join('tbl_pegawai', 'tbl_pegawai.id_pegawai=tbl_setting_gaji.id_pegawai');
        $this->db->join('tbl_jabatan', 'tbl_jabatan.id_jabatan=tbl_pegawai.id_jabatan');
        $this->db->where('tbl_pegawai.id_pegawai', $id);
        return $this->db->get()->result();
    }
    function get_potongan($id, $date){
        $this->db->select('potongan_bpjs, cicilan, kasbon');
        $this->db->from('tbl_potongan_gaji');
        $this->db->where('id_pegawai', $id);
        $this->db->where('bulan', $date);
        return $this->db->get()->row();
    }

}

/* End of file Tbl_pasien_model.php */
/* Location: ./application/models/Tbl_pasien_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-03 15:02:10 */
/* http://harviacode.com */