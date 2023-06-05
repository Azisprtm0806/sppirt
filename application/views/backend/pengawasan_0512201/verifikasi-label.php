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
			<!-- <hr> -->
			<form id="form-verifikasi">
				<h4><b>Data Label</b></h4>
				<div class="row text-dark">
				<div class="col-lg-4">
					<div class="form-group">
					    <label for="nama" class="form-label"><b>Rancangan Label</b></label>
					    <br>
				    	<img src="<?= base_url('uploads/labelproduk/').$data['upload_rancangan'] ?>" width="250px" height="300px">
					</div>
				</div>
				<div class="col-lg-4 col-sm-12">
					<div class="row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Nama Produk</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $data['nama_produk'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Berat Bersih/Isi Bersih</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $data['isi_bersih'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Tanggal dan Kode Produksi</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $data['kode_produksi'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Informasi Nilai Gizi</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $data['informasi_nilai_gizi'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Keterangan Lainnya</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $data['kel_lainnya'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-4 col-sm-12">
					<div class="row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Komposisi</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $data['ket_komposisi'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Halal</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $data['halal'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Keterangan Kadaluarsa</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $data['ket_kadaluarsa'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Asal Usul Bahan Tertentu</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $data['asal_usul'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
				</div>
			</div>
				<hr>
				<h4><b>Verifikasi Data Label</b></h4>
				<input type="hidden" name="jenis" value="<?= $this->uri->segment(3) ?>">
				<table class="text-dark table table-responsive" width="100%">
					<tbody>
						<tr>
							<td width="90%" class="text-left">1. Apakah nama pangan yang tertulis di label sesuai dengan yang dipilih pada pengisian data pangan?</td>
							<td width="10%" class="text-right">
								<div class="form-group mb-0">
									<input type="hidden" name="id_pengajuan" value="<?= encrypt_decrypt('encrypt',$data['id']) ?>" id="id_pengajuan">
								  <label class="radio-inline" for="nama_produk_1">
								  	<input type="radio" <?= $data['status_nama_produk'] == '1' ? "checked" : "" ?> name="nama_produk" onchange="buttonTerima(this)" id="nama_produk_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="nama_produk_0">
								  	<input type="radio" <?= $data['status_nama_produk'] == '0' ? "checked" : "" ?> name="nama_produk" onchange="buttonTolak(this)" id="nama_produk_0" value="0"> Tidak
								  </label>
								  <span class="text-danger" id="nama_produk_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_nama_produk'] == '0' ? "" : "hidden" ?> id="show_saran_nama_produk">
							<td colspan="2">
								<textarea placeholder="Saran Nama Produk" class="form-control" id="saran_nama_produk" name="saran_nama_produk"><?= $data['saran_nama_produk'] ?></textarea>
					    	<span class="text-danger" id="saran_nama_produk_error"></span>
							</td>
						</tr>
						<tr>
							<td width="90%" class="text-left">2. Apakah komposisi yang tercantum pada label sudah menuliskan semua bahan baku yang digunakan?</td>
							<td width="10%" class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="komposisi_1">
								  	<input type="radio" <?= $data['status_komposisi'] == '1' ? "checked" : ""  ?> name="komposisi" onchange="buttonTerima(this)" id="komposisi_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="komposisi_0">
								  	<input type="radio" <?= $data['status_komposisi'] == '0' ? "checked" : ""  ?> name="komposisi" onchange="buttonTolak(this)" id="komposisi_0" value="0"> Tidak
								  </label>
								  <span class="text-danger" id="komposisi_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_komposisi'] == '0' ? "" : "hidden" ?> id="show_saran_komposisi">
							<td colspan="2">
								<textarea placeholder="Saran Komposisi" class="form-control" id="saran_komposisi" name="saran_komposisi"><?= $data['saran_komposisi'] ?></textarea>
					    	<span class="text-danger" id="saran_komposisi_error"></span>
							</td>
						</tr>
						<tr>
							<td width="90%" class="text-left">3. Apakah jenis satuan yang dipilih oleh pelaku usaha sesuai dengan produknya?</td>
							<td width="10%" class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="berat_bersih_1">
								  	<input type="radio" <?= $data['status_berat_bersih'] == '1' ? "checked" : ""  ?> name="berat_bersih" onchange="buttonTerima(this)" id="berat_bersih_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="berat_bersih_0">
								  	<input type="radio" <?= $data['status_berat_bersih'] == '0' ? "checked" : ""  ?> name="berat_bersih" onchange="buttonTolak(this)" id="berat_bersih_0" value="0"> Tidak
								  </label>
								  <span class="text-danger" id="berat_bersih_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_berat_bersih'] == '0' ? "" : "hidden" ?> id="show_saran_berat_bersih">
							<td colspan="2">
								<textarea placeholder="Saran Berat Bersih" class="form-control" id="saran_berat_bersih" name="saran_berat_bersih"><?= $data['saran_berat_bersih'] ?></textarea>
					    	<span class="text-danger" id="saran_berat_bersih_error"></span>
							</td>
						</tr>
						<tr>
							<td width="90%" class="text-left">4. Apakah pada desain label pangan sudah mencantumkan Nama dan alamat produsen?</td>
							<td width="10%" class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="nama_alamat_1">
								  	<input type="radio" <?= $data['status_nama_alamat'] == '1' ? "checked" : ""  ?> name="nama_alamat" onchange="buttonTerima(this)" id="nama_alamat_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="nama_alamat_0">
								  	<input type="radio" <?= $data['status_nama_alamat'] == '0' ? "checked" : ""  ?> name="nama_alamat" onchange="buttonTolak(this)" id="nama_alamat_0" value="0"> Tidak
								  </label>
								  <span class="text-danger" id="nama_alamat_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_nama_alamat'] == '0' ? "" : "hidden" ?> id="show_saran_nama_alamat">
							<td colspan="2">
								<textarea placeholder="Saran Nama dan Alamat" class="form-control" id="saran_nama_alamat" name="saran_nama_alamat"><?= $data['saran_nama_alamat'] ?></textarea>
					    	<span class="text-danger" id="saran_nama_alamat_error"></span>
							</td>
						</tr>
						<tr>
							<td width="90%" class="text-left">
								5. Apakah pelaku usaha memiliki sertifikat halal?
								<br>
								<span style="color: red;">Note : Cek sertifikat yang dimiliki pelaku usaha jika logo halal tercantum pada label</span>
							</td>
							<td width="10%" class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="halal_1">
								  	<input type="radio" <?= $data['status_halal'] == '1' ? "checked" : ""  ?> name="halal" onchange="buttonTerima(this)" id="halal_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="halal_0">
								  	<input type="radio" <?= $data['status_halal'] == '0' ? "checked" : ""  ?> name="halal" onchange="buttonTolak(this)" id="halal_0" value="0"> Tidak
								  </label>
								  <span class="text-danger" id="halal_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_halal'] == '0' ? "" : "hidden" ?> id="show_saran_halal">
							<td colspan="2">
								<textarea placeholder="Saran Halal" class="form-control" id="saran_halal" name="saran_halal"><?= $data['saran_halal'] ?></textarea>
					    	<span class="text-danger" id="saran_halal_error"></span>
							</td>
						</tr>
						<tr>
							<td width="90%" class="text-left">6. Apakah pelaku usaha sudah mencantumkan tanggal dan kode produksi pada rancangan label yang dikirim?</td>
							<td width="10%" class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="tgl_kode_produksi_1">
								  	<input type="radio" <?= $data['status_tgl_kode_produksi'] == '1' ? "checked" : ""  ?> name="tgl_kode_produksi" onchange="buttonTerima(this)" id="tgl_kode_produksi_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="tgl_kode_produksi_0">
								  	<input type="radio" <?= $data['status_tgl_kode_produksi'] == '0' ? "checked" : ""  ?> name="tgl_kode_produksi" onchange="buttonTolak(this)" id="tgl_kode_produksi_0" value="0"> Tidak
								  </label>
								  <span class="text-danger" id="tgl_kode_produksi_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_tgl_kode_produksi'] == '0' ? "" : "hidden" ?> id="show_saran_tgl_kode_produksi">
							<td colspan="2">
								<textarea placeholder="Saran Tanggal dan Kode Porduksi" class="form-control" id="saran_tgl_kode_produksi" name="saran_tgl_kode_produksi"><?= $data['saran_tgl_kode_produksi'] ?></textarea>
					    	<span class="text-danger" id="saran_tgl_kode_produksi_error"></span>
							</td>
						</tr>
						<tr>
							<td width="90%" class="text-left">7. Apakah terdapat keterangan kedaluarsa pada rancangan label yang dikirimkan pelaku usaha ?</td>
							<td width="10%" class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="keterangan_kadaluarsa_1">
								  	<input type="radio" <?= $data['status_keterangan_kadaluarsa'] == '1' ? "checked" : ""  ?> name="keterangan_kadaluarsa" onchange="buttonTerima(this)" id="keterangan_kadaluarsa_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="keterangan_kadaluarsa_0">
								  	<input type="radio" <?= $data['status_keterangan_kadaluarsa'] == '0' ? "checked" : ""  ?> name="keterangan_kadaluarsa" onchange="buttonTolak(this)" id="keterangan_kadaluarsa_0" value="0"> Tidak
								  </label>
								  <span class="text-danger" id="keterangan_kadaluarsa_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_keterangan_kadaluarsa'] == '0' ? "" : "hidden" ?> id="show_saran_keterangan_kadaluarsa">
							<td colspan="2">
								<textarea placeholder="Saran Keterangan Kadaluarsa" class="form-control" id="saran_keterangan_kadaluarsa" name="saran_keterangan_kadaluarsa"><?= $data['saran_keterangan_kadaluarsa'] ?></textarea>
					    	<span class="text-danger" id="saran_keterangan_kadaluarsa_error"></span>
							</td>
						</tr>
						<tr>
							<td width="90%" class="text-left">
								8. Jika pangan terdapat bahan baku yang mengandung babi atau bersumber dari babi apakah sudah terdapat tanda peringatan pada rancangan labelnya?
								<br>
								<span style="color: red;">Note : Perhatikan komposisi. Apakah terdapat bahan-bahan yang mungkin berasal dari sumber yang tidak biasa misalnya gelatin dan lemak</span>
							</td>
							<td width="10%" class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="asal_usul_bahan_1">
								  	<input type="radio" <?= $data['status_asal_usul_bahan'] == '1' ? "checked" : ""  ?> name="asal_usul_bahan" onchange="buttonTerima(this)" id="asal_usul_bahan_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="asal_usul_bahan_0">
								  	<input type="radio" <?= $data['status_asal_usul_bahan'] == '0' ? "checked" : ""  ?> name="asal_usul_bahan" onchange="buttonTolak(this)" id="asal_usul_bahan_0" value="0"> Tidak
								  </label>
								  <span class="text-danger" id="asal_usul_bahan_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_asal_usul_bahan'] == '0' ? "" : "hidden" ?> id="show_saran_asal_usul_bahan">
							<td colspan="2">
								<textarea placeholder="Saran Asal Usul Bahan" class="form-control" id="saran_asal_usul_bahan" name="saran_asal_usul_bahan"><?= $data['saran_asal_usul_bahan'] ?></textarea>
					    	<span class="text-danger" id="asal_usul_bahan_error"></span>
							</td>
						</tr>
						<tr>
							<td width="90%" class="text-left">9. Apakah pelaku usaha sudah mencantumkan Informasi Nilai Gizi pada rancangan labelnya?
								  <span class="text-danger" id="informasi_nilai_gizi_error"></span>
							</td>
							<td width="10%" class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="informasi_nilai_gizi_1">
								  	<input type="radio" <?= $data['status_informasi_nilai_gizi'] == '1' ? "checked" : ""  ?> name="informasi_nilai_gizi" onchange="buttonTerima(this)" id="informasi_nilai_gizi_1" value="1"> Ya
								  </label>
								  <label class="radio-inline" for="informasi_nilai_gizi_0">
								  	<input type="radio" <?= $data['status_informasi_nilai_gizi'] == '0' ? "checked" : ""  ?> name="informasi_nilai_gizi" onchange="buttonTolak(this)" id="informasi_nilai_gizi_0" value="0"> Tidak
								  </label>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_informasi_nilai_gizi'] == '1' ? "" : "hidden"  ?> id="show_asal_informasi_nilai_gizi">
							<td width="90%" class="text-left" colspan="2">
								Dari mana didapatkan Informasi Nilai Gizi?
								<br>
								<select name="asal_informasi_nilai_gizi" class="form-control select2" id="asal_informasi_nilai_gizi">
									<option value="">-- Pilih --</option>
									<option value="1" <?= $data['asal_informasi_nilai_gizi'] == '1' ? "selected" : ""  ?>>Dari Uji Laboratorium</option>
									<option value="2" <?= $data['asal_informasi_nilai_gizi'] == '2' ? "selected" : ""  ?>>Perhitungan Sendiri</option>
									<option value="3" <?= $data['asal_informasi_nilai_gizi'] == '3' ? "selected" : ""  ?>>Dari Peraturan Badan POM tentang Pencantuman Informasi Nilai Gizi untuk Pangan Olahan yang Diproduksi Oleh Usaha Mikro dan Usaha Kecil</option>
								</select>
								<div id="show_note_informasi_nilai_gizi">
									<?php if ($data['asal_informasi_nilai_gizi'] == 2): ?>
										 <div class="alert alert-danger" role="alert">
									    Peringatan:<br>
									    <i>Silahkan tutup Informasi Nilai Gizi pada label sampai memiliki hasil uji lab</i>
									  </div>
									<?php endif ?>
							
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
							</td>						</tr>
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
		if (id == 'jenis_pangan') {
			$('#show_deskripsi_'+id).attr('hidden', true)
			$(`input[name="deskripsi_${id}"]`).prop('checked', false);
		}else if (id == 'deskripsi_jenis_pangan') {
			$('#show_button_batal').attr('hidden', true)

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
		if (id == 'jenis_pangan') {
			$('#show_deskripsi_'+id).attr('hidden', false)
		}else if (id == 'deskripsi_jenis_pangan') {
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



	// $('textarea').keyup(function(){
	// 	var val = $(this).val()
	// 	var key = $(this).attr('name')
	// 	// if (val) {
	// 		$('#' + key + '_error').html(val.length < 1 ? `<i class="fa fa-exclamation"> Tidak Boleh Kosong</i>` : ``)
	//     $('#' + key).removeClass('is-invalid').addClass(val.length < 1 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
	// 	// }
	// })


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