<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rekap-pelaku-usaha.xls");
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
            <th>Provinsi</th>
            <th>Kabupaten/Kota</th>
            <th>NIB</th>
            <th>Nama Pelaku Usaha</th>
            <th>Nomor Urut Pelaku Usaha</th>
            <th>Alamat Usaha</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Tanggal Daftar</th>
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
            <td><?php echo $value->no_urut_pelaku_usaha; ?></td>
            <td><?php echo $value->alamat_usaha; ?></td>
            <td><?php echo $value->no_telp; ?></td>
            <td><?php echo $value->email; ?></td>
            <td><?php echo date('d M Y',strtotime($value->created_at)); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
