<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('pdfgenerator');
    }

    public function view(){
        $data['judul'] = 'Laporan Penjualan';
        $this->load->view('laporan/v_pdf',$data);
        
        // filename dari pdf ketika didownload
        $file_pdf = 'laporan_penjualan_toko_kita';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        
		// $html = $this->load->view('laporan/v_pdf',$data,true);	    
        
        // run dompdf
        $this->pdfgenerator->generate($this->load->view('laporan/v_pdf',$data,true), $file_pdf,$paper,$orientation);
    }

    public function index(){
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');
        $today = date('Y-m-d');
        // title dari pdf
        $this->data['judul'] = 'LAPORAN PENJUALAN';
        $this->data['tanggal_hari_ini'] = $today;
        $this->data['unit'] = $this->db->query("SELECT tb_unit.id_unit, tb_unit.nama_unit FROM tb_unit join tb_transaksi on tb_transaksi.id_unit = tb_unit.id_unit WHERE tb_unit.id_unit IN (SELECT id_unit FROM tb_transaksi)")->result_array();
        $this->data['kategori'] = ["ATK","PRJ","SUP","AKB"];
        // $this->data['atk'] = $this->db->query("SELECT * FROM tb_transaksi join tb_detailtransaksi on tb_detailtransaksi.id_transaksi = tb_transaksi.id_transaksi WHERE tb_transaksi.");
        
        // filename dari pdf ketika didownload
        $file_pdf = 'laporan_penjualan_toko_kita';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        
		$html = $this->load->view('laporan/v_pdf',$this->data,true);	    
        
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
    }
}