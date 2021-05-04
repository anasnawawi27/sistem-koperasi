<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_unit');
		$this->load->library('form_validation');
		not_login();
	}

	public function index()
	{
		$data['judul'] = 'Tabel Data Unit';
		$data['unit'] = $this->m_unit->getAllUnit();
		$this->template->load('template', 'unit/v_unit', $data);
	}

	public function tambah(){
		
		$this->form_validation->set_rules('nama_unit', 'Nama Unit', 'required');
		$this->form_validation->set_rules('no_telp', 'No Telp', 'required');
		$this->form_validation->set_rules('nama_pic', 'Nama PIC', 'required');
		$this->form_validation->set_rules('no_telp_pic', 'No Telp PIC', 'required');
		$this->form_validation->set_rules('no_rek', 'No Rekening', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');

		if($this->form_validation->run() == false){
			$data['judul'] = 'Tambah Data Unit';
			$this->template->load('template','unit/v_tambahunit', $data);
		} else {
			$this->m_unit->tambahDataUnit();
			$this->session->set_flashdata('flash', ' Ditambahkan');
			redirect('unit/tambah');
		}
	}

	public function ubah($id){
		$this->form_validation->set_rules('nama_unit', 'Nama Unit', 'required');
		$this->form_validation->set_rules('no_telp', 'No Telp', 'required');
		$this->form_validation->set_rules('nama_pic', 'Nama PIC', 'required');
		$this->form_validation->set_rules('no_telp_pic', 'No Telp PIC', 'required');
		$this->form_validation->set_rules('no_rek', 'No Rekening', 'required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		
		if($this->form_validation->run() == false){
			$data['judul'] = 'Ubah Data Unit';
			$data['unit'] = $this->m_unit->getUnitById($id);
			$this->template->load('template','unit/v_ubahdataunit', $data);
		} else {
			$query = $this->m_unit->ubahDataUnit($id);
			$this->session->set_flashdata('flash', ' Diubah');
			redirect('unit');
		}
	}

	public function hapus($id){
		$this->m_unit->hapusUnit($id);
		$this->session->set_flashdata('flash','Dihapus');
		redirect('unit');
	}
}