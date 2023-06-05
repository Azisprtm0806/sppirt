<div class="row">
	<div class="col-12 card">
		<div class="card-body">
		<form method="post" action="<?php echo base_url()."backend/sertifikat-pkp/save"; ?>" id="form-verifikasi">
			<input type="hidden" name="nib" value="<?= encrypt_decrypt('encrypt',$data['nib']) ?>">
			<h4><b>Form Isi Sertifikat PKP</b></h4>
			<table class="table text-dark" width="100%">
				<tbody>
					<tr>
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">Nomor Sertifikat PKP <span style="color: red; font-size: 13px;">* (required)</span></label>
								<br>
								<input type="text" class="form-control" name="nomor_sertifikat_pkp" value="<?php echo isset($data['nomor_sertifikat_pkp'])?$data['nomor_sertifikat_pkp']:''; ?>" required>
							</div>
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">Link Sertifikat PKP</label>
								<br>
								<input type="text" class="form-control" id="link_pkp" onkeyup="return isUrl(event)" name="link_sertifikat_pkp" value="<?php echo isset($data['link_sertifikat_pkp'])?$data['link_sertifikat_pkp']:''; ?>">
							</div>
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="form-group">
								<label for="nomor_sertifikat">Tanggal Sertifikat PKP <span style="color: red; font-size: 13px;">* (required)</span></label>
								<br>
								<input type="date" name="tanggal_sertifikat_pkp" value="<?= $data['tanggal_sertifikat_pkp'] ?>" class="form-control" id="tanggal_sertifikat_pkp" placeholder="exp:2167343999" required>
							</div>
						</td>
						<td></td>
					</tr>
					<tr>
						<td class="text-right">
							<button type="submit" class="btn btn-primary" id="btn-verifikasi">Save</button>
						</td>
					</tr>
				</tbody>
			</table>
		</form>

		</div>
	</div>
</div>

<script type="text/javascript">
	function isUrl(e) {
		var text = e.target.value;
		let val_1 = text.substring(0, 1); 
		let val_2 = text.substring(1, 2); 
		let val_3 = text.substring(2, 3); 
		let val_4 = text.substring(3, 4); 
		let val_5 = text.substring(4, 5); 
		let val_6 = text.substring(5, 6); 
		let val_7 = text.substring(6, 7); 

		var cek = true;

		if(val_1.toLowerCase()!='h' && val_1.toLowerCase()!=''){
		    cek = false;
		}

		if(val_2.toLowerCase()!='t' && val_2.toLowerCase()!=''){
		    cek = false;
		}

		if(val_3.toLowerCase()!='t' && val_3.toLowerCase()!=''){
		    cek = false;
		}

		if(val_4.toLowerCase()!='p' && val_4.toLowerCase()!=''){
		    cek = false;
		}

		if((val_5.toLowerCase()!=':' && val_5.toLowerCase()!='') && (val_5.toLowerCase()!='s' && val_5.toLowerCase()!='')){
		    cek = false;
		}

		if((val_6.toLowerCase()!='/' && val_6.toLowerCase()!='') && (val_6.toLowerCase()!=':' && val_6.toLowerCase()!='')){
		    cek = false;
		}

		if((val_7.toLowerCase()!='/' && val_7.toLowerCase()!='') && (val_7.toLowerCase()!='/' && val_7.toLowerCase()!='')){
		    cek = false;
		}


		if(cek==false){
		    e.target.value = "";
		    Swal({
		      type: 'error',
		      title: 'Oops...',
		      text: "url harus mengandung http:// atau https://",
		    });
		    return false;
		}

	}
</script>