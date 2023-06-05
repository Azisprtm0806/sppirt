<style type="text/css">
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pengajuan Pembekuan Akun</h4>
            </div>
            <div class="card-body">
                <form id="form-search-nib" method="POST" onkeydown="return event.key != 'Enter';">
                    <div class="form-row">
                        <div class="form-group col-md-1"></div>
                        <div class="form-group col-md-8">
                            <label for="nib">Cari NIB</label>
                            <br>
                            <input type="number" onkeypress="return isNumberKey(event)" name="nib" class="form-control" id="nib">
                        </div>
                        <div class="form-group col-md-2">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-block btn-warning" id="btn-search-nib"> <i class="fa fa-search" style="margin-right: 6px;"></i> Search</button>
                        </div>
                        <div class="form-group col-md-1"></div>
                    </div>
                </form>
            </div>
            <div class="card-body detail-user" style="display: none;">
                <h4>Data Pelaku Usaha</h4>
                <hr>
                <div class="row text-dark">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label"><b>Nama</b></label>
                            <div class="col-sm-8">
                                <p class="mt-1" id="nama"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label"><b>Nama Usaha</b></label>
                            <div class="col-sm-8">
                                <p class="mt-1" id="nama_usaha"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label for="nik" class="col-sm-4 col-form-label"><b>NIK</b></label>
                            <div class="col-sm-8">
                                <p class="mt-1" id="nik"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label"><b>NIB</b></label>
                            <div class="col-sm-8">
                                <p class="mt-1" id="nib_pelaku_usaha"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label"><b>Alamat Usaha</b></label>
                            <div class="col-sm-10">
                                <p class="mt-1" id="alamat_usaha"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-dark">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label"><b>No Telpon</b></label>
                            <div class="col-sm-8">
                                <p class="mt-1" id="no_telp"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label"><b>Email</b></label>
                            <div class="col-sm-8">
                                <p class="mt-1" id="email"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <div class="form-group mb-0" style="">
                            <button type="button" id="btn-pengajuan-penangguhan" class="btn btn-danger">Rekomendasikan Pembekuan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loader" class="text-center" style="display: none; position: fixed; top: 0; right: 0; bottom: 0; left: 0; flex-direction: row; align-items: center; justify-content: center; padding: 10px; z-index: 1060; overflow-x: hidden; background-color: rgba(0,0,0,.4); -webkit-overflow-scrolling: touch;">
    <div class="spinner-border text-light" role="status" style="padding: 50px;"></div>
</div>

<div class="modal fade" id="modal-form-pembataan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Penangguhan Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3" id="form-send-submission" method="POST" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label class="form-label">Alasan Penangguhan Akun</label>
                        <input type="hidden" name="nib_modal" id="nib_modal">
                        <textarea class="form-control" name="alasan_pembatalan" id="alasan_pembatalan" style="height: 300px;"></textarea>
                    </div>
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label">Unggah Surat Rekomendasi Pembekuan</label>
                        <div class="btn-group" style="padding-bottom: 7px;">
                            <button type="button" class="btn btn-primary" id="upload_button">
                                <i class="fa fa-upload"></i>
                                <span>Unggah Surat Rekomendasi Pembekuan</span>
                            </button>
                        </div>
                        <input type="file" id="rekomendasi_pembatalan" name="rekomendasi_pembatalan" accept="application/pdf,application/,application/doc" onchange="changeName(this)" style="display: none;">
                        <br>
                        <span id="file-name"></span>
                        <h4 id="doc-template">Untuk contoh format surat rekomendasi pembekuan <a href="<?= base_url() ?>assets/backend/template_dokumen/contoh_format_pembekuan_dinkes.pdf" target="_blank"><br>Lihat Disini.</a></h4>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label"></label>
                        <button type="button" class="btn btn-primary" id="btn-submit" style="width: 100%;">Submit</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }
  
        return true;
    }

    $('#btn-search-nib').click(function(e){
        e.preventDefault("submit");

        var nib = $("#nib").val();

        $.ajax({
            type:'POST',
            url: '<?php echo base_url() . 'backend/pembatalan-akun/search-nib' ?>',            
            data:{'nib':nib},
            dataType : 'json',
            beforeSend: function(e){
                $('#loader').css('display', 'flex');
            },
            success: function (data) {
                $('#loader').css('display', 'none');
                if (data.status == 200) {
                    $(".detail-user").show();
                    $("#nama").text(data.userData['nama']);
                    $("#nama_usaha").text(data.userData['nama_usaha']);
                    $("#nik").text(data.userData['nik']);
                    $("#nib_pelaku_usaha").text(data.userData['nib']);
                    $("#alamat_usaha").text(data.userData['alamat_usaha']);
                    $("#no_telp").text(data.userData['no_telp']);
                    $("#email").text(data.userData['email']);
                }
                else{
                    $(".detail-user").hide();
                    $('#form-search-nib')[0].reset();
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: data.message,
                    });
                }
            }
        });
    });

    $('#btn-pengajuan-penangguhan').click(function(e){
        e.preventDefault("submit");

        nib = $("#nib_pelaku_usaha").text();

        $('#modal-form-pembataan').modal('show');
        $('#nib_modal').val(nib);
        $('#alasan_pembatalan').val('');
    });

    $('#upload_button').click(function(){ $('#rekomendasi_pembatalan').trigger('click'); });

    function changeName(input){
        var file_name = 'Selected File: '+ input.files[0].name;
        $("#file-name").html(file_name);
    }

    $("#btn-submit").click(function(e){
        e.preventDefault("submit")
        var formData = new FormData($('#form-send-submission')[0]);
        $.ajax({
            url:`${base_url}backend/pembatalan-akun/save-submission`,
            type:"post",
            dataType:'json',
            contentType: false,
            processData: false,
            data: formData,
            success:function(response){
                if (response.status == 200) {
                    Swal.fire({
                      type: 'success',
                      title: 'Success',
                      text: response.message,
                      showConfirmButton: false,
                      timer: 1500
                    }).then(() => {
                        location.reload();
                    })
                }
                else{
                    Swal.fire({
                      type: 'warning',
                      title: 'Error',
                      text: response.message,
                      showConfirmButton: false,
                      timer: 1500
                    })
                }
            }
        })
    })

    function closeModal(){
        $('#modal-form-pembataan').modal('hide');
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