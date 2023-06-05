<style type="text/css">
    .disabled-click{
        pointer-events: none;
        cursor: default;
        background-color: #cccccc;
        border-color: #cccccc;
    }
</style>
<div class="row">    
    <div class="col-12 text-right mb-2">
        <form action="" method="GET">
            <div class="form-row form_pelaku_usaha form_dinkes">
                <div class="form-group col-md-6">
                </div>
                <div class="form-group col-md-4">

                    <label>Cari Berdasarkan NIB</label>
                    <input type="text" class="form-control" name="q" value="<?php echo isset($_GET['q'])?$_GET['q']:''; ?>">

                </div>

                <div class="form-group col-md-2">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-block btn-warning" name="search" value="true"> <i class="fa fa-search" style="margin-right: 6px;"></i> Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $title; ?></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Provinsi</th>
                                <th>Kabupaten/Kota</th>
                                <th>NIB</th>
                                <th>Nama Pelaku Usaha</th>
                                <th>Alamat Usaha</th>
                                <th>Alasan Pembatalan</th>
                                <th width="7%">Terdaftar</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($datas as $key => $value) { ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $no++; ?></td>
                                <td><?php echo $value->nama_prov; ?></td>
                                <td><?php echo $value->nama_kabkot; ?></td>
                                <td><?php echo $value->nib; ?></td>
                                <td><?php echo $value->nama_pelaku_usaha; ?></td>
                                <td><?php echo $value->alamat_usaha; ?></td>
                                <td><?php echo $value->alasan_pembatalan_cara_pembuatan; ?></td>
                                <td><?php echo date('d-m-Y',strtotime($value->created_at)); ?></td>
                                <td>
                                    <div class="d-flex">
                                        <?php
                                            if ($value->status_dikembalikan == 2 && $this->userlog['id_role'] != 3) {
                                        ?>
                                            <a href="javascript:void(0)" onclick='pembatalanData("<?php echo encrypt_decrypt('encrypt', $value->nib); ?>","<?php echo $value->nib; ?>")' class="btn btn-success btn-xs mr-2">Approve</a>
                                            <a href="javascript:void(0)" onclick='tolakPenangguhan("<?php echo encrypt_decrypt('encrypt', $value->nib); ?>","<?php echo $value->nib; ?>")' class="btn btn-warning btn-xs mr-2">Reject</a>
                                            <a href="javascript:void(0)" onclick='openmodal("<?php echo encrypt_decrypt('encrypt', $value->nib); ?>")' title="Lihat Detail Alasan Penangguhan Akun" class="btn btn-info btn-xs mr-2"><i class="fa fa-eye"></i></a>
                                        <?php
                                            }
                                            if ($value->status_dikembalikan == 1) {
                                        ?>
                                        <a href="<?= !empty($value->surat_resmi_pembatalan) ? base_url('uploads/pengawasan/surat_resmi_pembatalan/').$value->surat_resmi_pembatalan : ''; ?>" target="_blank" title="Lihat Surat Resmi Pembatalan" class="btn btn-info btn-xs <?= !empty($value->surat_resmi_pembatalan) ? '' : 'disabled-click'; ?> mr-2"><i class="fa fa-file"></i></a>
                                        <?php
                                            }
                                        ?>
                                        <a href="<?= !empty($value->surat_rekomendasi_pembatalan) ? base_url('uploads/pengawasan/surat_rekomendasi_pembatalan/').$value->surat_rekomendasi_pembatalan : ''; ?>" target="_blank" title="Lihat Surat Rekomendasi Pembatalan" class="btn btn-info btn-xs mr-2 <?= !empty($value->surat_rekomendasi_pembatalan) ? '' : 'disabled-click'; ?>"><i class="fa fa-file"></i></a>
                                        <?php if ($value->status_dikembalikan == 1 && $this->userlog['id_role'] == 4) { ?>
                                            <a href="javascript:void(0)" onclick='uploadResmi("<?php echo encrypt_decrypt('encrypt', $value->nib); ?>","<?php echo $value->nib; ?>")' title="Upload Surat Resmi Pembatalan" class="btn btn-primary btn-xs mr-2"><i class="fa fa-cloud-upload fa-lg"></i></a>
                                        <?php } ?>
                                        <?php if ($value->status_dikembalikan == 2 && $this->userlog['id_role'] == 3) { ?>
                                            <a href="javascript:void(0)" onclick='uploadRekomendasi("<?php echo encrypt_decrypt('encrypt', $value->nib); ?>")' title="Upload Surat Rekomendasi Pembatalan" class="btn btn-primary btn-xs mr-2"><i class="fa fa-cloud-upload fa-lg"></i></a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group mt-2 text-right">
                                    Showing <?php echo ($total_data != 0) ? $start+1 : 0; ?> to <?php echo $start + count($datas); ?> of <?php echo $total_data; ?> entries
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <style type="text/css">
                                    .pagination{
                                        justify-content: flex-end !important;
                                    }
                                </style>
                                <?php if($pagination!=""){ ?>
                                    <?php echo $pagination; ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-sppirt" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-center" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#f93">
                <h5 class="modal-title">Alasan Penangguhan Akun dengan NIB: <span id="nib_modal"></span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alasan">
                <font color="red"><h5 id="no_baru">Nomor Baru:P-IRT 3036271010003-26</h5></font>
                <h5 id="no_lama">Nomor Lama:P-IRT 3036271010003-26</h5>
                <br>
                <p>Terdapat penyesuaian nomor urut pelaku usaha pada 4 digit terakhir nomor SPPIRT atau penyesuaian jumlah digit nomor SPPIRT</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form-rekomendasi-pembatalan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Unggah Surat Rekomendasi Pembekuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 needs-validation" novalidate method="POST" action="<?php echo base_url().'backend/verifikasi-cara-pembuatan/upload-rekomendasi-pembatalan'; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="nib_rekomendasi" id="nib_rekomendasi" value="">
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label">Unggah Surat Rekomendasi Pembekuan</label>
                        <div class="btn-group" style="padding-bottom: 7px;">
                            <button type="button" class="btn btn-primary" id="upload_rekomendasi">
                                <i class="fa fa-upload"></i>
                                <span>Unggah Surat Rekomendasi Pembekuan</span>
                            </button>
                        </div>
                        <input type="file" id="rekomendasi_pembatalan" name="rekomendasi_pembatalan" accept="application/pdf,application/,application/doc" onchange="changeFileName(this)" style="display: none;">
                        <br>
                        <span id="file-name"></span>
                        <h4 id="doc-template">Untuk contoh format surat rekomendasi pembekuan <a href="<?= base_url() ?>assets/backend/template_dokumen/contoh_format_pembekuan_dinkes.pdf" target="_blank"><br>Lihat Disini.</a></h4>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label"></label>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form-resmi-pembatalan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Unggah Surat Resmi Penangguhan Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="form-late-approve" novalidate method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="url_return" value="backend/pembatalan-akun/pembatalan-disetujui">
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label col-md-12">Unggah Surat Resmi Penangguhan</label>
                        <div class="btn-group col-md-12" style="padding-bottom: 7px;">
                            <button type="button" class="btn btn-primary" id="late_upload_button">
                                <i class="fa fa-upload"></i>
                                <span>Unggah Surat Resmi Penangguhan</span>
                            </button>
                        </div>
                        <input type="file" id="resmi_late_pembatalan" name="resmi_pembatalan" accept="application/pdf,application/,application/doc" onchange="changeNameLate(this)" style="display: none;">
                        <br>
                        <span id="file-name-late"></span>
                        <h4 id="doc-template">Untuk contoh format surat resmi pembekuan <a href="<?= base_url() ?>assets/backend/template_dokumen/contoh_format_pembekuan_ptsp.pdf" target="_blank"><br>Lihat Disini.</a></h4>
                    </div>
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label"></label>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form-pembataan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Persetujuan Penangguhan Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Dengan mengisi form ini anda akan menyetujui penangguhan akun dengan NIB: <span id="nib"></span></h4>
                <form class="row g-3 needs-validation" id="form-approve" novalidate method="POST" action="" enctype="multipart/form-data">
                    <div class="col-md-12">
                        
                    </div>
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label col-md-12">Unggah Surat Resmi Pembekuan</label>
                        <div class="btn-group col-md-12" style="padding-bottom: 7px;">
                            <button type="button" class="btn btn-primary" id="upload_button">
                                <i class="fa fa-upload"></i>
                                <span>Unggah Surat Resmi Pembekuan</span>
                            </button>
                        </div>
                        <input type="file" id="resmi_pembatalan" name="resmi_pembatalan" accept="application/pdf,application/,application/doc" onchange="changeName(this)" style="display: none;">
                        <br>
                        <span id="file-name"></span>
                        <h4 id="doc-template">Untuk contoh format surat resmi pembekuan <a href="<?= base_url() ?>assets/backend/template_dokumen/contoh_format_pembekuan_ptsp.pdf" target="_blank"><br>Lihat Disini.</a></h4>
                    </div>
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label"></label>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form-tolak-penangguhan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Penolakan Penangguhan Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Dengan mengisi form ini anda akan menolak penangguhan akun dengan NIB: <span id="nib_tolak_penangguhan"></span></h4>
                <form class="row g-3 needs-validation" id="form-cancel" novalidate method="POST" action="" enctype="multipart/form-data">
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label">Alasan Penolakan Penangguhan akun</label>
                        <textarea class="form-control" name="alasan_penolakan_penangguhan_akun" id="alasan_penolakan_penangguhan_akun" style="height: 300px;"></textarea>
                    </div>
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label"></label>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" >
function pembatalanData(id,nib){
    var url = "<?php echo base_url('backend/pembatalan-akun/approve/'); ?>"+id;

    $('#modal-form-pembataan').modal('show');
    $('#form-approve').attr('action', url);
    $('#nib').html(nib);

}

function tolakPenangguhan(id,nib){
    var url = "<?php echo base_url('backend/pembatalan-akun/cancel/'); ?>"+id;

    $('#modal-form-tolak-penangguhan').modal('show');
    $('#form-cancel').attr('action', url);
    $('#nib_tolak_penangguhan').html(nib);

}

function closeModal(){
    $('#modal-form-pembataan').modal('hide');
    $('#modal-form-rekomendasi-pembatalan').modal('hide');
    $('#modal-form-resmi-pembatalan').modal('hide');
    $('#modal-form-tolak-penangguhan').modal('hide');
}

$('#upload_button').click(function(){ $('#resmi_pembatalan').trigger('click'); });

function changeName(input){
    var file_name = 'Selected File: '+ input.files[0].name;
    $("#file-name").html(file_name);
}


$('#upload_rekomendasi').click(function(){ $('#rekomendasi_pembatalan').trigger('click'); });

function changeFileName(input){
    var file_name = 'Selected File: '+ input.files[0].name;
    $("#file-name").html(file_name);
}

function uploadRekomendasi(nib){

    $('#modal-form-rekomendasi-pembatalan').modal('show');
    $('#nib_rekomendasi').val(nib);

}

$('#late_upload_button').click(function(){ $('#resmi_late_pembatalan').trigger('click'); });

function changeNameLate(input){
    var file_name = 'Selected File: '+ input.files[0].name;
    $("#file-name-late").html(file_name);
}

function uploadResmi(id,nib){
    var url = "<?php echo base_url('backend/pembatalan-akun/approve/'); ?>"+id;

    $('#modal-form-resmi-pembatalan').modal('show');
    $('#form-late-approve').attr('action', url);
    // $('#nib').val(nib);

}

function approveData(id) {
    swal({
        title: 'Are you sure?',
        text: "Anda yakin akan menyetujui pembatalan ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.value) {
            window.location.href = "<?php echo base_url('backend/pembatalan-akun/approve/'); ?>"+id;
        }
    })
}

function rejectData(id) {
    swal({
        title: 'Are you sure?',
        text: "Anda yakin akan menolak pembatalan ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.value) {
            window.location.href = "<?php echo base_url('backend/pembatalan-akun/cancel/'); ?>"+id;
        }
    })
}

function openmodal(nib) {
    $.ajax({
        url:`${base_url}backend/VerifikasiCaraPembuatanController/getHasilVerifikasi`,
        type:"post",
        dataType:'json',
        data: {nib: nib},
        success:function(response){
            if (response.status == 'success') {
                $(".alasan").html(response.data);
                $("#nib_modal").html(response.nib);
                $("#modal-sppirt").modal("show");
            }else{
                
                swal({
                  type: 'error',
                  title: 'Oops...',
                  text: 'Gagal mengambil data, silakan ulangi beberapa saat lagi',
                });
            }
        }
    })
    // $("#modal-sppirt").modal("show");
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