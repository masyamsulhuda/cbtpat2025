<div class="page-inner">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
          <div>
            <h3 class="card-title mb-0 font-weight-bold">Daftar Ujian</h3>
            <div class="small text-muted"><b class="badge badge-success"><?php echo $lembaga['lembaga_profile'] ?></b></div>
          </div>
          <div class="btn-toolbar"></div>
        </div>
        <div class="table-responsive pb-3" style="overflow-x:auto;">
          <table id="datatabel" class="table table-striped table-bordered table-hover" cellspacing="0" style="width: 100%;">
            <thead class="bg-secondary">
              <tr class="text-white text-center">
                <th width="5%">No</th>
                <th>Nama Ujian</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Tanggal Mulai</th>
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
<!-- 
<?php
if (!empty($data)) {
  $no = 1;
  foreach ($data as $d) {
    echo '<tr>
                        <td class="ctr">' . $no . '</td>
                        <td>' . $d->nama_ujian . '</td>
                        <td>[' . $d->kelas . '] [' . $d->jurusan . '] - ' . $d->nmmapel . '</td>
                        <td class="ctr">' . $d->jumlah_soal . '</td>
                        <td class="ctr">' . $d->waktu . ' menit</td>
                        <td class="ctr">' . $d->status . '</td>
                        <td class="ctr">' . $d->tgl_mulai . '</td>
                        <td class="ctr">';
    if ($d->status == "Belum Ikut") {
      echo '<a href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="btn btn-primary btn-xs m-1"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Ikuti Ujian</a>';
    } else if ($d->status == "Sedang Tes") {
      echo '<a href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp; <blink>Ujian Sdg Aktif</blink></a>';
    } else if ($d->status == "Waktu Habis") {
      echo '<a href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp; <blink>Waktu Habis</blink></a>';
    } else {
      echo '<a href="' . base_url() . 'adm/sudah_selesai_ujian/' . $d->id . '" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-ok" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Anda sudah ikut</a>';
    }
    echo '</td></tr>';
    $no++;
  }
} else {
  echo '<tr class="text-center"><td colspan="8">Belum ada data</td></tr>';
}
?> -->