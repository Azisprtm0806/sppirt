<div class="row">
	<div class="col-12 card">
		<div class="card-body">
		<form id="form-verifikasi" enctype="multipart/form-data">
			<h4>NIB:  <?= $data['user_nib'] ?></h4>
			<hr>
			<?php 
				$disable = 'disabled';
				if ($data['status_verifikasi_cara_pembuatan'] == '0' && $data['status_dikembalikan'] == '0') {
					$disable = '';
			?>
			<span style="color: red;">* Akun sudah pernah diajukan untuk dibekukan, namun ditolak. Silakan Verifikasi ulang</span>
			<?php
				 } 
			?>
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
			<input type="hidden" name="jenis" value="<?= $this->uri->segment(3) ?>">
			<h4><b>Verifikasi Penerapan Cara Pembuatan Pangan yang Baik</b></h4>
			<table class="table text-dark" width="100%">
				<tbody>
					<tr>
						<td class="text-left" width="70%">1. Apakah lokasi produksi di rumah tinggal?</td>
						<td class="text-right" width="10%">
							<input type="hidden" name="nib" value="<?= encrypt_decrypt('encrypt',$data['user_nib']) ?>" id="nib">
							<label class="radio-inline" for="status_1">
								<input type="radio" <?= $data['lokasi_produksi'] == '1' ? "checked" : "" ?> name="lokasi_produksi" onchange="selectYa('lokasi-produksi')" id="lokasi_produksi_1" value="1" <?php if($data['lokasi_produksi']!=""){ echo $disable; }?>> Ya
							</label>
							<label class="radio-inline" for="status_0">
								<input type="radio" <?= $data['lokasi_produksi'] == '0' ? "checked" : "" ?> name="lokasi_produksi" onchange="selectTidak('lokasi-produksi')" id="lokasi_produksi_0" value="0" <?php if($data['lokasi_produksi']!=""){ echo $disable; }?>> Tidak
							</label>
						</td>
						<td class="text-right" width="20%">
							
							<div class="form-group mb-0" style="display: none;" id="btn-pembatalan-lokasi-produksi">
							  <button type="button" onclick='pembatalanData(0,"lokasi_produksi")' class="btn btn-danger">Rekomendasikan Pembekuan Akun</button>
							</div>

							<div class="form-group mb-0" style="display: none;" id="btn-verifikasi-ya-lokasi-produksi">
							  <button type="button" onclick='verifikasiData(1,"lokasi_produksi")' class="btn btn-primary">Verifikasi</button>
							</div>

						</td>
					</tr>
					<?php if($data['lokasi_produksi']!="" && $data['lokasi_produksi']!="0"){ ?>
					<tr>
						<td class="text-left">2. Apakah menggunakan peralatan otomatis?</td>
						<td class="text-right">
							<label class="radio-inline" for="status_1">
								<input type="radio" <?= $data['peralatan_otomatis'] == '1' ? "checked" : "" ?> name="peralatan_otomatis" onchange="selectYa('peralatan-otomatis')" id="peralatan_otomatis_1" value="1" <?php if($data['peralatan_otomatis']!=""){ echo $disable; }?>> Ya
							</label>
							<label class="radio-inline" for="status_0">
								<input type="radio" <?= $data['peralatan_otomatis'] == '0' ? "checked" : "" ?> name="peralatan_otomatis" onchange="selectTidak('peralatan-otomatis')" id="peralatan_otomatis_0" value="0" <?php if($data['peralatan_otomatis']!=""){ echo $disable; }?>> Tidak
							</label>
						</td>
						<td>
							
							<div class="form-group mb-0" style="display: none;" id="btn-pembatalan-peralatan-otomatis">
							  <button type="button" onclick='pembatalanData(1,"peralatan_otomatis")' class="btn btn-danger">Rekomendasikan Pembekuan Akun</button>
							</div>

							<div class="form-group mb-0" style="display: none;" id="btn-verifikasi-ya-peralatan-otomatis">
							  <button type="button" onclick='verifikasiData(0,"peralatan_otomatis")' class="btn btn-primary">Verifikasi</button>
							</div>

						</td>
					</tr>
					<?php } ?>
					<?php if($data['peralatan_otomatis']!="" && $data['peralatan_otomatis']!="1"){ ?>
					<tr>
						<td class="text-left">3. Apakah dalam 1 tahun terakhir pelaku usaha diperiksa sarananya? <span style="color: red; font-size: 13px;">(Apabila pemeriksaan sarana sudah selesai silakan pilih 'Ya')</span></td>
						<td class="text-right">
							<label class="radio-inline" for="status_1">
								<input type="radio" <?= $data['status'] == '1' ? "checked" : "" ?> name="status" onchange="buttonYa(this)" id="status_1" value="1"> Ya
							</label>
							<label class="radio-inline" for="status_0">
								<input type="radio" <?= $data['status'] == '0' ? "checked" : "" ?> name="status" onchange="buttonTidak(this)" id="status_0" value="0"> Tidak
							</label>
						</td>
						<td></td>
					</tr>
					<?php } ?>
					<tr <?= $data['status'] == '1' ? '' : 'hidden' ?> class="ya">
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">- Hasil Pemeriksaan <span style="color: red; font-size: 13px;">(Tuliskan hasil temuan selama proses verifikasi CPOB)</span></label>
								<br>
								<textarea name="hasil_pemeriksaan" id="hasil_pemeriksaan" class="form-control"><?= $data['hasil_pemeriksaan'] ?></textarea>
								<span class="text-danger" id="hasil_pemeriksaan_error"></span>
							</div>
						</td>
						<td></td>
					</tr>
					<tr <?= $data['status'] == '1' ? '' : 'hidden' ?> class="ya">
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">- Level</label>
								<br>
								<select class="form-control level-ya" id="levelya" name="levelya">
									<option value="">-- Pilih Level --</option>
									<option value="I" <?= $data['status'] == 1 && $data['level'] == 'I' ? "selected" : "" ?>>Level I</option>
									<option value="II" <?= $data['status'] == 1 && $data['level'] == 'II' ? "selected" : "" ?>>Level II</option>
									<option value="III" <?= $data['status'] == 1 && $data['level'] == 'III' ? "selected" : "" ?>>Level III</option>
									<option value="IV" <?= $data['status'] == 1 && $data['level'] == 'IV' ? "selected" : "" ?>>Level IV</option>
								</select>
								<span class="text-danger" id="levelya_error"></span>
							</div>
						</td>
						<td></td>
					</tr>
					<tr <?= $data['status'] == '1' && $data['level'] == 'III' ||  $data['level'] == 'IV' ? '' : 'hidden' ?>  id="show_jadwal_pemeriksaan">
						<td colspan="2">
							<div class="form-group">
								<label for="jadwal_pemeriksaan">- Jadwal Pemeriksaan</label>
								<br>
								<input type="date" name="jadwal_pemeriksaan" value="<?= $data['jadwal'] ?>" class="form-control" id="jadwal_pemeriksaan">
								<span class="text-danger" id="jadwal_pemeriksaan_error"></span>
							</div>
						</td>
						<td></td>
					</tr>
					<tr <?= $data['status'] == '1' && $data['level'] == 'III' ||  $data['level'] == 'IV' ? '' : 'hidden' ?>  id="show_hasil_pembinaan">
						<td colspan="2">
							<div class="form-group">
								<label for="berita_acara">- Hasil Pembinaan</label>
								<br>
								<textarea name="hasil_pembinaan" id="hasil_pembinaan" class="form-control"><?= $data['hasil_pembinaan'] ?></textarea>
								<span class="text-danger" id="hasil_pembinaan_error"></span>
							</div>
						</td>
						<td></td>
					</tr>

					<tr <?= $data['status'] == '0' ? '' : 'hidden' ?> class="tidak">
						<td colspan="2">
							<div class="form-group">
								<label for="jadwal">- Jadwal Pemeriksaan Sarana</label>
								<br>
								<input type="date" name="jadwal" value="<?= $data['jadwal'] ?>" class="form-control" id="jadwal">
								<span class="text-danger" id="jadwal_error"></span>
							</div>
						</td>
						<td></td>
					</tr>

					<?php if(count($data['hasil_pemeriksaan_cppob']) > 0){ $no = 1; ?>
					<tr>
						<td class="text-left"><h4><b>History Pemeriksaan Sarana Pelaku Usaha</b></h4></td>
						<td class="text-right"></td>
						<td></td>
					</tr>
					<?php foreach ($data['hasil_pemeriksaan_cppob'] as $key => $value) { ?>
					<tr>
						<td class="text-left"><h4><b><?= $no; ?>.</b></h4></td>
						<td class="text-right"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">- Hasil Pemeriksaan</label>
								<br>
								<textarea class="form-control" disabled><?= $value->hasil_pemeriksaan ?></textarea>
							</div>
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">- Level</label>
								<br>
								<select class="form-control" disabled>
									<option value="">-- Pilih Level --</option>
									<option value="I" <?= $value->level == 'I' ? "selected" : "" ?>>Level I</option>
									<option value="II" <?= $value->level == 'II' ? "selected" : "" ?>>Level II</option>
									<option value="III" <?= $value->level == 'III' ? "selected" : "" ?>>Level III</option>
									<option value="IV" <?= $value->level == 'IV' ? "selected" : "" ?>>Level IV</option>
								</select>
							</div>
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="form-group">
								<label for="jadwal_pemeriksaan">- Jadwal Pemeriksaan</label>
								<br>
								<input type="date" value="<?= $value->jadwal ?>" class="form-control" disabled>
							</div>
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="form-group">
								<label for="berita_acara">- Hasil Pembinaan</label>
								<br>
								<textarea class="form-control" disabled><?= $value->hasil_pembinaan ?></textarea>
							</div>
						</td>
						<td></td>
					</tr>
					<?php $no++; } } ?>


					<!-- <?php var_dump(count($data['hasil_pemeriksaan_cppob'])); ?> -->
					
					<tr>
						<td class="text-right">
							<?php if ((count($data['hasil_pemeriksaan_cppob']) >= 3) && ($data['status_verifikasi_cara_pembuatan'] != '1') && $data['status_dikembalikan'] != '1' && $data['status_dikembalikan'] != '2') { ?>
								<button type="button" class="btn btn-danger mr-2" id="btn-pengajuan-penangguhan">Rekomendasikan Pembatalan</button>
							<?php } ?>
						</td>
						<td colspan="2" class="text-right">
							<div class="row">
								<?php if ($data['status_dikembalikan'] != '1' && $data['status_dikembalikan'] != '2') { ?>
									<button type="button" <?= $data['status'] == '1' && $data['level'] == 'III' ||  $data['level'] == 'IV' ? '' : 'hidden' ?> class="btn btn-warning ya lvl34 mr-2" id="btn-tidak-memenuhi-komitmen">Tidak Memenuhi Komitmen</button>
									<button type="button" <?= $data['status'] == '1' ? '' : 'hidden' ?> class="btn btn-primary ya" id="btn-memenuhi-komitmen">Memenuhi Komitmen</button>
									<button type="button" <?= $data['status'] == '0' ? '' : 'hidden' ?> class="btn btn-success tidak" id="btn-penjadwalan-pemeriksaan" >Jadwalkan Pemeriksaan</button>
								<?php } ?>
								<?php if(isset($data['status_dikembalikan']) && $data['status_dikembalikan']=='2'){ ?>
									<button type="button" class="btn btn-warning" style=" border: 0px; pointer-events: none;">Sedang melakukan permohonan pembekuan akun</button>
								<?php } ?>

								<?php if(isset($data['status_dikembalikan']) && $data['status_dikembalikan']=='1'){ ?>
									<button type="button" class="btn btn-danger" style=" border: 0px; pointer-events: none;">Akun Dibekukan</button>
								<?php } ?>

								<!-- <button type="button" class="btn btn-warning">Sedang melakukan permohonan pembatalan</button> -->
							</div>

						</td>
						</tr>
				</tbody>
			</table>
		</form>
			
		</div>
	</div>
</div>

<div class="modal fade" id="modal-form-pembataan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Pembekuan Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 needs-validation" novalidate method="POST" action="<?php echo base_url().'backend/verifikasi-cara-pembuatan/pengajuan-pembatalan'; ?>" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label class="form-label">Alasan Pembekuan Akun</label>
                        <input type="hidden" name="nib" id="nib" value="<?php echo encrypt_decrypt('encrypt', $data['user_nib']); ?>">
                        <input type="hidden" name="type_verifikasi" id="type_verifikasi">
                        <input type="hidden" name="hasil_verifikasi" id="hasil_verifikasi">
                        <textarea class="form-control" name="alasan_pembatalan" id="alasan_pembatalan" style="height: 300px;"></textarea>
                    </div>
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label">Unggah Surat Rekomendasi Pembekuan Akun</label>
                        <div class="btn-group" style="padding-bottom: 7px;">
							<button type="button" class="btn btn-primary" id="upload_button">
								<i class="fa fa-upload"></i>
								<span>Unggah Surat Rekomendasi Pembekuan Akun</span>
							</button>
			            </div>
					    <input type="file" id="rekomendasi_pembatalan" name="rekomendasi_pembatalan" accept="application/pdf,application/,application/doc" onchange="changeName(this)" style="display: none;">
					    <br>
					    <span id="file-name"></span>
                        <h4 id="doc-template">Untuk contoh format surat rekomendasi pembekuan <a href="<?= base_url() ?>assets/backend/template_dokumen/contoh_format_pembekuan_dinkes.pdf" target="_blank"><br>Lihat Disini.</a></h4>
                    </div>
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label"></label>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL BUAT PENGAJUAN PEMBEKUAN USER YG TIDAK MEMENUHI KOMITMEN SETELAH 3X DICEK -->
<div class="modal fade" id="modal-form-pembekuan-akun" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Pembekuan Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3" id="form-send-submission" method="POST" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label class="form-label">Alasan Pembekuan Akun</label>
                        <input type="hidden" name="nib_modal" id="nib_modal">
                        <textarea class="form-control" name="alasan_pembatalan" id="alasan_pembekuan" style="height: 300px;"></textarea>
                    </div>
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label">Unggah Surat Rekomendasi Pembekuan Akun</label>
                        <div class="btn-group" style="padding-bottom: 7px;">
                            <button type="button" class="btn btn-primary" id="upload_button_surat">
                                <i class="fa fa-upload"></i>
                                <span>Unggah Surat Rekomendasi Pembekuan Akun</span>
                            </button>
                        </div>
                        <input type="file" id="rekomendasi_pembekuan" name="rekomendasi_pembatalan" accept="application/pdf,application/,application/doc" onchange="changeDocName(this)" style="display: none;">
                        <br>
                        <span id="doc-name"></span>
                        <h4 id="doc-template">Untuk contoh format surat rekomendasi pembekuan <a href="<?= base_url() ?>assets/backend/template_dokumen/contoh_format_pembekuan_dinkes.pdf" target="_blank"><br>Lihat Disini.</a></h4>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label"></label>
                        <button type="button" class="btn btn-primary" id="btn-submit" style="width: 100%;">Submit</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- SELESAI -->

<script>
	id_pengajuan = $("#id_pengajuan").val();
	function buttonYa(data)
	{
		$('.ya').attr('hidden',false);
		$('.level').attr('hidden',false);
		$('.tidak').attr('hidden',true);

		var lvl = $('.level-ya').val();
		if (lvl == 'III' || lvl == 'IV') {
			$("#show_hasil_pembinaan").attr('hidden',false)
			$("#show_jadwal_pemeriksaan").attr('hidden',false)
			$(".lvl34").attr('hidden',false)
		}else{
			$("#show_hasil_pembinaan").attr('hidden',true)
			$("#show_jadwal_pemeriksaan").attr('hidden',true)
			$(".lvl34").attr('hidden',true)
		}
	}

	function buttonTidak(data)
	{
		$('.ya').attr('hidden',true);
		$('.tidak').attr('hidden',false);
		$("#show_hasil_pembinaan").attr('hidden',true);
		$("#show_jadwal_pemeriksaan").attr('hidden',true);
	}

	$('.level-ya').change(function(){
		var lvl = $(this).val()
		if (lvl == 'III' || lvl == 'IV') {
			$("#show_hasil_pembinaan").attr('hidden',false)
			$("#show_jadwal_pemeriksaan").attr('hidden',false)
			$(".lvl34").attr('hidden',false)
		}else{
			$("#show_hasil_pembinaan").attr('hidden',true)
			$("#show_jadwal_pemeriksaan").attr('hidden',true)
			$(".lvl34").attr('hidden',true)
		}
	})

	function selectYa(param){

		if(param=='lokasi-produksi'){

			$('#btn-pembatalan-'+param).hide();
			$('#btn-verifikasi-ya-'+param).show();

		}else if(param=='peralatan-otomatis'){

			$('#btn-pembatalan-'+param).show();
			$('#btn-verifikasi-ya-'+param).hide();

		}

	}

	function selectTidak(param){

		if(param=='lokasi-produksi'){

			$('#btn-pembatalan-'+param).show();
			$('#btn-verifikasi-ya-'+param).hide();

		}else if(param=='peralatan-otomatis'){

			$('#btn-pembatalan-'+param).hide();
			$('#btn-verifikasi-ya-'+param).show();

		}

	}

	$('#upload_button').click(function(){ $('#rekomendasi_pembatalan').trigger('click'); });

	function changeName(input){
		var file_name = 'Selected File: '+ input.files[0].name;
		$("#file-name").html(file_name);
	}

	function verifikasiData(hasil_Verifikasi,type_verifikasi) {
	    swal({
	        title: 'Are you sure?',
	        text: "Anda yakin akan memverifikasi data ini?",
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes'
	    }).then((result) => {
	        if (result.value) {
	            window.location.href = "<?php echo base_url('backend/verifikasi-cara-pembuatan/verifikasi-data/'.encrypt_decrypt('encrypt', $data['user_nib']).'/'); ?>"+hasil_Verifikasi+"/"+type_verifikasi;
	        }
	    })
	}

	function pembatalanData(hasil_verifikasi,param){

	    $('#modal-form-pembataan').modal('show');
	    $('#type_verifikasi').val(param);
	    $('#hasil_verifikasi').val(hasil_verifikasi);
	    $('#alasan_pembatalan').val('');

	}

	function closeModal(){
	    $('#modal-form-pembataan').modal('hide');
	    $('#modal-form-pembekuan-akun').modal('hide');
	}

	$("#btn-penjadwalan-pemeriksaan").click(function(e){
		e.preventDefault("submit")
        var formData = new FormData($('#form-verifikasi')[0]);
        formData.append("status_verifikasi", 0);
		$.ajax({
			url:`${base_url}backend/verifikasi-cara-pembuatan/verifikasi-data`,
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
					
					swal({
				      type: 'error',
				      title: 'Oops...',
				      text: response.alert,
				    });
				}
			}
		})
	})

	// $("#btn-penjadwalan-pemeriksaan").click(function(e){
	// 	e.preventDefault("submit")

	// 	const reader = new FileReader()

	// 	var berita_acara;
	// 	let files = document.getElementById('berita_acara').files

	// 	if (files.length == 0) {
	// 		swal({
	// 	      type: 'error',
	// 	      title: 'Oops...',
	// 	      text: "File Berita Acara tidak boleh kosong",
	// 	    });
	// 	}
	// 	else{
	// 		reader.onload = async (event) => {
	// 		    // document.getElementById('preview').setAttribute('src', event.target.result)
	// 		    var formData = new FormData($('#form-verifikasi')[0]);
	// 		    formData.append("status_verifikasi", 0);
	// 			$.ajax({
	// 				url:`${base_url}backend/verifikasi-cara-pembuatan/verifikasi-data`,
	// 				type:"post",
	// 				dataType:'json',
	// 				contentType: false,
	// 	            processData: false,
	// 				// data:$('#form-verifikasi').serialize()+ '&status_verifikasi=0&berita_acara='+event.target.result,
	// 				data: formData,
	// 				success:function(response){
	// 					if (response.status) {
	// 						sukses(response.alert)
	// 						window.setTimeout(function(){location.reload()},3000)
	// 					}else{

	// 						swal({
	// 					      type: 'error',
	// 					      title: 'Oops...',
	// 					      text: response.alert,
	// 					    });

	// 					}
	// 				}
	// 			})
					
	// 		}
	// 		reader.readAsDataURL(files[0])
	// 	}
	// })

	$("#btn-tidak-memenuhi-komitmen").click(function(e){
		e.preventDefault("submit")
        var formData = new FormData($('#form-verifikasi')[0]);
        formData.append("status_verifikasi", 0);
		$.ajax({
			url:`${base_url}backend/verifikasi-cara-pembuatan/verifikasi-data`,
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
					
					swal({
				      type: 'error',
				      title: 'Oops...',
				      text: response.alert,
				    });
				}
			}
		})
	})

	$("#btn-memenuhi-komitmen").click(function(e){
		e.preventDefault("submit")
        var formData = new FormData($('#form-verifikasi')[0]);
        formData.append("status_verifikasi", 1);
		$.ajax({
			url:`${base_url}backend/verifikasi-cara-pembuatan/verifikasi-data`,
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
					
					swal({
				      type: 'error',
				      title: 'Oops...',
				      text: response.alert,
				    });
				}
			}
		})
	})

	$("#btn-verifikasi").click(function(e){
		e.preventDefault("submit")
        var formData = new FormData($('#form-verifikasi')[0]);
        formData.append()
		$.ajax({
			url:`${base_url}backend/verifikasi-cara-pembuatan/verifikasi-data`,
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
					
					swal({
				      type: 'error',
				      title: 'Oops...',
				      text: response.alert,
				    });
				}
			}
		})
	})

	// JS BUAT FLOW PEMBEKUAN AKUN SETELAH 3X GAGAL MEMENUHI KOMITMEN
	$('#btn-pengajuan-penangguhan').click(function(e){
        e.preventDefault("submit");

        nib = '<?= $data['user_nib'] ?>';

        $('#modal-form-pembekuan-akun').modal('show');
        $('#nib_modal').val(nib);
        $('#alasan_pembekuan').val('');
    });

    $('#upload_button_surat').click(function(){ $('#rekomendasi_pembekuan').trigger('click'); });

	function changeDocName(input){
		var file_name = 'Selected File: '+ input.files[0].name;
		$("#doc-name").html(file_name);
	}

	$("#btn-submit").click(function(e){
        e.preventDefault("submit")
        var formData = new FormData($('#form-send-submission')[0]);
        $.ajax({
            url:`${base_url}backend/pembatalan-akun/save-submission`,
            type:"post",
            dataType:'json',
            contentType: false,
            processData: false,
            data: formData,
            success:function(response){
                if (response.status == 200) {
                    Swal.fire({
                      type: 'success',
                      title: 'Success',
                      text: response.message,
                      showConfirmButton: false,
                      timer: 1500
                    }).then(() => {
                        location.reload();
                    })
                }
                else{
                    Swal.fire({
                      type: 'warning',
                      title: 'Error',
                      text: response.message,
                      showConfirmButton: false,
                      timer: 1500
                    })
                }
            }
        })
    })
</script>