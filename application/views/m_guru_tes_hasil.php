<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Monitoring Hasil Ujian</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="<?php echo base_url(); ?>adm/m_ujian"> <button class="btn btn-xs btn-secondary m-1 fw-bold"><i class="fa fa-pencil-square" aria-hidden="true"></i><span class="d-none d-md-block">Daftar Ujian</span></button></a>
          </div>
        </div>
        <div class="table-responsive pb-3" style="overflow-x:auto;">
          <table id="datatabel" class="table table-striped table-bordered table-hover" cellspacing="0" style="width: 100%;">
            <thead class="bg-danger">
              <tr class="text-white text-center">
                <th>No</th>
                <th>Tanggal</th>
                <th>Kelas</th>
                <th>Nama Tes</th>
                <th>Proktor</th>
                <th>Mata Pelajaran</th>
                <th>Jumlah Soal</th>
                <th>Waktu</th>
                <th>Aksi</th>
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