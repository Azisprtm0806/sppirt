<!-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> -->
<link href="<?= base_url('assets/backend/') ?>public/vendor/summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/backend/') ?>public/vendor/summernote/js/summernote.min.js" type="text/javascript"></script>
<link href="<?= base_url('assets/backend/') ?>public/vendor/pickadate/themes/default.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/backend/') ?>public/vendor/pickadate/themes/default.date.css" rel="stylesheet" type="text/css" />
<div class="row">
	<div class="col-12 text-right mb-2">
		<button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Berita</button>
	</div>
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="dt-menu-berita" class="display" width="100%">
						<thead>
							<tr>
								<th width="1%">No.</th>
								<th width="1%">Gambar</th>
								<th>Judul Berita</th>
								<th width="15%">Tanggal Berita</th>
								<th width="10%">Aksi</th>
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
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
				</button>
			</div>
			<div class="modal-body" style="max-height: 65vh; overflow-y: auto;">
				<form id="form">
					<div class="form-group">
						<label for="judul_berita">Judul Berita</label>
						<input type="hidden" name="id_berita" id="id_berita">
						<input type="hidden" name="slug_berita" id="slug_berita">
						<input type="text" name="judul_berita" class="form-control" id="judul_berita" placeholder="Judul Berita">
						<span class="judul_berita_error text-danger"></span>
					</div>
					<div class="form-group">
						<label for="deskripsi_berita">Deskripsi Berita</label>
						<textarea name="deskripsi_berita" class="form-control" id="deskripsi_berita"></textarea>
						<!-- <input type="text" name="deskripsi_berita" class="form-control summernote" id="deskripsi_berita" placeholder="Deskripsi Berita"> -->
						<span class="deskripsi_berita_error text-danger"></span>
					</div>
					<div class="form-group">
						<label for="tgl_berita">Tanggal Berita</label>
						<input type="text" name="tgl_berita" class="form-control datepicker-default" id="tgl_berita">
						<span class="tgl_berita_error text-danger"></span>
					</div>
					<div class="form-group">
						<label for="gambar_berita">Gambar Berita</label>
						<div id="show_gambar_berita" class="text-center">

						</div>
						<input type="file" name="gambar_berita" class="form-control" id="gambar_berita" placeholder="File Berita">
						<span class="gambar_berita_error text-danger"></span>
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
<script src="<?= base_url('assets/backend/') ?>public/vendor/pickadate/picker.js" type="text/javascript"></script>
<script src="<?= base_url('assets/backend/') ?>public/vendor/pickadate/picker.date.js" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		loadData()
		$('.datepicker-default').pickadate({
			format: 'dd mmmm yyyy',
			formatSubmit: 'yyyy/mm/dd',
			hiddenName: true
		});
		$("#deskripsi_berita").summernote({
			height: '200px',
			toolbar: [
				// ['headline', ['style']],
				['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
				['textsize', ['fontsize']],
				['alignment', ['ul', 'ol', 'paragraph', 'lineheight']]
			]
		})
	})

	function loadData() {
		dt = $('#dt-menu-berita').DataTable({
			//   "processing": true,
			// "serverSide": true,

			"processing": true,
			"serverSide": true,
			"destroy": true,
			"ajax": {
				"url": base_url + "backend/Berita/getData",
				"type": "POST",
			},
			"columnDefs": [{
					targets: [-1, 1, 0],
					orderable: false
				},
				{
					targets: [-1, 1, 0],
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
		$('.modal-title').text('Tambah Berita')
		$('.text-danger').empty()
		$('.is-invalid').removeClass('is-invalid')
		$('.is-valid').removeClass('is-valid')
	})


	$('.btn-submit').click(function() {
		var formData = new FormData($('#form')[0]);
		$.ajax({
			url: `${base_url}backend/Berita/${aksi}Berita`,
			type: 'post',
			data: formData,
			contentType: false,
			processData: false,
			dataType: 'json',
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


	function ButtonEdit(slug_berita) {
		aksi = 'ubah'
		// $('#form')[0].reset()

		$('.text-danger').empty()
		$('.is-invalid').removeClass('is-invalid')
		$('.is-valid').removeClass('is-valid')
		$('#modal-form').modal('show')
		$('.modal-title').text('Ubah Berita')
		$.ajax({
			url: base_url + 'backend/Berita/getDataById/' + slug_berita,
			dataType: 'json',
			success: function(response) {
				var data = response.data;
				$('#id_berita').val(data.id_berita)
				$('#slug_berita').val(data.slug_berita)
				$('#judul_berita').val(data.judul_berita)
				$('#deskripsi_berita').summernote('code', data.deskripsi_berita)
				var picker = $('#tgl_berita').pickadate('picker');
				picker.set('select', data.tgl_berita);
				$('#show_gambar_berita').html(`
					              <img src="${base_url}uploads/berita/${data.gambar_berita}" width="25%" height="25%"/>`)
			}
		})
	}

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
					url: base_url + 'backend/Berita/delete/' + id,
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