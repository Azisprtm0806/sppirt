<div class="row text-dark">
	<div class="col-12 text-right mb-2">
		<!--<a href="<?= base_url('backend/irtp') ?>" title="Buat Pengajuan IRTP" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Buat Pengajuan IRTP</a>-->
	</div>
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12 form-group">
						<label for="">Status Verifikasi</label>
						<select name="status" id="status" class="form-control select2">
							<option value="">Semua</option>
							<option value="3">Menunggu Verifikasi</option>
							<option value="0">Verifikasi Belum Lengkap</option>
							<option value="1">Sudah Diverifikasi</option>
						</select>
					</div>
				</div>
				<div class="">
					<table id="dt-menu-monitoring" class="display text-dark table-responsive" width="100%">
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
                                <th>Status</th>
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

<div class="modal" id="modal-sppirt" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-center" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#f93">
        <h5 class="modal-title">Riwayat Perubahan Nomor SPPIRT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 id="no_baru">Nomor Baru:P-IRT 3036271010003-26</h5>
        <h5 id="no_lama">Nomor Lama:P-IRT 3036271010003-26</h5>
		<br>
		<p>Terdapat penyesuaian nomor urut pelaku usaha pada 4 digit terakhir nomor SPPIRT</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
	$(document).ready(function() {
		loadData()
	})
	function openmodal(no_baru,no_lama){

		$("#modal-sppirt").modal("show");
		$("#no_baru").html('Nomor Baru: '+no_baru);
		$("#no_lama").html('Nomor Lama: '+no_lama);
		
	}

	function loadData() {
		var status = $('#status').val();
		dt = $('#dt-menu-monitoring').DataTable({
			//   "processing": true,
			// "serverSide": true,
			"processing": true,
			"serverSide": true,
			"destroy": true,
			"ajax": {
				"url": base_url + "backend/Monitoring/getData",
				"type": "POST",
				"data":{
					status:status,
					jenis:'pembuatan'
				}
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

	$('#status').change(function(){
		loadData()
	})
</script>