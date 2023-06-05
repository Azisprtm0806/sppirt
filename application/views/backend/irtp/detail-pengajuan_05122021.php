<div class="row">
	<div class="col-12 card">
		<!-- <div class="card-header">
			<h4>
				Tanggal Pengajuan IRTP : <?= date('d-m-Y H:i', strtotime($irtp->created_at)) ?>
			</h4>
		</div> -->
		<div class="card-body">
			<h4>Data Pelaku Usaha</h4>
			<hr>
			<div class="row text-dark">
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Nama	 </b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->nama ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Nama Usaha	</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->nama_usaha ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nik" class="col-sm-4 col-form-label"><b>NIK	  </b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->nik ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>NIB	  </b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->nib ?></p>
					    </div>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-2 col-form-label"><b>Alamat Usaha	</b></label>
					    <div class="col-sm-10">
					    	<p class="mt-1"><?= $irtp->alamat_usaha ?></p>
					    </div>
					</div>
				</div>
			</div>
			<div class="row text-dark">
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>No Telpon</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->no_telp ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Email	</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->email ?></p>
					    </div>
					</div>
				</div>
			</div>
			<h4 class="mt-4">Data Produk</h4>
			<hr>
			<div class="row text-dark">
				<div class="col-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-2 col-form-label"><b>Nama Produk Pangan	</b></label>
					    <div class="col-sm-10">
					    	<p class="mt-1" style="text-align: justify;"><?= $irtp->nama_produk_pangan ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Jenis Produk Pangan</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->nama_kategori_jenis_pangan ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Nama Jenis Pangan</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->nama_jenis_pangan ?></p>
					    </div>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-2 col-form-label"><b>Deskripsi Jenis Pangan	</b></label>
					    <div class="col-sm-10">
					    	<p class="mt-1" style="text-align: justify;"><?= $irtp->deskripsi ?></p>
					    </div>
					</div>
				</div>
			</div>
			<div class="row text-dark">
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Jenis Kemasan</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->nama_kemasan ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Proses Produksi</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->nama_proses_produksi ?></p>
					    </div>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-2 col-form-label"><b>Komposisi	</b></label>
					    <div class="col-sm-10">
					    	<p class="mt-1" style="text-align: justify;"><?= $irtp->komposisi ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Masa Simpan</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->masa_simpan.' '.ucfirst($irtp->jenis_simpan) ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-4 col-form-label"><b>Produk Ke?</b></label>
					    <div class="col-sm-8">
					    	<p class="mt-1"><?= $irtp->produk_ke ?></p>
					    </div>
					</div>
				</div>
			</div>
			<h4 class="mt-4">Data Label Produk</h4>
			<hr>
			<div class="row text-dark">
				<div class="col-lg-4">
					<div class="form-group">
					    <label for="nama" class="form-label"><b>Rancangan Label</b></label>
					    <br>
				    	<img src="<?= base_url('uploads/labelproduk/').$irtp->upload_rancangan ?>" width="250px" height="300px">
					</div>
				</div>
				<div class="col-lg-4 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Nama Produk</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $irtp->nama_produk == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Berat Bersih/Isi Bersih</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $irtp->isi_bersih == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Tanggal dan Kode Produksi</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $irtp->kode_produksi == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Informasi Nilai Gizi</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $irtp->informasi_nilai_gizi == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Keterangan Lainnya</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $irtp->kel_lainnya == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
				</div>
				<div class="col-lg-4 col-sm-12">
					<div class="form-group row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Komposisi</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $irtp->ket_komposisi == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Halal</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $irtp->halal == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Keterangan Kadaluarsa</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $irtp->ket_kadaluarsa == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
					<div class="form-group row">
					    <label for="nama" class="col-sm-10 col-form-label"><b>Asal Usul Bahan Tertentu</b></label>
					    <div class="col-sm-2">
					    	<p class="mt-1"><?= $irtp->asal_usul == 1 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></p>
					    </div>
					</div>
				</div>
			</div>
			<?php if ($irtp->status_pengajuan != 2): ?>
				<h4 class="mt-4">Alasan Penolakan</h4>
				<hr>
				<?php if ($irtp->status_pengajuan == 0): ?>
					<div class="alert alert-danger left-icon-big alert-dismissible fade show">
		                <div class="media">
		                  <div class="alert-left-icon-big">
		                    <span><i class="mdi mdi-close-octagon-outline"></i></span>
		                  </div>
		                  <div class="media-body">
		                    <h5 class="mt-1 mb-2">Pengajuan izin PIRT <strong class="text-danger"><i><u>DITOLAK</u></i></strong> karena tidak memenuhi kriteria produk yang telah ditetapkan.</h5>
		                    <p class="mb-0">Nomor izin PIRT tidak dapat diterbitkan</p>
		                  </div>
		                </div>
		            </div>
				<?php elseif($irtp->status_pengajuan == 1): ?>
					<!-- <div class="alert alert-warning solid alert-dismissible fade show">
			            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
			            Pengajuan IRTP <strong>ditolak</strong>  karena tidak memenuhi syarat label
			        </div> -->

			        <div class="alert alert-warning left-icon-big alert-dismissible fade show">
		                <div class="media">
		                  <div class="alert-left-icon-big">
		                    <span><i class="mdi mdi-alert-circle-outline"></i></span>
		                  </div>
		                  <div class="media-body">
		                    <h5 class="mt-1 mb-2">Pengajuan izin PIRT <strong><i><u>DITOLAK SEMENTARA</u></i></strong> karena tidak memenuhi syarat label yang telah ditetapkan.</h5>
		                    <p class="mb-0">Silahkan melakukan konsultasi dengan Dinas Kesehatan atau Badan POM. Data usulan PIRT dapat diperbaiki kembali setelah melakukan konsultasi.</p>
		                  </div>
		                </div>
		            </div>
				<?php endif ?>
			<?php endif ?>
		</div>
	</div>
</div>