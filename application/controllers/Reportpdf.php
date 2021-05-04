<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportpdf extends CI_Controller{
    public function index(){
        $this->load->library('mypdf');
        $data['judul'] = "Laporan Dompdf";
        $this->mypdf->generate('laporan/v_pdf',$data);
    }
}

?>