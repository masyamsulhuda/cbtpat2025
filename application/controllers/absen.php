<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Absen extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->db->query("SET time_zone='+7:00'");
    }
    public function absen()
    {
        $pdf = new PDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetTitle("Absensi Ruang", true);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Output();
    }
}
