<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Detail Ujian <?php echo $du['nama_ujian']; ?></h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="<?php echo base_url(); ?>adm/ikuti_ujian"> <button class="btn btn-xs btn-secondary m-1 fw-bold"><i class="fa fa-pencil-square" aria-hidden="true"></i><span class="d-none d-md-block">Data Ujian</span></button></a>
          </div>
        </div>
        <div class="col-lg-12 mb-4">
          <input type="hidden" name="_tgl_sekarang" id="_tgl_sekarang" value="<?php echo date('Y-m-d H:i:s'); ?>">
          <input type="hidden" name="_tgl_mulai" id="_tgl_mulai" value="<?php echo $tgl_mulai; ?>">
          <input type="hidden" name="_terlambat" id="_terlambat" value="<?php echo $terlambat; ?>">
          <input type="hidden" name="_statuse" id="_statuse" value="<?php echo $du['statuse']; ?>">
          <form name="f_token" id="f_token" onsubmit="return validasi_token();">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" name="id_ujian" id="id_ujian" value="<?php echo $du['id']; ?>">
              </div>
              <div class="col-md-7">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <table class="table table-bordered">
                      <tr>
                        <td width="35%" class="fw-bold">NAMA</td>
                        <td width="65%" class="fw-bold"><?php echo $dp['nama']; ?></td>
                      </tr>
                      <tr>
                        <td class="fw-bold">NIS</td>
                        <td class="fw-bold"><?php echo $dp['nim']; ?></td>
                      </tr>
                      <tr>
                        <td>GURU/MAPEL</td>
                        <td><?php echo $du['nmguru'] . "/" . $du['nmmapel']; ?></td>
                      </tr>
                      <tr>
                        <td>NAMA UJIAN</td>
                        <td><?php echo $du['nama_ujian']; ?></td>
                      </tr>
                      <tr>
                        <td>SOAL</td>
                        <td><?php echo $du['jumlah_soal']; ?> Soal</td>
                      </tr>
                      <tr>
                        <td>WAKTU</td>
                        <td><?php echo $du['waktu']; ?> Menit</td>
                      </tr>
                      <tr>
                        <td class="fw-bold">TOKEN</td>
                        <td><input type="text" name="token" id="token" required="true" class="form-control fw-bold col-md-6 mt-2 mb-2"></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="panel panel-default">
                  <div class="panel-body">
                    <div class="alert alert-warning">
                      WAKTU MENGERJAKAN UJIAN PADA SAAT TOMBOL <b>"MULAI"</b> BERWARNA HIJAU!</br>
                      <hr>
                      <b>DAN, HARAP DIPERHATIKAN JADWAL UJIAN SERTA PEMILIHAN UJIAN!</b>
                    </div>
                    <div class="col-md-12">
                      <div class="row">
                        <div id="btn_mulai" class="fw-bold">Ujian akan mulai dalam <span id="akan_mulai"></span>
                        </div>
                        <div class="btn btn-warning btn-lg ml-1 fw-bold" id="waktu_">
                          <i class="fas fa-clock" aria-hidden="true"></i> <span id="waktu_akhir_ujian"></span>
                        </div>
                        <div id="waktu_game_over"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>