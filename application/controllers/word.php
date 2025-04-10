<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Word extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->db->query("SET time_zone='+7:00'");
        $waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
        $this->waktu_sql = $waktu_sql['waktu'];
        $this->opsi = array("a", "b", "c", "d", "e");
        $this->load->library(array('session', 'pdflibrary'));
    }
    function cek_aktif()
    {
        if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
            redirect('adm/login');
        }
    }
    public function index()
    {
        $this->cek_aktif();
        cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
        //var def session
        $a['sess_level'] = $this->session->userdata('admin_level');
        $a['sess_user'] = $this->session->userdata('admin_user');
        $a['sess_konid'] = $this->session->userdata('admin_konid');
        $a['p']            = "f_soal_import_word";
        $this->load->view('aaa', $a);
    }
}
