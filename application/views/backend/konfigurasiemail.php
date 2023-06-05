<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt-menu-konfigurasiemail" class="display" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Protokol</th>
                                <th>Host</th>
                                <th>Auth</th>
                                <th>User</th>
                                <th>Port</th>
                                <th>Timeout</th>
                                <th>Crypto</th>
                                <th>Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">
                <form id="form">
                    <div class="form-group">
                        <label for="protocol">Protokol</label>
                        <input type="hidden" name="id_konfigurasi_email" id="id_konfigurasi_email">
                        <input type="text" name="protocol" class="form-control" id="protocol" placeholder="Protokol">
                        <span class="protocol_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="host">Host</label>
                        <input type="text" name="host" class="form-control" id="host" placeholder="Host">
                        <span class="host_error text-danger"></span>
                    </div>
                    <!-- <div class="form-group">
                        <select class="form-control" id="id_kategori_btp" name="id_kategori_btp">
                            <option value="">Pilih</option>
                            <?php foreach ($kategoribtp as $katbtp) : ?>
                                <option value="<?= $katbtp['id_kategori_btp'] ?>"><?= $katbtp['nama_kategori'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <span class="id_kategori_btp_error text-danger"></span>
                    </div> -->
                    <div class="form-group">
                        <label for="user">User</label>
                        <input type="text" name="user" class="form-control" id="user" placeholder="User">
                        <span class="user_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        <span class="password_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="text" name="port" class="form-control" id="port" placeholder="Port">
                        <span class="port_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="timeout">Timeout</label>
                        <input type="number" name="timeout" class="form-control" id="timeout" placeholder="Timeout">
                        <span class="timeout_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="crypto">Crypto</label>
                        <input type="text" name="crypto" class="form-control" id="crypto" placeholder="Crypto">
                        <span class="crypto_error text-danger"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-submit">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        loadData()
    })

    function loadData() {
        dt = $('#dt-menu-konfigurasiemail').DataTable({
            //   "processing": true,
            // "serverSide": true,

            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax": {
                "url": base_url + "backend/KonfigurasiEmail/getDataKonfigurasiEmail",
                "type": "POST",
            },
            "columnDefs": [{
                    targets: [-1, 0],
                    orderable: false
                },
                {
                    targets: [-1, 0],
                    class: 'text-nowrap text-center'
                }
            ],
            "order": [],
        });
    }

    function ButtonEdit(id) {
        aksi = 'ubah'
        // $('#form')[0].reset()
        $('.text-danger').empty()
        $('.is-invalid').removeClass('is-invalid')
        $('.is-valid').removeClass('is-valid')
        $('#modal-form').modal('show')
        $('.modal-title').text('Ubah Konfigurasi Email')
        $.ajax({
            url: base_url + 'backend/KonfigurasiEmail/getDataById/' + id,
            dataType: 'json',
            success: (response) => {
                $.each(response.data, function(key, value) {
                    if (key == 'id_konfigurasi_email') {
                        $('#' + key).val(value).trigger('change')

                    } else {
                        $('#' + key).val(value)
                    }
                })
            }
        })
    }


    $('.btn-submit').click(function() {
        $.ajax({
            url: base_url + 'backend/KonfigurasiEmail/' + aksi + 'konfigurasiemail',
            dataType: 'json',
            type: 'POST',
            data: $('#form').serialize(),
            success: (response) => {

                if (response.status) {
                    sukses(response.alert);
                    $('#modal-form').modal('hide')
                    dt.ajax.reload()
                } else {
                    var error = response.error
                    $.each(error, function(key, value) {

                        $('.' + key + '_error').html(value.length > 0 ? `<i class="fa fa-exclamation"> ${value}</i>` : value)
                        $('#' + key).removeClass('is-invalid').addClass(value.length > 0 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
                    })
                }

            }
        })
    })

    function ButtonDelete(id) {
        swal({
            title: "Yakin ingin menghapus data?",
            text: "Data yang sudah dihapus tidak bisa dikembalikan!!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!!",
            closeOnConfirm: !1
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: base_url + 'backend/Btp/delete/' + id,
                    type: 'post',
                    dataType: 'json',
                    success: (response) => {
                        sukses(response.alert);
                        dt.ajax.reload()
                    }
                })
            }
        })
    }
</script>