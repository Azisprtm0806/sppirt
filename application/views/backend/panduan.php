<div class="row">
    <div class="col-12 text-right mb-2">
        <button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Panduan</button>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt-menu-panduan" class="display" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kategori Panduan</th>
                                <th>Judul Panduan</th>
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
                        <input type="hidden" name="id_panduan" id="id_panduan">
                        <label for="id_kategori">Kategori Panduan</label>
                        <select class="form-control" name="id_kategori" id="id_kategori">
                            <option selected>Pilih Kategori Panduan</option>
                                    <?php foreach ($kategoripanduan as $katpan) {
                                         ?>
                                <option value="<?= $katpan['id_kategori_panduan']; ?>"><?= $katpan['nama_kategori_panduan']; ?></option>
                            <?php } ?>
                        </select>
                        <span class="id_kategori_error text-danger"></span>

                    </div>
                    <div class="form-group">
                        <label for="judul">Judul Panduan</label>
                        <input type="text" name="judul" class="form-control" id="judul" placeholder="Judul Panduan">
                        <span class="judul_error text-danger"></span>
                    </div>
                    <div class="form-group">
      			        <label for="file">File</label>
      			        <div id="show_file" class="text-center">
      				
      			        </div>
      			        <input type="file" name="file" class="form-control" id="file" placeholder="File Berita">
      			        <span class="file_error text-danger"></span>
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
        dt = $('#dt-menu-panduan').DataTable({
            // "processing": true,
            // "serverSide": true,

            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax": {
                "url": base_url + "backend/Panduan/getDataPanduan",
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
        $('.modal-title').text('Tambah Kategori Panduan')
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
        $('.modal-title').text('Ubah Panduan')
        $.ajax({
            url: base_url + 'backend/Panduan/getDataById/' + id,
            dataType: 'json',
            success: (response) => {
				$.each(response.data, function(key, value) {
					if (key == 'id_kategori') {
						$('#' + key).val(value).trigger('change')
                  	} else {
						$('#' + key).val(value)
					}
                    $(`#show_file`).html(`<a href="${base_url}uploads/panduan/${response.data.file}" >${response.data.file}</a>`)
				})
			}
        })
    }


    $('.btn-submit').click(function() {
		var formData = new FormData($('#form')[0]);
        $.ajax({
            url: `${base_url}backend/Panduan/${aksi}panduan`,
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
                    url: base_url + 'backend/Panduan/delete/' + id,
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