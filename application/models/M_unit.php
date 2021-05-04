<?php 

Class M_unit extends CI_Model{

	public function getAllUnit(){
		$this->db->order_by('id_unit', 'DESC');
		return $this->db->get('tb_unit')->result_array();
	}

	public function tambahDataUnit(){
		$data = [
			'id_unit' => '',
			'nama_unit' => $this->input->post('nama_unit', true),
			'alamat' => $this->input->post('alamat', true),
			'no_telp' => $this->input->post('no_telp', true),
			'no_telp_pic' => $this->input->post('no_telp_pic', true),
			'nama_pic'=> $this->input->post('nama_pic', true),
			'no_rek' => $this->input->post('no_rek'),
			'status' => 1,
			'updated_at' => 0,
		];

		$this->db->insert('tb_unit', $data);
	}

	public function getUnitById($id){
		$query = $this->db->get_where('tb_unit', ['id_unit' => $id]);
		return $query->row_array();
	}

	public function ubahDataUnit($id){
		$id_unit = $this->input->post('id_unit', TRUE);
		$nama_unit = $this->input->post('nama_unit', TRUE);
		$alamat = $this->input->post('alamat', TRUE);
		$no_telp = $this->input->post('no_telp', TRUE);
		$no_telp_pic = $this->input->post('no_telp_pic', TRUE);
		$nama_pic = $this->input->post('nama_pic', TRUE);
		$no_rek = $this->input->post('no_rek', TRUE);

		date_default_timezone_set('Asia/Jakarta');

		$data = [
			'id_unit' => $id_unit,
			'nama_unit' => $nama_unit,
			'alamat' => $alamat,
			'no_telp' => $no_telp,
			'no_telp_pic' => $no_telp_pic,
			'nama_pic' => $nama_pic,
			'no_rek' => $no_rek,
			'updated_at' => date("Y-m-d h:i:s"),
		];
		$this->db->where('id_unit', $id_unit);
		$this->db->update('tb_unit', $data);
	}

	public function hapusUnit($id){
		$this->db->delete('tb_unit', ['id_unit' => $id]);
	}

}



 ?>