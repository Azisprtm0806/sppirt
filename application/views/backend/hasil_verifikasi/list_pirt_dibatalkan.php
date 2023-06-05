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

                    <label>Cari Berdasarkan No. SPPIRT</label>
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
                <h4 class="card-title">List PIRT yang dibatalkan</h4>
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
                                <td><b>Kategori:</b> <i><?php echo $value->nama_kategori_jenis_pangan; ?></i><br><b>Jenis:</b> <i><?php echo $value->nama_jenis_pangan; ?></i><br><b>Kemasan:</b> <i><?php echo $value->nama_kemasan; ?></i></td>
                                <td><?php echo $value->nama_prov; ?><br><?php echo $value->nama_kabkot; ?></td>
                                <td><?php echo $value->nib; ?></td>
                                <td><?php echo $value->alasan_pembatalan; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($value->tgl_pengajuan)); ?></td>
                                <td>
                                    <div class="d-flex">
                                        <?php if ($value->status_ptsp_product == '1') { ?>
                                        <a href="<?= !empty($value->surat_resmi_pembatalan) ? base_url('uploads/verifikasiproduk/surat_resmi_pembatalan/').$value->surat_resmi_pembatalan : ''; ?>" target="_blank" title="Lihat Surat Resmi Pembatalan" class="btn btn-info btn-xs <?= !empty($value->surat_resmi_pembatalan) ? '' : 'disabled-click'; ?> mr-2"><i class="fa fa-file"></i></a>
                                        <?php } ?>
                                        <a href="<?= !empty($value->surat_rekomendasi_pembatalan) ? base_url('uploads/verifikasiproduk/surat_rekomendasi_pembatalan/').$value->surat_rekomendasi_pembatalan : ''; ?>" target="_blank" title="Lihat Surat Rekomendasi Pembatalan" class="btn btn-info btn-xs <?= !empty($value->surat_rekomendasi_pembatalan) ? '' : 'disabled-click'; ?>"><i class="fa fa-file"></i></a>
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

<script type="text/javascript" >
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