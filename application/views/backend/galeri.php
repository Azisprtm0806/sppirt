<div class="row">
    <div class="col-12 text-right mb-2">
        <button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Galeri</button>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt-menu-galeri" class="display" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul Galeri</th>
                                <th>Deskripsi Galeri</th>
                                <th>Gambar Galeri</th>
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
                        <label for="judul_galeri">Judul Galeri</label>
                        <input type="hidden" name="id_galeri" id="id_galeri">
                        <input type="text" name="judul_galeri" class="form-control" id="judul_galeri" placeholder="Judul Galeri">
                        <span class="judul_galeri_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="deksripsi_galeri">Deskripsi Galeri</label>
                        <textarea name="deskripsi_galeri" class="form-control" id="deskripsi_galeri" placeholder="Deskripsi Galeri"></textarea>
                        <span class="deksripsi_galeri_error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="gambar_galeri">Gambar Galeri</label>
                        <div id="show_gambar_galeri" class="text-center">

                        </div>
                        <input type="file" name="gambar_galeri" class="form-control" id="gambar_galeri" placeholder="File slider">
                        <span class="gambar_galeri_error text-danger"></span>
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
        dt = $('#dt-menu-galeri').DataTable({
            // "processing": true,
            // "serverSide": true,

            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax": {
                "url": base_url + "backend/Galeri/getDataGaleri",
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
        $('.modal-title').text('Tambah Galeri')
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
        $('.modal-title').text('Ubah Galeri')
        $.ajax({
            url: base_url + 'backend/Galeri/getDataById/' + id,
            dataType: 'json',
            success: function(response) {
                var data = response.data;
                $('#id_galeri').val(data.id_galeri)
                $('#judul_galeri').val(data.judul_galeri)
                $('#deskripsi_galeri').text(data.deskripsi_galeri)
                $('#show_gambar_galeri').html(`
					              <img src="${base_url}uploads/galeri/${data.gambar_galeri}" width="25%" height="25%"/>`)

            }
        })
    }


    $('.btn-submit').click(function() {
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: base_url + 'backend/Galeri/' + aksi + 'galeri',
            dataType: 'json',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
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
                    url: base_url + 'backend/Galeri/delete/' + id,
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