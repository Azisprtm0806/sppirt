<div class="row">
	<div class="col-12 text-right mb-2">
	</div>
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
			        <table id="dt-menu-sppirt" class="display" width="100%">
    					<thead>
    						<tr>
    							<!-- <th>No.</th> -->
    							<!-- <th>No SPPIRT</th> -->
    						<!-- 	<th>Nama Produk Pangan</th>
    							<th>Jenis Pangan</th>
    							<th>Kemasan</th>
    							<th>ID Izin OSS</th>
    							<th>Status</th>
    							<th>Status OSS</th>
    							<th>Aksi</th> -->
    							<th>No.</th>
                                <!-- <th>No SPPIRT</th> -->
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


<script>
	$(document).ready(function(){
		loadData()
	})
	function loadData()
	{
		dt = $('#dt-menu-sppirt').DataTable({
	      //   "processing": true,
	      // "serverSide": true,

	        "processing": true,
	        "serverSide": true,
	        "destroy":true,
	        "ajax": {
	            "url":base_url+"backend/Irtp/getData/1",
	            "type": "POST",
	        },
	        "columnDefs": [
	        {
	            targets : [-1,0],
	            orderable: false
	        },
	        {
	            targets : [-1,0],
	            class: 'text-nowrap text-center'
	        }
	        ],
	        "order" : [],
	      });
	}
</script>