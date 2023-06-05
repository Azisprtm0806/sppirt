<?php
  header("Content-type:application/octet-stream/");
  header("Content-Disposition:attachment; filename=rekap-data-pirt.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
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
            <th>No</th>
            <th>NO SPPIRT</th>
            <th>Nama Branding</th>
            <th>Kategori Product Pangan</th>
            <th>Jenis Product Pangan</th>
            <th>Kemasan</th>
            <th>Cara Penyimpanan</th>
            <th>Wilayah</th>
            <th>NIB</th>
            <th>TANGGAL PENGAJUAN</th>
            <th>STATUS OSS</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($datas as $key => $value) : ?>
        <tr>
            <td style="text-align: center;"><?php echo $no++; ?></td>
            <td><?php echo $value->no_sppirt; ?></td>
            <td><?php echo $value->nama_produk_pangan; ?></td>
            <td><?php echo $value->nama_kategori_jenis_pangan; ?></td>
            <td><?php echo $value->nama_jenis_pangan; ?></td>
            <td><?php echo $value->nama_kemasan; ?></td>
            <td><?php echo $value->cara_penyimpanan; ?></td>
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
        <?php endforeach; ?>
    </tbody>
</table>
