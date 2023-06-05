<div class="row">    
    <div class="col-xl-12">
        <div class="d-sm-flex  d-block align-items-center mb-4">
            <div class="mr-auto">
     
            </div>
            <div class="dropdown custom-dropdown mr-3 mb-2">
                
            </div>
            <div class="dashboard_bar mb-1">
                <a href="<?php echo base_url();?>user">
                    <button type="button" class="btn btn-rounded btn-primary">
                        <span class="btn-icon-left text-primary"><i class="fa fa-arrow-left color-primary"></i></span>Back
                    </button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        
        <?php $action = base_url().'user/change-password/'.encrypt_decrypt('encrypt', $data->id_user); ?>
        <form action="<?php echo $action ;?>" method="POST" onsubmit="return validateFormUbahPassword()">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Ubah Password</h4>
                <div class="dashboard_bar mr-2">
                    <button type="submit" class="btn btn-rounded btn-success">
                        <span class="btn-icon-left text-success"><i class="fa fa-check color-success"></i></span>Ubah Password
                    </button>
                </div>
            </div>
            <div class="card-body" id="body-kontak">
                <div class="basic-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password">
                            <font color="red" class="label-keterangan"><i>
                                - Password harus minimal 8 karakter<br>
                                - Password minimal mengandung satu huruf besar<br>
                                - Password terdiri dari kombinsasi huruf dan angka<br>
                                - Password minimal mengandung satu spesial karakter</i>
                            </font>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Re Password</label>
                            <input type="password" class="form-control" name="re_password">
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">
function validateFormUbahPassword(){

  var password =  document.getElementsByName("password")[0].value;
  var re_password =  document.getElementsByName("re_password")[0].value;

  if(password.length<6){
      Swal({
        type: 'error',
        title: 'Oops...',
        text: "Password minimal 6 karakter",
      });
      return false;
  }

  if(password!=re_password){
      Swal({
        type: 'error',
        title: 'Oops...',
        text: "Password dan Ketik Ulang Password tidak sama",
      });
      return false;
  }

  return true;

}
</script>

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