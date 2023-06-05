<?php $userData = $this->session->userdata('userData'); ?>
<link rel="stylesheet" href="sweetalert2.min.css">

<div class="row">
	<div class="col-12 text-right mb-2">

		<div class="form-row form_pelaku_usaha form_dinkes">
			<div class="form-group col-md-6">
				<a href="<?= base_url('export-excel') ?>" style="margin-top: 35px;float:left" class="btn btn-success mb-3"><i class="fa fa-file-excel-o" style="margin-right: 6px;"></i>Export Excel</a>
			</div>
			<div class="form-group col-md-3">

				<label>Provinsi</label>
				<select name="id_prov" class="form-control" id="id_provinsi" onchange="selectProvinsi()" <?php if ($userData['id_role']==3 || $userData['id_role']==4 || $userData['id_role']==5 || $userData['id_role']==8){ ?> disabled <?php } ?>>
            <option value="">Pilih ...</option>
            <?php foreach ($provinsi as $key => $value) { ?>
                <option value="<?php echo $value->id_prov; ?>" <?php if ((isset($_GET['id_prov']) && $_GET['id_prov'] == $value->id_prov) || (($userData['id_role']==3 || $userData['id_role']==4 || $userData['id_role']==5 || $userData['id_role']==8) && $userData['id_prov']==$value->id_prov)) { ?> selected <?php } ?>><?php echo $value->nama_prov; ?></option>
            <?php } ?>
        </select>

			</div>
			<div class="form-group col-md-3">
				<label>Kab/Kota</label>
				<select name="id_kota" class="form-control" id="id_kab_kota" <?php if ($userData['id_role']==3 || $userData['id_role']==4){ ?> disabled <?php } ?>>
					<?php if (isset($_GET['id_kota'])){ ?> <option value="<?php echo  $_GET['id_kota']; ?>" selected><?php echo  $_GET['id_kota']; ?></option> <?php } ?>
          <?php if ($userData['id_role']==3 || $userData['id_role']==4){ ?> 
              <option value="<?php echo  $userData['id_kota']; ?>" selected><?php echo  $userData['id_kota']; ?></option> 
          <?php } ?>
				</select>
			</div>
		</div>
		<!--<a href="<?= base_url('backend/irtp') ?>" title="Buat Pengajuan IRTP" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus"></i> Buat Pengajuan IRTP</a>-->
	</div>
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="dt-menu-sppirt" class="display" width="100%">
						<thead>
							<tr>
								<!-- <th>No.</th>
								<th>No SPPIRT</th>
								<th>Nama Produk Pangan</th>
								<th>Jenis Pangan</th>
								<th>Kemasan</th>
								<th>Masa Berlaku</th>
								<th>ID Izin OSS</th>
								<th>Status</th>
								<th>Status OSS</th>
								<th>Aksi</th> -->
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
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!--
<div class="modal" id="modal-pemberitahuan" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-center" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#f93">
        <h5 class="modal-title">INFO PENTING SPPIRT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Sehubungan dengan adanya pembenahan pemberian nomor urut pelaku usaha pada setiap kabupaten/kota maka terdapat perubahan nomor SPPIRT pada 4 digit terakhir (nomor urut pelaku usaha). Diharapkan pelaku usaha dapat menggunakan nomor SPPIRT baru yang telah disesuaikan. Demikian pemberitahuan ini, atas perhatian dan kerjasamanya diucapkan terimakasih. Mohon maklum.</p>
		<p><b>
		Jabat Erat,<br>
		SPPIRT Center BPOM RI
		</b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
-->
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
				<font color="red"><h5 id="no_baru">Nomor Baru:P-IRT 3036271010003-26</h5></font>
				<h5 id="no_lama">Nomor Lama:P-IRT 3036271010003-26</h5>
				<br>
				<p>Terdapat penyesuaian nomor urut pelaku usaha pada 4 digit terakhir nomor SPPIRT atau penyesuaian jumlah digit nomor SPPIRT</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-edit" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-center" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background:#f93">
				<h5 class="modal-title">Edit data SPPIRT </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">

				<input type="hidden" name="id_pengajuan" id="id_pengajuan" class="form-control" readonly>

				<label for="">NO SPPIRT LAMA (Salah/Kurang Digit)</label>
				<input type="text" name="no_sppirt_lama" id="no_sppirt_lama" class="form-control" readonly style="background-color: #ccc;">
				<br>
				<label for="">NO SPPIRT BARU (Pembenahan)</label>
				<input type="text" id="no_sppirt_baru" name="no_sppirt_baru" class="form-control">
				<br>
				<label for="">NAMA BRANDING (<font color="red"><i>Abaikan jika tidak ada perubahan</i></font>)</label>
				<input type="text" id="nama_produk_pangan" name="nama_produk_pangan" class="form-control">
				<br>
				<label for="">KETERANGAN (<font color="red"><i>Isikan tanda strip (-) jika tidak ada keterangan</i></font>)</label>
				<input type="text" id="keterangan" name="keterangan" class="form-control">


			</div>
			<div class="modal-footer">
				<input type="submit" name="simpan" id="simpan" onclick="save()" value="Simpan" class="btn btn-primary">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>

<script src="cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	var tableData = $("#dt-menu-sppirt");
	var simpan = $("#simpan");
	var formData = $("#formData");
	var modal = $("#modal-edit");
	$(document).ready(function() {
		loadData()
		$("#modal-pemberitahuan").modal("show");
	})

	function openmodal(no_baru, no_lama) {

		$("#modal-sppirt").modal("show");
		$("#no_baru").html('Nomor Baru: ' + no_baru);
		$("#no_lama").html('Nomor Lama: ' + no_lama);

	}

	function loadData() {
		dt = $('#dt-menu-sppirt').DataTable({
			//   "processing": true,
			// "serverSide": true,
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],


			"processing": true,
			"serverSide": true,
			"destroy": true,
			"ajax": {
				"url": base_url + "backend/Irtp/getData/2",
				"type": "POST",
				"data": function(data) {
					// Read values
					var id_prov = $('#id_provinsi').val();
					var id_kota = $('#id_kab_kota').val();

					// Append to data
					data.id_prov = id_prov;
					data.id_kota = id_kota;
				}
			},
			"columnDefs": [{
					targets: [-1, 0],
					orderable: false
				},
				{
					targets: [-1, 0],
					class: 'text-nowrap text-center'
				}
			],
			"order": [],
		});

		$('#id_provinsi').change(function() {
			dt.draw();
		});

		$('#id_kab_kota').change(function() {
			dt.draw();
		});

	}

	function selectProvinsi() {

		var id_provinsi = $('#id_provinsi').val();
		var id_kab_kota = $('#id_kab_kota').val();

		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>load-kab-kota",
			data: JSON.stringify({
				id_provinsi: id_provinsi,
				id_kab_kota: id_kab_kota
			}),
			contentType: "application/json; charset=utf-8",
			dataType: 'json',
			success: function(res) {
				$('#id_kab_kota').html(res.data)
			}

		})

	}
	selectProvinsi();

	function modalEdit(x) {
		$.ajax({
			type: "POST",
			url: "<?= base_url('backend/Irtp/ambilById'); ?>",
			data: 'id_pengajuan=' + x,
			dataType: 'json',
			success: function(hasil) {
				modal.modal("show")
				$('[name="id_pengajuan"]').val(hasil[0].id_pengajuan)
				$('[name="no_sppirt_lama"]').val(hasil[0].no_sppirt)
				$('[name="no_sppirt_baru"]').val(hasil[0].no_sppirt)
				$('[name="nama_produk_pangan"]').val(hasil[0].nama_produk_pangan)
			}
		})
	}

	function save() {
		var id_pengajuan = $('[name="id_pengajuan"]').val()
		var no_sppirt_lama = $('[name="no_sppirt_lama"]').val()
		var no_sppirt = $('[name="no_sppirt_baru"]').val()
		var nama_produk_pangan = $('[name="nama_produk_pangan"]').val()
		var keterangan = $('[name="keterangan"]').val()

		$.ajax({
			type: "POST",
			data: "id_pengajuan=" + id_pengajuan + "&no_sppirt_lama=" + no_sppirt_lama + "&no_sppirt_baru=" + no_sppirt + "&nama_produk_pangan=" + nama_produk_pangan + "&keterangan=" + keterangan,
			url: "<?= base_url('backend/Irtp/edit') ?>",
			dataType: 'json',
			success: function() {
				modal.modal("hide")
				Swal.fire({
					title: 'Berhasil',
					text: 'Data Berhasil Diupdate',
					type: 'success',
					showConfirmButton: false,
					timer: 3000
				})
				loadData()
			}
		})
	}
</script>