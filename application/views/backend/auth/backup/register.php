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
    <title>Register | Aplikasi Pelaporan Keamanan Pangan Onlin</title>
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/backend/public/') ?>images/favicon.png">
    
    <link href="<?= base_url('assets/backend/public/') ?>css/style.css" rel="stylesheet">
    <link href="<?= base_url('assets/backend/public/') ?>vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body class="h-100" data-typography="roboto" data-theme-version="light" data-layout="vertical" data-nav-headerbg="color_3" data-headerbg="color_1" data-sidebar-style="mini" data-sibebarbg="color_3" data-sidebar-position="fixed" data-header-position="fixed" data-container="wide" direction="ltr" data-primary="color_1" cz-shortcut-listen="true">
    
    <div class="authincation" style="margin-top: 120px;">
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

                                    <h4 class="text-center mb-4">Form Registrasi</h4> 

                                    <?php 
                                        $message = $this->session->flashdata('message');
                                        if(isset($message)){
                                    ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $message; ?>
                                    </div>
                                    <?php } ?>

                                    <form action="<?php echo base_url('action-register/'.$token); ?>" method="POST">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>NIB</strong></label>
                                            <input type="text" name="nib" class="form-control" placeholder="NIB" value="<?php echo isset($data->nib)?$data->nib:''; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Nama Pelaku Usaha</strong></label>
                                            <input type="text" name="nama_pelaku_usaha" class="form-control" placeholder="Nama Pelaku Usaha" value="<?php echo isset($data->nama_penanggung_jwb)?$data->nama_penanggung_jwb:''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Nomor KTP (NIK)</strong></label>
                                            <input type="text" name="nik" class="form-control" placeholder="Nomor KTP (NIK)" value="<?php echo isset($data->nik_penanggung_jwb)?$data->nik_penanggung_jwb:''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>No. HP</strong></label>
                                            <input type="text" name="no_telp" class="form-control" placeholder="" value="<?php echo isset($phone)?$phone:''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Nama Usaha</strong></label>
                                            <input type="text" name="nama_usaha" class="form-control" placeholder="Nama" value="<?php echo isset($data->nama_perseroan)?$data->nama_perseroan:''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Provinsi</strong></label>
                                            <select name="id_prov" class="form-control" id="id_provinsi" onchange="selectProvinsi()" required>
                                            <option value="">Pilih ...</option>
                                            <?php foreach ($provinsi as $key => $value) { ?>
                                                <option value="<?php echo $value->id_prov; ?>"><?php echo $value->nama_prov; ?></option>
                                            <?php } ?>
                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Kab/Kota</strong></label>
                                            <select name="id_kota" class="form-control" id="id_kab_kota" >
                                                <option value="">Pilih ...</option>'
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Alamat Usaha</strong></label>
                                            <textarea name="alamat_usaha" class="form-control"><?php echo isset($data->alamat_perseroan)?$data->alamat_perseroan:''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo isset($data->email_user_proses)?$data->email_user_proses:''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Username</strong></label>
                                            <input type="text" name="username" class="form-control" placeholder="Nama" value="<?php echo isset($data->nib)?$data->nib:''; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Retype Password</strong></label>
                                            <input type="password" name="re_password" class="form-control">
                                        </div>
                                        <div class="form-row d-flex justify-content-center mt-4 mb-2">
                                                <?php echo $widget;?>
                                                <?php echo $script;?>
                                            </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="<?php echo base_url(); ?>login">Sign in</a></p>
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

<script type="text/javascript">
    function selectProvinsi(){

        var id_provinsi = $('#id_provinsi').val();

        $.ajax({
            type: "POST",
            type: 'ajax',
            url: "<?php echo base_url();?>load-kab-kota",
            data: JSON.stringify({ id_provinsi:id_provinsi}),
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(res) {
                $('#id_kab_kota').html(res.data)
            }

        })

    }
</script>