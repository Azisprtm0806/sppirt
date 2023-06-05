<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= $title; ?></title>
  <meta name="description" content="Aplikasi SPPIRT BPOM Terintegrasi Sistem OSS Kementerian Maritim dan Investasi" >
  <meta name="keywords" content="SPPIRT, OSS, BPOM, BKPM, Kementerian Maves, Kementerian Investasi, Badan POM">

  <!-- Favicons -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/backend/public/') ?>/images/favicon.png">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url() ?>assets/frontend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/frontend/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/frontend/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/frontend/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/frontend/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/frontend/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="<?= base_url('assets/backend/public/') ?>/vendor/toastr/css/toastr.min.css" rel="stylesheet" type="text/css" />

  <!-- Template Main CSS File -->
  <link href="<?= base_url() ?>assets/frontend/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Eterna - v2.2.1
  * Template URL: https://bootstrapmade.com/eterna-free-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <script>
    var base_url = "<?= base_url() ?>";
  </script>
  <style>
    .img-fluid {
      border-radius: 10px;
    }

    .card-header {
      background-color: rgb(79 187 192 / 14%);
    }

    #footer .footer-top h4 {
      color: #FFCC00;
    }
  </style>

</head>

<body>
  <script src="<?= base_url() ?>assets/frontend/vendor/jquery/jquery.min.js"></script>
  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-none d-lg-block">
    <div class="container d-flex">
      <div class="contact-info mr-auto">
        <i class="icofont-envelope"></i><a href="mailto:
subditp3d.pmpu@gmail.com">
          subditp3d.pmpu@gmail.com</a>
        <i class="icofont-phone"></i> (+62) 21 42878701 / 42875738
      </div>
      <!-- <div class="social-links">
        <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
        <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
        <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
        <a href="#" class="skype"><i class="icofont-skype"></i></a>
        <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
      </div> -->
    </div>
  </section>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container d-flex">

      <div class="logo mr-auto">

        <a href="<?= base_url(''); ?>">
          <img src="<?= base_url() ?>assets/frontend/img/logoSPPIRT.png" alt="" class="img-fluid">
        </a>
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <?php $parents = getMenuFrontEnd(0) ?>
            <?php 
              $segs = $this->uri->segment_array();
              $totalSegs = count($segs);
              $link = '';
              for ($i = 1; $i <= $totalSegs; $i++) {
                  if ($segs[$i] === $segs[$totalSegs]) {
                      $link .= $segs[$i];
                  } else {
                      $link .= $segs[$i] . "/";
                  }
              }
             ?>
          <?php foreach ($parents as $parent): ?>



            <?php $childs = getMenuFrontEnd($parent['id_menu']) ?>
            <?php if ($parent['menu_flag_link'] == 1): ?>
              <li class="<?= $link == $parent['menu_url'] ? 'active' : '' ?>"><a href="<?= base_url().$parent['menu_url'] ?>"><?= $parent['nama_menu'] ?></a></li>
            <?php else: ?>
              <li class="drop-down"><a href="#"><?= $parent['nama_menu'] ?></a>
                <ul>
                  <?php foreach ($childs as $child): ?>
                    <li><a href="<?= $child['menu_url'] ?>"><?= $child['nama_menu'] ?></a></li>
                  <?php endforeach ?>
                </ul>
              </li>
            <?php endif ?>
          <?php endforeach ?>

          <!-- <li class="drop-down"><a href="#">About</a>
            <ul>
              <li><a href="about.html">About Us</a></li>
              <li><a href="team.html">Team</a></li>

              <li class="drop-down"><a href="#">Drop Down 2</a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
            </ul>
          </li> -->
<!-- 
          <li><a href="<?= base_url() ?>regulasi">Regulasi</a></li>
          <li><a href="<?= base_url() ?>panduan">Panduan</a></li>
          <li><a href="<?= base_url() ?>kontak">Kontak</a></li>
          <li><a href="<?= base_url() ?>berita">Berita</a></li>
          <li><a href="<?= base_url() ?>galeri">Galeri</a></li>
          <li><a href="<?= base_url() ?>faq">FAQ</a></li> -->
          <li><a class="btn btn-primary" 
          style="
            margin-left: 30px;
            margin-top: 4px;
            padding: 10px 30px;
            color: white;
            background-color: #FFCC00;
            border: none;" href="<?= base_url('login') ?>">Log In</a></li>


        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->
  <!-- <div>
    <marquee>
      <font color="red" face="courier new"><b>&raquo; INFO PENTING:</b> Aplikasi SPPIRT akan dilakukan MAINTENANCE terkait major updating fitur pengawasan pada <b>Hari Sabtu s/d Senin, 21-23 Januari 2023</b>, sehingga layanan pada aplikasi SPPIRT akan dihentikan sementara.. Aplikasi SPPIRT dapat diakses kembali pada hari Selasa, 24 Januari 2023...</font>
    </marquee>
  </div> -->


  <?= $contents ?>

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6 footer-links">
            <img src="<?= base_url() ?>assets/frontend/img/logo_footer.png" alt="" class="mb-3" style="width: 240px; height:auto">
            <p style="text-align: justify;">
              Aplikasi SPPIRT Badan POM Republik Indonesia telah terintegrasi dengan Sistem OSS (One Single Submission) Kementerian Perekonomian dan Investasi. NIB menjadi kunci utama agar pelaku usaha dapat mendaftarkan produknya pada aplikasi SPPIRT ini. Apabila belum memiliki NIB silahkan untuk mendaftar pada sistem OSS terlebih dahulu.
            </p>
          </div>

          <div class="col-lg-4 col-md-6 footer-links">
            <h4 class="footheader">Informasi Terkait</h4>
            <p>
              Silahkan klik link di bawah ini apabila ingin mengetahui informasi lain yang berkaitan dengan Aplikasi SPPIRT BPOM.
            </p>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://pom.go.id">Website BPOM RI</a></li>
              <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://oss.go.id">Sistem OSS</a></li>
              <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="https://jdih.pom.go.id">Peraturan (JDIH BPOM RI)</a></li>
            </ul>
          </div>

          <!-- <div class="col-lg-3 col-md-6 footer-links">
            <h4>SPPIRT CENTER</h4>
            <p>
              Anda dapat menghubungi kami pada hari kerja (senin s/d jum'at) melalui beberapa kontak berikut ini.
            </p>
            <ul>
              <li><i class="bx bx-phone-call mr-1"></i>(+62) 21 42878701 / 42875738</li>
              <li><i class="bx bx-mail-send mr-1"></i> <a href="#">subditp3d.pmpu@gmail.com</a></li>
            </ul>
          </div> -->

          <div class="col-lg-4 col-md-6 footer-contact">
            <h4>ALAMAT KAMI</h4>
            <p>
              Direktorat Pemberdayaan Masyarakat dan Pelaku Usaha. Badan Pengawas Obat dan Makanan Republik Indonesia, Jl. Percetakan Negara No. 23 Jakarta Pusat 10560
            </p>
            <p>
              Anda dapat menghubungi kami pada hari kerja (senin s/d jum'at) melalui beberapa kontak berikut ini.
            </p>
            <ul>
              <li><i class="bx bx-phone-call mr-1"></i><a href="tel:622142878701">(+62) 21 42878701 / 42875738</a></li>
              <li><i class="bx bx-mail-send mr-1"></i> <a href="mailto:subditp3d.pmpu@gmail.com">subditp3d.pmpu@gmail.com</a></li>
            </ul>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        Copyright &copy; 2021 - <?= date('Y'); ?> :: <strong><span>Aplikasi SPPIRT BPOM RI Terintegrasi OSS</span></strong>. All Rights Reserved.
      </div>
      <div class="credits">
        Powered by <a href="https://www.pom.go.id">Badan POM Republik Indonesia</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= base_url() ?>assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/frontend/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="<?= base_url() ?>assets/frontend/vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url('assets/backend/public/') ?>/vendor/toastr/js/toastr.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/backend/public/') ?>/js/plugins-init/toastr-init.js" type="text/javascript"></script>
  <script src="<?= base_url() ?>assets/frontend/vendor/jquery-sticky/jquery.sticky.js"></script>
  <script src="<?= base_url() ?>assets/frontend/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="<?= base_url() ?>assets/frontend/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="<?= base_url() ?>assets/frontend/vendor/counterup/counterup.min.js"></script>
  <script src="<?= base_url() ?>assets/frontend/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= base_url() ?>assets/frontend/vendor/venobox/venobox.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url() ?>assets/frontend/js/main.js"></script>

  <!--Start of Tawk.to Script-->
<script type="text/javascript">
            

var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
(
    function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/5befb84c40105007f378688a/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    }
)
();
</script>
<!--End of Tawk.to Script-->

</body>

</html>
