<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Daftar Ujian</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="#"><button class="btn btn-xs btn-success m-1 fw-bold" onclick="return m_ujian_e(0);"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="d-none d-md-block">Tambah</span></button></a>
            <a href="<?php echo base_url(); ?>adm/h_ujian"> <button class="btn btn-xs btn-secondary m-1 fw-bold"><i class="fa fa-eye" aria-hidden="true"></i><span class="d-none d-md-block">Hasil Ujian</span></button></a>
          </div>
        </div>
        <div class="table-responsive pb-3" style="overflow-x:auto;">
          <table id="datatabel" class="table table-striped table-bordered table-hover" cellspacing="0" style="width: 100%;">
            <thead class="bg-secondary">
              <tr class="text-white text-center">
                <th width="5%">No</th>
                <th>Rincian Ujian</th>
                <th>Jumlah Soal</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Token</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="m_ujian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel" class="fw-bold"><i class="fas fa-certificate"></i> PENGATURAN UJIAN</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-primary">
          <a href="#" onclick="return view_petunjuk('petunjuk');"><b>PETUNJUK PEMBUATAN UJIAN</b></a>
          <ul class="mb-0">
            <li><b>Jumlah Soal</b>, masukkan sesuai jumlah soal di bank soal</li>
            <li><b>Mulai Ujian</b>, waktu awal boleh mulai meng-klik tombol "mulai ujian"</li>
            <li><b>Selesai Ujian</b>, waktu akhir boleh mulai meng-klik tombol "mulai ujian"</li>
            <li><b>Acak Soal</b>, jika dipilih acak, maka soal akan diacak, jika diurutkan, maka akan diurutkan berdasarkan urutan soal masuk</li>
          </ul>
        </div>
        <form name="f_ujian" id="f_ujian" onsubmit="return m_ujian_s();">
          <div class="row">
            <input type="hidden" name="id" id="id" value="0">
            <input type="hidden" name="jumlah_soal1" id="jumlah_soal1" value="0">
            <div class="col-sm-8 text-left">
              <div class="form-group form-group-default bg-dop">
                <label class="text-secondary fw-bold"> Nama Ujian</label>
                <input type="text" class="form-control fw-bold" name="nama_ujian" id="nama_ujian" placeholder="Masukkan Nama Ujian" required>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default">
                <label class="fw-bold"> Acak Soal</label>
                <?php echo form_dropdown('acak', $pola_tes, '', 'class="form-control fw-bold" id="acak" required'); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default">
                <label class="fw-bold"><i class="fas fa-archive"></i> Mata Pelajaran</label>
                <?php echo form_dropdown('mapel', $p_mapel, '', 'class="form-control fw-bold"  id="mapel" required'); ?>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default">
                <label class="fw-bold"><i class="fas fa-building"></i> Kelas</label>
                <select name="kelas" id="kelas" class="form-control fw-bold" required>
                  <option value="">-- Pilih --</option>
                  <?php foreach ($kelas as $baris) : ?>
                    <option value="<?php echo $baris->kelas; ?>"><?php echo $baris->kelas; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default">
                <label class="fw-bold"><i class="fas fa-bookmark"></i> Jurusan</label>
                <select name="jurusan" id="jurusan" class="form-control fw-bold" required>
                  <option value="">-- Pilih --</option>
                  <?php foreach ($jurusan as $baris) : ?>
                    <option value="<?php echo $baris->jurusan; ?>"><?php echo $baris->jurusan; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default">
                <label class="fw-bold"><i class="fas fa-clock"></i> Durasi</label>
                <input type="text" class="form-control fw-bold" name="waktu" id="waktu" placeholder="Menit" required>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default">
                <label class="fw-bold"><i class="fas fa-clock"></i> Waktu Submit</label>
                <input type="text" class="form-control fw-bold" name="waktu_submit" id="waktu_submit" placeholder="Menit" required>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default">
                <label class="fw-bold"><i class="fas fa-clock"></i> Jumlah Soal</label>
                <input type="text" class="form-control fw-bold" name="jumlah_soal" id="jumlah_soal" placeholder="Jumlah Soal" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 text-left p-1">
              <div class="form-group">
                <label class="text-success">Mulai Ujian</label>
                <div class="input-group">
                  <input type="date" name='tgl_mulai' class="col-sm-7 form-control form-control-sm fw-bold" id="tgl_mulai" required>
                  <input type="time" name='wkt_mulai' class="col-sm-5 bg-success text-white form-control form-control-sm fw-bold" id="wkt_mulai" required>
                </div>
              </div>
            </div>
            <div class="col-sm-4 text-left p-1">
              <div class="form-group">
                <label class="text-danger">Selesai Ujian</label>
                <div class="input-group">
                  <input type="date" name='terlambat' class="col-sm-7 form-control form-control-sm fw-bold" id="terlambat" placeholder="Tgl" data-tooltip="waktu awal boleh menge-klik tombol" required>
                  <input type="time" name='terlambat2' class="col-sm-5 bg-danger text-white form-control form-control-sm fw-bold" id="terlambat2" placeholder="Waktu" required>
                </div>
              </div>
            </div>
            <div class="col-sm-12 text-left mb-0" id="jmlsoal"></div>
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