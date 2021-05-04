<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_barang');
		$this->load->library('form_validation');
		not_login();
	}

	public function index()
	{
		$data['judul'] = 'Tabel Data Barang';
		$data['barang'] = $this->m_barang->getAllBarang();
		$this->template->load('template', 'barang/v_barang', $data);
	}

	public function tambah(){
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required|is_unique[tb_barang.kode_barang]');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
		$this->form_validation->set_rules('detail_barang', 'Detail Barang', 'required');
		$this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required');
		$this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required');

		if($this->form_validation->run() == false){
			$data['judul'] = 'Tambah Data Barang';
			$this->template->load('template','barang/v_tambahbarang', $data);
		} else {
			$this->m_barang->tambahDataBarang();
			$this->session->set_flashdata('flash', ' Ditambahkan');
			redirect('barang/tambah');
		}
	}

	public function ubah($id){
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
		if($this->form_validation->run() == false){
			$data['satuan'] = ['PCS', 'RIM', 'DUS'];
			$data['kategori'] = ['ATK', 'PRC', 'SUP', 'AKB'];
			$data['ubah'] = $this->m_barang->getBarangById($id);
			$this->template->load('template','barang/v_ubahdatabarang', $data);
		} else {
			$this->m_barang->ubahDataBarang();
			$this->session->set_flashdata('flash', ' Diubah');
			redirect('barang');
		}
	}

	public function hapus($id)
    {
        $this->m_barang->hapusBarang($id);
        $this->session->set_flashdata('flash','Dihapus');
        redirect('barang');
    }

}