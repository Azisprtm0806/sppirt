<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?= $title; ?></title>
    <link href="<?= base_url() ?>assets/frontend/img/favicon.png" rel="icon">
    <link rel="stylesheet" href="<?= base_url() ?>assets/login/css/unplug-ui-kit.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/login/css/unplug-ui-kit-demo.css" />
    <link
      rel="stylesheet"
      href="<?= base_url() ?>assets/login/vendors/%40mdi/font/css/materialdesignicons.min.css"
    />
    <link href="<?= base_url('assets/backend/public/') ?>vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .text-welcome{
            color: #5f5f5f;
            font-size: 15px;
        }

        .text-welcome a {
            color: #2c2969;
            font-weight: bold;
        }

        .lupapassword{
            color: #5f5f5f;
            font-size: 14px;
        }

        .label {
            font-size: 14px;
        }

        .btn-success {
            color: #ffffff;
            background-color: #3fbbc0;
            border-color: #3fbbc0;
        }

        .auth-form-section .auth-form {
            margin-bottom: 15px;
        }

        .bawah {
            font-size: 14px;
        }

        .bawah a {
            font-weight: bold;
            color: #2c2969;
        }

        @media only screen and (max-width: 768px) {
            .mobileauth {
                width: 100%;
                height: auto;
                box-shadow: rgb(100 100 111 / 20%) 0px 7px 29px 0px;
                border-radius: 20px;
                background-color: white;
                padding: 30px;
                margin: 60px 20px;
            } 

            .lupapassword {
                float: right;
            }
        }
    </style>
  </head>
  <body>
    <main class="auth">
      <div class="container-fluid">
        <div class="row vh-100">
          <div
            class="
              col-md-6
              text-center
              py-5
              d-flex
              flex-column
              justify-content-center
              auth-bg-section
              text-white
              position-fixed
            "
            style="background-image: url(<?= base_url() ?>assets/login/images/bg.jpg); height:100%"
          >
            <h1>
              Selamat Datang
            </h1>
            <h3>Sistem SPPIRT BPOM Terintegrasi OSS</h3>
            <p class="text-welcome">
              Gunakan akun anda untuk mengakses sistem, atau kembali ke halaman utama klik <a href="<?= base_url() ?>Home">di sini</a>
            </p>
          </div>
        
          <div class="col-md-6 d-flex offset-6 flex-column py-5 justify-content-center mobileauth">   
              <?= $contents; ?>
          </div>
            
        </div>
      </div>
    </main>


    <script src="<?= base_url('assets/backend/public/') ?>vendor/global/global.min.js"></script>
    <script src="<?= base_url('assets/backend/public/') ?>vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?= base_url('assets/backend/public/') ?>vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="<?= base_url('assets/backend/public/') ?>js/custom.min.js"></script>
    <script src="<?= base_url('assets/backend/public/') ?>js/deznav-init.js"></script>

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
    
  </body>

</html>
