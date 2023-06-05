<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <h4>Profil</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profil</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-4">
                
                <div class="card">
                    <div class="profile-statistics">
                        <div class="text-center">
                            <div class="mt-4">
                                <span class="badge badge-primary mb-1 mr-1"><?php echo $data->level; ?></span> 
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="profile-photo mb-4">
                            <?php if(isset($data->picture) && $data->picture!=null){?>
                                <img alt="Event Stack" src="<?php echo $data->picture; ?>">
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/images/users/thumbs/sample.jpg" class="img-fluid rounded-circle" alt="">
                            <?php } ?>

                            
                        </div>
                        <div class="profile-name mb-4">
                            <h4 class="text-primary mb-0"><?php echo $data->nama_lengkap; ?></h4>
                            <p><?php echo $data->email; ?> / <?php echo $data->nomor_telpon ; ?></p>
                            <p></p>
                        </div>
                        
                        <div class="profile-blog mb-5">
                            <?php if($data->nama_provinsi!=""){ ?><h5 class="text-primary d-inline">Provinsi <?php echo $data->nama_provinsi; ?> - <?php echo $data->nama_kota; ?></h5><?php } ?>
                            <p class="mb-0"><?php echo $data->alamat; ?></p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#profil" data-toggle="tab" class="nav-link <?php if($this->uri->segment(1)=='profil'){ ?>active show<?php } ?>">Profil</a>
                                    </li>
                                    <li class="nav-item"><a href="#ubah-password" data-toggle="tab" class="nav-link <?php if($this->uri->segment(1)=='ubah-password'){ ?>active show<?php } ?>">Ubah Password</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="profil" class="tab-pane fade <?php if($this->uri->segment(1)=='profil'){ ?>active show<?php } ?>">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <form method="POST" action="<?php echo base_url();?>profil/save">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Nama Lengkap</label>
                                                            <input type="text" class="form-control" value="<?php echo $data->nama_lengkap; ?>" disabled style="background: #f2f2f2;">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Username</label>
                                                            <input type="email" placeholder="Username" class="form-control" value="<?php echo $data->username; ?>" disabled style="background: #f2f2f2;">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email</label>
                                                            <input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo $data->email; ?>">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Provinsi</label>
                                                            <select class="form-control" onchange="selectProvinsi()" id="id_provinsi" name="id_provinsi">
                                                                <option selected="">Pilih Provinsi...</option>
                                                                <?php foreach ($provinsi as $key => $value) { ?>
                                                                    <option <?php if($value->id_provinsi==$data->id_provinsi){?> selected <?php } ?> value="<?php echo $value->id_provinsi; ?>"><?php echo $value->nama_provinsi; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Kabupaten/Kota</label>
                                                            <select class="form-control" name="id_kab_kota" id="id_kab_kota">
                                                                <option selected="">Pilih Kabuoaten/Kota...</option>
                                                            </select>
                                                        </div>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <input type="text" value="<?php echo $data->alamat; ?>" class="form-control" name="alamat">
                                                    </div>
                                                    <div class="form-row">
                                                        <!-- <div class="form-group col-md-12">
                                                            <label>Level User</label>
                                                            <select class="form-control "  name="id_role_user">
                                                                <option selected="">Pilih Level...</option>
                                                                <option <?php if($data->id_role_user==1){?> selected <?php } ?> value="1">Admin</option>
                                                                <option <?php if($data->id_role_user==2){?> selected <?php } ?> value="2">Provinsi</option>
                                                                <option <?php if($data->id_role_user==3){?> selected <?php } ?> value="3">Pemerintah Daerah</option>
                                                            </select>
                                                        </div> -->
                                                        <div class="form-group col-md-12">
                                                            <label>Nomor Telepon</label>
                                                            <input type="text" class="form-control" value="<?php echo $data->nomor_telpon; ?>" name="nomor_telpon">
                                                        </div>
                                                    </div>
                                                    <div class="form-group text-center">
                                                        <div class="thumb-options">
                                                            <span>
                                                                <a data-toggle="modal" data-target="#crop_modal" class="btn btn-icon btn-danger">Upload Foto</a>
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
                                                    <br>
                                                    <div class="form-group">
                                                        <button class="btn btn-primary" type="submit">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="ubah-password" class="tab-pane fade <?php if($this->uri->segment(1)=='ubah-password'){ ?>active show<?php } ?>">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <form method="POST" action="<?php echo base_url();?>profil/ubah-password">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Password Baru</label>
                                                            <input type="password" name="password" placeholder="" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Ketik Ulang Password Baru</label>
                                                            <input type="password" name="re_password" placeholder="" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
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