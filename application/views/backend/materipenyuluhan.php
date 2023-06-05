<div class="row">
	<div class="col-12 text-right mb-2">
			<button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Materi Penyuluhan</button>
	</div>
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
			        <table id="dt-menu-materi" class="display" width="100%">
    					<thead>
    						<tr>
    							<th width="1%">No.</th>
    							<th>Nama Materi</th>
    							<th width="15%">Status</th>
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
      			<label for="nama_materi">Nama Materi</label>
      			<input type="hidden" name="id_penyuluhan" id="id_penyuluhan">
      			<input type="text" name="nama_materi" class="form-control" id="nama_materi" placeholder="Nama Materi">
      			<span class="nama_materi_error text-danger"></span>
      		</div>
      		<div class="form-group">
      			<label for="status_materi">Status Materi</label>
      			<select name="status_materi" id="status_materi" class="form-control">
      				<option value="aktif">Aktif</option>
      				<option value="non aktif">Non Aktif</option>
      			</select>
      			<!-- <input type="text" name="status_materi" class="form-control" id="status_materi" placeholder="Status Materi"> -->
      			<span class="status_materi_error text-danger"></span>
      		</div>
      		<div class="form-group">
      			<label for="file">File Materi</label>
      			<div id="show_file" class="text-center">
      				
      			</div>
      			<input type="file" name="file" class="form-control" id="file" placeholder="File Materi">
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


<script>
	$(document).ready(function(){
		loadData()
	})
	function loadData()
	{
		dt = $('#dt-menu-materi').DataTable({
	      //   "processing": true,
	      // "serverSide": true,

	        "processing": true,
	        "serverSide": true,
	        "destroy":true,
	        "ajax": {
	            "url":base_url+"backend/MateriPenyuluhan/getData",
	            "type": "POST",
	        },
	        "columnDefs": [
	        {
	            targets : [-1,1,0],
	            orderable: false
	        },
	        {
	            targets : [-1,1,0],
	            class: 'text-nowrap text-center'
	        }
	        ],
	        "order" : [],
	      });
	}


	$('#btn-tambah').click(function(){
		aksi = 'tambah';
		$('#form')[0].reset()
		$('#modal-form').modal('show')
		$('.modal-title').text('Tambah Materi Penyuluhan')
		$('.text-danger').empty()
		$('.is-invalid').removeClass('is-invalid')
		$('.is-valid').removeClass('is-valid')
	})


	$('.btn-submit').click(function(){
		var formData = new FormData($('#form')[0]);
		$.ajax({
		    url:`${base_url}backend/MateriPenyuluhan/${aksi}MateriPenyuluhan`,
		    type:'post',
		    data:formData,
		    contentType: false,
		    processData: false,
		    dataType:'json',
		    success:function(response){
		        if (response.status) {
					sukses(response.alert);
					$('#modal-form').modal('hide')
					dt.ajax.reload()
				}else{
					var error = response.error
					$.each(error, function(key, value) {
							$('.' + key + '_error').html(value.length > 0 ? `<i class="fa fa-exclamation"> ${value}</i>` : value)
							$('#' + key).removeClass('is-invalid').addClass(value.length > 0 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
						})
				}
		    }
		})
	})


	function ButtonEdit(slug_berita)
	{
		aksi = 'ubah'
		// $('#form')[0].reset()

		$('.text-danger').empty()
		$('.is-invalid').removeClass('is-invalid')
		$('.is-valid').removeClass('is-valid')
		$('#modal-form').modal('show')
		$('.modal-title').text('Ubah Materi Penyuluhan')
		$.ajax({
			url:base_url+'backend/MateriPenyuluhan/getDataById/'+slug_berita,
			dataType:'json',
			success: function(response) {
				var data = response.data;
				$('#id_penyuluhan').val(data.id_penyuluhan)
				$('#nama_materi').val(data.nama_materi)
				$('#show_file').html(`
					<a href="${base_url}uploads/materipenyuluhan/${data.file}" title="Materi ${data.nama_materi}"><i class="fa fa-file"></i> ${data.nama_materi}</a>`)
			}
		})
	}

	function ButtonDelete(id)
	{
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
	    			url:base_url+'backend/MateriPenyuluhan/delete/'+id,
	    			type:'post',
	    			dataType:'json',
	    			success: (response) => {
	    				sukses(response.alert);
							dt.ajax.reload()
	    			}
	    		})
			}
		})
	}
</script>