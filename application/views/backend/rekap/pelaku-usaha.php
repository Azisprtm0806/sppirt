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
                <div class="form-group col-md-4">
                    <button type="submit" class="btn btn-success" style="margin-top: 35px;float:left" name="export" value="true"> <i class="fa fa-file-excel-o" style="margin-right: 6px;"></i> Export Excel</button>
                </div>
                <div class="form-group col-md-3">

                    <label>Provinsi</label>
                    <select name="id_prov" class="form-control" id="id_provinsi" onchange="selectProvinsi()" <?php if ($userData['id_role']==3 || $userData['id_role']==4 || $userData['id_role']==5){ ?> disabled <?php } ?>>
                        <option value="">Pilih ...</option>
                        <?php foreach ($provinsi as $key => $value) { ?>
                            <option value="<?php echo $value->id_prov; ?>" <?php if ((isset($_GET['id_prov']) && $_GET['id_prov'] == $value->id_prov) || (($userData['id_role']==3 || $userData['id_role']==4 || $userData['id_role']==5) && $userData['id_prov']==$value->id_prov)) { ?> selected <?php } ?>><?php echo $value->nama_prov; ?></option>
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
        <i><font color="red">*) Silahkan klik nomor pada kolom no. wa pelaku usaha untuk tersambung dengan wa melalu whatsapp web</font></i><br>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Provinsi</th>
                    <th>Kabupaten/Kota</th>
                    <th>NIB</th>
                    <th>Nama Pelaku Usaha</th>
                    <th>No Urut</th>
                    <th>Alamat Usaha</th>
                    <th>No. WA <br><font color="red"><sup><i>*Klik Nomor WA</i></sup></font></th>
                    <th width="7%">Terdaftar</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach ($datas as $key => $value) { ?>
                <tr>
                    <td style="text-align: center;"><?php echo $no++; ?></td>
                    <td><?php echo $value->nama_prov; ?></td>
                    <td><?php echo $value->nama_kota; ?></td>
                    <td><?php echo $value->nib; ?></td>
                    <td><?php echo $value->nama_pelaku_usaha; ?></td>
                    <td><?php echo '<font color=blue>'. $value->no_urut_pelaku_usaha .'</font>'; ?></td>
                    <td><?php echo $value->alamat_usaha; ?></td>
                    <td><a href="https://wa.me/62<?php echo $value->no_telp; ?>" target="_blank"><?php echo $value->no_telp; ?></a></td>
                    <td><?php echo date('d-m-Y',strtotime($value->created_at)); ?></td>
                    <td>
                        <a href="<?= $value->nama_pelaku_usaha; ?>" class="btn btn-info btn-xs">Detail</a>
                    </td>
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