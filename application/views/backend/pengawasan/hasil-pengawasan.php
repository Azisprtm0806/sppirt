<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="dt-menu-pengawasan" class="display text-dark" width="100%">
						<thead>
							<tr>
								<th>No.</th>
                                <th>No SPPIRT</th>
                                <th>Nama Branding</th>
                                <th>Produk Pangan</th>
                                <th>Wilayah</th>
                                <th>NIB</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status OSS</th>
                                <th>Aksi</th>
							</tr>
							<!-- <tr>
								<th>Produk</th>
								<th>Label</th>
								<th>PKP</th>
								<th>Cara Pembuatan</th>
							</tr> -->
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-status">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
				</button>
			</div>
			<div class="modal-body text-dark" style="max-height: 75vh; overflow-y: auto;">
				<table class="text-dark">
					<tbody>
						<tr>
							<th class="text-left data-produk">Data Produk</th>
						</tr>
						<tr>
							<td class="text-left data-produk">1. Apakah jenis pangan yang dipilih pelaku usaha sesuai dengan data pangan yang diproduksi? 
								<br>
								<div id="kategori_jenis_pangan" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-left data-produk">2. Apakah nama pangan yang dipilih pelaku usaha sudah sesuai dengan produk yang diproduksi?
								<br>
								<div id="jenis_pangan">
									
								</div>
								<div id="deskripsi_jenis_pangan" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-left data-label">Data Label</th>
						</tr>
						<tr>
							<td class="text-left data-label">1. Apakah nama pangan yang tertulis di label sesuai dengan yang dipilih pada pengisian data pangan? 
								<br>
								<div id="status_nama_produk" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-left data-label">2. Apakah komposisi yang tercantum pada label sudah menuliskan semua bahan baku yang digunakan? 
								<br>
								<div id="status_komposisi" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-left data-label">3. Apakah jenis satuan yang dipilih oleh pelaku usaha sesuai dengan produknya? 
								<br>
								<div id="status_jenis_pangan" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-left data-label">4. Apakah pada desain label pangan sudah mencantumkan Nama dan alamat produsen? 
								<br>
								<div id="status_nama_alamat" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-left data-label">5. Apakah pelaku usaha memiliki sertifikat halal? 
								<br>
								<div id="status_halal" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-left data-label">6. Apakah pelaku usaha sudah mencantumkan tanggal dan kode produksi pada rancangan label yang dikirim?
								<br>
								<div id="status_tgl_kode_produksi" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-left data-label">7. Apakah terdapat keterangan kedaluarsa pada rancangan label yang dikirimkan pelaku usaha ?
								<br>
								<div id="status_keterangan_kadaluarsa" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-left data-label">8. Jika pangan terdapat bahan baku yang mengandung babi atau bersumber dari babi apakah sudah terdapat tanda peringatan pada rancangan labelnya?
								<br>
								<div id="status_asal_usul_bahan" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-left data-label">9. Apakah pelaku usaha sudah mencantumkan Informasi Nilai Gizi pada rancangan labelnya?
								<br>
								<div id="status_informasi_nilai_gizi" class="ml-3">
									
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-left data-pkp">Data PKP</th>
						</tr>
						<tr>
							<td class="text-left data-pkp">1. Apakah pelaku usaha sudah pernah mendapatkan Penyuluhan Keamanan Pangan?
								<br>
								<div id="status" class="">
									
								</div>
							</td>
						</tr>
						<tr>
							<th class="text-left data-pcp">Data Penerapan Cara Pembuatan Pangan yang Baik</th>
						</tr>
						<tr>
							<td class="text-left data-pcp">1. Apakah dalam 1 tahun terakhir pelaku usaha diperiksa sarananya?
								<br>
								<div id="status_pcp" class="">
									
								</div>
							</td>
						</tr>

					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		loadData()
	})

	function loadData() {
		dt = $('#dt-menu-pengawasan').DataTable({
			//   "processing": true,
			// "serverSide": true,
			"processing": true,
			"serverSide": true,
			"destroy": true,
			"ajax": {
				"url": base_url + "backend/Pengawasan/getHasilPengawasan",
				"type": "POST",
			},
			"columnDefs": [{
					targets: [0,-1],
					orderable: false
				},
				{
					targets: [-1, 0],
					class: 'text-nowrap text-center'
				}
			],
			"order": [],
		});
	}


	function ButtonDetailStatus(data)
	{
		$(".data-produk").hide()
		$(".data-label").hide()
		$(".data-pkp").hide()
		$(".data-pcp").hide()
		id_pengajuan = $(data).attr('data-id')
		$.ajax({
			url:`${base_url}backend/Pengawasan/getRowDataHasilPengawasan/${id_pengajuan}`,
			dataType:"json",
			success:function(response){
				if (response.status_verifikasi_produk) {
					$(".data-produk").show()
					var kategori_jenis_pangan = `
						${response.status_kategori_jenis_pangan == 0 ? "<b><u>Tidak</u></b> <br> <b>" + response.nama_kategori_jenis_pangan + "</b>" : "<b>Ya</b>" }
					`;

					var jenis_pangan = `
						${response.status_jenis_pangan == 0 ? "<b class='ml-3'><u>Tidak</u></b> <br> 3. Apakah pangannya sesuai dengan deskripsi pangan yang bisa mendapatkan SPP-IRT?" : "<b><u> Ya</u></b>" }
					`;
					var deskripsi_jenis_pangan = `
						${response.deskripsi_jenis_pangan == 0 ? "<b><u>Tidak</u></b> <br>" : "<b><u> Ya</u></b>" }
					`;
					$("#jenis_pangan").html(jenis_pangan)
					$("#kategori_jenis_pangan").html(kategori_jenis_pangan)
					$("#deskripsi_jenis_pangan").html(deskripsi_jenis_pangan)

				}

				if (response.status_verifikasi_label) {
					$(".data-label").show()
					var status_nama_produk = `
						${response.status_nama_produk == 0 ? "<b><u>Tidak</u></b> <br> <b> Saran : <br>" + response.saran_nama_produk + "</b>" : "<b>Ya</b>" }
					`;

					var status_komposisi = `
						${response.status_komposisi == 0 ? "<b><u>Tidak</u></b> <br> <b> Saran : <br>" + response.saran_komposisi + "</b>" : "<b>Ya</b>" }
					`;
					var status_jenis_pangan = `
						${response.status_jenis_pangan == 0 ? "<b><u>Tidak</u></b> <br> <b> Saran : <br>" + response.saran_berat_bersih + "</b>" : "<b>Ya</b>" }
					`;
					var status_nama_alamat = `
						${response.status_nama_alamat == 0 ? "<b><u>Tidak</u></b> <br> <b> Saran : <br>" + response.saran_nama_alamat + "</b>" : "<b>Ya</b>" }
					`;
					var status_halal = `
						${response.status_halal == 0 ? "<b><u>Tidak</u></b> <br> <b> Saran : <br>" + response.saran_halal + "</b>" : "<b>Ya</b>" }
					`;
					var status_tgl_kode_produksi = `
						${response.status_tgl_kode_produksi == 0 ? "<b><u>Tidak</u></b> <br> <b> Saran : <br>" + response.saran_tgl_kode_produksi + "</b>" : "<b>Ya</b>" }
					`;
					var status_keterangan_kadaluarsa = `
						${response.status_keterangan_kadaluarsa == 0 ? "<b><u>Tidak</u></b> <br> <b> Saran : <br>" + response.saran_keterangan_kadaluarsa + "</b>" : "<b>Ya</b>" }
					`;
					var status_asal_usul_bahan = `
						${response.status_asal_usul_bahan == 0 ? "<b><u>Tidak</u></b> <br> <b> Saran : <br>" + response.saran_asal_usul_bahan + "</b>" : "<b>Ya</b>" }
					`;
					if (response.asal_informasi_nilai_gizi == 1) {
						var asal_informasi_nilai_gizi = 'Dari Uji Laboratorium'; 
					}else if (response.asal_informasi_nilai_gizi == 2) {
						var asal_informasi_nilai_gizi = 'Perhitungan Sendiri'; 
					}else{
						var asal_informasi_nilai_gizi = 'Dari Peraturan Badan POM tentang Pencantuman Informasi Nilai Gizi untuk Pangan Olahan yang Diproduksi Oleh Usaha Mikro dan Usaha Kecil'; 
					}
					var status_informasi_nilai_gizi = `
						${response.status_informasi_nilai_gizi == 1 ? "<b>Ya</b> <br> <b> Asal Informasi Nilai Gizi : <br>" + asal_informasi_nilai_gizi + "</b>" : "<b><u>Tidak</u></b>" }
					`;

					$("#status_nama_produk").html(status_nama_produk)
					$("#status_komposisi").html(status_komposisi)
					$("#status_jenis_pangan").html(status_jenis_pangan)
					$("#status_nama_alamat").html(status_nama_alamat)
					$("#status_halal").html(status_halal)
					$("#status_tgl_kode_produksi").html(status_tgl_kode_produksi)
					$("#status_keterangan_kadaluarsa").html(status_keterangan_kadaluarsa)
					$("#status_asal_usul_bahan").html(status_asal_usul_bahan)
					$("#status_informasi_nilai_gizi").html(status_informasi_nilai_gizi)

				}

				if (response.status_verifikasi_pkp) {
					$(".data-pkp").show()
					if (response.status_pkp == 1) {
						var status = `
							<b class="ml-3">Sudah</b> 
							<br>
							2. Nomor Sertifikat
							<br>
							<b class="ml-3">
							${response.nomor_sertifikat}
							</b>
						`;
					}else{
						var status = `
							<b class="ml-3"><u>Belum</u></b> 
							<br>
							2. Jadwal Penyuluhan Keamanan Pangan
							<br>
							<b class="ml-3">
							${response.jadwal_pkp}
							</b>
						`;

					}

					$("#status").html(status);
				}

				if (response.status_verifikasi_cara_pembuatan) {
					$(".data-pcp").show()
					if (response.status == 1) {
						var status_pcp = `
							<b class="ml-3">Ya</b> 
							<br>
							2. Hasil Pemeriksaan
							<br>
							<b class="ml-3">
							${response.hasil_pemeriksaan}
							</b>
							<br>
							3. Level
							<br>
							<b class="ml-3">
							${response.level}
							</b>
						`;
					}else{
						var status_pcp = `
							<b class="ml-3"><u>Tidak</u></b> 
							<br>
							2. Jadwal Pemeriksaan Sarana
							<br>
							<b class="ml-3">
							${response.jadwal}
							</b>
							<br>
							3. Level
							<br>
							<b class="ml-3">
							${response.level}
							</b>
							<br>
							4. Berita Acara Pemeriksaan
							<a class="ml-3" target="_blank" href="${base_url}uploads/pengawasan/berita_acara/${response.berita_acara}" title=""></a>
							<br>
							4. Hasil Pembinaan
							<p class="ml-3" style="text-align:justify">${response.hasil_pembinaan}</p>
						`;

					}

					$("#status_pcp").html(status_pcp);
				}


				$('.modal-title').text(response.no_sppirt)
				$("#modal-status").modal('show')
			}
		})
	}
</script>