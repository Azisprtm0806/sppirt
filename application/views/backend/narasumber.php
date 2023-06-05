<div class="row">
    <div class="col-12 text-right mb-2">
        <button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Jenis Pangan</button>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt-narasumber" class="display" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Narasumber</th>
                                <th>NIP</th>
                                <th>NIK</th>
                                <th>Instansi</th>
                                <th>Nomor Telpon</th>
                                <th>Email</th>
                                <th>Nama Pelatihan</th>
                                <th>Tahun Pelatihan</th>
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
                        <label for="nama_narasumber">Nama Narasumber</label>
                        <input type="text" name="nama_narasumber" class="form-control" id="nama_narasumber" placeholder="Nama Narasumber">
                        <span class="nama_narasumber_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="NIP">NIP</label>
                        <input type="text" onkeypress="return isNumber(event)" name="NIP" class="form-control" id="NIP" placeholder="NIP">
                        <span class="NIP_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="NIK">NIK</label>
                        <input type="text" onkeypress="return isNumber(event)" name="NIK" class="form-control" id="NIK" placeholder="NIK">
                        <span class="NIK_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="nama_instansi">Nama Instansi</label>
                        <select class="form-control" id="nama_instansi" name="nama_instansi">
                            <option value="">Pilih</option>
                            <?php foreach ($instansi as $inst) : ?>
                                <option value="<?= $inst['id_instansi'] ?>"><?= $inst['nama_instansi'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <span class="nama_instansi_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="nama_pelatihan">Pelatihan Yang Pernah Diikuti</label>
                        <select class="form-control" id="nama_pelatihan" name="nama_pelatihan">
                            <option value="">Pilih</option>
                            <?php foreach ($pelatihan as $plt) : ?>
                                <option value="<?= $plt['id_pelatihan'] ?>"><?= $plt['nama_pelatihan'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <span class="id_kategori_jenis_pangan_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="tahun_pelatihan">Tahun Pelatihan</label>
                        <input type="text" name="tahun_pelatihan" class="form-control" id="tahun_pelatihan" placeholder="Tahun Pelatihan">
                        <span class="tahun_pelatihan_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                        <span class="email_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">Nomor Telepon</label>
                        <input type="text" name="no_telp" class="form-control" id="no_telp" placeholder="Nomor Telepon">
                        <span class="noTtelp_error text-danger"></span>
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
        dt = $('#dt-narasumber').DataTable({
            //   "processing": true,
            // "serverSide": true,

            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax": {
                "url": base_url + "backend/Narasumber/getDataNarasumber",
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
    $('#btn-tambah').click(function() {
        aksi = 'tambah';
        $('#form')[0].reset()
        $('#modal-form').modal('show')
        $('.modal-title').text('Tambah Narasumber')
        $('.text-danger').empty()
        $('.is-invalid').removeClass('is-invalid')
        $('.is-valid').removeClass('is-valid')
    })


    function ButtonEdit(id) {
        aksi = 'ubah'
        // $('#form')[0].reset()

        $('.text-danger').empty()
        $('.is-invalid').removeClass('is-invalid')
        $('.is-valid').removeClass('is-valid')
        $('#modal-form').modal('show')
        $('.modal-title').text('Ubah Narasumber')
        $.ajax({
            url: base_url + 'backend/Narasumber/getDataById/' + id,
            dataType: 'json',
            success: (response) => {
                $.each(response.data, function(key, value) {
                    if (key == 'id_kategori_jenis_pangan') {
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
            url: base_url + 'backend/Narasumber/' + aksi + 'narasumber',
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
                    url: base_url + 'backend/Narasumber/delete/' + id,
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
	function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        if (evt.which == 32){
            return false;
        }
        return true;
    }
</script>