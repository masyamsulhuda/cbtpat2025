<div class="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h3 class="card-title mb-0 font-weight-bold">Import Data Soal</h3>
                        <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
                    </div>
                    <div class="btn-toolbar">
                        <a href="<?php echo base_url(); ?>upload/format_soal_download.xlsx"> <button class="btn btn-xs btn-default m-1 fw-bold"><i class="fa fa-cloud-download" aria-hidden="true"></i><span class="d-none d-md-block">Download</span></button></a>
                        <a href="<?php echo base_url(); ?>adm/importword"> <button class="btn btn-xs btn-primary m-1 fw-bold"><i class="fa fa-file-word-o" aria-hidden="true"></i><span class="d-none d-md-block"> Import Word</span></button></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <span class="fw-bold">Halaman Import Data Soal</span> <br> <small>
                                Halaman ini digunakan untuk mengimport soal pilihan ganda/multiple choice dalam format excel. Silahkan download file template soal pada sistem yang sudah disediakan.
                            </small>
                        </div>
                    </div>
                    <form name="f_siswa" action="<?php echo base_url(); ?>import/soal" id="f_siswa" enctype="multipart/form-data" method="post">
                        <div class="row">
                            <input type="hidden" name="id" id="id" value="0">
                            <div class="col-sm-4 text-left">
                                <div class="form-group form-group-default fgsoal bg-dop">
                                    <label class="text-success fw-bold"><i class="fa fa-user-plus"></i> GURU</label>
                                    <?php echo form_dropdown('id_guru', $p_guru, '', 'class="form-control fw-bold" id="id_guru" required'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4 text-left">
                                <div class="form-group form-group-default fgsoal bg-dop">
                                    <label class="text-success fw-bold"><i class="fa fa-archive"></i> MATA PELAJARAN</label>
                                    <?php echo form_dropdown('id_mapel', $p_mapel, '', 'class="form-control fw-bold" id="id_mapel" required'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4 text-left">
                                <div class="form-group form-group-default fgsoal bg-dop">
                                    <label class="text-success fw-bold"><i class="fa fa-building"></i> KELAS</label>
                                    <?php echo form_dropdown('id_kelas', $p_kelas, '', 'class="form-control fw-bold" id="id_kelas" required'); ?>
                                </div>
                            </div>
                            <div class="col-sm-12 text-left">
                                <div class="form-group form-group-default bg-dop">
                                    <label class="text-success fw-bold"><i class="fa fa-cloud-download" aria-hidden="true"></i> UPLOAD FILE TEMPLATE SOAL</label>
                                    <br>
                                    <input type="file" class="form-control col-md-12 fw-bold" name="import_excel" required>
                                    <br>
                                    <small class="text-muted fw-bold">* Upload file harus menggunakan template pada aplikasi ini! </small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12 text-left">
                                <button type="submit" class="btn btn-primary fw-bold"><i class="fa fa-check"></i> Simpan</button>
                                <a href="<?php echo base_url(); ?>adm/m_soal" class="btn btn-default fw-bold"><i class="fa fa-minus-circle"></i> Kembali</a>
                            </div>
                        </div>
                        <!-- <table class="table table-form">
                            <tr>
                                <td style="width: 25%">Guru</td>
                                <td style="width: 75%">
                                    <?php echo form_dropdown('id_guru', $p_guru, '', 'class="form-control" id="id_guru" required'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Mata Pelajaran</td>
                                <td><?php echo form_dropdown('id_mapel', $p_mapel, '', 'class="form-control" id="id_mapel" required'); ?></td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td><?php echo form_dropdown('id_kelas', $p_kelas, '', 'class="form-control" id="id_kelas" required'); ?></td>
                            </tr>
                            <tr>
                                <td>File</td>
                                <td><input type="file" class="form-control col-md-3" name="import_excel" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                                    <a href="<?php echo base_url(); ?>adm/m_soal" class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
                                </td>
                            </tr>
                        </table> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>