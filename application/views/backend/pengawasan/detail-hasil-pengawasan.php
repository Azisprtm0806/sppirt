<div class="row">
	<div class="col-12">
		<div class="card alert alert-primary" role="alert">
			<?= $title ?>
		</div>
	</div>
	<div class="col-12">
		<div id="accordion">
		  <div class="card">
		    <div class="card-header" id="headingOne">
		      <h5 class="mb-0">
		        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Pengawasan Produk dilakukan pada : <?= tanggal_indo(date('Y-m-d', strtotime($irtp['created_produk'])))." Jam ".date('H:i', strtotime($irtp['created_produk'])) ?></h6>

		        </button>
		      </h5>
		    </div>

		    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
		      <div class="card-body">
		        <div class="form-group">
		        	<label for="" class="text-dark">1. Apakah jenis pangan yang dipilih pelaku usaha sesuai dengan data pangan yang diproduksi?</label>
		        	<?php if ($irtp['status_kategori_jenis_pangan'] == 0): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Tidak Sesuai
		        			<br>
		        			Saran :
		        			<?= $irtp['nama_kategori_jenis_pangan'] ?>
		        		</p>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Sesuai</p>
		        	<?php endif ?>
		        </div>
		        <div class="form-group">
		        	<label for="" class="text-dark">2. Apakah nama pangan yang dipilih pelaku usaha sudah sesuai dengan produk yang diproduksi?</label>
		        	<?php if ($irtp['status_jenis_pangan'] == 0): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Tidak Sesuai
		        		</p>
		        		<label for="" class="text-dark">3. Apakah pangannya sesuai dengan deskripsi pangan yang bisa mendapatkan SPP-IRT?</label>
		        		<?php if ($irtp['deskripsi_jenis_pangan'] == 0): ?>
		        			<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Tidak Sesuai
		        			</p>
		        		<?php else: ?>
		        			<p class="ml-3 text-dark"><span class="fa fa-check text-success"></span> Sesuai
		        			</p>
		        		<?php endif ?>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Sesuai</p>
		        	<?php endif ?>
		        </div>
		      </div>
		    </div>
		  </div>
		  <div class="card">
		    <div class="card-header" id="headingTwo">
		      <h5 class="mb-0">
		        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						Pengawasan Label dilakukan pada : <?= tanggal_indo(date('Y-m-d', strtotime($irtp['created_label'])))." Jam ".date('H:i', strtotime($irtp['created_label'])) ?></h6>

		        </button>
		      </h5>
		    </div>
		    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
		      <div class="card-body">
		        <div class="form-group">
		        	<label for="" class="text-dark">1. Apakah nama pangan yang tertulis di label sesuai dengan yang dipilih pada pengisian data pangan?</label>
		        	<?php if ($irtp['status_nama_produk'] == 0): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Tidak Sesuai
		        			<br>
		        			Saran :
		        			<?= $irtp['saran_nama_produk'] ?>
		        		</p>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Sesuai</p>
		        	<?php endif ?>
		        </div>
		        <div class="form-group">
		        	<label for="" class="text-dark">2. Apakah komposisi yang tercantum pada label sudah menuliskan semua bahan baku yang digunakan?</label>
		        	<?php if ($irtp['status_komposisi'] == 0): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Tidak Tercantum
		        			<br>
		        			Saran :
		        			<?= $irtp['saran_komposisi'] ?>
		        		</p>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Tercantum</p>
		        	<?php endif ?>
		        </div>
		        <div class="form-group">
		        	<label for="" class="text-dark">3. Apakah jenis satuan yang dipilih oleh pelaku usaha sesuai dengan produknya?</label>
		        	<?php if ($irtp['status_berat_bersih'] == 0): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Tidak Sesuai
		        			<br>
		        			Saran :
		        			<?= $irtp['saran_berat_bersih'] ?>
		        		</p>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Sesuai</p>
		        	<?php endif ?>
		        </div>
		        <div class="form-group">
		        	<label for="" class="text-dark">4.  Apakah pada desain label pangan sudah mencantumkan Nama dan alamat produsen?</label>
		        	<?php if ($irtp['status_nama_alamat'] == 0): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Tidak Tercantum
		        			<br>
		        			Saran :
		        			<?= $irtp['saran_nama_alamat'] ?>
		        		</p>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Tercantum</p>
		        	<?php endif ?>
		        </div>
		        <div class="form-group">
		        	<label for="" class="text-dark">5.  Apakah pelaku usaha memiliki sertifikat halal?</label>
		        	<?php if ($irtp['status_halal'] == 0): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Belum Memiliki
		        			<br>
		        			Saran :
		        			<?= $irtp['saran_halal'] ?>
		        		</p>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Memiliki</p>
		        	<?php endif ?>
		        </div>
		        <div class="form-group">
		        	<label for="" class="text-dark">6.  Apakah pelaku usaha sudah mencantumkan tanggal dan kode produksi pada rancangan label yang dikirim?</label>
		        	<?php if ($irtp['status_tgl_kode_produksi'] == 0): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Belum Tercantum
		        			<br>
		        			Saran :
		        			<?= $irtp['saran_tgl_kode_produksi'] ?>
		        		</p>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Tercantum</p>
		        	<?php endif ?>
		        </div>
		        <div class="form-group">
		        	<label for="" class="text-dark">7.  Apakah terdapat keterangan kedaluarsa pada rancangan label yang dikirimkan pelaku usaha ?</label>
		        	<?php if ($irtp['status_keterangan_kadaluarsa'] == 0): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Belum Tercantum
		        			<br>
		        			Saran :
		        			<?= $irtp['saran_keterangan_kadaluarsa'] ?>
		        		</p>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Tercantum</p>
		        	<?php endif ?>
		        </div>
		        <div class="form-group">
		        	<label for="" class="text-dark">8.  Jika pangan terdapat bahan baku yang mengandung babi atau bersumber dari babi apakah sudah terdapat tanda peringatan pada rancangan labelnya?</label>
		        	<?php if ($irtp['status_asal_usul_bahan'] == 0): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Belum Tercantum
		        			<br>
		        			Saran :
		        			<?= $irtp['saran_asal_usul_bahan'] ?>
		        		</p>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Tercantum</p>
		        	<?php endif ?>
		        </div>
		        <div class="form-group">
		        	<label for="" class="text-dark">9.  Apakah pelaku usaha sudah mencantumkan Informasi Nilai Gizi pada rancangan labelnya?</label>
		        	<?php if ($irtp['status_asal_usul_bahan'] == 1): ?>
		        		<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Tercantum
		        			<br>
		        		</p>
		        		<label for="" class="text-dark">Dari mana didapatkan Informasi Nilai Gizi?</label>
		        		<p class="text-dark ml-3">
		        			<?php if ($irtp['asal_informasi_nilai_gizi'] == 1): ?>
		        				Dari Uji Laboratorium 
		        			<?php elseif($irtp['asal_informasi_nilai_gizi'] == 2): ?>
		        				Perhitungan Sendiri
		        				<div class="alert alert-danger" role="alert">
		        				    Peringatan:<br>
		        				    <i>Silahkan tutup Informasi Nilai Gizi pada label sampai memiliki hasil uji lab</i>
		        				  </div>
		        			<?php else: ?>
		        				Dari Peraturan Badan POM tentang Pencantuman Informasi Nilai Gizi untuk Pangan Olahan yang Diproduksi Oleh Usaha Mikro dan Usaha Kecil
		        			<?php endif ?>
		        		</p>
		        	<?php else: ?>
		        		<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Belum Tercantum</p>
		        	<?php endif ?>
		        </div>
		      </div>
		    </div>
		  </div>
		  <div class="card">
		    <div class="card-header" id="headingThree">
		      <h5 class="mb-0">
		        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						Pengawasan Penyuluhan Keamanan Pangan dilakukan pada : <?= tanggal_indo(date('Y-m-d', strtotime($irtp['created_pkp'])))." Jam ".date('H:i', strtotime($irtp['created_pkp'])) ?></h6>

		        </button>
		      </h5>
		    </div>
		    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
		      <div class="card-body">
		      	<div class="form-group">
		      		<label for="" class="text-dark">1. Apakah pelaku usaha sudah pernah mendapatkan Penyuluhan Keamanan Pangan?</label>
		      		<?php if ($irtp['status_pkp'] == 1): ?>
		      			<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Pernah</p>
		      			<label for="" class="text-dark">2. Nomor Sertifikat</label>
		      			<br>
		      			<p class="text-dark ml-3">
		      				<?= $irtp['nomor_sertifikat'] ?>
		      			</p>
		      		<?php else: ?>
		      			<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Belum Pernah</p>
		      			<label for="" class="text-dark">2. Jadwal Penyuluhan</label>
		      			<br>
		      			<p class="text-dark ml-3">
		      				<?= tanggal_indo($irtp['jadwal_pkp'],TRUE) ?>
		      			</p>
		      		<?php endif ?>
		      	</div>
		      </div>
		    </div>
		  </div>
		    <div class="card">
		      <div class="card-header" id="headingFour">
		        <h5 class="mb-0">
		          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
		  				Pengawasan Penerapan Cara Pembuatan Pangan yang Baik dilakukan pada : <?= tanggal_indo(date('Y-m-d', strtotime($irtp['created_cara_pembuatan'])))." Jam ".date('H:i', strtotime($irtp['created_cara_pembuatan'])) ?></h6>

		          </button>
		        </h5>
		      </div>
		      <div id="collapseFour" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
		        <div class="card-body">
		        	<div class="form-group">
		        		<label for="" class="text-dark">1. Apakah dalam 1 tahun terakhir pelaku usaha diperiksa sarananya??</label>
		        		<?php if ($irtp['status_cara_pembuatan'] == 1): ?>
		        			<p class="text-dark ml-3"><span class="fa fa-check text-success"></span> Sudah Diperiksa</p>
		        			<label for="" class="text-dark">2. Hasil Pemeriksaan</label>
		        			<br>
		        			<p class="text-dark ml-3">
		        				<?= $irtp['hasil_pemeriksaan'] ?>
		        			</p>
		        			<label for="" class="text-dark">3. Level</label>
		        			<br>
		        			<p class="text-dark ml-3">
		        				<?= $irtp['level'] ?>
		        			</p>
		        		<?php else: ?>
		        			<p class="text-dark ml-3"><span class="fa fa-times text-danger"></span> Belum Diperiksa</p>
		        			<label for="" class="text-dark">2. Jadwal Pemeriksaan Sarana</label>
		        			<br>
		        			<p class="text-dark ml-3">
		        				<?php if ($irtp['jadwal_cara_pembuatan'] == "0000-00-00"): ?>
		        					Belum Dilakukan Penjadwalan
		        				<?php else: ?>
			        				<?= tanggal_indo($irtp['jadwal_cara_pembuatan'], true) ?>
		        				<?php endif ?>
		        			</p>
		        			<label for="" class="text-dark">3. Level</label>
		        			<br>
		        			<p class="text-dark ml-3">
		        				<?= $irtp['level'] ?>
		        			</p>
		        			<label for="" class="text-dark">4. Berita Acara Pemeriksaan</label>
		        			<br>
		        			<p class="text-dark ml-3">
		        				<button type="button" class="btn btn-sm btn-primary" onclick="showBeritaAcara(this)" data-link="<?= base_url('assets/pengawasan/berita_acara/').$irtp['berita_acara'] ?>">Lihat Berita Acara</button>
		        			</p>

		        			<?php if ($irtp['level'] == 3 || $irtp['level'] == 4): ?>
		        				<label for="" class="text-dark">5. Hasil Pembinaan</label>
		        				<br>
		        				<p class="text-dark ml-3">
		        					<?= $irtp['hasil_pembinaan'] ?>
		        				</p>
		        			<?php endif ?>

		        		<?php endif ?>
		        	</div>
		        </div>
		      </div>
		    </div>
		</div>
	</div>

</div>

<!-- 
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
	function showBeritaAcara(data) {
		var link = $(data).data('link')


	}
</script> -->