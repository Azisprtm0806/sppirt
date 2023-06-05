<div class="row">
	<div class="col-12 text-right mb-2">
		<!--<a href="<?= base_url('backend/irtp') ?>" title="Buat Pengajuan IRTP" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Buat Pengajuan IRTP</a>-->
	</div>
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="dt-menu-pengawasan" class="display text-dark" width="100%">
						<thead>
							<tr>
								<th>No.</th>
								<th>No SPPIRT</th>
								<th>Masa Berlaku</th>
								<th>Nama Produk Pangan</th>
								<th>Jenis Pangan</th>
								<th>Kemasan</th>
								<!--<th>Masa Berlaku</th>-->
								<th>ID Izin OSS</th>
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
			<div class="modal-body text-dark" style="max-height: 65vh; overflow-y: auto;">
						
				<div class="row">
					<div class="col-lg-6 col-sm-12 form-group">
						<label for="status-produk"><b>Status Verifikasi Produk</b></label>
						<div id="status-produk"></div>
					</div>
					<div class="col-lg-6 col-sm-12 form-group">
						<label for="status-label"><b>Status Verifikasi Label</b></label>
						<div id="status-label"></div>
					</div>
					<div class="col-lg-6 col-sm-12 form-group">
						<label for="status-pkp"><b>Status Verifikasi PKP</b></label>
						<div id="status-pkp"></div>
					</div>
					<div class="col-lg-6 col-sm-12 form-group">
						<label for="status-cara-pembuatan"><b>Status Verifikasi Cara Pembuatan</b></label>
						<div id="status-cara-pembuatan"></div>
					</div>
				</div>
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
				"url": base_url + "backend/Pengawasan/getData",
				"type": "POST",
			},
			"columnDefs": [{
					targets: [0,-1],
					orderable: false
				},
				{
					targets: [-1, 0,1,2,3,4,5],
					class: 'text-nowrap text-center'
				}
			],
			"order": [],
		});
	}


	function ButtonDetailStatus(data)
	{
		id_pengajuan = $(data).attr('data-id')
		$.ajax({
			url:`${base_url}getRowDataIrtp/${id_pengajuan}`,
			dataType:"json",
			success:function(response){
				$('.modal-title').text(response.no_sppirt)
				if (response.produk == null) {
					var btnProduk = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-produk/${response.id_pengajuan}" title="Status Verifikasi Produk" class="btn btn-xs btn-primary"><span class="fa fa-clock-o"></span> Menunggu Verifikasi</a>`;
				}else if (response.produk == 0) {
					var btnProduk = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-produk/${response.id_pengajuan}" title="Status Verifikasi Produk" class="btn btn-xs btn-warning"><span class="fa fa-clock-o"></span> Verifikasi Belum Lengkap</a>`;

				}else{
					var btnProduk = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-produk/${response.id_pengajuan}" title="Status Verifikasi Produk" class="btn btn-xs btn-success"><span class="fa fa-check"></span> Telah Diverifikasi</a>`;

				}
				if (response.label == null) {
					var btnLabel = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-label/${response.id_pengajuan}" title="Status Verifikasi Label" class="btn btn-xs btn-primary"><span class="fa fa-clock-o"></span> Menunggu Verifikasi</a>`;
				}else if (response.label == 0) {
					var btnLabel = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-label/${response.id_pengajuan}" title="Status Verifikasi Label" class="btn btn-xs btn-warning"><span class="fa fa-clock-o"></span> Verifikasi Belum Lengkap</a>`;

				}else{
					var btnLabel = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-label/${response.id_pengajuan}" title="Status Verifikasi Label" class="btn btn-xs btn-success"><span class="fa fa-check"></span> Telah Diverifikasi</a>`;

				}
				if (response.pkp == null) {
					var btnPkp = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-pkp/${response.id_pengajuan}" title="Status Verifikasi PKP" class="btn btn-xs btn-primary"><span class="fa fa-clock-o"></span> Menunggu Verifikasi</a>`;
				}else if (response.pkp == 0) {
					var btnPkp = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-pkp/${response.id_pengajuan}" title="Status Verifikasi PKP" class="btn btn-xs btn-warning"><span class="fa fa-clock-o"></span> Verifikasi Belum Lengkap</a>`;

				}else{
					var btnPkp = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-pkp/${response.id_pengajuan}" title="Status Verifikasi PKP" class="btn btn-xs btn-success"><span class="fa fa-check"></span> Telah Diverifikasi</a>`;

				}
				if (response.cara_pembuatan == null) {
					var btnCaraPembuatan = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-cara-pembuatan/${response.id_pengajuan}" title="Status Verifikasi Cara Pembuatan" class="btn btn-xs btn-primary"><span class="fa fa-clock-o"></span> Menunggu Verifikasi</a>`;
				}else if (response.cara_pembuatan == 0) {
					var btnCaraPembuatan = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-cara-pembuatan/${response.id_pengajuan}" title="Status Verifikasi Cara Pembuatan" class="btn btn-xs btn-warning"><span class="fa fa-clock-o"></span> Verifikasi Belum Lengkap</a>`;

				}else{
					var btnCaraPembuatan = `<a target="_blank" href="${base_url}/backend/pengawasan/verifikasi-cara-pembuatan/${response.id_pengajuan}" title="Status Verifikasi Cara Pembuatan" class="btn btn-xs btn-success"><span class="fa fa-check"></span> Telah Diverifikasi</a>`;

				}
				$("#status-produk").html(btnProduk)
				$("#status-label").html(btnLabel)
				$("#status-pkp").html(btnPkp)
				$("#status-cara-pembuatan").html(btnCaraPembuatan)
				$("#modal-status").modal('show')
			}
		})
	}
</script>