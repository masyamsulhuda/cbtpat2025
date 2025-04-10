<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* fungsi non database */
function tjs($tgl, $tipe)
{
	if ($tgl != "0000-00-00 00:00:00") {
		$pc_satu	= explode(" ", $tgl);
		if (count($pc_satu) < 2) {
			$tgl1		= $pc_satu[0];
			$jam1		= "";
		} else {
			$jam1		= $pc_satu[1];
			$tgl1		= $pc_satu[0];
		}
		$pc_dua		= explode("-", $tgl1);
		$tgl		= $pc_dua[2];
		$bln		= $pc_dua[1];
		$thn		= $pc_dua[0];
		$bln_pendek		= array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");
		$bln_panjang	= array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$bln_angka		= intval($bln) - 1;
		if ($tipe == "pj") {
			$bln_txt = $bln_panjang[$bln_angka];
		} else if ($tipe == "s") {
			$bln_txt = $bln_pendek[$bln_angka];
		}
		return $tgl . " " . $bln_txt . " " . $thn . "  " . $jam1;
	} else {
		return "Tgl Salah";
	}
}

function hari($wekday)
{
	$hari	= array("Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu");
	return $hari[$wekday];
}

function hariIndo($wekdayen)
{
	$hari = array(
		'Sun' => 'Minggu',
		'Mon' => 'Senin',
		'Tue' => 'Selasa',
		'Wed' => 'Rabu',
		'Thu' => 'Kamis',
		'Fri' => 'Jumat',
		'Sat' => 'Sabtu'
	);
	return $hari[$wekdayen];
}

function bulanIndo($montDay)
{
	$bln_indo		= array(
		'Jan' => 'Januari',
		'Feb' => 'Februari',
		'Mar' => 'Maret',
		'Apr' => 'April',
		'Mei' => 'Mei',
		'Jun' => 'Juni',
		'Jul' => 'Juli',
		'Ags' => 'Agustus',
		'Sep' => 'September',
		'Okt' => 'Oktober',
		'Nov' => 'November',
		'Dec' => 'Desember'
	);
	return $bln_indo[$montDay];
}

function emtpy_check($data, $teks)
{
	if (empty($data)) {
		return $teks;
	} else {
		return $data;
	}
}

function terbilang($bilangan)
{
	$bilangan = abs($bilangan);

	$angka 	= array("Nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp 	= "";

	if ($bilangan < 12) {
		$temp = " " . $angka[$bilangan];
	} else if ($bilangan < 20) {
		$temp = terbilang($bilangan - 10) . " belas";
	} else if ($bilangan < 100) {
		$temp = terbilang($bilangan / 10) . " puluh" . terbilang($bilangan % 10);
	} else if ($bilangan < 200) {
		$temp = " seratus" . terbilang($bilangan - 100);
	} else if ($bilangan < 1000) {
		$temp = terbilang($bilangan / 100) . " ratus" . terbilang($bilangan % 100);
	} else if ($bilangan < 2000) {
		$temp = " seribu" . terbilang($bilangan - 1000);
	} else if ($bilangan < 1000000) {
		$temp = terbilang($bilangan / 1000) . " ribu" . terbilang($bilangan % 1000);
	} else if ($bilangan < 1000000000) {
		$temp = terbilang($bilangan / 1000000) . " juta" . terbilang($bilangan % 1000000);
	}

	return $temp;
}

function tambah_jam_sql($menit)
{
	$str = "";
	if ($menit < 60) {
		$str = "00:" . str_pad($menit, 2, "0", STR_PAD_LEFT) . ":00";
	} else if ($menit >= 60) {
		$mod = $menit % 60;
		$bg = floor($menit / 60);
		$str = str_pad($bg, 2, "0", STR_PAD_LEFT) . ":" . str_pad($mod, 2, "0", STR_PAD_LEFT) . ":00";
	}
	return $str;
}

function bersih($data, $pil)
{
	// return mysql_real_escape_string
	return $data->$pil;
}

function obj_to_array($obj, $pilih)
{
	$pilihpc	= explode(",", $pilih);
	$array 		= array("" => "-- Pilih --");

	foreach ($obj as $o) {
		$xx = $pilihpc[0];
		$x = $o->$xx;
		$y = $pilihpc[1];

		$array[$x] = $o->$y;
	}

	return $array;
}

function tampil_media($file, $width = "320px", $height = "240px")
{
	$ret = '';

	$pc_file = explode(".", $file);
	$eks = end($pc_file);

	$eks_video = array("mp4", "flv", "mpeg");
	$eks_audio = array("mp3", "acc");
	$eks_image = array("jpeg", "jpg", "gif", "bmp", "png");


	if (!in_array($eks, $eks_video) && !in_array($eks, $eks_audio) && !in_array($eks, $eks_image)) {
		$ret .= '';
	} else {
		if (in_array($eks, $eks_video)) {
			if (is_file("./" . $file)) {
				$ret .= '<p><video width="' . $width . '" height="' . $height . '" controls>
				  <source src="' . base_url() . $file . '" type="video/mp4">
				  <source src="' . base_url() . $file . '" type="application/octet-stream">Browser tidak support</video></p>';
			} else {
				$ret .= '';
			}
		}

		if (in_array($eks, $eks_audio)) {
			if (is_file("./" . $file)) {
				$ret .= '<p><audio width="' . $width . '" height="' . $height . '" controls>
				<source src="' . base_url() . $file . '" type="audio/mpeg">
				<source src="' . base_url() . $file . '" type="audio/wav">Browser tidak support</audio></p>';
			} else {
				$ret .= '';
			}
		}

		if (in_array($eks, $eks_image)) {
			if (is_file("./" . $file)) {
				$ret .= '<div class="gambar"><img src="' . base_url() . $file . '" style="width: ' . $width . '; height: ' . $height . '; display: inline; float: left"></div>';
			} else {
				$ret .= '';
			}
		}
	}


	return $ret;
}

function j($data)
{
	header('Content-Type: application/json');
	echo json_encode($data);
}

function gen_menu()
{
	$CI 	= &get_instance();
	$sess_level = $CI->session->userdata('admin_level');
	$url = $CI->uri->segment(2);

	$menu = array();

	if ($sess_level == "guru") {
		$menu = array(
			array("icon" => "tachometer", "url" => "", "text" => "Home"),
			array("icon" => "database", "url" => "m_soal", "text" => "Bank Soal"),
			array("icon" => "briefcase", "url" => "m_ujian", "text" => "Pelaksanaan Ujian"),
			array("icon" => "certificate", "url" => "h_ujian", "text" => "Hasil Ujian"),
		);
	} else if ($sess_level == "siswa") {
		$menu = array(
			array("icon" => "tachometer", "url" => "", "text" => "Home"),
			array("icon" => "briefcase", "url" => "ikuti_ujian", "text" => "Pelaksanaan Ujian"),
		);
	} else if ($sess_level == "admin") {
		$menu = array(
			array("icon" => "tachometer", "url" => "", "text" => "Home"),
			array("icon" => "child", "url" => "m_siswa", "text" => "Siswa"),
			array("icon" => "building", "url" => "m_kelas", "text" => "Kelas"),
			array("icon" => "bookmark", "url" => "m_jurusan", "text" => "Jurusan"),
			array("icon" => "male", "url" => "m_guru", "text" => "Guru"),
			array("icon" => "archive", "url" => "m_mapel", "text" => "Mapel"),
			array("icon" => "database", "url" => "m_soal", "text" => "Bank Soal"),
			array("icon" => "certificate", "url" => "h_ujian", "text" => "Hasil Ujian"),
			array("icon" => "print", "url" => "m_cetak_kartu", "text" => "Kartu Ujian"),
		);
	} else {
		$menu = array(
			array("icon" => "tasks", "url" => "", "text" => "HOME")
		);
		if ($url == "ikut_ujian") {
			$menu = null;
		}
	}
	// <div class="container" style="margin-top: 75px">
	// <div class="row">
	// <div class="col-lg-12">
	if ($menu != null) {
		echo '
		<div class="panel panel-primary">
		<div class="panel-heading panel-success"><i class="fa fa-home"></i>&nbsp;<b>MENU DASHBOARD</b></div>
		    <div class="panel-body justify-content-center">';
		foreach ($menu as $m) {
			if ($url == $m['url']) {
				echo '<a href="' . base_url() . 'adm/' . $m['url'] . '"class="btn btn-block btn-sm btn-warning" style="margin-bottom:5px; text-align: left;"><i class="fa fa-' . $m['icon'] . '" aria-hidden="true"></i>&nbsp <b>' . $m['text'] . '</b> </a> ';
			} else {
				echo '<a href="' . base_url() . 'adm/' . $m['url'] . '"class="btn btn-block btn-sm btn-success" style="margin-bottom:5px; text-align: left;"><i class="fa fa-' . $m['icon'] . '" aria-hidden="true"></i>&nbsp <b>' . $m['text'] . '</b> </a> ';
			}
		}
		echo '</div></div>';
	}
}

function cek_hakakses($arr_yg_boleh_akses, $userid)
{
	if (!in_array($userid, $arr_yg_boleh_akses)) {
		redirect('adm');
	}
}
