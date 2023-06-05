<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt-menu-jenis_kemasan" class="display" width="100%">
                        <thead>
                            <tr> 
                                <th>No.</th>
                                <th>Nama Usaha</th>
                                <th>Nama Produk Pangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($datas as $key => $value) : ?>
                          <tr>
                            <td><?= $no++ ?></td>
                            <td><?php echo $value->nama_usaha; ?></td>
                            <td><?php echo $value->nama_produk_pangan; ?></td>
                          </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>