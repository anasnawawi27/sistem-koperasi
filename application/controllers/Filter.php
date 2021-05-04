<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filter extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('M_filter');
		not_login();
	}

	public function index()
	{
		$data['unit'] = $this->M_filter->getUnit();
		$data['data'] = $this->M_filter->getData();
		$this->template->load('template', 'v_filter', $data);
	}

	public function filterdata(){
		$mulai = $this->input->post('mulai');
		$sampai = $this->input->post('sampai');
		$unit = $this->input->post('unit');
		$kategori = $this->input->post('kategori');

		$where = "";
		$whereAnd ="";
	    $whereAND2 ="";
	if(!empty($mulai) && !empty($sampai)){	
	    if(!empty($unit)){
	        $whereAnd=" AND b.id_unit = '$unit'";
	    }else{
	        $whereAnd="";
	    }
	    if(!empty($kategori)){
	        $whereAND2=" AND c.kategori = '$kategori'";
	    }else{
	        $whereAND2="";
	    }
	    $where="b.created_at >= '$mulai' AND b.created_at <= DATE_ADD('$sampai', INTERVAL 1 DAY)";
	} elseif(!empty($unit)){
	    if(!empty($kategori)){
	        $whereAND2=" AND c.kategori = '$kategori'";
	    }
	    $whereAnd="b.id_unit = $unit";
	}elseif(!empty($kategori)){
	    $whereAND2="c.kategori = '$kategori'";
	}

	$query = "SELECT *, a.created_at FROM tb_detailtransaksi a JOIN tb_transaksi b ON b.id_transaksi = a.id_transaksi JOIN tb_barang c ON c.id_barang = a.id_barang JOIN tb_unit d ON d.id_unit = b.id_unit WHERE ".$where."".$whereAnd."".$whereAND2;

	$data = $this->db->query($query)->result_array();

	echo json_encode($data);
}

public function filterDataExport(){
		$mulai = $this->input->post('mulai');
		$sampai = $this->input->post('sampai');
		$unit = $this->input->post('unit');
		$kategori = $this->input->post('kategori');

		$where = "";
		$whereAnd ="";
	    $whereAND2 ="";
	if(!empty($mulai) && !empty($sampai)){	
	    if(!empty($unit)){
	        $whereAnd=" AND b.id_unit = '$unit'";
	    }else{
	        $whereAnd="";
	    }
	    if(!empty($kategori)){
	        $whereAND2=" AND c.kategori = '$kategori'";
	    }else{
	        $whereAND2="";
	    }
	    $where="b.created_at >= '$mulai' AND b.created_at <= DATE_ADD('$sampai', INTERVAL 1 DAY)";
	} elseif(!empty($unit)){
	    if(!empty($kategori)){
	        $whereAND2=" AND c.kategori = '$kategori'";
	    }
	    $whereAnd="b.id_unit = $unit";
	}elseif(!empty($kategori)){
	    $whereAND2="c.kategori = '$kategori'";
	}

	$query = "SELECT *, a.created_at FROM tb_detailtransaksi a JOIN tb_transaksi b ON b.id_transaksi = a.id_transaksi JOIN tb_barang c ON c.id_barang = a.id_barang JOIN tb_unit d ON d.id_unit = b.id_unit WHERE ".$where."".$whereAnd."".$whereAND2;

	$data['data'] = $this->db->query($query)->result_array();

	$this->template->load('template', 'v_export', $data);
}
}