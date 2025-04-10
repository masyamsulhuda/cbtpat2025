function opsiPilihan() {
  $('.kunciJawabanPG').fadeIn("slow");
  $('.kunciJawabanQA').fadeOut("slow");
	var x = document.getElementById("jenisSoal").value;
  document.getElementById('jwbQa').required = false;
	if (x == "multiple") {
    document.getElementsByClassName("opsiPilihan")[0].removeAttribute("style");
    document.getElementsByClassName("opsiPilihan")[1].removeAttribute("style");
    document.getElementsByClassName("opsiPilihan")[2].removeAttribute("style");
    document.getElementsByClassName("opsiPilihan")[3].removeAttribute("style");
    if(jml_opsi > 4){
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
}
$(document).ready(function () {
   $(".gambar").each(function () {
    var url = $(this).attr("src");
    $(this).zoom({ url: url });
  });

  var url = get_url(parseInt(uri_js));
  var url2 = get_url(parseInt(uri_js) + 1);
  var url3 = get_url(parseInt(uri_js) + 2);
  //console.log(url);

  if (url == "m_siswa") {
    pagination("datatabel", base_url + "adm/m_siswa/data", []);
  } else if (url == "m_guru") {
    pagination("datatabel", base_url + "adm/m_guru/data", []);
  } else if (url == "m_ruang") {
    pagination("datatabel", base_url + "adm/m_ruang/data", []);
  } else if (url == "m_ruangan") {
    pagination("datatabel", base_url + "adm/m_ruangan/data", []);
  } else if (url == "m_jurusan") {
    pagination("datatabel", base_url + "adm/m_jurusan/data", []);
  } else if (url == "m_kelas") {
    pagination("datatabel", base_url + "adm/m_kelas/data", []);
  } else if (url == "m_mapel") {
    pagination("datatabel", base_url + "adm/m_mapel/data", []);
  } else if (url == "m_soal") {
    pagination("datatabel", base_url + "adm/m_soal/data", []);
    if (url2 == "edit") {
      if (editor_style == "inline") {
        CKEDITOR.inline("editornya");
        CKEDITOR.inline("editornya_a");
        CKEDITOR.inline("editornya_b");
        CKEDITOR.inline("editornya_c");
        CKEDITOR.inline("editornya_d");
        CKEDITOR.inline("editornya_e");
      } else if (editor_style == "replace") {
        CKEDITOR.replace("editornya");
        CKEDITOR.replace("editornya_a");
        CKEDITOR.replace("editornya_b");
        CKEDITOR.replace("editornya_c");
        CKEDITOR.replace("editornya_d");
        CKEDITOR.replace("editornya_e");
      }
    }
  
  } else if (url == "m_ujian") {
    if (url2 == "det") {
      pagination("datatabel", base_url + "adm/m_ujian/data_det/" + url3, []);
    } else {
      pagination("datatabel", base_url + "adm/m_ujian/data", []);
    }
  } else if (url == "h_ujian") {
    if (url2 == "det") {
      pagination("datatabel", base_url + "adm/h_ujian/data_det/" + url3, []);
    } else {
      pagination("datatabel", base_url + "adm/h_ujian/data", []);
    }
  } else if (url == "ikuti_ujian") {
    pagination("datatabel", base_url + "adm/ikuti_ujian/data", []);
  } else if (url == "ikut_ujian") {
    if (url2 == "token") {
      timer();
    }
    if (url2 == "live") {
      if (editor_style == "inline") {
        CKEDITOR.inline("editornya");
      } else if (editor_style == "replace") {
        CKEDITOR.replace("editornya");
      }
    }
  } else if (url == "importword"){
    if (editor_style == "inline") {
      CKEDITOR.inline("import_soal");
    } else if (editor_style == "replace") {
      CKEDITOR.replace("import_soal");
    }
  } else if (url == "toimport"){
    if (editor_style == "inline") {
      CKEDITOR.inline("import_soal");
    } else if (editor_style == "replace") {
      CKEDITOR.replace("import_soal");
    }
  }
});
//umum
function timer() {
  var tgl_sekarang = $("#_tgl_sekarang").val();
  var tgl_mulai = $("#_tgl_mulai").val();
  var tgl_terlambat = $("#_terlambat").val();
  var id_ujian = $("#id_ujian").val();
  var statuse = $("#_statuse").val();
  statuse = parseInt(statuse);
  var z = document.getElementById("btn_mulai");

  if (statuse == 0) {
    $("#btn_mulai").addClass("btn btn-danger btn-lg");
    z.style.pointerEvents = "none";
    $("#waktu_").hide();
    $("#akan_mulai").countdowntimer({
      startDate: tgl_sekarang,
      dateAndTime: tgl_mulai,
      size: "lg",
      labelsFormat: false,
      timeUp: timeIsUp,
    });
  }  else if (statuse == 1) {
    $("#btn_mulai").html(
      '<a href="#" class="btn btn-success btn-lg fw-bold" id="tbl_mulai" onclick="return validasi_token()"><i class="fa fa-check-circle"></i> MULAI</a>'
      );
    $("#waktu_akhir_ujian").countdowntimer({
      startDate: tgl_sekarang,
      dateAndTime: tgl_terlambat,
      size: "lg",
      labelsFormat: false,
      timeUp: hilangkan_tombol,
    });
  } else if (statuse == 2) {
    hilangkan_tombol();
  } else {
    hilangkan_tombol();
  }
}
function timeIsUp() {
  var id_ujian = $("#id_ujian").val();
  $("#btn_mulai").hide();
  $("#btn_mulai").html(
    '<a href="#" class="btn btn-success btn-lg" id="tbl_mulai" onclick="return validasi_token()"><i class="fa fa-check-circle"></i> MULAI</a>'
    );
  window.location.reload();
  var tgl_sekarang = $("#_tgl_sekarang").val();
  var tgl_mulai = $("#_tgl_mulai").val();
  var tgl_terlambat = $("#_terlambat").val();
}
function hilangkan_tombol() {
  $("#btn_mulai").hide();
  $("#waktu_").hide();
  $("#waktu_game_over").html(
    '<a class="btn btn-danger btn-lg text-white fw-bold" onclick="return alert(\'WAKTU UJIAN TELAH SELESAI!\');"><i class="fa fa-times-circle"></i> UJIAN TELAH SELESAI</a>'
  );
}
function validasi_token() {
  var f_asal = $("#f_token");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/ikut_ujian/validasiToken",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "1") {
      window.location.assign(base_url + "adm/ikut_ujian/live/");
    } else {
      setTimeout(function () { 
        swal('Authentication Invalid', 'Perhatian! Token yang Anda Masukkan Salah.', {
        icon : 'error',
        buttons: false,
        })
        }, 10),
        window.setTimeout(function(){ 
        window.location.assign(base_url + "adm/ikut_ujian/token/" + response.ujian_id);
        }, 3000);
    return false;
    }
  });
  return false;
}
function konfirmasi_token(id) {
  var token_asli = $("#_token").val();
  var token_input = $("#token").val();
  if (token_asli != token_input) {
    setTimeout(function () { 
        swal('Authentication Invalid', 'Perhatian! Token yang Anda Masukkan Salah.', {
        icon : 'error',
        buttons: false,
        })
        }, 10),
        window.setTimeout(function(){ 
        window.location.assign(base_url + "adm/ikut_ujian/token/" + id);
        }, 3000);
    return false;
  } else {
    window.location.assign(base_url + "adm/ikut_ujian/_/" + id);
  }
}
function refresh_token(id) {
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_ujian/refresh_token/" + id,
    success: function (response) {
      if (response.status == "ok") {
        pagination("datatabel", base_url + "adm/m_ujian/data", []);
      } else {
        console.log("gagal");
      }
    },
  });
  return false;
}
function get_url(segmen) {
  var url1 = window.location.protocol;
  var url2 = window.location.host;
  var url3 = window.location.pathname;
  var pathArray = window.location.pathname.split("/");
  return pathArray[segmen];
}
function getFormData($form) {
  var unindexed_array = $form.serializeArray();
  var indexed_array = {};
  $.map(unindexed_array, function (n, i) {
    indexed_array[n["name"]] = n["value"];
  });
  return indexed_array;
}
function pagination(indentifier, url, config) {
  $("#" + indentifier).DataTable({
    language: {
      // "url": base_url+"___/plugin/datatables/Indonesian.json"
    },
    ordering: true,
    columnDefs: config,
    bProcessing: true,
    serverSide: true,
    bDestroy: true,
    rowReorder: {
      selector: "td:nth-child(0)",
    },
    responsive: true,
    ajax: {
      url: url, // json datasource
      type: "post", // type of method  , by default would be get
      error: function () {
        // error handling code
        $("#" + indentifier).css("display", "none");
      },
    },
  });
}
function login(e) {
  e = e || window.event;
  var data = $("#f_login").serialize();
  $("#konfirmasi").html(
    "<div class='alert alert-info'><i class='icon icon-spinner icon-spin'></i> Checking...</div>"
  );
  $.ajax({
    type: "POST",
    data: data,
    url: base_url + "adm/act_login",
    success: function (r) {
      if (r.log.status == 0) {
          setTimeout(function () { 
            swal('Authentication Gagal', r.log.keterangan, {
            icon : 'error',
            buttons: false,
            })
            }, 10),
            window.setTimeout(function(){ 
            window.location.assign(base_url);
            }, 2000);
      } else {
          setTimeout(function () { 
            swal('Authentication Success', r.log.keterangan, {
            icon : 'success',
            buttons: false,
            })
            }, 10),
            window.setTimeout(function(){ 
            window.location.assign(base_url + "adm");
            }, 1500);
      }
    },
  });
  return false;
}
function m_soal_h(id) {
  if (confirm("APAKAH ANDA YAKIN?")) {
    $.ajax({
      type: "GET",
      url: base_url + "adm/m_soal/hapus/" + id,
      success: function (response) {
        if (response.status == "ok") {
          window.location.assign(base_url + "adm/m_soal");
        } else {
          console.log("gagal");
        }
      },
    });
  }

  return false;
}
function m_soal_hs() {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Semua bank data soal akan dihapus semua!",
    icon: "info",
    buttons: ["Batal", "Oke, Hapus Semua!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_soal/hapussemua/",
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_soal");
            } else {
              console.log("gagal");
            }
          },
        });
    }}))
    return false;
}
//ujian
function m_ujian_e(id) {
  $("#m_ujian").modal("show");
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_ujian/det/" + id,
    success: function (data) {
      $("#id").val(data.id);
      $("#nama_ujian").val(data.nama_ujian);
      $("#jumlah_soal").val(data.jumlah_soal);
      $("#kelas").val(data.kelas);
      $("#jurusan").val(data.jurusan);
      $("#mapel").val(data.id_mapel);
      $("#waktu").val(data.waktu);
      $("#waktu_submit").val(data.waktu_submit);
      $("#terlambat").val(data.terlambat);
      $("#terlambat2").val(data.terlambat2);
      $("#tgl_mulai").val(data.tgl_mulai);
      $("#wkt_mulai").val(data.wkt_mulai);
      $("#acak").val(data.jenis);
      $("#nama_ujian").focus();
      __ambil_jumlah_soal(data.id_mapel);
    },
  });

  return false;
}
function m_ujian_s() {
  var f_asal = $("#f_ujian");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/m_ujian/simpan",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
      window.location.assign(base_url + "adm/m_ujian");
    } else {
      $("#jmlsoal").html(
        '<p class="alert alert-danger">' + response.caption + "</p>"
      );
    }
  });
  return false;
}
function m_ujian_h(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Data terpilih akan dihapus!",
    icon: "warning",
    buttons: ["Batal", "Oke, Hapus"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_ujian/hapus/" + id,
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_ujian");
            } else {
              console.log("gagal");
            }
          },
        });
    }}))
    return false;
}
//siswa
function m_siswa_e(id) {
  $("#m_siswa").modal("show");
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_siswa/det/" + id,
    success: function (data) {
      $("#id").val(data.id);
      $("#nama").val(data.nama);
      $("#nopes").val(data.nopes);
      $("#nim").val(data.nim);
      $("#jurusan").val(data.jurusan);
      $("#id_jurusan").val(data.id_jurusan);
      $("#nama").focus();
    },
  });
  return false;
}
function m_siswa_s() {
  var f_asal = $("#f_siswa");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/m_siswa/simpan",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
      window.location.assign(base_url + "adm/m_siswa");
    } else {
      console.log("gagal");
    }
  });
  return false;
}
function m_siswa_h(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Data terpilih akan dihapus!",
    icon: "warning",
    buttons: ["Batal", "Oke, Hapus"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_siswa/hapus/" + id,
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_siswa");
            } else {
              console.log("gagal");
            }
          },
        });
    }}))
    return false;
}
function m_siswa_hs() {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Semua akun peserta ujian akan dihapus semua!",
    icon: "info",
    buttons: ["Batal", "Oke, Hapus Semua!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_siswa/hapussemua/",
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_siswa");
            } else {
              console.log("gagal");
            }
          },
        });
    }}))
    return false;
}
function m_siswa_u(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Aktifkan akun ini! Username dan Password adalah NIS!",
    icon: "info",
    buttons: ["Batal", "Oke, Aktifkan!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_siswa/user/" + id,
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_siswa");
            } else {
              alert(response.caption);
            }
          },
        });
    }}))
    return false;
}
function m_siswa_ur(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Setelah RESET! Username dan Password adalah NIS!",
    icon: "info",
    buttons: ["Batal", "Oke, Reset Akun!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_siswa/user_reset/" + id,
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_siswa");
            } else {
              alert(response.caption);
            }
          },
        });
    }}))
    return false;
}
function aktifkan_semua_siswa() {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Semua akun peserta ujian akan aktif semua!",
    icon: "info",
    buttons: ["Batal", "Oke, Aktifkan Semua!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_siswa/aktifkan_semua/",
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_siswa");
            } else {
              alert(response.caption);
            }
          },
        });
    }}))
    return false;
}
function m_siswa_non_aktif(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Akun peserta ujian terpilih akan dinonaktifkan!",
    icon: "info",
    buttons: ["Batal", "Oke, Disable Akun!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_siswa/non_aktifkan/" + id,
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_siswa");
            } else {
              alert(response.caption);
            }
          },
        });
    }}))
    return false;
}
//guru
function m_guru_e(id) {
  $("#m_guru").modal("show");
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_guru/det/" + id,
    success: function (data) {
      $("#id").val(data.id);
      $("#nip").val(data.nip);
      $("#nama").val(data.nama);
      $("#nama").focus();
    },
  });
  return false;
}
function m_guru_s() {
  var f_asal = $("#f_guru");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/m_guru/simpan",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
      window.location.assign(base_url + "adm/m_guru");
    } else {
      console.log("gagal");
    }
  });
  return false;
}
function m_guru_h(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Akun ini akan dihapus!",
    icon: "info",
    buttons: ["Batal", "Oke, Hapus!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_guru/hapus/" + id,
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_guru");
            } else {
              console.log("gagal");
            }
          },
        });
    }}))
    return false;
  if (confirm("APAKAH ANDA YAKIN?")) {
    $.ajax({
      type: "GET",
      url: base_url + "adm/m_guru/hapus/" + id,
      success: function (response) {
        if (response.status == "ok") {
          window.location.assign(base_url + "adm/m_guru");
        } else {
          console.log("gagal");
        }
      },
    });
  }
  return false;
}
function m_guru_u(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Aktifkan akun ini! Username dan Password adalah NIP!",
    icon: "info",
    buttons: ["Batal", "Oke, Aktifkan!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_guru/user/" + id,
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_guru");
            } else {
              alert(response.caption);
            }
          },
        });
    }}))
    return false;
}
function m_guru_ur(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Reset akun ini! Username dan Password adalah NIP!",
    icon: "info",
    buttons: ["Batal", "Oke, Reset!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_guru/user_reset/" + id,
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_guru");
            } else {
              alert(response.caption);
            }
          },
        });
    }}))
    return false;
}
function aktifkan_semua_guru() {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Akun Proktor akan diaktifkan semua!",
    icon: "info",
    buttons: ["Batal", "Oke, Aktifkan!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_guru/aktifkan_semua_guru/",
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_guru");
            } else {
              alert(response.caption);
            }
          },
        });
    }}))
    return false;
}
function m_guru_matkul(id) {
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_guru/ambil_matkul/" + id,
    success: function (data) {
      if (data.status == "ok") {
        var jml_data = Object.keys(data.data).length;
        var hate =
          '<div class="modal fade" id="m_siswa_matkul" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h4 id="myModalLabel" class="fw-bold"><i class="fas fa-archive"></i> Setting Mata Pelajaran</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><form name="f_siswa_matkul" id="f_siswa_matkul" method="post" onsubmit="return m_guru_matkul_s();"><div class="modal-body"><span class="fw-bold">Daftar Mata Pelajaran</span> <br> <small>Silahkan pilih mata pelajaran yang akan diampu oleh pengajar/proktor. Pilihan mata pelajaran akan menjadi dasar untuk membuat soal dan pembuatan ujian untuk peserta ujian dalam sistem ini.</small><hr><input type="hidden" name="id_mhs" id="id_mhs" value="' + id +'"><div id="konfirmasi"></div><div class="row"><div class="col-sm-12"><div class="row">';
        if (jml_data > 0) {
          $.each(data.data, function (i, item) {
            if (item.ok == "1") {
              hate +='<div class="col-sm-3"><div class="custom-control custom-checkbox"><input type="checkbox" value="' + item.id + '" name="id_mapel_' + item.id + '" id="id_mapel_' + item.id + '" class="custom-control-input" checked><label class="custom-control-label" for="id_mapel_' + item.id + '">' + item.nama + "</label></div></div>";
            } else {
              hate +='<div class="col-sm-3"><div class="custom-control custom-checkbox"><input type="checkbox" value="' + item.id + '" name="id_mapel_' + item.id + '" id="id_mapel_' + item.id + '" class="custom-control-input"><label class="custom-control-label" for="id_mapel_' + item.id + '">' + item.nama + "</label></div></div>";
            }
          });
        } else {
          hate += "Belum ada data..";
        }
        hate +=
        '</div></div></div></div><div class="modal-footer"><button class="btn btn-sm btn-primary fw-bold" type="submit"><i class="fa fa-check"></i> Simpan</button><button class="btn btn-sm btn-danger fw-bold" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button></div></form></div></div></div>';
        $("#tampilkan_modal").html(hate);
        $("#m_siswa_matkul").modal("show");
      } else {
        console.log("gagal");
      }
    },
  });
  return false;
}
function m_guru_matkul_s() {
  var f_asal = $("#f_siswa_matkul");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/m_guru/simpan_matkul",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
      window.location.assign(base_url + "adm/m_guru");
    } else {
      console.log("gagal");
    }
  });
  return false;
}
//mapel
function m_mapel_e(id) {
  $("#m_mapel").modal("show");
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_mapel/det/" + id,
    success: function (data) {
      $("#id").val(data.id);
      $("#nama").val(data.nama);
      $("#nama").focus();
    },
  });
  return false;
}
function m_mapel_s() {
  var f_asal = $("#f_mapel");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/m_mapel/simpan",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
      window.location.assign(base_url + "adm/m_mapel");
    } else {
      console.log("gagal");
    }
  });
  return false;
}
function m_mapel_h(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Data terpilih akan dihapus!",
    icon: "warning",
    buttons: ["Batal", "Oke, Hapus"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_mapel/hapus/" + id,
          success: function (response) {
            if (response.status == "ok") {
              // swal("Poof! Your imaginary file has been deleted!", {
              //   icon: "success",
              // });
              window.location.assign(base_url + "adm/m_mapel")
            } else {
              console.log("gagal");
            }
          },
        });
    }}))
    return false;
}
//jurusan
function m_jurusan_e(id) {
  $("#m_jurusan").modal("show");
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_jurusan/det/" + id,
    success: function (data) {
      $("#id").val(data.id);
      $("#jurusan").val(data.jurusan);
      $("#jurusan").focus();
    },
  });
  return false;
}
function m_jurusan_s() {
  var f_asal = $("#f_jurusan");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/m_jurusan/simpan",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
      window.location.assign(base_url + "adm/m_jurusan");
    } else {
      console.log("gagal");
    }
  });
  return false;
}
function m_jurusan_h(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Data terpilih akan dihapus!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
      $.ajax({
        type: "GET",
        url: base_url + "adm/m_jurusan/hapus/" + id,
        success: function (response) {
          if (response.status == "ok") {
            window.location.assign(base_url + "adm/m_jurusan");
          } else {
            console.log("gagal");
          }
        }
      });
    }}))
    return false;
}
function batalkanUjian(id, uri) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Data terpilih akan dibatalkan ujiannya!",
    icon: "warning",
    buttons: ["Batal", "Oke, Batalkan Ujian!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
      $.ajax({
        type: "GET",
        url: base_url + "adm/h_ujian/batalkan_ujian/" + id,
        success: function (response) {
          if (response.status == "ok") {
            window.location.assign(base_url + "adm/h_ujian/det/" + uri);
          } else {
            console.log("gagal");
          }
        }
      });
    }}))
    return false;
}
function addTime(id) {
  $("#addTime").modal("show");
  $.ajax({
    type: "GET",
    url: base_url + "adm/h_ujian/addtime/" + id,
    success: function (data) {
      $("#id").val(data.idUjian);
      $("#nama").val(data.nama);
      $("#nopes").val(data.nopes);
      $("#selesai").val(data.tgl_selesai);
      $("#nama").focus();
    },
  });
  return false;
}
function addTime_s() {
  var f_asal = $("#f_addtime");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/h_ujian/svaddtime",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
        setTimeout(function() {
        swal('Successfully Saved', 'Data berhasil disimpan!', {
        icon: 'success',
        buttons: false,
        });
        }, 10);
        window.setTimeout(function() {
        window.location.reload();
        }, 1500);
    } else {
      console.log("gagal");
    }
  });
  return false;
}
//kelas
function m_kelas_e(id) {
  $("#m_kelas").modal("show");
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_kelas/det/" + id,
    success: function (data) {
      $("#id").val(data.id);
      $("#kelas").val(data.kelas);
      $("#kelas").focus();
    },
  });
  return false;
}
function m_kelas_s() {
  var f_asal = $("#f_kelas");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/m_kelas/simpan",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
      window.location.assign(base_url + "adm/m_kelas");
    } else {
      console.log("gagal");
    }
  });
  return false;
}
function m_kelas_h(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Data terpilih akan dihapus!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_kelas/hapus/" + id,
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_kelas");
            } else {
              console.log("gagal");
            }
          },
        });
    }}))
    return false;
}
//soal
function __ambil_jumlah_soal(id_mapel) {
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_ujian/jumlah_soal/" + id_mapel,
    success: function (response) {
      $("#jumlah_soal1").val(response.jumlah);
    },
  });
  return false;
}
function rubah_password() {
  $.ajax({
    type: "GET",
    url: base_url + "adm/rubah_password/",
    success: function (response) {
      var teks_modal =
        '<div class="modal fade" id="m_ubah_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 id="myModalLabel" class="fw-bold"><i class="fas fa-key"></i> UBAH SANDI</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><form name="f_ubah_password" id="f_ubah_password" onsubmit="return rubah_password_s();" method="post"><input type="hidden" name="id" id="id" value="' +
        response.id +
        '"><div id="konfirmasi"></div><table class="table table-bordered"><tr><td style="width: 40%">Username</td><td style="width: 60%"><input type="text" class="form-control mt-2 mb-2" name="u1" id="u1" required value="' +
        response.username +
        '" readonly></td></tr><tr><td style="width: 25%">Current Password</td><td style="width: 75%"><input type="password" class="form-control mt-2 mb-2" name="p1" id="p1" required></td></tr><tr><td style="width: 25%">New Password</td><td style="width: 75%"><input type="password" class="form-control mt-2 mb-2" name="p2" id="p2" required></td></tr><tr><td style="width: 25%">Reenter Password</td><td style="width: 75%"><input type="password" class="form-control mt-2 mb-2" name="p3" id="p3" required></td></tr></table></div><div class="modal-footer"><button class="btn btn-sm btn-primary fw-bold" onclick="return rubah_password_s();"><i class="fa fa-check"></i> Simpan</button><button class="btn btn-sm btn-danger fw-bold" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button></div></form></div></div></div>';
      $("#tampilkan_modal").html(teks_modal);
      $("#m_ubah_password").modal("show");
      $("#p1").focus();
    },
  });
  return false;
}
function rubah_password_s() {
  var f_asal = $("#f_ubah_password");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/rubah_password/simpan",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
      $("#m_ubah_password").modal("hide");
        setTimeout(function() {
        swal('Successfully Saved', 'Data berhasil disimpan!', {
        icon: 'success',
        buttons: false,
        });
        }, 10);
        window.setTimeout(function() {
        window.location.assign(base_url + "adm");
        }, 1500);
    } else {
      $("#konfirmasi").html(
        '<div class="alert alert-danger">' + response.msg + "</div>"
      );
    }
  });
  return false;
}
// import
function previewimport(){
  $.ajax({
    type: "POST",
    url: base_url+ "adm/toimport",
    contentType: "text/html; charset=utf-8",
  });
  return false;
}
// config
function config_s() {
  var f_asal = $("#f_config");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/lembaga/svapps",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
        setTimeout(function() {
        swal('Successfully Saved', 'Data berhasil disimpan!', {
        icon: 'success',
        buttons: false,
        });
        }, 10);
        window.setTimeout(function() {
        window.location.assign(base_url + "adm/lembaga");
        }, 1500);
    } else {
      console.log("gagal");
    }
  });
  return false;
}
function lembaga_s() {
  var f_asal = $("#f_lembaga");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/lembaga/svlmg",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
        setTimeout(function() {
        swal('Successfully Saved', 'Data berhasil disimpan!', {
        icon: 'success',
        buttons: false,
        });
        }, 10);
        window.setTimeout(function() {
        window.location.assign(base_url + "adm/lembaga");
        }, 1500);
    } else {
      console.log("gagal");
    }
  });
  return false;
}
function m_ruangan_e(id) {
  $("#m_ruangan").modal("show");
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_ruangan/det/" + id,
    success: function (data) {
      $("#ruangan_id").val(data.ruang_id);
      $("#ruangan_nama").val(data.ruang_nama);
      $("#ruangan_server").val(data.ruang_server);
      $("#ruangan_nama").focus();
    },
  });
  return false;
}
function m_ruangan_s() {
  var f_asal = $("#f_ruangan");
  var form = getFormData(f_asal);
  $.ajax({
    type: "POST",
    url: base_url + "adm/m_ruangan/simpan",
    data: JSON.stringify(form),
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (response) {
    if (response.status == "ok") {
      window.location.assign(base_url + "adm/m_ruangan");
    } else {
      console.log("gagal");
    }
  });
  return false;
}
function m_ruangan_h(id) {
  if (swal({
    title: "Apakah Anda Yakin?",
    text: "Ruangan ini akan dihapus!",
    icon: "info",
    buttons: ["Batal", "Oke, Hapus!"],
    dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "GET",
          url: base_url + "adm/m_ruangan/hapus/" + id,
          success: function (response) {
            if (response.status == "ok") {
              window.location.assign(base_url + "adm/m_ruangan");
            } else {
              console.log("gagal");
            }
          },
        });
    }}))
    return false;
  if (confirm("APAKAH ANDA YAKIN?")) {
    $.ajax({
      type: "GET",
      url: base_url + "adm/m_ruangan/hapus/" + id,
      success: function (response) {
        if (response.status == "ok") {
          window.location.assign(base_url + "adm/m_ruangan");
        } else {
          console.log("gagal");
        }
      },
    });
  }
  return false;
}
function m_absen_c(id) {
  $.ajax({
    type: "GET",
    url: base_url + "adm/m_ruangan/dafdir/" + id,
    success: function (response) {
      console.log("ok");
    },
  });
  return false;
}
function hitung_akhir (id) {
  if (swal({
          title: "Apakah Anda Yakin?",
          text: "Ujian peserta akan diakhiri setelah menekan tombol Oke",
          icon: "info",
          buttons: ["Batal", "Oke, Akhiri!"],
          dangerMode: false,
      }).then((willDelete) => {
          if (willDelete) {
              $.ajax({
                  type: "GET",
                  url: base_url + "adm/h_ujian/hitung_akhir/" + id,
                  beforeSend: function() {
                      $('.ajax-loading').show();
                  },
                  success: function(r) {
                    if (r.status == "ok") {
                      setTimeout(function() {
                      swal('Successfully Force Close', 'Data ujian berhasil paksa selesai!', {
                      icon: 'success',
                      buttons: false,
                      });
                      }, 10);
                      window.setTimeout(function() {
                      window.location.reload();
                      }, 1500);
                  } else {
                    console.log("gagal");
                  }
                  }
              });
          }
      }))
      return false;
}