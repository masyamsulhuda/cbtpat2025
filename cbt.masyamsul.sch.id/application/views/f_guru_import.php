<div class="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h3 class="card-title mb-0 font-weight-bold">Import Data Guru</h3>
                        <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
                    </div>
                    <div class="btn-toolbar">
                        <a href="<?php echo base_url(); ?>upload/format_import_guru.xlsx"> <button class="btn btn-xs btn-default m-1 fw-bold"><i class="fa fa-cloud-download" aria-hidden="true"></i><span class="d-none d-md-block">Download</span></button></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <span class="fw-bold">Halaman Import Data guru</span> <br> <small>
                                Template file harus menggunakan template pada aplikasi ini!
                            </small>
                        </div>
                    </div>
                    <form name="f_siswa" action="<?php echo base_url(); ?>import/guru" id="f_siswa" enctype="multipart/form-data" method="post">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="0">
                            <div class="col-sm-12 text-left">
                                <div class="form-group form-group-default bg-dop">
                                    <label class="text-secondary fw-bold"><i class="fa fa-cloud-download" aria-hidden="true"></i> UPLOAD FILE TEMPLATE GURU</label>
                                    <br>
                                    <input type="file" class="form-control" name="import_excel" required>
                                    <br>
                                    <small class="text-muted fw-bold">* Upload file harus menggunakan template pada aplikasi ini! </small>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-left">
                            <button type="submit" class="btn btn-primary fw-bold"><i class="fa fa-check"></i> Simpan</button>
                            <a href="<?php echo base_url(); ?>adm/m_guru" class="btn btn-default fw-bold"><i class="fa fa-minus-circle"></i> Kembali</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>