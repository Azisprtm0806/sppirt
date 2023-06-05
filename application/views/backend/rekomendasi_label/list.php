<div class="row">    
    <div class="col-12 text-right mb-2">
        <form action="" method="GET">
            <div class="form-row form_pelaku_usaha form_dinkes">
                <div class="form-group col-md-5">

                    <label>Cari Berdasarkan NIB/No. SPPIRT</label>
                    <input type="text" class="form-control" name="q" value="<?php echo isset($_GET['q'])?$_GET['q']:''; ?>">

                </div>
                <div class="form-group col-md-5">

                    <label>Status Verifikasi</label>
                    <select name="status" class="form-control" id="status">
                        <option value="0" <?php if (isset($_GET['status']) && $_GET['status'] == "0") { ?> selected <?php } ?>>Menunggu Perbaikan Pelaku Usaha</option>
                        <option value="3" <?php if (isset($_GET['status']) && $_GET['status'] == "3") { ?> selected <?php } ?>>Menunggu Verifikasi</option>
                        <option value=""  <?php if (isset($_GET['status']) && $_GET['status'] == "") { ?> selected <?php } ?>>Semua</option>
                        <option value="1" <?php if (isset($_GET['status']) && $_GET['status'] == "1") { ?> selected <?php } ?>>Sudah Diverifikasi</option>
                        <option value="2" <?php if (isset($_GET['status']) && $_GET['status'] == "2") { ?> selected <?php } ?>>Sudah Diperbaiki oleh Pelaku Usaha</option>
                    </select>

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
                <h4 class="card-title">List Pengajuan</h4>
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
                                <th>Tanggal Pengajuan</th>
                                <th>Status OSS</th>
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
                                <td><?php echo date('d-m-Y', strtotime($value->tgl_pengajuan)); ?></td>
                                <td>
                                    <?php if($value->status_sinkronisasi=='1'){ ?>
                                        <div><?php echo $value->id_izin; ?></div>
                                        <button type="button" class="badge badge-success">TERKIRIM OSS</button>
                                    <?php }else { ?>
                                        <button type="button" class="badge badge-warning"> BELUM TERKIRIM OSS</button>
                                    <?php } ?>
                                <td>

                                    
                                    <!-- <div class="d-flex">

                                        <a href="<?php echo base_url(); ?>backend/rekomendasi-label/verifikasi/<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>" type="button" title="Lihat Label" class="btn btn-info shadow btn-xs sharp mr-1" target="_blank" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a>

                                    </div> -->

                                    <div class="d-flex">

                                        <?php if ($value->status_verifikasi_label == '0') { ?>
                                            <a href="<?php echo base_url(); ?>backend/rekomendasi-label/verifikasi/<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>" target="_blank" class="btn btn-warning btn-xs">Menunggu Perbaikan Pelaku Usaha</a>
                                        <?php }else if ($value->status_verifikasi_label == '1') { ?>
                                            <a href="<?php echo base_url(); ?>backend/rekomendasi-label/verifikasi/<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>" target="_blank" class="btn btn-success btn-xs">Sudah Diverifikasi</a>
                                        <?php }else if ($value->status_verifikasi_label == '2') { ?>
                                            <a href="<?php echo base_url(); ?>backend/rekomendasi-label/verifikasi/<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>" target="_blank" class="btn btn-warning btn-xs">Menunggu Verifikasi Label</a>
                                        <?php }else{ ?>
                                            <a href="<?php echo base_url(); ?>backend/rekomendasi-label/verifikasi/<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>" target="_blank" class="btn btn-primary btn-xs">Menunggu Diverifikasi</a>
                                        <?php } ?>
<!-- 
                                        <a href="javascript:void(0)" onclick='pembatalanData("<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>")' class="btn btn-danger btn-xs">Pembatalan</a>
                                        <a href="javascript:void(0)" onclick='approveData("<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>")' class="btn btn-success btn-xs">Approve</a>
                                        <a href="javascript:void(0)" onclick='rejectData("<?php echo encrypt_decrypt('encrypt', $value->id_pengajuan); ?>")' class="btn btn-warning btn-xs">Reject</a>
 -->
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
                                    Showing <?php echo ($start+1); ?> to <?php echo $start + count($datas); ?> of <?php echo $total_data; ?> entries
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

function closeModal(){
    $('#modal-form-pembataan').modal('hide');
    $('#id_pengajuan').val('');
    $('#alasan_pembatalan').val('');
}

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