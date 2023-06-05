<div class="row">
	<div class="col-12 text-right mb-2">
			<button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Pengguna</button>
	</div>
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
			        <table id="dt-menu-user" class="display" width="100%">
    					<thead>
    						<tr>
    							<th>No.</th>
    							<th>Username</th>
    							<th>Role</th>
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
      			<label for="id_role">Role</label>
      			<select class="form-control" id="id_role" name="id_role">
      				<option value="">Pilih</option>
      				<?php foreach ($roles as $role): ?>
      					<option value="<?= $role['id_role'] ?>"><?= $role['role'] ?></option>
      				<?php endforeach ?>
      			</select>
      			<span class="id_role_error text-danger"></span>
      		</div>
      		<div class="form-group">
      			<label for="id_prov">Provinsi</label>
      			<select class="form-control" id="id_prov" name="id_prov">
      				<option value="">Pilih</option>
      				<?php foreach ($provinsi as $prov): ?>
      					<option value="<?= $prov['id_prov'] ?>"><?= $prov['provinsi'] ?></option>
      				<?php endforeach ?>
      			</select>
      			<span class="id_prov_error text-danger"></span>
      		</div>
      		<div class="form-group" id="show-kota">
      			
      		</div>
      		<div class="form-group">
      			<label for="username">Username</label>
      			<input type="hidden" name="id_user" id="id_user">
      			<input type="text" name="username" class="form-control" id="username" placeholder="Nama Kategori BTP">
      			<span class="username_error text-danger"></span>
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
		dt = $('#dt-menu-user').DataTable({
	      //   "processing": true,
	      // "serverSide": true,

	        "processing": true,
	        "serverSide": true,
	        "destroy":true,
	        "ajax": {
	            "url":base_url+"backend/Pengguna/getData",
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
		$('.modal-title').text('Tambah Pengguna')
		$('.text-danger').empty()
		$('.is-invalid').removeClass('is-invalid')
		$('.is-valid').removeClass('is-valid')
	})
	$('#id_prov').change(function(){
	  var id_prov = $(this).val()
	  $.ajax({
	    url:`${base_url}backend/General/getKabKota/${id_prov}`,
	    dataType:'json',
	    success:function(response){
	      var data = response.data;
	      var kabkota = `
	      <label for="id_kota">Kab/Kota</label>
	      <select class="form-control" id="id_kota" name="id_kota">`

	      for (var i = 0; i < data.length; i++) {
	        kabkota += `<option value="${data[i].id_kabkota}">${data[i].kabkota}</option>`;
	      }
	      kabkota += `</select>
	      <span class="id_kota_error text-danger"></span>`;
	      console.log(kabkota)
	      $('#show-kota').html(kabkota);

	    }
	  })
	})
</script>