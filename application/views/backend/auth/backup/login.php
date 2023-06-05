<html class="h-100" dir="ltr" lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MotaAdmin - Bootstrap Admin Dashboard">
    <meta property="og:title" content="MotaAdmin - Bootstrap Admin Dashboard">
    <meta property="og:description" content="MotaAdmin - Bootstrap Admin Dashboard">
    <meta property="og:image" content="social-image.png">
    <meta name="format-detection" content="telephone=no">
    
    <!-- PAGE TITLE HERE -->
    <title>Login | Aplikasi Pelaporan Keamanan Pangan Onlin</title>
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/backend/public/') ?>images/favicon.png">
    
    <link href="<?= base_url('assets/backend/public/') ?>css/style.css" rel="stylesheet">
    <link href="<?= base_url('assets/backend/public/') ?>vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

    
</head>
<body class="h-100" data-typography="roboto" data-theme-version="light" data-layout="vertical" data-nav-headerbg="color_3" data-headerbg="color_1" data-sidebar-style="mini" data-sibebarbg="color_3" data-sidebar-position="fixed" data-header-position="fixed" data-container="wide" direction="ltr" data-primary="color_1" cz-shortcut-listen="true">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">

                                    <div class="text-center mb-3">
                                        <a href="<?php echo base_url(); ?>"><img src="<?= base_url('assets/backend/public/') ?>images/logo-bpom.png" alt="Logo Web Sender" style="width: 50%;"></a>
                                    </div>

                                    <h4 class="text-center mb-4">Masuk ke akun Anda</h4>

                                    <form action="<?php echo base_url('authentication'); ?>" method="POST">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Username</strong></label>
                                            <input type="username" name="username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="form-row d-flex justify-content-center mt-4 mb-2">
                                            <?php echo $widget;?>
                                            <?php echo $script;?>
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                             <!--   <div class="custom-control custom-checkbox ml-1">
                                                    <input type="checkbox" class="custom-control-input" id="basic_checkbox_1">
                                                    <label class="custom-control-label" for="basic_checkbox_1">Remember my preference</label>
                                                </div> -->
                                            </div>
                                            <div class="form-group">
                                                <a href="<?php echo base_url(); ?>forgot-password">Lupa Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Belum punya akun? <a class="text-primary" href="<?php echo base_url(); ?>register">Register</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?= base_url('assets/backend/public/') ?>vendor/global/global.min.js"></script>
    <script src="<?= base_url('assets/backend/public/') ?>vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?= base_url('assets/backend/public/') ?>vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="<?= base_url('assets/backend/public/') ?>js/custom.min.js"></script>
    <script src="<?= base_url('assets/backend/public/') ?>js/deznav-init.js"></script>

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