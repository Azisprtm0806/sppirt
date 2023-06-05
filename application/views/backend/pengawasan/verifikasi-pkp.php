<div class="row">
	<div class="col-12 card">
		<div class="card-body">
		<form id="form-verifikasi">
			<h4>No  <?= $data['no_sppirt'] ?></h4>
			<hr>
			<input type="hidden" name="jenis" value="<?= $this->uri->segment(3) ?>">
			<h4><b>Verifikasi Penyuluhan Keamanan Pangan</b></h4>
			<table class="table text-dark" width="100%">
				<tbody>
					<tr>
						<td class="text-left" width="90%">1. Apakah pelaku usaha sudah pernah mendapatkan Penyuluhan Keamanan Pangan?</td>
						<td class="text-right" width="10%">
									<input type="hidden" name="id_pengajuan" value="<?= encrypt_decrypt('encrypt',$data['id']) ?>" id="id_pengajuan">

							<label class="radio-inline" for="status_1">
								<input type="radio" <?= $data['status'] == '1' ? "checked" : "" ?> name="status" onchange="buttonSudah(this)" id="status_1" value="1"> Sudah
							</label>
							<label class="radio-inline" for="status_0">
								<input type="radio" <?= $data['status'] == '0' ? "checked" : "" ?> name="status" onchange="buttonBelum(this)" id="status_0" value="0"> Belum
							</label>
						</td>
					</tr>
					<tr <?= $data['status'] == '1' ? '' : 'hidden' ?> id="sudah">
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">2. Nomor Sertifikat</label>
								<input type="text" name="nomor_sertifikat" value="<?= $data['nomor_sertifikat'] ?>" class="form-control" id="nomor_sertifikat" placeholder="exp:2167343999">
							</div>
						</td>
					</tr>
					<tr <?= $data['status'] == '0' ? '' : 'hidden' ?> id="belum">
						<td colspan="2">
							<div class="form-group">
								<label for="jadwal">2. Jadwal Penyuluhan Keamanan Pangan</label>
								<input type="date" name="jadwal" value="<?= $data['jadwal'] ?>" class="form-control" id="jadwal" placeholder="exp:2167343999">
							</div>
						</td>
					</tr>
					<tr>
						<td class="text-left">
							<button type="button" onclick="window.open('', '_self', ''); window.close();" class="btn btn-secondary">Kembali</button>
							<!-- <a href="<?= base_url('backend/pengawasan') ?>" class="btn btn-secondary">Kembali</a> -->
						</td>
						<td class="text-right">
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
	function buttonSudah(data)
	{
		$('#sudah').attr('hidden', false);
		$('#belum').attr('hidden', true);
	}
	function buttonBelum(data)
	{
		$('#sudah').attr('hidden', true);
		$('#belum').attr('hidden', false);
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
					warning('Data '+response.alert)

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