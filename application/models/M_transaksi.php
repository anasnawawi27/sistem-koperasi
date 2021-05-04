<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class M_transaksi extends CI_Model{
	public function getAllInventori(){
		$this->db->select('*');
		$this->db->from('tb_detailtransaksi');
		$this->db->join('tb_transaksi', 'tb_transaksi.id_transaksi = tb_detailtransaksi.id_transaksi');
		$query = $this->db->get();

		return $query->result_array();
	}

	public function dataTransaksi(){
		$query = "SELECT tb_transaksi.id_transaksi,  tb_transaksi.id_unit,  tb_transaksi.cara_bayar,  tb_transaksi.status_bayar,  tb_transaksi.id_transaksi,  tb_transaksi.status_pengambilan,  tb_transaksi.created_at, tb_unit.nama_unit FROM tb_transaksi JOIN tb_unit ON tb_unit.id_unit = tb_transaksi.id_unit ORDER BY tb_transaksi.id_transaksi DESC";

		return $this->db->query($query)->result_array();
	}

	public function hapusTransaksi($id){

		$looping = $this->db->get_where('tb_detailtransaksi', ['id_transaksi' => $id])->result_array();

		foreach ($looping as $l) {
			
			$jumlahbeli = $l['jumlah_beli'];
			$id_barang = $l['id_barang'];

			$query = "UPDATE tb_barang SET stok = stok + $jumlahbeli WHERE id_barang = $id_barang";
			$this->db->query($query);

		}
		$this->db->delete('tb_transaksi', ['id_transaksi' => $id]);
		$this->db->delete('tb_detailtransaksi', ['id_transaksi' => $id]);
	}

	public function editTransaksi(){
		$id_transaksi = $this->input->post('id_transaksi', TRUE);
		$status_bayar = $this->input->post('status_bayar', TRUE);
		$status_pengambilan = $this->input->post('status_pengambilan', TRUE);

		$data = [];

		if (isset($status_bayar)) {
			if (isset($status_pengambilan)) {
				$data = [
				'status_bayar' => $status_bayar,
				'status_pengambilan' => $status_pengambilan
				];
			} else {
				$data = [
				'status_bayar' => $status_bayar
				];
			}

		} elseif(isset($status_pengambilan)) {
			$data = [
				'status_pengambilan' => $status_pengambilan
			];
		}

		$this->db->where('id_transaksi', $id_transaksi);
		$this->db->update('tb_transaksi', $data);
	}

	public function getDetailData($id){
		return $this->db->get_where('tb_detailtransaksi', ['id_transaksi' => $id]);
	}

	public function getTransaksiById($id){
		$query = "SELECT * FROM tb_transaksi a JOIN tb_unit b ON b.id_unit = a.id_unit WHERE a.id_transaksi = $id";
		return $this->db->query($query)->row_array();
	}

}