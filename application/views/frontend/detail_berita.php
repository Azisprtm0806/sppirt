<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

      <ol>
        <li><a href="<?= base_url(''); ?>">Home</a></li>
        <li><a href="<?= base_url('Berita'); ?>">Berita</a></li>
        <li><a href="<?= base_url('#'); ?>">Detail_Berita</a></li>
      </ol>
      <h2>Detail Berita</h2>

    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Blog Section ======= -->
  <section id="blog" class="blog">
    <div class="container">

      <div class="row">

        <div class="col-lg-8 entries">

          <article class="entry entry-single">

            <div class="entry-img">
              <img src="<?= base_url('uploads/berita/thumbnail/') . $detail_berita['gambar_berita'] ?>" alt="" class="img-fluid">
            </div>

            <h2 class="entry-title">
              <a href=""><?= $detail_berita['judul_berita'] ?></a>
            </h2>

            <div class="entry-meta">
              <ul>
                <li class="d-flex align-items-center"><i class="icofont-user"></i> Admin</li>
                <li class="d-flex align-items-center"><i class="icofont-wall-clock"></i> <time datetime="2020-01-01"><?= date('d F Y', strtotime($detail_berita['tgl_berita'])); ?></time></li>
              </ul>
            </div>

            <div class="entry-content">
              <p>
                <?= $detail_berita['deskripsi_berita']; ?>

              </p>

            </div>

            <div class="entry-footer clearfix">


              <div class="float-right share">
                
              </div>

            </div>

          </article><!-- End blog entry -->

        </div><!-- End blog entries list -->

        <div class="col-lg-4">

          <div class="sidebar">
            <h3 class="sidebar-title">Berita Terbaru</h3>
            <div class="sidebar-item recent-posts">
              <?php foreach ($berita_terbaru as $bt) { ?>
                <div class="post-item clearfix">
                  <img src="<?= base_url('uploads/berita/thumbnail/') . $bt['gambar_berita'] ?>" alt="">
                  <h4><a href=" <?= base_url('Home/detail_berita/') . encrypt_decrypt('encrypt', $bt['id_berita']); ?>"><?= $bt['judul_berita']; ?></a></h4>
                  <time datetime="2020-01-01"><?= date('d F Y', strtotime($bt['tgl_berita'])); ?></time>
                </div>
              <?php } ?>
              <div class=" text-left">
                <a href="<?= base_url('berita/'); ?>">Read More...</a>
              </div>

            </div><!-- End sidebar recent posts-->

          </div><!-- End sidebar -->

        </div><!-- End blog sidebar -->

      </div>

    </div>
  </section><!-- End Blog Section -->

</main><!-- End #main -->