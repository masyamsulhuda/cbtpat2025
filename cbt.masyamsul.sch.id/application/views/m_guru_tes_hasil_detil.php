<?php
$uri4 = $this->uri->segment(4);
?>
<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Detail Hasil Ujian</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="<?php echo base_url(); ?>adm/hasil_ujian_cetak/<?php echo $uri4; ?>" target="_blank"><button class="btn btn-xs btn-primary fw-bold"><i class="fa fa-print" aria-hidden="true"></i><span class="d-none d-md-block">Cetak Hasil</span></button></a>
          </div>
        </div>
        <div class="col-lg-12 mb-4">
          <div class="row">
            <div class="col-lg-6">
              <table class="table table-bordered" style="margin-bottom: 0px">
                <tr class="fw-bold">
                  <td width="30%">Nama Ujian</td>
                  <td width="70%">[<?php echo $detil_tes->kelas; ?>] - [<?php echo $detil_tes->jurusan; ?>] - <?php echo $detil_tes->nama_ujian; ?></td>
                </tr>
                <tr>
                  <td>Mata Pelajaran</td>
                  <td><?php echo $detil_tes->namaMapel; ?></td>
                </tr>
                <tr>
                  <td>Nama Guru</td>
                  <td><?php echo $detil_tes->nama_guru; ?></td>
                </tr>
                <tr>
                  <td>Waktu</td>
                  <td><?php echo $detil_tes->waktu; ?> Menit</td>
                </tr>
              </table>
            </div>
            <div class="col-lg-6">
              <table class="table table-bordered" style="margin-bottom: 0px">
                <tr>
                  <td width="30%">Jumlah Soal</td>
                  <td><?php echo $detil_tes->jumlah_soal; ?> Pertanyaan</td>
                </tr>
                <tr>
                  <td>Tertinggi</td>
                  <td><?php echo $statistik->max_; ?></td>
                </tr>
                <tr>
                  <td>Terendah</td>
                  <td><?php echo $statistik->min_; ?></td>
                </tr>
                <tr>
                  <td>Rata-rata</td>
                  <td><?php echo number_format($statistik->avg_); ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="table-responsive pb-3" style="overflow-x:auto;">
          <table id="datatabel" class="table table-striped table-bordered table-hover" cellspacing="0" style="width: 100%;">
            <thead class="bg-warning">
              <tr class="text-white text-center">
                <th width="5%">No</th>
                <th width="10%">Username</th>
                <th width="30%">Nama Peserta</th>
                <th width="10%">Jumlah Benar</th>
                <th width="10%">Nilai</th>
                <th width="10%">Nilai Bobot</th>
                <th width="20%">Force Submit</th>
                <th width="10%">Aksi</th>
              </tr>
            </thead>

            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="addTime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel" class="fw-bold"><i class="fas fa-clock"></i> Tambah Waktu Ujian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form name="f_addtime" id="f_addtime" onsubmit="return addTime_s();">
          <input type="hidden" name="id" id="id" value="0">
          <div class="form-group row">
            <label for="nama" class="col-sm-3 col-form-label col-form-label">Nama</label>
            <div class="col-sm-9">
              <input type="text" class="form-control fw-bold" name="nama" id="nama" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="nopes" class="col-sm-3 col-form-label col-form-label">No. Peserta</label>
            <div class="col-sm-9">
              <input type="text" class="form-control fw-bold" name="nopes" id="nopes" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="nopes" class="col-sm-3 col-form-label col-form-label">Waktu</label>
            <div class="col-sm-3">
              <input type="number" class="form-control fw-bold" name="waktu" id="waktu" placeholder="menit">
            </div>
            <div class="col-sm-6">
              <input type="text" class="form-control fw-bold" name="selesai" id="selesai" readonly>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-primary fw-bold"><i class="fa fa-check"></i> Simpan</button>
        <button class="btn btn-sm btn-danger fw-bold" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div>