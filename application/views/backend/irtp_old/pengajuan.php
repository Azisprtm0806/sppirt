
<div class="row">
    <div class="col-xl-12 col-xxl-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Pengajuan IRTP</h4>
        </div>
        <div class="card-body">
          <form action="#" id="step-form-horizontal" class="step-form-horizontal">
            <div>
              <h4>Data Pelaku Usaha</h4>
              <section>
                <div class="row">
                  <div class="col-lg-6 mb-2">
                    <div class="form-group">
                      <label class="text-label">Nama Pelaku Usaha*</label>
                      <input type="text" class="form-control" id="nama_pelaku_usaha" value="<?= $pelakuusaha['nama_penanggung_jwb'] ?>"  placeholder="" required>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-2">
                    <div class="form-group">
                      <label class="text-label">NIK*</label>
                      <input type="text" class="form-control" id="nik"  maxlength="16" minlength="16" value="<?= $pelakuusaha['nik_penanggung_jwb'] ?>" placeholder="" required>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-2">
                    <div class="form-group">
                      <label class="text-label">Nama Usaha*</label>
                      <input type="text" class="form-control" id="nama_usaha" value="<?= $pelakuusaha['nama_perseroan'] ?>" placeholder="" required>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-2">
                    <div class="form-group">
                      <label class="text-label">NIB*</label>
                      <input type="text" class="form-control" id="nib" readonly value="<?= $pelakuusaha['nib'] ?>" placeholder="" required>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-2">
                    <div class="form-group">
                      <label class="text-label">Provinsi*</label>
                      <select name="id_prov" id="id_prov" class="form-control" >
                      	<option value="">Pilih...</option>
                      	<?php foreach ($provinsi as $prov): ?>
                      		<option value="<?= $prov['id_prov'] ?>" <?= $prov['id_prov'] == $this->session->userdata('userData')['id_prov'] ? 'selected' : '' ?>><?= $prov['nama_prov'] ?></option>
                      	<?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-2">
                    <div class="form-group">
                      <label class="text-label">Kab/Kota*</label>
                      <select name="id_kota" id="id_kota" class="form-control" >
                      	<option value="">Pilih...</option>
                      	<?php foreach ($kota as $kabkota): ?>
                      		<option value="<?= $kabkota['id_kota'] ?>" <?= $kabkota['id_kota'] == $this->session->userdata('userData')['id_kota'] ? 'selected' : '' ?>><?= $kabkota['nama_kota'] ?></option>
                      	<?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-2">
                    <div class="form-group">
                      <label class="text-label">No Telpon*</label>
                      <input type="text" name="no_telp" class="form-control" value="<?= $this->session->userdata('userData')['phone'] ?>" placeholder="">
                    </div>
                  </div>
                  <div class="col-lg-6 mb-2">
                    <div class="form-group">
                      <label class="text-label">Email*</label>
                      <input type="email" name="email" class="form-control" value="<?= $this->session->userdata('userData')['email'] ?>">
                    </div>
                  </div>
                </div>
              </section>
              <h4>Data Produk</h4>
              <section>
                <div class="row">
                	<div class="col-lg-6">
                		<div class="form-group">
                		  <label class="text-label">Jenis Produk Pangan*</label>
                		  <select name="id_kategori_jenis_pangan" id="id_kategori_jenis_pangan" class="form-control" >
                		  	<option value="">Pilih...</option>
                		  	<?php foreach ($kategorijenispangan as $jenis): ?>
                		  		<option value="<?= $jenis['id_kategori_jenis_pangan'] ?>"><?= $jenis['nama_kategori_jenis_pangan'] ?></option>
                		  	<?php endforeach ?>
                		  </select>
                		</div>
                		<div class="form-group">
                		  <label class="text-label">Nama Jenis Pangan*</label>
                		  <div id="show-jenis-pangan">
                		  	<select name="id_jenis_pangan" class="form-control">
                		  		<option value="">Pilih Kategori Jenis Pangan Terlebih Dahulu</option>
                		  	</select>
                		  </div>
                		</div>
                		<div class="form-group">
	                      <label class="text-label">Jenis Kemasan*</label>
	                      <select name="id_jenis_kemasan" id="id_jenis_kemasan" class="form-control" >
	                      	<option value="">Pilih...</option>
	                      	<?php foreach ($jeniskemasan as $kemasan): ?>
	                      		<option value="<?= $kemasan['id_jenis_kemasan'] ?>"><?= $kemasan['nama_kemasan'] ?></option>
	                      	<?php endforeach ?>
	                      </select>
	                    </div>
                		<div class="form-group">
	                      <label class="text-label">Komposisi*</label>
	                      <textarea name="komposisi" id="komposisi" class="form-control"></textarea>
	                    </div>
                	</div>
                	<div class="col-lg-6">
                		<div class="form-group">
                		  <label class="text-label">Proses Produksi*</label>
                		  <select name="id_proses_produksi" id="id_proses_produksi" class="form-control" >
                		  	<option value="">Pilih...</option>
                		  	<?php foreach ($prosesproduksi as $produksi): ?>
                		  		<option value="<?= $produksi['id_proses_produksi'] ?>"><?= $produksi['nama_proses_produksi'] ?></option>
                		  	<?php endforeach ?>
                		  </select>
                		</div>
                		<div class="form-group">
                		  <label class="text-label">Cara Penyimpanan*</label>
                		  <select name="id_penyimpanan" id="id_penyimpanan" class="form-control" >
                		  	<option value="">Pilih...</option>
                		  	<?php foreach ($carapenyimpanan as $penyimpanan): ?>
                		  		<option value="<?= $penyimpanan['id_penyimpanan'] ?>"><?= $penyimpanan['cara_penyimpanan'] ?></option>
                		  	<?php endforeach ?>
                		  </select>
                		</div>
                		<div class="row">
                			<div class="col-lg-6 mb-2">
            				<label class="text-label">Masa Simpan</label>
                			  <div class="form-group">
                			  	<select name="satuan_masa_simpan" class="form-control" id="satuan_masa_simpan">
                			  		<option value="">Pilih....</option>
                			  		<option value="Hari">Hari</option>
                			  		<option value="Minggu">Minggu</option>
                			  		<option value="Bulan">Bulan</option>
                			  		<option value="Tahun">Tahun</option>
                			  	</select>
                			    <!-- <input type="text" name="no_telp" class="form-control" value="<?= $this->session->userdata('userData')['phone'] ?>" placeholder=""> -->
                			  </div>
                			</div>
                			<div class="col-lg-6 mb-2">
            				<label class="text-label">Masa Simpan</label>
                			  <div class="form-group">
                			    <input type="number" min="0" name="masa_simpan" id="masa_simpan" class="form-control" >
                			  </div>
                			</div>
                		</div>
		    			<div class="form-group">
							<label class="text-label">Produk Ke?</label>
		    			   <input type="number" min="0" name="produk_ke" id="produk_ke" class="form-control" >
		    			</div>
                	</div>
                </div>
              </section>
              <h4>Label Produk</h4>
              <section>
                <div class="row">
                	<div class="col-12">
	                	<h5>Apakah label anda telah mencantumkan informasi berikut?</h5>
	                	<table class="table">
	                		<tbody>
	                			<tr>
	                				<td class="text-left">1. Nama Produk</td>
	                				<td class="text-right">
	                					<div class="form-group mb-0">
        					                <label class="radio-inline mr-3" for="nama_produk_ya"><input type="radio" name="nama_produk" id="nama_produk_ya"> Ya</label>
        					                <label class="radio-inline mr-3" for="nama_produk_tidak"><input type="radio" name="nama_produk" id="nama_produk_tidak"> Tidak</label>
        					            </div>
	                				</td>
	                			</tr>
	                			<tr>
	                				<td class="text-left">2. Komposisi</td>
	                				<td class="text-right">
	                					<!-- <input type="checkbox" name="komposisi" id="komposisi" value="ya"> Ya
	                					<input type="checkbox" name="komposisi" id="komposisi" value="tidak"> Tidak -->
	                					<div class="form-group mb-0">
	    					                <label class="radio-inline mr-3" for="komposisi_ya"><input type="radio" name="komposisi" id="komposisi_ya"> Ya</label>
	    					                <label class="radio-inline mr-3" for="komposisi_tidak"><input type="radio" name="komposisi" id="komposisi_tidak"> Tidak</label>
	    					            </div>
	                				</td>
	                			</tr>
	                			<tr>
	                				<td class="text-left">3. Berat bersih/isi bersih</td>
	                				<td class="text-right">
	                					<!-- <input type="checkbox" name="isi_bersih" id="isi_bersih" value="ya"> Ya
	                					<input type="checkbox" name="isi_bersih" id="isi_bersih" value="tidak"> Tidak -->
	                					<div class="form-group mb-0">
        					                <label class="radio-inline mr-3" for="isi_bersih_ya"><input type="radio" name="isi_bersih" id="isi_bersih_ya"> Ya</label>
        					                <label class="radio-inline mr-3" for="isi_bersih_tidak"><input type="radio" name="isi_bersih" id="isi_bersih_tidak"> Tidak</label>
        					            </div>
	                				</td>
	                			</tr>
	                			<tr>
	                				<td class="text-left">4. Halal</td>
	                				<td class="text-right">
	                					<!-- <input type="checkbox" name="halal" id="halal" value="ya"> Ya
	                					<input type="checkbox" name="halal" id="halal" value="tidak"> Tidak -->
	                					<div class="form-group mb-0">
        					                <label class="radio-inline mr-3" for="halal_ya"><input type="radio" name="halal" id="halal_ya"> Ya</label>
        					                <label class="radio-inline mr-3" for="halal_tidak"><input type="radio" name="halal" id="halal_tidak"> Tidak</label>
        					            </div>
	                				</td>
	                			</tr>
	                			<tr>
	                				<td class="text-left">5. Tanggal dan Kode Produksi</td>
	                				<td class="text-right">
	                					<!-- <input type="checkbox" name="tanggal_kode" id="tanggal_kode" value="ya"> Ya
	                					<input type="checkbox" name="tanggal_kode" id="tanggal_kode" value="tidak"> Tidak -->
	                					<div class="form-group mb-0">
        					                <label class="radio-inline mr-3" for="tanggal_kode_ya"><input type="radio" name="tanggal_kode" id="tanggal_kode_ya"> Ya</label>
        					                <label class="radio-inline mr-3" for="tanggal_kode_tidak"><input type="radio" name="tanggal_kode" id="tanggal_kode_tidak"> Tidak</label>
        					            </div>
	                				</td>
	                			</tr>
	                			<tr>
	                				<td class="text-left">6. Keterangan Kadaluarsa</td>
	                				<td class="text-right">
	                					<!-- <input type="checkbox" name="ket_kadaluarsa" id="ket_kadaluarsa" value="ya"> Ya
	                					<input type="checkbox" name="ket_kadaluarsa" id="ket_kadaluarsa" value="tidak"> Tidak -->
	                					<div class="form-group mb-0">
        					                <label class="radio-inline mr-3" for="ket_kadaluarsa_ya"><input type="radio" name="ket_kadaluarsa" id="ket_kadaluarsa_ya"> Ya</label>
        					                <label class="radio-inline mr-3" for="ket_kadaluarsa_tidak"><input type="radio" name="ket_kadaluarsa" id="ket_kadaluarsa_tidak"> Tidak</label>
        					            </div>
	                				</td>
	                			</tr>
	                			<tr>
	                				<td class="text-left">7. Asal usul bahan pangan tertentu</td>
	                				<td class="text-right">
	                					<!-- <input type="checkbox" name="asal_usul" id="asal_usul" value="ya"> Ya -->
	                					<!-- <input type="checkbox" name="asal_usul" id="asal_usul" value="tidak"> Tidak -->
	                					<div class="form-group mb-0">
        					                <label class="radio-inline mr-3" for="asal_usul_ya"><input type="radio" name="asal_usul" id="asal_usul_ya"> Ya</label>
        					                <label class="radio-inline mr-3" for="asal_usul_tidak"><input type="radio" name="asal_usul" id="asal_usul_tidak"> Tidak</label>
        					            </div>
	                				</td>
	                			</tr>
	                			<tr>
	                				<td class="text-left">9. Informasi Nilai Gizi </td>
	                				<td class="text-right">
	                					<!-- <input type="checkbox" name="info_gizi" id="info_gizi" value="ya"> Ya
	                					<input type="checkbox" name="info_gizi" id="info_gizi" value="tidak"> Tidak -->
	                					<div class="form-group mb-0">
        					                <label class="radio-inline mr-3" for="info_gizi_ya"><input type="radio" name="info_gizi" id="info_gizi_ya"> Ya</label>
        					                <label class="radio-inline mr-3" for="info_gizi_tidak"><input type="radio" name="info_gizi" id="info_gizi_tidak"> Tidak</label>
        					            </div>
	                				</td>
	                			</tr>
	                			<tr>
	                				<td class="text-left">9. Keterangan Lainnya</td>
	                				<td class="text-right">
	                					<!-- <input type="checkbox" name="ket_lain" id="ket_lain" value="ya"> Ya -->
	                					<!-- <input type="checkbo<div class="form-group mb-0">
        					                <label class="radio-inline mr-3" for="nama_produk_ya"><input type="radio" name="nama_produk" id="nama_produk_ya"> Ya</label>
        					                <label class="radio-inline mr-3" for="nama_produk_tidak"><input type="radio" name="nama_produk" id="nama_produk_tidak"> Tidak</label>
        					            </div>x" name="ket_lain" id="ket_lain" value="tidak"> Tidak -->
	                					<div class="form-group mb-0">
        					                <label class="radio-inline mr-3" for="ket_lain_ya"><input type="radio" name="ket_lain" id="ket_lain_ya"> Ya</label>
        					                <label class="radio-inline mr-3" for="ket_lain_tidak"><input type="radio" name="ket_lain" id="ket_lain_tidak"> Tidak</label>
        					            </div>
	                				</td>
	                			</tr>
	                			<tr>
	                				<td class="text-left">10. Upload Rancangan Label</td>
	                				<td class="text-right">
	                					<input type="file" name="rancangan" id="rancangan" placeholder="">
	                				</td>
	                			</tr>
	                		</tbody>
	                	</table>
                	</div>
                </div>
              </section>
              <h4>Email Setup</h4>
              <section>
                <div class="row emial-setup">
                  <div class="col-sm-3 col-6">
                    <div class="form-group">
                      <label for="mailclient11" class="mailclinet mailclinet-gmail">
                        <input type="radio" name="emailclient" id="mailclient11">
                        <span class="mail-icon">
                          <i class="mdi mdi-google-plus" aria-hidden="true"></i>
                        </span>
                        <span class="mail-text">I'm using Gmail</span>
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-3 col-6">
                    <div class="form-group">
                      <label for="mailclient12" class="mailclinet mailclinet-office">
                        <input type="radio" name="emailclient" id="mailclient12">
                        <span class="mail-icon">
                          <i class="mdi mdi-office" aria-hidden="true"></i>
                        </span>
                        <span class="mail-text">I'm using Office</span>
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-3 col-6">
                    <div class="form-group">
                      <label for="mailclient13" class="mailclinet mailclinet-drive">
                        <input type="radio" name="emailclient" id="mailclient13">
                        <span class="mail-icon">
                          <i class="mdi mdi-google-drive" aria-hidden="true"></i>
                        </span>
                        <span class="mail-text">I'm using Drive</span>
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-3 col-6">
                    <div class="form-group">
                      <label for="mailclient14" class="mailclinet mailclinet-another">
                        <input type="radio" name="emailclient" id="mailclient14">
                        <span class="mail-icon">
                          <i class="fa fa-question-circle-o"
                          aria-hidden="true"></i>
                        </span>
                        <span class="mail-text">Another Service</span>
                      </label>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-12">
                    <div class="skip-email text-center">
                      <p>Or if want skip this step entirely and setup it later</p>
                      <a href="javascript:void()">Skip step</a>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<script src="<?= base_url('assets/backend/') ?>public/vendor/jquery-steps/build/jquery.steps.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/backend/') ?>public/vendor/jquery-validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/backend/') ?>public/js/plugins-init/jquery.validate-init.js" type="text/javascript"></script>
<!-- <script src="<?= base_url('assets/backend/') ?>public/js/plugins-init/jquery-steps-init.js" type="text/javascript"></script> -->


<script>
	$('#id_kategori_jenis_pangan').change(function(){
		var id_kategori_jenis_pangan = $(this).val()
		$.ajax({
			url:`${base_url}backend/General/getJenisPangan/`+id_kategori_jenis_pangan,
			dataType:'json',
			success:function(response){
				var data = response.data
			        var html = `
			        <select name="id_kategori_jenis_pangan" class="form-control" id="id_kategori_jenis_pangan">
			        
			        <option value="">Pilih...</option>`;
			        for ( i = 0 ; i < data.length ; i++ )
	                {
                       html += `<option value="${data[i].id_jenis_pangan}">${data[i].nama_jenis_pangan}</option>`;  
	                }
	               html += `</select>`;
			        $('#show-jenis-pangan').html(html);
			}
		})
	})

	
	var form = $("#step-form-horizontal");
	    form.children('div').steps({
	        headerTag: "h4",
	        bodyTag: "section",
	        transitionEffect: "slideLeft",
	        autoFocus: true,
	        transitionEffect: "slideLeft",
	        onStepChanging: function(event, currentIndex, newIndex) {
	        	console.log(event)
	            form.validate().settings.ignore = ":disabled,:hidden";
	            return form.valid();
	        }
	    });
</script>