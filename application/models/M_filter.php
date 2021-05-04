<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class M_filter extends CI_Model{
	public function getData(){
		$query = "SELECT *, dtl.created_at FROM tb_detailtransaksi dtl JOIN tb_transaksi trk ON trk.id_transaksi = dtl.id_transaksi JOIN tb_unit unt ON unt.id_unit = trk.id_unit JOIN tb_barang brg ON brg.id_barang = dtl.id_barang ORDER BY dtl.id_transaksi DESC";
		return $this->db->query($query)->result_array();
	}

	public function getUnit(){
		$data = $this->db->get('tb_unit')->result_array();
		return $data;
	}

	public function getFilterAll(){
		$tanggal_awal = $this->input->post('mulai');
		$tanggal_akhir = $this->input->post('sampai');
		$unit = $this->input->post('unit');
		$kategori = $this->input->post('kategori');

		$query = "SELECT * FROM tb_detailtransaksi dtl JOIN tb_transaksi trk ON trk.id_transaksi = dtl.id_transaksi JOIN tb_barang brg ON brg.id_barang = dtl.id_barang WHERE dtl.created_at >= '$tgl_awal' AND dtl.created_at <= DATE_ADD('$sampai', INTERVAL 1 DAY) AND trk.id_unit = $unit AND brg.kategori = $kategori";

		return $this->db->query($query)->result_array();
	}
}