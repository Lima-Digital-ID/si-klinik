<?php

function getInfoRS($field){
    $ci = get_instance();
    $ci->db->where('id',1);
    $rs = $ci->db->get('tbl_profil_rumah_sakit')->row_array();
    return $rs[$field];
}
function biayaSK($select)
{
    $ci = get_instance();
    $ci->db->select($select);
    $biaya = $ci->db->get('tbl_biaya_sk')->row_array();
    return $biaya[$select];
}

function getBranchKlinik($id_klinik){
    $ci = get_instance();
    $ci->db->where('id_klinik',$id_klinik);
    $rs = $ci->db->get('tbl_klinik')->row_array();
    return $rs;
}



/* fungsi untuk mendapatkan value dari sebuah tabel
 * $table nama tabel yang digunakan
 * $field nama field yang ingin ditampilkan
 * $key ingin ditampilkan berdasarkan field yang mana
 * $value = berdasrkan apa
 */
function getFieldValue($table,$field,$key,$value){
    $ci = get_instance();
    $ci->db->where($key,$value);
    $data = $ci->db->get($table)->row_array();
    return $data[$field];
}

// untuk chek akses level pada modul peberian akses
function checked_akses($id_user_level,$id_menu){
    $ci = get_instance();
    $ci->db->where('id_user_level',$id_user_level);
    $ci->db->where('id_menu',$id_menu);
    $data = $ci->db->get('tbl_hak_akses');
    if($data->num_rows()>0){
        return "checked='checked'";
    }
}

?>
