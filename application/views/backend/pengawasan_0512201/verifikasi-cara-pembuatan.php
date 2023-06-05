<div class="row">
	<div class="col-12 card">
		<div class="card-body">
		<form id="form-verifikasi">
			<h4>No  <?= $data['no_sppirt'] ?></h4>
			<hr>
			<input type="hidden" name="jenis" value="<?= $this->uri->segment(3) ?>">
			<h4><b>Verifikasi Penerapan Cara Pembuatan Pangan yang Baik</b></h4>
			<table class="table text-dark" width="100%">
				<tbody>
					<tr>
						<td class="text-left" width="90%">1. Apakah dalam 1 tahun terakhir pelaku usaha diperiksa sarananya?</td>
						<td class="text-right" width="10%">
									<input type="hidden" name="id_pengajuan" value="<?= encrypt_decrypt('encrypt',$data['id']) ?>" id="id_pengajuan">

							<label class="radio-inline" for="status_1">
								<input type="radio" <?= $data['status'] == '1' ? "checked" : "" ?> name="status" onchange="buttonYa(this)" id="status_1" value="1"> Ya
							</label>
							<label class="radio-inline" for="status_0">
								<input type="radio" <?= $data['status'] == '0' ? "checked" : "" ?> name="status" onchange="buttonTidak(this)" id="status_0" value="0"> Tidak
							</label>
						</td>
					</tr>
					<tr <?= $data['status'] == '1' ? '' : 'hidden' ?> class="ya">
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">2. Hasil Pemeriksaan</label>
								<br>
								<textarea name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control"><?= $data['hasil_pemeriksaan'] ?></textarea>
								<span class="text-danger" id="hasil_pemeriksaan_error"></span>
							</div>
						</td>
					</tr>
					<tr <?= $data['status'] == '1' ? '' : 'hidden' ?> class="ya">
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">3. Level</label>
								<br>
								<select class="form-control" id="levelya" name="levelya">
									<option value="">-- Pilih Level --</option>
									<option value="I" <?= $data['status'] == 1 && $data['level'] == 'I' ? "selected" : "" ?>>Level I</option>
									<option value="II" <?= $data['status'] == 1 && $data['level'] == 'II' ? "selected" : "" ?>>Level II</option>
									<option value="III" <?= $data['status'] == 1 && $data['level'] == 'III' ? "selected" : "" ?>>Level III</option>
									<option value="IV" <?= $data['status'] == 1 && $data['level'] == 'IV' ? "selected" : "" ?>>Level IV</option>
								</select>
								<span class="text-danger" id="levelya_error"></span>
							</div>
						</td>
					</tr>

					<tr <?= $data['status'] == '0' ? '' : 'hidden' ?> class="tidak">
						<td colspan="2">
							<div class="form-group">
								<label for="jadwal">2. Jadwal Pemeriksaan Sarana</label>
								<br>
								<input type="date" name="jadwal" value="<?= $data['jadwal'] ?>" class="form-control" id="jadwal">
								<span class="text-danger" id="jadwal_error"></span>
							</div>
						</td>
					</tr>
					<tr <?= $data['status'] == '0' ? '' : 'hidden' ?> class="tidak">
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">3. Level</label>
								<br>
								<select class="form-control level-tidak" id="leveltidak" name="leveltidak">
									<option value="">-- Pilih Level --</option>
									<option value="I" <?= $data['status'] == 0 && $data['level'] == 'I' ? "selected" : "" ?>>Level I</option>
									<option value="II" <?= $data['status'] == 0 && $data['level'] == 'II' ? "selected" : "" ?>>Level II</option>
									<option value="III" <?= $data['status'] == 0 && $data['level'] == 'III' ? "selected" : "" ?>>Level III</option>
									<option value="IV" <?= $data['status'] == 0 && $data['level'] == 'IV' ? "selected" : "" ?>>Level IV</option>
								</select>
								<span class="text-danger" id="leveltidak_error"></span>
							</div>
						</td>
					</tr>
					<tr <?= $data['status'] == '0' ? '' : 'hidden' ?> class="tidak">
						<td colspan="2">
							<div class="form-group">
								<label for="berita_acara">4. Berita Acara Pemeriksaan</label>
								<br>
								<input type="file" name="berita_acara" accept="application/pdf,application/,application/doc" class="form-control" id="berita_acara">
								<a href="<?= base_url('uploads/pengawasan/berita_acara/').$data['berita_acara'] ?>" target="_blank" title="Berita Acara"><?= $data['berita_acara'] ?></a>
								<span class="text-danger" id="berita_acara_error"></span>
							</div>
						</td>
					</tr>
					<tr <?= $data['status'] == '0' && $data['level'] == 'III' ||  $data['level'] == 'IV' ? '' : 'hidden' ?>  id="show_hasil_pembinaan">
						<td colspan="2">
							<div class="form-group">
								<label for="berita_acara">5. Hasil Pembinaan</label>
								<br>
								<textarea name="hasil_pembinaan" id="hasil_pembinaan" class="form-control"><?= $data['hasil_pembinaan'] ?></textarea>
								<span class="text-danger" id="hasil_pembinaan_error"></span>
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
	id_pengajuan = $("#id_pengajuan").val();
	function buttonYa(data)
	{
		$('.ya').attr('hidden',false);
		$('.tidak').attr('hidden',true);
	}

	function buttonTidak(data)
	{
		$('.ya').attr('hidden',true);
		$('.tidak').attr('hidden',false);
	}

	$('.level-tidak').change(function(){
		var lvl = $(this).val()
		if (lvl == 'III' || lvl == 'IV') {
			$("#show_hasil_pembinaan").attr('hidden',false)
		}else{
			$("#show_hasil_pembinaan").attr('hidden',true)
		}
	})

	$("#btn-verifikasi").click(function(e){
		e.preventDefault("submit")
        var formData = new FormData($('#form-verifikasi')[0]);
		$.ajax({
			url:`${base_url}backend/Pengawasan/prosesVerifikasi`,
			type:"post",
			dataType:'json',
			contentType: false,
            processData: false,
            data: formData,
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