<?php
  header("Content-type:application/octet-stream/");
  header("Content-Disposition:attachment; filename=permohonan-ditolak.xls");
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
<h3>Permohonan Pembatalan Ditolak</h3>
<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>No SPPIRT</th>
            <th>Nama Branding</th>
            <th>Kategori Pangan</th>
            <th>Jenis Pangan</th>
            <th>Kemasan</th>
            <th>Wilayah</th>
            <th>NIB</th>
            <th>Alasan Pembatalan</th>
            <th>Tanggal Pengajuan</th>
    <tbody>
      <?php $no=1; foreach($datas as $key => $value) : ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?php echo $value->no_sppirt; ?></td>
        <td><?php echo $value->nama_produk_pangan; ?></td>
        <td><?php echo $value->nama_kategori_jenis_pangan; ?></td>
        <td><?php echo $value->nama_jenis_pangan; ?></td>
        <td><?php echo $value->nama_kemasan; ?></td>
        <td>
            <b>Provinsi:</b> <i><?php echo $value->nama_prov; ?></i><br>
            <b>Kota/Kab:</b> <i><?php echo $value->nama_kabkot; ?></i><br>
        </td>
        <td><?php echo $value->nib; ?></td>
        <td><?php echo $value->alasan_pembatalan; ?></td>
        <td><?php echo date('d-m-Y', strtotime($value->tgl_pengajuan)); ?></td>
      </tr>

      <?php endforeach; ?>
    </tbody>
</table>
