<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Atur Ruang Peserta</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="<?php echo base_url(); ?>adm/m_ruangan" class="btn btn-xs btn-success m-1 fw-bold"><i class="fa fa-building" aria-hidden="true"></i><span class="d-none d-md-block">Daftar Ruangan</span></button></a>
          </div>
        </div>
        <?php echo form_open_multipart(base_url() . "adm/m_ruang/simpan_ruang_siswa", "class='form-horizontal'"); ?>
        <div class="table-responsive pb-3" style="overflow-x:auto;">
          <table id="datatabel" class="table table-striped table-bordered table-hover" cellspacing="0" style="width: 100%;">
            <thead class="bg-primary">
              <tr class="text-white text-center">
                <th>No</th>
                <th>Pilih</th>
                <th>Nama</th>
                <th>No. Peserta</th>
                <th>NIS</th>
                <th>Tingkat</th>
                <th>Ruang</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <hr class="mb-0">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-6 mt-3 mb-3">
                <span class="font-weight-bold small">Daftar Ruangan</span>
                <select name="ruangan" id="ruangan" class="form-control form-control-sm font-weight-bold" required>
                  <option value="">--Pilih Ruangan--</option>
                  <?php
                  foreach ($ruangan as $a) {
                    echo "<option value='$a[ruang_id]'>$a[ruang_nama]</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-6 mt-3 mb-3">
                <span class="font-weight-bold">Setting Ruangan</span> <br> <small>
                  Buat ruangan terlebih dahulu, kemudian pilih siswa untuk dimasukkan ke dalam ruang yang sudah dibuat!
                </small>
              </div>
            </div>
          </div>
          <div class="btn-group pull-left ml-3">
            <button type="submit" class="btn btn-primary fw-bold"><i class="fa fa-check"></i> Simpan</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>