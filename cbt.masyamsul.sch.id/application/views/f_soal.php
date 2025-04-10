<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Bank Soal</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar">
            <a href="<?php echo base_url(); ?>adm/m_soal/import"><button class='btn btn-warning btn-xs m-1 fw-bold'><i class="fa fa-cloud-upload" aria-hidden="true"></i><span class="d-none d-md-block">Import</span></button></a>
          </div>
        </div>
        <div class="card-body">
          <?php echo form_open_multipart(base_url() . "adm/m_soal/simpan", "class='form-horizontal'"); ?>
          <div class="row">
            <input type="hidden" name="id" id="id" value="<?php echo $d['id']; ?>">
            <input type="hidden" name="mode" id="mode" value="<?php echo $d['mode']; ?>">
            <div id="konfirmasi" class="col-sm-12"></div>
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default fgsoal bg-dop">
                <label class="text-danger fw-bold"><i class="fa fa-archive"></i> MATA PELAJARAN</label>
                <?php echo form_dropdown('id_mapel', $p_mapel, $d['id_mapel'], 'class="form-control fw-bold" id="id_mapel" required'); ?>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default fgsoal bg-dop">
                <label class="text-danger fw-bold"><i class="fa fa-male"></i> GURU MATA PELAJARAN</label>
                <?php echo form_dropdown('id_guru', $p_guru, $d['id_guru'], 'class="form-control fw-bold" id="id_guru" required'); ?>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default fgsoal bg-dop">
                <label class="text-danger fw-bold"><i class="fa fa-building"></i> KELAS</label>
                <?php echo form_dropdown('id_kelas', $p_kelas, $d['id_kelas'], 'class="form-control fw-bold" id="id_kelas" required'); ?>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default fgsoal bg-dop">
                <label class="text-danger fw-bold">JENIS SOAL</label>
                <select class="form-control fw-bold" name="jenisSoal" id="jenisSoal" onchange="opsiPilihan()" required>
                  <?php
                  foreach ($jenisSoal as $idjs => $js) {
                    if ($idjs == $d['jenis_soal']) {
                      echo '<option value="' . $idjs . '"selected>' . $js . '</option>';
                    } else {
                      echo '<option value="' . $idjs . '">' . $js . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default fgsoal bg-dop">
                <label class="text-danger fw-bold">BOBOT SOAL</label>
                <input type="number" name="bobot" class="form-control fw-bold" required value="<?php echo $d['bobot']; ?>">
              </div>
            </div>
            <div class="col-sm-4 text-left kunciJawabanPG">
              <div class="form-group form-group-default fgsoal bg-dop">
                <label class="text-danger fw-bold">KUNCI JAWABAN</label>
                <select class="form-control fw-bold" name="jawaban" id="jawaban" required>
                  <option value="">--Pilih Kunci Jawaban--</option>
                  <?php
                  for ($o = 0; $o < $aplikasi['ujian_opsi']; $o++) {
                    $_opsi = strtoupper($huruf_opsi[$o]);
                    if ($d['jawaban'] == $_opsi) {
                      echo '<option value="' . $_opsi . '" selected>' . $_opsi . '</option>';
                    } else {
                      echo '<option value="' . $_opsi . '">' . $_opsi . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4 text-left kunciJawabanQA">
              <div class="form-group form-group-default fgsoal bg-dop">
                <label class="text-danger fw-bold">JAWABAN QUICK ANSWER</label>
                <input type="text" name="jwbQa" id="jwbQa" class="form-control fw-bold" required value="<?php echo $d['jawaban']; ?>" placeholder="Masukkan jawaban singkat">
              </div>
            </div>
          </div>
          <hr>
          <div class="row mb-2">
            <div class="col-sm-4 text-left">
              <div class="form-group form-group-default">
                <label class="text-primary fw-bold">TEKS SOAL & UPLOAD FILE</label>
                <input type="file" name="gambar_soal" id="gambar_soal" class="form-control fw-bold upload">
                <?php
                if (is_file('./upload/gambar_soal/' . $d['file'])) {
                  echo '<br/>';
                  echo tampil_media('./upload/gambar_soal/' . $d['file'], "100%");
                  echo '<br/>';
                }
                ?>
                <small class="text-muted">* Upload jika terdapat gambar pada soal! </small><br>
              </div>
            </div>
            <div class="col-sm-8 text-left">
              <textarea class="form-control" id="editornya" style="height: 50px;" name="soal"><?php echo $d['soal']; ?></textarea>
            </div>
          </div>
          <?php
          for ($j = 0; $j < $aplikasi['ujian_opsi']; $j++) {
            $idx = $huruf_opsi[$j];
          ?>
            <div class="row fgsoal opsiPilihan mb-2">
              <div class="col-sm-4 text-left">
                <div class="form-group form-group-default">
                  <label class="text-success fw-bold">JAWABAN <?php echo $huruf_opsi[$j]; ?> & UPLOAD FILE</label>
                  <input type="file" name="gj<?php echo $huruf_opsi[$j]; ?>" id="gambar_soal" class="form-control fw-bold upload"><br>
                  <?php
                  if (is_file('./upload/gambar_opsi/' . $data_pc[$idx]['gambar'])) {
                    echo '<br/>';
                    echo tampil_media('./upload/gambar_opsi/' . $data_pc[$idx]['gambar'], "100%");
                    echo '<br/>';
                  }
                  ?>
                  <small class="text-muted">* Upload jika terdapat gambar pada jawaban! </small><br>
                </div>
              </div>
              <div class="col-sm-8 text-left">
                <textarea class="form-control" id="editornya_<?php echo $huruf_opsi[$j]; ?>" style="height: 30px" name="opsi_<?php echo $huruf_opsi[$j]; ?>"><?php echo $data_pc[$idx]['opsi']; ?></textarea>
              </div>
            </div>
          <?php } ?>
          <hr>
          <div class="row">
            <div class="col-sm-12 text-left">
              <button type="submit" class="btn btn-primary fw-bold"><i class="fa fa-check"></i> Simpan</button>
              <a href="<?php echo base_url(); ?>adm/m_soal/pilih_mapel/<?php echo $d['id_mapel']; ?>" class="btn btn-default fw-bold"><i class="fa fa-minus-circle"></i> Kembali</a>
            </div>
          </div>
        </div>
        </form>
      </div><!-- panel body-->
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var x = document.getElementById("jenisSoal").value;
    if (x == "multiple") {
      $('.kunciJawabanPG').fadeIn("slow");
      $('.kunciJawabanQA').fadeOut("slow");
      document.getElementById('jwbQa').required = false;
      document.getElementsByClassName("opsiPilihan")[0].removeAttribute("style");
      document.getElementsByClassName("opsiPilihan")[1].removeAttribute("style");
      document.getElementsByClassName("opsiPilihan")[2].removeAttribute("style");
      document.getElementsByClassName("opsiPilihan")[3].removeAttribute("style");
      if (jml_opsi > 4) {
        document.getElementsByClassName("opsiPilihan")[4].removeAttribute("style");
      }
    } else if (x == "quick") {
      document.getElementById('jawaban').required = false;
      $('.opsiPilihan').fadeOut("slow");
      $('.kunciJawabanPG').fadeOut("slow");
      $('.kunciJawabanQA').fadeIn("slow");
    } else {
      $('.opsiPilihan').fadeOut("slow");
      $('.kunciJawabanPG').fadeOut("slow");
      $('.kunciJawabanQA').fadeOut("slow");
    }
  });
  jml_opsi = "<?php echo $aplikasi['ujian_opsi']; ?>"
</script>