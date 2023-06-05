<div class="row">    
    <div class="col-12 text-right mb-2">
        <form action="" method="GET">
            <div class="form-row form_pelaku_usaha form_dinkes">
                <div class="form-group col-md-2">
                    <?php if(isset($_GET['q'])): ?>
                        <button type="submit" class="btn btn-success" style="margin-top: 29px;float:left" name="export" value="true" disabled> <i class="fa fa-file-excel-o"></i> Export Excel</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-success" style="margin-top: 29px;float:left" name="export" value="true"> <i class="fa fa-file-excel-o"></i> Export Excel</button>
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-2">
                    <label>Cari Berdasarkan NIB</label>
                    <input type="text" class="form-control" name="q" value="<?php echo isset($_GET['q'])?$_GET['q']:''; ?>">
                </div>
                <div class="form-group col-md-2">
                    <label>Status Verifikasi</label>
                    <select name="status" class="form-control" id="status">
                        <option value="4"  <?php if (isset($_GET['status']) && $_GET['status'] == "") { ?> selected <?php } ?>>Semua</option>
                        <option value="0" <?php if (isset($_GET['status']) && $_GET['status'] == "0") { ?> selected <?php } ?>>Verifikasi Belum Lengkap</option>
                        <option value="1" <?php if (isset($_GET['status']) && $_GET['status'] == "1") { ?> selected <?php } ?>>Sudah Diverifikasi</option>
                        <option value="3" <?php if (isset($_GET['status']) && $_GET['status'] == "3") { ?> selected <?php } ?>>Menunggu Verifikasi</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <?php
                        $readonlyprov = '';
                        $readonly = '';
                        $prov = isset($_GET['id_prov'])?$_GET['id_prov']:'';
                        $kota = isset($_GET['id_kota'])?$_GET['id_kota']:'';

                        if (($this->userlog['id_role'] == '3') || ($this->userlog['id_role'] == '4')) {
                            $readonlyprov = 'disabled';
                            $readonly = 'disabled';
                            $prov = $this->userlog['id_prov'];
                            $kota = $this->userlog['id_kota'];
                        }else if ($this->userlog['id_role'] == '5') {
                            $readonlyprov = 'disabled';
                            $prov = $this->userlog['id_prov'];
                        }
                    ?>

                    <label>Provinsi</label>
                    <select name="id_prov" class="form-control" id="id_provinsi" onchange="selectProvinsi()" <?php echo $readonlyprov; ?>>
                        <option value="">Pilih ...</option>
                        <?php foreach ($provinsi as $key => $value) { ?>
                            <option value="<?php echo $value->id_prov; ?>" <?php if ($prov == $value->id_prov) { ?> selected <?php } ?>><?php echo $value->nama_prov; ?></option>
                        <?php } ?>
                    </select>

                </div>
                <div class="form-group col-md-2">
                    <label>Kab/Kota</label>
                    <select name="id_kota" class="form-control" id="id_kab_kota" <?php echo $readonly; ?>>
                        <option value="">Pilih ...</option> 
                        <?php if (isset($kota)){ ?> <option value="<?php echo  $kota; ?>" selected><?php echo  $kota; ?></option> <?php } ?>
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
                <h4 class="card-title">List Pelaku Usaha</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Provinsi</th>
                                <th>Kabupaten/Kota</th>
                                <th>Kecamatan</th>
                                <th>Desa/Kelurahan</th>
                                <th>NIB</th>
                                <th>Nama Pelaku Usaha</th>
                                <th>Alamat Usaha</th>
                                <th>Phone</th>
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
                                <td><?php echo $value->nama_kecamatan; ?></td>
                                <td><?php echo $value->nama_desa; ?></td>
                                <td><?php echo $value->nib; ?></td>
                                <td><?php echo $value->nama_pelaku_usaha; ?></td>
                                <td><?php echo $value->alamat_usaha; ?></td>
                                <td><?php echo $value->no_telp; ?></td>
                                <td><?php echo date('d-m-Y',strtotime($value->created_at)); ?></td>
                                <td>
                                    <div class="d-flex">
                                        <?php if ($value->status_verifikasi_pkp == '0') { ?>
                                            <a href="<?php echo base_url(); ?>backend/verifikasi-pkp/verifikasi/<?php echo encrypt_decrypt('encrypt', $value->nib); ?>" target="_blank" class="btn btn-warning btn-xs">Verifikasi Belum Lengkap</a>
                                        <?php }else if ($value->status_verifikasi_pkp == '1') { ?>
                                            <a href="<?php echo base_url(); ?>backend/verifikasi-pkp/verifikasi/<?php echo encrypt_decrypt('encrypt', $value->nib); ?>" target="_blank" class="btn btn-success btn-xs">Sudah Diverifikasi</a>
                                        <?php }else{ ?>
                                            <a href="<?php echo base_url(); ?>backend/verifikasi-pkp/verifikasi/<?php echo encrypt_decrypt('encrypt', $value->nib); ?>" target="_blank" class="btn btn-primary btn-xs">Menunggu Diverifikasi</a>
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


<div class="modal fade" id="modal-form-pembataan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 needs-validation" novalidate method="POST" action="<?php echo base_url().'backend/verifikasi-produk/pengajuan-pembatalan'; ?>">
                    <div class="col-md-12">
                        <label class="form-label">Alasan</label>
                        <input type="hidden" name="id_pengajuan" id="id_pengajuan">
                        <textarea class="form-control" name="alasan_pembatalan" id="alasan_pembatalan" style="height: 300px;"></textarea>
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
            window.location.href = "<?php echo base_url('backend/verifikasi-produk/approve/'); ?>"+id;
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
            window.location.href = "<?php echo base_url('backend/verifikasi-produk/cancel/'); ?>"+id;
        }
    })
}

function pembatalanData(id){

    $('#modal-form-pembataan').modal('show');
    $('#id_pengajuan').val(id);
    $('#alasan_pembatalan').val('');

}

function closeModal(){
    $('#modal-form-pembataan').modal('hide');
    $('#id_pengajuan').val('');
    $('#alasan_pembatalan').val('');
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