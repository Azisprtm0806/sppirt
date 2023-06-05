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
        
        <?php $action = isset($data->id_user)?base_url().'user/update/'.encrypt_decrypt('encrypt', $data->id_user):base_url().'user/save'; ?>
        <form action="<?php echo $action ;?>" method="POST" onsubmit="return validateForm()">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form User</h4>
                <div class="dashboard_bar mr-2">
                    <button type="submit" class="btn btn-rounded btn-success">
                        <span class="btn-icon-left text-success"><i class="fa fa-check color-success"></i></span>Save
                    </button>
                </div>
            </div>
            <div class="card-body" id="body-kontak">
                <div class="basic-form">
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>User Role</label>
                            <select class="form-control" id="id_role" name="id_role" onchange="selectRole()">
                                <?php foreach($user_role as $key => $value){ ?>
                                    <option value="<?php echo $value->id_role; ?>" <?php if(isset($data->id_role) && $data->id_role==$value->id_role){?> selected <?php } ?>><?php echo $value->role; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status</label>
                            <select class="form-control" name="is_active">
                                    <option value="1" <?php if(isset($data->is_active) && $data->is_active=='1'){ ?>selected<?php } ?>>ACTIVE</option>
                                    <option value="0" <?php if(isset($data->is_active) && $data->is_active=='0'){ ?>selected<?php } ?>>INACTIVE</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo isset($data->username)?$data->username:''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nama lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo isset($data->nama)?$data->nama:''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="<?php echo isset($data->email)?$data->email:''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nomor HP</label>
                            <input type="text" class="form-control" name="no_telp" value="<?php echo isset($data->no_telp)?$data->no_telp:''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Re Password</label>
                            <input type="password" class="form-control" name="re_password">
                        </div>
                    </div>

                    <hr class="form_pelaku_usaha">

                    <div class="form-row form_pelaku_usaha">
                        <div class="form-group col-md-6">
                            <label>NIB</label>
                            <input type="text" class="form-control" name="nib" value="<?php echo isset($data->nib)?$data->nib:''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nama Pelaku Usaha</label>
                            <input type="text" class="form-control" name="nama_pelaku_usaha" value="<?php echo isset($data->nama_pelaku_usaha)?$data->nama_pelaku_usaha:''; ?>">
                        </div>
                    </div>
                    <div class="form-row form_pelaku_usaha">
                        <div class="form-group col-md-6">
                            <label>Nomor KTP (NIK)</label>
                            <input type="text" class="form-control" name="nik" value="<?php echo isset($data->nik)?$data->nik:''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nama Usaha</label>
                            <input type="text" class="form-control" name="nama_usaha" value="<?php echo isset($data->nama_usaha)?$data->nama_usaha:''; ?>">
                        </div>
                    </div>

                    <div class="form-row form_pelaku_usaha form_dinkes">
                        <div class="form-group col-md-6">
                            <label>Provinsi</label>
                            <select name="id_prov" class="form-control" id="id_provinsi" onchange="selectProvinsi()">
                                <option value="">Pilih ...</option>
                                <?php foreach ($provinsi as $key => $value) { ?>
                                    <option value="<?php echo $value->id_prov; ?>" <?php if(isset($data->id_prov) && $data->id_prov==$value->id_prov){ ?> selected <?php } ?>><?php echo $value->nama_prov; ?></option>
                                <?php } ?>
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label>Kab/Kota</label>
                            <select name="id_kota" class="form-control" id="id_kab_kota">
                                <?php if(isset($data->id_kota)){?> <option value="<?php echo $data->id_kota; ?>"></option> <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row form_pelaku_usaha">
                        <div class="form-group col-md-12">
                            <label>Alamat Usaha</label>
                            <textarea class="form-control" name="alamat_usaha"><?php echo isset($data->alamat_usaha)?$data->alamat_usaha:''; ?></textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    function validateForm(){

        var nama =  document.getElementsByName("nama")[0].value;
        var email =  document.getElementsByName("email")[0].value;
        var no_telp =  document.getElementsByName("no_telp")[0].value;

        if(nama=="" || nama==" " || email=="" || email==" " || no_telp=="" || no_telp==" "){
            Swal({
            type: 'error',
            title: 'Oops...',
            text: "Form tidak boleh kosong",
            });
            return false;
        }
        return true;

    }

    function selectProvinsi(){

        var id_provinsi = $('#id_provinsi').val();
        var id_kab_kota = $('#id_kab_kota').val();

        $.ajax({
            type: "POST",
            type: 'ajax',
            url: "<?php echo base_url();?>load-kab-kota",
            data: JSON.stringify({ id_provinsi:id_provinsi, id_kab_kota:id_kab_kota}),
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(res) {
                $('#id_kab_kota').html(res.data)
            }

        })

    }

    function selectRole(){

        if($('#id_role').val()==2){
            $('.form_pelaku_usaha').show();
        }else if($('#id_role').val()==3 || $('#id_role').val()==4){
            $('.form_pelaku_usaha').hide();
            $('.form_dinkes').show();
        }else{
            $('.form_pelaku_usaha').hide();
        }

    }

    setTimeout(function() {
        selectRole()
        selectProvinsi();
    }, 100);
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
