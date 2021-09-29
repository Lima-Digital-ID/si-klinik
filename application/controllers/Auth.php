<?php
Class Auth extends CI_Controller{
    
    
    
    function index(){
        $this->load->view('auth/login');
    }
    
    function cheklogin(){
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');
        // query chek users
        $this->db->where('email',$email);
        $this->db->where('password',  md5($password));
        $user       = $this->db->get('tbl_user');
        if($user->num_rows()>0){
            // retrive user data to session
            $this->session->set_userdata($user->row_array());
            if($this->session->userdata('id_user_level') == 5)
                redirect('periksamedis');
            else if ($this->session->userdata('id_user_level') == 4)
                redirect('pendaftaran/create');
            else if ($this->session->userdata('id_user_level') == 3)
                redirect('apotek');
            else if ($this->session->userdata('id_user_level') == 7)
                redirect('akuntansi/akun');
            else if ($this->session->userdata('id_user_level') == 6)
                redirect('hrms/pegawai');
            else
                redirect('welcome');
        }else{
            $this->session->set_flashdata('status_login','email atau password yang anda input salah');
            redirect('auth');
        }
    }
    
    function logout(){
        $this->session->sess_destroy();
        $this->session->set_flashdata('status_login','Anda sudah berhasil keluar dari aplikasi');
        redirect('auth');
    }
}
