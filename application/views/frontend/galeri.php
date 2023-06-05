<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.html">Home</a></li>
          <li>Galeri</li>
        </ol>
        <h2>Galeri</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Galeri Section ======= -->
      <section id="portfolio" class="portfolio blog">
        <div class="container">

          <div class="row portfolio-container">
            <?php foreach ($galeri as $gr) { ?>
              <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                <div class="portfolio-wrap">
                  <img src="<?= base_url('uploads/galeri/') . $gr['gambar_galeri'] ?>" class="img-fluid" alt="">
                  <div class="portfolio-info">
                    <h4>App 1</h4>
                    <p>App</p>
                    <div class="portfolio-links">
                      <a href="<?= base_url('uploads/galeri/') . $gr['gambar_galeri'] ?>" data-gall="portfolioGallery" class="venobox" title="App 1"><i class="bx bx-plus"></i></a>
                    </div>
                  </div>
                </div>
              </div>

            <?php } ?>
          </div>

          <div class="blog-pagination">
              <ul class="justify-content-center">
                <li class="disabled"><i class="icofont-rounded-left"></i></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#"><i class="icofont-rounded-right"></i></a></li>
              </ul>
            </div>


        </div>
      </section>
      <!-- End Galeri Section -->

  </main><!-- End #main -->