<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Akuntansi_model extends CI_Model
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
    function insert($data)
    {
        $this->db->insert($this->table, $data);
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
    
    function getListAkun(){
        $this->datatables->select('*, id_akun');
        $this->datatables->from('tbl_akun');
        $this->datatables->where('level !=', 0);
        $this->datatables->add_column('action', anchor(site_url('akuntansi/akun/detailBukuBesar/$1'),'<i class="fa fa-list" aria-hidden="true"></i>','class="btn btn-info btn-sm" title="Detail"'), 'id_akun');            
        return $this->datatables->generate();
    }
    function getDetailBukuBesar($date, $id)
    {
        // $db=$this->db->query('SELECT COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
        //   JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
        //   WHERE tra.tanggal=tra1.tanggal and trd.id_akun=trd2.id_akun and tipe="KREDIT"), 0) AS jumlah_kredit, 
        //   COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
        //   JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
        //   WHERE  tra.tanggal=tra1.tanggal and trd.id_akun=trd2.id_akun and tipe="DEBIT"), 0) AS jumlah_debit, 
        //   tra1.tanggal FROM tbl_trx_akuntansi tra1 
        //   JOIN tbl_trx_akuntansi_detail trd2 on trd2.id_trx_akun=tra1.id_trx_akun WHERE tra1.tanggal LIKE "'.$date.'%" AND trd2.id_akun='.$id.' GROUP by tra1.tanggal');
        // // $this->db->order_by('tanggal');
        // return $db->result();

        // $db=$this->db->query('SELECT COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
        //   JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
        //   WHERE tra.tanggal=tra1.tanggal and trd.id_akun=trd2.id_akun and tipe="KREDIT"), 0) AS jumlah_kredit, 
        //   COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
        //   JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
        //   WHERE  tra.tanggal=tra1.tanggal and trd.id_akun=trd2.id_akun and tipe="DEBIT"), 0) AS jumlah_debit, trd2.id_akun,
        //   tra1.tanggal FROM tbl_trx_akuntansi tra1 
        //   JOIN tbl_trx_akuntansi_detail trd2 on trd2.id_trx_akun=tra1.id_trx_akun WHERE tra1.tanggal LIKE "'.$date.'%" AND trd2.id_akun='.$id.' OR trd2.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE id_parent='.$id.') OR trd2.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan1='.$id.') OR trd2.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan2='.$id.') GROUP by tra1.tanggal, trd2.id_akun');
        $db=$this->db->query('SELECT COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal=tra1.tanggal  and tipe="KREDIT" AND trd.id_akun='.$id.'), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal=tra1.tanggal  and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE id_parent='.$id.')), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal=tra1.tanggal  and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan1='.$id.')), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal=tra1.tanggal  and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan2='.$id.')), 0) AS jumlah_kredit, COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal=tra1.tanggal  and tipe="DEBIT" AND trd.id_akun='.$id.'), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal=tra1.tanggal  and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE id_parent='.$id.')), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal=tra1.tanggal  and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan1='.$id.')), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal=tra1.tanggal  and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan2='.$id.')), 0) AS jumlah_debit,
          tra1.tanggal FROM tbl_trx_akuntansi tra1 
          JOIN tbl_trx_akuntansi_detail trd2 on trd2.id_trx_akun=tra1.id_trx_akun WHERE tra1.tanggal LIKE "'.$date.'%" GROUP by tra1.tanggal');
        
        return $db->result();        
    }
    //get saldo akun dari jurnal
    // SELECT COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
    //       JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
    //       WHERE tra.tanggal LIKE "2019-12%"  and tipe="KREDIT" AND trd.id_akun=tad2.id_akun), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
    //       JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
    //       WHERE tra.tanggal LIKE "2019-12%" and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE id_parent=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
    //       JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
    //       WHERE tra.tanggal LIKE "2019-12%" and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan1=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
    //       JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
    //       WHERE tra.tanggal LIKE "2019-12%" and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan2=tad2.id_akun)), 0) AS jumlah_kredit, COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
    //       JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
    //       WHERE tra.tanggal LIKE "2019-12%" and tipe="DEBIT" AND trd.id_akun=tad2.id_akun), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
    //       JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
    //       WHERE tra.tanggal LIKE "2019-12%" and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE id_parent=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
    //       JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
    //       WHERE tra.tanggal LIKE "2019-12%" and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan1=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
    //       JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
    //       WHERE tra.tanggal LIKE "2019-12%" and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan2=tad2.id_akun)), 0) AS jumlah_kredit, tad2.turunan1,
    //       tra1.tanggal, tad2.id_akun, ta.nama_akun FROM tbl_trx_akuntansi tra1 
    //       JOIN tbl_trx_akuntansi_detail trd2 on trd2.id_trx_akun=tra1.id_trx_akun JOIN tbl_akun_detail tad2 on tad2.id_akun=trd2.id_akun JOIN tbl_akun ta on ta.id_akun=trd2.id_akun WHERE tra1.tanggal LIKE "2019-12%" AND tad2.turunan1 = 0 OR tad2.turunan1 IS null GROUP BY tad2.id_akun ORDER BY ta.no_akun
    
    function getSaldoAkun($id, $date){
        $db=$this->db->query('SELECT COALESCE((SELECT SUM(tsa1.jumlah_saldo) FROM tbl_saldo_akun tsa1 WHERE tsa1.tanggal LIKE "'.$date.'%" 
            AND tsa1.is_updated=0 AND tsa1.id_akun='.$id.'), 0) + COALESCE((SELECT SUM(tsa1.jumlah_saldo) FROM tbl_saldo_akun tsa1 WHERE tsa1.tanggal LIKE "'.$date.'%" 
            AND tsa1.is_updated=0 AND tsa1.id_akun IN (SELECT tad.id_akun FROM tbl_akun_detail tad WHERE tad.turunan1='.$id.')), 0) + COALESCE((SELECT SUM(tsa1.jumlah_saldo) 
            FROM tbl_saldo_akun tsa1 WHERE tsa1.tanggal LIKE "'.$date.'%" AND tsa1.is_updated=0 AND tsa1.id_akun IN 
            (SELECT tad.id_akun FROM tbl_akun_detail tad WHERE tad.turunan2='.$id.')), 0) + COALESCE((SELECT SUM(tsa1.jumlah_saldo) FROM 
            tbl_saldo_akun tsa1 WHERE tsa1.tanggal LIKE "'.$date.'%" AND tsa1.is_updated=0 AND tsa1.id_akun IN (SELECT tad.id_akun FROM tbl_akun_detail tad WHERE tad.turunan3='.$id.')), 0) AS jumlah_saldo');
        return $db->row();
    }
    function cekAllJurnal($date){
        $db=$this->db->query('SELECT COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%"  and tipe="KREDIT" AND trd.id_akun=tad2.id_akun), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE id_parent=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan1=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan2=tad2.id_akun)), 0) AS jumlah_kredit, COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="DEBIT" AND trd.id_akun=tad2.id_akun), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE id_parent=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan1=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan2=tad2.id_akun)), 0) AS jumlah_debit, MAX(tad2.turunan1) as turunan1,
          MAX(tra1.tanggal) as tanggal, MAX(tad2.id_akun) as id_akun, MAX(tad2.id_parent) as id_parent, MAX(ta.nama_akun) as nama_akun, MAX(ta.no_akun) as no_akun FROM tbl_trx_akuntansi tra1 
          JOIN tbl_trx_akuntansi_detail trd2 on trd2.id_trx_akun=tra1.id_trx_akun JOIN tbl_akun_detail tad2 on tad2.id_akun=trd2.id_akun JOIN tbl_akun ta on ta.id_akun=trd2.id_akun WHERE tra1.tanggal LIKE "'.$date.'%" AND tad2.turunan1 = 0 OR tad2.turunan2 = 0  GROUP BY tad2.id_akun ORDER BY ta.no_akun');
        // $db=$this->db->query('SELECT COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd JOIN tbl_trx_akuntansi tra ON 
        //     tra.id_trx_akun=trd.id_trx_akun WHERE trd.id_akun=trd2.id_akun AND trd.tipe="KREDIT" AND tra.tanggal LIKE "'.$date.'%"), 0) AS jumlah_kredit, 
        //     COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd JOIN tbl_trx_akuntansi tra ON tra.id_trx_akun=trd.id_trx_akun 
        //         WHERE trd.id_akun=trd2.id_akun AND trd.tipe="DEBIT" AND tra.tanggal LIKE "'.$date.'%"), 0) AS jumlah_debit, trd2.id_akun, ta2.no_akun, ta2.nama_akun, tad2.id_parent 
        //     FROM `tbl_trx_akuntansi_detail` trd2 JOIN tbl_akun_detail tad2 ON trd2.id_akun=tad2.id_akun JOIN tbl_trx_akuntansi tra2 ON trd2.id_trx_akun=tra2.id_trx_akun JOIN tbl_akun ta2 
        //     ON ta2.id_akun=tad2.id_akun WHERE tra2.tanggal LIKE "'.$date.'%" GROUP BY trd2.id_akun ORDER BY ta2.no_akun');
        return $db->result();
    }
    function rekapPengeluaran($date){
      $db=$this->db->query('SELECT COALESCE((SELECT SUM(jumlah) AS jumlah FROM `tbl_trx_akuntansi` tra JOIN tbl_trx_akuntansi_detail trd ON 
        trd.id_trx_akun=tra.id_trx_akun WHERE trd.id_akun=tad2.id_akun AND DATE(tra.tanggal) >= "'.$date.'" AND DATE(tra.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 1 WEEK)), 0) as minggu1, COALESCE((SELECT SUM(jumlah) AS jumlah FROM `tbl_trx_akuntansi` tra JOIN 
        tbl_trx_akuntansi_detail trd ON trd.id_trx_akun=tra.id_trx_akun WHERE trd.id_akun=tad2.id_akun AND DATE(tra.tanggal) >= 
        (DATE("'.$date.'") + INTERVAL 1 WEEK) AND DATE(tra.tanggal) <= (DATE("'.$date.'") + INTERVAL 2 WEEK)), 0) as minggu2, 
      COALESCE((SELECT SUM(jumlah) AS jumlah FROM `tbl_trx_akuntansi` tra JOIN tbl_trx_akuntansi_detail trd ON trd.id_trx_akun=tra.id_trx_akun 
        WHERE trd.id_akun=tad2.id_akun AND DATE(tra.tanggal) >= (DATE("'.$date.'") + INTERVAL 2 WEEK) AND DATE(tra.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 3 WEEK)), 0) as minggu3, COALESCE((SELECT SUM(jumlah) AS jumlah FROM `tbl_trx_akuntansi` tra JOIN 
        tbl_trx_akuntansi_detail trd ON trd.id_trx_akun=tra.id_trx_akun WHERE trd.id_akun=tad2.id_akun AND DATE(tra.tanggal) >= 
        (DATE("'.$date.'") + INTERVAL 3 WEEK) AND DATE(tra.tanggal) <= (DATE("'.$date.'") + INTERVAL 4 WEEK)), 0) as minggu4, 
        tad2.id_akun FROM tbl_akun_detail tad2 WHERE tad2.id_akun=35 OR tad2.id_akun=36 OR tad2.id_akun=67 OR tad2.id_akun=66');
        return $db->result();
    }
    function rekapPettyCash($date){
      $db=$this->db->query('SELECT ta.no_akun, ta.id_akun, ta.nama_akun, tra.deskripsi, tra.tanggal, trd.jumlah, trd.tipe FROM tbl_trx_akuntansi tra JOIN tbl_trx_akuntansi_detail trd ON tra.id_trx_akun=trd.id_trx_akun JOIN tbl_akun ta ON ta.id_akun=trd.id_akun WHERE tra.tanggal LIKE "'.$date.'%" AND tipe="DEBIT" AND tra.id_trx_akun IN (SELECT id_trx_akun FROM tbl_trx_akuntansi_detail WHERE id_akun=35) ORDER BY tra.tanggal');
      return $db->result();
    }

    function rekapRT($date){
      $db=$this->db->query('SELECT ta.no_akun, ta.id_akun, ta.nama_akun, tra.deskripsi, tra.tanggal, trd.jumlah, trd.tipe FROM tbl_trx_akuntansi tra JOIN tbl_trx_akuntansi_detail trd ON tra.id_trx_akun=trd.id_trx_akun JOIN tbl_akun ta ON ta.id_akun=trd.id_akun WHERE tra.tanggal LIKE "'.$date.'%" AND tipe="DEBIT" AND tra.id_trx_akun IN (SELECT id_trx_akun FROM tbl_trx_akuntansi_detail WHERE id_akun=36) ORDER BY tra.tanggal');
      return $db->result();
    }

    function cekSaldoKas($date)
    {
        $db=$this->db->query('SELECT SUM(jumlah_saldo) as jumlah_saldo FROM `tbl_saldo_akun` JOIN tbl_akun_detail ON tbl_saldo_akun.id_akun=tbl_akun_detail.id_akun WHERE tbl_akun_detail.id_parent=3 AND is_updated=0 AND tanggal LIKE "'.$date.'%" AND tbl_akun_detail.turunan1=20');
        return $db->row();
    }
    function cekBukuBesar($id, $date){
        $this->db->select('id_akun, tanggal');
        $this->db->from('tbl_saldo_akun');
        $this->db->where('id_akun', $id);
        $this->db->like('tanggal', $date, 'after');
        return $this->db->get()->num_rows();
    }
    function rekap_all($date){
      $db=$this->db->query('SELECT SUM(jumlah) as jumlah, MAX(trd.id_akun) as id_akun, MAX(trd.id_trx_akun) AS id_trx_akun, MAX(ta.nama_akun) as rincian, COALESCE((SELECT nama_akun FROM tbl_trx_akuntansi_detail JOIN tbl_akun ON tbl_akun.id_akun=tbl_trx_akuntansi_detail.id_akun WHERE tbl_trx_akuntansi_detail.id_trx_akun=trd.id_trx_akun AND tbl_trx_akuntansi_detail.tipe="KREDIT")) AS nama_akun FROM `tbl_trx_akuntansi` JOIN tbl_trx_akuntansi_detail trd ON trd.id_trx_akun=tbl_trx_akuntansi.id_trx_akun JOIN tbl_akun ta ON ta.id_akun=trd.id_akun WHERE tbl_trx_akuntansi.id_trx_akun in (SELECT id_trx_akun FROM tbl_trx_akuntansi_detail WHERE id_akun=35 OR id_akun=36 OR id_akun=66 OR id_akun=67) AND tipe="DEBIT" AND tanggal LIKE "'.$date.'%" AND trd.id_akun != 35 AND trd.id_akun != 36 GROUP BY trd.id_akun');
      return $db->result();
    }
    function get_laba_rugi($id, $date){
        $db=$this->db->query('SELECT COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%"  and tipe="KREDIT" AND trd.id_akun=tad2.id_akun), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE id_parent=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan1=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="KREDIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan2=tad2.id_akun)), 0) AS jumlah_kredit, COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="DEBIT" AND trd.id_akun=tad2.id_akun), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE id_parent=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan1=tad2.id_akun)), 0) + COALESCE((SELECT SUM(trd.jumlah) FROM tbl_trx_akuntansi_detail trd 
          JOIN tbl_trx_akuntansi tra ON trd.id_trx_akun=tra.id_trx_akun 
          WHERE tra.tanggal LIKE "'.$date.'%" and tipe="DEBIT" AND trd.id_akun IN ( SELECT id_akun FROM tbl_akun_detail WHERE turunan2=tad2.id_akun)), 0) AS jumlah_debit, MAX(tad2.turunan1) as turunan1,
          MAX(tra1.tanggal) as tanggal, MAX(tad2.id_akun) as id_akun, MAX(tad2.id_parent) as id_parent, MAX(ta.nama_akun) as nama_akun, MAX(ta.no_akun) as no_akun FROM tbl_trx_akuntansi tra1 
          JOIN tbl_trx_akuntansi_detail trd2 on trd2.id_trx_akun=tra1.id_trx_akun JOIN tbl_akun_detail tad2 on tad2.id_akun=trd2.id_akun JOIN tbl_akun ta on ta.id_akun=trd2.id_akun WHERE tra1.tanggal LIKE "'.$date.'%" AND tad2.id_parent="'.$id.'"  GROUP BY tad2.id_akun ORDER BY ta.no_akun');
        return $db->result();
    }
    function rekap_mingguan($minggu, $date){
      // if ($minggu == 1) {
      //   $db=$this->db->query('SELECT tra.*, trd.jumlah, trd.tipe, trd.id_akun, ta.nama_akun FROM `tbl_trx_akuntansi` tra JOIN tbl_trx_akuntansi_detail trd ON 
      //   trd.id_trx_akun=tra.id_trx_akun JOIN tbl_akun ta ON 
      //   trd.id_akun=ta.id_akun WHERE trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
      //   trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=35 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= "'.$date.'" AND DATE(tra2.tanggal) <= 
      //   (DATE("'.$date.'") + INTERVAL 1 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
      //   trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=36 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= "'.$date.'" AND DATE(tra2.tanggal) <= 
      //   (DATE("'.$date.'") + INTERVAL 1 WEEK))');
      // }else if ($minggu == 2) {
      //   $db=$this->db->query('SELECT tra.*, trd.jumlah, trd.tipe, trd.id_akun, ta.nama_akun FROM `tbl_trx_akuntansi` tra JOIN tbl_trx_akuntansi_detail trd ON 
      //   trd.id_trx_akun=tra.id_trx_akun JOIN tbl_akun ta ON 
      //   trd.id_akun=ta.id_akun WHERE trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
      //   trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=35 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 1 WEEK) AND DATE(tra2.tanggal) <= 
      //   (DATE("'.$date.'") + INTERVAL 2 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
      //   trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=36 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 1 WEEK) AND DATE(tra2.tanggal) <= 
      //   (DATE("'.$date.'") + INTERVAL 2 WEEK))');
      // }else if ($minggu == 3) {
      //   $db=$this->db->query('SELECT tra.*, trd.jumlah, trd.tipe, trd.id_akun, ta.nama_akun FROM `tbl_trx_akuntansi` tra JOIN tbl_trx_akuntansi_detail trd ON 
      //   trd.id_trx_akun=tra.id_trx_akun JOIN tbl_akun ta ON 
      //   trd.id_akun=ta.id_akun WHERE trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
      //   trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=35 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 2 WEEK) AND DATE(tra2.tanggal) <= 
      //   (DATE("'.$date.'") + INTERVAL 3 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
      //   trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=36 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 2 WEEK) AND DATE(tra2.tanggal) <= 
      //   (DATE("'.$date.'") + INTERVAL 3 WEEK))');
      // }else{
      //   $db=$this->db->query('SELECT tra.*, trd.jumlah, trd.tipe, trd.id_akun, ta.nama_akun FROM `tbl_trx_akuntansi` tra JOIN tbl_trx_akuntansi_detail trd ON 
      //   trd.id_trx_akun=tra.id_trx_akun JOIN tbl_akun ta ON 
      //   trd.id_akun=ta.id_akun WHERE trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
      //   trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=35 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 3 WEEK) AND DATE(tra2.tanggal) <= 
      //   (DATE("'.$date.'") + INTERVAL 4 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
      //   trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=36 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 3 WEEK) AND DATE(tra2.tanggal) <= 
      //   (DATE("'.$date.'") + INTERVAL 4 WEEK))');
      // }
      if ($minggu == 1) {
        $db=$this->db->query('SELECT trd.id_trx_akun, trd.tanggal, trd.deskripsi FROM `tbl_trx_akuntansi` trd  WHERE trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=35 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= "'.$date.'" AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 1 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=36 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= "'.$date.'" AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 1 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=66 AND trd2.tipe="DEBIT" AND DATE(tra2.tanggal) >= "'.$date.'" AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 1 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=67 AND trd2.tipe="DEBIT" AND DATE(tra2.tanggal) >= "'.$date.'" AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 1 WEEK))');
      }else if ($minggu == 2) {
        $db=$this->db->query('SELECT trd.id_trx_akun, trd.tanggal, trd.deskripsi FROM `tbl_trx_akuntansi` trd  WHERE trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=35 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 1 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 2 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=36 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 1 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 2 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=66 AND trd2.tipe="DEBIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 1 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 2 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=67 AND trd2.tipe="DEBIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 1 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 2 WEEK))');
      }else if ($minggu == 3) {
        $db=$this->db->query('SELECT trd.id_trx_akun, trd.tanggal, trd.deskripsi FROM `tbl_trx_akuntansi` trd  WHERE trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=35 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 2 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 3 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=36 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 2 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 3 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=66 AND trd2.tipe="DEBIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 2 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 3 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=67 AND trd2.tipe="DEBIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 2 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 3 WEEK))');
      }else{
        $db=$this->db->query('SELECT trd.id_trx_akun, trd.tanggal, trd.deskripsi FROM `tbl_trx_akuntansi` trd  WHERE trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=35 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 3 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 4 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=36 AND trd2.tipe="KREDIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 3 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 4 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=66 AND trd2.tipe="DEBIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 3 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 4 WEEK)) OR trd.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=67 AND trd2.tipe="DEBIT" AND DATE(tra2.tanggal) >= (DATE("'.$date.'") + INTERVAL 3 WEEK) AND DATE(tra2.tanggal) <= 
        (DATE("'.$date.'") + INTERVAL 4 WEEK))');
      }

        return $db->result();
    }
    function getRekapDay($date){
      $db=$this->db->query('SELECT tra.* FROM tbl_trx_akuntansi tra WHERE tra.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=35 AND trd2.tipe="KREDIT" AND tra2.tanggal="'.$date.'") OR tra.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=36 AND trd2.tipe="KREDIT" AND tra2.tanggal="'.$date.'") OR tra.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=66 AND trd2.tipe="DEBIT" AND tra2.tanggal="'.$date.'") OR tra.id_trx_akun IN (SELECT trd2.id_trx_akun FROM tbl_trx_akuntansi_detail trd2 JOIN tbl_trx_akuntansi tra2 ON 
        trd2.id_trx_akun=tra2.id_trx_akun WHERE trd2.id_akun=67 AND trd2.tipe="DEBIT" AND tra2.tanggal="'.$date.'")');
      return $db->result();
    }
    function detailKreditJurnal($id){
      $this->db->select('*');
      $this->db->from('tbl_trx_akuntansi_detail');
      $this->db->where('id_trx_akun', $id);
      // $this->db->where('tipe', 'KREDIT');
      return $this->db->get()->result();
    }
    function detailDebitJurnal($id){
      $this->db->select('*');
      $this->db->from('tbl_trx_akuntansi_detail');
      $this->db->where('id_trx_akun', $id);
      // $this->db->where('tipe', 'DEBIT');
      return $this->db->get()->result();
    }
}
