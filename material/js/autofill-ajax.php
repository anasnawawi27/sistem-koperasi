<?php 

$id = $_GET['kode'];
$result = $this->db->get_where('tb_barang', ['kode_barang' => $kode])->row_array();

$data = array(
	'nama_barang' => $result['nama_barang'],
	'detail_barang' => $result['detail_barang'],
);

echo json_encode($data);


 ?>