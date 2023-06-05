<div class="row">
	<div class="col-12 text-right mb-2">
			<button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Role</button>
	</div>
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
			        <table id="dt-menu-role" class="display" width="100%">
    					<thead>
    						<tr>
    							<th>No.</th>
    							<th>Role</th>
    							<th>Deskripsi</th>
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
      			<label for="role">Nama Role</label>
      			<input type="hidden" name="id_role" id="id_role">
      			<input type="text" name="role" class="form-control" id="role" placeholder="Nama Role">
      			<span class="role_error text-danger"></span>
      		</div>
      		<div class="form-group">
      			<label for="deskripsi">Deskripsi Role</label>
      			<input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi Role">
      			<span class="deskripsi_error text-danger"></span>
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


<div class="modal fade" id="modal-akses">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hak Akses</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
      </div>
    <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">
      	<form id="form-akses">
      		<input type="hidden" id="id_role" name="id_role">
      		<label>
      		    <input type="checkbox" id="select_all"> 
      		    <span>Select All</span>
      		</label>
      		<hr size="1">
      		<div id="role-akses"></div>
      	</form>
  	</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-submit-akses">Submit</button>
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
		dt = $('#dt-menu-role').DataTable({
	      //   "processing": true,
	      // "serverSide": true,

	        "processing": true,
	        "serverSide": true,
	        "destroy":true,
	        "ajax": {
	            "url":base_url+"backend/Role/getData",
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

	$('#btn-tambah').click(function(){
		aksi = 'tambah';
		$('#form')[0].reset()
		$('#modal-form').modal('show')
		$('.modal-title').text('Tambah Role')
		$('.text-danger').empty()
		$('.is-invalid').removeClass('is-invalid')
		$('.is-valid').removeClass('is-valid')
	})


	function ButtonEdit(id)
	{
		aksi = 'ubah'
		// $('#form')[0].reset()

		$('.text-danger').empty()
		$('.is-invalid').removeClass('is-invalid')
		$('.is-valid').removeClass('is-valid')
		$('#modal-form').modal('show')
		$('.modal-title').text('Ubah Role')
		$.ajax({
			url:base_url+'backend/Role/getDataById/'+id,
			dataType:'json',
			success: (response) => {
				$.each(response.data, function(key, value) {
					$('#'+key).val(value)
				})
			}
		})
	}


	$('.btn-submit').click(function(){
		$.ajax({
			url:base_url+'backend/Role/'+aksi+'Role',
			dataType:'json',
			type:'POST',
			data:$('#form').serialize(),
			success: (response) =>{

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
	    			url:base_url+'backend/Role/delete/'+id,
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

function ButtonAccess(id)
  {
    $('#modal-akses').modal('show');
    $.ajax({
        url: base_url+'backend/Role/akses/'+id,
        type: "get",
        dataType: "html",
        success: function(response)
        {
            $("input[name='id_role']").val(id);
            $("#role-akses").html(response);
        }
    });
  }

  $("#select_all").click(function(){
  	console.log($(this).is(':checked'));
    if($(this).is(':checked')==true)
    {
      $("#role-akses input[type='checkbox']").attr('checked',true);
    }
    else
    {
      $("#role-akses input[type='checkbox']").attr('checked',false);
    }
  })

  $('.btn-submit-akses').click(function(){
  	$.ajax({
  		url:base_url+'backend/Role/saveAkses',
  		dataType:'json',
  		type:'POST',
  		data:$('#form-akses').serialize(),
  		success: (response) =>{
  			if (response.success) {
  				sukses('Diperbarui');
  				$('#modal-akses').modal('hide')
  				dt.ajax.reload()
  			}else{
  				gagal('Diperbarui, Silahkan Hubungi Administrator');
  			}

  		}
  	})
  })
</script>