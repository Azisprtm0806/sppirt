<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=verifikasi-label.xls");
?>

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
<table border="1">
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
                    <?php echo $value->no_sppirt; ?>
                <?php }else{ ?>
                    <?php echo $value->no_sppirt; ?>
                <?php } ?>
                <br>Masa Berlaku: <?php echo date('d-m-Y', strtotime('+5 years', strtotime($value->tgl_pengajuan))); ?>
            </td>
            <td><?php echo $value->nama_produk_pangan; ?></td>
            <td>
                <b>Kategori:</b> <i><?php echo $value->nama_kategori_jenis_pangan; ?></i><br>
                <b>Jenis:</b> <i><?php echo $value->nama_jenis_pangan; ?></i><br>
                <b>Kemasan:</b> <i><?php echo $value->nama_kemasan; ?></i>
            </td>
            <td>
                <b>Provinsi:</b> <i><?php echo $value->nama_prov; ?></i><br>
                <b>Kota/Kab:</b> <i><?php echo $value->nama_kabkot; ?></i>
            </td>
            <td><?php echo $value->nib; ?></td>
            <td><?php echo date('d-m-Y', strtotime($value->tgl_pengajuan)); ?></td>
            <td>
                <?php if($value->status_sinkronisasi=='1'){ ?>
                    <?php echo $value->id_izin; ?>
                     (TERKIRIM OSS)
                <?php }else { ?>
                     (BELUM TERKIRIM OSS)
                <?php } ?>
            <td>
                <div class="d-flex">

                    <?php if ($value->status_verifikasi_label == '0') { ?>
                        Menunggu Perbaikan Pelaku Usaha
                    <?php }else if ($value->status_verifikasi_label == '1') { ?>
                        Sudah Diverifikasi
                    <?php }else if ($value->status_verifikasi_label == '2') { ?>
                        Sudah Diperbaiki oleh Pelaku Usaha<
                    <?php }else{ ?>
                        Menunggu Diverifikasi
                    <?php } ?>
                </div>
            </td>
            <?php } ?>

    </tbody>
</table>
