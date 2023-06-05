<div class="row">
    <div class="col-12 text-right mb-2">
        <button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Proses Produksi</button>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt-menu-proses_produksi" class="display" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Proses Produksi</th>
                                <th>Tanggal Dibuat</th>
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
                        <label for="nama_proses_produksi">Nama Proses Produksi</label>
                        <input type="hidden" name="id_proses_produksi" id="id_proses_produksi">
                        <input type="text" name="nama_proses_produksi" class="form-control" id="nama_proses_produksi" placeholder="Nama Proses Produksi">
                        <span class="nama_proses_produksi_error text-danger"></span>
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
<script type="text/javascript">
    $(document).ready(function() {
        loadData()
    })

    function loadData() {
        dt = $('#dt-menu-proses_produksi').DataTable({
            // "processing": true,
            // "serverSide": true,

            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax": {
                "url": base_url + "backend/ProsesProduksi/getDataProsesProduksi",
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
        $('.modal-title').text('Tambah Proses Produksi')
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
        $('.modal-title').text('Ubah Jenis Pangan')
        $.ajax({
            url: base_url + 'backend/ProsesProduksi/getDataById/' + id,
            dataType: 'json',
            success: (response) => {
                $.each(response.data, function(key, value) {
                    $('#' + key).val(value)
                })
            }
        })
    }


    $('.btn-submit').click(function() {
        $.ajax({
            url: base_url + 'backend/ProsesProduksi/' + aksi + 'prosesproduksi',
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
                    url: base_url + 'backend/ProsesProduksi/delete/' + id,
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