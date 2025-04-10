<div class="page-inner">
  <div class="row">
    <?php if ($this->session->userdata('admin_level') == "guru") { ?>
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-primary bubble-shadow-small">
                  <i class="fas fa-file-invoice"></i>
                </div>
              </div>
              <div class="col col-stats ml-3 ml-sm-0">
                <div class="numbers">
                  <p class="card-category fw-bold">Mata Pelajaran</p>
                  <h4 class="card-title fw-bold"><?php echo $mapel; ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-danger bubble-shadow-small">
                  <i class="fas fa-file-signature"></i>
                </div>
              </div>
              <div class="col col-stats ml-3 ml-sm-0">
                <div class="numbers">
                  <p class="card-category fw-bold">Soal</p>
                  <h4 class="card-title fw-bold"><?php echo $soal; ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-warning bubble-shadow-small">
                  <i class="fa fa-archive"></i>
                </div>
              </div>
              <div class="col col-stats ml-3 ml-sm-0">
                <div class="numbers">
                  <p class="card-category fw-bold">Ujian</p>
                  <h4 class="card-title fw-bold"><?php echo $ujian; ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } else if ($this->session->userdata('admin_level') == "admin") { ?>
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-primary bubble-shadow-small">
                  <i class="fas fa-user-friends"></i>
                </div>
              </div>
              <div class="col col-stats ml-3 ml-sm-0">
                <div class="numbers">
                  <p class="card-category fw-bold">Peserta Ujian</p>
                  <h4 class="card-title fw-bold"><?php echo $siswa; ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-danger bubble-shadow-small">
                  <i class="fas fa-user-graduate"></i>
                </div>
              </div>
              <div class="col col-stats ml-3 ml-sm-0">
                <div class="numbers">
                  <p class="card-category fw-bold">Proktor</p>
                  <h4 class="card-title fw-bold"><?php echo $proktor; ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-warning bubble-shadow-small">
                  <i class="fa fa-archive"></i>
                </div>
              </div>
              <div class="col col-stats ml-3 ml-sm-0">
                <div class="numbers">
                  <p class="card-category fw-bold">Ujian</p>
                  <h4 class="card-title fw-bold"><?php echo $ujian; ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } else { ?>
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-success bubble-shadow-small">
                  <i class="fas fa-check-circle"></i>
                </div>
              </div>
              <div class="col col-stats ml-3 ml-sm-0">
                <div class="numbers">
                  <p class="card-category fw-bold">Ujian Selesai</p>
                  <h4 class="card-title fw-bold"><?php echo $selesai_ujian; ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-warning bubble-shadow-small">
                  <i class="fa fa-times-circle"></i>
                </div>
              </div>
              <div class="col col-stats ml-3 ml-sm-0">
                <div class="numbers">
                  <p class="card-category fw-bold">Belum Ujian</p>
                  <h4 class="card-title fw-bold"><?php echo ($ujian - $selesai_ujian); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-danger bubble-shadow-small">
                  <i class="fa fa-archive"></i>
                </div>
              </div>
              <div class="col col-stats ml-3 ml-sm-0">
                <div class="numbers">
                  <p class="card-category fw-bold">Total Ujian</p>
                  <h4 class="card-title fw-bold"><?php echo $ujian; ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="alert alert-secondary mb-4">
    <span class="fw-bold h3">Dashboard <?php echo $aplikasi['aplikasi_nama']; ?> </span><br>
    <small> Selamat Datang <b class="text-primary"> <?php echo $this->session->userdata('admin_nama'); ?></b> di <?php echo $aplikasi['aplikasi_nama']; ?>! Anda login sebagai <b><?php echo $sess_level; ?></b>.</small>
  </div>
</div>