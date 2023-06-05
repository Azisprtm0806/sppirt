<style type="text/css">
    .read{
        background-color: #a3a09e8a;
    }

    tbody {
        display:block;
        max-height:500px;
        overflow-y:scroll;
    }
    thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
</style>

<!-- <h2>Halaman ini dipersiapkan untuk grafik dan statistik terkait data SPPIRT</h2> -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body" style="background:#ccc">
                            <p class="card-title text-md-left">
                            <h5>Total Pengajuan SPPIRT</h5>
                            </p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?= $total_pengajuan['pengajuan']; ?></h3>
                                <!-- <i class="fa fa-id-card icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i> -->
                            </div>

                        </div>
                        <a href="<?= base_url('#'); ?>">
                            <div class="card-footer">
                                <span class="pull-left"><i>Data Update: <?=date("h:i:s a"); ?></i></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body" style="background:#690">
                            <p class="card-title text-md-left">
                            <h5>Total PIRT Diterbitkan</h5>
                            </p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?= $total_terbit['pengajuan']; ?></h3>
                                <!-- <i class="fa fa-id-card icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i> -->
                            </div>

                        </div>
                        <a href="<?= base_url('#'); ?>">
                            <div class="card-footer">
                                <span class="pull-left"><i>Data Update: <?=date("h:i:s a"); ?></i></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body" style="background:#f93">
                            <p class="card-title text-md-left">
                            <h5>Total PIRT Ditangguhkan</h5>
                            </p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?= $total_ditangguhkan['pengajuan']; ?></h3>
                                <!-- <i class="fa fa-id-card icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i> -->
                            </div>

                        </div>
                        <a href="<?= base_url('#'); ?>">
                            <div class="card-footer">
                                <span class="pull-left"><i>Data Update: <?=date("h:i:s a"); ?></i></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body" style="background:#f60">
                            <p class="card-title text-md-left">
                            <h5>Total PIRT Ditolak</h5>
                            </p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?= $total_ditolak['pengajuan']; ?></h3>
                                <!-- <i class="fa fa-id-card icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i> -->
                            </div>

                        </div>
                        <a href="<?= base_url('#'); ?>">
                            <div class="card-footer">
                                <span class="pull-left"><i>Data Update: <?=date("h:i:s a"); ?></i></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				<div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body" style="background:#09f">
                            <p class="card-title text-md-left">
                            <h5>Total PIRT Dibatalkan</h5>
                            </p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?= $total_dibatalkan['pengajuan']; ?></h3>
                                <!-- <i class="fa fa-id-card icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i> -->
                            </div>

                        </div>
                        <a href="<?= base_url('#'); ?>">
                            <div class="card-footer">
                                <span class="pull-left"><i>Data Update: <?=date("h:i:s a"); ?></i></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php
                $role = $this->session->userdata('userData')['id_role'];
                if ($role == 2 || $role == 3 || $role == 4) {
            ?>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-xxl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Pemberitahuan Terbaru (<?= count($notifications); ?>)</h4>
                            <div class="card-action">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="btn btn-md nav-link" href="javascript:void(0);" onclick="read('all');">
                                            Read All
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-md nav-link" href="javascript:void(0);" onclick="read('multiple');">
                                            Read Selected
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive recentOrderTable">
                                <table class="table verticle-middle table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                                    <label class="custom-control-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th scope="col">Tipe</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">NIB</th>
                                            <th scope="col">NO SPPIRT</th>
                                            <th scope="col">Waktu</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="scrollable">
                                        <?php
                                            if (!empty($notifications)) {
                                                foreach ($notifications as $key => $value) {
                                                    $last_param = $view_url = '';

                                                    switch ($value['type']) {
                                                        case 'Verifikasi Produk':
                                                            $last_param = $value['id_pengajuan'];
                                                            break;
                                                        case 'Verifikasi Label':
                                                            $last_param = $value['id_pengajuan'];
                                                            break;
                                                        case 'Verifikasi PKP':
                                                            $last_param = $value['nib'];
                                                            break;
                                                        case 'Verifikasi Cara Pembuatan':
                                                            $last_param = $value['nib'];
                                                            break;
                                                        default:
                                                            break;
                                                    }

                                                    if (!empty($last_param)) {
                                                        if ($value['type'] == 'Verifikasi Label' && $role == 2) {
                                                            $slug = 'rekomendasi-label';
                                                        }
                                                        else{
                                                            $slug = gen_slug(strtolower($value['type']));
                                                        }

                                                        $view_url = base_url().'backend/'.$slug.'/verifikasi/'.encrypt_decrypt('encrypt', $last_param);
                                                        $view_url = encrypt_decrypt('encrypt', $view_url);
                                                    }
                                        ?>
                                        <tr class="<?= ($value['read'] == 1)?'read':''; ?>">
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkbox_<?php echo $value['id']; ?>" value="<?php echo $value['id']; ?>">
                                                    <label class="custom-control-label" for="checkbox_<?php echo $value['id']; ?>"></label>
                                                </div>
                                            </td>
                                            <td><?php echo $value['type']; ?></td>
                                            <td><?php echo $value['status']; ?></td>
                                            <td><?php echo $value['keterangan']; ?></td>
                                            <td><?php echo $value['nib']; ?></td>
                                            <td><?php echo $value['no_sppirt']; ?></td>
                                            <td><?php echo date("d-m-Y H:i:s", strtotime($value['created_at'])); ?></td>
                                            <td>
                                                <?php
                                                    if ($value['read'] == 0) {
                                                ?>
                                                <a href="javascript:void(0);" onclick="read_single(<?php echo $value['id']; ?>);" class="btn btn-primary btn-xs mr-2">Tandai Sudah Dibaca</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if (($role != 2 || $value['type'] == 'Verifikasi Label') && !empty($view_url)) {
                                                ?>
                                                <a href="javascript:void(0)" onclick='read_single(<?php echo $value['id']; ?>, "<?php echo $view_url; ?>");' title="Lihat Detail" class="btn btn-primary btn-xs mr-2 <?= (empty($view_url))?'disabled':''; ?>"><i class="fa fa-eye fa-lg"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php   
                }
            ?>
        </div>
    </div>
</section>

<script type="text/javascript">
    $("#checkAll").change(function() {
        $("td input:checkbox").prop('checked', $(this).prop("checked"));
    });

    function read(type) {
        var selected = [];
        if (type == 'all') {

        }
        else if(type == 'multiple'){
            $('td input[type=checkbox]').each(function() {
                if ($(this).is(":checked")) {
                    selected.push($(this).val());
                }
            });

            if (selected.length == 0) {
                return swal({
                    type: 'error',
                    title: 'Oops...',
                    text: "Silakan pilih minimal 1 pesan untuk ditandai sudah dibaca!",
                });
            }
        }

        $.ajax({
            url:`${base_url}backend/Dashboard/read_notifications`,
            type:"post",
            dataType:'json',
            data: {type: type, ids : selected},
            success:function(response){
                if (response.status) {
                    swal({
                        type: 'success',
                        title: 'Success',
                        text: response.text
                    }).then(() => {
                        location.reload();
                    });
                }else{
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: response.text
                    }).then(() => {
                        location.reload();
                    });
                }
            }
        })
    }

    function read_single(id, cb = "") {
        console.log(cb);
        var selected = [];
        selected.push(id);
        $.ajax({
            url:`${base_url}backend/Dashboard/read_notifications`,
            type:"post",
            dataType:'json',
            data: {type: 'single', ids : selected, cb: cb},
            success:function(response){
                if (response.status) {
                    swal({
                        type: 'success',
                        title: 'Success',
                        text: response.text
                    }).then(() => {
                        if (response.callback) {
                            window.open(response.callback);
                        }
                        else{
                            location.href = response.callback;
                        }
                    });
                }else{
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: response.text
                    }).then(() => {
                        if (response.callback) {
                            window.open(response.callback);
                        }
                        else{
                            location.href = response.callback;
                        }
                    });
                }
            }
        })
    }
</script>