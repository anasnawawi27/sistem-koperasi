<?php 

	function bulan(){
		$bulan = date('m');
		switch ($bulan) {
			case 1:
				$bulan = 'Januari';
				break;
			case 2:
				$bulan = 'Februari';
				break;
			case 3:
				$bulan = 'Maret';
				break;
			case 4:
				$bulan = 'April';
				break;
			case 5:
				$bulan = 'Mei';
				break;
			case 6:
				$bulan = 'Juni';
				break;
			case 7:
				$bulan = 'Juli';
				break;
			case 8:
				$bulan = 'Agustus';
				break;
			case 9:
				$bulan = 'September';
				break;
			case 10:
				$bulan = 'Oktober';
				break;
			case 11:
				$bulan = 'November';
				break;
			case 12:
				$bulan = 'Desember';
				break;

			default:
				$bulan = 'Nama bulan tidak tersedia';
				break;
		}

		return $bulan;
	}

	function hari(){
		$hari = date('D');

		switch ($hari) {
			case 'Sun':
				$hari = 'Minggu';
				break;
			case 'Mon':
				$hari = 'Senin';
				break;
			case 'Tue':
				$hari = 'Selasa';
				break;
			case 'Wed':
				$hari = 'Rabu';
				break;
			case 'Thu':
				$hari = 'Kamis';
				break;
			case 'Fri':
				$hari = 'Jumat';
				break;
			case 'Sat':
				$hari = 'Sabtu';
				break;
			default:
				$hari = 'Hari tidak ditemukan';
				break;
		}
		return $hari;
	}

	function active($param){
		$CI =& get_instance();
		if ($CI->uri->segment(1) == $param  && $CI->uri->segment(2) == "tambah")
			{
				echo "active";
			} elseif ($CI->uri->segment(1) == $param  && $CI->uri->segment(2) == "ubah")
			{ 
				echo "active";
			} elseif ($CI->uri->segment(1) == $param  && $CI->uri->segment(2) == "data")
			{ 
				echo "active";
			}
	}




 ?>