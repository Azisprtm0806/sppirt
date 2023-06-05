<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.html">Home</a></li>
          <li>Cek NIB</li>
        </ol>
        <h2>Cek NIB</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
      <div class="container" id="load-regulasi">

        <?php if(form_error('nib')){ ?>
            <div class="alert alert-danger" role="alert">
              <?php echo str_replace("<p>", "",str_replace("</p>", "", form_error('nib'))) ; ?>
            </div>
            <?php } ?>

            <?php 
                $message = $this->session->flashdata('message');
                if(isset($message)){
            ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $message; ?>
            </div>
            <?php } ?>

            <form action="<?php echo base_url('action-cek-nib'); ?>" method="POST" class="auth-form">

                            <div class="form-group">
                <label for="nib" class="label">Masukkan NIB untuk memulai registrasi</label>
                <input type="text" name="nib" id="nib" class="form-control"
                  placeholder="81201xxxxxxxx" value="<?php echo isset($nib)?$nib:''; ?>" />
              </div>
                            
                <button type="submit" class="btn btn-success btn-block mb-3 mt-4">
                CEK STATUS NIB
              </button>
            </form>

            <label for="username" class="bawah">Sudah punya akun? <a href="<?= base_url() ?>login">Login Disini</a></label>

      </div>
    </section><!-- End Team Section -->

  </main><!-- End #main -->