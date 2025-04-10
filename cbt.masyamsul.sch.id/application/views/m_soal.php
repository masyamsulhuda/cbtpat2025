<?php
$uri4 = $this->uri->segment(4);
?>
<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Bank Soal</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="<?php echo base_url(); ?>adm/m_soal/edit/0"><button class='btn btn-success btn-xs m-1 fw-bold'><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="d-none d-md-block">Tambah</span></button></a>
            <a href="<?php echo base_url(); ?>adm/m_soal/import"><button class='btn btn-warning btn-xs m-1 fw-bold'><i class="fa fa-cloud-upload" aria-hidden="true"></i><span class="d-none d-md-block">Import</span></button></a>
            <a href='<?php echo base_url(); ?>adm/m_soal/cetak/<?php echo $uri4; ?>' target='_blank'><button class='btn btn-primary btn-xs m-1 fw-bold'><i class="fa fa-print" aria-hidden="true"></i><span class="d-none d-md-block">Cetak</span></button></a>
            <?php if ($this->session->userdata('admin_level') == 'admin') { ?>
              <a href="#"> <button onclick="return m_soal_hs();" class="btn btn-xs btn-danger m-1 fw-bold"><i class="fa fa-archive" aria-hidden="true"></i><span class="d-none d-md-block">DeleteAll</span></button></a>
            <?php } ?>
          </div>
        </div>
        <?php echo $this->session->flashdata('k'); ?>
        <div class="table-responsive pb-3" style="overflow-x:auto;">
          <table id="datatabel" class="table table-striped table-bordered table-hover" cellspacing="0" style="width: 100%;">
            <thead class="bg-primary">
              <tr class="text-white text-center">
                <th>No</th>
                <!-- <th>Pilih</th> -->
                <th>Jenis</th>
                <th>Soal</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <!-- <th>Analisis Soal</th> -->
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <!-- <hr class="mb-0">
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
          </div> -->
        </div>
      </div>
    </div>
  </div>
</div>