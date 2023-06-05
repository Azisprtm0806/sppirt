<style type="text/css">
    table[border="1"] {
    border-collapse:collapse;
    color:#000;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 13px;
    width: 100%;
    }
    table[border="1"] th, table[border="1"] td {
    vertical-align:middle;
    padding:10px 5px;
    border:1px solid #ebebeb;
    font-size: 13px;
    background: #fff;
    color:#666 !important;
    }
    table[border="1"] th {
    background:#3FBBC0;
    color:#000;
    font-size: 13px;
    text-align: center;
    }
    table[border="0"] {
    border-collapse:collapse;
    color:#000;
    font-family: Arial, Helvetica, sans-serif
    }
    #title_report{text-transform:uppercase; font-size: 30px; font-weight: bold;}
    #address_report{font-size: 20px;}
</style>

<div class="row">    
    <div class="col-12 text-right mb-2">
        <form action="" method="GET">
            <div class="form-row form_pelaku_usaha form_dinkes">
                <div class="form-group col-md-2">
                    <?php if(!isset($_GET['search']) && $_GET['search']=true) : ?>
                        <button type="submit" disabled class="btn btn-success" style="margin-top: 35px;float:left" name="export" value="true"> <i class="fa fa-file-excel-o" style="margin-right: 6px;"></i> Export Excel</button>
                        <?php else:?>
                            <button type="submit" class="btn btn-success" style="margin-top: 35px;float:left" name="export" value="true"> <i class="fa fa-file-excel-o" style="margin-right: 6px;"></i> Export Excel</button>
                    <?php endif; ?>

                </div>
                <div class="form-group col-md-2">

                    <label>Status</label>
                    <select name="status" class="form-control" id="status" >>
                        <option value="4">ALL STATUS</option>
                        <option value="2" <?php if (isset($_GET['status']) && $_GET['status']==2) { ?> selected <?php } ?>> PIRT TERBIT </option>
                        <option value="0" <?php if (isset($_GET['status']) && $_GET['status']==0) { ?> selected <?php } ?>> USULAN DITOLAK </option>
                        <option value="1" <?php if (isset($_GET['status']) && $_GET['status']==1) { ?> selected <?php } ?>> USULAN DITANGGUHKAN </option>
                        <option value="3" <?php if (isset($_GET['status']) && $_GET['status']==3) { ?> selected <?php } ?>> USULAN DIBATALKAN </option>
                    </select>

                </div>
                <div class="form-group col-md-3">

                    <label>Provinsi</label>
                    <select name="id_prov" class="form-control" id="id_provinsi" onchange="selectProvinsi()" <?php if ($userData['id_role']==3 || $userData['id_role']==4 || $userData['id_role']==5 || $userData['id_role']==8){ ?> disabled <?php } ?>>
                        <option value="">Pilih ...</option>
                        <?php foreach ($provinsi as $key => $value) { ?>
                            <option value="<?php echo $value->id_prov; ?>" <?php if ((isset($_GET['id_prov']) && $_GET['id_prov'] == $value->id_prov) || (($userData['id_role']==3 || $userData['id_role']==4 || $userData['id_role']==5 || $userData['id_role']==8) && $userData['id_prov']==$value->id_prov)) { ?> selected <?php } ?>><?php echo $value->nama_prov; ?></option>
                        <?php } ?>
                    </select>

                </div>
                <div class="form-group col-md-3">
                    <label>Kab/Kota</label>
                    <select name="id_kota" class="form-control" id="id_kab_kota" <?php if ($userData['id_role']==3 || $userData['id_role']==4){ ?> disabled <?php } ?>>
                        <option value="">Pilih ...</option> 
                        <?php if (isset($_GET['id_kota'])){ ?> <option value="<?php echo  $_GET['id_kota']; ?>" selected><?php echo  $_GET['id_kota']; ?></option> <?php } ?>
                        <?php if ($userData['id_role']==3 || $userData['id_role']==4){ ?> 
                            <option value="<?php echo  $userData['id_kota']; ?>" selected><?php echo  $userData['id_kota']; ?></option> 
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-block btn-warning" name="search" value="true"> <i class="fa fa-search" style="margin-right: 6px;"></i> Tampilkan</button>
                </div>
            </div>
        </form>
    </div>
        <!--<a href="<?= base_url('backend/irtp') ?>" title="Buat Pengajuan IRTP" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Buat Pengajuan IRTP</a>-->
    <div class="col-lg-12">
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NO SPPIRT</th>
                    <th>Nama Branding</th>
                    <th>Kategori Jenis</th>
                    <th>Nama Jenis</th>
                    <th>Wilayah</th>
                    <th>NIB</th>
                    <th>TANGGAL PENGAJUAN</th>
                    <th>STATUS OSS</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach ($datas as $key => $value) { ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no++; ?></td>
                    <td><?php echo $value->no_sppirt; ?></td>
                    <td><?php echo $value->nama_produk_pangan; ?></td>
                    <td><?php echo $value->nama_kategori_jenis_pangan; ?></td>
                    <td><?php echo $value->nama_jenis_pangan; ?></td>
                    <td>
                        <b>Provinsi:</b> <?php echo $value->nama_prov; ?>,<br>
                        <b>Kota:</b> <?php echo $value->nama_kota; ?>,<br>
                        <b>Kecamatan:</b> <?php echo $value->nama_kecamatan; ?><br>
                        <b>Kelurahan:</b> <?php echo $value->nama_desa; ?>
                    </td>
                    <td><?php echo $value->nib; ?></td>
                    <td><?php echo $value->tgl_prengajuan; ?></td>
                    <td><?php echo $value->status_oss; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
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

<script type="text/javascript" >
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