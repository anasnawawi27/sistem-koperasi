<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
Class M_inventori extends CI_Model{

	public function getAllInventori(){
		$this->db->select('*');
		$this->db->from('tb_barang');
		$this->db->join('tb_inventori', 'tb_inventori.id_barang = tb_barang.id_barang');
		$this->db->order_by('tb_inventori.id_inventori', 'DESC');
		$query = $this->db->get();

		return $query->result_array();
	}

	public function tambah(){
		$data = [
			'id_inventori' => $this->input->post('id_inventori', TRUE),
			'id_barang' => $this->input->post('id_barang', TRUE),
			'qty' => $this->input->post('qty', TRUE),
			'updated_at' => 0,
		];

		$this->db->insert('tb_inventori', $data);

		$qty = $this->input->post('qty', TRUE);
		$id_barang = $this->input->post('id_barang', TRUE);

		$sql = "UPDATE tb_barang SET stok = stok + '$qty' WHERE id_barang = '$id_barang'";
		$this->db->query($sql);
	}

	public function getBarangById($id){
		return $this->db->get_where('tb_barang', ['id_barang' => $id])->row_array();
	}

	public function getInventoryById($id){
		$where = array('id_inventori' => $id);
		$join = array('tb_barang', 'tb_barang.id_barang=tb_inventori.id_barang');
		$query = $this->db->join($join[0], $join[1])->get_where('tb_inventori', $where);

		return $query;
	}

	// public function ubahDataBarang(){

	// 	date_default_timezone_set('Asia/Jakarta');

	// 	$data = [
	// 		'kode_barang' => $this->input->post('kode_barang', TRUE),
	// 		'nama_barang' => $this->input->post('nama_barang', TRUE),
	// 		'detail_barang' => $this->input->post('detail_barang', TRUE),
	// 		'satuan'=> $this->input->post('satuan', TRUE),
	// 		'kategori'=> $this->input->post('kategori', TRUE),
	// 		'updated_at' => date("Y-m-d h:i:s"),
	// 	];

	// 	$this->db->where('id_barang', $this->input->post('id_barang', true));
	// 	$this->db->update('tb_barang', $data);
	// }

	public function editDataInventori(){

		date_default_timezone_set('Asia/Jakarta');

		$id_inventori = $this->input->post('id_inventori');
		$id_barang = $this->input->post('id_barang');
		$qty = $this->input->post('qty');
		$qtyawal = $this->input->post('qty_awal');

		//kembalikan stok ke awal
		$query1 = "UPDATE tb_barang SET stok = stok - $qtyawal WHERE id_barang = $id_barang";
		$this->db->query($query1);

		$data = [
			'id_barang' => $id_barang,
			'qty' => $qty,
			'updated_at' => date("Y-m-d h:i:s"),

		];
		$this->db->where('id_inventori', $id_inventori);
		$this->db->update('tb_inventori', $data);

		//update stok barang lagi
		$query2 = "UPDATE tb_barang SET stok = stok + $qty WHERE id_barang = $id_barang";
		$this->db->query($query2);

	}

	public function hapusDataInventori($inv, $brg, $qty){
		//update stok barang
		$query = "UPDATE tb_barang SET stok = stok - $qty WHERE id_barang = $brg";
		$this->db->query($query);

		$this->db->delete('tb_inventori',['id_inventori'=>$inv]);
	}

	




}