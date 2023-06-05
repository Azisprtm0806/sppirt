<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Authentication Page | SPPIRT BPOM RI</title>
  <link rel="stylesheet" href="<?= base_url() ?>assets/login/css/unplug-ui-kit.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/login/css/unplug-ui-kit-demo.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/login/vendors/%40mdi/font/css/materialdesignicons.min.css" />
  <link href="<?= base_url('assets/backend/public/') ?>vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
  <style>
    .lupapassword {
      color: #5f5f5f;
      font-size: 14px;
    }

    .label {
      font-size: 14px;
    }
  </style>
</head>

<body>
  <main class="auth">
    <div class="container-fluid">
      <div class="row vh-100">
        <div class="
              col-md-7
              text-center
              py-5
              d-flex
              flex-column
              justify-content-center
              auth-bg-section
              text-white
            " style="background-image: url(<?= base_url() ?>assets/login/images/bg_login.jpeg)">
          <h1 class="text-reset">
            Selamat Datang <br />
            Sistem SPPIRT BPOM Terintegrasi OSS
          </h1>
          <p class="font-weight-bold text-reset">
            Gunakan akun Anda untuk mengakses sistem, atau kembali ke halaman utama klik <a href="<?php echo base_url(''); ?>">
              <font color="red">di sini</font>
            </a>
          </p>
        </div>
        <div class="col-md-5 d-flex flex-column py-5 justify-content-center">
          <div class="auth-form-section">
            <div class="text-center">
              <div class="logo">
                <img src="<?= base_url('assets/backend/public/') ?>images/logo-bpom.png" class="img-fluid" alt="Unplug UI" width="200" />
              </div>
              <h2>Sign in</h2>

            </div>
            <form action="<?php echo base_url('authentication'); ?>" method="POST" class="auth-form">
              <div class="form-group">
                <label for="username" class="label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Masukan Username" />
              </div>
              <div class="form-group">
                <label for="userPassword" class="label">Password</label>
                <input type="password" name="userPassword" id="userPassword" class="form-control" placeholder="Masukan Password" />
              </div>

              <div style="margin-top: 20px; margin-bottom: 20px">
                <?php echo $widget; ?>
                <?php echo $script; ?>
              </div>

              <button type="submit" class="btn btn-info btn-block mb-3 mt-3">
                Sign In
              </button>
              <div class="d-md-flex justify-content-between">
                <div class="form-check"></div>
                <a href="<?php echo base_url(); ?>forgot-password" class="lupapassword">Lupa Password?</a>
              </div>
            </form>
            <!--<label for="username" class="bawah">Belum punya akun? <a href="<?= base_url() ?>register">Register</a></label
              >-->
			<label for="username" class="bawah">Belum punya akun? <a href="https://oss.go.id" target="_blank">Daftar akun melalui Sistem OSS</a></label>
			</div>
        </div>
      </div>
    </div>
  </main>
  <script src="<?= base_url('assets/backend/public/') ?>vendor/sweetalert2/dist/sweetalert2.min.js"></script>
  <?php if ($this->session->flashdata('error')) { ?>
    <script language='JavaScript'>
      swal({
        type: 'error',
        title: 'Oops...',
        text: "<?php echo $this->session->flashdata('error'); ?>",
      });
    </script>
  <?php } else if ($this->session->flashdata('success')) { ?>
    <script language='JavaScript'>
      swal({
        type: 'success',
        title: 'Success',
        text: "<?php echo $this->session->flashdata('success'); ?>",
      });
    </script>
  <?php } ?>
</body>

</html>