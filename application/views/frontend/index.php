<style>
  #hero {
    height: 75vh;
  }

  #hero .carousel-item {
    height: 75vh;
  }

  #hero .carousel-content {
    margin-top: -50px;
  }

  .carousel-control-next,
  .carousel-control-prev {
    top: -50px;
  }

  .blog {
    padding-bottom: 90px;
  }
</style>

<!-- <marquee behaviour="alternate">
  <font face="courier new" color="red"><b>Pengajuan SPPIRT hanya dilakukan dengan terlebih dahulu membuat usulan pada sistem OSS..</b></font>
</marquee> -->
<!-- ======= Hero Section ======= -->
<section id="hero">
  <div class="hero-container">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

      <!-- <ol class="carousel-indicators" id="hero-carousel-indicators"></ol> -->

      <div class="carousel-inner" role="listbox">

        <!-- Slide 1 -->
        <?php $no =0;foreach ($slider as $slide): ?>
          
        <div class="carousel-item <?= $no++ == 1 ? 'active' : '' ?>" style="background: url(<?= base_url('uploads/slider/').$slide['gambar_slider'] ?>); background-size: 100%;">
          <div class="carousel-container">
            <div class="carousel-content">

			  <!-- <h2 class="animate__animated animate__fadeInDown">INFO PENTING <span>SPPIRT:</span></h2> -->
              <!-- <h2 class="animate__animated animate__fadeInDown">SPPIRT Terintegrasi <span>OSS</span></h2> -->
        <!--
			  <p class="animate__animated animate__fadeInUp">
				Aplikasi SPPIRT Badan POM Republik Indonesia telah terintegrasi dengan Sistem OSS <i>(One Single Submission)</i>. Pendaftaran akun SPPIRT dan pengajuan SPPIRT dapat dilakukan melalui link pemenuhan komitmen dari Sistem OSS yang nantinya akan diarahkan ke halaman registrasi Aplikasi SPPIRT.
			  </p>
      -->
			  
			  <!--
			  <p class="animate__animated animate__fadeInUp"><font color="red">
				Aplikasi SPPIRT Badan POM Republik Indonesia saat ini SEDANG DIKEMBANGKAN  agar dapat terintegrasi dengan Sistem OSS <i>(One Single Submission)</i>. Untuk sementara sistem SPPIRT belum dapat digunakan. Mohon bersabar menunggu sampai proses integrasi selesai. <br><br>Terimakasih.
			  </font></p>
			  -->
              <!--<a href="https://oss.go.id" target="_blank" class="btn-get-started animate__animated animate__fadeInUp">Daftarkan Produk Pangan</a> -->
            </div>
          </div>
        </div>
        <?php endforeach ?>

        <!-- Slide 2
          <div class="carousel-item" style="background: url(<?= base_url() ?>assets/frontend/img/slide/slide-2.jpg)">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated fanimate__adeInDown">Lorem <span>Ipsum Dolor</span></h2>
                <p class="animate__animated animate__fadeInUp">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam. Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus deleniti vel. Minus et tempore modi architecto.</p>
                <a href="" class="btn-get-started animate__animated animate__fadeInUp">Read More</a>
              </div>
            </div>
          </div>

          Slide 3 
          <div class="carousel-item" style="background: url(<?= base_url() ?>assets/frontend/img/slide/slide-3.jpg)">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">Sequi ea <span>Dime Lara</span></h2>
                <p class="animate__animated animate__fadeInUp">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam. Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus deleniti vel. Minus et tempore modi architecto.</p>
                <a href="" class="btn-get-started animate__animated animate__fadeInUp">Read More</a>
              </div>
            </div>
          </div> -->

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon icofont-rounded-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon icofont-rounded-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>
  </div>
</section><!-- End Hero -->

<main id="main">

  <!-- ======= Featured Section ======= -->
  <section id="featured" class="featured">
    <div class="container">

      <div class="row" style="margin-top: 110px;">
        <div class="col-lg-4">
          <div class="icon-box">
            <i class="icofont-gears"></i>
            <h3><a href="#"> Terintegrasi OSS</a></h3>
            <p>Aplikasi SPPIRT telah terintegrasi dengan sistem OSS untuk validasi data NIB</p>
          </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="icon-box">
            <i class="icofont-globe"></i>
            <h3><a href="#">Pelayanan Online</a></h3>
            <p>Pelayanan menjadi lebih mudah, cepat, efektif dan efisien</p>
          </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="icon-box">
            <i class="icofont-hour-glass"></i>
            <h3><a href="#">Data Real Time</a></h3>
            <p>Data SPPIRT dapat diakses kapan saja dan di mana saja secara real time</p>
          </div>
        </div>
      </div>

    </div>
  </section>
  <!-- End Featured Section -->

  <!-- ======= Blog Section ======= -->
  <section id="blog" class="blog">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Berita Aktual</h2>
      </div>

      <div class="row">
        <?php foreach ($berita as $br) { ?>
          <div class="col-lg-4 entries">
            <article class="entry">

              <div class="entry-img">
                <img src="<?= base_url('uploads/berita/thumbnail/') . $br['gambar_berita'] ?>" alt="" class="img-fluid">
              </div>

              <h2 class="entry-title">
                <a href="<?= base_url('Home/detail_berita/') . encrypt_decrypt('encrypt', $br['id_berita']); ?>"><?= $br['judul_berita'] ?></a>
              </h2>

              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="icofont-user"></i> Admin</li>
                  <li class="d-flex align-items-center"><i class="icofont-wall-clock"></i> <time datetime="2020-01-01"><?= $br['tgl_berita'] ?></time></li>
                </ul>
              </div>

              <div class="entry-content">
                <p>
                  <?= substr($br['deskripsi_berita'], 0, 100); ?>
                </p>
                <div class="read-more">
                  <a href="<?= base_url('Home/detail_berita/') . encrypt_decrypt('encrypt', $br['id_berita']); ?>">Lihat detail ...</a>
                </div>
              </div>

            </article><!-- End blog entry -->
          </div>
        <?php } ?>

      </div>
      <div class="read-more text-center" style="text-transform: capitalize; font-size: 20px;">
        <a href="<?= base_url('berita/'); ?>">Lihat Berita Aktual Lainnya &raquo;</a>
      </div>
    </div>

  </section>
  <!-- End Blog Section -->

  <!-- ======= About Section ======= -->
  <section id="about" class="about">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Tentang Kami</h2>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <img src="<?= base_url() ?>assets/frontend/img/tentang.png" class="img-fluid" alt="">
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0 content">
          <p style="text-align: justify;">Salah satu tugas pokok dan fungsi Deputi Bidang Pengawasan Pangan Olahan adalah adalah melaksanakan pengawasan dan pembinaan di bidang keamanan pangan. Dalam rangka meningkatkan pembinaan dan pengawasan Industri Rumah Tangga Pangan (IRTP) dan tata hubungan kerja dengan dengan Pemerintah Daerah khususnya Dinas Kesehatan Kabupaten/ Kota di seluruh Indonesia, BPOM telah menerbitkan Peraturan Badan Pengawas obat dan Makanan RI Nomor 22 pada tahun 2018 tentang Pedoman Pemberian Sertifikat Produksi Pangan Industri Rumah Tangga. Pada tahun 2021, Badan POM telah membangun aplikasi SPPIRT yang terintegrasi dengan OSS (One Single Submission) dari Kementerian Koordinator Perekonomian dan Investasi. Aplikasi SPPIRT ini dapat dipergunakan oleh para pelaku usaha untuk mengajukan permohonan nomor PIRT dengan syarat sudah memiliki NIB yang telah didapatkan dari sistem OSS.</p>
          <!-- <p class="font-italic">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua.
          </p> -->
          <!-- <ul>
            <li><i class="icofont-check-circled"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
            <li><i class="icofont-check-circled"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
            <li><i class="icofont-check-circled"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
          </ul> -->

        </div>
      </div>
  </section>

  <section id="footer" style="margin-bottom: 120px;">
    <div class="footer-newsletter">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h3>Butuh Bantuan</h3>
            <p>Hubungi kami melalui informasi kontak yang tersedia atau bisa langsung chat kami.</p>
          </div>
          <div class="col-lg-6">
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= Services Section ======= -->
  <section id="services" class="services">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Pelayanan</h2>
      </div>

      <div class="row" style="justify-content: center;">
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-book"></i></div>
            <h4><a href="">Permohonan SPPIRT</a></h4>
            <p>Pelaku Usaha dan Industri Rumah Tangga dapat mengajukan permohonan PIRT.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-group"></i></div>
            <h4><a href="">Penyuluhan</a></h4>
            <p>Dinas Kesehatan melakukan penyuluhan kepada Pelaku Usaha.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-plus-medical"></i></div>
            <h4><a href="">Pemeriksaan</a></h4>
            <p>Dinas kesehatan melakukan pemeriksaan sesuai dengan ketentuan yang ada.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-check-square"></i></div>
            <h4><a href="">Penerbitan</a></h4>
            <p>SPPIRT diterbitkan setelah semua persyaratan dipenuhi sesuai ketentuan.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-transfer s"></i></div>
            <h4><a href="">Perpanjangan</a></h4>
            <p>Pelaku Usaha dapat mengajukan perpanjangan PIRT 6 bulan sebelum masa berlaku habis.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-slideshow"></i></div>
            <h4><a href="">Perubahan Data</a></h4>
            <p>Tersedia juga fitur perubahan data yang dapat dipergunakan jika terdapat kekeliruan.</p>
          </div>
        </div>

        <!-- <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-arch"></i></div>
            <h4><a href="">Pencabutan</a></h4>
            <p>Tersedia fitur pencabutan PIRT apabila ada temuan terhadap suatu produk tidak sesuai dengan ketentuan.</p>
          </div>
        </div> -->

      </div>

    </div>
  </section>
  <!-- End Services Section -->

  <!-- ======= Galeri Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Galeri SPPIRT</h2>
      </div>

      <div class="row portfolio-container">
        <?php foreach ($galeri as $gr) { ?>
          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-wrap">
              <img src="<?= base_url('uploads/galeri/') . $gr['gambar_galeri'] ?>" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4></h4>
                <p></p>
                <div class="portfolio-links">
                  <a href="<?= base_url('uploads/galeri/') . $gr['gambar_galeri'] ?>" data-gall="portfolioGallery" class="venobox" title="Gallery"><i class="bx bx-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

        <?php } ?>


      </div>
      <div class="read-more text-center">
        <a href="<?= base_url('galeri/'); ?>">Lihat gallery lainnya...</a>
      </div>
    </div>
  </section>
  <!-- End Galeri Section -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Kontak Kami</h2>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="info-box mb-4">
            <i class="bx bx-map"></i>
            <h3>Alamat Kami</h3>
            <p>Direktorat Pemberdayaan Masyarakat dan Pelaku Usaha Pangan Olahan,<br>BPOM RI, Jl. Percetakan Negara No. 23 Jakarta Pusat, 10560</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="info-box  mb-4">
            <i class="bx bx-envelope"></i>
            <h3>Email Kami</h3>
            <p>
              subditp3d.pmpu@gmail.com</p><br>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="info-box  mb-4">
            <i class="bx bx-phone-call"></i>
            <h3>Nomor Telfon</h3>
            <p>(+62) 21 42878701 / 42875738</p><br>
          </div>
        </div>

      </div>

      <div class="row">
  <div class="col-lg-12 col-md-12">
          <div class="info-box  mb-4">
           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3129.869694262233!2d106.85742891400344!3d-6.188580295519772!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4596128c679%3A0xd23cd73b07e914c3!2sBpom%20Percetakan%20Negara!5e1!3m2!1sid!2sid!4v1632182072508!5m2!1sid!2sid" width="100%" height="490" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>
        

        

      </div>

    </div>
  </section>
  <!-- End Contact Section -->

  <!-- ======= Testimonials Section ======= -->
  <section id="testimonials" class="testimonials">
    <div class="container">

      <div class="section-title">
        <h2>Testimonial SPPIRT</h2>
      </div>

      <div class="row">
        <?php foreach ($testimoni as $testimoni) { ?>
          <div class="col-lg-6">
            <div class="testimonial-item">
              <img src="<?= base_url('/uploads/testimoni/') . $testimoni['foto_testimoni'] ?>" class=" testimonial-img" alt="">
              <h3><?= $testimoni['nama_testimoni'] ?></h3>
              <h4>Pelaku Usaha</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                <?= $testimoni['komentar_testimoni']; ?>
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>
        <?php } ?>

      </div>

    </div>
  </section>
  <!-- End Testimonials Section -->

</main><!-- End #main -->
<script>
  $('.btn-submit').click(function() {
    var formData = new FormData($('#form')[0]);
    $.ajax({
      url: `${base_url}Home/TambahSaran`,
      type: 'post',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(response) {
        if (response.status) {
          sukses(response.alert);
          $('#modal-form').modal('hide')
          $('#form')[0].reset()
        } else {
          var error = response.error
        }
      }
    })
  })

  function sukses(msg) {
    toastr.success(msg, "Berhasil dikirim", {
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


