<div class="row">
	<div class="col-12 card">
		<!-- <div class="card-header">
			<h4>
				Tanggal Pengajuan IRTP : <?= date('d-m-Y H:i', strtotime($data->created_at)) ?>
			</h4>
		</div> -->
		<div class="card-body">
			<h4>No  <?= $data['no_sppirt'] ?></h4>
			<hr>
			<h4>Data Produk</h4>
			<div class="row text-dark">
				<div class="col-12">
					<div class="row">
					    <label for="nama" class="col-sm-2 col-form-label"><b>Nama Produk Pangan	</b></label>
					    <div class="col-sm-10">
					    	<p class="mt-1" style="text-align: justify;"><?= $data['nama_produk_pangan'] ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Jenis Produk Pangan</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $data['nama_kategori_jenis_pangan'] ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Nama Jenis Pangan</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $data['nama_jenis_pangan'] ?></p>
					    </div>
					</div>
				</div>
				<div class="col-12">
					<div class="row">
					    <label for="nama" class="col-sm-2 col-form-label"><b>Deskripsi Jenis Pangan	</b></label>
					    <div class="col-sm-10">
					    	<p class="mt-1" style="text-align: justify;"><?= $data['deskripsi'] ?></p>
					    </div>
					</div>
				</div>
			</div>
			<hr>
			<!-- <hr> -->
			<form id="form-verifikasi">
				<h4><b>Verifikasi Data Produk</b></h4>
				<input type="hidden" name="jenis" value="<?= $this->uri->segment(3) ?>">
				<table class="table text-dark">
					<tbody>
						<tr>
							<td class="text-left">1. Apakah jenis pangan yang dipilih pelaku usaha sesuai dengan data pangan yang diproduksi? </td>
							<td class="text-right">
									<input type="hidden" name="id_pengajuan" value="<?= encrypt_decrypt('encrypt',$data['id']) ?>" id="id_pengajuan">

								<div class="form-group mb-0">
								  <label class="radio-inline" for="kategori_jenis_pangan_1">
								  	<input type="radio" <?= $data['status_kategori_jenis_pangan'] == '1' ? "checked" : "" ?> name="kategori_jenis_pangan" onchange="buttonTerima(this)" id="kategori_jenis_pangan_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="kategori_jenis_pangan_0">
								  	<input type="radio" <?= $data['status_kategori_jenis_pangan'] == '0' ? "checked" : "" ?> name="kategori_jenis_pangan" onchange="buttonTolak(this)" id="kategori_jenis_pangan_0" value="0"> Tidak
								  </label>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_kategori_jenis_pangan'] == '0' ? "" : "hidden" ?> id="show_saran_kategori_jenis_pangan">
							<td colspan="2">
							<select name="id_kategori_jenis_pangan" id="id_kategori_jenis_pangan" class="form-control select2">
				    		<option value="">-- Pilih --</option>
				    		<?php foreach ($jenis_pangan as $jns_pgn): ?>
				    			<option value="<?= $jns_pgn->id_kategori_jenis_pangan ?>" <?= $data['id_kategori_jenis_pangan'] == $jns_pgn->id_kategori_jenis_pangan ? "selected" : ""  ?>><?= $jns_pgn->kode_kategori_jenis_pangan.'-'.$jns_pgn->nama_kategori_jenis_pangan ?></option>
				    		<?php endforeach ?>
				    	</select>
				    	<span class="text-danger" id="id_kategori_jenis_pangan_error"></span>
							</td>
						</tr>
						<tr>
							<td class="text-left">2. Apakah nama pangan yang dipilih pelaku usaha sudah sesuai dengan produk yang diproduksi?</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="jenis_pangan_1">
								  	<input type="radio" <?= $data['status_jenis_pangan'] == '1' ? "checked" : "" ?> name="jenis_pangan" onchange="buttonTerima(this)" id="jenis_pangan_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="jenis_pangan_0">
								  	<input type="radio" <?= $data['status_jenis_pangan'] == '0' ? "checked" : "" ?> name="jenis_pangan" onchange="buttonTolak(this)" id="jenis_pangan_0" value="0"> Tidak
								  </label>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_jenis_pangan'] == '0' ? "" : "hidden" ?> id="show_deskripsi_jenis_pangan">
							<td class="text-left">3. Apakah pangannya sesuai dengan deskripsi pangan yang bisa mendapatkan SPP-IRT?</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="deskripsi_jenis_pangan_1">
								  	<input type="radio" <?= $data['deskripsi_jenis_pangan'] == '1' ? "checked" : "" ?> name="deskripsi_jenis_pangan" onchange="buttonTerima(this)" id="deskripsi_jenis_pangan_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="deskripsi_jenis_pangan_0">
								  	<input type="radio" <?= $data['deskripsi_jenis_pangan'] == '0' ? "checked" : "" ?> name="deskripsi_jenis_pangan" onchange="buttonTolak(this)" id="deskripsi_jenis_pangan_0" value="0"> Tidak
								  </label>
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-left">
								<button type="button" onclick="window.open('', '_self', ''); window.close();" class="btn btn-secondary">Kembali</button>
							<!-- <a href="<?= base_url('backend/pengawasan') ?>" class="btn btn-secondary">Kembali</a> -->
							</td>
							<td  class="text-right" <?= $data['deskripsi_jenis_pangan'] == '0' ? "" : "hidden" ?> id="show_button_batal">
								<button type="button" class="btn btn-danger" data-id="<?= encrypt_decrypt("encrypt",$data['id_pengajuan']) ?>" onclick="buttonBatal(this)">Batalkan</button>
							</td>
							<td class="text-right" <?= $data['deskripsi_jenis_pangan'] != '0' ? "" : "hidden" ?> id="show_button_verifikasi">
								<button type="submit" class="btn btn-primary" id="btn-verifikasi">Verifikasi</button>
							</td>
						</tr>
					</tbody>
				</table>
			</form>

		</div>
	</div>
</div>


<script>
	id_pengajuan = $("#id_pengajuan").val();
	function buttonTerima(data)
	{
		var id = $(data).attr('name');
		$('#id_'+id).val('').change()
		$('#show_button_verifikasi').attr('hidden', false)
		$('#show_button_batal').attr('hidden', true)
		if (id == 'jenis_pangan') {
			$('#show_deskripsi_'+id).attr('hidden', true)
			$(`input[name="deskripsi_${id}"]`).prop('checked', false);
		}else if (id == 'deskripsi_jenis_pangan') {
			$('#show_button_batal').attr('hidden', true)
			$('#show_button_verifikasi').attr('hidden', false)
		}else if(id == 'informasi_nilai_gizi'){
			$(`#show_asal_${id}`).attr('hidden', false)
		}else{
			$('#show_saran_'+id).attr('hidden', true)
			$('#saran_'+id).val('')
		}
	}

	function buttonTolak(data)
	{
		// console.log(data);
		var id = $(data).attr('name');
		$('#id_'+id).val('').change()
		$('#show_button_verifikasi').attr('hidden', false)
		$('#show_button_batal').attr('hidden', true)
		if (id == 'jenis_pangan') {
			$('#show_deskripsi_'+id).attr('hidden', false)
		}else if (id == 'deskripsi_jenis_pangan') {
			$('#show_button_verifikasi').attr('hidden', true)
			$('#show_button_batal').attr('hidden', false)
		}else if(id == 'informasi_nilai_gizi'){
			$(`#show_asal_${id}`).attr('hidden', true)
		}else{
			$('#show_saran_'+id).attr('hidden', false)
			$('#saran_'+id).focus()
		}
	}


	$("#asal_informasi_nilai_gizi").change(function(){
		var id_ing = $(this).val()
		if (id_ing == 2) {
			$("#show_note_informasi_nilai_gizi").html(`
  <div class="alert alert-danger" role="alert">
    Peringatan:<br>
    <i>Silahkan tutup Informasi Nilai Gizi pada label sampai memiliki hasil uji lab</i>
  </div>
				`)
		}else{
			$("#show_note_informasi_nilai_gizi").html(``)
		}
	})

	function buttonBatal(data)
	{
		var id_pengajuan = $(data).attr('data-id');
		swal({
		    title: 'Are you sure?',
		    text: "Anda yakin ingin membatalkan pengajuan ini?",
		    type: 'warning',
		    showCancelButton: true,
		    confirmButtonColor: '#3085d6',
		    cancelButtonColor: '#d33',
		    confirmButtonText: 'Yes'
		}).then((result) => {
		    if (result.value) {
		    		$.ajax({
		    			url:`${base_url}backend/Pengawasan/cancelIrtp/${id_pengajuan}`,
		    			type:"post",
		    			dataType:'json',
		    			success:function(response){
		    				if (response.status) {
		    					sukses(response.alert)
									window.setTimeout(function(){window.location.href=`${base_url}/backend/pengawasan`},3000)
		    				}else{
		    					warning(response.alert)
		    				}
		    			}
		    		})
		    }
		})
	}



	$("#btn-verifikasi").click(function(e){
		e.preventDefault("submit")

			$.ajax({
				url:`${base_url}backend/Pengawasan/prosesVerifikasi`,
				type:"post",
				dataType:'json',
				data:$('#form-verifikasi').serialize(),
				success:function(response){
					if (response.status) {
						sukses(response.alert)
						window.setTimeout(function(){location.reload()},3000)
					}else{
						warning(response.alert)
						var error = response.errors
						$.each(error, function(key, value) {
						    $('#' + key + '_error').html(value.length > 0 ? `<i class="fa fa-exclamation"> ${value}</i>` : value)
						    $('#' + key).removeClass('is-invalid').addClass(value.length > 0 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
						})
					}
				}
			})
	})
</script>