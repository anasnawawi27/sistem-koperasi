<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('./excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Laporan extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_unit');
		$this->load->model('m_transaksi');
		not_login();
	}

	public function index()
	{
		$data['unit'] = $this->m_unit->getAllUnit();

		for($i=2020; $i <= 2030; $i++){
			$generateTahun[] = $i;
		}
		$data['tahun'] = $generateTahun; 
		$this->template->load('template', 'laporan/v_laporan', $data);
	}

	//REPORT 3
	public function exportKategoriBulan(){
		$kategori = $this->input->post('kategori');
		$bulan = $this->input->post('bulan_kategori');
		$tahun = $this->input->post('tahun_kategori');

		$kata = "";

		if ($bulan == "Pilih Bulan" || $kategori == "Pilih Kategori") {
			$this->session->set_flashdata('fail', 'Gagal');
			redirect('laporan');
		}

		if ($kategori == 'ATK') {
			$kata = 'ALAT TULIS KANTOR';
		} elseif ($kategori == 'PRC') {
			$kata = 'PERCETAKAN';
		} elseif ($kategori == 'SUP') {
			$kata = 'SUPPLAIS';
		} elseif ($kategori == 'AKB') {
			$kata = 'ALAT KEBERSIHAN';
		}

		$bulann = "";
		if ($bulan == 1) {
			$bulann = 'JANUARI';
		} elseif ($bulan == 2) {
			$bulann = 'FEBRUARI';
		} elseif ($bulan == 3) {
			$bulann = 'MARET';
		} elseif ($bulan == 4) {
			$bulann = 'APRIL';
		} elseif ($bulan == 5) {
			$bulann = 'MEI';
		} elseif ($bulan == 6) {
			$bulann = 'JUNI';
		} elseif ($bulan == 7) {
			$bulann = 'JULI';
		} elseif ($bulan == 8) {
			$bulann = 'AGUSTUS';
		} elseif ($bulan == 9) {
			$bulann = 'SEPTEMBER';
		} elseif ($bulan == 10) {
			$bulann = 'OKTOBER';
		} elseif ($bulan == 11) {
			$bulann = 'NOVEMBER';
		} elseif ($bulan == 12) {
			$bulann = 'DESEMBER';
		}



		$unit = $this->db->query("SELECT * from tb_unit")->result_array();

		$spreadsheet = new Spreadsheet();

		$sheet = $spreadsheet->getActiveSheet();

		    $style = array(
		    	'font' => [
		            'bold' => true,
		            'size' => 14,
		        ],
		        'alignment' => [
				    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				],
		    );

    	$sheet->getStyle("A1:G1")->applyFromArray($style);
		$sheet->mergeCells('A1:G1');
		$sheet->setCellValue('A1', 'LAMPIRAN REKAPITULASI');

		$sheet->getStyle("A2:G2")->applyFromArray($style);
		$sheet->mergeCells('A2:G2');
		$sheet->setCellValue('A2', 'PENGGUNAAN BIAYA '.$kata.' BRI UNIT');

		$sheet->getStyle("A3:G3")->applyFromArray($style);
		$sheet->mergeCells('A3:G3');
		$sheet->setCellValue('A3', 'POSISI BULAN '.$bulann.' ' . $tahun);

		$style2 = array(
			'font' => [
		            'bold' => true,
		            'size' => 11,
		     ],
		        'alignment' => [
				    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				],
			'borders' => [
			        'outline' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			        ],
			    ],
		);

		$style3 = array(
			'font' => [
		            'bold' => true,
		            'size' => 11,
		     ],
		        'alignment' => [
				    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				],
			'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			        ],
			    ],
		);

		$sheet->getStyle("A5:G5")->applyFromArray($style2);
		$sheet->mergeCells('A5:G5');

		$p = 5;
		$i = 0;
		$grand_total2 = [];
		foreach ($unit as $u) {
			$awalUntukTotalAwal = $p+2;

			$sheet->setCellValue('A'.$p, $u['nama_unit']);
			$sheet->getStyle("A$p:G$p")->applyFromArray($style2);
			$sheet->mergeCells("A$p:G$p");

			$p = $p+1;

		        	//buat header
		        	$sheet->setCellValue('A'.$p, 'No');
		        	$sheet->setCellValue('B'.$p, 'Nama Barang');
		        	$sheet->setCellValue('C'.$p, 'Satuan');
		        	$sheet->setCellValue('D'.$p, 'Jumlah');
		        	$sheet->setCellValue('E'.$p, 'Harga');
		        	$sheet->setCellValue('F'.$p, 'Total');
		        	$sheet->setCellValue('G'.$p, '');

		        	$sheet->getColumnDimension('B')->setWidth(30);
		        	$sheet->getColumnDimension('A')->setWidth(5);
		        	$sheet->getColumnDimension('E')->setWidth(20);
		        	$sheet->getColumnDimension('F')->setWidth(20);
		        	$sheet->getColumnDimension('G')->setWidth(15);


					$sheet->getStyle("A$p:G$p")->applyFromArray($style3);

			$param = $u['id_unit'];
			$barang = $this->db->query("SELECT * from tb_detailtransaksi join tb_barang on tb_barang.id_barang = tb_detailtransaksi.id_barang JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_detailtransaksi.id_transaksi WHERE tb_transaksi.id_unit = $param AND tb_barang.kategori = '$kategori' AND substr(tb_transaksi.created_at,6,2) = $bulan AND substr(tb_transaksi.created_at,1,4) = $tahun")->result_array();
		        $a = 0;
		        $p = $p+1;
		        $nomor = 1;
		        $total = [];
		        $indexAwalUntukTotal = $p;

		        //border
		            $border = [
					    'borders' => [
					        'allBorders' => [
					            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					        ],
					    ],
					];

		        while ( $a < count($barang)) {
		        	$sheet->setCellValue('A'.$p, $nomor);
		            $sheet->setCellValue('B'.$p, $barang[$a]['nama_barang']);
		            $sheet->setCellValue('C'.$p, $barang[$a]['satuan']);
		            $sheet->setCellValue('D'.$p, $barang[$a]['jumlah_beli']);
		            $sheet->setCellValue('E'.$p, $barang[$a]['harga_jual']);
		            $sheet->setCellValue('F'.$p, $barang[$a]['total']);
		            $sheet->setCellValue('G'.$p, '');

		            $total[] = $barang[$a]['total'];

					$sheet->getStyle("A$p:G$p")->applyFromArray($border);

		            $sheet->getStyle('A'.$p)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		            $sheet->getStyle("C$p:D$p")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		            $sheet->getStyle("E$p:F$p")->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_RP);

		            $nomor++;
		            $a++;
		            $p++;
		        }
		        $sheet->setCellValue('A'.$p, '');
		        $sheet->getStyle("A$p:G$p")->applyFromArray($border);
		        $p=$p+1;
				$sheet->setCellValue('A'.$p, 'Total');
				$grand_total = array_sum($total);

				$akhirUntukTotal = $p-2;
				$sheet->setCellValue('G'.$p, '=SUM(F'.$awalUntukTotalAwal.':F'.$akhirUntukTotal.')');
				$sheet->getStyle('A'.$p)->getFont()->setBold(1);
				$sheet->getStyle('G'.$p)->getFont()->setBold(1);
				$sheet->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_RP);
				$sheet->getStyle('A'.$p)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle("A$p:G$p")->applyFromArray($border);
				$sheet->mergeCells("A$p:F$p");
				$p = $p+1;
		$i++;
		$p++;

		$grand_total2[] = $grand_total;
		}

		$p = $p+1;
		$grand_total3 = array_sum($grand_total2);
		$sheet->mergeCells("A$p:F$p");
		$sheet->getStyle("A$p:G$p")->applyFromArray($border);
		$sheet->getStyle("A$p:G$p")->getFont()->setBold(1);
		$sheet->setCellValue('A'.$p, "TOTAL TAGIHAN ".$kategori." UNIT " .$bulann." ".date('Y'));
		$sheet->getStyle('A'.$p)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		//GRAND TOTAL KESELURUHAN

		$indexDikurangiP = $p-3;
		$sheet->setCellValue('G'.$p, '=SUM(G7:G'.$indexDikurangiP.')');
		$sheet->getStyle('G'.$p)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_RP);


		

		$filename = 'Report-'.time().'.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		header('Cache-Control: max-age=1');

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output'); 
	}

	//REPORT 3
	public function exportUnitBulan(){
		$bulan = $this->input->post('bulan_unit');
		$tahun = $this->input->post('tahun_unit');

		$bulann = "";

		if ($bulan == "Pilih Bulan") {
			$this->session->set_flashdata('fail', 'Gagal');
			redirect('laporan');
		}

		if ($bulan == 1) {
			$bulann = 'JANUARI';
		} elseif ($bulan == 2) {
			$bulann = 'FEBRUARI';
		} elseif ($bulan == 3) {
			$bulann = 'MARET';
		} elseif ($bulan == 4) {
			$bulann = 'APRIL';
		} elseif ($bulan == 5) {
			$bulann = 'MEI';
		} elseif ($bulan == 6) {
			$bulann = 'JUNI';
		} elseif ($bulan == 7) {
			$bulann = 'JULI';
		} elseif ($bulan == 8) {
			$bulann = 'AGUSTUS';
		} elseif ($bulan == 9) {
			$bulann = 'SEPTEMBER';
		} elseif ($bulan == 10) {
			$bulann = 'OKTOBER';
		} elseif ($bulan == 11) {
			$bulann = 'NOVEMBER';
		} elseif ($bulan == 12) {
			$bulann = 'DESEMBER';
		}


		$spreadsheet = new Spreadsheet();

		$sheet = $spreadsheet->getActiveSheet();

		        	$style = array(
					'font' => [
				            'bold' => true,
				            'size' => 11,
					     ],
					);

		$sheet->getStyle('A')->getFont()->setBold(1);
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(30);

		$sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$sheet->getColumnDimension('E')->setWidth(15);
		$sheet->getColumnDimension('F')->setWidth(15);
		$sheet->getColumnDimension('G')->setWidth(15);
		$sheet->getColumnDimension('H')->setWidth(17);

		$sheet->getStyle('E')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_RP);
		$sheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_RP);
		$sheet->getStyle('G')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_RP);



		$border = array(
			'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			        ],
			    ],
		);

		$unit = $unit = $this->db->query("SELECT * from tb_unit")->result_array();
		$jumlah_total = [];
		$p = 1;
		$i =0; foreach ($unit as $u) {

			$awalp = 1;

			$sheet->mergeCells("B$p:H$p");
			$sheet->setCellValue('B'.$p,'LAMPIRAN REKAPITULASI');
			$sheet->getStyle('B'.$p)->getFont()->setBold(1);
			$p = $p+1;

			$sheet->mergeCells("B$p:H$p");
			$sheet->setCellValue('B'.$p,'UNIT '.strtoupper($u['nama_unit']));
			$sheet->getStyle('B'.$p)->getFont()->setBold(1);
			$p = $p+1;

			$sheet->mergeCells("B$p:H$p");
			$sheet->setCellValue('B'.$p,'BULAN '.$bulann.' '. $tahun);
			$sheet->getStyle('B'.$p)->getFont()->setBold(1);
			$p = $p+1;

			$sheet->mergeCells("B$p:H$p");
			$sheet->setCellValue('B'.$p,'');

			$sheet->getStyle("B$awalp:H$p")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$p = $p+1;
			$sheet->setCellValue('A'.$p,'NO');
			$sheet->setCellValue('B'.$p,'NAMA BARANG');
			$sheet->setCellValue('C'.$p,'SATUAN');
			$sheet->setCellValue('D'.$p,'QTY');
			$sheet->setCellValue('E'.$p,'HARGA');
			$sheet->setCellValue('F'.$p,'JUMLAH');
			$sheet->setCellValue('G'.$p,'TOTAL');
			$sheet->setCellValue('H'.$p,'UNIT KERJA');
			$awal = $p;
			$sheet->getStyle("A$p:H$p")->getFont()->setBold(1);
			$sheet->getStyle("A$p:H$p")->applyFromArray($border);
			$sheet->getStyle("E$p:H$p")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$p = $p+1;
			$indexUntukKeAwal = $p;
			$sheet->setCellValue('A'.$p,'A.');
			$sheet->setCellValue('B'.$p,'ALAT TULIS KANTOR');
			$sheet->getStyle("A$p:B$p")->getFont()->setBold(1);

			$sheet->getStyle("A$p:G$p")->applyFromArray($border);

			$p = $p+1;
			$id_unit = $u['id_unit'];
			$atk = $this->db->query("SELECT * from tb_detailtransaksi join tb_barang on tb_barang.id_barang = tb_detailtransaksi.id_barang JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_detailtransaksi.id_transaksi WHERE tb_transaksi.id_unit = $id_unit AND tb_barang.kategori = 'ATK' AND substr(tb_transaksi.created_at,6,2) = $bulan AND substr(tb_transaksi.created_at,1,4) = $tahun")->result_array();
			$no1 = 1;
			$total1 = [];
			$indexAwal = $p;
			foreach ($atk as $a) {
				$sheet->setCellValue('A'.$p,$no1);
				$sheet->setCellValue('B'.$p,$a['nama_barang']);
				$sheet->setCellValue('C'.$p,$a['satuan']);
				$sheet->setCellValue('D'.$p,$a['jumlah_beli']);
				$sheet->setCellValue('E'.$p,$a['harga_beli']);
				$sheet->setCellValue('F'.$p,$a['total']);
				$sheet->getStyle("A$p:G$p")->applyFromArray($border);
				$sheet->getStyle("B$p")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
				$no1++;
				$p++;

			}

			$indexUntukKeAkhir = $p;

			// $sheet->getStyle("B$p")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

			$indexAkhir1 = $p-1;
			$sheet->setCellValue('G'.$p, '=SUM(F'.$indexAwal.':F'.$indexAkhir1.')');
			$sheet->getStyle('G'.$p)->getFont()->setBold(1);
			$sheet->getStyle("A$p:G$p")->applyFromArray($border);
			$p = $p+1;
			$sheet->setCellValue('A'.$p,'B.');
			$sheet->setCellValue('B'.$p,'PERCETAKAN');
			$sheet->getStyle("A$p:B$p")->getFont()->setBold(1);
			$sheet->getStyle("A$p:G$p")->applyFromArray($border);
			$p = $p+1;
			$prc = $this->db->query("SELECT * from tb_detailtransaksi join tb_barang on tb_barang.id_barang = tb_detailtransaksi.id_barang JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_detailtransaksi.id_transaksi WHERE tb_transaksi.id_unit = $id_unit AND tb_barang.kategori = 'PRC' AND substr(tb_transaksi.created_at,6,2) = $bulan AND substr(tb_transaksi.created_at,1,4) = $tahun")->result_array();

			$no2=1;
			$total2 = [];
			$indexAwal2 = $p;
			foreach ($prc as $pr) {
				$sheet->setCellValue('A'.$p,$no2);
				$sheet->setCellValue('B'.$p,$pr['nama_barang']);
				$sheet->setCellValue('C'.$p,$pr['satuan']);
				$sheet->setCellValue('D'.$p,$pr['jumlah_beli']);
				$sheet->setCellValue('E'.$p,$pr['harga_beli']);
				$sheet->setCellValue('F'.$p,$pr['total']);
				$sheet->getStyle("A$p:G$p")->applyFromArray($border);
				$no2++;
				$p++;

			}
			$indexAkhir2 = $p-1;
			$sheet->setCellValue('G'.$p, '=SUM(F'.$indexAwal2.':F'.$indexAkhir2.')');
			$sheet->getStyle('G'.$p)->getFont()->setBold(1);
			$sheet->getStyle("A$p:G$p")->applyFromArray($border);
			$p = $p+1;
			$sheet->setCellValue('A'.$p,'C.');
			$sheet->setCellValue('B'.$p,'SUPPLAIS');
			$sheet->getStyle("A$p:B$p")->getFont()->setBold(1);
			$sheet->getStyle("A$p:G$p")->applyFromArray($border);
			$p = $p+1;
			$sup = $this->db->query("SELECT * from tb_detailtransaksi join tb_barang on tb_barang.id_barang = tb_detailtransaksi.id_barang JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_detailtransaksi.id_transaksi WHERE tb_transaksi.id_unit = $id_unit AND tb_barang.kategori = 'SUP' AND substr(tb_transaksi.created_at,6,2) = $bulan AND substr(tb_transaksi.created_at,1,4) = $tahun")->result_array();

			$no3 = 1;
			$total3 = [];
			$indexAwal3 = $p;
			foreach ($sup as $s) {
				$sheet->setCellValue('A'.$p,$no3);
				$sheet->setCellValue('B'.$p,$s['nama_barang']);
				$sheet->setCellValue('C'.$p,$s['satuan']);
				$sheet->setCellValue('D'.$p,$s['jumlah_beli']);
				$sheet->setCellValue('E'.$p,$s['harga_beli']);
				$sheet->setCellValue('F'.$p,$s['total']);
				$sheet->getStyle("A$p:G$p")->applyFromArray($border);
				$no3++;
				$p++;
			}
			$indexAkhir13 = $p-1;
			$sheet->setCellValue('G'.$p, '=SUM(F'.$indexAwal3.':F'.$indexAkhir13.')');
			$sheet->getStyle('G'.$p)->getFont()->setBold(1);
			$sheet->getStyle("A$p:G$p")->applyFromArray($border);
			$p = $p+1;
			$sheet->setCellValue('A'.$p,'D.');
			$sheet->setCellValue('B'.$p,'ALAT KEBERSIHAN');
			$sheet->getStyle("A$p:B$p")->getFont()->setBold(1);
			$sheet->getStyle("A$p:G$p")->applyFromArray($border);
			$p = $p+1;
			$akb = $this->db->query("SELECT * from tb_detailtransaksi join tb_barang on tb_barang.id_barang = tb_detailtransaksi.id_barang JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_detailtransaksi.id_transaksi WHERE tb_transaksi.id_unit = $id_unit AND tb_barang.kategori = 'AKB' AND substr(tb_transaksi.created_at,6,2) = $bulan AND substr(tb_transaksi.created_at,1,4) = $tahun")->result_array();

			$no4 = 1;
			$total4 = [];
			$indexAwal4 = $p;
			foreach ($akb as $ak) {

				$sheet->setCellValue('A'.$p,$no4);
				$sheet->setCellValue('B'.$p,$ak['nama_barang']);
				$sheet->setCellValue('C'.$p,$ak['satuan']);
				$sheet->setCellValue('D'.$p,$ak['jumlah_beli']);
				$sheet->setCellValue('E'.$p,$ak['harga_beli']);
				$sheet->setCellValue('F'.$p,$ak['total']);
				$sheet->getStyle("A$p:G$p")->applyFromArray($border);
				$no4++;
				$p++;

			}

			$indexAkhir14 = $p-1;
			$sheet->setCellValue('G'.$p, '=SUM(F'.$indexAwal4.':F'.$indexAkhir14.')');
			$sheet->getStyle('G'.$p)->getFont()->setBold(1);
			$sheet->getStyle("A$p:G$p")->applyFromArray($border);

			$p=$p+1;
			$sheet->setCellValue("A$p",'');
			$sheet->getStyle("A$p:G$p")->applyFromArray($border);
			$p=$p+1;
			$sheet->setCellValue("A$p",'');
			$sheet->getStyle("A$p:G$p")->applyFromArray($border);
			$sheet->mergeCells("A$p:F$p");
			$sheet->setCellValue("A$p", 'JUMLAH');
			$akhir = $p-1;
			$sheet->setCellValue("G$p", '=SUM(G'.$indexAwal.':G'.$akhir.')');
			$sheet->getStyle("A$p")->getFont()->setBold(1);
			$sheet->getStyle("G$p")->getFont()->setBold(1);
			$sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("A$p:G$p")->applyFromArray($border);
			$sheet->getStyle("H$awal:H$akhir")->applyFromArray($border);

			$p = $p+2;

			$awal2 = $p;
			$sheet->mergeCells("F$p:H$p");
			$sheet->setCellValue("F$p", 'KOPERASI BRIWANTI');

			$p = $p+4;
			$sheet->setCellValue("F$p", 'Aep Maman RH');
			$sheet->getStyle("F$p")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

			$namaPegawai = 	$this->session->userdata('nama_lengkap');
			$sheet->setCellValue("H$p", $namaPegawai);
			$sheet->getStyle("H$p")->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
			$p=$p+1;
			$sheet->setCellValue("F$p", 'Ketua');
			$sheet->setCellValue("H$p", 'Pegawai Koperasi');

			$akhir2 = $p;
			$sheet->getStyle("F$awal2:H$akhir2")->getFont()->setBold(1);
			$sheet->getStyle("F$awal2:H$akhir2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$p=$p+5;

		$p++;

		}

		$filename = 'Report-'.time().'.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		header('Cache-Control: max-age=1');

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output'); 
	}

	//REPORT 1
	public function exportCabangBulan(){
		$bulan = $this->input->post('bulan_cabang');
		$cabang = $this->input->post('cabang');
		$tahun = $this->input->post('tahun_cabang');

		$bulann = "";

		if ($bulan == "Pilih Bulan" || $cabang == "Pilih Cabang") {
			$this->session->set_flashdata('fail', 'Gagal');
			redirect('laporan');
		}

		if ($bulan == 1) {
			$bulann = 'JANUARI';
		} elseif ($bulan == 2) {
			$bulann = 'FEBRUARI';
		} elseif ($bulan == 3) {
			$bulann = 'MARET';
		} elseif ($bulan == 4) {
			$bulann = 'APRIL';
		} elseif ($bulan == 5) {
			$bulann = 'MEI';
		} elseif ($bulan == 6) {
			$bulann = 'JUNI';
		} elseif ($bulan == 7) {
			$bulann = 'JULI';
		} elseif ($bulan == 8) {
			$bulann = 'AGUSTUS';
		} elseif ($bulan == 9) {
			$bulann = 'SEPTEMBER';
		} elseif ($bulan == 10) {
			$bulann = 'OKTOBER';
		} elseif ($bulan == 11) {
			$bulann = 'NOVEMBER';
		} elseif ($bulan == 12) {
			$bulann = 'DESEMBER';
		}


			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getColumnDimension('A')->setWidth(5);
			$sheet->getColumnDimension('B')->setWidth(30);
			$sheet->getColumnDimension('E')->setWidth(20);
			$sheet->getColumnDimension('F')->setWidth(20);
			$sheet->getColumnDimension('G')->setWidth(20);

		//ATK
		$p = 1;
		$kategori = ['ATK', 'PRC', 'SUP', 'AKB'];

		$namaCabang = $this->db->get_where('tb_unit', ['id_unit' => $cabang])->row();

		for ($i=0; $i < count($kategori) ; $i++) {


			if ($kategori[$i] == 'ATK') {
				$judul = "ALAT TULIS KANTOR";
			} elseif ($kategori[$i] == 'PRC') {
				$judul = "PERCETAKAN";
			} elseif ($kategori[$i] == 'SUP') {
				$judul = "SUPPLAIS KOMPUTER";
			} elseif ($kategori[$i] == 'AKB') {
				$judul = "ALAT KEBERSIHAN";
			}

			$awal = $p;
			$sheet->setCellValue('A'.$p, 'LAMPIRAN REKAPITULASI');
			$sheet->mergeCells("A$p:G$p");
			$p = $p+1;

			$sheet->setCellValue('A'.$p, 'PENGGUNAAN BIAYA '.$judul.' BRI CABANG '.strtoupper($namaCabang->nama_unit));
			$sheet->mergeCells("A$p:G$p");
			$p = $p+1;
			$sheet->setCellValue('A'.$p, 'POSISI BULAN '.$bulann.' '.$tahun);
			$sheet->mergeCells("A$p:G$p");
			$akhir = $p;

			$sheet->getStyle("A$awal:F$akhir")->getFont()->setBold(1);
			$sheet->getStyle("A$awal:F$akhir")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$p = $p+2;
			$paramborder = $p;
			$sheet->setCellValue("A$p",'No');
			$sheet->setCellValue("B$p",'Nama Barang');
			$sheet->setCellValue("C$p",'Satuan');
			$sheet->setCellValue("D$p",'Qty');
			$sheet->setCellValue("E$p",'Harga');
			$sheet->setCellValue("F$p",'Total');
			$sheet->getStyle("A$p:F$p")->getFont()->setBold(1);
			$sheet->getStyle("A$p:F$p")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$paramkategori = $kategori[$i];

			$item = $this->db->query("SELECT * from tb_detailtransaksi join tb_barang on tb_barang.id_barang = tb_detailtransaksi.id_barang JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_detailtransaksi.id_transaksi WHERE tb_transaksi.id_unit = $cabang AND tb_barang.kategori = '$paramkategori' AND substr(tb_transaksi.created_at,6,2) = $bulan AND substr(tb_transaksi.created_at,1,4) = $tahun")->result_array();
			$p = $p+1;
			$no1 = 1;
			$total1 = [];
			$rpawal1 = $p;
			foreach ($item as $a) {
				$sheet->setCellValue("A$p", $no1);
				$sheet->getStyle("A$p")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue("B$p", $a['nama_barang']);
				$sheet->setCellValue("C$p", $a['satuan']);
				$sheet->setCellValue("D$p", $a['jumlah_beli']);
				$sheet->setCellValue("E$p", $a['harga_jual']);
				$sheet->setCellValue("F$p", $a['total']);
				$no1++;
				$p++;
				$rpakhir2 = $p;
				$sheet->getStyle("E$rpawal1:F$rpakhir2")->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_RP);
				$sheet->getStyle("C$rpawal1:D$rpakhir2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			}
			$paramborder2 = $p;
			$border = [
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						],
					],
			];
			$sheet->mergeCells("A$p:F$p");
			$sheet->setCellValue("A$p", 'TOTAL');
			$sheet->getStyle("A$p")->getFont()->setBold(1);
			$sheet->getStyle("A$p")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$indexAkhirP = $p - 1;
			$sheet->setCellValue("G$p", '=SUM(F'.$rpawal1.':F'.$indexAkhirP.')');
			$sheet->getStyle("G$p")->getFont()->setBold(1);
			$sheet->getStyle("G$p")->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_RP);
			$sheet->getStyle("A$paramborder:G$paramborder2")->applyFromArray($border);

			$p = $p+3;

		}

		$filename = 'Report-'.time().'.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		header('Cache-Control: max-age=1');

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');

	}

	//REPORT 2
		public function exportDebetKategori(){
		$bulan = $this->input->post('bulan_debet');
		$kategori = $this->input->post('kategori_debet');
		$tahun = $this->input->post('tahun_debet');

		$bulann = "";

		if ($bulan == "Pilih Bulan" || $kategori == "Pilih Kategori") {
			$this->session->set_flashdata('fail', 'Gagal');
			redirect('laporan');
		}

		if ($bulan == 1) {
			$bulann = 'JANUARI';
		} elseif ($bulan == 2) {
			$bulann = 'FEBRUARI';
		} elseif ($bulan == 3) {
			$bulann = 'MARET';
		} elseif ($bulan == 4) {
			$bulann = 'APRIL';
		} elseif ($bulan == 5) {
			$bulann = 'MEI';
		} elseif ($bulan == 6) {
			$bulann = 'JUNI';
		} elseif ($bulan == 7) {
			$bulann = 'JULI';
		} elseif ($bulan == 8) {
			$bulann = 'AGUSTUS';
		} elseif ($bulan == 9) {
			$bulann = 'SEPTEMBER';
		} elseif ($bulan == 10) {
			$bulann = 'OKTOBER';
		} elseif ($bulan == 11) {
			$bulann = 'NOVEMBER';
		} elseif ($bulan == 12) {
			$bulann = 'DESEMBER';
		}


		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1','BANK RAKYAT INDONESIA');
		$sheet->setCellValue('E1', 'UM.10');
		$sheet->getStyle('E1')->getFont()->setBold(1);

		$sheet->setCellValue('C2', 'No Buku Besar');
		$sheet->mergeCells('D2:E2');
		$sheet->setCellValue('D2', '0302-01-000456-30-6');
		$sheet->getStyle('D2')->getFont()->setBold(1);

		$border = array(
			'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			        ],
			    ],
			);
		$sheet->getStyle('C2:E2')->applyFromArray($border);
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(25);
		$sheet->getColumnDimension('C')->setWidth(15);
		$sheet->getColumnDimension('D')->setWidth(15);
		$sheet->getColumnDimension('E')->setWidth(15);

		$sheet->setCellValue('C4', '');
		$sheet->mergeCells('D4:E4');
		$sheet->setCellValue('D4', 'KOPERASI BRIWANTI');
		$sheet->getStyle('C4:E4')->applyFromArray($border);

		$sheet->setCellValue('A5', "POSISI BULAN : $bulann ". $tahun);

		$sheet->setCellValue('A6', 'NO');
		$sheet->setCellValue('B6', 'NAMA BRI UNIT');
		$sheet->setCellValue('C6', 'NO REKENING');
		$sheet->setCellValue('D6', 'DEBET');
		$sheet->setCellValue('E6', 'KREDIT');

		$style = [
			'font' => [
		            'bold' => true,
		        ],
			'alignment' => [
				    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				],
			];

		$sheet->getRowDimension('6')->setRowHeight('30');
		$sheet->getStyle('A6:E6')->applyFromArray($style);

		$p = 7;

		$query = "SELECT * FROM tb_unit";
		$unit = $this->db->query($query)->result_array();
		$nomor = 1;
		$awal = $p -1;
		$awalUntukTotal = $p;
		$grand_total2 = [];
		foreach ($unit as $u) {
			$sheet->setCellValue('A'.$p, $nomor);
			$sheet->getStyle('A'.$p)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->setCellValue('B'.$p, strtoupper($u['nama_unit']));
			$sheet->setCellValue('C'.$p, strtoupper($u['no_rek']));
			$sheet->setCellValue('D'.$p, 0);

			$id_unit = $u['id_unit'];
			$kredit = $this->db->query("SELECT * FROM tb_detailtransaksi JOIN tb_barang ON tb_barang.id_barang = tb_detailtransaksi.id_barang JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_detailtransaksi.id_transaksi WHERE substr(tb_transaksi.created_at, 6,2 ) = $bulan AND substr(tb_transaksi.created_at,1,4) = $tahun AND tb_barang.kategori = '$kategori' AND tb_transaksi.id_unit = $id_unit")->result_array();
			$total = [];
			foreach ($kredit as $k) {
				$total[] = $k['total'];
			}

			$grand_total = array_sum($total);
			$sheet->setCellValue('E'.$p, $grand_total);
			$sheet->getStyle("D$p:E$p")->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_RP);
			$p++;
			$nomor++;
			$akhir = $p;

			$grand_total2[] = $grand_total;
		}
		$p = $p+1;
		$param = $awal-1;
		$param2 = $akhir-1;
		$sheet->mergeCells("A$p:C$p");
		$sheet->setCellValue('A'.$p, 'JUMLAH TOTAL');
		$sheet->getStyle('A'.$p)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->setCellValue("D$p","=SUM(D$param:D$param2)");

		//GRAND TOTAL KESELURUHAN
		$indexDikurangi = $p-2;
		$sheet->setCellValue("E$p", '=SUM(E'.$awalUntukTotal.':E'.$indexDikurangi.')');

		$sheet->getStyle("D$p:E$p")->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_RP);
		$sheet->getStyle("E$p")->getFont()->setBold(1);
		$sheet->getStyle("A$awal:E$p")->applyFromArray($border);

		$p = $p+2;
		$sheet->setCellValue('A'.$p, "REMARK : Tag.Biaya $kategori 2020");
		$sheet->getStyle('A'.$p)->getFont()->setBold(1);
		$sheet->setCellValue('C'.$p, 'SIGNER');
		$sheet->setCellValue('D'.$p, 'CHECKER');
		$sheet->setCellValue('E'.$p, 'MAKER');
				$sheet->getStyle("C$p:E$p")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$row1 = $p;

		$p = $p+1;

		$mergeakhir = $p+3;
		$sheet->mergeCells("C$p:C$mergeakhir");
		$sheet->mergeCells("D$p:D$mergeakhir");
		$sheet->mergeCells("E$p:E$mergeakhir");

		$borderbold = array(
			'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
			        ],
			    ],
			);
		$sheet->getStyle("C$row1:E$mergeakhir")->applyFromArray($borderbold);

		$filename = 'Report-'.time().'.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		header('Cache-Control: max-age=1');

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output'); 
	}

}