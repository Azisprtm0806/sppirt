<div class="row">
	<div class="col-12 card">
		<!-- <div class="card-header">
			<h4>
				Tanggal Pengajuan IRTP : <?= date('d-m-Y H:i', strtotime($data->created_at)) ?>
			</h4>
		</div> -->
		<div class="card-body">
			<h4>Data Pelaku Usaha - <?= $data->no_sppirt ?></h4>
			<hr>
			<div class="row text-dark">
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Nama	 </b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $data->nama ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Nama Usaha	</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $data->nama_usaha ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nik" class="col-sm-4 col-form-label"><b>NIK	  </b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $data->nik ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>NIB	  </b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $data->nib ?></p>
					    </div>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-2 col-form-label"><b>Alamat Usaha	</b></label>
					    <div class="col-sm-10">
					    	<p class="mt-1"><?= $data->alamat_usaha ?></p>
					    </div>
					</div>
				</div>
			</div>
			<div class="row text-dark">
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>No Telpon</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $data->no_telp ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Email	</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $data->email ?></p>
					    </div>
					</div>
				</div>
			</div>
			<h4 class="mt-4">Verifikasi Data Produk</h4>
			<hr>
			<form id="form-verifikasi">
				<div class="row text-dark">
						<div class="form-group col-12">
							<h4><b>Nama Jenis Pangan : <u><?= $data->nama_kategori_jenis_pangan ?></u></b></h4>
						    <label for="kategori_jenis_pangan" class="form-label" id="label_kategori_jenis_pangan"><b>Apakah jenis pangan yang dipilih pelaku usaha sesuai dengan data pangan yang diproduksi?</b>
				    		<a href="javascript:void" onclick="buttonTolak(this)" data-id="kategori_jenis_pangan" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
				    		<a href="javascript:void" onclick="buttonTerima(this)" data-id="kategori_jenis_pangan" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
						    </label>
					    	<input type="hidden" name="status_kategori_jenis_pangan" id="status_kategori_jenis_pangan">
					    	<div hidden="true" id="kategori_jenis_pangan">
						    	<select name="kategori_jenis_pangan" class="form-control select2">
						    		<option value="">-- Pilih --</option>
						    		<?php foreach ($jenis_pangan as $jns_pgn): ?>
						    			<option value="<?= $jns_pgn->id_kategori_jenis_pangan ?>"><?= $jns_pgn->kode_kategori_jenis_pangan.'-'.$jns_pgn->nama_kategori_jenis_pangan ?></option>
						    		<?php endforeach ?>
						    	</select>
					    	</div>
						</div>
						<div class="form-group col-12" style="text-align: justify;">
							<h4><b>Nama Pangan : <u><?= $data->nama_jenis_pangan ?></u></b></h4>
						    <label for="jenis_pangan" class="form-label" id="label_jenis_pangan"><b>Apakah nama pangan yang dipilih pelaku usaha sudak sesuai dengan produk yang diproduksi?</b>
						    <a href="javascript:void" onclick="buttonTolak(this)" data-id="jenis_pangan" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
						    <a href="javascript:void" onclick="buttonTerima(this)" data-id="jenis_pangan" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
						    </label>
					    	<input type="hidden" name="status_jenis_pangan" id="status_jenis_pangan">
					    	<div hidden="true" id="deskripsi_jenis_pangan">
					    		<label for="deskripsi_pangan" id="label_deskripsi_pangan" class="form-label">
					    			<b>Apakah pangannya sesuai dengan deskripsi pangan yang bisa mendapatkan SPP-IRT?</b>
					    			<a href="javascript:void" onclick="buttonTolak(this)" data-id="deskripsi_pangan" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
					    			<a href="javascript:void" onclick="buttonTerima(this)" data-id="deskripsi_pangan" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
							    </label>
							    <div hidden="true" id="button_deskripsi_pangan">
							    	<button type="button" class="btn btn-danger btn-sm" data-id="<?= encrypt_decrypt('encrypt', $data->id_pengajuan) ?>" onclick="buttonBatal(this)">Batalkan SPPIRT</button>
							    </div>
					    	</div>
						</div>
				</div>
				<h4 class="mt-4">Verifikasi Data Label Produk</h4>
				<hr>
				<div class="row text-dark">
					<div class="col-12 text-center">
						<div class="form-group">
						    <label for="nama" class="form-label"><b>Rancangan Label</b></label>
						    <br>
					    	<img src="<?= base_url('uploads/labelproduk/').$data->upload_rancangan ?>" width="250px" height="300px">
						</div>
					</div>
					<div class="form-group col-12" style="text-align: justify;">
						<h5><b>Nama Produk : <u><?= $data->nama_produk_pangan ?></u></b></h4>
					    <label for="nama_produk_pangan" class="form-label" id="label_nama_produk_pangan">
					    	<b>Apakah nama pangan yang tertulis di label sesuai dengan yang dipilih pada pengisian data pangan?</b>
					    	<a href="javascript:void" onclick="buttonTolak(this)" data-id="nama_produk_pangan" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
					    	<a href="javascript:void" onclick="buttonTerima(this)" data-id="nama_produk_pangan" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
					    </label>
				    	<input type="hidden" name="status_nama_produk_pangan" id="status_nama_produk_pangan">
				    	<textarea hidden="true" name="nama_produk_pangan" id="nama_produk_pangan" placeholder="Saran" class="form-control"></textarea>
					</div>
					<div class="form-group col-12" style="text-align: justify;">
						<h5><b>Komposisi : <u><?= $data->komposisi ?></u></b></h4>
					    <label for="komposisi" class="form-label" id="label_komposisi">
					    	<b>Apakah komposisi yang tercantum pada label sudah menuliskan semua bahan baku yang digunakan?</b>
					    	<a href="javascript:void" onclick="buttonTolak(this)" data-id="komposisi" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
					    	<a href="javascript:void" onclick="buttonTerima(this)" data-id="komposisi" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
					    </label>
				    	<input type="hidden" name="status_komposisi" id="status_komposisi">
				    	<textarea hidden="true" name="komposisi" id="komposisi" placeholder="Saran" class="form-control"></textarea>
					</div>
					<div class="form-group col-12" style="text-align: justify;">
						<h5><b>Berat Bersih : <u><?= isset($data->jenis_satuan) ? $data->jenis_satuan : '-'  ?></u></b></h4>
					    <label for="jenis_satuan" class="form-label" id="label_jenis_satuan">
					    	<b>Apakah jenis satuan yang dipilih oleh pelaku usaha sesuai dengan produknya?</b>
					    	<a href="javascript:void" onclick="buttonTolak(this)" data-id="jenis_satuan" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
					    	<a href="javascript:void" onclick="buttonTerima(this)" data-id="jenis_satuan" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
					    </label>
				    	<input type="hidden" name="status_jenis_satuan" id="status_jenis_satuan">
				    	<textarea hidden="true" name="jenis_satuan" id="jenis_satuan" placeholder="Saran" class="form-control"></textarea>
					</div>
					<div class="form-group col-12" style="text-align: justify;">
						<h5><b>Nama dan alamat produsen : <u><?= $data->nama_usaha.' - '.$data->alamat_usaha ?></u></b></h5>
					    <label for="produsen" class="form-label" id="label_produsen">
					    	<b>Apakah komposisi yang tercantum pada label sudah menuliskan semua bahan baku yang digunakan?</b>
					    	<a href="javascript:void" onclick="buttonTolak(this)" data-id="produsen" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
					    	<a href="javascript:void" onclick="buttonTerima(this)" data-id="produsen" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
					    </label>
				    	<input type="hidden" name="status_produsen" id="status_produsen">
				    	<textarea hidden="true" name="produsen" id="produsen" placeholder="Saran" class="form-control"></textarea>
					</div>
					<div class="form-group col-12" style="text-align: justify;">
						<h5><b>Halal (bagi yang dipersyaratkan) : <u><?= $data->halal == 1 ? 'Ada keterangan halal' : 'tidak ada keterangan halal'   ?></u></b></h4>
					    <label for="halal" class="form-label" id="label_halal">
					    	<b>Apakah pelaku usaha memilki sertifikat halal?</b>
					    	<a href="javascript:void" onclick="buttonTolak(this)" data-id="halal" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
					    	<a href="javascript:void" onclick="buttonTerima(this)" data-id="halal" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
					    </label>
				    	<input type="hidden" name="status_halal" id="status_halal">
				    	<textarea hidden="true" name="halal" id="halal" placeholder="Saran" class="form-control"></textarea>
					</div>

					<div class="form-group col-12" style="text-align: justify;">
						<h5><b>Tanggal dan kode Produksi : <u><?= $data->tgl_produksi == 1 ? 'Ada tanggal dan kode produksi' : 'tidak ada tanggal dan kode produksi'   ?></u></b></h4>
					    <label for="tgl_produksi" class="form-label" id="label_tgl_produksi">
					    	<b>Apakah pelaku usaha sudah mencantumkan tanggal dan kode produksi pada rancangan label yang dikirim?</b>
					    	<a href="javascript:void" onclick="buttonTolak(this)" data-id="tgl_produksi" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
					    	<a href="javascript:void" onclick="buttonTerima(this)" data-id="tgl_produksi" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
					    </label>
				    	<input type="hidden" name="status_tgl_produksi" id="status_tgl_produksi">
				    	<textarea hidden="true" name="tgl_produksi" id="tgl_produksi" placeholder="Saran" class="form-control"></textarea>
					</div>

					<div class="form-group col-12" style="text-align: justify;">
						<h5><b>Keterangan Kadaluarsa : <u><?= $data->ket_kadaluarsa == 1 ? 'Ada keterangan kadaluarsa' : 'tidak ada keterangan kadaluarsa'   ?></u></b></h4>
					    <label for="kadaluarsa" class="form-label" id="label_kadaluarsa">
					    	<b>Apakah pelaku usaha sudah mencantumkan tanggal dan kode produksi pada rancangan label yang dikirim?</b>
					    	<a href="javascript:void" onclick="buttonTolak(this)" data-id="kadaluarsa" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
					    	<a href="javascript:void" onclick="buttonTerima(this)" data-id="kadaluarsa" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
					    </label>
				    	<input type="hidden" name="status_kadaluarsa" id="status_kadaluarsa">
				    	<textarea hidden="true" name="kadaluarsa" id="kadaluarsa" placeholder="Saran" class="form-control"></textarea>
					</div>


					<div class="form-group col-12" style="text-align: justify;">
						<h5><b>Asal usul bahan pangan tertentu : <u><?= $data->asal_usul == 1 ? 'Ada keterangan asal usul' : 'tidak ada keterangan asal usul kadaluarsa'   ?></u></b></h4>
					    <label for="asal_usul" class="form-label" id="label_asal_usul">
					    	<b>Apakah terdapat bahan-bahan yang mungkin berasal dari sumber yang tidak biasa misalnya gelatin dan lemak. Jika pangan terdapat bahan baku yang mengandung babi atau bersumber dari babi apakah sudah terdapat tanda peringatan pada rancangan labelnya?</b>
					    	<a href="javascript:void" onclick="buttonTolak(this)" data-id="asal_usul" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
					    	<a href="javascript:void" onclick="buttonTerima(this)" data-id="asal_usul" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
					    </label>
				    	<input type="hidden" name="status_asal_usul" id="status_asal_usul">
				    	<textarea hidden="true" name="asal_usul" id="asal_usul" placeholder="Saran" class="form-control"></textarea>
					</div>

					<div class="form-group col-12" style="text-align: justify;">
						<h5><b>Informasi nilai gizi : <u><?= $data->informasi_nilai_gizi == 1 ? 'Ada informasi nilai gizi' : 'tidak ada informasi nilai gizi'   ?></u></b></h4>
					    <label for="informasi_nilai_gizi" class="form-label" id="label_informasi_nilai_gizi">
					    	<b>Apakah pelaku usaha sudah mencantumkan Informasi Nilai Gizi pada rancangan labelnya?</b>
					    	<a href="javascript:void" onclick="buttonTolak(this)" data-id="informasi_nilai_gizi" data-value="0" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-times"></i></a>
					    	<a href="javascript:void" onclick="buttonTerima(this)" data-id="informasi_nilai_gizi" data-value="1" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-check"></i></a>
					    </label>
				    	<input type="hidden" name="status_informasi_nilai_gizi" id="status_informasi_nilai_gizi">
				    	<textarea hidden="true" name="informasi_nilai_gizi" id="informasi_nilai_gizi" placeholder="Saran" class="form-control"></textarea>
					</div>

					<div class="form-group col-12" style="text-align: justify;" hidden="true" id="verifikasi_informasi_nilai_gizi">
						<label for="asal_ing" class="form-label" id="label_asal_usul"><b>Informasi nilai gizi didapatkan dari mana?</b></label>
					    <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= encrypt_decrypt("encrypt",$data->id_pengajuan) ?>">
						<select name="asal_ing" class="form-control select2" id="asal_ing">
							<option value="">-- Pilih --</option>
							<option value="1">Dari Uji Laboratorium</option>
							<option value="2">Perhitungan Sendiri</option>
							<option value="3">Dari Peraturan Badan POM tentang Pencantuman Informasi Nilai Gizi untuk Pangan Olahan yang Diproduksi Oleh Usaha Mikro dan Usaha Kecil</option>
						</select>
						<div id="show-note-ing">
							
						</div>
					</div>
					<div class="form-group text-right">
						<button type="button" class="btn btn-primary" id="btn-verifikasi-pengawasan">Verifikasi</button>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>


<script>
	id_pengajuan = $("#id_pengajuan").val();
	function buttonTerima(data)
	{
		var id = $(data).attr('data-id');
		var value = $(data).attr('data-value');
		// console.log(data);
		// if (id == 'informasi_nilai_gizi') {
		// 	$(`#verifikasi_${id}`).attr('hidden', false);
		// }else{
		// 	$(`#${id}`).attr('hidden', true);
		// }


		if (id == 'informasi_nilai_gizi') {
			$(`#verifikasi_${id}`).attr('hidden', false);
			$("#show-note-ing").html(``)
			$("#asal_ing").val('').change()
		}else if (id == 'jenis_pangan') {
			$(`#deskripsi_${id}`).attr('hidden', true);
		}else if(id == 'deskripsi_pangan'){
			$(`#button_${id}`).attr('hidden', true);
		}else{
			$(`#${id}`).attr('hidden', true);
		}

		var text = $(`#label_${id}`).children('b').text()
		$(`#label_${id}`).children('b').html(`<i class="fa fa-check"></i> ${text}`).removeClass('text-danger').addClass('text-success')
		var status = $(`#status_${id}`).val(value)
	}

	function buttonTolak(data)
	{
		// console.log(data);
		var id = $(data).attr('data-id');
		var value = $(data).attr('data-value');
		if (id == 'informasi_nilai_gizi') {
			$(`#verifikasi_${id}`).attr('hidden', true);
			$("#show-note-ing").html(``)
			$("#asal_ing").val('').change()
		}else if (id == 'jenis_pangan') {
			$(`#deskripsi_${id}`).attr('hidden', false);
		}else if(id == 'deskripsi_pangan'){
			$(`#button_${id}`).attr('hidden', false);
		}else{
			$(`#${id}`).attr('hidden', false);
		}
		var text = $(`#label_${id}`).children('b').text()
		$(`#label_${id}`).children('b').html(`<i class="fa fa-exclamation"></i> ${text}`).removeClass('text-success').addClass('text-danger')
		var status = $(`#status_${id}`).val(value)
	}


	$("#asal_ing").change(function(){
		var id_ing = $(this).val()
		if (id_ing == 2) {
			$("#show-note-ing").html(`
  <div class="alert alert-danger" role="alert">
    Peringatan:<br>
    <i>Silahkan tutup Informasi Nilai Gizi pada label sampai memiliki hasil uji lab</i>
  </div>
				`)
		}else{
			$("#show-note-ing").html(``)
		}
	})

	function buttonBatal(data)
	{
		var id_pengajuan = $(data).attr('data-id')
		alert(id_pengajuan)
	}



	$("#btn-verifikasi-pengawasan").click(function(e){
		e.preventDefault("submit")
		$.ajax({
			url:`${base_url}backend/Pengawasan/prosesVerifikasi`,
			type:"post",
			dataType:'json',
			data:$('#form-verifikasi').serialize(),
			success:function(response){
				alerts('.....')
			}
		})
	})
</script>