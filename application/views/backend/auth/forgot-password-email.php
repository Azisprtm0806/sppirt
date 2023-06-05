<!DOCTYPE html>
<html class="h-100" dir="ltr" lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- PAGE TITLE HERE -->
    <title>Forgot | SPPIRT BPOM Terintegrasi OSS</title>
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/backend/public/') ?>images/favicon.png">
    
    <link href="<?= base_url('assets/backend/public/') ?>css/style.css" rel="stylesheet">
    <link href="<?= base_url('assets/backend/public/') ?>vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body class="h-100" data-typography="roboto" data-theme-version="light" data-layout="vertical" data-nav-headerbg="color_3" data-headerbg="color_1" data-sidebar-style="mini" data-sibebarbg="color_3" data-sidebar-position="fixed" data-header-position="fixed" data-container="wide" direction="ltr" data-primary="color_1" cz-shortcut-listen="true">
    
    <div class="authincation" style="margin-top: 100px;">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">

                                    <div class="text-center mb-3">
                                        <a href="<?php echo base_url(); ?>"><img src="<?= base_url('assets/backend/public/') ?>images/logo-bpom.png" alt="Logo Web Sender" style="width: 40%;"></a>
                                    </div><br>

                                    <h4 class="text-center mb-4">Silahkan masuk email anda untuk mendapatkan link Reset Password</h4><br>

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

                                    <form method="post" action="<?php echo base_url('action-forgot-password'); ?>">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" placeholder="email">
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-success btn-block">Submit</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Sudah punya akun? <a class="text-primary" href="<?php echo base_url(); ?>login">Login disini</a></p>
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


</body>
</html>
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