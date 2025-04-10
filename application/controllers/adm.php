<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Adm extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->db->query("SET time_zone='+7:00'");
		$waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
		$this->waktu_sql = $waktu_sql['waktu'];
		$this->opsi = array("a", "b", "c", "d", "e");
		$this->load->library(array('session', 'pdflibrary'));
	}

	public function get_servertime()
	{
		$now = new DateTime();
		$dt = $now->format("M j, Y H:i:s O");
		j($dt);
	}

	public function cek_aktif()
	{
		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
			redirect('adm/login');
		}
	}

	public function cek_token()
	{
		if ($this->session->userdata('ujian_valid') == false && $this->session->userdata('ujian_token') == "") {
			redirect('adm/ikuti_ujian');
		}
	}

	public function index()
	{
		$this->cek_aktif();
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");

		if ($a['sess_level'] == "guru") {
			$a['ujian'] = $this->db->query("SELECT * FROM tr_guru_tes WHERE id_guru = '" . $a['sess_konid'] . "'")->num_rows();
			$a['mapel'] = $this->db->query("SELECT * FROM tr_guru_mapel WHERE id_guru = '" . $a['sess_konid'] . "'")->num_rows();
			$a['soal'] = $this->db->query("SELECT * FROM m_soal WHERE id_guru = '" . $a['sess_konid'] . "'")->num_rows();
		} else if ($a['sess_level'] == "admin") {
			$a['ujian'] = $this->db->query("SELECT * FROM tr_guru_tes")->num_rows();
			$a['siswa'] = $this->db->query("SELECT * FROM m_siswa")->num_rows();
			$a['proktor'] = $this->db->query("SELECT * FROM m_guru")->num_rows();
		} else if ($a['sess_level'] == "siswa") {
			$x = $this->db->query("SELECT id, jurusan, id_jurusan FROM m_siswa WHERE id = '" . $a['sess_konid'] . "'")->row();
			$y = "UMUM";
			$d = date('Y-m-d');
			$a['ujian'] = $this->db->query("SELECT a.id, a.nama_ujian, a.jumlah_soal, a.waktu, a.kelas, a.jurusan, a.tgl_mulai, b.nama nmmapel, c.nama nmguru,
										IF((d.status='Y' AND NOW() BETWEEN d.tgl_mulai AND d.tgl_selesai),'Sedang Tes',
										IF(d.status='Y' AND NOW() NOT BETWEEN d.tgl_mulai AND d.tgl_selesai,'Waktu Habis',
										IF(d.status='N','Selesai','Belum Ikut'))) status
										FROM tr_guru_tes a INNER JOIN m_mapel b ON a.id_mapel = b.id INNER JOIN m_guru c ON a.id_guru = c.id
										LEFT JOIN tr_ikut_ujian d ON CONCAT('" . $a['sess_konid'] . "',a.id) = CONCAT(d.id_user,d.id_tes)
										WHERE a.kelas = '" . $x->jurusan . "' AND a.jurusan LIKE '%" . $x->id_jurusan . "%' OR a.jurusan LIKE '%" . $y . "%'")->num_rows();
			$a['selesai_ujian'] = $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id_user = '" . $a['sess_konid'] . "' AND status = 'N'")->num_rows();
		}
		$a['p']			= "v_main";
		$this->load->view('aaa', $a);
	}

	public function kartupeserta()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");

		$data = $this->db->query("SELECT * FROM m_siswa")->result_array();
		$nama_sekolah = $a['lembaga']['lembaga_profile'];
		$nama_ujian = $a['aplikasi']['ujian_nama'];
		$tgl_ujian = $a['aplikasi']['ujian_tanggal'];
		$nama_kepala = $a['lembaga']['lembaga_pimpinan'];
		$nip_kepala = $a['lembaga']['lembaga_pimpinan_nip'];

		$pdf = new FPDF('P', 'mm', 'A4');
		$this->load->library('CustomFPDF');
		$pdf = $this->customfpdf->getInstance();
		$pdf->AddPage();
		foreach ($data as $load) {
			$pdf->SetTitle('KARTU PESERTA - ' . strtoupper($nama_ujian), true);
			$pdf->SetFont('Arial', '', 7);

			// logo
			$pdf->Cell(3.5, 3, '', 0, 0);
			$pdf->Cell(20, null, $pdf->Image('upload/gambar_lembaga/' . $a['lembaga']['lembaga_foto'], null, 17, 10), 0, 1, 'C');
			$pdf->Cell(3.5, 3, '', 0, 0);
			$pdf->Cell(20, null, $pdf->Image('upload/gambar_lembaga/' . $a['lembaga']['lembaga_foto'], null, 84, 10), 0, 1, 'C');
			$pdf->Cell(3.5, 3, '', 0, 0);
			$pdf->Cell(20, null, $pdf->Image('upload/gambar_lembaga/' . $a['lembaga']['lembaga_foto'], null, 151.5, 10), 0, 1, 'C');
			$pdf->Cell(3.5, 3, '', 0, 0);
			$pdf->Cell(20, null, $pdf->Image('upload/gambar_lembaga/' . $a['lembaga']['lembaga_foto'], null, 219, 10), 0, 1, 'C');

			// ttd
			$pdf->Cell(38, 3, '', 0, 0);
			$pdf->Cell(20, null, $pdf->Image('upload/gambar_ttd/' . $a['lembaga']['lembaga_ttd'], null, 56, 20), 0, 1, 'C');
			$pdf->Cell(38, 3, '', 0, 0);
			$pdf->Cell(20, null, $pdf->Image('upload/gambar_ttd/' . $a['lembaga']['lembaga_ttd'], null, 123, 20), 0, 1, 'C');
			$pdf->Cell(38, 3, '', 0, 0);
			$pdf->Cell(20, null, $pdf->Image('upload/gambar_ttd/' . $a['lembaga']['lembaga_ttd'], null, 190, 20), 0, 1, 'C');
			$pdf->Cell(38, 3, '', 0, 0);
			$pdf->Cell(20, null, $pdf->Image('upload/gambar_ttd/' . $a['lembaga']['lembaga_ttd'], null, 257, 20), 0, 1, 'C');

			//kop kartu
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(90, 0.1, '', 1, 1, 'C');
			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);

			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(15, 3, '', 0, 0, 'L');
			$pdf->Cell(74.8, 3, 'KARTU AKUN', 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(15, 3, '', 0, 0, 'L');
			$pdf->Cell(74.8, 3, $nama_ujian, 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(15, 3, '', 0, 0, 'L');
			$pdf->Cell(74.8, 3, $nama_sekolah, 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);

			$pdf->Cell(90, 0.1, '', 1, 1, 'C');

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);
			// $pdf->HeaderKartu();
			//konten kartu
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(2.8, 3, '', 0, 0);
			$pdf->Cell(20, 3, 'Nama', 0, 0);
			$pdf->Cell(67, 3, ': ' . $load['nama'], 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(2.8, 3, '', 0, 0);
			$pdf->Cell(20, 3, 'Kelas', 0, 0);
			$pdf->Cell(67, 3, ': ' . $load['jurusan'] . ' ' . $load['id_jurusan'], 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(2.8, 3, '', 0, 0);
			$pdf->Cell(20, 3, 'No. Peserta', 0, 0);
			$pdf->Cell(67, 3, ': ' . $load['nopes'], 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(2.8, 3, '', 0, 0);
			$pdf->Cell(20, 3, 'Username', 0, 0);
			$pdf->Cell(67, 3, ': ' . $load['nim'], 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(2.8, 3, '', 0, 0);
			$pdf->Cell(20, 3, 'Password', 0, 0);
			$pdf->Cell(67, 3, ': ' . $load['sandi'], 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);

			//footer kartu
			// $pdf->FooterKartu();
			$pdf->Cell(10, 0, '', 0, 0);
			$pdf->Cell(17, 0, '', 1, 0);
			$pdf->Cell(63, 0, '', 0, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(9.8, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(16.9, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(13.9, 3, '', 0, 0);
			$pdf->Cell(49, 3, $tgl_ujian, 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(9.8, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(16.9, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(13.9, 3, '', 0, 0);
			$pdf->Cell(49, 3, 'Ketua Panitia', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(9.8, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(16.9, 2.5, '', 0, 0, 'C');
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(13.9, 2.5, '', 0, 0);
			$pdf->Cell(49, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 1);

			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(9.8, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(16.9, 2.5, 'foto', 0, 0, 'C');
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(13.9, 2.5, '', 0, 0);
			$pdf->Cell(49, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 1);

			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(9.8, 2.53, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(16.9, 2.5, '2 x 3', 0, 0, 'C');
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(13.9, 2.5, '', 0, 0);
			$pdf->Cell(49, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 1);

			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(9.8, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(16.9, 2.5, '', 0, 0, 'C');
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(13.9, 2.5, '', 0, 0);
			$pdf->Cell(49, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 1);

			$pdf->SetFont('Arial', 'BU', 7);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(9.8, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(16.9, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(13.9, 3, '', 0, 0);
			$pdf->Cell(49, 3, $nama_kepala, 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(9.8, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(16.9, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(13.9, 3, '', 0, 0);
			$pdf->Cell(49, 3, 'NIP. ' . $nip_kepala, 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(10, 0, '', 0, 0);
			$pdf->Cell(17, 0, '', 1, 0);
			$pdf->Cell(63, 0, '', 0, 1);

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);

			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(90, 0, '', 1, 1);
			$pdf->Ln(9);
		}
		$pdf->Output('I', 'KARTU PESERTA - ' . strtoupper($nama_ujian) . '.pdf');
	}

	/* == ADMIN == */
	public function m_siswa()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		$a['kelas'] = $this->db->query("SELECT m_kelas.* FROM m_kelas ORDER BY kelas ASC")->result();
		$a['jurusan'] = $this->db->query("SELECT m_jurusan.* FROM m_jurusan ORDER BY jurusan ASC")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_siswa WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_siswa SET nama = '" . bersih($p, "nama") . "', nopes = '" . bersih($p, "nopes") . "', nim = '" . bersih($p, "nim") . "', jurusan = '" . bersih($p, "jurusan") . "', id_jurusan = '" . bersih($p, "id_jurusan") . "'	WHERE id = '" . bersih($p, "id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_siswa VALUES (null, '" . bersih($p, "nama") . "', '" . bersih($p, "nopes") . "', '" . bersih($p, "nim") . "', '" . bersih($p, "nim") . "', '" . bersih($p, "jurusan") . "', '" . bersih($p, "id_jurusan") . "', null)");
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_siswa WHERE id = '" . $uri4 . "'");
			$this->db->query("DELETE FROM m_admin WHERE level = 'siswa' AND kon_id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapussemua") {
			$this->db->query("TRUNCATE TABLE m_siswa");
			$this->db->query("DELETE FROM m_admin WHERE level = 'siswa'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "non_aktifkan") {
			$this->db->query("DELETE FROM m_admin WHERE level = 'siswa' AND kon_id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "disable sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "user") {
			$det_user = $this->db->query("SELECT id, nim FROM m_siswa WHERE id = '$uri4'")->row();
			if (!empty($det_user)) {
				$q_cek_username = $this->db->query("SELECT id FROM m_admin WHERE username = '" . $det_user->nim . "' AND level = 'siswa'")->num_rows();
				if ($q_cek_username < 1) {
					$sandi = sha1($det_user->nim);
					$this->db->query("UPDATE m_siswa SET sandi = '" . $det_user->nim . "' WHERE id='" . $det_user->id . "'");
					$this->db->query("INSERT INTO m_admin VALUES (null, '" . $det_user->nim . "', '" . $sandi . "', 'siswa', '" . $det_user->id . "')");
					$ret_arr['status'] 	= "ok";
					$ret_arr['caption']	= "tambah user sukses";
					j($ret_arr);
				} else {
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "Username telah digunakan";
					j($ret_arr);
				}
			} else {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "tambah user gagal";
				j($ret_arr);
			}
			exit();
		} else if ($uri3 == "user_reset") {
			$det_user = $this->db->query("SELECT id, nim FROM m_siswa WHERE id = '$uri4'")->row();
			$sandi = sha1($det_user->nim);
			$this->db->query("UPDATE m_siswa SET sandi = '" . $det_user->nim . "' WHERE id='" . $det_user->id . "'");
			$this->db->query("UPDATE m_admin SET password = '" . $sandi . "' WHERE level = 'siswa' AND kon_id = '" . $det_user->id . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "Update password sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "ambil_matkul") {
			$matkul = $this->db->query("SELECT m_mapel.*,
										(SELECT COUNT(id) FROM tr_siswa_mapel WHERE id_siswa = " . $uri4 . " AND id_mapel = m_mapel.id) AS ok
										FROM m_mapel
										")->result();
			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $matkul;
			j($ret_arr);
			exit;
		} else if ($uri3 == "simpan_matkul") {
			$ket 	= "";
			//echo var_dump($p);
			$ambil_matkul = $this->db->query("SELECT id FROM m_mapel ORDER BY id ASC")->result();
			if (!empty($ambil_matkul)) {
				foreach ($ambil_matkul as $a) {
					$p_sub = "id_mapel_" . $a->id;
					if (!empty($p->$p_sub)) {
						$cek_sudah_ada = $this->db->query("SELECT id FROM tr_siswa_mapel WHERE  id_siswa = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'")->num_rows();
						if ($cek_sudah_ada < 1) {
							$this->db->query("INSERT INTO tr_siswa_mapel VALUES (null, '" . $p->id_mhs . "', '" . $a->id . "')");
						} else {
							$this->db->query("UPDATE tr_siswa_mapel SET id_mapel = '" . $p->$p_sub . "' WHERE id_siswa = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'");
						}
					} else {
						//echo "0<br>";
						$this->db->query("DELETE FROM tr_siswa_mapel WHERE id_siswa = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'");
					}
				}
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$d_total_row = $this->db->query("SELECT id FROM m_siswa a WHERE a.nama LIKE '%" . $search['value'] . "%'")->num_rows();
			$q_datanya = $this->db->query("SELECT a.*, 
											(SELECT COUNT(id) FROM m_admin WHERE level = 'siswa' AND kon_id = a.id) AS ada
											FROM m_siswa a
											-- INNER JOIN m_jurusan b ON a.id_jurusan = b.id
	                                        WHERE a.nama LIKE '%" . $search['value'] . "%' ORDER BY nama ASC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);
			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[] = '<center>' . $no++ . '</center>';
				$data_ok[] = $d['nama'];
				$data_ok[] = $d['sandi'];
				$data_ok[] = $d['nopes'];
				$data_ok[] = $d['nim'];
				$data_ok[] = '<center>' . $d['jurusan'] . '</center>';
				$data_ok[] = '<center>' . $d['id_jurusan'] . '</center>';
				$data_ok[] = '<center><div class="btn-group mt-1 mb-1">';
				if ($a['sess_level'] == "admin") {
					$data_ok[7] .= '<a href="#" title="Edit" onclick="return m_siswa_e(' . $d['id'] . ');" class="btn btn-success btn-xs fw-bold"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>';
					$data_ok[7] .= '<a href="#" title="Hapus" onclick="return m_siswa_h(' . $d['id'] . ');" class="btn btn-danger btn-xs fw-bold"><i class="fa fa-times-circle" aria-hidden="true"></i> Hapus</a>';
				}
				if ($d['ada'] == "0") {
					$data_ok[7] .= '<a href="#" title="Aktifkan" onclick="return m_siswa_u(' . $d['id'] . ');" class="btn btn-warning btn-xs fw-bold"><i class="fa fa-user-plus" aria-hidden="true"></i> Active</a>';
				} else {
					$data_ok[7] .= '<a href="#" title="Reset Password" onclick="return m_siswa_ur(' . $d['id'] . ');" class="btn btn-warning btn-xs fw-bold"><i class="fa fa-lock" aria-hidden="true"></i> Reset</a>';
					$data_ok[7] .= '<a href="#" title="Nonaktifkan" onclick="return m_siswa_non_aktif(' . $d['id'] . ');" class="btn btn-info btn-xs fw-bold"><i class="fa fa-user-times" aria-hidden="true"></i> Disable</a>';
				}
				$data[] = $data_ok;
			}
			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "import") {
			$a['p']	= "f_siswa_import";
		} else if ($uri3 == "aktifkan_semua") {
			$q_get_user = $this->db->query("select 
								a.id, a.nama, a.nim, ifnull(b.username,'N') usernya
								from m_siswa a 
								left join m_admin b on concat(b.level,b.kon_id) = concat('siswa',a.id)")->result_array();
			$jml_aktif = 0;
			if (!empty($q_get_user)) {
				foreach ($q_get_user as $j) {
					if ($j['usernya'] == "N") {
						$sandi = sha1($j['nim']);
						$this->db->query("UPDATE m_siswa SET sandi = '" . $j['nim'] . "' WHERE id='" . $j['id'] . "'");
						$this->db->query("INSERT INTO m_admin VALUES (null, '" . $j['nim'] . "', '" . $sandi . "', 'siswa', '" . $j['id'] . "')");
						$jml_aktif++;
					}
				}
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $jml_aktif . " user diaktifkan";
			j($ret_arr);
			exit();
		} else {
			$a['p']	= "m_siswa";
		}
		$this->load->view('aaa', $a);
	}
	public function lembaga()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		if ($uri3 == "svapps") {
			$pdata = array(
				"aplikasi_nama" => $p->app_name,
				"aplikasi_versi" => $p->app_versi,
				"ujian_nama" => $p->tes_name,
				"ujian_tanggal" => $p->tes_tanggal,
				"ujian_nilai" => $p->tes_nilai,
				"ujian_opsi" => $p->tes_opsi,
			);
			$this->db->where("settings_id", $p->id);
			$this->db->update("m_setting", $pdata);
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "svlmg") {
			$pdata = array(
				"lembaga_jenjang" => $p->lembaga_jenjang,
				"lembaga_nsm" => $p->lembaga_nsm,
				"lembaga_npsn" => $p->lembaga_npsn,
				"lembaga_tahun" => $p->lembaga_tahun,
				"lembaga_profile" => $p->lembaga_nama,
				"lembaga_alamat" => $p->lembaga_alamat,
				"lembaga_web" => $p->lembaga_web,
				"lembaga_email" => $p->lembaga_email,
				"lembaga_kota" => $p->lembaga_kota,
				"lembaga_telp" => $p->lembaga_telp,
				"lembaga_pimpinan" => $p->lembaga_pimpinan,
				"lembaga_pimpinan_nip" => $p->lembaga_pimpinan_nip,
			);
			$this->db->where("lembaga_id", $p->id);
			$this->db->update("m_lembaga", $pdata);
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "svgmb") {
			$p = $this->input->post();
			$folder_gb_lembaga = "./upload/gambar_lembaga/";
			$buat_folder_gb_lembaga = !is_dir($folder_gb_lembaga) ? @mkdir("./upload/gambar_lembaga/") : false;
			$allowed_type 	= array(
				"image/jpeg", "image/png", "image/gif"
			);
			$name_logo = date('dmYHis');
			$gagal 		= array();
			$nama_file 	= array();
			$tipe_file 	= array();
			foreach ($_FILES as $k => $v) {
				$file_name 		= $_FILES[$k]['name'];
				$file_type		= $_FILES[$k]['type'];
				$file_tmp		= $_FILES[$k]['tmp_name'];
				$file_error		= $_FILES[$k]['error'];
				$file_size		= $_FILES[$k]['size'];
				$kode_file_error = array("File berhasil diupload", "Ukuran file terlalu besar", "Ukuran file terlalu besar", "File upload error", "Tidak ada file yang diupload", "File upload error");
				if ($file_error != 0) {
					$gagal[$k] = $kode_file_error[$file_error];
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else if (!in_array($file_type, $allowed_type)) {
					$gagal[$k] = "Tipe file ini tidak diperbolehkan!";
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
					redirect('adm/lembaga');
				} else if ($file_name == "") {
					$gagal[$k] = "Tidak ada file yang diupload";
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else {
					$ekstensi = explode(".", $file_name);
					$file_name = $name_logo . "." . $ekstensi[1];
					if ($k == "foto") {
						@move_uploaded_file($file_tmp, $folder_gb_lembaga . $file_name);
					}
					$gagal[$k]	 	= $kode_file_error[$file_error]; //kode kegagalan upload file
					$nama_file[$k]	= $file_name; //ambil nama file
					$tipe_file[$k]	= $file_type; //ambil tipe file

					$data_simpan = array();
					if (!empty($nama_file['foto'])) {
						$data_simpan = array(
							"lembaga_foto" => $nama_file['foto']
						);
					}
					$id_lembaga = $p['id'];
					$gambar_lama = $this->db->query("SELECT lembaga_foto FROM m_lembaga WHERE lembaga_id = '" . $id_lembaga . "'")->row();
					@unlink("./upload/gambar_lembaga/" . $gambar_lama->lembaga_foto);
					$this->db->where("lembaga_id", $id_lembaga);
					$this->db->update("m_lembaga", $data_simpan);
				}
			}
			//ambil data awal
			$teks_gagal = "";
			foreach ($gagal as $k => $v) {
				$teks_gagal .= $v;
			}
			$this->session->set_flashdata('k', '<div class="alert alert-info">' . $teks_gagal . '</div>');
			redirect('adm/lembaga');
		} else if ($uri3 == "svttd") {
			$p = $this->input->post();
			$folder_gb_lembaga = "./upload/gambar_ttd/";
			$buat_folder_gb_lembaga = !is_dir($folder_gb_lembaga) ? @mkdir("./upload/gambar_ttd/") : false;
			$allowed_type 	= array(
				"image/jpeg", "image/png", "image/gif"
			);
			$name_logo = date('dmYHis');
			$gagal 		= array();
			$nama_file 	= array();
			$tipe_file 	= array();
			foreach ($_FILES as $k => $v) {
				$file_name 		= $_FILES[$k]['name'];
				$file_type		= $_FILES[$k]['type'];
				$file_tmp		= $_FILES[$k]['tmp_name'];
				$file_error		= $_FILES[$k]['error'];
				$file_size		= $_FILES[$k]['size'];
				$kode_file_error = array("File berhasil diupload", "Ukuran file terlalu besar", "Ukuran file terlalu besar", "File upload error", "Tidak ada file yang diupload", "File upload error");
				if ($file_error != 0) {
					$gagal[$k] = $kode_file_error[$file_error];
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else if (!in_array($file_type, $allowed_type)) {
					$gagal[$k] = "Tipe file ini tidak diperbolehkan!";
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
					redirect('adm/lembaga');
				} else if ($file_name == "") {
					$gagal[$k] = "Tidak ada file yang diupload";
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else {
					$ekstensi = explode(".", $file_name);
					$file_name = $name_logo . "." . $ekstensi[1];
					if ($k == "foto") {
						@move_uploaded_file($file_tmp, $folder_gb_lembaga . $file_name);
					}
					$gagal[$k]	 	= $kode_file_error[$file_error]; //kode kegagalan upload file
					$nama_file[$k]	= $file_name; //ambil nama file
					$tipe_file[$k]	= $file_type; //ambil tipe file

					$data_simpan = array();
					if (!empty($nama_file['foto'])) {
						$data_simpan = array(
							"lembaga_ttd" => $nama_file['foto']
						);
					}
					$id_lembaga = $p['id'];
					$gambar_lama = $this->db->query("SELECT lembaga_ttd FROM m_lembaga WHERE lembaga_id = '" . $id_lembaga . "'")->row();
					@unlink("./upload/gambar_ttd/" . $gambar_lama->lembaga_ttd);
					$this->db->where("lembaga_id", $id_lembaga);
					$this->db->update("m_lembaga", $data_simpan);
				}
				//ambil data awal
				$teks_gagal = "";
				foreach ($gagal as $k => $v) {
					$teks_gagal .= $v;
				}
				$this->session->set_flashdata('k', '<div class="alert alert-info">' . $teks_gagal . '</div>');
				redirect('adm/lembaga');
			}
		} else {
			$a['p']	= "m_lembaga";
		}
		$this->load->view('aaa', $a);
	}
	public function m_jurusan()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['data'] = $this->db->query("SELECT m_jurusan.* FROM m_jurusan")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_jurusan WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_jurusan SET jurusan = '" . bersih($p, "jurusan") . "'
									WHERE id = '" . bersih($p, "id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_jurusan VALUES (null, '" . bersih($p, "jurusan") . "')");
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_jurusan WHERE id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$d_total_row = $this->db->query("SELECT id FROM m_jurusan a WHERE a.jurusan LIKE '%" . $search['value'] . "%'")->num_rows();
			$q_datanya = $this->db->query("SELECT a.*
												FROM m_jurusan a
												WHERE a.jurusan LIKE '%" . $search['value'] . "%' ORDER BY a.jurusan ASC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);
			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = '<center>' . $no++ . '</center>';
				$data_ok[1] = $d['jurusan'];
				$data_ok[2] = '<center><div class="btn-group mt-1 mb-1">
							  <a href="#" onclick="return m_jurusan_e(' . $d['id'] . ');" class="btn btn-success btn-xs fw-bold"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
							  <a href="#" onclick="return m_jurusan_h(' . $d['id'] . ');" class="btn btn-danger btn-xs fw-bold" id="alert-delete"><i class="fa fa-times-circle" aria-hidden="true"></i> Hapus</a>
							 ';
				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else {
			$a['p']	= "m_jurusan";
		}
		$this->load->view('aaa', $a);
	}
	/* == KELAS == */
	public function m_kelas()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['data'] = $this->db->query("SELECT m_kelas.* FROM m_kelas")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_kelas WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_kelas SET kelas = '" . bersih($p, "kelas") . "'
									WHERE id = '" . bersih($p, "id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_kelas VALUES (null, '" . bersih($p, "kelas") . "')");
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_kelas WHERE id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			$d_total_row = $this->db->query("SELECT id FROM m_kelas a WHERE a.kelas LIKE '%" . $search['value'] . "%'")->num_rows();

			$q_datanya = $this->db->query("SELECT a.*
												FROM m_kelas a
												WHERE a.kelas LIKE '%" . $search['value'] . "%' ORDER BY a.kelas ASC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);

			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = '<center>' . $no++ . '</center>';
				$data_ok[1] = $d['kelas'];
				$data_ok[2] = '<center><div class="btn-group mt-1 mb-1">
							  <a href="#" title="Edit" onclick="return m_kelas_e(' . $d['id'] . ');" class="btn btn-success btn-xs fw-bold"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
							  <a href="#" title="Hapus" onclick="return m_kelas_h(' . $d['id'] . ');" class="btn btn-danger btn-xs fw-bold"><i class="fa fa-times-circle" aria-hidden="true"></i> Hapus</a>
							 ';

				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else {
			$a['p']	= "m_kelas";
		}
		$this->load->view('aaa', $a);
	}
	public function m_ruang()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		$a['kelas'] = $this->db->query("SELECT m_kelas.* FROM m_kelas ORDER BY kelas ASC")->result();
		$a['jurusan'] = $this->db->query("SELECT m_jurusan.* FROM m_jurusan ORDER BY jurusan ASC")->result();
		$a['ruangan'] = $this->db->query("SELECT * FROM m_ruang")->result_array();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_siswa WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$d_total_row = $this->db->query("SELECT id FROM m_siswa a WHERE a.nama LIKE '%" . $search['value'] . "%'")->num_rows();
			$q_datanya = $this->db->query("SELECT a.*, (SELECT COUNT(id) FROM m_admin WHERE level = 'siswa' AND kon_id = a.id) AS ada, ruang_nama FROM m_siswa a LEFT JOIN m_ruang ON a.id_ruang=m_ruang.ruang_id WHERE a.nama LIKE '%" . $search['value'] . "%' ORDER BY jurusan, id_jurusan, nama ASC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);
			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[] = '<center>' . $no++ . '</center>';
				$data_ok[] = '<center><input type="checkbox" id="pilih_siswa" name="pilih_siswa[]" value="' . $d['id'] . '"></center>';
				$data_ok[] = $d['nama'];
				$data_ok[] = $d['nopes'];
				$data_ok[] = $d['nim'];
				$data_ok[] = '<center>' . $d['jurusan'] . ' ' . $d['id_jurusan'] . '</center>';
				$data_ok[] = $d['ruang_nama'];
				$data[] = $data_ok;
			}
			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "simpan_ruang_siswa") {
			$siswa = $_POST['pilih_siswa'];
			$ruang = $_POST['ruangan'];
			$jmlSiswa = count($siswa);
			for ($i = 0; $i < $jmlSiswa; $i++) {
				$this->db->query("UPDATE m_siswa SET id_ruang = '" . $ruang . "' WHERE id = '" . $siswa[$i] . "'");
			}
			redirect('adm/m_ruang');
		} else {
			$a['p']	= "m_ruang";
		}
		$this->load->view('aaa', $a);
	}
	public function m_ruangan()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['data'] = $this->db->query("SELECT m_ruang.* FROM m_ruang")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_ruang WHERE ruang_id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->ruangan_id != 0) {
				$this->db->query("UPDATE m_ruang SET ruang_nama = '" . bersih($p, "ruangan_nama") . "', ruang_server = '" . bersih($p, "ruangan_server") . "' WHERE ruang_id = '" . bersih($p, "ruangan_id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_ruang VALUES (null, '" . bersih($p, "ruangan_nama") . "', '" . bersih($p, "ruangan_server") . "')");
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_ruang WHERE ruang_id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$d_total_row = $this->db->query("SELECT ruang_id FROM m_ruang a WHERE a.ruang_nama LIKE '%" . $search['value'] . "%'")->num_rows();
			$q_datanya = $this->db->query("SELECT a.* FROM m_ruang a WHERE a.ruang_nama LIKE '%" . $search['value'] . "%' ORDER BY a.ruang_nama ASC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);

			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = '<center>' . $no++ . '</center>';
				$data_ok[1] = $d['ruang_nama'];
				$data_ok[2] = $d['ruang_server'];
				$data_ok[3] = '<center><div class="btn-group mt-1 mb-1">
				<a href="m_ruangan/dafdir/' . $d['ruang_id'] . '" title="Cetak" target="_blank" class="btn btn-primary btn-xs fw-bold"><i class="fa fa-print" aria-hidden="true"></i> Print</a>			  
				<a href="#" title="Edit" onclick="return m_ruangan_e(' . $d['ruang_id'] . ');" class="btn btn-success btn-xs fw-bold"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
				<a href="#" title="Hapus" onclick="return m_ruangan_h(' . $d['ruang_id'] . ');" class="btn btn-danger btn-xs fw-bold"><i class="fa fa-times-circle" aria-hidden="true"></i> Hapus</a>';

				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "dafdir") {
			$b = $this->db->query("SELECT * FROM m_siswa INNER JOIN m_ruang ON m_siswa.id_ruang = m_ruang.ruang_id WHERE m_siswa.id_ruang = '" . $uri4 . "'")->result();
			$c = $this->db->query("SELECT * FROM m_ruang WHERE ruang_id='" . $uri4 . "'")->row();

			$nama_kota = $a['lembaga']['lembaga_kota'];
			$tahunpelajaran = $a['lembaga']['lembaga_tahun'];
			$nama_sekolah = $a['lembaga']['lembaga_profile'];
			$jenjang_sekolah = $a['lembaga']['lembaga_jenjang'];
			$nama_ujian = $a['aplikasi']['ujian_nama'];

			$pdf = new FPDF('P', 'mm', array(210, 330));
			$pdf->AddPage();
			$pdf->AliasNbPages();
			$pdf->SetTitle('Daftar Hadir Peserta - ' . $c->ruang_nama, true);
			$pdf->SetFont('Arial', '', 7);
			$pdf->Image('upload/gambar_lembaga/' . $a['lembaga']['lembaga_foto'], 10, 8, 20);

			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(0, 5, 'DAFTAR HADIR PESERTA', 0, 1, 'C');
			$pdf->Cell(0, 5, $nama_ujian . ' ' . $jenjang_sekolah, 0, 1, 'C');
			$pdf->Cell(0, 5, 'TAHUN PELAJARAN ' . $tahunpelajaran . '/' . ($tahunpelajaran + 1), 0, 1, 'C');
			$pdf->Ln(7);
			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(40, 5, 'KOTA/KABUPATEN', 0, 0, 'L');
			$pdf->Cell(5, 5, ':', 0, 0, 'L');
			$pdf->Cell(80, 5, $nama_kota, 'B', 1, 'L');
			$pdf->Cell(40, 5, 'SEKOLAH/MADRASAH', 0, 0, 'L');
			$pdf->Cell(5, 5, ':', 0, 0, 'L');
			$pdf->Cell(80, 5, $nama_sekolah, 'B', 1, 'L');

			$pdf->Cell(40, 5, 'ID SERVER/RUANG', 0, 0, 'L');
			$pdf->Cell(5, 5, ':', 0, 0, 'L');
			$pdf->Cell(80, 5, $c->ruang_server . ' / ' . $c->ruang_nama, 'B', 0, 'L');
			$pdf->Cell(5, 5, '', 0, 0, 'L');
			$pdf->Cell(20, 5, 'SESI', 0, 0, 'L');
			$pdf->Cell(5, 5, ':', 0, 0, 'L');
			$pdf->Cell(35, 5, '', 'B', 1, 'L');

			$pdf->Cell(40, 5, 'HARI', 0, 0, 'L');
			$pdf->Cell(5, 5, ':', 0, 0, 'L');
			$pdf->Cell(20, 5, '', 'B', 0, 'L');
			$pdf->Cell(2, 5, '', 0, 0, 'L');
			$pdf->Cell(20, 5, 'TANGGAL', 0, 0, 'L');
			$pdf->Cell(5, 5, ':', 0, 0, 'L');
			$pdf->Cell(33, 5, '', 'B', 0, 'L');
			$pdf->Cell(5, 5, '', 0, 0, 'L');
			$pdf->Cell(20, 5, 'PUKUL', 0, 0, 'L');
			$pdf->Cell(5, 5, ':', 0, 0, 'L');
			$pdf->Cell(35, 5, '', 'B', 1, 'L');

			$pdf->Cell(40, 5, 'MATA PELAJARAN', 0, 0, 'L');
			$pdf->Cell(5, 5, ':', 0, 0, 'L');
			$pdf->Cell(80, 5, '', 'B', 1, 'L');

			$pdf->Ln(7);
			$pdf->SetDrawColor(80, 80, 80);
			$pdf->SetFillColor(200, 200, 200);
			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(10, 8, 'No', 1, 0, 'C', 'F');
			$pdf->Cell(35, 8, 'Username', 1, 0, 'C', 'F');
			$pdf->Cell(85, 8, ' Nama Peserta', 1, 0, 'C', 'F');
			$pdf->Cell(40, 8, 'Tanda Tangan', 1, 0, 'C', 'F');
			$pdf->Cell(20, 8, 'Ket', 1, 1, 'C', 'F');

			$nomor = 1;
			foreach ($b as $load) {
				$pdf->SetDrawColor(80, 80, 80);
				$pdf->SetFillColor(100, 100, 100);
				$pdf->SetTextColor(10);
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(10, 6, $nomor, 1, 0, 'C');
				$pdf->Cell(35, 6, $load->nim, 1, 0, 'C');
				$pdf->Cell(85, 6, ' ' . $load->nama, 1, 0);
				$sisa = $nomor % 2;
				if ($sisa == 1) {
					$pdf->Cell(40, 6, $nomor . '.', 1, 0, 'L');
				} else {
					$pdf->Cell(40, 6, $nomor . '.', 1, 0, 'C');
				}
				$pdf->Cell(20, 6, '', 1, 1, 'C');
				$nomor++;
			}

			$pdf->SetFont('Arial', 'BI', 10);
			$pdf->Cell(0, 8, 'Keterangan :', 0, 1, 'L');
			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(0, 5, '1. Dibuat rangkat 2 (dua), masing-masing untuk sekolah dan kota/kab.', 0, 1, 'L');
			$pdf->Cell(0, 5, '2. Pengawas ruang menyilang Nama Peserta yang tidak hadir.', 0, 1, 'L');
			$pdf->Ln(7);
			$pdf->Cell(110, 5, '', 0, 0, 'L');
			$pdf->Cell(50, 5, 'Proktor', 0, 0, 'L');
			$pdf->Cell(50, 5, 'Pengawas', 0, 1, 'L');

			$pdf->Cell(65, 5, 'Jumlah Peserta yang Seharusnya Hadir', 'LT', 0, 'L');
			$pdf->Cell(3, 5, ':', 'T', 0, 'L');
			$pdf->Cell(8, 5, '......', 'T', 0, 'C');
			$pdf->Cell(10, 5, 'orang', 'T', 0, 'L');
			$pdf->Cell(2, 5, '', 'TR', 1, 'L');

			$pdf->Cell(65, 5, 'Jumlah Peserta yang Tidak Hadir', 'LB', 0, 'L');
			$pdf->Cell(3, 5, ':', 'B', 0, 'L');
			$pdf->Cell(8, 5, '......', 'B', 0, 'L');
			$pdf->Cell(10, 5, 'orang', 'B', 0, 'L');
			$pdf->Cell(2, 5, '', 'BR', 1, 'L');

			$pdf->Cell(65, 5, 'Jumlah Peserta Hadir', 'LB', 0, 'L');
			$pdf->Cell(3, 5, ':', 'B', 0, 'L');
			$pdf->Cell(8, 5, '......', 'B', 0, 'L');
			$pdf->Cell(10, 5, 'orang', 'B', 0, 'L');
			$pdf->Cell(2, 5, '', 'BR', 1, 'L');

			$pdf->Ln(2);
			$pdf->Cell(100, 5, '', 0, 0, 'L');
			$pdf->Cell(50, 5, 'NIP.', 0, 0, 'L');
			$pdf->Cell(50, 5, 'NIP.', 0, 1, 'L');

			$pdf->Output('I', 'Daftar Hadir Peserta - ' . $c->ruang_nama . '.pdf');
		} else {
			$a['p']	= "m_ruangan";
		}
		$this->load->view('aaa', $a);
	}
	public function m_guru()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_guru WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_guru SET nama = '" . bersih($p, "nama") . "', nip = '" . bersih($p, "nip") . "' WHERE id = '" . bersih($p, "id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_guru VALUES (null, '" . bersih($p, "nip") . "', '" . bersih($p, "nama") . "')");
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_guru WHERE id = '" . $uri4 . "'");
			$this->db->query("DELETE FROM m_admin WHERE level = 'guru' AND kon_id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "user") {
			$det_user = $this->db->query("SELECT id, nip FROM m_guru WHERE id = '$uri4'")->row();
			if (!empty($det_user)) {
				$q_cek_username = $this->db->query("SELECT id FROM m_admin WHERE username = '" . $det_user->nip . "' AND level = 'guru'")->num_rows();
				if ($q_cek_username < 1) {
					$this->db->query("INSERT INTO m_admin VALUES (null, '" . $det_user->nip . "', sha1('" . $det_user->nip . "'), 'guru', '" . $det_user->id . "')");
					$ret_arr['status'] 	= "ok";
					$ret_arr['caption']	= "tambah user sukses";
					j($ret_arr);
				} else {
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "Username telah digunakan";
					j($ret_arr);
				}
			} else {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "tambah user gagal";
				j($ret_arr);
			}
			exit();
		} else if ($uri3 == "user_reset") {
			$det_user = $this->db->query("SELECT id, nip FROM m_guru WHERE id = '$uri4'")->row();
			$this->db->query("UPDATE m_admin SET password = sha1('" . $det_user->nip . "') WHERE level = 'guru' AND kon_id = '" . $det_user->id . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "Update password sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "ambil_matkul") {
			$matkul = $this->db->query("SELECT m_mapel.*, (SELECT COUNT(id) FROM tr_guru_mapel WHERE id_guru = " . $uri4 . " AND id_mapel = m_mapel.id) AS ok FROM m_mapel ORDER BY nama ASC")->result();
			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $matkul;
			j($ret_arr);
			exit;
		} else if ($uri3 == "simpan_matkul") {
			$ket 	= "";
			//echo var_dump($p);
			$ambil_matkul = $this->db->query("SELECT id FROM m_mapel ORDER BY id ASC")->result();
			if (!empty($ambil_matkul)) {
				foreach ($ambil_matkul as $a) {
					$p_sub = "id_mapel_" . $a->id;
					if (!empty($p->$p_sub)) {
						$cek_sudah_ada = $this->db->query("SELECT id FROM tr_guru_mapel WHERE  id_guru = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'")->num_rows();
						if ($cek_sudah_ada < 1) {
							$this->db->query("INSERT INTO tr_guru_mapel VALUES (null, '" . $p->id_mhs . "', '" . $a->id . "')");
						} else {
							$this->db->query("UPDATE tr_guru_mapel SET id_mapel = '" . $p->$p_sub . "' WHERE id_guru = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'");
						}
					} else {
						$this->db->query("DELETE FROM tr_guru_mapel WHERE id_guru = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'");
					}
				}
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$d_total_row = $this->db->query("SELECT id FROM m_guru a WHERE a.nama LIKE '%" . $search['value'] . "%'")->num_rows();
			$q_datanya = $this->db->query("SELECT a.*,
											(SELECT COUNT(id) FROM m_admin WHERE level = 'guru' AND kon_id = a.id) AS ada
											FROM m_guru a
	                                        WHERE a.nama LIKE '%" . $search['value'] . "%' ORDER BY a.nama ASC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);
			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = '<center>' . $no++ . '</center>';
				$mapelGuru = $this->db->query("SELECT id_mapel, nama as nmMapel FROM tr_guru_mapel INNER JOIN m_mapel ON tr_guru_mapel.id_mapel=m_mapel.id WHERE id_guru = $d[id]")->result_array();
				$mapel = array();
				foreach ($mapelGuru as $ss) {
					$mapel[] = " " . $ss['nmMapel'];
				}
				$data_ok[3] = $mapel;
				$data_ok[1] = $d['nama'];
				$data_ok[2] = $d['nip'];
				$data_ok[4] = 	'<center><div class="btn-group mt-1 mb-1">
								<a href="#" title="Edit" onclick="return m_guru_e(' . $d['id'] . ');" class="btn btn-primary btn-xs fw-bold"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
								<a href="#" title="Hapus" onclick="return m_guru_h(' . $d['id'] . ');" class="btn btn-danger btn-xs fw-bold"><i class="fa fa-times-circle" aria-hidden="true"></i> Hapus</a>
								<a href="#" title="Pilih Mata Pelajaran" onclick="return m_guru_matkul(' . $d['id'] . ');" class="btn btn-success btn-xs fw-bold"><i class="fa fa-archive" aria-hidden="true"></i> Mapel</a>
								';
				if ($d['ada'] == "0") {
					$data_ok[4] .= '<a href="#" title="Aktifkan Guru" onclick="return m_guru_u(' . $d['id'] . ');" class="btn btn-info btn-xs fw-bold"><i class="fa fa-user-plus" aria-hidden="true"></i> Active</a>';
				} else {
					$data_ok[4] .= '<a href="#" title="Reset Password" onclick="return m_guru_ur(' . $d['id'] . ');" class="btn btn-warning btn-xs fw-bold"><i class="fa fa-lock" aria-hidden="true"></i> Reset</a>';
				}
				$data[] = $data_ok;
			}
			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "import") {
			$a['p']	= "f_guru_import";
		} else if ($uri3 == "aktifkan_semua_guru") {
			$q_get_user = $this->db->query("select 
								a.id, a.nama, a.nip, ifnull(b.username,'N') usernya
								from m_guru a 
								left join m_admin b on concat(b.level,b.kon_id) = concat('guru',a.id)")->result_array();
			$jml_aktif = 0;
			if (!empty($q_get_user)) {
				foreach ($q_get_user as $j) {
					if ($j['usernya'] == "N") {
						$this->db->query("INSERT INTO m_admin VALUES (null, '" . $j['nip'] . "', sha1('" . $j['nip'] . "'), 'guru', '" . $j['id'] . "')");
						$jml_aktif++;
					}
				}
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $jml_aktif . " user diaktifkan";
			j($ret_arr);
			exit();
		} else {
			$a['p']	= "m_guru";
		}
		$this->load->view('aaa', $a);
	}
	public function m_mapel()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['data'] = $this->db->query("SELECT m_mapel.* FROM m_mapel")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_mapel WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_mapel SET nama = '" . bersih($p, "nama") . "'
								WHERE id = '" . bersih($p, "id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_mapel VALUES (null, '" . bersih($p, "nama") . "')");
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_mapel WHERE id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$d_total_row = $this->db->query("SELECT id FROM m_mapel a WHERE a.nama LIKE '%" . $search['value'] . "%'")->num_rows();
			$q_datanya = $this->db->query("SELECT a.* FROM m_mapel a WHERE a.nama LIKE '%" . $search['value'] . "%' ORDER BY a.nama ASC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);
			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = '<center>' . $no++ . '</center>';
				$data_ok[1] = $d['nama'];
				$data_ok[2] = '<center><div class="btn-group mt-1 mb-1">
                          <a href="#" onclick="return m_mapel_e(' . $d['id'] . ');" class="btn btn-success btn-xs fw-bold"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
                          <a href="#" onclick="return m_mapel_h(' . $d['id'] . ');" class="btn btn-danger btn-xs fw-bold"><i class="fa fa-times-circle" aria-hidden="true"></i> Hapus</a>
                         ';
				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else {
			$a['p']	= "m_mapel";
		}
		$this->load->view('aaa', $a);
	}
	public function importword()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");

		if ($a['sess_level'] == "guru") {
			$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM m_guru WHERE id = '" . $a['sess_konid'] . "'")->result(), "id,nama");
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT 
											b.id, b.nama
											FROM tr_guru_mapel a
											INNER JOIN m_mapel b ON a.id_mapel = b.id
											WHERE a.id_guru = '" . $a['sess_konid'] . "'")->result(), "id,nama");
			$a['p_kelas'] = obj_to_array($this->db->query("SELECT * FROM m_kelas")->result(), "id,kelas");
		} else {
			$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM m_guru")->result(), "id,nama");
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT b.id, b.nama FROM tr_guru_mapel a INNER JOIN m_mapel b ON a.id_mapel = b.id")->result(), "id,nama");
			$a['p_kelas'] = obj_to_array($this->db->query("SELECT * FROM m_kelas")->result(), "id,kelas");
		}

		$a['p']			= "f_soal_import_word";
		$this->load->view('aaa', $a);
	}
	public function c_import()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		if ($a['sess_level'] == "guru") {
			$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM m_guru WHERE id = '" . $a['sess_konid'] . "'")->result(), "id,nama");
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT 
											b.id, b.nama
											FROM tr_guru_mapel a
											INNER JOIN m_mapel b ON a.id_mapel = b.id
											WHERE a.id_guru = '" . $a['sess_konid'] . "'")->result(), "id,nama");
			$a['p_kelas'] = obj_to_array($this->db->query("SELECT * FROM m_kelas")->result(), "id,kelas");
		} else {
			$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM m_guru")->result(), "id,nama");
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT b.id, b.nama FROM tr_guru_mapel a INNER JOIN m_mapel b ON a.id_mapel = b.id")->result(), "id,nama");
			$a['p_kelas'] = obj_to_array($this->db->query("SELECT * FROM m_kelas")->result(), "id,kelas");
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('import-soal', 'Daftar Soal', 'required');
		if ($this->form_validation->run() == TRUE) {
			$id_topik = $this->input->post('topik', true);
			$daftar_soal = $this->input->post('import-soal', false);
			$doc = new DOMDocument();
			$doc->loadHTML($daftar_soal);
			$tables = $doc->getElementsByTagName('table');
			if (!empty($tables->item(0)->nodeValue)) {
				$rows = $tables->item(0)->getElementsByTagName('tr');
				$counter = 1;
				$soal = '<table class="table table-striped table-bordered table-hover" cellspacing="0" style="width: 100%;">';
				foreach ($rows as $row) {
					/*** get each column by tag name ***/
					$cols = $row->getElementsByTagName('td');
					$kosong = 0;
					if (empty($cols->item(1)->nodeValue)) {
						$kosong++;
					}
					if (empty($cols->item(2)->nodeValue)) {
						$kosong++;
					}
					if (empty($cols->item(3)->nodeValue)) {
						$kosong++;
					}
					if ($kosong == 0) {
						$jenis = strtoupper(preg_replace('/\s+/', '', $cols->item(1)->nodeValue));
						$kunci = strtoupper(preg_replace('/\s+/', '', $cols->item(3)->nodeValue));
						$kunci = intval($kunci);
						if ($kunci > 1) {
							$kunci = 1;
						}
						if ($jenis == 'SOAL') {
							$soal = $soal . '
								<tr>
								<td valign="top"><p>' . $counter . '</p></td>
								<td colspan="2" dir="rtl" lang="ar">' . $this->innerHTML($cols->item(2)) . '</td>
								</tr>
							';
							$counter++;
						} else if ($jenis == 'JAWABAN') {
							$soal = $soal . '
									<tr>
										<td width="5%"> </td>
										<td width="5%" valign="midle" align="center">' . $kunci . '</td>
										<td width="75%">' . $this->innerHTML($cols->item(2)) . '</td>
									</tr>
								';
						}
					} else {
						// menghentikan loop ketika ada yang kosong
						break;
					}
				}
				$soal = $soal . '</table>';
				if ($counter > 1) {
					$status['topik'] = $id_topik;
					$status['soal'] = $soal;
					$status['status'] = 1;
					$status['pesan'] = '';
				} else {
					$status['status'] = 0;
					$status['pesan'] = 'Silahkan cek format soal terlebih dahulu';
				}
			} else {
				$status['status'] = 0;
				$status['pesan'] = 'Terjadi kesalahan format soal. Silahkan cek format soal terlebih dahulu';
			}
		} else {
			$status['status'] = 0;
			$status['pesan'] = validation_errors();
		}
		echo json_encode($status);
	}
	function konfirmasi()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		$a['huruf_opsi'] = array("a", "b", "c", "d", "e");
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_guru', 'Guru Mata Pelajaran', 'required');
		$this->form_validation->set_rules('id_mapel', 'Mata Pelajaran', 'required');
		$this->form_validation->set_rules('id_kelas', 'Kelas', 'required');
		$this->form_validation->set_rules('konfirmasi-import-soal', 'Daftar Soal', 'required');
		if ($this->form_validation->run() == TRUE) {
			$guru = $this->input->post('id_guru', false);
			$mapel = $this->input->post('id_mapel', false);
			$kelas = $this->input->post('id_kelas', false);
			$daftar_soal = $this->input->post('konfirmasi-import-soal', false);
			$doc = new DOMDocument();
			$doc->loadHTML($daftar_soal);
			$tables = $doc->getElementsByTagName('table');
			if (!empty($tables->item(0)->nodeValue)) {
				$rows = $tables->item(0)->getElementsByTagName('tr');
				$counter_soal = 0;
				$counter_jawaban = 0;
				$soal_id = 0;
				$opsi = 0;
				foreach ($rows as $row) {
					/*** get each column by tag name ***/
					$cols = $row->getElementsByTagName('td');
					$kosong = 0;
					if (empty($cols->item(1)->nodeValue)) {
						$kosong++;
					}
					if (empty($cols->item(2)->nodeValue)) {
						$kosong++;
					}
					if (empty($cols->item(3)->nodeValue)) {
						$kosong++;
					}
					if ($opsi >= 5) {
						$opsi = 0;
					}
					if ($kosong == 0) {
						$jenis = strtoupper(preg_replace('/\s+/', '', $cols->item(1)->nodeValue));
						$kunci = strtoupper(preg_replace('/\s+/', '', $cols->item(3)->nodeValue));
						$kunci = intval($kunci);
						if ($kunci > 1) {
							$kunci = 1;
						}
						if ($jenis == 'SOAL') {
							$soal = $this->innerHTML($cols->item(2));
							$soal = str_replace(base_url(), "[base_url]", $soal);
							$bobot = strtoupper(preg_replace('/\s+/', '', $cols->item(3)->nodeValue));
							$bobot = intval($bobot);
							$pdata = array(
								"id_guru" 		=> $guru,
								"id_mapel" 		=> $mapel,
								"id_kelas" 		=> $kelas,
								"bobot" 		=> $bobot,
								"jenis_soal" 	=> 'multiple',
								"soal" 			=> $soal,
								"tgl_input" 	=> date('Y-m-d H:i:s'),
							);
							$soal_id = $this->db->insert("m_soal", $pdata);
							$soal_id = $this->db->insert_id();
							$counter_soal++;
						} else if ($jenis == 'JAWABAN') {
							if ($soal_id != 0) {
								$jopsi = $a['huruf_opsi'][$opsi];
								$jawaban = $this->innerHTML($cols->item(2));
								$jawaban = str_replace(base_url(), "[base_url]", $jawaban);
								if ($kunci == 1) {
									$data['jawaban'] = strtoupper($a['huruf_opsi'][$opsi]);
								}
								$data['opsi_' . $jopsi] = '#####' . $jawaban;
								$this->db->where("id", $soal_id);
								$this->db->update("m_soal", $data);
								$counter_jawaban++;
								$opsi++;
							}
						}
					} else {
						// menghentikan loop ketika ada yang kosong
						break;
					}
				}
				$soal = $soal . '</table>';
				if ($counter_soal > 0) {
					$status['counter_soal'] = $counter_soal;
					$status['counter_jawaban'] = $counter_jawaban;
					$status['status'] = 1;
					$status['pesan'] = 'Daftar soal berhasil diimport';
				} else {
					$status['status'] = 0;
					$status['pesan'] = 'Silahkan cek format soal terlebih dahulu';
				}
			} else {
				$status['status'] = 0;
				$status['pesan'] = 'Terjadi kesalahan format soal. Silahkan cek format soal terlebih dahulu';
			}
		} else {
			$status['status'] = 0;
			$status['pesan'] = validation_errors();
		}
		$a = json_encode($status);
		$info = json_decode($a);
		$this->session->set_flashdata('k', '<div class="card-body"><div class="alert alert-info">' . $info->pesan . '<br>Berhasil: ' . $info->counter_soal . ' Soal</div></div>');
		redirect('adm/m_soal');
	}
	public function innerHTML(DOMNode $n, $include_target_tag = false)
	{
		$doc = new DOMDocument();
		$doc->appendChild($doc->importNode($n, true));
		$html = trim($doc->saveHTML());
		if ($include_target_tag) {
			return $html;
		}
		return preg_replace('@^<' . $n->nodeName . '[^>]*>|</' . $n->nodeName . '>$@', '', $html);
	}
	/* == GURU == */
	public function m_soal()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		$a['huruf_opsi'] = array("a", "b", "c", "d", "e");
		$a['jenis_soal'] = array("multiple", "quick", "essay");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		if ($a['sess_level'] == "guru") {
			$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM m_guru WHERE id = '" . $a['sess_konid'] . "'")->result(), "id,nama");
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT 
											b.id, b.nama
											FROM tr_guru_mapel a
											INNER JOIN m_mapel b ON a.id_mapel = b.id
											WHERE a.id_guru = '" . $a['sess_konid'] . "'")->result(), "id,nama");
			$a['p_kelas'] = obj_to_array($this->db->query("SELECT * FROM m_kelas")->result(), "id,kelas");
		} else {
			$a['p_guru'] = obj_to_array($this->db->query("SELECT * FROM m_guru")->result(), "id,nama");
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT b.id, b.nama FROM tr_guru_mapel a INNER JOIN m_mapel b ON a.id_mapel = b.id")->result(), "id,nama");
			$a['p_kelas'] = obj_to_array($this->db->query("SELECT * FROM m_kelas")->result(), "id,kelas");
		}
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_soal WHERE id = '$uri4' ORDER BY id DESC")->row();
			j($a);
			exit();
		} else if ($uri3 == "import") {
			$a['p']	= "f_soal_import";
		} else if ($uri3 == "hapus_gambar") {
			$nama_gambar = $this->db->query("SELECT file FROM m_soal WHERE id = '" . $uri5 . "'")->row();
			$this->db->query("UPDATE m_soal SET file = '', tipe_file = '' WHERE id = '" . $uri5 . "'");
			@unlink("./upload/gambar_soal/" . $nama_gambar->file);
			redirect('adm/m_soal/pilih_mapel/' . $uri4);
		} else if ($uri3 == "hapussemua") {
			$this->db->query("TRUNCATE TABLE m_soal");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "pilih_mapel") {
			if ($a['sess_level'] == "guru") {
				$a['data'] = $this->db->query("SELECT m_soal.*, m_guru.nama AS nama_guru FROM m_soal INNER JOIN m_guru ON m_soal.id_guru = m_guru.id WHERE m_soal.id_guru = '" . $a['sess_konid'] . "' AND m_soal.id_mapel = '$uri4' ORDER BY id DESC")->result();
			} else {
				$a['data'] = $this->db->query("SELECT m_soal.*, m_guru.nama AS nama_guru FROM m_soal INNER JOIN m_guru ON m_soal.id_guru = m_guru.id WHERE m_soal.id_mapel = '$uri4' ORDER BY id DESC")->result();
			}
			//echo $this->db->last_query();
			$a['p']	= "m_soal";
		} else if ($uri3 == "simpan") {
			$p = $this->input->post();
			$pembuat_soal = ($a['sess_level'] == "admin") ? $p['id_guru'] : $a['sess_konid'];
			$pembuat_soal_u = ($a['sess_level'] == "admin") ? ", id_guru = '" . $p['id_guru'] . "'" : "";
			//etok2nya config
			$folder_gb_soal = "./upload/gambar_soal/";
			$folder_gb_opsi = "./upload/gambar_opsi/";
			$buat_folder_gb_soal = !is_dir($folder_gb_soal) ? @mkdir("./upload/gambar_soal/") : false;
			$buat_folder_gb_opsi = !is_dir($folder_gb_opsi) ? @mkdir("./upload/gambar_opsi/") : false;
			$allowed_type 	= array(
				"image/jpeg", "image/png", "image/gif",
				"audio/mpeg", "audio/mpg", "audio/mpeg3", "audio/mp3", "audio/x-wav", "audio/wave", "audio/wav",
				"video/mp4", "application/octet-stream"
			);
			$gagal 		= array();
			$nama_file 	= array();
			$tipe_file 	= array();
			//get mode
			$__mode = $p['mode'];
			$__id_soal = 0;
			//ambil data post sementara
			$jawabansoal = $p['jenisSoal'] == 'multiple' ? $p['jawaban'] : $p['jwbQa'];
			$pdata = array(
				"id_guru" => $p['id_guru'],
				"id_mapel" => $p['id_mapel'],
				"id_kelas" => $p['id_kelas'],
				"bobot" => $p['bobot'],
				"jenis_soal" => $p['jenisSoal'],
				"soal" => $p['soal'],
				"jawaban" => addslashes($jawabansoal),
				"tgl_input" => date('Y-m-d H:i:s'),

			);
			if ($__mode == "edit") {
				$this->db->where("id", $p['id']);
				$this->db->update("m_soal", $pdata);
				$__id_soal = $p['id'];
			} else {
				$this->db->insert("m_soal", $pdata);
				$get_id_akhir = $this->db->query("SELECT MAX(id) maks FROM m_soal LIMIT 1")->row_array();
				$__id_soal = $get_id_akhir['maks'];
			}
			//mulai dari sini id soal diambil dari variabel $__id
			//lakukan perulangan sejumlah file upload yang terdeteksi
			foreach ($_FILES as $k => $v) {
				//var file upload
				//$k = nama field di form
				$file_name 		= $_FILES[$k]['name'];
				$file_type		= $_FILES[$k]['type'];
				$file_tmp		= $_FILES[$k]['tmp_name'];
				$file_error		= $_FILES[$k]['error'];
				$file_size		= $_FILES[$k]['size'];
				//kode ref file upload jika error
				$kode_file_error = array("File berhasil diupload", "Ukuran file terlalu besar", "Ukuran file terlalu besar", "File upload error", "Tidak ada file yang diupload", "File upload error");
				//jika file error = 0 / tidak ada, tipe file ada di file yang diperbolehkan, dan nama file != kosong
				if ($file_error != 0) {
					$gagal[$k] = $kode_file_error[$file_error];
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else if (!in_array($file_type, $allowed_type)) {
					$gagal[$k] = "Tipe file ini tidak diperbolehkan!";
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else if ($file_name == "") {
					$gagal[$k] = "Tidak ada file yang diupload";
					$nama_file[$k]	= "";
					$tipe_file[$k]	= "";
				} else {
					$ekstensi = explode(".", $file_name);
					$file_name = $k . "_" . $__id_soal . "." . $ekstensi[1];
					if ($k == "gambar_soal") {
						@move_uploaded_file($file_tmp, $folder_gb_soal . $file_name);
					} else {
						@move_uploaded_file($file_tmp, $folder_gb_opsi . $file_name);
					}
					$gagal[$k]	 	= $kode_file_error[$file_error]; //kode kegagalan upload file
					$nama_file[$k]	= $file_name; //ambil nama file
					$tipe_file[$k]	= $file_type; //ambil tipe file
				}
			}
			//ambil data awal
			$get_opsi_awal = $this->db->query("SELECT opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal WHERE id = '" . $__id_soal . "'")->row_array();
			$data_simpan = array();
			if (!empty($nama_file['gambar_soal'])) {
				$data_simpan = array(
					"file" => $nama_file['gambar_soal'],
					"tipe_file" => $tipe_file['gambar_soal'],
				);
			}
			for ($t = 0; $t < $a['aplikasi']['ujian_opsi']; $t++) {
				$idx 	= "opsi_" . $a['huruf_opsi'][$t];
				$idx2 	= "gj" . $a['huruf_opsi'][$t];
				//jika file kosong
				$pc_opsi_awal = explode("#####", $get_opsi_awal[$idx]);
				$nama_file_opsi = empty($nama_file[$idx2]) ? $pc_opsi_awal[0] : $nama_file[$idx2];
				$data_simpan[$idx] = $nama_file_opsi . "#####" . $p[$idx];
			}
			$this->db->where("id", $__id_soal);
			$this->db->update("m_soal", $data_simpan);
			$teks_gagal = "";
			foreach ($gagal as $k => $v) {
				$arr_nama_file_upload = array("gambar_soal" => "File Soal ", "gja" => "File opsi A ", "gjb" => "File opsi B ", "gjc" => "File opsi C ", "gjd" => "File opsi D ", "gje" => "File opsi E ");
				$teks_gagal .= $arr_nama_file_upload[$k] . ': ' . $v . '<br>';
			}
			$this->session->set_flashdata('k', '<div class="alert alert-info">' . $teks_gagal . '</div>');
			redirect('adm/m_soal/pilih_mapel/' . $p['id_mapel']);
		} else if ($uri3 == "edit") {
			$a['opsij'] = array("" => "Jawaban", "A" => "A", "B" => "B", "C" => "C", "D" => "D", "E" => "E");
			$a['jenisSoal'] = array("" => "--Pilih Jenis Soal--", "multiple" => "Multiple", "quick" => "Quick Answer");
			$id_guru = $this->session->userdata('admin_level') == "guru" ? "WHERE a.id_guru = '" . $a['sess_konid'] . "'" : "";
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT b.id, b.nama FROM tr_guru_mapel a INNER JOIN m_mapel b ON a.id_mapel = b.id $id_guru ORDER BY nama ASC")->result(), "id,nama");
			$a['p_kelas'] = obj_to_array($this->db->query("SELECT * FROM m_kelas ORDER BY kelas ASC")->result(), "id,kelas");
			if ($uri4 == 0) {
				$a['d'] = array("mode" => "add", "id" => "0", "id_guru" => $id_guru, "id_mapel" => "", "id_kelas" => "", "bobot" => "1", "file" => "", "soal" => "", "opsi_a" => "#####", "opsi_b" => "#####", "opsi_c" => "#####", "opsi_d" => "#####", "opsi_e" => "#####", "jawaban" => "", "tgl_input" => "");
			} else {
				$a['d'] = $this->db->query("SELECT m_soal.*, 'edit' AS mode FROM m_soal WHERE id = '$uri4'")->row_array();
			}
			$data = array();
			for ($e = 0; $e < $a['aplikasi']['ujian_opsi']; $e++) {
				$iidata = array();
				$idx = "opsi_" . $a['huruf_opsi'][$e];
				$idx2 = $a['huruf_opsi'][$e];
				$pc_opsi_edit = explode("#####", $a['d'][$idx]);
				$iidata['opsi'] = $pc_opsi_edit[1];
				$iidata['gambar'] = $pc_opsi_edit[0];
				$data[$idx2] = $iidata;
			}
			$a['data_pc'] = $data;
			$a['p'] = "f_soal";
		} else if ($uri3 == "hapus") {
			$nama_gambar = $this->db->query("SELECT id_mapel, file, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal WHERE id = '" . $uri4 . "'")->row();
			$pc_opsi_a = explode("#####", $nama_gambar->opsi_a);
			$pc_opsi_b = explode("#####", $nama_gambar->opsi_b);
			$pc_opsi_c = explode("#####", $nama_gambar->opsi_c);
			$pc_opsi_d = explode("#####", $nama_gambar->opsi_d);
			$pc_opsi_e = explode("#####", $nama_gambar->opsi_e);
			$this->db->query("DELETE FROM m_soal WHERE id = '" . $uri4 . "'");
			@unlink("./upload/gambar_soal/" . $nama_gambar->file);
			@unlink("./upload/gambar_soal/" . $pc_opsi_a[0]);
			@unlink("./upload/gambar_soal/" . $pc_opsi_b[0]);
			@unlink("./upload/gambar_soal/" . $pc_opsi_c[0]);
			@unlink("./upload/gambar_soal/" . $pc_opsi_d[0]);
			@unlink("./upload/gambar_soal/" . $pc_opsi_e[0]);
			redirect('adm/m_soal/pilih_mapel/' . $nama_gambar->id_mapel);
		} else if ($uri3 == "cetak") {
			$html = "<link href='" . base_url() . "___/css/style_print.css' rel='stylesheet' media='' type='text/css'/>";
			if ($a['sess_level'] == "admin") {
				$data = $this->db->query("SELECT * FROM m_soal")->result();
			} else {
				$data = $this->db->query("SELECT * FROM m_soal WHERE id_guru = '" . $a['sess_konid'] . "'")->result();
			}
			$mapel = $this->db->query("SELECT nama FROM m_mapel WHERE id = '" . $uri4 . "'")->row();
			if (!empty($data)) {
				$no = 1;
				$jawaban = array("A", "B", "C", "D", "E");
				foreach ($data as $d) {
					$arr_tipe_media = array(
						"" => "none", "image/jpeg" => "gambar", "image/png" => "gambar", "image/gif" => "gambar",
						"audio/mpeg" => "audio", "audio/mpg" => "audio", "audio/mpeg3" => "audio", "audio/mp3" => "audio", "audio/x-wav" => "audio", "audio/wave" => "audio", "audio/wav" => "audio",
						"video/mp4" => "video", "application/octet-stream" => "video"
					);
					$tipe_media = $arr_tipe_media[$d->tipe_file];
					$file_ada = file_exists("./upload/gambar_soal/" . $d->file) ? "ada" : "tidak_ada";
					$tampil_media = "";
					if ($file_ada == "ada" && $tipe_media == "audio") {
						$tampil_media = '<<< Ada media Audionya >>>';
					} else if ($file_ada == "ada" && $tipe_media == "video") {
						$tampil_media = '<<< Ada media Videonya >>>';
					} else if ($file_ada == "ada" && $tipe_media == "gambar") {
						$tampil_media = '<p><img src="' . base_url() . 'upload/gambar_soal/' . $d->file . '" class="thumbnail" style="width: 300px; height: 280px; display: inline; float: left"></p>';
					} else {
						$tampil_media = '';
					}
					$html .= '<table>
	                <tr><td>' . $no . '.</td><td colspan="2">' . $d->soal . '<br>' . $tampil_media . '</td></tr>';
					for ($j = 0; $j < $a['aplikasi']['ujian_opsi']; $j++) {
						$opsi = "opsi_" . strtolower($jawaban[$j]);
						$pc_pilihan_opsi = explode("#####", $d->$opsi);
						$tampil_media_opsi = (file_exists('./upload/gambar_soal/' . $pc_pilihan_opsi[0]) and $pc_pilihan_opsi[0] != "") ? '<img src="' . base_url() . 'upload/gambar_soal/' . $pc_pilihan_opsi[0] . '" style="width: 100px; height: 100px; margin-right: 20px">' : '';
						if ($jawaban[$j] == $d->jawaban) {
							$html .= '<tr><td width="2%" style="font-weight: bold">' . $jawaban[$j] . '</td><td style="font-weight: bold">' . $tampil_media_opsi . $pc_pilihan_opsi[1] . '</td></label></tr>';
						} else {
							$html .= '<tr><td width="2%">' . $jawaban[$j] . '</td><td>' . $tampil_media_opsi . $pc_pilihan_opsi[1] . '</td></label></tr>';
						}
					}
					$html .= '</table></div>';
					$no++;
				}
			}
			echo $html;
			exit;
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$wh = '';
			if ($a['sess_level'] == "guru") {
				$wh = "a.id_guru = '" . $a['sess_konid'] . "' AND ";
			} else if ($a['sess_level'] == "admin") {
				$wh = "";
			}
			$d_total_row = $this->db->query("SELECT a.*
												FROM m_soal a
												INNER JOIN m_guru b ON a.id_guru = b.id
												INNER JOIN m_mapel c ON a.id_mapel = c.id
												INNER JOIN m_kelas d ON a.id_kelas = d.id
		                                        WHERE " . $wh . " (a.soal LIKE '%" . $search['value'] . "%' 
												OR b.nama LIKE '%" . $search['value'] . "%' 
												OR c.nama LIKE '%" . $search['value'] . "%' 
												OR d.kelas LIKE '%" . $search['value'] . "%')")->num_rows();
			$q_datanya = $this->db->query("SELECT a.*, b.nama nmguru, c.nama nmmapel, d.kelas nmkelas
												FROM m_soal a
												INNER JOIN m_guru b ON a.id_guru = b.id
												INNER JOIN m_mapel c ON a.id_mapel = c.id
												INNER JOIN m_kelas d ON a.id_kelas = d.id
		                                        WHERE " . $wh . " (a.soal LIKE '%" . $search['value'] . "%' 
												OR b.nama LIKE '%" . $search['value'] . "%' 
												OR c.nama LIKE '%" . $search['value'] . "%' 
												OR d.kelas LIKE '%" . $search['value'] . "%')
		                                        ORDER BY a.id DESC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);
			foreach ($q_datanya as $d) {
				$jml_benar = empty($d['jml_benar']) ? 0 : intval($d['jml_benar']);
				$jml_salah = empty($d['jml_salah']) ? 0 : intval($d['jml_salah']);
				$total = ($jml_benar + $jml_salah);
				$persen_benar = $total > 0 ? (($jml_benar / $total) * 100) : 0;
				$data_ok = array();
				$data_ok[0] = '<center>' . $no++ . '</center>';
				// $data_ok[1] = '<center><input type="checkbox" id="pilih_soal" name="pilih_soal[]" value="' . $d['id'] . '"></center>';
				$data_ok[1] = '<span class="badge badge-info">' . $d['jenis_soal'] . '</span>';
				$data_ok[2] = htmlentities(substr($d['soal'], 0, 100), ENT_QUOTES) . ' ...';
				$data_ok[3] = '<center>' . $d['nmkelas'] . '</center>';
				$data_ok[4] = $d['nmmapel'];
				$data_ok[5] = $d['nmguru'];
				// $data_ok[6] = '<span class="badge badge-warning mt-1">' . $d['jenis_soal'] . '</span>
				// <span class="badge badge-warning mt-1">dipakai: ' . $total . '</span><br>
				// <span class="badge badge-success mt-1">benar: ' . $jml_benar . '</span>
				// <span class="badge badge-danger mt-1">salah: ' . $jml_salah . '</span><br>
				// <span class="badge badge-primary mt-1 mb-1">persentasi benar: ' . number_format($persen_benar, 1, '.', '') . '%</span><br>';
				$data_ok[6] = '<center><div class="btn-group mt-1 mb-1">
				  <a href="' . base_url() . 'adm/m_soal/edit/' . $d['id'] . '" class="btn btn-success btn-xs fw-bold"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a>
				  <a href="' . base_url() . 'adm/m_soal/hapus/' . $d['id'] . '" class="btn btn-danger btn-xs fw-bold"><i class="fa fa-times-circle" aria-hidden="true"></i> Hapus</a>
				 ';
				$data[] = $data_ok;
			}
			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else {
			$a['p']	= "m_soal";
		}
		$this->load->view('aaa', $a);
	}
	public function m_ujian()
	{
		$this->cek_aktif();
		cek_hakakses(array("guru", "admin"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$wh_1 = $a['sess_level'] == "admin" ? "" : " AND a.id_guru = '" . $a['sess_konid'] . "'";
		$a['pola_tes'] = array("" => "-- Pilih Acak Soal --", "acak" => "Random/Acak", "set" => "In Order/Urut");
		$a['jurusan'] = $this->db->query("SELECT * FROM m_jurusan WHERE id ORDER BY jurusan ASC")->result();
		$a['kelas'] = $this->db->query("SELECT * FROM m_kelas WHERE id")->result();
		if ($a['sess_level'] == "guru") {
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT 
			b.id, b.nama
			FROM tr_guru_mapel a
			INNER JOIN m_mapel b ON a.id_mapel = b.id
			WHERE a.id_guru = '" . $a['sess_konid'] . "'")->result(), "id,nama");
		} else {
			$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM m_mapel WHERE id ORDER BY nama ASC")->result(), "id,nama");
		}
		if ($uri3 == "det") {
			$are = array();
			$a = $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '$uri4'")->row();
			if (!empty($a)) {
				$pc_waktu = explode(" ", $a->tgl_mulai);
				$pc_tgl = explode("-", $pc_waktu[0]);
				$pc_terlambat = explode(" ", $a->terlambat);
				$are['id'] = $a->id;
				$are['id_guru'] = $a->id_guru;
				$are['id_mapel'] = $a->id_mapel;
				$are['nama_ujian'] = $a->nama_ujian;
				$are['jumlah_soal'] = $a->jumlah_soal;
				$are['kelas'] = $a->kelas;
				$are['jurusan'] = $a->jurusan;
				$are['waktu'] = $a->waktu;
				$are['waktu_submit'] = $a->waktu_submit;
				$are['terlambat'] = $pc_terlambat[0];
				$are['terlambat2'] = substr($pc_terlambat[1], 0, 5);
				$are['jenis'] = $a->jenis;
				$are['detil_jenis'] = $a->detil_jenis;
				$are['tgl_mulai'] = $pc_waktu[0];
				$are['wkt_mulai'] = substr($pc_waktu[1], 0, 5);
				$are['token'] = $a->token;
			} else {
				$are['id'] = "";
				$are['id_guru'] = "";
				$are['id_mapel'] = "";
				$are['nama_ujian'] = "";
				$are['jumlah_soal'] = "";
				$are['kelas'] = "";
				$are['jurusan'] = "";
				$are['waktu'] = "";
				$are['terlambat'] = "";
				$are['terlambat2'] = "";
				$are['jenis'] = "";
				$are['detil_jenis'] = "";
				$are['tgl_mulai'] = "";
				$are['wkt_mulai'] = "";
				$are['token'] = "";
			}
			j($are);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			$ambil_data = $this->db->query("SELECT id FROM m_soal WHERE id_mapel = '" . bersih($p, "mapel") . "' AND id_guru = '" . $a['sess_konid'] . "'")->num_rows();
			$jml_soal_diminta = intval(bersih($p, "jumlah_soal"));
			if ($ambil_data < $jml_soal_diminta) {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "Jumlah soal melebihi yang tersedia di database, jumlah soal adalah " . $ambil_data;
			} else {
				if ($p->id != 0) {
					$this->db->query("UPDATE tr_guru_tes SET 
						id_mapel = '" . bersih($p, "mapel") . "', 
						nama_ujian = '" . bersih($p, "nama_ujian") . "',
						jumlah_soal = '" . bersih($p, "jumlah_soal") . "', 
						kelas = '" . bersih($p, "kelas") . "',
						jurusan = '" . bersih($p, "jurusan") . "',
						waktu = '" . bersih($p, "waktu") . "', 
						waktu_submit = '" . bersih($p, "waktu_submit") . "', 
						terlambat = '" . bersih($p, "terlambat") . " " . bersih($p, "terlambat2") . "', 
						tgl_mulai = '" . bersih($p, "tgl_mulai") . " " . bersih($p, "wkt_mulai") . "', 
						jenis = '" . bersih($p, "acak") . "'
						WHERE id = '" . bersih($p, "id") . "'");
					$ket = "edit";
				} else {
					$ket = "tambah";
					$token = strtoupper(random_string('alpha', 5));
					$karakter = '123456789';
					$shuffle  = str_shuffle($karakter);
					$this->db->query("INSERT INTO tr_guru_tes VALUES (
						'$shuffle', 
						'" . $a['sess_konid'] . "', 
						'" . bersih($p, "mapel") . "',
						'" . bersih($p, "nama_ujian") . "', 
						'" . bersih($p, "jumlah_soal") . "', 
						'" . bersih($p, "kelas") . "',
						'" . bersih($p, "jurusan") . "',
						'" . bersih($p, "waktu") . "', 
						'" . bersih($p, "waktu_submit") . "', 
						'" . bersih($p, "acak") . "', 
						'', 
						'" . bersih($p, "tgl_mulai") . " " . bersih($p, "wkt_mulai") . "', 
						'" . bersih($p, "terlambat") . " " . bersih($p, "terlambat2") . "', 
						'$token')");
				}
				$ret_arr['status'] 	= "ok";
				$ret_arr['caption']	= $ket . " sukses";
			}
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM tr_guru_tes WHERE id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$d_total_row = $this->db->query("SELECT a.id FROM tr_guru_tes a
			INNER JOIN m_mapel b ON a.id_mapel = b.id 
			INNER JOIN m_guru c ON a.id_guru = c.id
			WHERE (a.nama_ujian LIKE '%" . $search['value'] . "%' OR b.nama LIKE '%" . $search['value'] . "%' OR c.nama LIKE '%" . $search['value'] . "%') " . $wh_1 . "")->num_rows();
			$q_datanya = $this->db->query("SELECT a.*, b.nama AS mapel, c.nama AS nama_guru FROM tr_guru_tes a
			INNER JOIN m_mapel b ON a.id_mapel = b.id 
			INNER JOIN m_guru c ON a.id_guru = c.id
			WHERE (a.nama_ujian LIKE '%" . $search['value'] . "%' OR b.nama LIKE '%" . $search['value'] . "%' OR c.nama LIKE '%" . $search['value'] . "%') " . $wh_1 . " ORDER BY b.nama ASC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);
			foreach ($q_datanya as $d) {
				$jenis_soal = $d['jenis'] == "acak" ? "Random" : "In Order";
				$data_ok = array();
				$data_ok[0] = '<center>' . $no++ . '</center>';
				$data_ok[1] = '<b>' . $d['nama_ujian'] . '</b><br>' . $d['mapel'];
				$data_ok[2] = '<span class="badge badge-info mt-1 fw-bold">' . $d['jumlah_soal'] . ' Soal</span><br><span class="badge badge-success mt-1 fw-bold">' . $d['waktu'] . ' Menit</span><br><span class="badge badge-warning mt-1 mb-1 fw-bold">' . $jenis_soal . '</span>';
				$data_ok[3] = '<center>' . $d['kelas'] . " " . $d['jurusan'] . '</center>';
				$data_ok[4] = '<center><i class="fas fa-calendar-alt"></i> ' . tjs($d['tgl_mulai'], "s") . '<br><i class="fas fa-calendar-check"></i> ' . tjs($d['terlambat'], "s") . '</center>';
				$data_ok[5] = '<center><span class="badge badge-secondary mt-1 fw-bold"><i class="fas fa-key"></i>&nbsp;&nbsp; ' . $d['token'] . '</span></center>';
				$data_ok[6] = '<div class="btn-group mt-1 mb-1">
						  <a href="#" onclick="return refresh_token(' . $d['id'] . ');" class="btn btn-warning btn-xs fw-bold"><i class="fa fa-refresh"></i> Token</a>
						  <a href="' . base_url() . 'adm/m_ujian/berita_acara/' . $d['id'] . '" class="btn btn-info btn-xs fw-bold" target="_blank"><i class="fa fa-print"></i> Berita Acara</a>
						  </div></br>
						  <div class="btn-group mt-1 mb-1">
                          <a href="#" onclick="return m_ujian_e(' . $d['id'] . ');" class="btn btn-success btn-xs fw-bold"><i class="fa fa-pencil-square"></i> Edit</a>
                          <a href="#" onclick="return m_ujian_h(' . $d['id'] . ');" class="btn btn-danger btn-xs fw-bold"><i class="fa fa-times-circle"></i> Hapus</a> 
                          <a href="' . base_url() . 'adm/h_ujian/det/' . $d['id'] . '" class="btn btn-primary btn-xs fw-bold"><i class="fa fa-eye"></i> lihat</a></div>';
				$data[] = $data_ok;
			}
			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "refresh_token") {
			$token = strtoupper(random_string('alpha', 5));
			$this->db->query("UPDATE tr_guru_tes SET token = '$token' WHERE id = '$uri4'");
			$ret_arr['status'] = "ok";
			j($ret_arr);
			exit();
		} else if ($uri3 == "berita_acara") {
			if ($uri4 != '') {
				$b = $this->db->query("SELECT m_mapel.nama AS namaMapel, m_guru.nama AS nama_guru, tr_guru_tes.* FROM tr_guru_tes INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id WHERE tr_guru_tes.id = '" . $uri4 . "'")->row();

				$nama_sekolah = $a['lembaga']['lembaga_profile'];
				$jenjang_sekolah = $a['lembaga']['lembaga_jenjang'];
				$tahunpelajaran = $a['lembaga']['lembaga_tahun'];
				$nama_ujian = $a['aplikasi']['ujian_nama'];
				$tgl_ujian = $a['aplikasi']['ujian_tanggal'];
				$nama_kepala = $a['lembaga']['lembaga_pimpinan'];
				$nip_kepala = $a['lembaga']['lembaga_pimpinan_nip'];

				$pdf = new FPDF('P', 'mm', 'A4');
				$pdf->AddPage();
				$pdf->AliasNbPages();
				$pdf->SetTitle('Berita Acara - ' . $b->namaMapel, true);
				$pdf->SetFont('Arial', '', 7);
				// logo
				$pdf->Image('upload/gambar_lembaga/' . $a['lembaga']['lembaga_foto'], 95, 10, 20);
				$pdf->Ln(25);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(0, 5, 'BERITA ACARA PELAKSANAAN', 0, 1, 'C');
				$pdf->Cell(0, 5, $nama_ujian . ' ' . $jenjang_sekolah, 0, 1, 'C');
				$pdf->Cell(0, 5, 'TAHUN PELAJARAN ' . $tahunpelajaran . '/' . ($tahunpelajaran + 1), 0, 1, 'C');

				$pdf->Ln(5);
				$pdf->SetFont('Arial', '', 10);
				$pdf->MultiCell(0, 5, 'Pada hari ini ' . hariIndo(date('D', strtotime($b->tgl_mulai))) . ' tanggal ' . date('d', strtotime($b->tgl_mulai)) . ' bulan ' . bulanIndo(date('M', strtotime($b->tgl_mulai))) . ' tahun ' . date('Y', strtotime($b->tgl_mulai)) . ', di ' . $nama_sekolah . ' telah diselenggarakan ' . ucwords(strtolower($nama_ujian)) . ', untuk Mata Pelajaran ' . $b->namaMapel . ' dari pukul ' . date('H:i', strtotime($b->tgl_mulai)) . ' sampai dengan pukul ' . date('H:i', strtotime($b->terlambat)) . '', 0, 1);
				$pdf->Ln(5);
				$pdf->Cell(10, 6, '1. ', 0, 0, 'L');
				$pdf->Cell(50, 5, 'Nama Ujian', 0, 0, 'L');
				$pdf->Cell(5, 5, ':', 0, 0, 'L');
				$pdf->Cell(125, 5, $b->nama_ujian, 'B', 1, 'L');

				$pdf->Ln(1);
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(50, 5, 'Sekolah/Madrasah', 0, 0, 'L');
				$pdf->Cell(5, 5, ':', 0, 0, 'L');
				$pdf->Cell(125, 5, $nama_sekolah . '', 'B', 1, 'L');

				$pdf->Ln(1);
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(50, 5, 'Kelas/Ruang', 0, 0, 'L');
				$pdf->Cell(5, 5, ':', 0, 0, 'L');
				$pdf->Cell(125, 5, $b->kelas . ' ' . $b->jurusan . '/ ....................', 'B', 1, 'L');

				$pdf->Ln(1);
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(50, 5, 'Jumlah Peserta Seharusnya', 0, 0, 'L');
				$pdf->Cell(5, 5, ':', 0, 0, 'L');
				$pdf->Cell(40, 5, '', 'B', 1, 'L');

				$pdf->Ln(1);
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(50, 5, 'Jumlah Hadir (Ikut Ujian)', 0, 0, 'L');
				$pdf->Cell(5, 5, ':', 0, 0, 'L');
				$pdf->Cell(40, 5, '', 'B', 1, 'L');

				$pdf->Ln(1);
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(50, 5, 'Jumlah Tidak Hadir', 0, 0, 'L');
				$pdf->Cell(5, 5, ':', 0, 0, 'L');
				$pdf->Cell(40, 5, '', 'B', 1, 'L');

				$pdf->Ln(1);
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(50, 5, 'Nomor Peserta Tidak Hadir', 0, 0, 'L');
				$pdf->Cell(5, 5, ':', 0, 0, 'L');
				$pdf->Cell(125, 5, '', 'B', 1, 'L');

				$pdf->Ln(1);
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(50, 5, '', 0, 0, 'L');
				$pdf->Cell(5, 5, '', 0, 0, 'L');
				$pdf->Cell(125, 5, '', 'B', 1, 'L');

				$pdf->Ln(5);
				$pdf->Cell(10, 6, '2. ', 0, 0, 'L');
				$pdf->Cell(180, 5, 'Catatan selama ' . ucwords(strtolower($nama_ujian)), 0, 1, 'L');
				$pdf->Ln(1);
				$pdf->Cell(10, 6, '', 0, 0, 'L');
				$pdf->MultiCell(0, 35, '', 1, 1);

				$pdf->Ln(5);
				$pdf->Cell(0, 5, 'Yang membuat berita acara : ', 0, 0, 'L');

				$pdf->Ln(10);
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(30, 5, '', 0, 0, 'L');
				$pdf->Cell(50, 5, '', 0, 0, 'L');
				$pdf->Cell(10, 5, '', 0, 0, 'R');
				$pdf->Cell(50, 5, 'TTD', '', 1, 'C');

				$pdf->Ln(5);
				$pdf->Cell(10, 5, '1. ', 0, 0, 'L');
				$pdf->Cell(30, 5, 'Proktor', 0, 0, 'L');
				$pdf->Cell(50, 5, '....................', 'B', 0, 'L');
				$pdf->Cell(10, 5, '1. ', 0, 0, 'R');
				$pdf->Cell(50, 5, '', 'B', 1, 'L');
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(30, 5, 'NIP.', 0, 0, 'L');
				$pdf->Cell(50, 5, '', 'B', 1, 'L');

				$pdf->Ln(5);
				$pdf->Cell(10, 5, '2. ', 0, 0, 'L');
				$pdf->Cell(30, 5, 'Pengawas', 0, 0, 'L');
				$pdf->Cell(50, 5, '....................', 'B', 0, 'L');
				$pdf->Cell(10, 5, '2. ', 0, 0, 'R');
				$pdf->Cell(50, 5, '', 'B', 1, 'L');
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(30, 5, 'NIP.', 0, 0, 'L');
				$pdf->Cell(50, 5, '', 'B', 1, 'L');

				$pdf->Ln(5);
				$pdf->Cell(10, 5, '3. ', 0, 0, 'L');
				$pdf->Cell(30, 5, 'Kepala', 0, 0, 'L');
				$pdf->Cell(50, 5, '....................', 'B', 0, 'L');
				$pdf->Cell(10, 5, '3. ', 0, 0, 'R');
				$pdf->Cell(50, 5, '', 'B', 1, 'L');
				$pdf->Cell(10, 5, '', 0, 0, 'L');
				$pdf->Cell(30, 5, 'NIP.', 0, 0, 'L');
				$pdf->Cell(50, 5, '', 'B', 1, 'L');

				$pdf->Ln(5);
				$pdf->SetFont('Arial', 'IB', 10);
				$pdf->Cell(120, 8, 'Catatan:', 1, 1, 'L');
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(120, 8, '- Dibuat rangkap 2 (dua), masing-masing untuk arsip lembaga', 1, 0, 'L');

				$pdf->setY(-29);
				$pdf->Cell(8, 8, '', 1, 0);
				$pdf->Cell(3, 8, '', 0, 0);
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->Cell(169, 8, $nama_sekolah, 1, 0, 'C');
				$pdf->Cell(3, 8, '', 0, 0);
				$pdf->Cell(8, 8, '', 1, 0);


				$pdf->Output('I', 'Berita Acara - ' . $b->namaMapel . '.pdf');
			}
		} else {
			$a['p']	= "m_guru_tes";
		}
		$this->load->view('aaa', $a);
	}
	public function h_ujian()
	{
		$this->cek_aktif();
		cek_hakakses(array("guru", "admin"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$wh_1 = $a['sess_level'] == "admin" ? "" : " AND a.id_guru = '" . $a['sess_konid'] . "'";
		if ($uri3 == "det") {
			if ($uri4 != '') {
				$a['p'] = "m_guru_tes_hasil_detil";
				$a['detil_tes'] = $this->db->query("SELECT m_mapel.nama AS namaMapel, m_guru.nama AS nama_guru, tr_guru_tes.* FROM tr_guru_tes INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id WHERE tr_guru_tes.id = '$uri4'")->row();
				$a['statistik'] = $this->db->query("SELECT MAX(nilai) AS max_, MIN(nilai) AS min_, AVG(nilai) AS avg_ FROM tr_ikut_ujian WHERE tr_ikut_ujian.id_tes = '$uri4'")->row();
			} else {
				redirect('adm/m_ujian');
			}
		} else if ($uri3 == "data_det") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$d_total_row = $this->db->query("
	        	SELECT a.id
				FROM tr_ikut_ujian a
				INNER JOIN m_siswa b ON a.id_user = b.id
				WHERE a.id_tes = '$uri4' 
				AND b.nama LIKE '%" . $search['value'] . "%'")->num_rows();
			$q_datanya = $this->db->query("
	        	SELECT a.id, a.nilai, a.jml_benar, a.nilai_bobot, b.nama, b.nim
				FROM tr_ikut_ujian a
				INNER JOIN m_siswa b ON a.id_user = b.id
				WHERE a.id_tes = '$uri4' 
				AND b.nama LIKE '%" . $search['value'] . "%' ORDER BY a.nilai DESC LIMIT " . $start . ", " . $length . "")->result_array();

			$data = array();
			$no = ($start + 1);
			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = '<center>' . $no++ . '</center>';
				$data_ok[1] = '<center>' . $d['nim'] . '</center>';
				$data_ok[2] = $d['nama'];
				$data_ok[3] = '<center>' . $d['jml_benar'] . '</center>';
				$data_ok[4] = '<center>' . $d['nilai'] . '</center>';
				$data_ok[5] = '<center>' . $d['nilai_bobot'] . '</center>';
				$data_ok[6] = '<center>
				<div class="btn-group mt-1 mb-1">
				<a href="#" onclick="return hitung_akhir(' . $d['id'] . ');" class="btn btn-primary btn-xs fw-bold" id="alert-delete"><i class="far fa-paper-plane" aria-hidden="true"></i> Sumbit</a>
				<a href="#" onclick="return addTime(' . $d['id'] . ',' . $this->uri->segment(4) . ');" class="btn btn-success btn-xs fw-bold" id="alert-delete"><i class="fas fa-clock" aria-hidden="true"></i> Waktu</a>
				</div>
				</center>';
				$data_ok[7] = '<a href="#" onclick="return batalkanUjian(' . $d['id'] . ',' . $this->uri->segment(4) . ');" class="btn btn-danger btn-xs m-1 fw-bold" id="alert-delete"><i class="fas fa-sync-alt" aria-hidden="true"></i> Reset Ujian</a>';
				$data[] = $data_ok;
			}
			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "batalkan_ujian") {
			$this->db->query("DELETE FROM tr_ikut_ujian WHERE id = '$uri4'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$d_total_row = $this->db->query("SELECT a.id FROM tr_guru_tes a
	        	INNER JOIN m_mapel b ON a.id_mapel = b.id 
	        	INNER JOIN m_guru c ON a.id_guru = c.id
	            WHERE (a.nama_ujian LIKE '%" . $search['value'] . "%' OR b.nama LIKE '%" . $search['value'] . "%' OR c.nama LIKE '%" . $search['value'] . "%') " . $wh_1 . "")->num_rows();
			$q_datanya = $this->db->query("SELECT a.*, b.nama AS mapel, c.nama AS nama_guru FROM tr_guru_tes a
	        	INNER JOIN m_mapel b ON a.id_mapel = b.id 
	        	INNER JOIN m_guru c ON a.id_guru = c.id
	            WHERE (a.nama_ujian LIKE '%" . $search['value'] . "%' OR b.nama LIKE '%" . $search['value'] . "%' OR c.nama LIKE '%" . $search['value'] . "%') " . $wh_1 . " ORDER BY b.nama ASC LIMIT " . $start . ", " . $length . "")->result_array();

			$data = array();
			$no = ($start + 1);
			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = '<center>' . $no++ . '</center>';
				$data_ok[1] = '<b>' . date("d:m:Y", strtotime($d['tgl_mulai'])) . ' s/d ' .  date("d:m:Y", strtotime($d['terlambat'])) . '</b>';
				$data_ok[2] =  $d['kelas'] . ' ' . $d['jurusan'];
				$data_ok[3] = $d['nama_ujian'];
				$data_ok[4] = $d['nama_guru'];
				$data_ok[5] = $d['mapel'];
				$data_ok[6] = '<center>' . $d['jumlah_soal'] . '</center>';
				$data_ok[7] = $d['waktu'] . " menit";
				$data_ok[8] = '<center><a title="Hasil" href="' . base_url() . 'adm/h_ujian/det/' . $d['id'] . '" class="btn btn-primary btn-xs fw-bold mt-1 mb-1"><i class="fa fa-eye" aria-hidden="true"></i> Lihat</a>
                         ';
				$data[] = $data_ok;
			}
			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else if ($uri3 == "hitung_akhir") {
			$id_tes = abs($uri4);
			$tes_id = $this->db->query("SELECT id_tes FROM tr_ikut_ujian WHERE id = '$uri4'")->row();
			$get_jawaban = $this->db->query("SELECT list_jawaban FROM tr_ikut_ujian WHERE id = '$uri4'")->row_array();
			$pc_jawaban = explode(",", $get_jawaban['list_jawaban']);
			$jumlah_benar 	= 0;
			$jumlah_salah 	= 0;
			$jumlah_ragu  	= 0;
			$nilai_bobot 	= 0;
			$total_bobot	= 0;
			$jumlah_soal	= sizeof($pc_jawaban);
			for ($x = 0; $x < $jumlah_soal; $x++) {
				$pc_dt = explode(":", $pc_jawaban[$x]);
				$id_soal 	= $pc_dt[0];
				$jawaban 	= $pc_dt[1];
				$ragu 		= $pc_dt[2];
				$cek_jwb 	= $this->db->query("SELECT bobot, jawaban FROM m_soal WHERE id = '" . $id_soal . "'")->row();
				$total_bobot = $total_bobot + $cek_jwb->bobot;
				if (($cek_jwb->jawaban == $jawaban)) {
					//jika jawaban benar 
					$jumlah_benar++;
					$nilai_bobot = $nilai_bobot + $cek_jwb->bobot;
					$q_update_jwb = "UPDATE m_soal SET jml_benar = jml_benar + 1 WHERE id = '" . $id_soal . "'";
				} else {
					//jika jawaban salah
					$jumlah_salah++;
					$q_update_jwb = "UPDATE m_soal SET jml_salah = jml_salah + 1 WHERE id = '" . $id_soal . "'";
				}
				$this->db->query($q_update_jwb);
			}
			$nilai = ($jumlah_benar / $jumlah_soal)  * 100;
			$nilai_bobot = ($nilai_bobot / $total_bobot)  * 100;
			$this->db->query("UPDATE tr_ikut_ujian SET jml_benar = " . $jumlah_benar . ", nilai = " . $nilai . ", nilai_bobot = " . $nilai_bobot . ", status = 'N' WHERE id = '$id_tes'");
			$a['status'] = "ok";
			$a['id_ujian'] = $tes_id;
			j($a);
			exit;
		} else if ($uri3 == "addtime") {
			$a = $this->db->query("SELECT a.id as idUjian, a.tgl_selesai, b.nama, b.nopes FROM tr_ikut_ujian as a INNER JOIN m_siswa as b ON a.id_user=b.id WHERE a.id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "svaddtime") {
			if ($p->id != 0) {
				$sql = $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id = '" . bersih($p, "id") . "'")->row();
				$tambah_waktu = tambah_jam_sql(bersih($p, "waktu"));
				$time_mulai		= $sql->tgl_selesai;
				$this->db->query("UPDATE tr_ikut_ujian SET tgl_selesai = ADDTIME('$time_mulai', '$tambah_waktu') WHERE id='" . bersih($p, "id") . "'");
			}
			$ret_arr['id_tes'] 	= $sql->id_tes;
			$ret_arr['status'] 	= "ok";
			j($ret_arr);
			exit();
		} else {
			$a['p']	= "m_guru_tes_hasil";
		}
		$this->load->view('aaa', $a);
	}
	public function hasil_ujian_cetak()
	{
		$this->cek_aktif();
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		$a['detil_tes'] = $this->db->query("SELECT m_mapel.nama AS namaMapel, m_guru.nama AS nama_guru, 
												tr_guru_tes.* 
												FROM tr_guru_tes 
												INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id
												INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id
												WHERE tr_guru_tes.id = '$uri3'")->row();

		$a['statistik'] = $this->db->query("SELECT MAX(nilai) AS max_, MIN(nilai) AS min_, AVG(nilai) AS avg_ 
										FROM tr_ikut_ujian
										WHERE tr_ikut_ujian.id_tes = '$uri3'")->row();
		$a['hasil'] = $this->db->query("SELECT m_siswa.nama, tr_ikut_ujian.nilai, tr_ikut_ujian.jml_benar, tr_ikut_ujian.nilai_bobot
										FROM tr_ikut_ujian
										INNER JOIN m_siswa ON tr_ikut_ujian.id_user = m_siswa.id
										WHERE tr_ikut_ujian.id_tes = '$uri3' ORDER BY tr_ikut_ujian.nilai DESC")->result();
		$this->load->view("m_guru_tes_hasil_detil_cetak", $a);
	}
	/* == SISWA == */
	public function ikuti_ujian()
	{
		$data = array(
			'ujian_valid' => false,
			'ujian_token' => ''
		);
		$this->session->set_userdata($data);

		$this->cek_aktif();
		cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$x = $this->db->query("SELECT id, jurusan, id_jurusan FROM m_siswa WHERE id = '" . $a['sess_konid'] . "'")->row();
		$y = "UMUM";
		$d = date('Y-m-d');
		$a['data'] = $this->db->query("SELECT a.id, a.nama_ujian, a.jumlah_soal, a.waktu, a.kelas, a.jurusan, a.tgl_mulai, b.nama nmmapel, c.nama nmguru,
									IF((d.status='Y' AND NOW() BETWEEN d.tgl_mulai AND d.tgl_selesai),'Sedang Tes',
									IF(d.status='Y' AND NOW() NOT BETWEEN d.tgl_mulai AND d.tgl_selesai,'Waktu Habis',
									IF(d.status='N','Selesai','Belum Ikut'))) status
									FROM tr_guru_tes a INNER JOIN m_mapel b ON a.id_mapel = b.id INNER JOIN m_guru c ON a.id_guru = c.id
									LEFT JOIN tr_ikut_ujian d ON CONCAT('" . $a['sess_konid'] . "',a.id) = CONCAT(d.id_user,d.id_tes)
									WHERE a.kelas = '" . $x->jurusan . "' AND a.jurusan LIKE '%" . $x->id_jurusan . "%' OR a.jurusan LIKE '%" . $y . "%' AND a.tgl_mulai LIKE '%" . $d . "%' ORDER BY a.tgl_mulai ASC")->result();

		if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');
			$d_total_row = $this->db->query("SELECT a.id,
										IF((d.status='Y' AND NOW() BETWEEN d.tgl_mulai AND d.tgl_selesai),'Sedang Tes',
										IF(d.status='Y' AND NOW() NOT BETWEEN d.tgl_mulai AND d.tgl_selesai,'Waktu Habis',
										IF(d.status='N','Selesai','Belum Ikut'))) status_ujian
										FROM tr_guru_tes a
										INNER JOIN m_mapel b ON a.id_mapel = b.id 
										INNER JOIN m_guru c ON a.id_guru = c.id
										LEFT JOIN tr_ikut_ujian d ON CONCAT('" . $a['sess_konid'] . "',a.id) = CONCAT(d.id_user,d.id_tes)
										WHERE a.kelas = '" . $x->jurusan . "' AND a.jurusan = '" . $x->id_jurusan . "' AND (a.nama_ujian LIKE '%" . $search['value'] . "%' OR b.nama LIKE '%" . $search['value'] . "%' OR c.nama LIKE '%" . $search['value'] . "%')")->num_rows();
			$q_datanya = $this->db->query("SELECT a.*, b.nama AS mapel, c.nama AS nama_guru,
										IF((d.status='Y' AND NOW() BETWEEN d.tgl_mulai AND d.tgl_selesai),'Sedang Tes',
										IF(d.status='Y' AND NOW() NOT BETWEEN d.tgl_mulai AND d.tgl_selesai,'Waktu Habis',
										IF(d.status='N','Selesai','Belum Ikut'))) status_ujian
										FROM tr_guru_tes a
										INNER JOIN m_mapel b ON a.id_mapel = b.id 
										INNER JOIN m_guru c ON a.id_guru = c.id
										LEFT JOIN tr_ikut_ujian d ON CONCAT('" . $a['sess_konid'] . "',a.id) = CONCAT(d.id_user,d.id_tes)
										WHERE a.kelas = '" . $x->jurusan . "' AND a.jurusan = '" . $x->id_jurusan . "' AND  (a.nama_ujian LIKE '%" . $search['value'] . "%' OR b.nama LIKE '%" . $search['value'] . "%' OR c.nama LIKE '%" . $search['value'] . "%') ORDER BY b.nama ASC LIMIT " . $start . ", " . $length . "")->result_array();

			$data = array();
			$no = ($start + 1);
			foreach ($q_datanya as $d) {
				$jenis_soal = $d['jenis'] == "acak" ? "Random" : "In Order";
				$data_ok = array();
				$data_ok[0] = '<center>' . $no++ . '</center>';
				$data_ok[1] = '<b>' . $d['nama_ujian'] . '</b><br>' . $d['mapel'] . '<br>' . $d['nama_guru'];
				$data_ok[2] = '<center>' . $d['kelas'] . ' ' . $d['jurusan'] . '</center>';
				$data_ok[3] = '<center><span class="badge badge-warning fw-bold">' . $d['status_ujian'] . '</span></center>';
				$data_ok[4] = '<center><i class="fas fa-calendar-alt"></i> ' . tjs($d['tgl_mulai'], "s") . '<br><i class="fas fa-calendar-check"></i> ' . tjs($d['terlambat'], "s") . '</center>';
				if ($d['status_ujian'] == "Belum Ikut") {
					$data_ok[5] = '<center><a href="' . base_url() . 'adm/ikut_ujian/token/' . $d['id'] . '" title="Ikuti Ujian"" class="btn btn-success btn-xs fw-bold m-1"><i class="fas fa-check-circle"></i> Ikuti Ujian</a></center>';
				} elseif ($d['status_ujian'] == "Sedang Tes") {
					$data_ok[5] = '<center><a href="' . base_url() . 'adm/ikut_ujian/token/' . $d['id'] . '" title="Ujian Sedang Berjalan"" class="btn btn-warning btn-xs fw-bold m-1"><i class="fas fa-ellipsis-h"></i> On Progress</a></center>';
				} elseif ($d['status_ujian'] == "Waktu Habis") {
					$data_ok[5] = '<center><a href="' . base_url() . 'adm/ikut_ujian/token/' . $d['id'] . '" title="Kehabisan Waktu"" class="btn btn-danger btn-xs fw-bold m-1"><i class="fa fa-times-circle"></i> Kehabisan Waktu</a></center>';
				} else {
					$data_ok[5] = '<center><a href="' . base_url() . 'adm/nilai/' . $d['id'] . '" title="Hasil"" class="btn btn-info btn-xs fw-bold m-1"><i class="fa fa-eye"></i> Lihat Hasil</a></center>';
				}

				$data[] = $data_ok;
			}
			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else {
			$a['p']	= "m_list_ujian_siswa";
		}
		$this->load->view('aaa', $a);
	}
	public function ikut_ujian()
	{
		$this->cek_aktif();
		cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		$a['detil_user'] = $this->db->query("SELECT * FROM m_siswa WHERE id = '" . $a['sess_konid'] . "'")->row();
		if ($uri3 == "simpan_satu") {
			$p			= json_decode(file_get_contents('php://input'));
			$update_ 	= "";
			for ($i = 1; $i < $p->jml_soal; $i++) {
				$_tjawab 	= "opsi_" . $i;
				$_tidsoal 	= "id_soal_" . $i;
				$_ragu 		= "rg_" . $i;
				$jawaban_ 	= empty($p->$_tjawab) ? "" : $p->$_tjawab;
				$update_	.= "" . $p->$_tidsoal . ":" . $jawaban_ . ":" . $p->$_ragu . ",";
			}
			$update_		= substr($update_, 0, -1);
			$this->db->query("UPDATE tr_ikut_ujian SET list_jawaban = '" . $update_ . "' WHERE id_tes = '$uri4' AND id_user = '" . $a['sess_konid'] . "'");
			//echo $this->db->last_query();
			$q_ret_urn 	= $this->db->query("SELECT list_jawaban FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '" . $a['sess_konid'] . "'");
			$d_ret_urn 	= $q_ret_urn->row_array();
			$ret_urn 	= explode(",", $d_ret_urn['list_jawaban']);
			$hasil 		= array();
			foreach ($ret_urn as $key => $value) {
				$pc_ret_urn = explode(":", $value);
				$idx 		= $pc_ret_urn[0];
				$val 		= $pc_ret_urn[1] . '_' . $pc_ret_urn[2];
				$hasil[] = $val;
			}
			$d['data'] = $hasil;
			$d['status'] = "ok";
			j($d);
			exit;
		} else if ($uri3 == "simpan_akhir") {
			$id_tes = abs($uri4);
			$get_jawaban = $this->db->query("SELECT list_jawaban FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '" . $a['sess_konid'] . "'")->row_array();
			$pc_jawaban = explode(",", $get_jawaban['list_jawaban']);
			$jumlah_benar 	= 0;
			$jumlah_salah 	= 0;
			$jumlah_ragu  	= 0;
			$nilai_bobot 	= 0;
			$total_bobot	= 0;
			$jumlah_soal	= sizeof($pc_jawaban);
			for ($x = 0; $x < $jumlah_soal; $x++) {
				$pc_dt = explode(":", $pc_jawaban[$x]);
				$id_soal 	= $pc_dt[0];
				$jawaban 	= $pc_dt[1];
				$ragu 		= $pc_dt[2];
				$cek_jwb 	= $this->db->query("SELECT bobot, jawaban FROM m_soal WHERE id = '" . $id_soal . "'")->row();
				$total_bobot = $total_bobot + $cek_jwb->bobot;
				if (($cek_jwb->jawaban == $jawaban)) {
					//jika jawaban benar 
					$jumlah_benar++;
					$nilai_bobot = $nilai_bobot + $cek_jwb->bobot;
					$q_update_jwb = "UPDATE m_soal SET jml_benar = jml_benar + 1 WHERE id = '" . $id_soal . "'";
				} else {
					//jika jawaban salah
					$jumlah_salah++;
					$q_update_jwb = "UPDATE m_soal SET jml_salah = jml_salah + 1 WHERE id = '" . $id_soal . "'";
				}
				$this->db->query($q_update_jwb);
			}
			$nilai = ($jumlah_benar / $jumlah_soal)  * 100;
			$nilai_bobot = ($nilai_bobot / $total_bobot)  * 100;
			$this->db->query("UPDATE tr_ikut_ujian SET jml_benar = " . $jumlah_benar . ", nilai = " . $nilai . ", nilai_bobot = " . $nilai_bobot . ", status = 'N' WHERE id_tes = '$id_tes' AND id_user = '" . $a['sess_konid'] . "'");
			$a['status'] = "ok";
			j($a);
			exit;
		} else if ($uri3 == "token") {
			if ($uri4 != '') {
				header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Pragma: no-cache");
				$a['du'] = $this->db->query("SELECT a.id, a.tgl_mulai, a.terlambat, 
										a.token, a.nama_ujian, a.jumlah_soal, a.waktu,
										b.nama nmguru, c.nama nmmapel,
										(case
											when (now() < a.tgl_mulai) then 0
											when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1
											else 2
										end) statuse
										FROM tr_guru_tes a 
										INNER JOIN m_guru b ON a.id_guru = b.id
										INNER JOIN m_mapel c ON a.id_mapel = c.id 
										WHERE a.id = '$uri4'")->row_array();
				$a['dp'] = $this->db->query("SELECT * FROM m_siswa WHERE id = '" . $a['sess_konid'] . "'")->row_array();
				//$q_status = $this->db->query();
				if (!empty($a['du']) || !empty($a['dp'])) {
					$tgl_selesai = $a['du']['tgl_mulai'];
					//$tgl_selesai2 = strtotime($tgl_selesai);
					//$tgl_baru = date('F j, Y H:i:s', $tgl_selesai);
					//$tgl_terlambat = strtotime("+".$a['du']['terlambat']." minutes", $tgl_selesai2);	
					$tgl_terlambat_baru = $a['du']['terlambat'];
					$a['tgl_mulai'] = $tgl_selesai;
					$a['terlambat'] = $tgl_terlambat_baru;
					$a['p']	= "m_token";
					$this->load->view('aaa', $a);
				} else {
					redirect('adm/ikuti_ujian');
				}
			} else {
				redirect('adm/ikuti_ujian');
			}
		} else if ($uri3 == "validasiToken") {
			$q_data		= $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '" . bersih($p, 'id_ujian') . "' AND token = '" . bersih($p, 'token') . "'");
			$j_data		= $q_data->num_rows();
			$a_data		= $q_data->row();
			if ($j_data == 1) {
				if ($a_data->token == bersih($p, 'token')) {
					$data = array(
						'ujian_id' => $a_data->id,
						'ujian_token' => $a_data->token,
						'ujian_valid' => true
					);
					$this->session->set_userdata($data);
					$_log['status']			= "1";
					$_log['keterangan']		= "Token Valid";
					$_log['ujian_id']		= $a_data->id;
					$_log['detil_ujian']	= $this->session->userdata;
				} else {
					$_log['status']			= "0";
					$_log['keterangan']		= "Token Tidak Valid";
					$_log['ujian_id']		= $a_data->id;
					$_log['detil_ujian']	= null;
				}
			} else {
				$_log['status']			= "0";
				$_log['keterangan']		= "Token Tidak Valid";
				$_log['ujian_id']		= bersih($p, 'id_ujian');
				$_log['detil_ujian']	= null;
			}
			j($_log);
		} else if ($uri3 == "live") {
			$this->cek_token();
			$a['sess_ujian'] = $this->session->userdata('ujian_valid');
			$a['sess_ujianId'] = $this->session->userdata('ujian_id');
			$a['sess_token'] = $this->session->userdata('ujian_token');
			if ($a['sess_ujian'] == false || $a['sess_token'] == '') {
				redirect('adm/ikuti_ujian');
			} else {
				$cek_token = $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '" . $a['sess_ujianId'] . "'")->row();
				if ($cek_token == $uri5) {
					redirect('adm/ikuti_ujian');
				} else {
					header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
					header("Cache-Control: post-check=0, pre-check=0", false);
					header("Pragma: no-cache");
					$cek_sdh_selesai = $this->db->query("SELECT id FROM tr_ikut_ujian WHERE id_tes = '" . $a['sess_ujianId'] . "' AND id_user = '" . $a['sess_konid'] . "' AND status = 'N'")->num_rows();
					//sekalian validasi waktu sudah berlalu...
					if ($cek_sdh_selesai < 1) {
						//ini jika ujian belum tercatat, belum ikut
						//ambil detil soal
						$cek_detil_tes = $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '" . $a['sess_ujianId'] . "'")->row();
						$cek_detil_soal = $this->db->query("SELECT a.id FROM m_kelas a INNER JOIN tr_guru_tes b ON a.kelas=b.kelas WHERE b.id='" . $a['sess_ujianId'] . "'")->row();
						$q_cek_sdh_ujian = $this->db->query("SELECT id FROM tr_ikut_ujian WHERE id_tes = '" . $a['sess_ujianId'] . "' AND id_user = '" . $a['sess_konid'] . "'");
						$d_cek_sdh_ujian = $q_cek_sdh_ujian->row();
						$cek_sdh_ujian	= $q_cek_sdh_ujian->num_rows();
						$acakan = $cek_detil_tes->jenis == "acak" ? "ORDER BY RAND()" : "ORDER BY id ASC";
						if ($cek_sdh_ujian < 1) {
							$soal_urut_ok = array();
							$q_soal			= $this->db->query("SELECT id, file, tipe_file, soal, jenis_soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, '' AS jawaban FROM m_soal WHERE id_mapel = '" . $cek_detil_tes->id_mapel . "' AND id_guru = '" . $cek_detil_tes->id_guru . "' AND id_kelas = '" . $cek_detil_soal->id . "' " . $acakan . " LIMIT " . $cek_detil_tes->jumlah_soal)->result();
							$i = 0;
							foreach ($q_soal as $s) {
								$soal_per = new stdClass();
								$soal_per->id = $s->id;
								$soal_per->soal = $s->soal;
								$soal_per->file = $s->file;
								$soal_per->tipe_file = $s->tipe_file;
								$soal_per->jenis_soal = $s->jenis_soal;
								$soal_per->opsi_a = $s->opsi_a;
								$soal_per->opsi_b = $s->opsi_b;
								$soal_per->opsi_c = $s->opsi_c;
								$soal_per->opsi_d = $s->opsi_d;
								$soal_per->opsi_e = $s->opsi_e;
								$soal_per->jawaban = $s->jawaban;
								$soal_urut_ok[$i] = $soal_per;
								$i++;
							}
							$soal_urut_ok = $soal_urut_ok;
							$list_id_soal	= "";
							$list_jw_soal 	= "";
							if (!empty($q_soal)) {
								foreach ($q_soal as $d) {
									$list_id_soal .= $d->id . ",";
									$list_jw_soal .= $d->id . "::N,";
								}
							}
							$list_id_soal = substr($list_id_soal, 0, -1);
							$list_jw_soal = substr($list_jw_soal, 0, -1);
							$waktu_submit = tambah_jam_sql($cek_detil_tes->waktu - $cek_detil_tes->waktu_submit);
							$waktu_selesai = tambah_jam_sql($cek_detil_tes->waktu);
							$time_mulai		= date('Y-m-d H:i:s');
							$this->db->query("INSERT INTO tr_ikut_ujian VALUES (null, '" . $a['sess_ujianId'] . "', '" . $a['sess_konid'] . "', '$list_id_soal', '$list_jw_soal', 0, 0, 0, '$time_mulai', ADDTIME('$time_mulai', '$waktu_selesai'), ADDTIME('$time_mulai', '$waktu_submit'), 'Y')");
							$detil_tes = $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id_tes = '" . $a['sess_ujianId'] . "' AND id_user = '" . $a['sess_konid'] . "'")->row();
							$soal_urut_ok = $soal_urut_ok;
						} else {
							$q_ambil_soal 	= $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id_tes = '" . $a['sess_ujianId'] . "' AND id_user = '" . $a['sess_konid'] . "'")->row();
							$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);
							$soal_urut_ok	= array();
							for ($i = 0; $i < sizeof($urut_soal); $i++) {
								$pc_urut_soal = explode(":", $urut_soal[$i]);
								$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'" . $pc_urut_soal[1] . "'";
								$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal WHERE id = '" . $pc_urut_soal[0] . "'")->row();
								$soal_urut_ok[] = $ambil_soal;
							}
							$detil_tes = $q_ambil_soal;
							$soal_urut_ok = $soal_urut_ok;
						}
						$pc_list_jawaban = explode(",", $detil_tes->list_jawaban);
						$arr_jawab = array();
						foreach ($pc_list_jawaban as $v) {
							$pc_v = explode(":", $v);
							$idx = $pc_v[0];
							$val = $pc_v[1];
							$rg = $pc_v[2];
							$arr_jawab[$idx] = array("j" => $val, "r" => $rg);
						}
						$html = '';
						$no = 1;
						if (!empty($soal_urut_ok)) {
							foreach ($soal_urut_ok as $d) {
								$tampil_media = tampil_media("./upload/gambar_soal/" . $d->file, 'auto', 'auto');
								$vrg = $arr_jawab[$d->id]["r"] == "" ? "N" : $arr_jawab[$d->id]["r"];
								$html .= '<input type="hidden" name="id_soal_' . $no . '" value="' . $d->id . '">';
								$html .= '<input type="hidden" name="rg_' . $no . '" id="rg_' . $no . '" value="' . $vrg . '">';
								$html .= '<div class="step" id="widget_' . $no . '">';
								$html .= '<div class="row">
								<div class="col-md-12">
								<span class="badge badge-warning mb-2 mt-2">Pertayaan ke-' . $no . '</span><br>' . $d->soal . '<br>';
								if ($d->jenis_soal == 'multiple') {
									$html .= '<span class="badge badge-success mb-3 mt-2">Pilihan Jawaban</span>' . $tampil_media . '</div><div class="col-md-12">';
								} else {
									$html .= '<span class="badge badge-success mb-3 mt-2">Jawaban Singkat</span>' . $tampil_media . '</div><div class="col-md-12">';
								}

								if ($d->jenis_soal == 'multiple') {
									for ($j = 0; $j < $a['aplikasi']['ujian_opsi']; $j++) {
										$opsi = "opsi_" . $this->opsi[$j];
										$checked = $arr_jawab[$d->id]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";
										$pc_pilihan_opsi = explode("#####", $d->$opsi);
										$tampil_media_opsi = (is_file('./upload/gambar_soal/' . $pc_pilihan_opsi[0]) || $pc_pilihan_opsi[0] != "") ? tampil_media('./upload/gambar_opsi/' . $pc_pilihan_opsi[0], 'auto', 'auto') : '';
										$pilihan_opsi = empty($pc_pilihan_opsi[1]) ? "-" : $pc_pilihan_opsi[1];

										$html .= '<div class="row mb-4" onclick="return simpan_sementara();">
									<label class="selectgroup-item col-md-12">
										<input type="radio" class="selectgroup-input" id="opsi_' . strtoupper($this->opsi[$j]) . '_' . $d->id . '" name="opsi_' . $no . '" value="' . strtoupper($this->opsi[$j]) . '" ' . $checked . '>
										<label class="selectgroup-button text-left" for="opsi_' . strtoupper($this->opsi[$j]) . '_' . $d->id . '">
											<div class="row align-items-center">
												<div class="col-md-1">
													<div class="huruf_opsi btn btn-sm btn-info fw-bold">' . strtoupper($this->opsi[$j]) . '</div>
												</div>
												<div class="col-sm-11">' . $pilihan_opsi . '</div>
												<div class="col-md-6">
													' . $tampil_media_opsi . '
												</div>
											</div>
										</label>
									</label>
									</div>';
									}
								} else {
									$vrg = $arr_jawab[$d->id]["j"] == "" ? "" : $arr_jawab[$d->id]["j"];
									$html .= '<input class="form-control" id="opsi_' . $d->id . '" name="opsi_' . $no . '" value="' . $vrg . '">';
								}
								$html .= '</div></div></div>';
								$no++;
							}
						}
						$a['jam_mulai'] = $detil_tes->tgl_mulai;
						$a['jam_selesai'] = $detil_tes->tgl_selesai;
						$a['jam_submit'] = $detil_tes->tgl_submit;
						$a['id_tes'] = $cek_detil_tes->id;
						$a['no'] = $no;
						$a['html'] = $html;
						$this->load->view('v_ujian', $a);
					} else {
						redirect('adm/nilai/' . $a['sess_ujianId']);
					}
				}
			}
		} else {
			redirect('adm/ikuti_ujian');
		}
	}
	public function jvs()
	{
		$this->cek_aktif();
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		$data_soal 		= $this->db->query("SELECT id, gambar, jenis_soal, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal ORDER BY RAND()")->result();
		j($data_soal);
		exit;
	}
	public function rubah_password()
	{
		$this->cek_aktif();
		//var def session
		$a['sess_admin_id'] = $this->session->userdata('admin_id');
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		$ret = array();
		if ($uri3 == "simpan") {
			$p1_md5 = sha1($p->p1);
			$p2_md5 = sha1($p->p2);
			$p3_md5 = sha1($p->p3);
			$p4_sandi = $p->p3;
			$cek_pass_lama = $this->db->query("SELECT password FROM m_admin WHERE id = '" . $a['sess_admin_id'] . "'")->row();
			if ($cek_pass_lama->password != $p1_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password lama tidak sama!";
			} else if ($p2_md5 != $p3_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru konfirmasinya tidak sama!";
			} else if (strlen($p->p2) < 6) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru minimal terdiri dari 6 huruf!";
			} else {
				$this->db->query("UPDATE m_siswa SET sandi = '" . $p4_sandi . "' WHERE id = '" . $a['sess_konid'] . "'");
				$this->db->query("UPDATE m_admin SET password = '" . $p3_md5 . "' WHERE id = '" . $a['sess_admin_id'] . "'");
				$ret['status'] = "ok";
				$ret['msg'] = "Password berhasil diubah!";
			}
			j($ret);
			exit;
		} else {
			$data = $this->db->query("SELECT id, kon_id, level, username FROM m_admin WHERE id = '" . $a['sess_admin_id'] . "'")->row();
			j($data);
			exit;
		}
	}
	public function nilai()
	{
		$this->cek_aktif();
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		if ($uri3 != '') {
			$q_nilai = $this->db->query("SELECT nilai, tgl_selesai FROM tr_ikut_ujian WHERE id_tes = $uri3 AND id_user = '" . $a['sess_konid'] . "' AND status = 'N'")->row();
			$a['hasil'] = $this->db->query("SELECT * FROM tr_ikut_ujian INNER JOIN tr_guru_tes ON tr_ikut_ujian.id_tes=tr_guru_tes.id INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id WHERE tr_ikut_ujian.id_user = '" . $a['sess_konid'] . "' AND status = 'N'")->result();
			if (empty($q_nilai)) {
				redirect('adm/ikut_ujian/_/' . $uri3);
			} else {
				$a['p'] = "v_nilai_detail";
				if ($a['aplikasi']['ujian_nilai']) {
					$a['data'] = "Anda telah selesai mengikuti ujian ini pada <b>" . tjs($q_nilai->tgl_selesai, 'pj') . ".</b><br> dan, Anda mendapatkan nilai <b>" . ceil($q_nilai->nilai) . ".</b>";
				} else {
					$a['data'] = "Anda telah selesai mengikuti ujian ini pada: <b>" . tjs($q_nilai->tgl_selesai, "pj") . "</b>.<br>Nilai akan diumumkan oleh guru yang bersangkutan. Terima kasih!";
				}
			}
		} else {
			$a['hasil'] = $this->db->query("SELECT * FROM tr_ikut_ujian INNER JOIN tr_guru_tes ON tr_ikut_ujian.id_tes=tr_guru_tes.id INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id WHERE tr_ikut_ujian.id_user = '" . $a['sess_konid'] . "' AND status = 'N'")->result();
			$a['p'] = "v_nilai";
		}
		$this->load->view('aaa', $a);
	}
	/* Login Logout */
	public function login()
	{
		$a['lembaga'] = $this->db->query("SELECT * FROM m_lembaga WHERE lembaga_status = 'aktif'")->row_array();
		$a['aplikasi'] = $this->db->query("SELECT * FROM m_setting WHERE settings_status = 'aktif'")->row_array();
		$a['jenjang'] = array("" => "Pilih", "MI" => "MI", "SD" => "SD", "MTS" => "MTS", "SMP" => "SMP", "MA" => "MA", "SMA/SMK" => "SMA/SMK");
		$this->load->view('aaa_login', $a);
	}
	public function act_login()
	{
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');
		$password2	= sha1($password);
		$q_data		= $this->db->query("SELECT * FROM m_admin WHERE username = '" . $username . "' AND password = '$password2'");
		$j_data		= $q_data->num_rows();
		$a_data		= $q_data->row();
		$_log		= array();
		if ($j_data === 1) {
			$sess_nama_user = "";
			if ($a_data->level == "siswa") {
				$det_user = $this->db->query("SELECT nama FROM m_siswa WHERE id = '" . $a_data->kon_id . "'")->row();
				if (!empty($det_user)) {
					$sess_nama_user = $det_user->nama;
				}
				$data = array(
					'admin_id' => $a_data->id,
					'admin_user' => $a_data->username,
					'admin_level' => $a_data->level,
					'admin_konid' => $a_data->kon_id,
					'admin_nama' => $sess_nama_user,
					'admin_valid' => true,
					'ujian_valid' => false,
					'ujian_token' => ''
				);
				$this->session->set_userdata($data);
				redirect('adm/ikuti_ujian');
			} else if ($a_data->level == "guru") {
				$det_user = $this->db->query("SELECT nama FROM m_guru WHERE id = '" . $a_data->kon_id . "'")->row();
				if (!empty($det_user)) {
					$sess_nama_user = $det_user->nama;
				}
				$data = array(
					'admin_id' => $a_data->id,
					'admin_user' => $a_data->username,
					'admin_level' => $a_data->level,
					'admin_konid' => $a_data->kon_id,
					'admin_nama' => $sess_nama_user,
					'admin_valid' => true,
					'ujian_valid' => false,
					'ujian_token' => ''
				);
				$this->session->set_userdata($data);
				redirect('adm');
			} else {
				$sess_nama_user = "Administrator";
				$data = array(
					'admin_id' => $a_data->id,
					'admin_user' => $a_data->username,
					'admin_level' => $a_data->level,
					'admin_konid' => $a_data->kon_id,
					'admin_nama' => $sess_nama_user,
					'admin_valid' => true,
					'ujian_valid' => false,
					'ujian_token' => ''
				);
				$this->session->set_userdata($data);
				redirect('adm');
			}
		} else {
			redirect('adm/login');
		}
	}
	public function logout()
	{
		$data = array(
			'admin_id' => '',
			'admin_user' => '',
			'admin_level' => '',
			'admin_konid' => '',
			'admin_nama' => '',
			'admin_valid' => false,
			'ujian_valid' => false,
			'ujian_token' => ''
		);
		$this->session->set_userdata($data);
		redirect('adm/login');
	}
	//fungsi tambahan
	public function get_akhir($tabel, $field, $kode_awal, $pad)
	{
		$get_akhir	= $this->db->query("SELECT MAX($field) AS max FROM $tabel LIMIT 1")->row();
		$data		= (intval($get_akhir->max)) + 1;
		$last		= $kode_awal . str_pad($data, $pad, '0', STR_PAD_LEFT);
		return $last;
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */