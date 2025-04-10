<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Data Mata Pelajaran</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="#"><button class="btn btn-xs btn-success m-1 fw-bold" onclick="return m_mapel_e(0);"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="d-none d-md-block">Tambah</span></button></a>
            <a href='<?php echo base_url(); ?>adm/m_kelas'><button class='btn btn-primary btn-xs m-1 fw-bold'><i class="fa fa-building" aria-hidden="true"></i><span class="d-none d-md-block">&nbsp; Kelas &nbsp;</span></button></a>
            <a href='<?php echo base_url(); ?>adm/m_jurusan'><button class='btn btn-secondary btn-xs m-1 fw-bold'><i class="fa fa-bookmark" aria-hidden="true"></i><span class="d-none d-md-block">Jurusan</span></button></a>
          </div>
        </div>
        <div class="table-responsive pb-3" style="overflow-x:auto;">
          <table id="datatabel" class="table table-striped table-bordered table-hover" cellspacing="0" style="width: 100%;">
            <thead class="bg-success">
              <tr class="text-white text-center">
                <th width="5%">No</th>
                <th width="75%">Mata Pelajaran</th>
                <th width="20%">Aksi</th>
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
<div class="modal fade" id="m_mapel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel" class="fw-bold"><i class="fas fa-archive"></i> Data Mata Pelajaran</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form name="f_mapel" id="f_mapel" onsubmit="return m_mapel_s();">
          <input type="hidden" name="id" id="id" value="0">
          <div class="form-group row">
            <label for="nama" class="col-sm-3 col-form-label col-form-label">Mata Pelajaran</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="nama" id="nama" required>
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