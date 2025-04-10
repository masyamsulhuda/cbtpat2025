<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12 mb-4">
              <span class="fw-bold">Halaman Import Soal Pilihan Ganda</span> <br> <small>
                Halaman ini digunakan untuk mengimport soal pilihan ganda/multiple choice. Silahkan lakukan copy soal sesuai format yang sudah ditentukan, kemudian paste soal pada input area ini! Kemudian setting/pilih guru, mata pelajaran, dan kelas untuk soal yang akan dimport ke database.
              </small>
            </div>
            <div class="col-md-12 mb-4">
              <?php echo form_open(base_url() . 'adm/konfirmasi', 'id="form-konfirmasi"'); ?>
              <div class="row ">
                <input type="hidden" name="id" id="id" value="0">
                <div class="col-sm-4 text-left">
                  <div class="form-group form-group-default fgsoal bg-dop">
                    <label class="text-primary fw-bold"><i class="fa fa-user-plus"></i> GURU</label>
                    <?php echo form_dropdown('id_guru', $p_guru, '', 'class="form-control fw-bold" name="id_guru" id="id_guru" required'); ?>
                  </div>
                </div>
                <div class="col-sm-4 text-left">
                  <div class="form-group form-group-default fgsoal bg-dop">
                    <label class="text-primary fw-bold"><i class="fa fa-archive"></i> MATA PELAJARAN</label>
                    <?php echo form_dropdown('id_mapel', $p_mapel, '', 'class="form-control fw-bold" name="id_mapel" id="id_mapel" required'); ?>
                  </div>
                </div>
                <div class="col-sm-4 text-left">
                  <div class="form-group form-group-default fgsoal bg-dop">
                    <label class="text-primary fw-bold"><i class="fa fa-building"></i> KELAS</label>
                    <?php echo form_dropdown('id_kelas', $p_kelas, '', 'class="form-control fw-bold" name="id_kelas" id="id_kelas" required'); ?>
                  </div>
                </div>
              </div>
              <textarea class="textarea" id="import_soal" name="import_soal" required></textarea>
            </div>
            <div class="col-md-12 box-footer">
              <button type="submit" class="btn btn-primary fw-bold" id="btn-konfirmasi"><i class="fa fa-check"></i> Simpan</button>
              <a href="<?php echo base_url(); ?>adm/importword" class="btn btn-default fw-bold"><i class="fa fa-minus-circle"></i> Kembali</a>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row col-md-12">
            <h2 class="mb-0">Lihat Review Soal</h2>
          </div>
          <div class="row col-md-12 mt-4" id="daftar-soal">
            <?php
            echo json_decode($aa)->soal;
            ?>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>