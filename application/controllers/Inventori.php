<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventori extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_inventori');
		$this->load->library('form_validation');
		$this->load->model('m_barang');
		not_login();
	}

	public function index()
	{
		$data['judul'] = 'Tabel Data Inventori';
		$data['inventori'] = $this->m_inventori->getAllInventori();
		$this->template->load('template', 'inventori/v_inventori', $data);
	}

	public function tambah(){
		
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
		$this->form_validation->set_rules('detail_barang', 'Detail Barang', 'required');
		$this->form_validation->set_rules('qty', 'Quantity', 'required');

		if($this->form_validation->run() == false){
			$data['judul'] = 'Tambah Data Inventori';
			$this->template->load('template','inventori/v_tambahinventori', $data);
		} else {
			$this->m_inventori->tambah();
			$this->session->set_flashdata('flash', ' Ditambahkan');
			redirect('inventori/tambah');
		}
	}

	public function autokodebaranginv(){
		$id = $this->input->post('kode_barang');
		$rows = $this->m_barang->getAutoBarangById($id);
		foreach ($rows as $row) {
			$row[] = $rows;
		}
		$data = array(
			'id_barang'=>$row['id_barang'],
			'nama_barang'=>$row['nama_barang'],
			'detail_barang'=>$row['detail_barang']
		);
		echo json_encode($data);
	}

	public function ubah($id){
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
		$this->form_validation->set_rules('detail_barang', 'Detail Barang', 'required');
		$this->form_validation->set_rules('qty', 'Quantity', 'required');

		if($this->form_validation->run() == false){
			$data['judul'] = 'Edit Data Inventori';
			$data['inventori'] = $this->m_inventori->getInventoryById($id)->row_array();
			$this->template->load('template','inventori/v_ubahinventori', $data);
		} else {
			$this->m_inventori->editDataInventori();
			$this->session->set_flashdata('flash', ' Diubah');
			redirect('inventori');
		}
	}

	public function hapus($inv, $brg, $qty){
		$this->m_inventori->hapusDataInventori($inv, $brg, $qty);
		$this->session->set_flashdata('flash', 'Dihapus');
		redirect('inventori');
	}
}