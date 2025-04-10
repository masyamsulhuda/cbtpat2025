<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Data Siswa</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="#"><button onclick="return aktifkan_semua_siswa();" class="btn btn-xs btn-primary m-1 fw-bold"><i class="fa fa-user-plus" aria-hidden="true"></i><span class="d-none d-md-block">ActiveAll</span></button></a>
            <?php if ($this->session->userdata('admin_level') == 'admin') { ?>
              <a href="#"> <button onclick="return m_siswa_e(0);" class="btn btn-xs btn-success m-1 fw-bold"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="d-none d-md-block">Tambah</span></button></a>
              <a href="<?php echo base_url(); ?>adm/m_siswa/import"> <button class="btn btn-xs btn-warning m-1 fw-bold"><i class="fa fa-cloud-upload" aria-hidden="true"></i><span class="d-none d-md-block">Import</span></button></a>
              <a href="#"> <button onclick="return m_siswa_hs();" class="btn btn-xs btn-danger m-1 fw-bold"><i class="fa fa-user-times" aria-hidden="true"></i><span class="d-none d-md-block">DeleteAll</span></button></a>
            <?php } ?>
          </div>
        </div>
        <div class="table-responsive pb-3" style="overflow-x:auto;">
          <table id="datatabel" class="table table-striped table-bordered table-hover" cellspacing="0" style="width: 100%;">
            <thead class="bg-warning">
              <tr class="text-white text-center">
                <th>No</th>
                <th>Nama</th>
                <th>Sandi</th>
                <th>No. Peserta</th>
                <th>NIS</th>
                <th>Tingkat</th>
                <th>Jurusan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button name="updateNIS" type="submit" class="btn btn-sm btn-primary fw-bold"><i class="fa fa-check"></i> Simpan</button>
          <button type="button" class="btn btn-sm btn-danger fw-bold" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="m_siswa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel" class="fw-bold"><i class="fas fa-user-plus"></i> Data Siswa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form name="f_siswa" id="f_siswa" onsubmit="return m_siswa_s();">
          <input type="hidden" name="id" id="id" value="0">
          <div class="form-group row">
            <label for="nama" class="col-sm-3 col-form-label col-form-label">Nama</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="nama" id="nama" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="nopes" class="col-sm-3 col-form-label col-form-label">No. Peserta</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="nopes" id="nopes" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="nis" class="col-sm-3 col-form-label col-form-label">NIS</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" name="nim" id="nim" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="kelas" class="col-sm-3 col-form-label col-form-label">Kelas/Tingkat</label>
            <div class="col-sm-9">
              <select name="jurusan" id="jurusan" class="form-control" required>
                <option value="">-- pilih kelas/tingkat --</option>
                <?php foreach ($kelas as $baris) : ?>
                  <option value="<?php echo $baris->kelas; ?>"><?php echo $baris->kelas; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="jurusan" class="col-sm-3 col-form-label col-form-label">Jurusan</label>
            <div class="col-sm-9">
              <select name="id_jurusan" id="id_jurusan" class="form-control" required>
                <option value="">-- pilih jurusan --</option>
                <?php foreach ($jurusan as $baris) : ?>
                  <option value="<?php echo $baris->jurusan; ?>"><?php echo $baris->jurusan; ?></option>
                <?php endforeach; ?>
              </select>
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

<!-- cetak absensi -->
<!-- <div class="modal fade" id="m_siswa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel" class="fw-bold"><i class="fas fa-user-plus"></i> Data Siswa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form name="f_siswa" id="f_siswa" onsubmit="return m_siswa_s();">
          <input type="hidden" name="id" id="id" value="0">
          <div class="form-group row">
            <label for="kelas" class="col-sm-3 col-form-label col-form-label">Kelas/Tingkat</label>
            <div class="col-sm-9">
              <select name="jurusan" id="jurusan" class="form-control" required>
                <option value="">-- pilih kelas/tingkat --</option>
                <?php foreach ($kelas as $baris) : ?>
                  <option value="<?php echo $baris->kelas; ?>"><?php echo $baris->kelas; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="jurusan" class="col-sm-3 col-form-label col-form-label">Jurusan</label>
            <div class="col-sm-9">
              <select name="id_jurusan" id="id_jurusan" class="form-control" required>
                <option value="">-- pilih jurusan --</option>
                <?php foreach ($jurusan as $baris) : ?>
                  <option value="<?php echo $baris->jurusan; ?>"><?php echo $baris->jurusan; ?></option>
                <?php endforeach; ?>
              </select>
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
</div> -->