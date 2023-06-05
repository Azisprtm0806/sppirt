<div class="row">
    <div class="col-12 text-right mb-2">
        <button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Regulasi</button>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt-menu-regulasi" class="display" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kategori Regulasi</th>
                                <th>Judul Regulasi</th>
                                <th>File</th>
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
                        <input type="hidden" name="id_regulasi" id="id_regulasi">
                        <label for="id_kategori">Kategori Regulasi</label>
                        <select class="form-control" name="id_kategori" id="id_kategori">
                            <option selected>Pilih Kategori Regulasi</option>
                                    <?php foreach ($kategoriregulasi as $katreg) {
                                         ?>
                                <option value="<?= $katreg['id_kategori_regulasi']; ?>"><?= $katreg['nama_kategori_regulasi']; ?></option>
                            <?php } ?>
                        </select>
                        <span class="id_kategori_error text-danger"></span>

                    </div>
                    <div class="form-group">
                        <label for="judul_regulasi">Judul Regulasi</label>
                        <input type="text" name="judul_regulasi" class="form-control" id="judul_regulasi" placeholder="Judul Regulasi">
                        <span class="judul_regulasi_error text-danger"></span>
                    </div>
                    <div class="form-group">
      			        <label for="file_regulasi">File</label>
      			        <div id="show_file_regulasi" class="text-center">
      				
      			        </div>
      			        <input type="file" name="file_regulasi" class="form-control" id="file_regulasi" placeholder="File Berita">
      			        <span class="file_regulasi_error text-danger"></span>
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
        dt = $('#dt-menu-regulasi').DataTable({
            // "processing": true,
            // "serverSide": true,

            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax": {
                "url": base_url + "backend/Regulasi/getDataRegulasi",
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
        $('.modal-title').text('Tambah Kategori Regulasi')
        $('.text-danger').empty()
        $('.is-invalid').removeClass('is-invalid')
        $('.is-valid').removeClass('is-valid')
    })


    function ButtonEdit(id) {
        aksi = 'ubah'
        $('#form')[0].reset()

        $('.text-danger').empty()
        $('.is-invalid').removeClass('is-invalid')
        $('.is-valid').removeClass('is-valid')
        $('#modal-form').modal('show')
        $('.modal-title').text('Ubah Regulasi')
        $.ajax({
            url: base_url + 'backend/Regulasi/getDataById/' + id,
            dataType: 'json',
            success: (response) => {
				var data = response.data;
                $('#id_regulasi').val(data.id_regulasi)
                $('#judul_regulasi').val(data.judul_regulasi)
                $('#id_kategori').val(data.id_kategori)
                $(`#show_file_regulasi`).html(`<a href="${base_url}uploads/regulasi/${data.file_regulasi}" target="_BLANK">${data.file_regulasi}</a>`)
			}
        })
    }


    $('.btn-submit').click(function() {
		var formData = new FormData($('#form')[0]);
        $.ajax({
            url: `${base_url}backend/Regulasi/${aksi}regulasi`,
            type: 'POST',
		    data:formData,
		    contentType: false,
		    processData: false,
            dataType:'json',
           success: function(response) {
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
                    url: base_url + 'backend/Regulasi/delete/' + id,
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