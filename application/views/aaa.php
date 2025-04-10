<!DOCTYPE html>
<html lang="en">

<head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <title><?php echo $aplikasi['aplikasi_nama']; ?> <?php echo $aplikasi['aplikasi_versi']; ?></title>
   <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
   <meta name="description" content="<?php echo $lembaga['lembaga_profile']; ?>">
   <meta name="author" content="<?php echo $lembaga['lembaga_alamat']; ?>">
   <meta name="keyword" content="<?php echo $aplikasi['aplikasi_nama']; ?>">
   <script>
      var base_url_js = '<?php echo base_url(); ?>';
   </script>
   <script src="<?php echo base_url(); ?>___/js/jquery-3.5.1.js"></script>
   <!-- Fonts dan Icons -->
   <script src="<?php echo base_url(); ?>___/js/plugin/webfont/webfont.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/webfont/font.js"></script>
   <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
   <link href="<?php echo base_url(); ?>___/css/font-awesome.min.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>___/css/bootstrap.min.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>___/css/atlantis.min.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>___/css/rowReorder.dataTables.min.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>___/css/responsive.dataTables.min.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>upload/gambar_lembaga/<?php echo $lembaga['lembaga_foto']; ?>" rel="icon" type="image/png">
</head>

<body>
   <div class="wrapper">
      <div class="main-header">
         <!-- Logo Header -->
         <div class="logo-header" data-background-color="green">
            <a href="<?php echo base_url(); ?>" class="logo">
               <!-- <b class="text-white"><i class="fa fa-buysellads" aria-hidden="true"></i>UMadrasah</b> -->
               <b class="text-white"><?php echo $aplikasi['aplikasi_nama']; ?></b>
            </a>
            <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon">
                  <i class="icon-menu"></i>
               </span>
            </button>
            <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
            <div class="nav-toggle">
               <button class="btn btn-toggle toggle-sidebar">
                  <i class="icon-menu"></i>
               </button>
            </div>
         </div>
         <!-- End Logo Header -->
         <!-- Navbar Header -->
         <nav class="navbar navbar-header navbar-expand-lg" data-background-color="green2">
            <div class="container-fluid">
               <div class="collapse" id="search-nav">
                  <span class="d-flex align-items-center">
                     <span class="text-white fw-bold">Assalamualaikum, <?php echo $this->session->userdata('admin_nama'); ?>!</span>
                  </span>
               </div>
               <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                  <li class="nav-item dropdown hidden-caret">
                     <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <span class="d-flex align-items-center">
                           <div class="avatar-sm">
                              <img src="<?php echo base_url(); ?>___/img/default.png" class="avatar-img rounded-circle">
                           </div>
                           <span class="text-white fw-bold"><?php echo $this->session->userdata('admin_nama'); ?></span>
                        </span>
                     </a>
                     <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                           <li>
                              <div class="user-box">
                                 <div class="avatar-lg">
                                    <img src="<?php echo base_url(); ?>___/img/default.png" class="avatar-img rounded">
                                 </div>
                                 <div class="u-text mt-2">
                                    <h4><?php echo $this->session->userdata('admin_level'); ?></h4>
                                    <p class="text-muted"><?php echo $this->session->userdata('admin_nama'); ?></p>
                                 </div>
                              </div>
                           </li>
                           <li>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ubahAkunProfil"><i class="fas fa-user-alt"></i>&nbsp; Profil</a>
                              <a class="dropdown-item" href="#" onclick="return rubah_password();" data-toggle="modal" data-target="#tampilkan_modal"><i class="fas fa-lock"></i>&nbsp; Ubah password</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="<?php echo base_url(); ?>adm/logout"><i class="fas fa-sign-out-alt text-danger"></i>&nbsp; Keluar</a>
                           </li>
                        </div>
                     </ul>
                  </li>
               </ul>
            </div>
         </nav>
         <!-- End Navbar -->
      </div>
      <!-- Sidebar -->
      <div class="sidebar sidebar-style-2">
         <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
               <div class="user">
                  <div class="avatar-sm avatar avatar-online float-left mr-2">
                     <img src="<?php echo base_url(); ?>___/img/default.png" class="avatar-img rounded-circle">
                  </div>
                  <div class="info">
                     <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span><small class="fw-bold"><?php echo $sess_user; ?></small><span class="user-level text-secondary"><?php echo $this->session->userdata('admin_nama'); ?></span></span>
                     </a>
                     <div class="clearfix"></div>
                  </div>
               </div>
               <ul class="nav nav-info">
                  <!-- beranda -->
                  <li class="nav-item active">
                     <a href="<?php echo base_url(); ?>" class="collapsed">
                        <i class="fas fa-home text-info"></i>
                        <p>Beranda</p>
                     </a>
                  </li>
                  <!-- main utama -->
                  <li class="nav-section">
                     <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                     </span>
                     <h4 class="text-section">Main Utama</h4>
                  </li>
                  <?php if ($this->session->userdata('admin_level') == 'admin') { ?>
                     <li class="nav-item">
                        <a data-toggle="collapse" href="#lembaga">
                           <i class="fa fa-building text-info"></i>
                           <p class="fw-bold">Lembaga</p>
                           <span class="caret"></span>
                        </a>
                        <div class="collapse <?php if (strpos($this->uri->segment(2), 'lembaga') !== false) {
                                                echo "show";
                                             }; ?>" id="lembaga">
                           <ul class="nav nav-collapse pt-0">
                              <li><a href="<?php echo base_url(); ?>adm/lembaga"><span class="sub-item">Profil</span></a>
                              </li>
                           </ul>
                        </div>
                     </li>
                  <?php }
                  if ($this->session->userdata('admin_level') == 'admin' or $this->session->userdata('admin_level') == 'guru') { ?>
                     <li class="nav-item">
                        <a data-toggle="collapse" href="#siswa">
                           <i class="fas fa-user text-warning"></i>
                           <p class="fw-bold">Peserta Didik</p>
                           <span class="caret"></span>
                        </a>
                        <div class="collapse <?php if (strpos($this->uri->segment(2), 'm_siswa') !== false) {
                                                echo "show";
                                             }; ?>" id="siswa">
                           <ul class="nav nav-collapse pt-0">
                              <li><a href="<?php echo base_url(); ?>adm/m_siswa"><span class="sub-item">Data</span></a>
                              </li>
                           </ul>
                        </div>
                     </li>
                     <li class="nav-item">
                        <a data-toggle="collapse" href="#soal">
                           <i class="fas fa-database text-primary"></i>
                           <p class="fw-bold">Bank Soal</p>
                           <span class="caret"></span>
                        </a>
                        <div class="collapse <?php if (strpos($this->uri->segment(2), 'm_soal') !== false or strpos($this->uri->segment(2), 'importword') !== false) {
                                                echo "show";
                                             }; ?>" id="soal">
                           <ul class="nav nav-collapse pt-0">
                              <li><a href="<?php echo base_url(); ?>adm/m_soal"><span class="sub-item">Data Soal</span></a></li>
                              <li><a href="<?php echo base_url(); ?>adm/importword"><span class="sub-item">Impor Word</span></a></li>
                              <li><a href="<?php echo base_url(); ?>adm/m_soal/import"><span class="sub-item">Impor Excel</span></a></li>
                           </ul>
                        </div>
                     </li>
                     <?php if ($this->session->userdata('admin_level') == 'admin') { ?>
                        <li class="nav-item">
                           <a data-toggle="collapse" href="#atur">
                              <i class="fas fa-sliders-h text-success"></i>
                              <p class="fw-bold">Pengaturan</p>
                              <span class="caret"></span>
                           </a>
                           <div class="collapse <?php if (strpos($this->uri->segment(2), 'm_jurusan') !== false or strpos($this->uri->segment(2), 'm_kelas') !== false or strpos($this->uri->segment(2), 'm_mapel') !== false or strpos($this->uri->segment(2), 'm_ruang') !== false) {
                                                   echo "show";
                                                }; ?>" id="atur">
                              <ul class="nav nav-collapse">
                                 <li><a href="<?php echo base_url(); ?>adm/m_jurusan"><span class="sub-item">Jurusan</span></a>
                                 <li><a href="<?php echo base_url(); ?>adm/m_kelas"><span class="sub-item">Kelas</span></a>
                                 <li><a href="<?php echo base_url(); ?>adm/m_mapel"><span class="sub-item">Mata Pelajaran</span></a>
                                 <li><a href="<?php echo base_url(); ?>adm/m_ruang"><span class="sub-item">Ruang</span></a>
                                 </li>
                              </ul>
                           </div>
                        </li>
                        <li class="nav-item">
                           <a data-toggle="collapse" href="#proktor">
                              <i class="fa fa-user-plus text-info"></i>
                              <p class="fw-bold">Proktor</p>
                              <span class="caret"></span>
                           </a>
                           <div class="collapse <?php if (strpos($this->uri->segment(2), 'm_guru') !== false) {
                                                   echo "show";
                                                }; ?>" id="proktor">
                              <ul class="nav nav-collapse">
                                 <li><a href="<?php echo base_url(); ?>adm/m_guru"><span class="sub-item">Data</span></a>
                                 </li>
                              </ul>
                           </div>
                        </li>
                     <?php } ?>
                     <li class="nav-item">
                        <a data-toggle="collapse" href="#ujian">
                           <i class="fas fa-certificate text-secondary"></i>
                           <p class="fw-bold">Ujian</p>
                           <span class="caret"></span>
                        </a>
                        <div class="collapse <?php if (strpos($this->uri->segment(2), 'm_ujian') !== false or strpos($this->uri->segment(2), 'm_ruangan') !== false or strpos($this->uri->segment(2), 'h_ujian') !== false) {
                                                echo "show";
                                             }; ?>" id="ujian">
                           <ul class="nav nav-collapse">
                              <li><a href="<?php echo base_url(); ?>adm/m_ujian"><span class="sub-item">Daftar Ujian</span></a>
                              <li><a href="<?php echo base_url(); ?>adm/m_ruangan"><span class="sub-item">Cetak Daftar Hadir</span></a>
                              <li><a href="<?php echo base_url(); ?>adm/kartupeserta" target="_blank"><span class="sub-item">Cetak Kartu Ujian</span></a>
                              </li>
                           </ul>
                        </div>
                     </li>
                  <?php }
                  if ($this->session->userdata('admin_level') == 'siswa') { ?>
                     <li class="nav-item">
                        <a data-toggle="collapse" href="#ujian">
                           <i class="fa fa-pencil-square text-secondary"></i>
                           <p class="fw-bold">Data Ujian</p>
                           <span class="caret"></span>
                        </a>
                        <div class="collapse <?php if (strpos($this->uri->segment(2), 'ikuti_ujian') !== false) {
                                                echo "show";
                                             }; ?>" id="ujian">
                           <ul class="nav nav-collapse">
                              <li><a href="<?php echo base_url(); ?>adm/ikuti_ujian"><span class="sub-item">Ujian</span></a>
                              </li>
                           </ul>
                        </div>
                     </li>
                  <?php } ?>
                  <!-- keluar -->
                  <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                     <h4 class="text-section">User</h4>
                  </li>
                  <li class="nav-item">
                     <a href="<?php echo base_url(); ?>adm/logout" class="collapsed"><i class="fas fa-sign-out-alt text-danger"></i>
                        <p class="fw-bold">Keluar</p>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <!-- End Sidebar -->
      <!-- Content -->
      <div class="main-panel">
         <div class="content">
            <?php echo $this->load->view($p); ?>
         </div>
         <footer class="footer">
            <div class="container">
               <div class="copyright ml-auto">
                  <b><?php echo  date('Y') .  " &copy " . $lembaga['lembaga_profile'] ?></b>
               </div>
            </div>
         </footer>
      </div>
      <!-- End Content -->
   </div>
   <!-- insert modal -->
   <div id="tampilkan_modal"></div>
   <script src="<?php echo base_url(); ?>___/js/jquery-3.5.1.js"></script>
   <script src="<?php echo base_url(); ?>___/js/core/popper.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/core/bootstrap.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/datatables/datatables.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/datatables/dataTables.rowReorder.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/datatables/dataTables.responsive.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/datatables/dataTables.buttons.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/datatables/jszip.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/datatables/vfs_fonts.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/datatables/buttons.html5.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/datatables/buttons.print.min.js"></script>
   <script src="<?php echo base_url(); ?>___/plugin/jquery_zoom/jquery.zoom.min.js"></script>
   <script src="<?php echo base_url(); ?>___/plugin/countdown/jquery.countdownTimer.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/jquery.validate/jquery.validate.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/select2/select2.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/plugin/sweetalert/sweetalert.min.js"></script>
   <script src="<?php echo base_url(); ?>___/js/atlantis.min.js"></script>
   <?php
   if ($this->uri->segment(2) == "m_soal" && $this->uri->segment(3) == "edit") { ?>
      <script src="<?php echo base_url(); ?>___/plugin/ckeditor/ckeditor.js"></script>
   <?php } elseif ($this->uri->segment(2) == "importword" or $this->uri->segment(2) == "toimport") { ?>
      <script src="<?php echo base_url(); ?>___/plugin/ckeditor/ckeditor.js"></script>
   <?php } ?>
   <script type="text/javascript">
      var base_url = "<?php echo base_url(); ?>";
      var editor_style = "<?php echo $this->config->item('editor_style'); ?>";
      var uri_js = "<?php echo $this->config->item('uri_js'); ?>";
   </script>
   <script>
      $(document).ready(function() {
         $('#example').DataTable();
      });
   </script>
   <script src="<?php echo base_url(); ?>___/js/aplikasi.js?time=<?php echo time(); ?>"></script>
</body>

</html>