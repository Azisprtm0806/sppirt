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
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-success" style="margin-top: 29px;float:left" name="export" value="true"> <i class="fa fa-file-excel-o"></i> Export Excel</button>
                </div>
                <div class="form-group col-md-4">
                </div>
                <div class="form-group col-md-4">

                    <label>Cari Berdasarkan NIB/No. SPPIRT</label>
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
                                <th>No SPPIRT</th>
                                <th>Nama Branding</th>
                                <th>Produk Pangan</th>
                                <th>Wilayah</th>
                                <th>NIB</th>
                                <th>Alasan Pembatalan</th>
                                <th>Tanggal Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($datas as $key => $value) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <?php if($value->status_no_sppirt==1){ ?>
                                        <br><button type="button" class="badge badge-danger">BERUBAH</button><br>
                                        <a href='javascript:void(0)' onclick='openmodal(`<?php echo $value->no_sppirt; ?>`,`<?php echo $value->no_sppirt_lama; ?>`)' style='color:#008FC3'> Lihat riwayat</a><br>
                                        <?php echo $value->no_sppirt; ?>
                                    <?php }else{ ?>
                                        <?php echo $value->no_sppirt; ?>
                                    <?php } ?>

                                    <br>Masa Berlaku:<br> <i><font color="purple"><?php echo date('d-m-Y', strtotime('+5 years', strtotime($value->tgl_pengajuan))); ?></font></i></td>
                                <td><?php echo $value->nama_produk_pangan; ?></td>
                                <td>
                                    <b>Kategori:</b> <i><?php echo $value->nama_kategori_jenis_pangan; ?></i><br>
                                    <b>Jenis:</b> <i><?php echo $value->nama_jenis_pangan; ?></i><br>
                                    <b>Kemasan:</b> <i><?php echo $value->nama_kemasan; ?></i>
                                </td>
                                <td><?php echo $value->nama_prov; ?><br><?php echo $value->nama_kabkot; ?></td>
                                <td><?php echo $value->nib; ?></td>
                                <td><?php echo $value->alasan_pembatalan; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($value->tgl_pengajuan)); ?></td>
                                <td>
                                    <div class="d-flex">
                                        <?php if($value->status_ptsp_product=='0' && $this->userlog['id_role'] != 3){ ?>
                                            <a href="javascript:void(0)" onclick='pembatalanData("<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>","<?php echo $value->no_sppirt; ?>")' class="btn btn-success btn-xs mr-2">Approve</a>
                                            <a href="javascript:void(0)" onclick='rejectData("<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>")' class="btn btn-warning btn-xs mr-2">Reject</a>
                                        <?php } if ($value->status_ptsp_product == '1') { ?>
                                        <a href="<?= !empty($value->surat_resmi_pembatalan) ? base_url('uploads/verifikasiproduk/surat_resmi_pembatalan/').$value->surat_resmi_pembatalan : ''; ?>" target="_blank" title="Lihat Surat Resmi Pembatalan" class="btn btn-info btn-xs <?= !empty($value->surat_resmi_pembatalan) ? '' : 'disabled-click'; ?> mr-2"><i class="fa fa-file"></i></a>
                                        <?php } ?>
                                        <a href="<?= !empty($value->surat_rekomendasi_pembatalan) ? base_url('uploads/verifikasiproduk/surat_rekomendasi_pembatalan/').$value->surat_rekomendasi_pembatalan : ''; ?>" target="_blank" title="Lihat Surat Rekomendasi Pembatalan" class="btn btn-info btn-xs mr-2 <?= !empty($value->surat_rekomendasi_pembatalan) ? '' : 'disabled-click'; ?>"><i class="fa fa-file"></i></a>
                                        <?php if ($value->status_ptsp_product=='1' && $this->userlog['id_role'] == 4) { ?>
                                            <a href="javascript:void(0)" onclick='uploadResmi("<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>","<?php echo $value->no_sppirt; ?>")' title="Upload Surat Rekomendasi Pembatalan" class="btn btn-primary btn-xs mr-2"><i class="fa fa-cloud-upload fa-lg"></i></a>
                                        <?php } ?>
                                        <?php if ($value->status_ptsp_product=='0' && $this->userlog['id_role'] == 3) { ?>
                                            <a href="javascript:void(0)" onclick='uploadRekomendasi("<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>")' title="Upload Surat Rekomendasi Pembatalan" class="btn btn-primary btn-xs mr-2"><i class="fa fa-cloud-upload fa-lg"></i></a>
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
        <h5 class="modal-title">Riwayat Perubahan Nomor SPPIRT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 id="no_baru">Nomor Baru:P-IRT 3036271010003-26</h5>
        <h5 id="no_lama">Nomor Lama:P-IRT 3036271010003-26</h5>
        <br>
        <p>Terdapat penyesuaian nomor urut pelaku usaha pada 4 digit terakhir nomor SPPIRT</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-form-rekomendasi-pembatalan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Unggah Surat Rekomendasi Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 needs-validation" novalidate method="POST" action="<?php echo base_url().'backend/verifikasi-produk/upload-rekomendasi-pembatalan'; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="">
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label">Unggah Surat Rekomendasi Pembatalan</label>
                        <div class="btn-group" style="padding-bottom: 7px;">
                            <button type="button" class="btn btn-primary" id="upload_rekomendasi">
                                <i class="fa fa-upload"></i>
                                <span>Unggah Surat Rekomendasi Pembatalan</span>
                            </button>
                        </div>
                        <input type="file" id="rekomendasi_pembatalan" name="rekomendasi_pembatalan" accept="application/pdf,application/,application/doc" onchange="changeFileName(this)" style="display: none;">
                        <br>
                        <span id="file-name"></span>
                        <h4 id="doc-template">Untuk contoh format surat rekomendasi pembatalan <a href="<?= base_url() ?>assets/backend/template_dokumen/contoh_format_pembatalan_dinkes.pdf" target="_blank"><br>Lihat Disini.</a></h4>
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
                <h5 class="modal-title" id="exampleModalLabel">Form Unggah Surat Resmi Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="form-late-approve" novalidate method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="url_return" value="backend/pembatalan-disetujui">
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label col-md-12">Unggah Surat Resmi Pembatalan</label>
                        <div class="btn-group col-md-12" style="padding-bottom: 7px;">
                            <button type="button" class="btn btn-primary" id="late_upload_button">
                                <i class="fa fa-upload"></i>
                                <span>Unggah Surat Resmi Pembatalan</span>
                            </button>
                        </div>
                        <input type="file" id="resmi_late_pembatalan" name="resmi_pembatalan" accept="application/pdf,application/,application/doc" onchange="changeNameLate(this)" style="display: none;">
                        <br>
                        <span id="file-name-late"></span>
                        <h4 id="doc-template">Untuk contoh format surat resmi pembatalan <a href="<?= base_url() ?>assets/backend/template_dokumen/contoh_format_pembatalan_ptsp.pdf" target="_blank"><br>Lihat Disini.</a></h4>
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
                <h5 class="modal-title" id="exampleModalLabel">Form Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Dengan mengisi form ini anda akan menyetujui pembatalan verifikasi PIRT dengan nomor: <span id="sppirt"></span></h4>
                <form class="row g-3 needs-validation" id="form-approve" novalidate method="POST" action="" enctype="multipart/form-data">
                    <div class="col-md-12">
                        
                    </div>
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label col-md-12">Unggah Surat Resmi Pembatalan</label>
                        <div class="btn-group col-md-12" style="padding-bottom: 7px;">
                            <button type="button" class="btn btn-primary" id="upload_button">
                                <i class="fa fa-upload"></i>
                                <span>Unggah Surat Resmi Pembatalan</span>
                            </button>
                        </div>
                        <input type="file" id="resmi_pembatalan" name="resmi_pembatalan" accept="application/pdf,application/,application/doc" onchange="changeName(this)" style="display: none;">
                        <br>
                        <span id="file-name"></span>
                        <h4 id="doc-template">Untuk contoh format surat resmi pembatalan <a href="<?= base_url() ?>assets/backend/template_dokumen/contoh_format_pembatalan_ptsp.pdf" target="_blank"><br>Lihat Disini.</a></h4>
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
function pembatalanData(id,sppirt){
    var url = "<?php echo base_url('backend/permohonan-pembatalan/approve/'); ?>"+id;

    $('#modal-form-pembataan').modal('show');
    $('#form-approve').attr('action', url);
    $('#sppirt').html(sppirt);    

}

function closeModal(){
    $('#modal-form-pembataan').modal('hide');
    $('#modal-form-rekomendasi-pembatalan').modal('hide');
    $('#modal-form-resmi-pembatalan').modal('hide');
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

function uploadRekomendasi(id){

    $('#modal-form-rekomendasi-pembatalan').modal('show');
    $('#id_pengajuan').val(id);

}



$('#late_upload_button').click(function(){ $('#resmi_late_pembatalan').trigger('click'); });

function changeNameLate(input){
    var file_name = 'Selected File: '+ input.files[0].name;
    $("#file-name-late").html(file_name);
}

function uploadResmi(id,nib){
    var url = "<?php echo base_url('backend/permohonan-pembatalan/approve/'); ?>"+id;

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
            window.location.href = "<?php echo base_url('backend/permohonan-pembatalan/approve/'); ?>"+id;
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
            window.location.href = "<?php echo base_url('backend/permohonan-pembatalan/cancel/'); ?>"+id;
        }
    })
}

function selectProvinsi() {

    var id_provinsi = $('#id_provinsi').val();
    var id_kab_kota = $('#id_kab_kota').val();

    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>load-kab-kota",
        data: JSON.stringify({
            id_provinsi: id_provinsi,
            id_kab_kota: id_kab_kota
        }),
        contentType: "application/json; charset=utf-8",
        dataType: 'json',
        success: function(res) {
            $('#id_kab_kota').html(res.data)
        }

    })

}
selectProvinsi();

function openmodal(no_baru,no_lama){

    $("#modal-sppirt").modal("show");
    $("#no_baru").html('Nomor Baru: '+no_baru);
    $("#no_lama").html('Nomor Lama: '+no_lama);
    
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