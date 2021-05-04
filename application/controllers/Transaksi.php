<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Transaksi extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('M_unit');
		$this->load->model('M_barang');
		$this->load->model('M_inventori');
		$this->load->model('M_transaksi');
		not_login();
	}

	public function data(){
		$data['data'] = $this->M_transaksi->dataTransaksi();
		$this->template->load('template', 'transaksi/v_datatransaksi', $data);
	}

	public function caritransaksi(){
		$mulai = $this->input->post('mulai');
		$sampai = $this->input->post('sampai');

		$query = "SELECT * FROM tb_transaksi JOIN tb_unit ON tb_unit.id_unit = tb_transaksi.id_unit WHERE tb_transaksi.created_at >= '$mulai' AND tb_transaksi.created_at <= DATE_ADD('$sampai', INTERVAL 1 DAY)";
		$data['data'] = $this->db->query($query)->result_array();

	}

	
	public function hapus($id){
		$this->M_transaksi->hapusTransaksi($id);
		$this->session->set_flashdata('flash', 'Dihapus');
		redirect('transaksi/data');
	}

	public function edit(){
		$this->M_transaksi->editTransaksi();
		$this->session->set_flashdata('flash', 'Diubah!');
		redirect('transaksi/data');
	}

	public function index(){
		$data['option'] = $this->M_unit->getAllUnit();
		$data['barang'] = $this->M_barang->getBarangStok();
		$this->template->load('template', 'transaksi/v_transaksi', $data);
	}

	public function post(){
		$kode_transaksi = $this->input->post('kode_transaksi');
		$unit = $this->input->post('unit');
		$cara_bayar = $this->input->post('cara_bayar');
		$status_bayar = $this->input->post('status_bayar');
		$pengambilan_barang = $this->input->post('pengambilan_barang');


		$kode_barang = $this->input->post('kode_barang');
		$jumlah = $this->input->post('jumlah');
		$harga = $this->input->post('harga');
		$total = $this->input->post('total');

		
	}

	public function ajax(){
		$data= $this->M_inventori->getAllInventori();

		echo json_encode($data);
	}

	public function autokodebarangtrk(){
		$kode_barang = $this->input->post('kode');
		$rows = $this->M_barang->getAutoBarangById($kode_barang);
		foreach ($rows as $row) {
			$row[] = $rows;
		}

		$data = [
			'kode_barang' => $row['kode_barang'],
			'id_barang'=> $row['id_barang'],
			'nama_barang'=> $row['nama_barang'],
			'harga_barang'=> $row['harga_jual'],
			'stok_barang' => $row['stok'],
		];

		echo json_encode($data);
	}

	public function autoidbarangtrk(){
		$kode_barang = $this->input->post('kode');
		$row = $this->M_barang->getBarangById($kode_barang);

		$data = [
			'kode_barang' => $row['kode_barang'],
			'id_barang'=> $row['id_barang'],
			'nama_barang'=> $row['nama_barang'],
			'harga_barang'=> $row['harga_jual'],
			'stok_barang' => $row['stok'],
		];

		echo json_encode($data);
	}

	public function insertTrkDetail(){
		$carabayar = $this->db->post('carabayar');
		$query = "INSERT INTO tb_detailtransaksi VALUES ('','$carabayar','','','','','')";
		$this->db->query($query);
	}

	public function simpandata(){

	$i = 0; // untuk loopingnya

	//yang ada array nya
    $idbarang = $this->input->post('id_barang');
    $harga = $this->input->post('harga_barang');
    $jumlah = $this->input->post('jumlah');
    $total = $this->input->post('total');

    //data tambahan
    $kodetransaksi = $this->input->post('kode_transaksi');
    $idunit = $this->input->post('kode_unit');
    $carabayar = $this->input->post('cara_bayar');
    $statusbayar = $this->input->post('status_bayar');
    $statusambil = $this->input->post('status_pengambilan');

    if ($idbarang[0] !== null) 
    {
      foreach ($idbarang as $row) 
      {
        $data = [
		    'id_barang'=>$row,
		    'jumlah_beli'=>$jumlah[$i],
		    'total'=>$total[$i],
		    'updated_at'=>0,
        ];

        $insert = $this->db->insert('tb_detailtransaksi', $data);

        //update stok saat insert data transaksi
        $sql = "UPDATE tb_barang SET stok = stok - $jumlah[$i] WHERE id_barang = $row";
        $this->db->query($sql);

        if ($insert) {
          $i++;
        }
      }
      $data2 = [
      		'id_unit' => $idunit,
		    'cara_bayar'=>$carabayar,
		    'status_bayar'=>$statusbayar,
		    'status_pengambilan'=>$statusambil,
		    'updated_at'=>0,
        ];
        
      $insert = $this->db->insert('tb_transaksi', $data2);

      $query = "SELECT * FROM tb_transaksi ORDER BY id_transaksi DESC LIMIT 1";
      $idmax = $this->db->query($query)->row_array();
      $id = $idmax['id_transaksi'];

      	//update id_transaksi di tabel detail transaksi
		$data3 = array(
	        'id_transaksi' => $id
		);

		$this->db->where('id_transaksi', 0);
		$this->db->update('tb_detailtransaksi', $data3);
    }

    $this->session->set_flashdata('flash', 'Ditambahkan');

  }

  public function getdetailtransaksi(){
  	$id_transaksi = $this->input->post('id');

  	$query = "SELECT * FROM tb_detailtransaksi JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_detailtransaksi.id_transaksi JOIN tb_barang ON tb_barang.id_barang = tb_detailtransaksi.id_barang WHERE tb_detailtransaksi.id_transaksi = $id_transaksi";
  	$data = $this->db->query($query)->result_array();

  	echo json_encode($data);
  }

  public function ubahtransaksi($id){
  	$data['judul'] = "Edit Data Transaksi";
  	$data['data'] = $this->M_transaksi->getTransaksiById($id);
  	$this->template->load('template', 'transaksi/v_edittransaksi', $data);
  }

}