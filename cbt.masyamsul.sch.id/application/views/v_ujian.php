<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo $aplikasi['aplikasi_nama']; ?> <?php echo $aplikasi['aplikasi_versi']; ?></title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="description" content="<?php echo $lembaga['lembaga_profile']; ?>">
    <meta name="author" content="<?php echo $lembaga['lembaga_alamat']; ?>">
    <meta name="keyword" content="<?php echo $aplikasi['aplikasi_nama']; ?>">
    <script>
        var base_url_js = '<?php echo base_url(); ?>';
    </script>
    <script src="<?php echo base_url(); ?>___/js/jquery-3.5.1.js"></script>
    <script src="<?php echo base_url(); ?>___/js/plugin/webfont/webfont.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/plugin/webfont/font.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url(); ?>___/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>___/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>___/css/atlantis2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>___/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>___/css/responsive.dataTables.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>upload/gambar_lembaga/<?php echo $lembaga['lembaga_foto']; ?>">
    <style type="text/css">
        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(<?php echo base_url('___/img/loading.gif'); ?>) center no-repeat #fff;
            size: 10%;
        }

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
</head>

<body>
    <div class="se-pre-con"></div>
    <div class="wrapper">
        <div class="main-header" data-background-color="blue">
            <div class="nav-top">
                <div class="container d-flex flex-row">
                    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <i class="icon-menu"></i>
                        </span>
                    </button>
                    <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                    <!-- Logo Header -->
                    <a href="#" class="logo d-flex align-items-center">
                        <b class="text-white"><?php echo $aplikasi['aplikasi_nama']; ?></b>
                    </a>
                    <!-- End Logo Header -->
                    <!-- Navbar Header -->
                    <nav class="navbar navbar-header navbar-expand-lg p-0">
                        <div class="container-fluid p-0">
                            <div class="collapse" id="search-nav">
                                <form class="navbar-left navbar-form nav-search ml-md-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-search pr-1">
                                                <i class="fa fa-search search-icon"></i>
                                            </button>
                                        </div>
                                        <input type="text" placeholder="Help Desk" class="form-control">
                                    </div>
                                </form>
                            </div>
                            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                                <li class="nav-item toggle-nav-search hidden-caret">
                                    <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </li>
                                <li class="nav-item dropdown hidden-caret">
                                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <span class="d-flex align-items-center">
                                            <div class="avatar-sm">
                                                <img src="<?php echo base_url(); ?>___/img/default.png" class="avatar-img rounded-circle">
                                            </div>
                                            <span class="text-white ml-2">
                                                <span class="fw-bold"><?php echo $this->session->userdata('admin_nama'); ?></span>
                                            </span>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                                        <div class="dropdown-user-scroll scrollbar-outer">
                                            <li>
                                                <div class="user-box">
                                                    <div class="avatar-lg">
                                                        <img src="<?php echo base_url(); ?>___/img/default.png" class="avatar-img rounded">
                                                    </div>
                                                    <div class="u-text mt-2">
                                                        <h4><?php echo $this->session->userdata('admin_level'); ?></h4>
                                                        <p class="text-muted"><?php echo $this->session->userdata('admin_nama'); ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ubahProfil"><i class="fas fa-user-alt"></i>&nbsp; Profil</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#tampilkan_modal"><i class="fas fa-lock"></i>&nbsp; Ubah password</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>adm/logout"><i class="fas fa-sign-out-alt text-danger"></i>&nbsp; Keluar</a>
                                            </li>
                                        </div>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <!-- End Navbar -->
                </div>
            </div>
            <div class="nav-bottom bg-white">
                <h3 class="title-menu d-flex d-lg-none fw-bold">
                    <b class="text-white"><?php echo $aplikasi['aplikasi_nama']; ?></b>
                    <div class="close-menu"> <i class="flaticon-cross"></i></div>
                </h3>
                <div class="container d-flex flex-row">
                    <ul class="nav page-navigation page-navigation-danger">
                        <li class="nav-item submenu active">
                            <a class="nav-link" href="#">
                                <i class="link-icon icon-screen-desktop"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                            <div class="navbar-dropdown animated fadeIn">
                                <ul>
                                    <li class="fw-bold"><a href="<?php echo base_url(); ?>adm/ikuti_ujian">Daftar Ujian</a></li>
                                    <li class="fw-bold"><a href="<?php echo base_url(); ?>adm/logout">Keluar</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-panel">
            <div class="container">
                <div class="page-inner">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <form role="form" name="_form" method="post" id="_form">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title fw-bold">SOAL KE &nbsp;<div class="btn btn-xl btn-danger fw-bold" id="soalke"></div>
                                            </div>
                                            <div class="card-tools">
                                                <div class="btn-group">
                                                    <div class="btn btn-xl btn-warning fw-bold">SISA WAKTU</div>
                                                    <div id="clock" class="btn btn-xl btn-info fw-bold"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php echo $html; ?>
                                    </div>
                                    <div class="card-footer">
                                        <div class="panel-footer text-center">
                                            <a class="action back btn btn-sm btn-success fw-bold text-white m-1" rel="0" onclick="return back();"><i class="fas fa-chevron-circle-left"></i> BACK</a>
                                            <a class="ragu_ragu btn btn-sm btn-warning fw-bold m-1" rel="1" onclick="return tidak_jawab();"> RAGU-RAGU</a>
                                            <a class="action next btn btn-sm btn-success fw-bold text-white m-1" rel="2" onclick="return next();"><i class="fas fa-chevron-circle-right"></i> NEXT</a>
                                            <input type="hidden" name="jml_soal" id="jml_soal" value="<?php echo $no; ?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="dmobile">
                                        <div id="v_jawaban">
                                            <div class="btn btn-primary btn-block fw-bold"><i class="fa fa-home"></i> NAVIGASI SOAL</div>
                                            <div class="panel-heading" id="nav_soal" style="overflow: auto">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="tampil_jawaban" class="text-left"></div>
                                </div>
                                <div class="card-footer">
                                    <a style="pointer-events: none;" class="selesai action submit btn btn-block btn-sm btn-danger fw-bold text-white m-1" onclick="return simpan_akhir();"><i class="fas fa-calendar-check"></i> AKHIRI UJIAN <span id="clocksubmit"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <nav class="pull-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <b class="text-white"><?php echo $aplikasi['aplikasi_nama']; ?></b>
                        </li>
                    </ul>
                </nav>
                <div class="copyright ml-auto fw-bold">
                    <b><?php echo  date('Y') .  " &copy " . $lembaga['lembaga_profile'] ?></b>
                </div>
            </div>
        </footer>
    </div>
    <div class="ajax-loading"><i class="fa fa-spin fa-spinner"></i> Loading ...</div>
    <script src="<?php echo base_url(); ?>___/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/core/bootstrap-toggle.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/plugin/jquery.validate/jquery.validate.js"></script>
    <script src="<?php echo base_url(); ?>___/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/atlantis2.min.js"></script>
    <script src="<?php echo base_url(); ?>___/plugin/countdown/jquery.countdownTimer.js"></script>
    <script src="<?php echo base_url(); ?>___/plugin/jquery_zoom/jquery.zoom.min.js"></script>
    <script src="<?php echo base_url(); ?>___/plugin/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
        id_tes = "<?php echo $id_tes; ?>";
        $(window).on('load', function() {
            $(".se-pre-con").fadeOut("slow");
        });

        function getFormData($form) {
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};
            $.map(unindexed_array, function(n, i) {
                indexed_array[n['name']] = n['value'];
            });
            return indexed_array;
        }
        $(document).ready(function() {
            $('.gambar').each(function() {
                var url = $(this).attr("src");
                $(this).zoom({
                    url: url
                });
            });
            hitung();
            simpan_sementara();
            buka(1);
            widget = $(".step");
            btnnext = $(".next");
            btnback = $(".back");
            btnsubmit = $(".submit");
            $(".step").hide();
            $(".back").hide();
            $("#widget_1").show();
        });
        widget = $(".step");
        total_widget = widget.length;
        simpan_sementara = function() {
            var f_asal = $("#_form");
            var form = getFormData(f_asal);
            //form = JSON.stringify(form);
            var jml_soal = form.jml_soal;
            jml_soal = parseInt(jml_soal);
            var hasil_jawaban = "";
            for (var i = 1; i < jml_soal; i++) {
                var idx = 'opsi_' + i;
                var idx2 = 'rg_' + i;
                var jawab = form[idx];
                var ragu = form[idx2];
                if (jawab != undefined) {
                    if (ragu == "Y") {
                        if (jawab == "N") {
                            hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-info btn_soal btn-xs fw-bold ml-1 mb-1 text-white" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                        } else {
                            hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-warning btn_soal btn-xs fw-bold ml-1 mb-1" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                        }
                    } else {
                        if (jawab == "N") {
                            hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-info btn_soal btn-xs fw-bold ml-1 mb-1 text-white" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                        } else if (jawab == "") {
                            hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-info btn_soal btn-xs fw-bold ml-1 mb-1 text-white" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                        } else {
                            hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-success btn_soal btn-xs fw-bold ml-1 mb-1 text-white" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                        }
                    }
                } else {
                    hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-info btn_soal btn-xs fw-bold ml-1 mb-1 text-white" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                }
            }
            $("#tampil_jawaban").html('<div id="yes"></div>' + hasil_jawaban);
        }
        simpan = function() {
            var f_asal = $("#_form");
            var form = getFormData(f_asal);
            $.ajax({
                type: "POST",
                url: base_url + "adm/ikut_ujian/simpan_satu/" + id_tes,
                data: JSON.stringify(form),
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                beforeSend: function() {
                    $('.ajax-loading').show();
                }
            }).done(function(response) {
                $('.ajax-loading').hide();
                var hasil_jawaban = "";
                var panjang = response.data.length;
                for (var i = 0; i < panjang; i++) {
                    if (response.data[i] != "_N") {
                        var getjwb = response.data[i];
                        var pc_getjwb = getjwb.split('_');
                        if (pc_getjwb[1] == "Y") {
                            if (pc_getjwb[0] == "-") {
                                hasil_jawaban += '<a id="btn_soal_' + (i + 1) + '" class="btn btn-default btn_soal btn-sm" onclick="return buka(' + (i + 1) + ');">' + (i + 1) + ". " + pc_getjwb[0] + "</a>";
                            } else {
                                hasil_jawaban += '<a id="btn_soal_' + (i + 1) + '" class="btn btn-warning btn_soal btn-sm" onclick="return buka(' + (i + 1) + ');">' + (i + 1) + ". " + pc_getjwb[0] + "</a>";
                            }
                        } else {
                            if (pc_getjwb[0] == "-") {
                                hasil_jawaban += '<a id="btn_soal_' + (i + 1) + '" class="btn btn-default btn_soal btn-sm" onclick="return buka(' + (i + 1) + ');">' + (i + 1) + ". " + pc_getjwb[0] + "</a>";
                            } else {
                                hasil_jawaban += '<a id="btn_soal_' + (i + 1) + '" class="btn btn-success btn_soal btn-sm" onclick="return buka(' + (i + 1) + ');">' + (i + 1) + ". " + pc_getjwb[0] + "</a>";
                            }
                        }
                    } else {
                        hasil_jawaban += '<a id="btn_soal_' + (i + 1) + '" class="btn btn-default btn_soal btn-sm" onclick="return buka(' + (i + 1) + ');">' + (i + 1) + ". -</a>";
                    }
                }
                // $("#tampil_jawaban").html('<div id="yes"></div>' + hasil_jawaban);
            });
            return false;
        }
        hitung = function() {
            var tgl_mulai = '<?php echo date('Y-m-d H:i:s'); ?>';
            var tgl_selesai = '<?php echo $jam_selesai; ?>';
            var tgl_submit = '<?php echo $jam_submit; ?>';

            $("div#clock").countdowntimer({
                startDate: tgl_mulai,
                dateAndTime: tgl_selesai,
                size: "lg",
                displayFormat: "HMS",
                timeUp: timeover,
            });

            $("span#clocksubmit").countdowntimer({
                startDate: tgl_mulai,
                dateAndTime: tgl_submit,
                size: "lg",
                displayFormat: "HMS",
                timeUp: aaa,
            });

            function aaa() {
                $("span#clocksubmit").hide();
                $(".selesai").removeAttr('style');
                $(".selesai").removeClass('btn-danger');
                $(".selesai").addClass('btn-success');
            }
        }
        timeover = function() {
            var f_asal = $("#_form");
            var form = getFormData(f_asal);
            simpan_akhir_timeover(id_tes);
            window.location.assign("<?php echo base_url(); ?>adm/nilai/" + id_tes);
            return false;
        }
        selesai = function() {
            var f_asal = $("#_form");
            var form = getFormData(f_asal);
            simpan_akhir(id_tes);
            window.location.assign("<?php echo base_url(); ?>adm/nilai/" + id_tes);
            return false;
        }
        next = function() {
            var berikutnya = $(".next").attr('rel');
            berikutnya = parseInt(berikutnya);
            berikutnya = berikutnya > total_widget ? total_widget : berikutnya;
            $("#soalke").html(berikutnya);
            $(".next").attr('rel', (berikutnya + 1));
            $(".back").attr('rel', (berikutnya - 1));
            $(".ragu_ragu").attr('rel', (berikutnya));
            cek_status_ragu(berikutnya);
            // cek_terakhir(berikutnya);
            var sudah_akhir = berikutnya == total_widget ? 1 : 0;
            $(".step").hide();
            $("#widget_" + berikutnya).show();
            if (sudah_akhir == 1) {
                $(".back").show();
                $(".next").hide();
            } else if (sudah_akhir == 0) {
                $(".next").show();
                $(".back").show();
            }
            simpan_sementara();
            simpan();
        }
        back = function() {
            var back = $(".back").attr('rel');
            back = parseInt(back);
            back = back < 1 ? 1 : back;
            $("#soalke").html(back);
            $(".back").attr('rel', (back - 1));
            $(".next").attr('rel', (back + 1));
            $(".ragu_ragu").attr('rel', (back));
            cek_status_ragu(back);
            // cek_terakhir(back);
            $(".step").hide();
            $("#widget_" + back).show();
            var sudah_awal = back == 1 ? 1 : 0;
            $(".step").hide();
            $("#widget_" + back).show();
            if (sudah_awal == 1) {
                $(".back").hide();
                $(".next").show();
            } else if (sudah_awal == 0) {
                $(".next").show();
                $(".back").show();
            }
            simpan_sementara();
            simpan();
        }
        tidak_jawab = function() {
            var id_step = $(".ragu_ragu").attr('rel');
            var status_ragu = $("#rg_" + id_step).val();
            if (status_ragu == "N") {
                $("#rg_" + id_step).val('Y');
                $("#btn_soal_" + id_step).removeClass('btn-success');
                $("#btn_soal_" + id_step).addClass('btn-warning');
            } else {
                $("#rg_" + id_step).val('N');
                $("#btn_soal_" + id_step).removeClass('btn-warning');
                $("#btn_soal_" + id_step).addClass('btn-success');
            }
            cek_status_ragu(id_step);
            simpan_sementara();
            simpan();
        }
        cek_status_ragu = function(id_soal) {
            var status_ragu = $("#rg_" + id_soal).val();
            if (status_ragu == "N") {
                $(".ragu_ragu").html('<i class="fas fa-info-circle"></i> RAGU-RAGU');
            } else {
                $(".ragu_ragu").html('<i class="fas fa-info-circle"></i> TIDAK RAGU');
            }
        }
        // cek_terakhir = function(id_soal) {
        //     var jml_soal = $("#jml_soal").val();
        //     var tgl_mulai = '<?php echo date('Y-m-d H:i:s'); ?>';
        //     var tgl_submit = '<?php echo $jam_submit; ?>';
        //     jml_soal = (parseInt(jml_soal) - 1);
        //     if (jml_soal == id_soal) {
        //         $(".selesai").show();
        //         $("span#clocksubmit").countdowntimer({
        //             startDate: tgl_mulai,
        //             dateAndTime: tgl_submit,
        //             size: "lg",
        //             displayFormat: "HMS",
        //             timeUp: aaa,
        //         });

        //         function aaa() {
        //             $("span#clocksubmit").hide();
        //             $(".selesai").removeAttr('style');
        //             $(".selesai").removeClass('btn-danger');
        //             $(".selesai").addClass('btn-primary');
        //         }
        //     } else {
        //         $(".selesai").show();
        //     }
        // }
        buka = function(id_widget) {
            $(".next").attr('rel', (id_widget + 1));
            $(".back").attr('rel', (id_widget - 1));
            $(".ragu_ragu").attr('rel', (id_widget));
            cek_status_ragu(id_widget);
            // cek_terakhir(id_widget);
            $("#soalke").html(id_widget);
            $(".step").hide();
            $("#widget_" + id_widget).show();
        }
        simpan_akhir_timeover = function() {
            simpan();
            $.ajax({
                type: "GET",
                url: base_url + "adm/ikut_ujian/simpan_akhir/" + id_tes,
                beforeSend: function() {
                    $('.ajax-loading').show();
                },
                success: function(r) {
                    if (r.status == "ok") {
                        window.location.assign("<?php echo base_url(); ?>adm/nilai/" + id_tes);
                    }
                }
            });
            return false;
        }
        simpan_akhir = function() {
            simpan();
            if (swal({
                    title: "Apakah Anda Yakin?",
                    text: "Ujian akan diakhiri setelah menekan tombol Akhiri",
                    icon: "warning",
                    buttons: ["Batal", "Oke, Akhiri!"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        simpan();
                        $.ajax({
                            type: "GET",
                            url: base_url + "adm/ikut_ujian/simpan_akhir/" + id_tes,
                            beforeSend: function() {
                                $('.ajax-loading').show();
                            },
                            success: function(r) {
                                if (r.status == "ok") {
                                    window.location.assign("<?php echo base_url(); ?>adm/nilai/" + id_tes);
                                }
                            }
                        });
                    }
                }))
                return false;
        }
        show_jawaban = function() {
            $("#v_jawaban").toggle();
        }
    </script>
</body>

</html>