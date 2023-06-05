<div class="row">
	<div class="col-12 card">
		<!-- <div class="card-header">
			<h4>
				Tanggal Pengajuan IRTP : <?= date('d-m-Y H:i', strtotime($data->created_at)) ?>
			</h4>
		</div> -->
		<div class="card-body">
			<h4>No SPPIRT:  <?= $data['no_sppirt']. ' | NIB: ' .$data['nib'] ?></h4>
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
					    <label for="nama" class="col-sm-2 col-form-label"><b>Jenis Kemasan</b></label>
					    <div class="col-sm-10">
					    	<p class="mt-1" style="text-align: justify;"><?= $data['nama_kemasan'] ?></p>
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
				<div class="col-12">
					<div class="row">
					    <label for="nama" class="col-sm-2 col-form-label"><b>Komposisi Pangan	</b></label>
					    <div class="col-sm-10">
					    	<p class="mt-1" style="text-align: justify;"><?= $data['komposisi'] ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Berat Bersih</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $data['isi_bersih_produk'] ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Masa Simpan</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $data['masa_simpan']. ' ' .ucfirst($data['jenis_simpan']) ?></p>
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
						<?php $no=1; foreach ($analisis_product as $key => $value) { ?>
						<?php if($value->is_show==1){?>
						<tr>
							<td class="text-left" style="width:60%;"><?php echo $no++; ?>. <?php echo $value->analisis; ?> </td>
							<td class="text-right" style="width:20%;">
								<div class="form-group mb-0">
								  <label class="radio-inline" for="<?php echo $value->id; ?>_1">
								  	<input type="radio" name="kategori_jenis_pangan[<?php echo $value->id; ?>]" <?php if((isset($value->hasil_verifikasi) && $value->hasil_verifikasi!=NULL && $value->hasil_verifikasi==1)){?> checked <?php } ?> onchange='selectYa(<?php echo $value->id; ?>,"<?php echo $value->ya; ?>")' id="<?php echo $value->id; ?>_1" value="1" <?php if($value->is_disabled==1){?>disabled<?php } ?>> Ya
								  </label>
								  <label class="radio-inline" for="<?php echo $value->id; ?>_0">
								  	<input type="radio" name="kategori_jenis_pangan[<?php echo $value->id; ?>]" <?php if((isset($value->hasil_verifikasi) && $value->hasil_verifikasi!=NULL && $value->hasil_verifikasi==0 ) ){?> checked <?php } ?> onchange='selectTidak(<?php echo $value->id; ?>,"<?php echo $value->tidak; ?>")' id="<?php echo $value->id; ?>_0" value="0" <?php if($value->is_disabled==1){?>disabled<?php } ?>> Tidak 
								  </label>
								</div>
							</td>
							<td class="text-right" style="width:20%;">
	
								<div class="form-group mb-0">
								  <button type="button" onclick='pembatalanData("<?php echo encrypt_decrypt('encrypt', $value->id); ?>",1)' class="btn btn-danger" id="btn-pembatalan-<?php echo $value->id; ?>" style="display: none;">Rekomendasikan Pembatalan</button>
								</div>

								<div class="form-group mb-0">
								  <button type="button" onclick='verifikasiData("<?php echo encrypt_decrypt('encrypt', $value->id); ?>",1)' class="btn btn-primary" id="btn-verifikasi-ya-<?php echo $value->id; ?>" style="display: none;">Verifikasi</button>
								</div>

								<div class="form-group mb-0">
								  <button type="button" onclick='verifikasiData("<?php echo encrypt_decrypt('encrypt', $value->id); ?>",0)' class="btn btn-primary" id="btn-verifikasi-tidak-<?php echo $value->id; ?>" style="display: none;">Verifikasi</button>
								</div>

								<div class="form-group mb-0">
								  <button type="button" onclick='rekomendasiKategoriJenisPanganData("<?php echo encrypt_decrypt('encrypt', $value->id); ?>")' class="btn btn-warning" id="btn-rekomendasi-kategori-jenis-pangan-<?php echo $value->id; ?>" style="display: none;">Rekomendasi Kategori Jenis Pangan</button>
								</div>

								<div class="form-group mb-0">
								  <button type="button" onclick='rekomendasiJenisPanganData("<?php echo encrypt_decrypt('encrypt', $value->id); ?>")' class="btn btn-warning" id="btn-rekomendasi-jenis-pangan-<?php echo $value->id; ?>" style="display: none;" >Rekomendasi Jenis Pangan</button>
								</div>

								<div class="form-group mb-0">
								  <button type="button" onclick='rekomendasiJenisKemasanData("<?php echo encrypt_decrypt('encrypt', $value->id); ?>")' class="btn btn-warning" id="btn-rekomendasi-jenis-kemasan-<?php echo $value->id; ?>" style="display: none;">Rekomendasi Jenis Kemasan</button>
								</div>

								<div class="form-group mb-0">
								  <button type="button" onclick='rekomendasiJumlahBtpData("<?php echo encrypt_decrypt('encrypt', $value->id); ?>")' class="btn btn-warning" id="btn-rekomendasi-jumlah-btp-<?php echo $value->id; ?>" style="display: none;">Rekomendasi Jumlah BTP</button>
								</div>

							</td>
							
						</tr>
						<?php } ?>
						<?php } ?>
						<tr>
						<td><?php if(isset($perubahan_sppirt) && $perubahan_sppirt>0 && $data['status_verifikasi_product']==1){?> <span class="badge badge-danger">Terjadi Perubahan Nomor SPPIRT dari <?php echo $data['no_sppirt_lama']; ?> menjadi  <?php echo $data['no_sppirt']; ?> </span> <?php } ?></td>
						<td colspan="2" class="text-right">
							
							<?php if($data['status_verifikasi_product']!=1 && $last_verifikasi>7){?>
							<button type="button" onclick='pemenuhanKomitmenData()' class="btn btn-success" id="btn-pemenuhan-komitmen">Pemenuhan Komitmen</button>
							<?php } ?>

							<?php if(isset($data['status_ptsp_product']) && $data['status_ptsp_product']=='0'){ ?>
								<button type="button" class="btn btn-warning">Sedang melakukan permohonan pembatalan</button>
							<?php } ?>

							<?php if(isset($data['status_verifikasi_product']) && $data['status_verifikasi_product']=='1'){ ?>
								<button type="button" class="btn btn-success">Telah selesai diverifikasi</button>
							<?php }?>

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
                <h5 class="modal-title" id="exampleModalLabel">Form Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 needs-validation" novalidate method="POST" action="<?php echo base_url().'backend/verifikasi-produk/pengajuan-pembatalan'; ?>" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label class="form-label">Alasan</label>
                        <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?php echo encrypt_decrypt('encrypt', $data['id_pengajuan']); ?>">
                        <input type="hidden" name="id_analisis_product" id="id_analisis_product">
                        <textarea class="form-control" name="alasan_pembatalan" id="alasan_pembatalan" style="height: 300px;"></textarea>
                    </div>
                    <div class="col-md-12" style="padding-top: 20px;">
                        <label class="form-label">Unggah Surat Rekomendasi Pembatalan</label>
                        <div class="btn-group" style="padding-bottom: 7px;">
							<button type="button" class="btn btn-primary" id="upload_button">
								<i class="fa fa-upload"></i>
								<span>Unggah Surat Rekomendasi Pembatalan</span>
							</button>
			            </div>
					    <input type="file" id="rekomendasi_pembatalan" name="rekomendasi_pembatalan" accept="application/pdf,application/,application/doc" onchange="changeName(this)" style="display: none;">
					    <br>
					    <span id="file-name"></span>
					    <h4 id="doc-template">Untuk contoh format surat rekomendasi pembatalan <a href="<?= base_url() ?>assets/backend/template_dokumen/contoh_format_pembatalan_dinkes.pdf" target="_blank"><br>Lihat Disini.</a></h4>
                    </div>
                    <div class="col-md-12">
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

<div class="modal fade" id="modal-form-kategori-jenis-pangan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Rekomendasi Kategori Jenis Pangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 needs-validation" novalidate method="POST" action="<?php echo base_url().'backend/verifikasi-produk/rekomendasi-kategori-jenis-pangan'; ?>">
                    <div class="col-md-12">
                        <label class="form-label">Kategori Jenis Pangan</label>
                        <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?php echo encrypt_decrypt('encrypt', $data['id_pengajuan']); ?>">
                        <input type="hidden" name="id_analisis_product" id="id_analisis_product2">
                        <select class="form-control" name="kode_kategori_jenis_pangan">
                        	<option>Pilih ...</option>
                        	<?php foreach ($kategori_jenis_pangan as $key => $value) { ?>
                        		<option value="<?php echo $value->kode_kategori_jenis_pangan; ?>"><?php echo $value->nama_kategori_jenis_pangan; ?></option>
                        	<?php } ?>
                        </select>
                    </div>
                    <div class="col-md-12">
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

<div class="modal fade" id="modal-form-jenis-pangan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Rekomendasi Jenis Pangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 needs-validation" novalidate method="POST" action="<?php echo base_url().'backend/verifikasi-produk/rekomendasi-jenis-pangan'; ?>">
                    <div class="col-md-12">
                        <label class="form-label">Jenis Pangan</label>
                        <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?php echo encrypt_decrypt('encrypt', $data['id_pengajuan']); ?>">
                        <input type="hidden" name="id_analisis_product" id="id_analisis_product3">
                        <select class="form-control" name="id_jenis_pangan">
                        	<option>Pilih ...</option>
                        	<?php foreach ($jenis_pangan as $key => $value) { ?>
                        		<option value="<?php echo $value->id_jenis_pangan; ?>"><?php echo $value->nama_jenis_pangan; ?></option>
                        	<?php } ?>
                        </select>
                    </div>
                    <div class="col-md-12">
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

<div class="modal fade" id="modal-form-jumlah-btp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Rekomendasi Jumlah BTP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 needs-validation" novalidate method="POST" action="<?php echo base_url().'backend/verifikasi-produk/rekomendasi-jumlah-btp'; ?>">
                    <div class="col-md-12">
                        <label class="form-label">Rekomendasikan jumlah BTP yang digunakan di bawah batas maksimal</label>
                        <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?php echo encrypt_decrypt('encrypt', $data['id_pengajuan']); ?>">
                        <input type="hidden" name="id_analisis_product" id="id_analisis_product4">
                        <textarea class="form-control" name="notes" id="notes" style="height: 300px;"></textarea>
                    </div>
                    <div class="col-md-12">
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

<div class="modal fade" id="modal-form-jenis-kemasan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Rekomendasi Jenis Kemasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 needs-validation" novalidate method="POST" action="<?php echo base_url().'backend/verifikasi-produk/rekomendasi-jenis-kemasan'; ?>">
                    <div class="col-md-12">
                        <label class="form-label">Jenis Kemasan</label>
                        <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?php echo encrypt_decrypt('encrypt', $data['id_pengajuan']); ?>">
                        <input type="hidden" name="id_analisis_product" id="id_analisis_product5">
                        <select class="form-control" name="id_jenis_kemasan">
                        	<option>Pilih ...</option>
                        	<?php foreach ($jenis_kemasan as $key => $value) { ?>
                        		<option value="<?php echo $value->id_jenis_kemasan; ?>"><?php echo $value->nama_kemasan; ?></option>
                        	<?php } ?>
                        </select>
                    </div>
                    <div class="col-md-12">
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

<script>

	function approveData(id) {
	    swal({
	        title: 'Are you sure?',
	        text: "Anda yakin akan menyetujui pembatalan ini?",
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes'
	    }).then((result) => {
	        if (result.value) {
	            window.location.href = "<?php echo base_url('backend/verifikasi-produk/approve/'); ?>"+id;
	        }
	    })
	}

	function rejectData(id) {
	    swal({
	        title: 'Are you sure?',
	        text: "Anda yakin akan menolak pembatalan ini?",
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes'
	    }).then((result) => {
	        if (result.value) {
	            window.location.href = "<?php echo base_url('backend/verifikasi-produk/cancel/'); ?>"+id;
	        }
	    })
	}

	function pemenuhanKomitmenData() {
	    swal({
	        title: 'Are you sure?',
	        text: "Anda yakin akan memenuhi komitmen ini?",
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes'
	    }).then((result) => {
	        if (result.value) {
	            window.location.href = "<?php echo base_url('backend/verifikasi-produk/pemenuhan-komitmen/'.encrypt_decrypt('encrypt', $data['id_pengajuan'])); ?>";
	        }
	    })
	}

	function verifikasiData(id,hasil_verifikasi) {
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
	            window.location.href = "<?php echo base_url('backend/verifikasi-produk/verifikasi-data/'.encrypt_decrypt('encrypt', $data['id_pengajuan']).'/'); ?>"+hasil_verifikasi+'/'+id;
	        }
	    })
	}

	$('#upload_button').click(function(){ $('#rekomendasi_pembatalan').trigger('click'); });

	function changeName(input){
		var file_name = 'Selected File: '+ input.files[0].name;
		$("#file-name").html(file_name);
	}

	function pembatalanData(id){

	    $('#modal-form-pembataan').modal('show');
	    $('#id_analisis_product').val(id);
	    $('#alasan_pembatalan').val('');

	}

	function rekomendasiKategoriJenisPanganData(id){

	    $('#modal-form-kategori-jenis-pangan').modal('show');
	    $('#id_analisis_product2').val(id);

	}

	function rekomendasiJenisPanganData(id){

	    $('#modal-form-jenis-pangan').modal('show');
	    $('#id_analisis_product3').val(id);

	}

	function rekomendasiJumlahBtpData(id){

	    $('#modal-form-jumlah-btp').modal('show');
	    $('#id_analisis_product4').val(id);
	    $('#notes').val('');

	}

	function rekomendasiJenisKemasanData(id){

	    $('#modal-form-jenis-kemasan').modal('show');
	    $('#id_analisis_product5').val(id);

	}



	function closeModal(){
	    $('#modal-form-pembataan').modal('hide');
	    $('#modal-form-kategori-jenis-pangan').modal('hide');
	    $('#modal-form-jenis-pangan').modal('hide');
	    $('#modal-form-jenis-kemasan').modal('hide');
	    $('#modal-form-jumlah-btp').modal('hide');
	    $('#id_analisis_product').val('');
	    $('#id_analisis_product2').val('');
	    $('#id_analisis_product3').val('');
	    $('#id_analisis_product4').val('');
	    $('#id_analisis_product5').val('');
	    $('#alasan_pembatalan').val('');
	    $('#notes').val('');
	}

	function selectYa(id,param){

		if(param=='VERIFIKASI'){

			$('#btn-verifikasi-ya-'+id).show();
			$('#btn-verifikasi-tidak-'+id).hide();
			$('#btn-pembatalan-'+id).hide();
			$('#btn-rekomendasi-jumlah-btp-'+id).hide();
			$('#btn-rekomendasi-kategori-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-kemasan-'+id).hide();

		}else if(param=='REKOMENDADI JUMLAH BTP'){

			$('#btn-verifikasi-ya-'+id).hide();
			$('#btn-verifikasi-tidak-'+id).hide();
			$('#btn-pembatalan-'+id).hide();
			$('#btn-rekomendasi-jumlah-btp-'+id).show();
			$('#btn-rekomendasi-kategori-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-kemasan-'+id).hide();

		}
		

	}

	function selectTidak(id,param){

		if(param=='VERIFIKASI'){

			$('#btn-verifikasi-ya-'+id).hide();
			$('#btn-verifikasi-tidak-'+id).show();
			$('#btn-pembatalan-'+id).hide();
			$('#btn-rekomendasi-jumlah-btp-'+id).hide();
			$('#btn-rekomendasi-kategori-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-kemasan-'+id).hide();

		}else if(param=='REKOMENDASI PEMBATALAN'){

			$('#btn-verifikasi-ya-'+id).hide();
			$('#btn-verifikasi-tidak-'+id).hide();
			$('#btn-pembatalan-'+id).show();
			$('#btn-rekomendasi-jumlah-btp-'+id).hide();
			$('#btn-rekomendasi-kategori-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-kemasan-'+id).hide();
			
		}else if(param=='REKOMENDASI KATEGORI JENIS PANGAN'){

			$('#btn-verifikasi-ya-'+id).hide();
			$('#btn-verifikasi-tidak-'+id).hide();
			$('#btn-pembatalan-'+id).hide();
			$('#btn-rekomendasi-jumlah-btp-'+id).hide();
			$('#btn-rekomendasi-kategori-jenis-pangan-'+id).show();
			$('#btn-rekomendasi-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-kemasan-'+id).hide();
			
		}else if(param=='REKOMENDASI JENIS PANGAN'){

			$('#btn-verifikasi-ya-'+id).hide();
			$('#btn-verifikasi-tidak-'+id).hide();
			$('#btn-pembatalan-'+id).hide();
			$('#btn-rekomendasi-jumlah-btp-'+id).hide();
			$('#btn-rekomendasi-kategori-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-pangan-'+id).show();
			$('#btn-rekomendasi-jenis-kemasan-'+id).hide();
			
		}else if(param=='REKOMENDASI JENIS KEMASAN'){

			$('#btn-verifikasi-ya-'+id).hide();
			$('#btn-verifikasi-tidak-'+id).hide();
			$('#btn-pembatalan-'+id).hide();
			$('#btn-rekomendasi-jumlah-btp-'+id).hide();
			$('#btn-rekomendasi-kategori-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-pangan-'+id).hide();
			$('#btn-rekomendasi-jenis-kemasan-'+id).show();
			
		}

	}

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
		    			url:`${base_url}backend/Pengawasan/rekomendasicancelIrtp/${id_pengajuan}`,
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