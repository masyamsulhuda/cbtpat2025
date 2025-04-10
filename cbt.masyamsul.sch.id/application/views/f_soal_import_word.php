<style type="text/css">
  .ajax-loading {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: #6f6464;
    opacity: 0.75;
    color: #fff;
    text-align: center;
    font-size: 25px;
    padding-top: 200px;
    display: none;
  }
</style>
<div class="page-inner" id="openword">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Import Data Soal</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="<?php echo base_url(); ?>upload/format_soal_download.docx"> <button class="btn btn-xs btn-primary m-1 fw-bold"><i class="fa fa-file-word-o" aria-hidden="true"></i><span class="d-none d-md-block">Download</span></button></a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <?php echo $this->session->flashdata('notifikasi'); ?>
            <div class="col-sm-12 mb-4">
              <span class="fw-bold">Halaman Import Soal Pilihan Ganda</span> <br> <small>
                Halaman ini digunakan untuk mengimport soal pilihan ganda/multiple choice. Silahkan lakukan copy soal sesuai format yang sudah ditentukan, kemudian paste soal pada input area ini! Setelah itu klik tombol preview untuk melihat hasil import sebelum disimpan ke dalam database.
              </small>
            </div>
            <div class="col-sm-12">
              <!-- <?php echo form_open(base_url() . 'adm/toimport', 'id="form-importsoal"'); ?> -->
              <?php echo form_open(base_url() . 'adm/c_import', 'id="form-importsoal"'); ?>
              <input type="hidden" name="topik" id="topik" value="coba import">
              <input type="hidden" name="import-soal" id="import-soal">
              <textarea class="textarea" id="import_soal" name="import_soal"></textarea>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <a href="<?php echo base_url(); ?>adm/m_soal" class="btn btn-default fw-bold"><i class="fa fa-minus-circle"></i> Kembali</a>
          <button type="submit" class="btn btn-primary fw-bold pull-right" id="c_import"><i class="fa fa-play-circle" aria-hidden="true"></i> Preview</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="page-inner" id="reopenword">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Import Data Soal</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="<?php echo base_url(); ?>upload/format_soal_download.docx"> <button class="btn btn-xs btn-primary m-1 fw-bold"><i class="fa fa-file-word-o" aria-hidden="true"></i><span class="d-none d-md-block">Download</span></button></a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h3 class="mb-2 fw-bold">Setting Identitas Soal</h3>
              <?php echo form_open(base_url() . 'adm/konfirmasi', 'id="form-konfirmasi"'); ?>
              <div class="row ">
                <input type="hidden" name="id" id="id" value="0">
                <input type="hidden" name="konfirmasi-import-soal" id="konfirmasi-import-soal">
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
            </div>
            <div class="col-md-12 box-footer">
              <button type="submit" class="btn btn-primary fw-bold" id="btn-konfirmasi"><i class="fa fa-check"></i> Simpan</button>
              <a href="<?php echo base_url(); ?>adm/importword" class="btn btn-default fw-bold"><i class="fa fa-minus-circle"></i> Kembali</a>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12">
              <span class="fw-bold">Lihat Preview Soal</span><br>
              <p class="text-muted small">
                Halaman ini digunakan untuk melihat preview setiap pertanyaan. Jika soal sudah sesuai, langkah selanjutnya soal bisa diimport ke dalam database dengan setting identitas soal diatas.
              </p>
            </div>
            <div class="col-md-12" id="daftar-soal">
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<div class="ajax-loading"><i class="fa fa-spin fa-spinner"></i> Mohon Bersabar ...</div>
<script>
  $(document).ready(function() {
    $('#reopenword').hide();
    $(function() {
      $('#form-importsoal').submit(function() {
        $('#import-soal').val(CKEDITOR.instances.import_soal.getData());
        $('.ajax-loading').show();
        $.ajax({
          type: "POST",
          url: base_url + "adm/c_import",
          timeout: 300000,
          data: $('#form-importsoal').serialize(),
          cache: false,
          // contentType: "text/html; charset=utf-8",
          success: function(respon) {
            var obj = $.parseJSON(respon);
            if (obj.status == 1) {
              $('#openword').hide();
              $('.ajax-loading').hide();
              $('#reopenword').show();
              $('#konfirmasi-import-soal').val($('#import-soal').val());
              $('#daftar-soal').html(obj.soal);
              $('#box-konfirmasi').removeClass('hide');
            } else {
              console.log("gagal");
            }
          }
        });
        return false;
      })
    })
  });
</script>