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
                <h4 class="card-title">List Akun yang Ditangguhkan</h4>
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
                                <th>Alasan Penangguhan</th>
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
                                            if ($value->status_dikembalikan == 1) {
                                        ?>
                                        <a href="<?= !empty($value->surat_resmi_pembatalan) ? base_url('uploads/pengawasan/surat_resmi_pembatalan/').$value->surat_resmi_pembatalan : ''; ?>" target="_blank" title="Lihat Surat Resmi Pembatalan" class="btn btn-info btn-xs <?= !empty($value->surat_resmi_pembatalan) ? '' : 'disabled-click'; ?> mr-2"><i class="fa fa-file"></i></a>
                                        <?php
                                            }
                                        ?>
                                        <a href="<?= !empty($value->surat_rekomendasi_pembatalan) ? base_url('uploads/pengawasan/surat_rekomendasi_pembatalan/').$value->surat_rekomendasi_pembatalan : ''; ?>" target="_blank" title="Lihat Surat Rekomendasi Pembatalan" class="btn btn-info btn-xs mr-2 <?= !empty($value->surat_rekomendasi_pembatalan) ? '' : 'disabled-click'; ?>"><i class="fa fa-file"></i></a>

                                        <a href="javascript:void(0)" onclick='approveData("<?php echo encrypt_decrypt('encrypt', $value->nib); ?>")' class="btn btn-success btn-xs mr-2">Reactivate Akun</a>
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

<script type="text/javascript" >
function approveData(id) {
    swal({
        title: 'Are you sure?',
        text: "Anda yakin mengaktifkan kembali akun ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.value) {
            window.location.href = "<?php echo base_url('backend/pembatalan-akun/process-reactivate/'); ?>"+id;
        }
    })
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