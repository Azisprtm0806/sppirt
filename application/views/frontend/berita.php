<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.html">Home</a></li>
          <li>Berita</li>
        </ol>
        <h2>Berita Terkini</h2>

      </div>
    </section><!-- End Breadcrumbs -->

     <!-- ======= Blog Section ======= -->
      <section id="blog" class="blog">
        <div class="container">
            
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
                      <a href="<?= base_url('Home/detail_berita/') . encrypt_decrypt('encrypt', $br['id_berita']); ?>">Read More</a>
                    </div>
                  </div>

                </article><!-- End blog entry -->
              </div>
            <?php } ?>

          </div>
          
          <!--<div class="blog-pagination">
              <ul class="justify-content-center">
                <li class="disabled"><i class="icofont-rounded-left"></i></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#"><i class="icofont-rounded-right"></i></a></li>
              </ul>
            </div>-->
			<?php if($pagination!=""){ ?>
                                    <?php echo $pagination; ?>
                                <?php } ?>

        </div>

      </section>
      <!-- End Blog Section -->
	
  </main><!-- End #main -->