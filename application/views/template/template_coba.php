<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from motaadmin.dexignlab.com/laravel/demo/index-4 by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Aug 2021 05:08:20 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="3lQHvKD8Aovyg4rAphN8QMtzFsBCGpxiK60TAYz9">
  <title>MotaAdmin | Dashboard 4</title>

  <meta name="description" content="Some description for the page" />
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('') ?>assets/backend/public/images/favicon.png">
  <link href="<?= base_url('assets/backend/public/') ?>/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend/public/') ?>/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend/public/') ?>/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend') ?>/LineIcons.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend/public/') ?>/css/style.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend/public/') ?>/vendor/toastr/css/toastr.min.css" rel="stylesheet" type="text/css" />




  <link href="<?= base_url('') ?>assets/backend/public/css/style.css" rel="stylesheet" type="text/css" />
  <script>
    var base_url = "<?= base_url() ?>";
  </script>


</head>

<body>

  <!--*******************
        Preloader start
    ********************-->
  <div id="preloader">
    <div class="sk-three-bounce">
      <div class="sk-child sk-bounce1"></div>
      <div class="sk-child sk-bounce2"></div>
      <div class="sk-child sk-bounce3"></div>
    </div>
  </div>
  <!--*******************
        Preloader end
    ********************-->

  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">

    <!--**********************************
            Nav header start
        ***********************************-->
    <div class="nav-header">
      <a href="index.html" class="brand-logo">
        <img class="logo-abbr" src="<?= base_url('') ?>assets/backend/public/images/logo-white.png" alt="">
        <img class="logo-compact" src="<?= base_url('') ?>assets/backend/public/images/logo-text-white.png" alt="">
        <img class="brand-title" src="<?= base_url('') ?>assets/backend/public/images/logo-text-white.png" alt="">

      </a>

      <div class="nav-control">
        <div class="hamburger">
          <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
      </div>
    </div>
    <!--**********************************
            Nav header end
        ***********************************-->

    <!--**********************************
            Chat box start
        ***********************************-->
    <!--**********************************
  Chat box start
***********************************-->

    <!--**********************************
  Chat box End
***********************************-->
    <!--**********************************
            Chat box End
        ***********************************-->

    <!--**********************************
            Header start
        ***********************************-->

    <!--**********************************
  Header start
***********************************-->
    <div class="header">
      <div class="header-content">
        <nav class="navbar navbar-expand">
          <div class="collapse navbar-collapse justify-content-between">
            <div class="header-left">

            </div>

            <ul class="navbar-nav header-right">
              <li class="nav-item dropdown notification_dropdown">
                <a class="nav-link bell dz-fullscreen" href="#">
                  <svg id="icon-full" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                  </svg>
                  <svg id="icon-minimize" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minimize">
                    <path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"></path>
                  </svg>
                </a>
              </li>
              <li class="nav-item dropdown notification_dropdown">
                <a class="nav-link bell ai-icon" href="#" role="button" data-toggle="dropdown">
                  <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                  </svg>
                  <div class="pulse-css"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3" style="height:380px;">
                    <ul class="timeline">
                      <li>
                        <div class="timeline-panel">
                          <div class="media mr-2">
                            <img alt="image" width="50" src="<?= base_url('') ?>assets/backend/public/images/avatar/1.jpg">
                          </div>
                          <div class="media-body">
                            <h6 class="mb-1">Dr sultads Send you Photo</h6>
                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="timeline-panel">
                          <div class="media mr-2 media-info">
                            KG
                          </div>
                          <div class="media-body">
                            <h6 class="mb-1">Resport created successfully</h6>
                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="timeline-panel">
                          <div class="media mr-2 media-success">
                            <i class="fa fa-home"></i>
                          </div>
                          <div class="media-body">
                            <h6 class="mb-1">Reminder : Treatment Time!</h6>
                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="timeline-panel">
                          <div class="media mr-2">
                            <img alt="image" width="50" src="<?= base_url('') ?>assets/backend/public/images/avatar/1.jpg">
                          </div>
                          <div class="media-body">
                            <h6 class="mb-1">Dr sultads Send you Photo</h6>
                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="timeline-panel">
                          <div class="media mr-2 media-danger">
                            KG
                          </div>
                          <div class="media-body">
                            <h6 class="mb-1">Resport created successfully</h6>
                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="timeline-panel">
                          <div class="media mr-2 media-primary">
                            <i class="fa fa-home"></i>
                          </div>
                          <div class="media-body">
                            <h6 class="mb-1">Reminder : Treatment Time!</h6>
                            <small class="d-block">29 July 2020 - 02:26 PM</small>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <a class="all-notification" href="#">See all notifications <i class="ti-arrow-right"></i></a>
                </div>
              </li>
              <li class="nav-item dropdown header-profile">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                  <img src="<?= base_url('') ?>assets/backend/public/images/profile/pic1.jpg" width="20" alt="" />
                  <div class="header-info">
                    <span>Hey, <strong>Joshua</strong></span>
                    <small>Business Profile</small>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="app-profile.html" class="dropdown-item ai-icon">
                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                      <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="ml-2">Profile </span>
                  </a>
                  <a href="email-inbox.html" class="dropdown-item ai-icon">
                    <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                      <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span class="ml-2">Inbox </span>
                  </a>
                  <a href="page-login.html" class="dropdown-item ai-icon">
                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                      <polyline points="16 17 21 12 16 7"></polyline>
                      <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="ml-2">Logout </span>
                  </a>
                </div>
              </li>

            </ul>
          </div>
        </nav>
      </div>
    </div>
    <!--**********************************
  Header end ti-comment-alt
***********************************-->

    <!--**********************************
  Sidebar start
***********************************-->
    <div class="deznav">
      <div class="deznav-scroll">
        <ul class="metismenu" id="menu">

          <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24" />
                  <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
                  <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
                </g>
              </svg>
              <span class="nav-text">Dashboard</span>
            </a>
            <ul aria-expanded="false">
              <li><a href="index.html">Light</a></li>
              <li><a href="index-2.html">Dark</a></li>
              <li><a href="index-3.html">Mini Sidebar</a></li>
              <li><a href="index-4.html">Sidebar</a></li>
            </ul>
          </li>



        </ul>
      </div>


    </div>

    <div class="content-body">
      <!-- row -->
      <!-- row -->
      <div class="container-fluid">
        <?= $breadcrumb ?>
        <?= $contents ?>
      </div>
    </div>

    <script src="<?= base_url('assets/backend/public/') ?>/vendor/global/global.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/vendor/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/vendor/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/vendor/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/vendor/toastr/js/toastr.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/js/plugins-init/toastr-init.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/vendor/chart.js/Chart.bundle.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/vendor/apexchart/apexchart.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/vendor/peity/jquery.peity.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/vendor/chartist/js/chartist.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/vendor/svganimation/vivus.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/vendor/svganimation/svg.animation.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/js/custom.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/backend/public/') ?>/js/dashboard/dashboard-4.js" type="text/javascript"></script>
</body>

<!-- Mirrored from motaadmin.dexignlab.com/laravel/demo/index-4 by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Aug 2021 05:09:09 GMT -->
<script>
  function info() {
    toastr.info('Mengubah Posisi', "Berhasil", {
      timeOut: 3000,
      closeButton: !0,
      debug: !1,
      newestOnTop: !0,
      progressBar: !0,
      positionClass: "toast-top-right",
      preventDuplicates: !0,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
      tapToDismiss: !1
    })

  }

  function sukses(msg) {
    toastr.success(msg, "Berhasil", {
      timeOut: 3000,
      closeButton: !0,
      debug: !1,
      newestOnTop: !0,
      progressBar: !0,
      positionClass: "toast-top-right",
      preventDuplicates: !0,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
      tapToDismiss: !1
    })
  }
</script>

</html>