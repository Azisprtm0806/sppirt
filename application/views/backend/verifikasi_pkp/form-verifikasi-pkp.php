<div class="row">
	<div class="col-12 card">
		<div class="card-body">
		<form id="form-verifikasi">
			<h4>NIB:  <?= $data['user_nib'] ?></h4>
			<hr>
            <h4>Data Pelaku Usaha</h4>
            <div class="row text-dark">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-4 col-form-label"><b>Nama</b></label>
                        <div class="col-sm-8">
                            <p class="mt-1" id="nama"><?= $data['nama'] ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-4 col-form-label"><b>Nama Usaha</b></label>
                        <div class="col-sm-8">
                            <p class="mt-1" id="nama_usaha"><?= $data['nama_usaha'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group row">
                        <label for="nik" class="col-sm-4 col-form-label"><b>NIK</b></label>
                        <div class="col-sm-8">
                            <p class="mt-1" id="nik"><?= $data['nik'] ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-4 col-form-label"><b>NIB</b></label>
                        <div class="col-sm-8">
                            <p class="mt-1" id="nib_pelaku_usaha"><?= $data['user_nib'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label"><b>Alamat Usaha</b></label>
                        <div class="col-sm-10">
                            <p class="mt-1" id="alamat_usaha"><?= $data['alamat_usaha'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-dark">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-4 col-form-label"><b>No Telpon</b></label>
                        <div class="col-sm-8">
                            <p class="mt-1" id="no_telp"><?= $data['no_telp'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-4 col-form-label"><b>Email</b></label>
                        <div class="col-sm-8">
                            <p class="mt-1" id="email"><?= $data['email'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <h4>Data Sertifikat PKP</h4>
            <div class="row text-dark">
            	<?php
            		$link = '-';

            		if (!empty($data['link_sertifikat_pkp'])) {
            			$link = '<a href="'.$data['link_sertifikat_pkp'].'" target="_blank">'.$data['link_sertifikat_pkp'].'</a>';
            		}
            	?>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-4 col-form-label"><b>Nomor Sertifikat</b></label>
                        <div class="col-sm-8">
                            <p class="mt-1" id="nomor_sertifikat_pkp"><?= !empty($data['nomor_sertifikat_pkp'])?$data['nomor_sertifikat_pkp']:'-' ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group row">
                        <label for="nik" class="col-sm-4 col-form-label"><b>Tanggal PKP</b></label>
                        <div class="col-sm-8">
                            <p class="mt-1" id="tanggal_sertifikat_pkp"><?= !empty($data['tanggal_sertifikat_pkp'])?date("d-m-Y", strtotime($data['tanggal_sertifikat_pkp'])):'-' ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label"><b>Link Sertifikat</b></label>
                        <div class="col-sm-10">
                            <p class="mt-1" id="link_sertifikat_pkp"><?= $link ?></p>
                        </div>
                    </div>
                </div>
            </div>
			<hr>
			<input type="hidden" name="jenis" value="<?= $this->uri->segment(3) ?>">
			<h4><b>Verifikasi Penyuluhan Keamanan Pangan</b></h4>
			<table class="table text-dark" width="100%">
				<tbody>
					<?php
						$hide = '';
						$today = strtotime(date('Y-m-d'));
						if ($data['status'] == '0' && !empty($data['jadwal'])) {
							if ($today < strtotime($data['jadwal'])) {
								$hide = 'hidden';
							}
					?>
					<tr>
						<td class="text-left" width="90%">1. Apakah pelaku usaha sudah pernah mendapatkan Penyuluhan Keamanan Pangan?</td>
						<td class="text-right" width="10%">
							<label class="radio-inline">
								<input type="radio" value="1" disabled> Sudah
							</label>
							<label class="radio-inline">
								<input type="radio" checked value="0" disabled> Belum
							</label>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="form-group">
								<label for="jadwal">- Jadwal Penyuluhan Keamanan Pangan</label>
								<input type="date" value="<?= $data['jadwal'] ?>" class="form-control" placeholder="exp:2167343999" disabled>
							</div>
						</td>
					</tr>
					<?php
						}
					?>
					<tr <?= $hide; ?>>
						<td class="text-left" width="90%">1. Apakah pelaku usaha sudah pernah mendapatkan Penyuluhan Keamanan Pangan?</td>
						<td class="text-right" width="10%">
									<input type="hidden" name="nib" value="<?= encrypt_decrypt('encrypt',$data['user_nib']) ?>" id="id_pengajuan">

							<label class="radio-inline" for="status_1">
								<input type="radio" <?= $data['status'] == '1' ? "checked" : "" ?> name="status" onchange="buttonSudah(this)" id="status_1" value="1"> Sudah
							</label>
							<label class="radio-inline" for="status_0">
								<input type="radio" <?= $data['status'] == '0' ? "checked" : "" ?> name="status" onchange="buttonBelum(this)" id="status_0" value="0"> Belum
							</label>
						</td>
					</tr>
					<tr <?= $data['status'] == '1' ? '' : 'hidden' ?> <?= $hide; ?> id="status_personil">
						<td class="text-left" width="90%">2. Apakah personil yang mengikuti penyuluhan keamanan pangan masih aktif dalam proses produksi?</td>
						<td class="text-right" width="10%">
							<label class="radio-inline" for="status_personil_1">
								<input type="radio" <?= $data['status_personil'] == '1' ? "checked" : "" ?> name="status_personil" onchange="buttonMasih(this)" id="status_personil_1" value="1"> Masih
							</label>
							<label class="radio-inline" for="status_personil_0">
								<input type="radio" <?= $data['status_personil'] == '0' ? "checked" : "" ?> name="status_personil" onchange="buttonTidak(this)" id="status_personil_0" value="0"> tidak
							</label>
						</td>
					</tr>
					<tr <?= ($data['status'] == '1' && $data['status_personil'] == '1') ? '' : 'hidden' ?> <?= $hide; ?> id="sudah">
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">- Nomor Sertifikat <span style="color: red;">(Apabila pelaku usaha sudah mengisi nomor sertifikat PKP, silakan salin dari data yang diisi)</span></label>
								<input type="text" name="nomor_sertifikat" value="<?= $data['nomor_sertifikat'] ?>" class="form-control" id="nomor_sertifikat" placeholder="exp:2167343999">
							</div>
						</td>
					</tr>
					<tr <?= ($data['status'] == '0' || ( $data['status'] == '1' && $data['status_personil'] == '0')) ? '' : 'hidden' ?> <?= $hide; ?> id="belum">
						<td colspan="2">
							<div class="form-group">
								<label for="jadwal">- Jadwal Penyuluhan Keamanan Pangan</label>
								<input type="date" name="jadwal" value="<?= $data['jadwal'] ?>" class="form-control" id="jadwal" placeholder="exp:2167343999">
							</div>
						</td>
					</tr>
					<tr>
						<td class="text-left">
							<button type="button" onclick="window.open('', '_self', ''); window.close();" class="btn btn-secondary">Kembali</button>
						</td>
						<td class="text-right" <?= $hide; ?>>
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
		$('#sudah').attr('hidden', true);
		$('#belum').attr('hidden', true);
		$('#status_personil').attr('hidden', false);
	}
	function buttonBelum(data)
	{
		$('#sudah').attr('hidden', true);
		$('#belum').attr('hidden', false);
		$('#status_personil').attr('hidden', true);
	}

	function buttonMasih(data)
	{
		$('#sudah').attr('hidden', false);
		$('#belum').attr('hidden', true);
		$('#status_personil').attr('hidden', false);
	}
	function buttonTidak(data)
	{
		$('#sudah').attr('hidden', true);
		$('#belum').attr('hidden', false);
		$('#status_personil').attr('hidden', false);
	}

	$("#btn-verifikasi").click(function(e){
		e.preventDefault("submit")
		$.ajax({
			url:`${base_url}backend/verifikasi-pkp/verifikasi-data`,
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