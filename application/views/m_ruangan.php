<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Data Ruangan</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="#"><button class="btn btn-xs btn-success m-1 fw-bold" onclick="return m_ruangan_e(0);"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="d-none d-md-block">Tambah</span></button></a>
            <a href='<?php echo base_url(); ?>adm/m_ruang'><button class='btn btn-primary btn-xs m-1 fw-bold'><i class="fa fa-building" aria-hidden="true"></i><span class="d-none d-md-block">&nbsp; Set Ruangan &nbsp;</span></button></a>
          </div>
        </div>
        <div class="table-responsive pb-3" style="overflow-x:auto;">
          <table id="datatabel" class="table table-striped table-bordered table-hover" cellspacing="0" style="width: 100%;">
            <thead class="bg-success">
              <tr class="text-white text-center">
                <th width="5%">No</th>
                <th width="50%">Nama Ruangan</th>
                <th width="20%">ID Server</th>
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
<div class="modal fade" id="m_ruangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel" class="fw-bold"><i class="fas fa-building"></i> Data Ruangan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form name="f_ruangan" id="f_ruangan" onsubmit="return m_ruangan_s();">
          <input type="hidden" name="ruangan_id" id="ruangan_id" value="0">
          <div class="form-group row">
            <label for="ruangan_nama" class="col-sm-3 col-form-label col-form-label">Ruangan</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="ruangan_nama" id="ruangan_nama" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="ruangan_server" class="col-sm-3 col-form-label col-form-label">ID Server</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="ruangan_server" id="ruangan_server" required>
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