<div class="row">
	<div class="col-12 text-right mb-2">
			<button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Testimoni</button>
	</div>
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
			        <table id="dt-menu-testimoni" class="display" width="100%">
    					<thead>
    						<tr>
    							<th>No.</th>
    							<th>Foto</th>
    							<th>Nama</th>
    							<th>Komentar</th>
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
      			<label for="nama_testimoni">Nama</label>
      			<input type="hidden" name="id_testimoni" id="id_testimoni">
      			<input type="text" name="nama_testimoni" class="form-control" id="nama_testimoni" placeholder="Nama Pelaku Usaha">
      			<span class="nama_testimoni_error text-danger"></span>
      		</div>
      		<div class="form-group">
      			<label for="komentar_testimoni">Komentar</label>
      			<textarea name="komentar_testimoni" id="komentar_testimoni" class="form-control"></textarea>
      			<span class="komentar_testimoni_error text-danger"></span>
      		</div>
      		<div class="form-group">
		        <label for="foto_testimoni">Foto</label>
		        <div id="show_foto_testimoni" class="text-center"></div>
		        <input type="file" name="foto_testimoni" class="form-control" id="foto_testimoni" placeholder="File Berita">
		        <span class="foto_testimoni_error text-danger"></span>
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
	$(document).ready(function(){
		loadData()
	})
	function loadData()
	{
		dt = $('#dt-menu-testimoni').DataTable({
	      //   "processing": true,
	      // "serverSide": true,

	        "processing": true,
	        "serverSide": true,
	        "destroy":true,
	        "ajax": {
	            "url":base_url+"backend/Testimoni/getData",
	            "type": "POST",
	        },
	        "columnDefs": [
	        {
	            targets : [-1,0],
	            orderable: false
	        },
	        {
	            targets : [-1,0],
	            class: 'text-nowrap text-center'
	        }
	        ],
	        "order" : [],
	      });
	}
	    $('#btn-tambah').click(function() {
	        aksi = 'tambah';
	        $('#form')[0].reset()
	        $('#show_foto_testimoni').html('')
	        $('#komentar_testimoni').text('')
	        $('#modal-form').modal('show')
	        $('.modal-title').text('Tambah Testimoni')
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
	        $('.modal-title').text('Ubah Testimoni')
	        $.ajax({
	            url: base_url + 'backend/Testimoni/getDataById/' + id,
	            dataType: 'json',
	            success: (response) => {
	            	var data = response.data
					$('#komentar_testimoni').text(data.komentar_testimoni)
					$('#id_testimoni').val(data.id_testimoni)
					$('#nama_testimoni').val(data.nama_testimoni)
					$('#show_foto_testimoni').html(`
						              <img src="${base_url}uploads/testimoni/${data.foto_testimoni}" width="25%" height="25%"/>`)
				}
	        })
	    }


	    $('.btn-submit').click(function() {
			var formData = new FormData($('#form')[0]);
	        $.ajax({
	            url: `${base_url}backend/Testimoni/${aksi}Testimoni`,
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
	                    url: base_url + 'backend/Testimoni/delete/' + id,
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