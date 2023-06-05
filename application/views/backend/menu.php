<div class="row">
	<div class="col-12 text-right mb-2">
			<button type="button" id="btn-tambah" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Menu</button>
	</div>
	<div class="col-12">

		<div class="card">
				<ul class="nav nav-tabs" role="tablist">
				  <li class="nav-item">
				    <a class="nav-link active" data-toggle="tab" onClick="loadMenu('backend')" href="#backend"></i> BackEnd</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" data-toggle="tab" onClick="loadMenu('frontend')" href="#frontend"></i> FrontEnd</a>
				  </li>
				</ul>
			<div class="card-body">
				  <div class="tab-content">
				    <div class="tab-pane fade show active" id="backend" role="tabpanel">
				      <div class="pt-4 table-responsive">
				        <table id="dt-menu-backend" class="display" width="100%">
        					<thead>
        						<tr>
        							<th>No.</th>
        							<th>Parent</th>
        							<th>Label</th>
        							<th>Link</th>
        							<th>Icon</th>
        							<th>Is Parent</th>
        							<th>Action</th>
        						</tr>
        					</thead>
        					<tbody>
        					</tbody>
        				</table>
				      </div>
				    </div>
				    <div class="tab-pane fade" id="frontend">
				      <div class="pt-4 table-responsive">
					       <table id="dt-menu-frontend" class="display" width="100%">
					       	<thead>
					       		<tr>
					       			<th>No.</th>
					       			<th>Parent</th>
					       			<th>Label</th>
					       			<th>Link</th>
					       			<th>Icon</th>
					       			<th>Is Parent</th>
					       			<th>Action</th>
					       		</tr>
					       	</thead>
					       	<tbody>
					       	</tbody>
					       </table>
				      </div>
				    </div>
				  </div>
				<!-- </div> -->
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
      			<label for="menu_parent">Is Parent?</label>
      			<input type="hidden" name="id_menu" id="id_menu">
      			<input type="hidden" name="tipe" id="tipe">
      			<div id="show_menu_parent">
      				
      			</div>
      			<!-- <select name="menu_parent" id="menu_parent" class="form-control">
      			</select> -->
      			<span class="menu_parent_error text-danger"></span>
      		</div>
      		<div class="form-group">
      			<label for="nama_menu">Nama Menu</label>
      			<input type="text" name="nama_menu" class="form-control" id="nama_menu" placeholder="Nama Menu">
      			<span class="nama_menu_error text-danger"></span>
      		</div>
      		<div class="form-group">
      			<label for="menu_flag_link">Memiliki Link?</label>
      				<div id="show_menu_flag_link">
      					
      				</div>
      				<span class="menu_flag_link_error text-danger"></span>
      		</div>
      		<div class="form-group" id="show-link">
      			<label for="menu_url">Menu URL</label>
      			<div class="input-group">
      				<span class="input-group-text" id="basic-addon3"><?= base_url() ?></span>
      				<input type="text" class="form-control" name="menu_url" id="menu_url" placeholder="Link Menu" aria-describedby="basic-addon3">
      			</div>
      				<span class="menu_url_error text-danger"></span>
      		</div>
      		<div class="form-group">
      			<label for="menu_icon_parent">Icon</label>
      			<div class="input-group">
      				<span class="input-group-text"><span id="show-menu_icon_parent"></span></span>
      				<input type="text" class="form-control" autocomplete="none" name="menu_icon_parent" id="menu_icon_parent">
      			</div>
      				<span class="menu_icon_parent_error text-danger"></span>
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
		loadMenu('backend')
	})

	$('#btn-tambah').click(function(){
		aksi = 'tambah';
		$('#form')[0].reset()
		$('#modal-form').modal('show')
		$('.modal-title').text('Tambah Menu')
		$('.text-danger').empty()
		$('.is-invalid').removeClass('is-invalid')
		$('.is-valid').removeClass('is-valid')
		loadParent();
		loadMenuFLag();
	})

	function loadMenu(tipe)
	{
				id_table = tipe == 'backend' ? '#dt-menu-backend' : '#dt-menu-frontend';
				dt = $(id_table).DataTable({
	      //   "processing": true,
	      // "serverSide": true,

	        "processing": true,
	        "serverSide": true,
	        "destroy":true,
	        "ajax": {
	            "url":base_url+"backend/Menu/getData",
	            "type": "POST",
	            "data":{
	            	tipe:tipe
	            }
	        },
	        "columnDefs": [
	        {
	            targets : [-1,0],
	            orderable: false
	        },
	        {
	            targets : [-1,0, 4,5],
	            class: 'text-nowrap text-center'
	        }
	        ],
	        "order" : [],
	      });

	}


	$('#menu_icon_parent').keyup(function() {
		var icon = $(this).val()
		$('#show-menu_icon_parent').removeClass().text('').addClass(`fa fa-${icon}`)
	})

	function loadMenuFLag()
	{
		var html = `
			<select name="menu_flag_link" id="menu_flag_link" class="form-control">
				<option value="">Pilih</option>
				<option value="1">Memiliki Link</option>
				<option value="0">Tidak Memiliki Link</option>
			</select>
		`;

		$('#show_menu_flag_link').html(html)
	}

	function loadParent()
	{
			tipe = $('.active')[2].id;
			$('#tipe').val(tipe)
			$.ajax({
			    url:base_url+"backend/Menu/loadParent",
			    data:{
			      tipe:tipe
			    },
			    type:"get",
			    dataType:"JSON",
			    async: false,            
			    success:function(data)
			    {
			        var html = `
			        <select name="menu_parent" class="form-control" id="menu_parent">
			        
			        <option value="0">Menu Label</option>`;
			        for ( i = 0 ; i < data.length ; i++ )
	                {
	                   if(data[i]['menu_parent_title']==null){
	                     html += `<option value="${data[i].id_menu}">Sub Menu of Label ${data[i].nama_menu}</option>`;  
	                   }else{
	                     if(data[i]['menu_parent_parent_title']==null){
	                       html += `<option value="${data[i].id_menu}">Sub Menu of ${data[i].nama_menu}</option>`;  
	                     }
	                     // else{
	                     //   html += `<option value=${data[i].id_menu}">Sub Menu of ${data[i].nama_menu}</option>`;  
	                     // }
	                   }
	                }
	               html += `</select>`;
			        $('#show_menu_parent').html(html);
			    }
			});
	}

	$('.btn-submit').click(function(){
		$.ajax({
			url:base_url+'backend/Menu/'+aksi+'Menu',
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

	function ButtonEdit(id)
	{
		aksi = 'ubah'
		// $('#form')[0].reset()

		$('.text-danger').empty()
		$('.is-invalid').removeClass('is-invalid')
		$('.is-valid').removeClass('is-valid')
		$('#modal-form').modal('show')
		$('.modal-title').text('Ubah Menu')
				loadParent();
				loadMenuFLag();
		$.ajax({
			url:base_url+'backend/Menu/getDataById/'+id,
			dataType:'json',
			success: (response) => {
				$.each(response.data, function(key, value) {
						$('#'+key).val(value)
				})
				var classIcon = response.data.menu_icon_parent == null ? '#' : response.data.menu_icon_parent;
				$('#menu_icon_parent').val(classIcon)
				classIcon == '#' ? $('#show-menu_icon_parent').removeClass().text(classIcon) : $('#show-menu_icon_parent').removeClass().text('').addClass(`fa fa-${classIcon}`);
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
	    			url:base_url+'backend/Menu/delete/'+id,
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