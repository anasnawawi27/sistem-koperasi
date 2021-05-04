<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

// class Pdfview extends CI_Controller{

//     public function index(){

//         $this->load->library("Pdfgenerator");
//         $data['judul'] = "Laporan PDF";

//         $filename = "Laporan PDF";
//         $html = $this->load->view('laporan/v_pdf',$data);
//         $paper = "A4";
//         $orientation = "portrait";

//         // $this->pdfgenerator->generatepdf($filename, $html,$paper,$orientation);
//         $this->pdfgenerator->generatepdf($html, $filename, $paper,$orientation);
//     }

// }


defined('BASEPATH') OR exit('No direct script access allowed');

class Pdfview extends CI_Controller {
    public function index()
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');
        
        // title dari pdf
        $this->data['judul'] = 'Laporan Penjualan Toko Kita';
        
        // filename dari pdf ketika didownload
        $file_pdf = 'laporan_penjualan_toko_kita';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        
		$html = $this->load->view('laporan/v_pdf',$this->data, true);	    
        
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
    }
}


?>