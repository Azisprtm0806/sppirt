<style type="text/css">
input:-moz-read-only, textarea:-moz-read-only,
input:read-only, textarea:read-only {
  /*border: 0;*/
  box-shadow: none;
  background: #ebebeb !important;
}

select:disabled{
  /*border: 0;*/
  box-shadow: none;
  background: #ebebeb !important;
}

</style>
<!-- row -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs -->
                <div class="custom-tab-1">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link <?php if((isset($_GET['tab']) && $_GET['tab']=='profile') || !isset($_GET['tab'])){?>active<?php } ?>" data-toggle="tab" href="#tab1"><i class="la la-user mr-2"></i> Profile Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if(isset($_GET['tab']) && $_GET['tab']=='ubah-password'){?>active<?php } ?>" data-toggle="tab" href="#tab2"><i class="la la-unlock mr-2"></i> Change Password</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade <?php if((isset($_GET['tab']) && $_GET['tab']=='profile')  || !isset($_GET['tab'])){?>show active<?php } ?>" id="tab1" role="tabpanel">
                            <br>
                            <form id="form-profile" action="<?php echo base_url();?>account/save-profile" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">

                                <div class="form-row">
                                    <input type="hidden" id="id_role" value="<?php echo isset($data->id_role)?$data->id_role:''; ?>">
                                    <div class="form-group col-md-6">
                                        <label>Email *</label>
                                        <input type="text" class="form-control" name="email" value="<?php echo isset($data->email)?$data->email:''; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Nama lengkap *</label>
                                        <input type="text" class="form-control" name="nama" value="<?php echo isset($data->nama)?$data->nama:''; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Nomor HP *</label>
                                        <input type="text" class="form-control" name="no_telp" value="<?php echo isset($data->no_telp)?$data->no_telp:''; ?>">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="thumb-options">
                                            <span>
                                                <a data-toggle="modal" data-target="#crop_modal" class="btn btn-icon btn-warning">Upload Foto</a>
                                                <input type="hidden" id="picture" name="picture" value="<?php echo isset($data->picture)?$data->picture:''; ?>">
                                                <!-- <a href="#" class="btn btn-icon btn-success"><i class="icon-remove"></i></a> -->
                                            </span>
                                        </div>
                                        <br>
                                        <div class="block">
                                            <div class="thumbnail">
                                                <div class="thumb">
                                                    <div class="loader hidden" id="loader-poster"></div> 
                                                    <?php if(isset($data->picture) && $data->picture!=null){?>
                                                        <img id="gambar" alt="Emutasi" src="<?php echo $data->picture; ?>">
                                                    <?php }else{ ?>
                                                        <img id="gambar" src="<?php echo base_url(); ?>assets/images/users/thumbs/sample.jpg" class="img-fluid" alt="">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="form_pelaku_usaha">

                                <div class="form-row form_pelaku_usaha">
                                    <div class="form-group col-md-6">
                                        <label>NIB <i style="color:red">(NIB tidak bisa diubah)</i></label>
                                        <input type="text" style="background-color:#ccc" class="form-control" name="nib" value="<?php echo isset($data->nib)?$data->nib:''; ?>" readonly>
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
                                        <select name="id_prov" class="form-control" id="id_provinsi" onchange="selectProvinsi()" required>
                                            <option value="">Pilih ...</option>
                                            <?php foreach ($provinsi as $key => $value) { ?>
                                                <option value="<?php echo $value->id_prov; ?>" <?php if(isset($data->id_prov) && $data->id_prov==$value->id_prov){ ?> selected <?php } ?>><?php echo $value->nama_prov; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Kab/Kota</label>
                                        <select name="id_kota" class="form-control" id="id_kab_kota" onchange="selectKota()">
                                            <?php if(isset($data->id_kota)){?> <option value="<?php echo $data->id_kota; ?>"></option> <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row form_pelaku_usaha form_dinkes">
                                    <div class="form-group col-md-6">
                                        <label>Kecamatan</label>
                                        <select name="id_kecamatan" class="form-control" id="id_kecamatan" onchange="selectKecamatan()">
                                            <?php if(isset($data->id_kecamatan)){?> <option value="<?php echo $data->id_kecamatan; ?>"></option> <?php } ?>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Desa</label>
                                        <select name="id_desa" class="form-control" id="id_desa">
                                            <?php if(isset($data->id_desa)){?> <option value="<?php echo $data->id_desa; ?>"></option> <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row form_pelaku_usaha">
                                    <div class="form-group col-md-12">
                                        <label>Alamat Usaha</label>
                                        <textarea class="form-control" name="alamat_usaha"><?php echo isset($data->alamat_usaha)?$data->alamat_usaha:''; ?></textarea>
                                    </div>
                                </div>

                                <br>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                </div>

                            </form>
                        </div>
                        <div class="tab-pane fade <?php if(isset($_GET['tab']) && $_GET['tab']=='ubah-password'){?>show active<?php } ?>" id="tab2">
                            <form id="form-profile" action="<?php echo base_url();?>account/ubah-password" method="POST">
                            <div class="pt-4 pr-2 pl">
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <div class="form-group">
                                            <label class="text-label">Current Password*</label>
                                            <input type="password" name="current_password" id="current_password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <div class="form-group">
                                            <label class="text-label">New Password*</label>
                                            <input type="password" name="password" id="password" class="form-control">
                                            <font color="red" class="label-keterangan"><i>
                                                - Password harus minimal 8 karakter<br>
                                                - Password minimal mengandung satu huruf besar<br>
                                                - Password terdiri dari kombinsasi huruf dan angka<br>
                                                - Password minimal mengandung satu spesial karakter</i>
                                            </font>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <div class="form-group">
                                            <label class="text-label">Retype New Password*</label>
                                            <input type="password" name="re_password" id="re_password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-center align-items-center mb-4 mt-4">
                                    <div class="dashboard_bar mr-2">
                                        <button type="submit" class="btn btn-rounded btn-success"  name="button_send" value="SIMAPN">
                                            <span class="btn-icon-left text-success"><i class="fa fa-save color-success"></i></span>CHANGE PASSWORD
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /form modal crop -->
<div id="crop_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-upload"></i>Form Upload</h4>
            </div>

            <div class="modal-body with-padding">

                <button type="button" class="btn btn-warning" onclick="document.getElementById('picture_file').click();">UPLOAD FOTO</button>
                <br><br>
                
                <form method="post" action="" enctype="multipart/form-data" id="myform">
                    <div class="col-md-12">
                        <input type="file" id="picture_file" name="picture_file" onchange="uploadCropper(this);" style="display: none" class="form-control" accept="image/*">
                    </div>
                    <!-- Crop and preview -->   
                    <div class="col-md-12">
                        <div class="row">
                            <div class="box-avatar-wrapper" style="margin-bottom: 20px; height: 400px; width: 100%;"></div>
                        </div>
                    </div> 
                    <div class="avatar-upload">
                        <input type="hidden" class="avatar-data" name="avatar_data">
                    </div>                                                 
                </form>

            </div>

            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="submitCrop();">Crop & Save</button>
            </div>
        </div>
    </div>
</div>
<!-- /form modal crop-->

<script type="text/javascript">

    //CROP POSTER
    function uploadCropper(input){
        var reader;
        var imageFile = input.files[0];

        if (imageFile != null) {
            if (imageFile.size > 10000000) {
                Swal.fire(
                  'Oopps!',
                  'Ukuran File Lebih dari 1 MB',
                  'error'
                )
                $('#gambar').removeAttr('src');
                $('#gambar').hide();
                $('#picture').val('');
            }
            else{
                var url = URL.createObjectURL(imageFile);
                var img = $('<img src="' + url + '">');
                $('.box-avatar-wrapper').empty().html(img);
                img.cropper({
                  aspectRatio: 16 / 16,
                  dragMode: 'none',
                  cropBoxMovable: true,
                  cropBoxResizable: true,
                  crop: function (e) {
                    var json = [
                          '{"x":' + e.x,
                          '"y":' + e.y,
                          '"height":' + e.height,
                          '"width":' + e.width,
                          '"rotate":' + e.rotate + '}'
                        ].join();

                    $('.avatar-data').val(json);
                  }
                });
            }
        }
    }

    function submitCrop(){

        $("#loader-poster").removeClass( "hidden" );
        $("#gambar").addClass( "hidden" );

        var files = $("#picture_file").prop('files')[0];
        var cropping = $('.avatar-data').val();
        var form_data = new FormData();                  
        form_data.append('file', files);
        form_data.append('avatar-data', cropping);

        $.ajax({ 
            url: "<?php echo base_url(); ?>account/upload-picture", 
            type: 'post', 
            data: form_data, 
            dataType: 'json',
            type: 'POST',
            contentType: false, 
            processData: false, 
            success: function(response){
                if(response.status == 'success'){ 

                   $('#gambar').attr('src',response.thumbPath);
                   $('#gambar').show();
                   $('#picture').val(response.thumbPath);

                   $("#loader-poster").addClass( "hidden" );
                    setTimeout(() => {  $("#gambar").removeClass( "hidden" ); }, 500);

                } 
                else{ 
                    Swal.fire(
                      'Oopps!',
                      'File not uploaded',
                      'error'
                    )
                } 
            }, 
        }); 
    }

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

        $('#id_kecamatan').prop('selectedIndex',0);
        $('#id_desa').prop('selectedIndex',0);
        selectKota();
        selectKecamatan();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>load-kab-kota",
            data: JSON.stringify({ id_provinsi:id_provinsi, id_kab_kota:id_kab_kota}),
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(res) {

                $('#id_kab_kota').html(res.data)
            }

        })

    }

    function selectKota() {

        var id_kab_kota = $('#id_kab_kota').val();
        var id_kecamatan = $('#id_kecamatan').val();

        $.ajax({
            type: "POST",
            type: 'ajax',
            url: "<?php echo base_url(); ?>load-kecamatan",
            data: JSON.stringify({
                id_kab_kota: id_kab_kota,
                id_kecamatan: id_kecamatan
            }),
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(res) {
                $('#id_kecamatan').html(res.data)
            }

        })

    }

    function selectKecamatan() {

        var id_kecamatan = $('#id_kecamatan').val();
        var id_desa = $('#id_desa').val();

        $.ajax({
            type: "POST",
            type: 'ajax',
            url: "<?php echo base_url(); ?>load-desa",
            data: JSON.stringify({
                id_kecamatan: id_kecamatan,
                id_desa: id_desa
            }),
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(res) {
                $('#id_desa').html(res.data)
            }

        })

    }

    function selectRole(){

        if($('#id_role').val()==2){
            $('.form_pelaku_usaha').show();
        }else if($('#id_role').val()==3 || $('#id_role').val()==4){
            $('.form_pelaku_usaha').hide();
            $('.form_dinkes').show();

            $("#id_provinsi").prop("disabled",true);
            $("#id_kab_kota").prop("disabled",true);

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