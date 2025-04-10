<?php
$tahun = $lembaga['tahunajaran_id'];
$tahunpelajaran = $tahun . '/' . ($tahun + 1)
?>
<div class="page-inner">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="mt-2">
                        <h4 class="card-title fw-bold">Data Lembaga</h4>
                        <div class="small text-muted fw-bold"><?php echo $lembaga['lembaga_profile']; ?></div>
                        <div class="small text-muted"><?php echo $lembaga['lembaga_alamat']; ?></div>
                    </div>
                    <div class="btn-toolbar">
                        <ul class="nav nav-sm nav-pills nav-warning nav-pills-no-bd nav-pills-icons justify-content-center font-weight-bold" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="a-tab" data-toggle="tab" href="#a" role="tab" aria-controls="a" aria-selected="true"><i class="fas fa-chalkboard"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="b-tab" data-toggle="tab" href="#b" role="tab" aria-controls="b" aria-selected="false"><i class="fas fa-building"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="a" role="tabpanel" aria-labelledby="a-tab">
                            <?php echo $this->session->flashdata('k'); ?>
                            <span class="fw-bold">Pengaturan Aplikasi & Ujian</span> <br><small>
                                Halaman ini digunakan untuk menentukan nama aplikasi, versi & pengaturan ujian. Silahkan ubah data sesuai dengan kebutuhan. Konfigurasi ini akan digunakan sebagai setting dasar.
                            </small>
                            <form name="f_config" id="f_config" onsubmit="return config_s();">
                                <div class="row mt-4">
                                    <div class="col-sm-8 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold"><i class="fas fa-laptop"></i> NAMA APLIKASI</label>
                                            <input type="hidden" name="id" id="id" required value="<?php echo $aplikasi['settings_id']; ?>">
                                            <input type="text" name="app_name" id="app_name" class="form-control fw-bold" required value="<?php echo $aplikasi['aplikasi_nama']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold"><i class="fas fa-signature"></i> VERSI APLIKASI</label>
                                            <input type="text" name="app_versi" id="app_versi" class="form-control fw-bold" required value="<?php echo $aplikasi['aplikasi_versi']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-8 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold"><i class="fas fa-receipt"></i> NAMA UJIAN</label>
                                            <input type="text" name="tes_name" id="tes_name" class="form-control fw-bold" required value="<?php echo $aplikasi['ujian_nama']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold"><i class="fas fa-bullhorn"></i> PENGUMUMAN NILAI</label>
                                            <select name="tes_nilai" id="tes_nilai" class="form-control fw-bold" required>
                                                <?php
                                                $nilai = [
                                                    0 => 'Tidak Ditampilkan',
                                                    1 => 'Tampilkan',
                                                ];
                                                foreach ($nilai as $baris => $desc) :
                                                    if ($baris == $aplikasi['ujian_nilai']) {
                                                        echo '<option value="' . $baris . '" selected>' . $desc . '</option>';
                                                    } else {
                                                        echo '<option value="' . $baris . '">' . $desc . '</option>';
                                                    }
                                                endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold"><i class="fas fa-calendar-alt"></i> TANGGAL UJIAN</label>
                                            <input type="text" name="tes_tanggal" id="tes_tanggal" class="form-control fw-bold" required value="<?php echo $aplikasi['ujian_tanggal']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold"><i class="fas fa-tasks"></i> JUMLAH JAWABAN</label>
                                            <input type="number" name="tes_opsi" id="tes_opsi" min="4" max="5" class="form-control fw-bold" required value="<?php echo $aplikasi['ujian_opsi']; ?>">
                                        </div>
                                    </div>
                                    <div class="btn-group pull-right ml-3">
                                        <button class="btn btn-warning fw-bold"><i class="fa fa-check"></i> Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade show" id="b" role="tabpanel" aria-labelledby="b-tab">
                            <span class="fw-bold">Pengaturan Lembaga</span> <br> <small>
                                Silahkan isi kebutuhan data profil lembaga untuk digunakan dibeberapa konfigurasi aplikasi ini!
                            </small>
                            <form name="f_lembaga" id="f_lembaga" onsubmit="return lembaga_s();">
                                <div class="row mt-2">
                                    <div class="col-sm-8 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold"><i class="fas fa-building"></i> NAMA LEMBAGA</label>
                                            <input type="hidden" name="id" id="id" required value="<?php echo $aplikasi['lembaga_id']; ?>">
                                            <input required name="lembaga_nama" id="lembaga_nama" type="text" class="form-control fw-bold" value="<?php echo $lembaga['lembaga_profile']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold"> <i class="fas fa-list-ol"></i> JENJANG</label>
                                            <select name="lembaga_jenjang" id="lembaga_jenjang" class="form-control fw-bold" required>
                                                <?php foreach ($jenjang as $baris) :
                                                    if ($baris == $lembaga['lembaga_jenjang']) {
                                                        echo '<option value="' . $baris . '" selected>' . $baris . '</option>';
                                                    } else {
                                                        echo '<option value="' . $baris . '">' . $baris . '</option>';
                                                    }
                                                endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold">NPSN</label>
                                            <input required name="lembaga_npsn" id="lembaga_npsn" type="text" class="form-control fw-bold" value="<?php echo $lembaga['lembaga_npsn']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold">NSM</label>
                                            <input required name="lembaga_nsm" type="text" class="form-control fw-bold" value="<?php echo $lembaga['lembaga_nsm']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold">TAHUN</label>
                                            <input required name="lembaga_tahun" type="text" class="form-control fw-bold" value="<?php echo $lembaga['lembaga_tahun']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold">WEBSITE</label>
                                            <input required name="lembaga_web" type="text" class="form-control fw-bold" value="<?php echo $lembaga['lembaga_web']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold">EMAIL</label>
                                            <input required name="lembaga_email" type="text" class="form-control fw-bold" value="<?php echo $lembaga['lembaga_email']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold">KOTA/KABUPATEN</label>
                                            <input required name="lembaga_kota" type="text" class="form-control fw-bold" value="<?php echo $lembaga['lembaga_kota']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold">TELEPON</label>
                                            <input required name="lembaga_telp" type="text" class="form-control fw-bold" value="<?php echo $lembaga['lembaga_telp']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold"><i class="fas fa-user-shield"></i> NAMA KEPALA/KETUA</label>
                                            <input required name="lembaga_pimpinan" type="text" class="form-control fw-bold" value="<?php echo $lembaga['lembaga_pimpinan']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold"><i class="fas fa-keyboard"></i> NIP</label>
                                            <input required name="lembaga_pimpinan_nip" type="text" class="form-control fw-bold" value="<?php echo $lembaga['lembaga_pimpinan_nip']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-left">
                                        <div class="form-group form-group-default">
                                            <label class="text-primary fw-bold">ALAMAT</label>
                                            <textarea required name="lembaga_alamat" type="text" class="form-control fw-bold"><?php echo $lembaga['lembaga_alamat']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="btn-group pull-right ml-3">
                                        <button class="btn btn-warning fw-bold"><i class="fa fa-check"></i> Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card card-profile">
                <div class="card-header">
                    <div class="profile-picture">
                        <?php if ($lembaga['lembaga_foto'] != NULL) { ?>
                            <div class="avatar avatar-online avatar-xxl">
                                <img src="<?php echo base_url(); ?>/upload/gambar_lembaga/<?= $lembaga['lembaga_foto'] ?>" alt="" class="avatar-img rounded-circle">
                            </div>
                        <?php } else { ?>
                            <div class="avatar avatar-away avatar-xxl">
                                <img src="<?php echo base_url(); ?>/upload/gambar_lembaga/default.png" class="avatar-img rounded-circle">
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-profile text-center">
                        <div class="name fw-bold"><?php echo $lembaga['lembaga_profile']; ?></div>
                        <div class="desc"><?php echo $lembaga['lembaga_alamat']; ?><br><?php echo $lembaga['lembaga_web']; ?></div>
                        <div class="view-profile">
                            <small class='badge badge-success'><i class='fa fa-check'></i> Aktif</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-sm btn-danger fw-bold btn-block" data-toggle="modal" data-target="#ubahFoto"><i class="fas fa-camera"></i> &nbsp;SETTING LOGO</a>
                    <a href="#" class="btn btn-sm btn-info fw-bold btn-block" data-toggle="modal" data-target="#ubabTtd"><i class="fas fa-signature"></i> &nbsp;SETTING TTD</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- modal foto profil -->
<div class="modal fade" id="ubahFoto" tabindex="-1" role="dialog" aria-labelledby="ubahFoto">
    <div class="modal-dialog modal-md" role="document">
        <div class="col-sm-10">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="ubahFoto"><i class="fab fa-microsoft"></i> LOGO LEMBAGA</h3>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">x</span></button>
                </div>
                <?php echo form_open_multipart(base_url() . "adm/lembaga/svgmb", "class='form-horizontal'"); ?>
                <div class=" modal-body">
                    <div class="form-group text-center">
                        <?php if ($lembaga['lembaga_foto'] != NULL) { ?>
                            <img src="<?php echo base_url(); ?>upload/gambar_lembaga/<?= $lembaga['lembaga_foto'] ?>" alt="Foto Profil Lembaga" class="img-thumbnail" width="70%">
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>upload/gambar_lembaga/default.png" alt="Foto Default" class="img-thumbnail" width="70%">
                        <?php } ?>
                    </div>
                    <div class="form-group form-group-default bg-dop">
                        <label class="text-primary text-small fw-bold">UPLOAD FOTO</label>
                        <input type="hidden" name="id" id="id" required value="<?php echo $aplikasi['lembaga_id']; ?>">
                        <input type="file" class="form-control fw-bold" name="foto" id="foto" required>
                        <small class="small result_default">* Ukuran maksimal file foto 1 MB </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary fw-bold"><i class="fa fa-check"></i> Simpan</button>
                    <button class="btn btn-sm btn-danger fw-bold" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal gambar ttd -->
<div class="modal fade" id="ubabTtd" tabindex="-1" role="dialog" aria-labelledby="ubabTtd">
    <div class="modal-dialog modal-md" role="document">
        <div class="col-sm-10">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="ubabTtd"><i class="fab fa-microsoft"></i> GAMBAR TTD</h3>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">x</span></button>
                </div>
                <?php echo form_open_multipart(base_url() . "adm/lembaga/svttd", "class='form-horizontal'"); ?>
                <div class=" modal-body">
                    <div class="form-group text-center">
                        <?php if ($lembaga['lembaga_ttd'] != NULL) { ?>
                            <img src="<?php echo base_url(); ?>upload/gambar_ttd/<?= $lembaga['lembaga_ttd'] ?>" alt="Gambar TTD" class="img-thumbnail" width="70%">
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>upload/gambar_ttd/default.png" alt="Foto Default" class="img-thumbnail" width="70%">
                        <?php } ?>
                    </div>
                    <div class="form-group form-group-default bg-dop">
                        <label class="text-primary text-small fw-bold">UPLOAD FOTO</label>
                        <input type="hidden" name="id" id="id" required value="<?php echo $aplikasi['lembaga_id']; ?>">
                        <input type="file" class="form-control fw-bold" name="foto" id="foto" required>
                        <small class="small result_default">* Ukuran maksimal file foto 1 MB </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary fw-bold"><i class="fa fa-check"></i> Simpan</button>
                    <button class="btn btn-sm btn-danger fw-bold" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>