<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="3lQHvKD8Aovyg4rAphN8QMtzFsBCGpxiK60TAYz9">
  <title><?= $title ?> | SPPIRT BPOM RI</title>

  <meta name="description" content="SPPIRT BPOM RI Terintegrasi OSS" />
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/backend/public/') ?>/images/favicon.png">
  <link href="<?= base_url('assets/backend/public/') ?>/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend/') ?>public/vendor/jquery-steps/css/jquery.steps.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend/public/') ?>/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend/public/') ?>/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend') ?>/LineIcons.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend/public/') ?>/css/style.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend/public/') ?>/vendor/toastr/css/toastr.min.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/backend/public/') ?>crop/css/cropper.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/public/select2/css/select2.min.css">

  <script>
    var base_url = "<?= base_url() ?>";
  </script>

  <style>
    .btn-primary {
      background-color: #3fbbc0;
      border-color: #3fbbc0;
    }

    [data-nav-headerbg="color_3"][data-theme-version="dark"] .nav-header,
    [data-nav-headerbg="color_3"] .nav-header {
      background-color: #3fbbc0;
    }

    .nav-header .brand-title {
      margin-left: 8px;
      max-width: 160px;
    }

    .nav-header .logo-abbr {
      max-width: 50px;
    }
  </style>

  <style type="text/css">
  .box-loading{
      position: fixed; 
      z-index: 99999999999999999; 
      width: 100%; 
      height: 100%; 
      background: rgba(000,000,000,0.5); top: 0; 
      padding-top: 25%;
      display: none;
  }
  .loader,
  .loader:after {
    border-radius: 50%;
    width: 10em;
    height: 10em;
  }
  .loader {
    margin: auto;
    font-size: 10px;
    position: relative;
    text-indent: -9999em;
    border-top: 1.1em solid rgba(255,255,255, 0.2);
    border-right: 1.1em solid rgba(255,255,255, 0.2);
    border-bottom: 1.1em solid rgba(255,255,255, 0.2);
    border-left: 1.1em solid #FFF;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-animation: load8 1.1s infinite linear;
    animation: load8 1.1s infinite linear;
  }
  @-webkit-keyframes load8 {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
  @keyframes load8 {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
  </style>

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
      <a href="#" class="brand-logo">
        <img class="logo-abbr" src="<?= base_url() ?>assets/backend/image/sidebarlogo.png" alt="">
        <!-- <img class="logo-compact" src="<?= base_url() ?>assets/login/images/bg.jpg" alt=""> -->
        <img class="brand-title" src="<?= base_url() ?>assets/backend/image/sidebarlogo2.png" alt="">

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
              <!-- <div class="search_bar dropdown">
            <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
              <i class="mdi mdi-magnify"></i>
            </span>
            <div class="dropdown-menu p-0 m-0">
              <form>
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
              </form>
            </div>
          </div> -->
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

              <li class="nav-item notification_dropdown">

                  <a class="nav-link bell ai-icon" href="#" role="button" data-toggle="dropdown">
                    <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                      <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                      <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>

                    <?php

                      $this->db->from('tb_notification');
                      $this->db->where('read','0');
                      $this->db->where('user_id',$this->session->userdata("userData")['id']);
                      $this->db->order_by('created_at','DESC');
                      $this->db->limit(5);
                      $notification =  $this->db->get()->result();
         
                      ?>

                     <?php 
                     $total_notification = count($notification);
                     if ($total_notification>0){ ?> 
                    <div class="badge badge-danger"><?php echo $total_notification; ?></div>
                    <?php } ?>

                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3">
                      <ul class="timeline">

                        
                        <?php if ($total_notification>0){ ?>
                          <?php foreach ($notification as $key => $value) { ?>
                            <li>
                              <a href="<?php echo base_url(); ?>notif/read/<?php echo encrypt_decrypt('encrypt',$value->id); ?>">
                                <div class="timeline-panel">
                                  <div class="media mr-2">
                                    <div class="bell ai-icon">
                                      <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="media-body">
                                    <h6 class="mb-1"><?php echo $value->type; ?></h6>
                                    <span><?php echo $value->keterangan; ?></span>
                                  </div>
                                </div>
                              </a>
                            </li>
                          <?php } ?>
                        <?php  }else{ ?>
                          <h6 class="mb-1">Tidak ada notifikasi</h6>
                        <?php } ?>
                      </ul>
                    </div>
                  </div>
                </li>

              <?php $session = $this->session->userdata("userData")['id_role'];
              if ($session != 2) {
              ?>
                <li class="nav-item notification_dropdown">

                  <a class="nav-link bell ai-icon" href="#" role="button" data-toggle="dropdown">
                    <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                      <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                      <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <?php
                    $tipe = 'backend';
                    $sessionkab = $this->session->userdata("userData")['id_kota'];
                    $sessionprov = $this->session->userdata("userData")['id_prov'];

                    $this->db->select('COUNT(*) as notifikasi');
                    $this->db->from('tb_notifikasi');
                    if ($session == 1) {
                      $this->db->where(['notifikasi_admin' => '0', 'status' => '2']);
                    } else if ($session == 3) {
                      $this->db->where(['notifikasi_dinkeskab', '0', 'status' => '2']);
                      $this->db->where('id_kab', $sessionkab);
                    } else if ($session == 4) {
                      $this->db->where(['notifikasi_ptsp', '0', 'status' => '2']);
                      $this->db->where('id_kab', $sessionkab);
                    } else if ($session == 5) {
                      $this->db->where(['notifikasi_dinkesprov', '0', 'status' => '2']);
                      $this->db->where('id_prov', $sessionprov);
                    }
                    $notif_diterima =  $this->db->get()->row();

                    // Notifikasi di tolak
                    $this->db->select('COUNT(*) as notifikasi_ditolak');
                    $this->db->from('tb_notifikasi');
                    if ($session == 1) {
                      $this->db->where('notifikasi_admin', '0');
                      $this->db->where_in('status', ['0', '1']);
                    } else if ($session == 3) {
                      $this->db->where('notifikasi_dinkeskab', '0');
                      $this->db->where_in('status', ['0', '1']);
                      $this->db->where('id_kab', $sessionkab);
                    } else if ($session == 4) {
                      $this->db->where('notifikasi_ptsp', '0');
                      $this->db->where_in('status', ['0', '1']);
                      $this->db->where('id_kab', $sessionkab);
                    } else if ($session == 5) {
                      $this->db->where('notifikasi_dinkesprov', '0');
                      $this->db->where_in('status', ['0', '1']);
                      $this->db->where('id_prov', $sessionprov);
                    }
                    $notif_ditolak =  $this->db->get()->row();

                    // echo $notif->notifikasi;
                    if ($session != 2 && $notif_diterima->notifikasi != 0 ||  $notif_ditolak->notifikasi_ditolak != 0) { ?>
                      <div class="pulse-css"></div>
                    <?php } ?>

                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3">
                      <ul class="timeline">
                        <?php if ($notif_diterima->notifikasi != 0) { ?>
                          <li>
                            <a href="<?= base_url('backend/Notifikasi/list/diterima') ?>">
                              <div class="timeline-panel">
                                <div class="media mr-2">
                                  <div class="bell ai-icon">
                                    <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                      <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                      <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                    </svg>
                                  </div>
                                </div>
                                <div class="media-body">
                                  <h6 class="mb-1">Terdapat <?= $notif_diterima->notifikasi ?> usulan baru yang diterbitkan</h6>
                                </div>
                              </div>
                            </a>
                          </li>

                        <?php   } ?>
                        <?php if ($notif_ditolak->notifikasi_ditolak != 0) { ?>
                          <li>
                            <a href="<?= base_url('backend/Notifikasi/list/ditolak') ?>">
                              <div class="timeline-panel">
                                <div class="media mr-2">
                                  <div class="bell ai-icon">
                                    <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                      <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                      <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                    </svg>
                                  </div>
                                </div>
                                <div class="media-body">
                                  <h6 class="mb-1">Terdapat <?= $notif_ditolak->notifikasi_ditolak ?> usulan baru yang ditolak</h6>
                                </div>
                              </div>
                            </a>
                          </li>
                        <?php  }
                        if ($notif_diterima->notifikasi == 0 && $notif_ditolak->notifikasi_ditolak == 0) {

                          echo '<h6 class="mb-1">Tidak ada notifikasi</h6>';
                        } ?>
                      </ul>
                    </div>
                  </div>
                </li>
              <?php } ?>
              <li class="nav-item dropdown header-profile">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown">


                  <?php if (isset($this->session->userdata("userData")['picture']) && $this->session->userdata("userData")['picture'] == null || $this->session->userdata("userData")['picture'] == "") { ?>
                    <img src="<?= base_url('assets/backend/public/') ?>/images/profile/pic1.jpg" width="20" alt="" />
                  <?php } else { ?>
                    <img src="<?php echo $this->session->userdata("userData")['picture']; ?>" width="20" alt="" />
                  <?php } ?>

                  <div class="header-info">
                    <span>Halo, <strong><?php echo $this->session->userdata("userData")['nama']; ?></strong></span>
                    <small>Level User: <?php echo $this->session->userdata("userData")['role']; ?></small>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="<?php echo base_url(); ?>account" class="dropdown-item ai-icon">
                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                      <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="ml-2">Profile </span>
                  </a>
                  <a href="<?php echo base_url(); ?>account?tab=ubah-password" class="dropdown-item ai-icon">
                    <svg id="icon-unclock" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M15.6274517,4.55882251 L14.4693753,6.2959371 C13.9280401,5.51296885 13.0239252,5 12,5 C10.3431458,5 9,6.34314575 9,8 L9,10 L14,10 L17,10 L18,10 C19.1045695,10 20,10.8954305 20,12 L20,18 C20,19.1045695 19.1045695,20 18,20 L6,20 C4.8954305,20 4,19.1045695 4,18 L4,12 C4,10.8954305 4.8954305,10 6,10 L7,10 L7,8 C7,5.23857625 9.23857625,3 12,3 C13.4280904,3 14.7163444,3.59871093 15.6274517,4.55882251 Z" fill="#3A7AFE" />
                    </svg>
                    <span class="ml-2">Ubah Password </span>
                  </a>
                  <a href="<?php echo base_url(); ?>logout" class="dropdown-item ai-icon">
                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                      <polyline points="16 17 21 12 16 7"></polyline>
                      <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="ml-2">Logout </span>
                  </a>
                </div>
              </li>
              <!-- <li class="nav-item right-sidebar">
            <a class="nav-link bell ai-icon" href="#">
              <svg id="icon-menu" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            </a>
          </li> -->
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
          <?php $tipe = 'backend';
          $menu_labels = getMenu(0, $tipe);  ?>
          <?php foreach ($menu_labels as $menu_label) : $first = $menu_label['posisi'] == 1 ? 'first' : '';  ?>
            <li class="nav-label <?= $first ?>"><?= $menu_label['nama_menu'] ?></li>
            <?php $first_menus = getMenu($menu_label['id_menu'], $tipe); ?>

            <?php foreach ($first_menus as $first_menu) : ?>
              <?php if ($first_menu['menu_flag_link'] == 1) : ?>
                <li>
                  <a href="<?= base_url('backend/' . $first_menu['menu_url']) ?>" class="ai-icon" aria-expanded="false">
                    <i class="fa fa-<?= $first_menu['menu_icon_parent'] ?> mr-2"></i>
                    <span class="nav-text">
                      <?= $first_menu['nama_menu'] ?>
                    </span>
                  </a>
                </li>
              <?php else : ?>

                <?php $second_menus = getMenu($first_menu['id_menu'], $tipe); ?>

                <li>
                  <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-<?= $first_menu['menu_icon_parent'] ?> mr-2"></i>
                    <span class="nav-text">
                      <?= $first_menu['nama_menu'] ?>
                    </span>
                  </a>
                  <ul aria-expanded="false">
                    <?php foreach ($second_menus as $second_menu) : ?>
                      <li><a href="<?= base_url('backend/' . $second_menu['menu_url']) ?>"><?= $second_menu['nama_menu'] ?></a></li>
                    <?php endforeach ?>
                  </ul>
                </li>

              <?php endif ?>
            <?php endforeach ?>


          <?php endforeach ?>
        </ul>
      </div>


    </div>
    <!--**********************************
  Sidebar end
***********************************-->

    <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
      <!-- row -->
      <!-- row -->
      <script src="<?= base_url('assets/backend/public/') ?>/vendor/global/global.min.js" type="text/javascript"></script>
      <script src="<?= base_url('assets/backend/public/') ?>/vendor/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
      <?php if ($this->uri->segment(1) != 'user' && $this->uri->segment(1) != 'account' && $this->uri->segment(2) != 'rekap' && ($this->uri->segment(2) != 'irtp' && $this->uri->segment(3) != 'list' && $this->uri->segment(2) != 'verifikasi-produk' && $this->uri->segment(2) != 'verifikasi-label' && $this->uri->segment(2) != 'verifikasi-pkp' && $this->uri->segment(2) != 'verifikasi-cara-pembuatan' && $this->uri->segment(2) != 'status-pemenuhan-komitmen')) { ?>
        <script src="<?= base_url('assets/backend/public/') ?>/vendor/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
      <?php } ?>
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

      <script src="<?= base_url('assets/backend/public/') ?>crop/js/cropper.js" type="text/javascript"></script>

      <script src="<?php echo base_url(); ?>assets/backend/public/select2/js/select2.min.js"></script>
      
      <div class="container-fluid">
        <?= $breadcrumb ?>
        <?= $contents ?>
      </div>
    </div>
    <!--**********************************
            Content body end
        ***********************************-->


    <!--**********************************
            Footer start
        ***********************************-->

    <!--**********************************
  Footer start
***********************************-->
    <div class="footer">
      <div class="copyright">
        <p>Copyright © SPPIRT BPOM RI Terintegrasi OSS. Powered by <a href="https://pom.go.id/" target="_blank">BPOM RI</a> 2021</p>
      </div>
    </div>
    <!--**********************************
  Footer end
***********************************-->
    <!--**********************************
            Footer end
        ***********************************-->

    <!--**********************************
           Support ticket button start
        ***********************************-->

    <!--**********************************
           Support ticket button end
        ***********************************-->


  </div>
  <!--**********************************
        Main wrapper end
    ***********************************-->

  <!--**********************************
        Scripts
    ***********************************-->

    <div class="box-loading">
      <div class="loader">Loading...</div>
  </div>

</body>

<style type="text/css">
    .swal2-select{
        display: none !important;
    }
</style>

<?php if($this->session->flashdata('error')){ ?>
    <script language='JavaScript'>
        swal({
        type: 'error',
        title: 'Oops...',
        text: "<?php echo $this->session->flashdata('error'); ?>",
        });
    </script>
    <?php }else if($this->session->flashdata('success')){ ?>
    <script language='JavaScript'>
        swal({
        type: 'success',
        title: 'Success',
        text: "<?php echo $this->session->flashdata('success'); ?>",
        });
    </script>
<?php } ?>
<script src="https://unpkg.com/@yaireo/tagify"></script>
  <script src="https://unpkg.com/@yaireo/tagify@3.1.0/dist/tagify.polyfills.min.js"></script>
  <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
  <script>
    var input = document.getElementById('isi_bersih_produk')
    var tagify = new Tagify(input, {
      
    })
      </script>
<script>

  $('.select2').select2();
  
  

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

  function alerts(msg = null) {
    toastr.info(msg, "", {
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

  function warning(msg) {
    toastr.warning(msg, "Gagal", {
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

  function sendData(id){

    swal({
        title: 'Are you sure?',
        text: "Anda yakin akan kirim data ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.value) {
            window.location.href = "<?php echo base_url('backend/Irtp/send_data/'); ?>"+id;
        }
    })

  }

  function sendData2(){

    var id = $('#id_pengajuan').val();

    swal({
        title: 'Are you sure?',
        text: "Anda yakin akan kirim data ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.value) {
            window.location.href = "<?php echo base_url('backend/Irtp/send_data/'); ?>"+id;
        }
    })

  }


</script>

</html>