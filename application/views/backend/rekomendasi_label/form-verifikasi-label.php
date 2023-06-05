<style>
* { border:0; margin:0; padding:0; }
		p { position:absolute; top:3px; right:28px; color:#555; font:bold 13px/1 sans-serif;}
	/* these styles are for the demo, but are not required for the plugin */
	.zoom {
		display:inline-block;
		position: relative;
	}
	
	/* magnifying glass icon */
	.zoom:after {
		content:'';
		display:block; 
		width:33px; 
		height:33px; 
		position:absolute; 
		top:0;
		right:0;
		background:url(icon.png);
	}

	.zoom img {
		display: block;
	}

	.zoom img::selection { background-color: transparent; }

	#ex2 img:hover { cursor: url(grab.cur), default; }
	#ex2 img:active { cursor: url(grabbed.cur), default; }
</style>

<div class="row">
	<div class="col-12 card">
		<div class="card-body">
			<h4>No  <?= $data['no_sppirt'] ?></h4>
			<?php
				if ($data['status_verifikasi_label'] == '0') {
			?>
			<span style="color: red;">Label anda belum memenuhi komitmen, dengan alasan: <?php echo $data['alasan_pengembalian'] ?></span>
			<?php
				}
				if ($data['status_verifikasi_label'] == '1') {
			?>
			<span style="color: green;">Label anda sudah memenuhi komitmen.</span>
			<?php
				}
				if ($data['status_verifikasi_label'] == '2' || $data['status_verifikasi_label'] == '') {
			?>
			<span style="color: #ff9f00;">Label anda sedang diverifikasi.</span>
			<?php
				}
			?>
			<hr>
			<!-- <hr> -->
			<form id="form-verifikasi">
				<!-- <h4><b>Data Label</b></h4>
				<div class="row text-dark">
					<div class="col-lg-4">
						<div class="form-group">
						    <label for="nama" class="form-label"><b>Rancangan Label</b></label>
						    <br>
						    <span class='zoom' id='ex4'>
						    	<img id="img_preview" src="<?= base_url('uploads/labelproduk/').$data['upload_rancangan'] ?>" width="250px" height="300px">
							</span>
						</div>
						<div class="form-group">
						    <label for="nama" class="form-label"><b>Rekomendasi Label dari Dinkes</b></label>
						    <br>
						    <span class='zoom' id='ex4'>
						    	<img id="img_preview" src="<?= base_url('uploads/labelproduk/').$data['rekomendasi_label'] ?>" width="250px" height="300px">
							</span>
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
						    <label for="nama" class="col-sm-10 col-form-label"><b>Nama Produsen</b></label>
						    <div class="col-sm-2">
						    	<p class="mt-1"><?= $data['nama_produsen'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
						    </div>
						</div>
						<div class="row">
						    <label for="nama" class="col-sm-10 col-form-label"><b>Alamat Produsen</b></label>
						    <div class="col-sm-2">
						    	<p class="mt-1"><?= $data['alamat_produsen'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
						    </div>
						</div>
						<div class="row">
						    <label for="nama" class="col-sm-10 col-form-label">
						    	<b>Upload Rekomendasi Label</b>
						    	<br>
						    	<input type="file" id="rekomendasi_label" name="rekomendasi_label" onchange="prevGambar(this)" accept="image/*">
						    	<br>
						    	<span class="text-danger" id="rekomendasi_label_error"></span>
						    </label>
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
						<div class="row">
						    <label for="nama" class="col-sm-10 col-form-label"><b>Keterangan Lainnya</b></label>
						    <div class="col-sm-2">
						    	<p class="mt-1"><?= $data['kel_lainnya'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
						    </div>
						</div>
					</div>
				</div>
				<hr> -->
				<h4><b>Verifikasi Data Label</b></h4>
				<input type="hidden" name="jenis" value="<?= $this->uri->segment(3) ?>">
				<table class="text-dark table" style="width: :100%;">
					<tbody>
						<tr>
							<td style="width:90%" class="text-left">1. Apakah nama pangan yang tertulis di label sesuai dengan yang dipilih pada pengisian data pangan?</td>
							<td style="width:10%" class="text-right">
								<div class="form-group mb-0">
									<input type="hidden" name="id_pengajuan" value="<?= encrypt_decrypt('encrypt',$data['id']) ?>" id="id_pengajuan">
								  <label class="radio-inline" for="nama_produk_1">
								  	<input type="radio" <?= $data['status_nama_produk'] == '1' ? "checked" : "" ?> name="nama_produk" onchange="buttonTerima(this)" id="nama_produk_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="nama_produk_0">
								  	<input type="radio" <?= $data['status_nama_produk'] == '0' ? "checked" : "" ?> name="nama_produk" onchange="buttonTolak(this)" id="nama_produk_0" value="0" disabled> Tidak
								  </label>
								  <span class="text-danger" id="nama_produk_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_nama_produk'] == '0' ? "" : "hidden" ?> id="show_saran_nama_produk">
							<td colspan="2">
								<textarea placeholder="Saran Nama Produk" class="form-control" id="saran_nama_produk" name="saran_nama_produk" disabled><?= $data['saran_nama_produk'] ?></textarea>
					    	<span class="text-danger" id="saran_nama_produk_error"></span>
							</td>
						</tr>
						<tr>
							<td class="text-left">2. Apakah komposisi yang tercantum pada label sudah menuliskan semua bahan baku yang digunakan?</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="komposisi_1">
								  	<input type="radio" <?= $data['status_komposisi'] == '1' ? "checked" : ""  ?> name="komposisi" onchange="buttonTerima(this)" id="komposisi_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="komposisi_0">
								  	<input type="radio" <?= $data['status_komposisi'] == '0' ? "checked" : ""  ?> name="komposisi" onchange="buttonTolak(this)" id="komposisi_0" value="0" disabled> Tidak
								  </label>
								  <span class="text-danger" id="komposisi_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_komposisi'] == '0' ? "" : "hidden" ?> id="show_saran_komposisi">
							<td colspan="2">
								<textarea placeholder="Saran Komposisi" class="form-control" id="saran_komposisi" name="saran_komposisi" disabled><?= $data['saran_komposisi'] ?></textarea>
					    	<span class="text-danger" id="saran_komposisi_error"></span>
							</td>
						</tr>
						<tr>
							<td class="text-left">3. Apakah jenis satuan yang dipilih oleh pelaku usaha sesuai dengan produknya?</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="berat_bersih_1">
								  	<input type="radio" <?= $data['status_berat_bersih'] == '1' ? "checked" : ""  ?> name="berat_bersih" onchange="buttonTerima(this)" id="berat_bersih_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="berat_bersih_0">
								  	<input type="radio" <?= $data['status_berat_bersih'] == '0' ? "checked" : ""  ?> name="berat_bersih" onchange="buttonTolak(this)" id="berat_bersih_0" value="0" disabled> Tidak
								  </label>
								  <span class="text-danger" id="berat_bersih_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_berat_bersih'] == '0' ? "" : "hidden" ?> id="show_saran_berat_bersih">
							<td colspan="2">
								<textarea placeholder="Saran Berat Bersih" class="form-control" id="saran_berat_bersih" name="saran_berat_bersih" disabled><?= $data['saran_berat_bersih'] ?></textarea>
					    	<span class="text-danger" id="saran_berat_bersih_error"></span>
							</td>
						</tr>
						<tr>
							<td class="text-left">4. Apakah pada desain label pangan sudah mencantumkan Nama dan alamat produsen?</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="nama_alamat_1">
								  	<input type="radio" <?= $data['status_nama_alamat'] == '1' ? "checked" : ""  ?> name="nama_alamat" onchange="buttonTerima(this)" id="nama_alamat_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="nama_alamat_0">
								  	<input type="radio" <?= $data['status_nama_alamat'] == '0' ? "checked" : ""  ?> name="nama_alamat" onchange="buttonTolak(this)" id="nama_alamat_0" value="0" disabled> Tidak
								  </label>
								  <span class="text-danger" id="nama_alamat_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_nama_alamat'] == '0' ? "" : "hidden" ?> id="show_saran_nama_alamat">
							<td colspan="2">
								<textarea placeholder="Saran Nama dan Alamat" class="form-control" id="saran_nama_alamat" name="saran_nama_alamat" disabled><?= $data['saran_nama_alamat'] ?></textarea>
					    	<span class="text-danger" id="saran_nama_alamat_error"></span>
							</td>
						</tr>
						<tr <?= $data['halal'] == '0' ? "hidden" : "" ?>>
							<td class="text-left">
								5. Apakah pelaku usaha memiliki sertifikat halal?
							</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="halal_1">
								  	<input type="radio" <?= $data['status_halal'] == '1' ? "checked" : ""  ?> name="halal" onchange="buttonTerima(this)" id="halal_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="halal_0">
								  	<input type="radio" <?= $data['status_halal'] == '0' ? "checked" : ""  ?> name="halal" onchange="buttonTolak(this)" id="halal_0" value="0" disabled> Tidak
								  </label>
								  <span class="text-danger" id="halal_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_halal'] == '0' ? "" : "hidden" ?> id="show_saran_halal">
							<td colspan="2">
								<textarea placeholder="Saran Halal" class="form-control" id="saran_halal" name="saran_halal" disabled><?= $data['saran_halal'] ?></textarea>
					    	<span class="text-danger" id="saran_halal_error"></span>
							</td>
						</tr>
						<tr>
							<td class="text-left">6. Apakah pelaku usaha sudah mencantumkan tanggal dan kode produksi pada rancangan label yang dikirim?</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="tgl_kode_produksi_1">
								  	<input type="radio" <?= $data['status_tgl_kode_produksi'] == '1' ? "checked" : ""  ?> name="tgl_kode_produksi" onchange="buttonTerima(this)" id="tgl_kode_produksi_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="tgl_kode_produksi_0">
								  	<input type="radio" <?= $data['status_tgl_kode_produksi'] == '0' ? "checked" : ""  ?> name="tgl_kode_produksi" onchange="buttonTolak(this)" id="tgl_kode_produksi_0" value="0" disabled> Tidak
								  </label>
								  <span class="text-danger" id="tgl_kode_produksi_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_tgl_kode_produksi'] == '0' ? "" : "hidden" ?> id="show_saran_tgl_kode_produksi">
							<td colspan="2">
								<textarea placeholder="Saran Tanggal dan Kode Porduksi" class="form-control" id="saran_tgl_kode_produksi" name="saran_tgl_kode_produksi" disabled><?= $data['saran_tgl_kode_produksi'] ?></textarea>
					    	<span class="text-danger" id="saran_tgl_kode_produksi_error"></span>
							</td>
						</tr>
						<tr>
							<td class="text-left">7. Apakah terdapat keterangan kedaluarsa pada rancangan label yang dikirimkan pelaku usaha ?</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="keterangan_kadaluarsa_1">
								  	<input type="radio" <?= $data['status_keterangan_kadaluarsa'] == '1' ? "checked" : ""  ?> name="keterangan_kadaluarsa" onchange="buttonTerima(this)" id="keterangan_kadaluarsa_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="keterangan_kadaluarsa_0">
								  	<input type="radio" <?= $data['status_keterangan_kadaluarsa'] == '0' ? "checked" : ""  ?> name="keterangan_kadaluarsa" onchange="buttonTolak(this)" id="keterangan_kadaluarsa_0" value="0" disabled> Tidak
								  </label>
								  <span class="text-danger" id="keterangan_kadaluarsa_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_keterangan_kadaluarsa'] == '0' ? "" : "hidden" ?> id="show_saran_keterangan_kadaluarsa">
							<td colspan="2">
								<textarea placeholder="Saran Keterangan Kadaluarsa" class="form-control" id="saran_keterangan_kadaluarsa" name="saran_keterangan_kadaluarsa" disabled><?= $data['saran_keterangan_kadaluarsa'] ?></textarea>
					    	<span class="text-danger" id="saran_keterangan_kadaluarsa_error"></span>
							</td>
						</tr>
						<tr>
							<td class="text-left">
								8. Jika pangan terdapat bahan baku yang mengandung babi atau bersumber dari babi apakah sudah terdapat tanda peringatan pada rancangan labelnya?
							</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="asal_usul_bahan_1">
								  	<input type="radio" <?= $data['status_asal_usul_bahan'] == '1' ? "checked" : ""  ?> name="asal_usul_bahan" onchange="buttonTerima(this)" id="asal_usul_bahan_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="asal_usul_bahan_0">
								  	<input type="radio" <?= $data['status_asal_usul_bahan'] == '0' ? "checked" : ""  ?> name="asal_usul_bahan" onchange="buttonTolak(this)" id="asal_usul_bahan_0" value="0" disabled> Tidak
								  </label>
								  <span class="text-danger" id="asal_usul_bahan_error"></span>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea placeholder="Catatan Terkait Asal Usul Bahan (e.g Tidak Mengandung Pangan Bersumber Babi)" class="form-control" id="catatan_asal_usul_bahan" name="catatan_asal_usul_bahan" disabled><?= $data['catatan_asal_usul_bahan'] ?></textarea>
					    	<span class="text-danger" id="asal_usul_bahan_error"></span>
							</td>
						</tr>
						<tr <?= $data['status_asal_usul_bahan'] == '0' ? "" : "hidden" ?> id="show_saran_asal_usul_bahan">
							<td colspan="2">
								<textarea placeholder="Saran Asal Usul Bahan" class="form-control" id="saran_asal_usul_bahan" name="saran_asal_usul_bahan" disabled><?= $data['saran_asal_usul_bahan'] ?></textarea>
					    	<span class="text-danger" id="asal_usul_bahan_error"></span>
							</td>
						</tr>
						
						<tr>
							<td class="text-left">
								9. Apakah terdapat nama Produsen?
							</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="nama_produsen_1">
								  	<input type="radio" <?= $data['nama_produsen'] == '1' ? "checked" : ""  ?> name="nama_produsen" onchange="buttonTerima(this)" id="nama_produsen_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="nama_produsen_0">
								  	<input type="radio" <?= $data['nama_produsen'] == '0' ? "checked" : ""  ?> name="nama_produsen" onchange="buttonTolak(this)" id="nama_produsen_0" value="0" disabled> Tidak
								  </label>
								  <span class="text-danger" id="nama_produsen_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['nama_produsen'] == '0' ? "" : "hidden" ?> id="show_saran_nama_produsen">
							<td colspan="2">
								<textarea placeholder="Saran Nama Produsen" class="form-control" id="saran_nama_produsen" name="saran_nama_produsen" disabled><?= $data['saran_nama_produsen'] ?></textarea>
					    	<span class="text-danger" id="nama_produsen_error"></span>
							</td>
						</tr>
						<tr>
							<td class="text-left">
								10. Apakah terdapat alamat Produsen?
							</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="alamat_produsen_1">
								  	<input type="radio" <?= $data['alamat_produsen'] == '1' ? "checked" : ""  ?> name="alamat_produsen" onchange="buttonTerima(this)" id="alamat_produsen_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="alamat_produsen_0">
								  	<input type="radio" <?= $data['alamat_produsen'] == '0' ? "checked" : ""  ?> name="alamat_produsen" onchange="buttonTolak(this)" id="alamat_produsen_0" value="0" disabled> Tidak
								  </label>
								  <span class="text-danger" id="alamat_produsen_error"></span>
								</div>
							</td>
						</tr>
						<tr <?= $data['alamat_produsen'] == '0' ? "" : "hidden" ?> id="show_saran_alamat_produsen">
							<td colspan="2">
								<textarea placeholder="Saran alamat Produsen" class="form-control" id="saran_alamat_produsen" name="saran_alamat_produsen" disabled><?= $data['saran_alamat_produsen'] ?></textarea>
					    	<span class="text-danger" id="alamat_produsen_error"></span>
							</td>
						</tr>
						
						<tr>
							<td class="text-left">11. Apakah pelaku usaha sudah mencantumkan Informasi Nilai Gizi pada rancangan labelnya?
								  <span class="text-danger" id="informasi_nilai_gizi_error"></span>
							</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="informasi_nilai_gizi_1">
								  	<input type="radio" <?= $data['status_informasi_nilai_gizi'] == '1' ? "checked" : ""  ?> name="informasi_nilai_gizi" onchange="buttonTerima(this)" id="informasi_nilai_gizi_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="informasi_nilai_gizi_0">
								  	<input type="radio" <?= $data['status_informasi_nilai_gizi'] == '0' ? "checked" : ""  ?> name="informasi_nilai_gizi" onchange="buttonTolak(this)" id="informasi_nilai_gizi_0" value="0" disabled> Tidak
								  </label>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_informasi_nilai_gizi'] == '1' ? "" : "hidden"  ?> id="show_asal_informasi_nilai_gizi">
							<td class="text-left" colspan="2">
								Dari mana didapatkan Informasi Nilai Gizi?
								<br>
								<select name="asal_informasi_nilai_gizi" class="form-control select2" id="asal_informasi_nilai_gizi" disabled>
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
							<td class="text-left">12. Apakah ada klaim yang dicantumkan pada label?
								  <span class="text-danger" id="klaim_pada_label_error"></span>
							</td>
							<td class="text-right">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="klaim_pada_label_1">
								  	<input type="radio" <?= $data['status_klaim_pada_label'] == '1' ? "checked" : ""  ?> name="klaim_pada_label" onchange="buttonTerima(this)" id="klaim_pada_label_1" value="1" disabled> Ya
								  </label>
								  <label class="radio-inline" for="klaim_pada_label_0">
								  	<input type="radio" <?= $data['status_klaim_pada_label'] == '0' ? "checked" : ""  ?> name="klaim_pada_label" onchange="buttonTolak(this)" id="klaim_pada_label_0" value="0" disabled> Tidak
								  </label>
								</div>
							</td>
						</tr>
						<tr <?= $data['status_klaim_pada_label'] == '1' ? "" : "hidden"  ?> id="show_klaim_pada_label">
							<td class="text-left" colspan="2">
								<div id="show_note_informasi_nilai_gizi">
									<div class="alert alert-danger" role="alert">
										Peringatan:<br>
										<i>Silahkan hapus klaim yang ada pada label.</i>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<h4 class="mt-4">Data Label Produk</h4>
				<hr>
				<div class="row text-dark">
					<div class="col-lg-6 col-sm-12">
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
						    <label for="nama" class="col-sm-10 col-form-label"><b>Nama Produsen</b></label>
						    <div class="col-sm-2">
						    	<p class="mt-1"><?= $data['nama_produsen'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
						    </div>
						</div>
						<div class="row">
						    <label for="nama" class="col-sm-10 col-form-label"><b>Alamat Produsen</b></label>
						    <div class="col-sm-2">
						    	<p class="mt-1"><?= $data['alamat_produsen'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
						    </div>
						</div>
					</div>
					<div class="col-lg-6 col-sm-12">
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
						<div class="row">
						    <label for="nama" class="col-sm-10 col-form-label"><b>Keterangan Lainnya</b></label>
						    <div class="col-sm-2">
						    	<p class="mt-1"><?= $data['kel_lainnya'] == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
						    </div>
						</div>
					</div>
				</div>
				<br>
				<div class="row text-dark">
					<div class="col-lg-4">
						<div class="form-group">
						    <label for="nama" class="form-label"><b>Rancangan Label</b></label>
						    <br>
						    <span class='zoom' id='ex4'>
						    	<img id="img_preview" src="<?= base_url('uploads/labelproduk/').$data['upload_rancangan'] ?>" width="250px" height="300px">
							</span>
							<br>
							<div class="btn-group" <?= $data['upload_rancangan'] == '' ? 'hidden' : '' ?>>
								<a href="<?= base_url('uploads/labelproduk/').$data['upload_rancangan'] ?>" target="_blank">
			                      <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Lihat Foto Dalam Ukuran Asli"><span>Lihat Foto Dalam Ukuran Asli</span></button>
			                    </a>
				            </div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="col-lg-12">
							<div class="form-group">
							    <label for="nama" class="form-label"><b>Rekomendasi Label dari Dinkes</b></label>
							    <br>
						    	<span id="no_recommendation" <?= $data['rekomendasi_label'] == '' ? '' : 'hidden' ?>>Tidak Ada Rekomendasi Label</span>

							    <span class='zoom' id='ex1' <?= $data['rekomendasi_label'] == '' ? 'hidden' : '' ?>>
							    	<img id="img_preview_rekomendasi" src="<?= base_url('uploads/labelproduk/').$data['rekomendasi_label'] ?>" width="250px" height="300px">
								</span>
								<br>
								<div class="btn-group" <?= $data['rekomendasi_label'] == '' ? 'hidden' : '' ?>>
									<a href="<?= base_url('uploads/labelproduk/').$data['rekomendasi_label'] ?>" target="_blank">
				                      <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Lihat Foto Dalam Ukuran Asli"><span>Lihat Foto Dalam Ukuran Asli</span></button>
				                    </a>
					            </div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
							    <label for="nama" class="form-label"><b>Catatan Perbaikan Label: </b></label>
							    <br>
							    <span><?php echo !empty($data['catatan_perbaikan_label'])?$data['catatan_perbaikan_label']:'Tidak Ada Catatan Perbaikan Label'; ?></span>
							</div>
						</div>
					</div>
					<?php
						if ($data['status_verifikasi_label'] == '0') {
					?>
					<div class="col-lg-2">
						<div class="form-group">
						    <label for="nama" class="form-label"><b>Upload Perbaikan Label</b></label>
						    <br>
						    <div class="btn-group">
								<button type="button" class="btn btn-primary" id="upload_button">
									<i class="fa fa-upload"></i>
									<span>Upload Perbaikan Label</span>
								</button>
				            </div>
						    <input type="file" id="rekomendasi_label" name="rekomendasi_label" onchange="prevGambar(this)" accept="image/*" style="display: none;">
					    	<br>
					    	<span class="text-danger" id="rekomendasi_label_error"></span>
						</div>
					</div>
					<?php
						}
					?>
				</div>
				<div class="row">
					<div class="col-md-6">
						<a href="<?= base_url('backend/rekomendasi-label') ?>" class="btn btn-secondary">Kembali</a>
					</div>

					<?php if($data['status_verifikasi_label'] == '2' || $data['status_verifikasi_label'] == ''){ ?>
						<div class="col-md-6 text-right">
							<button type="button" class="btn btn-warning" style=" border: 0px; pointer-events: none;">Label anda sedang diverifikasi</button>
						</div>
					<?php } ?>

					<?php if(isset($data['status_verifikasi_label']) && $data['status_verifikasi_label']=='1'){ ?>
						<div class="col-md-6 text-right">
							<button type="button" class="btn btn-success" style=" border: 0px; pointer-events: none;">Label anda memenuhi komitmen</button>
						</div>
					<?php } ?>
					<?php if(isset($data['status_verifikasi_label']) && $data['status_verifikasi_label']=='0'){ ?>
					<div class="col-md-6 text-right">
						<button type="button" class="btn btn-primary" id="btn-perbaikan-label">Submit Perbaikan Label</button>
					</div>	
					<?php } ?>
				</div>	

			</form>

		</div>
	</div>
</div>



<script src='<?= base_url('assets/backend/vendor/jquery.zoom.min.js') ?>'></script>
<script>
	$(document).ready(function(){
		$('#ex4').zoom({ on:'toggle' });
		$('#ex1').zoom({ on:'toggle' });
	});
</script>
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

	function prevGambar(input){
		var reader;
		// for(i=0; i < input.files.length; i++){
		reader = new FileReader();
		reader.onload = function (e) {
		  $('#img_preview').attr('src', e.target.result);
		  $('#img_preview').show();
		};
		reader.readAsDataURL(input.files[0]);
		// }
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


	$("#btn-memenuhi-komitmen").click(function(e){
		e.preventDefault("submit")
		$.ajax({
			url:`${base_url}backend/verifikasi-label/verifikasi-data`,
			type:"post",
			dataType:'json',
			data:$('#form-verifikasi').serialize()+ '&status_verifikasi=1',
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

					// warning('Data '+response.alert)

					// var error = response.errors
					// $.each(error, function(key, value) {

					//     $('#' + key + '_error').html(value.length > 0 ? `<i class="fa fa-exclamation"> ${value}</i>` : value)
					//     $('#' + key).removeClass('is-invalid').addClass(value.length > 0 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
					// })
				}
			}
		})
	})

	// $("#btn-tidak-memenuhi-komitmen").click(function(e){

	// 	e.preventDefault("submit")
	// 	$.ajax({
	// 		url:`${base_url}backend/verifikasi-label/verifikasi-data`,
	// 		type:"post",
	// 		dataType:'json',
	// 		data:$('#form-verifikasi').serialize()+ '&status_verifikasi=0&alasan_pengembalian='+$('#alasan_pengembalian').val(),
	// 		success:function(response){

	// 			$('#modal-form-pengembalian').modal('hide');
	//     		$('#alasan_pengembalian').val('');

	// 			if (response.status) {
	// 				sukses(response.alert)
	// 				// window.setTimeout(function(){location.reload()},3000)
	// 			}else{

	// 				swal({
	// 			      type: 'error',
	// 			      title: 'Oops...',
	// 			      text: response.alert,
	// 			    });

	// 				// warning('Data '+response.alert)

	// 				// var error = response.errors
	// 				// $.each(error, function(key, value) {

	// 				//     $('#' + key + '_error').html(value.length > 0 ? `<i class="fa fa-exclamation"> ${value}</i>` : value)
	// 				//     $('#' + key).removeClass('is-invalid').addClass(value.length > 0 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
	// 				// })
	// 			}
	// 		}
	// 	})
	// })

	$("#btn-tidak-memenuhi-komitmen").click(function(e){

		e.preventDefault("submit");
		var formData = new FormData($('#form-verifikasi')[0]);
        formData.append("status_verifikasi", 0);
        formData.append("alasan_pengembalian", $('#alasan_pengembalian').val());
		$.ajax({
			url:`${base_url}backend/verifikasi-label/verifikasi-data`,
			type:"post",
			dataType:'json',
			contentType: false,
            processData: false,
            data: formData,
			success:function(response){

				$('#modal-form-pengembalian').modal('hide');
	    		$('#alasan_pengembalian').val('');

				if (response.status) {
					sukses(response.alert)
					// window.setTimeout(function(){location.reload()},3000)
				}else{

					swal({
				      type: 'error',
				      title: 'Oops...',
				      text: response.alert,
				    });

					// warning('Data '+response.alert)

					// var error = response.errors
					// $.each(error, function(key, value) {

					//     $('#' + key + '_error').html(value.length > 0 ? `<i class="fa fa-exclamation"> ${value}</i>` : value)
					//     $('#' + key).removeClass('is-invalid').addClass(value.length > 0 ? 'is-invalid' : 'is-valid').find('.text-danger').remove()
					// })
				}
			}
		})
	});

	$('#upload_button').click(function(){ $('#rekomendasi_label').trigger('click'); });

	$('#btn-perbaikan-label').click(function(e){
		let files = document.getElementById('rekomendasi_label').files;

		console.log(files);

		if (files.length == 0) {
			swal({
		      type: 'error',
		      title: 'Oops...',
		      text: "File Perbaikan Label tidak boleh kosong",
		    });
		}
		else{
			var formData = new FormData($('#form-verifikasi')[0]);
	        formData.append("status_verifikasi", 2);
			$.ajax({
				url:`${base_url}backend/rekomendasi-label/verifikasi-data`,
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
		}
	});

	function tidakMemnuhiKomitmen(){

		$('#modal-form-pengembalian').modal('show');
	    $('#alasan_pengembalian').val('');
	}

	function closeModal(){
	    $('#modal-form-pengembalian').modal('hide');
	    $('#alasan_pengembalian').val('');
	}

</script>