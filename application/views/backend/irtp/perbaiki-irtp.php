
<style type="text/css" media="screen">
  .wizard-content-left {
    background-blend-mode: darken;
    background-color: rgba(0, 0, 0, 0.45);
    background-image: url("https://i.ibb.co/X292hJF/form-wizard-bg-2.jpg");
    background-position: center center;
    background-size: cover;
    height: 100vh;
    padding: 30px;
  }

  .wizard-content-left h1 {
    color: #ffffff;
    font-size: 38px;
    font-weight: 600;
    padding: 12px 20px;
    text-align: center;
  }

  .form-wizard {
    color: #888888;
    padding: 30px;
  }

  .form-wizard .wizard-form-radio {
    display: inline-block;
    margin-left: 5px;
    position: relative;
  }

  .form-wizard .wizard-form-radio input[type="radio"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    -o-appearance: none;
    appearance: none;
    background-color: #dddddd;
    height: 25px;
    width: 25px;
    display: inline-block;
    vertical-align: middle;
    border-radius: 50%;
    position: relative;
    cursor: pointer;
  }

  .form-wizard .wizard-form-radio input[type="radio"]:focus {
    outline: 0;
  }

  .form-wizard .wizard-form-radio input[type="radio"]:checked {
    background-color: #fb1647;
  }

  .form-wizard .wizard-form-radio input[type="radio"]:checked::before {
    content: "";
    position: absolute;
    width: 10px;
    height: 10px;
    display: inline-block;
    background-color: #ffffff;
    border-radius: 50%;
    left: 1px;
    right: 0;
    margin: 0 auto;
    top: 8px;
  }

  .form-wizard .wizard-form-radio input[type="radio"]:checked::after {
    content: "";
    display: inline-block;
    webkit-animation: click-radio-wave 0.65s;
    -moz-animation: click-radio-wave 0.65s;
    animation: click-radio-wave 0.65s;
    background: #000000;
    content: '';
    display: block;
    position: relative;
    z-index: 100;
    border-radius: 50%;
  }

  .form-wizard .wizard-form-radio input[type="radio"]~label {
    padding-left: 10px;
    cursor: pointer;
  }

  .form-wizard .form-wizard-header {
    text-align: center;
  }

  .form-wizard .form-wizard-next-btn,
  .form-wizard .form-wizard-previous-btn,
  .form-wizard .form-wizard-submit {
    background-color: #3a7afe;
    color: #ffffff;
    display: inline-block;
    min-width: 100px;
    min-width: 120px;
    padding: 10px;
    text-align: center;
  }

  .form-wizard .form-wizard-next-btn:hover,
  .form-wizard .form-wizard-next-btn:focus,
  .form-wizard .form-wizard-previous-btn:hover,
  .form-wizard .form-wizard-previous-btn:focus,
  .form-wizard .form-wizard-submit:hover,
  .form-wizard .form-wizard-submit:focus {
    color: #ffffff;
    opacity: 0.6;
    text-decoration: none;
  }

  .form-wizard .wizard-fieldset {
    display: none;
  }

  .form-wizard .wizard-fieldset.show {
    display: block;
  }

  .form-wizard .wizard-form-error {
    display: none;
    background-color: #d70b0b;
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 2px;
    width: 100%;
  }

  .form-wizard .form-wizard-previous-btn {
    background-color: #fb1647;
  }

  .form-wizard .form-control {
    font-weight: 300;
    height: auto !important;
    /*padding: 15px;*/
    /*color: #888888;*/
    /*background-color: #f1f1f1;*/
    /*border: none;*/
  }

  .form-wizard .form-control:focus {
    box-shadow: none;
  }

  .form-wizard .form-group {
    position: relative;
    /*margin: 25px 0;*/
  }

  .form-wizard .wizard-form-text-label {
    position: absolute;
    left: 10px;
    top: 16px;
    transition: 0.2s linear all;
  }

  .form-wizard .focus-input .wizard-form-text-label {
    color: #3a7afe;
    top: -18px;
    transition: 0.2s linear all;
    font-size: 12px;
  }

  .form-wizard .form-wizard-steps {
    margin: 30px 0;
  }

  .form-wizard .form-wizard-steps li {
    width: 20%;
    float: left;
    position: relative;
  }

  .form-wizard .form-wizard-steps li::after {
    background-color: #f3f3f3;
    content: "";
    height: 5px;
    left: 0;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    border-bottom: 1px solid #dddddd;
    border-top: 1px solid #dddddd;
  }

  .form-wizard .form-wizard-steps li span {
    background-color: #dddddd;
    border-radius: 50%;
    display: inline-block;
    height: 40px;
    line-height: 40px;
    position: relative;
    text-align: center;
    width: 40px;
    z-index: 1;
  }

  .form-wizard .form-wizard-steps li:last-child::after {
    width: 50%;
  }

  .form-wizard .form-wizard-steps li.active span,
  .form-wizard .form-wizard-steps li.activated span {
    background-color: #3a7afe;
    color: #ffffff;
  }

  .form-wizard .form-wizard-steps li.active::after,
  .form-wizard .form-wizard-steps li.activated::after {
    background-color: #3a7afe;
    left: 50%;
    width: 50%;
    border-color: #3a7afe;
  }

  .form-wizard .form-wizard-steps li.activated::after {
    width: 100%;
    border-color: #3a7afe;
  }

  .form-wizard .form-wizard-steps li:last-child::after {
    left: 0;
  }

  .form-wizard .wizard-password-eye {
    position: absolute;
    right: 32px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
  }

  @keyframes click-radio-wave {
    0% {
      width: 25px;
      height: 25px;
      opacity: 0.35;
      position: relative;
    }

    100% {
      width: 60px;
      height: 60px;
      margin-left: -15px;
      margin-top: -15px;
      opacity: 0.0;
    }
  }

  @media screen and (max-width: 767px) {
    .wizard-content-left {
      height: auto;
    }
  }

  .fit-image {
    width: 100%;
    object-fit: cover
  }
</style>
<div class="row">
  <div class="col-12 card">
    <div class="card-body">
      <section class="wizard-section">
        <div class="row no-gutters">
		  <div class="col-lg-12 col-md-12">
            <div class="form-wizard">
              <form class="form-pengajuan-irtp" role="form">
                <div class="form-wizard-header">
                  <p>Isi Semua Form Untuk Dapat Melanjutkan Ke Form Berikutnya</p>
                  <ul class="list-unstyled form-wizard-steps clearfix">
                    <li class="active"><span>1</span></li>
                    <li><span>2</span></li>
                    <li><span>3</span></li>
                    <li><span>4</span></li>
                    <li><span>5</span></li>
                  </ul>
                </div>
                <fieldset class="wizard-fieldset show" data-wizard="1">
                  <h5>Data Pelaku Usaha</h5>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="text-label">Nama Pelaku Usaha*</label>
                        <input type="hidden" name="id_pengajuan" value="<?= $irtp->id_pengajuan ?>" id="id_pengajuan">
                        <input type="hidden" name="id_input_label" value="<?= $irtp->id_input_label ?>" id="id_input_label">
                        <input type="hidden" name="id_input_data" value="<?= $irtp->id_input_data ?>" id="id_input_data">
                        <input type="text" readonly class="form-control wizard-required" nama="Nama Pelaku Usaha" id="nama_pelaku_usaha" name="nama_pelaku_usaha" value="<?= $pelakuusaha['nama_penanggung_jwb'] ?>" placeholder="" required>
                        <div class="text-danger"></div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="text-label">NIK*</label>
                        <input type="text" readonly class="form-control wizard-required" id="nik" nama="NIK" name="nik" maxlength="16" minlength="16" value="<?= $pelakuusaha['nik_penanggung_jwb'] ?>" placeholder="" required>
                        <div class="text-danger"></div>

                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="text-label">Nama Usaha*</label>
                        <input type="text" readonly class="form-control wizard-required" nama="Nama Usaha" id="nama_usaha" name="nama_usaha" value="<?= $pelakuusaha['nama_perseroan'] ?>" placeholder="" required>
                        <div class="text-danger"></div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="text-label">NIB*</label>
                        <input type="text" readonly class="form-control wizard-required" id="nib" nama="NIB" name="nib" readonly value="<?= $pelakuusaha['nib'] ?>" placeholder="" required>
                        <div class="text-danger"></div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="text-label">Provinsi*</label>
                        <select name="id_prov" id="id_prov" class="form-control wizard-required" disabled nama="Provinsi">
                          <option value="">Pilih...</option>
                          <?php foreach ($provinsi as $prov) : ?>
                            <option value="<?= $prov['id_prov'] ?>" <?= $prov['id_prov'] == $this->session->userdata('userData')['id_prov'] ? 'selected' : '' ?>><?= $prov['nama_prov'] ?></option>
                          <?php endforeach ?>
                        </select>
                        <div class="text-danger"></div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="text-label">Kab/Kota*</label>
                        <select name="id_kota" id="id_kota" class="form-control wizard-required" disabled nama="Kab/Kota">
                          <option value="">Pilih...</option>
                          <?php foreach ($kota as $kabkota) : ?>
                            <option value="<?= $kabkota['id_kota'] ?>" <?= $kabkota['id_kota'] == $this->session->userdata('userData')['id_kota'] ? 'selected' : '' ?>><?= $kabkota['nama_kota'] ?></option>
                          <?php endforeach ?>
                        </select>
                        <div class="text-danger"></div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="text-label">No Telpon*</label>
                        <input type="text" onkeypress="return isNumber(event)" name="no_telp" id="no_telp" class="form-control wizard-required" nama="No Telpon" value="<?= $this->session->userdata('userData')['phone'] ?>" placeholder="">
                        <div class="text-danger no_telp_error"></div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="text-label">Email*</label>
                        <input type="email" name="email" id="email" class="form-control wizard-required" nama="Email" value="<?= $this->session->userdata('userData')['email'] ?>">
                        <div class="text-danger email_error"></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group clearfix">
				  <span class="text-dark">Apabila data provinsi dan kabupaten/kota belum sesuai, silahkan diperbaiki melalui fitur <a href="<?= base_url('account')?>">update profile</a></span>
                    <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                  </div>
                </fieldset>
                <fieldset class="wizard-fieldset" data-wizard="2">
                  <h5>Data Produk</h5>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="text-label">Nama Produk Pangan</label>
                        <input type="text" name="nama_produk_pangan" id="nama_produk_pangan" value="<?= $irtp->nama_produk_pangan ?>" nama="Nama Produk Pangan" class="form-control wizard-required" placeholder="Nama Produk Pangan">
                        <div class="nama_produk_pangan_error text-danger"></div>
                      </div>
                      <div class="form-group">
                        <label class="text-label">Jenis Produk Pangan*</label>
                        <select name="id_kategori_jenis_pangan" id="id_kategori_jenis_pangan" nama="Jenis Produk Pangan" class="select2 form-control wizard-required">
                          <option value="">Pilih...</option>
                          <?php foreach ($kategorijenispangan as $jenis) : ?>
                            <option value="<?= $jenis['id_kategori_jenis_pangan'] ?>" <?= $irtp->id_kategori_jenis_pangan == $jenis['id_kategori_jenis_pangan'] ? 'selected' : ''; ?>><?= $jenis['nama_kategori_jenis_pangan'] ?></option>
                          <?php endforeach ?>
                        </select>
                        <div class="text-danger id_kategori_jenis_pangan_error"></div>
                      </div>
                      <div class="form-group">
                        <label class="text-label">Nama Jenis Pangan*</label>
                        <select name="id_jenis_pangan" id="id_jenis_pangan" nama="Nama Jenis Pangan" class="form-control select2 wizard-required">
                          <option value="">Pilih Kategori Jenis Pangan Terlebih Dahulu</option>
                        </select>
                        <div class="text-danger id_jenis_pangan_error"></div>
                      </div>
                      <div class="form-group" id="show-deskripsi-jenis-pangan">

                      </div>
                      <div class="form-group">
                        <label class="text-label">Jenis Kemasan*</label>
                        <select name="id_jenis_kemasan" id="id_jenis_kemasan" nama="Jenis Kemasan" class="form-control select2 wizard-required">
                          <option value="">Pilih...</option>
                          <?php foreach ($jeniskemasan as $kemasan) : ?>
                            <option value="<?= $kemasan['id_jenis_kemasan'] ?>" <?= $irtp->id_jenis_kemasan == $kemasan['id_jenis_kemasan'] ? 'selected' : ''; ?>><?= $kemasan['nama_kemasan'] ?></option>
                          <?php endforeach ?>
                        </select>
                        <div class="text-danger id_jenis_kemasan_error"></div>
                      </div>
                      <div class="form-group">
                        <label class="text-label">Isi Bersih<font color="red"><sup> *</sup></font></label>
                        <input type="text" name="isi_bersih_produk" id="isi_bersih_produk" nama="Isi Bersih Produk" class="form-control wizard-required isi_bersih_produk">
                        <!-- <input type="text" name="isi_bersih_produk" id="isi_bersih_produk" class="form-control"> -->
                        <div class="isi_bersih_produk_error text-danger"></div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="text-label">Proses Produksi*</label>
                        <select name="id_proses_produksi" id="id_proses_produksi" nama="Proses Poduksi" class="form-control select2 wizard-required">
                          <option value="">Pilih...</option>
                          <?php foreach ($prosesproduksi as $produksi) : ?>
                            <option value="<?= $produksi['id_proses_produksi'] ?>" <?= $irtp->id_proses_produksi == $produksi['id_proses_produksi'] ? 'selected' : ''; ?>><?= $produksi['nama_proses_produksi'] ?></option>
                          <?php endforeach ?>
                        </select>
                        <div class="text-danger id_proses_produksi_error"></div>
                      </div>
                      <div class="form-group">
                        <label class="text-label">Cara Penyimpanan*</label>
                        <select name="id_penyimpanan" id="id_penyimpanan" nama="Cara Penyimpanan" class="form-control select2 wizard-required">
                          <option value="">Pilih...</option>
                          <?php foreach ($carapenyimpanan as $penyimpanan) : ?>
                            <option value="<?= $penyimpanan['id_penyimpanan'] ?>" <?= $irtp->id_penyimpanan == $penyimpanan['id_penyimpanan'] ? 'selected' : ''; ?>><?= $penyimpanan['cara_penyimpanan'] ?></option>
                          <?php endforeach ?>
                        </select>
                        <div class="text-danger id_penyimpanan_error"></div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 mb-2">
                          <label class="text-label">Jenis Simpan*</label>
                          <div class="form-group">
                            <select name="satuan_masa_simpan" class="form-control wizard-required select2" nama="Jenis Simpan" id="satuan_masa_simpan">
                              <option value="">Pilih....</option>
                              <option value="hari" <?= $irtp->jenis_simpan == 'hari' ? 'selected' : '' ?>>Hari</option>
                              <option value="minggu" <?= $irtp->jenis_simpan == 'minggu' ? 'selected' : '' ?>>Minggu</option>
                              <option value="bulan" <?= $irtp->jenis_simpan == 'bulan' ? 'selected' : '' ?>>Bulan</option>
                              <option value="tahun" <?= $irtp->jenis_simpan == 'tahun' ? 'selected' : '' ?>>Tahun</option>
                            </select>
                            <!-- <input type="text" name="no_telp" class="form-control wizard-required" value="<?= $this->session->userdata('userData')['phone'] ?>" placeholder=""> -->
                            <div class="text-danger satuan_masa_simpan_error"></div>
                          </div>
                        </div>
                        <div class="col-lg-6 mb-2">
                          <div class="form-group">
                            <label class="text-label">Masa Simpan*</label>
                            <input type="number" min="0" name="masa_simpan" id="masa_simpan" value="<?= $irtp->masa_simpan ?>" nama="Masa Simpan" class="form-control wizard-required">
                            <div class="text-danger masa_simpan_error"></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="text-label">Produk Ke?</label>
                        <input type="number" min="0" name="produk_ke" id="produk_ke" value="<?= buatKode2($irtp->produk_ke,'',2) ?>" nama="Produk Ke?" class="form-control wizard-required">
                        <div class="text-danger produk_ke_error"></div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="text-label">Komposisi*</label>
                        <textarea name="komposisi" id="komposisi" nama="komposisi" class="form-control wizard-required"><?= $irtp->komposisi ?></textarea>
                        <div class="text-danger komposisi_error"></div>

                      </div>
                    </div>
                  </div>
                  <div class="form-group clearfix">
                    <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                    <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                  </div>
                </fieldset>
                <fieldset class="wizard-fieldset" data-wizard="3">
                  <h5>Label Produk</h5>
                  <div class="row">
                    <div class="col-12">
                      <h5>Apakah label anda telah mencantumkan informasi berikut?</h5>
                      <table class="table">
                        <tbody>
                          <tr>
                            <td class="text-left">1. Nama Produk <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="nama_produk_1"><input type="radio" <?= $irtp->nama_produk == '1' ? 'checked' : ''  ?> name="nama_produk" id="nama_produk_1" value="1"> Ya</label>
                                <label class="radio-inline" for="nama_produk_0"><input type="radio" <?= $irtp->nama_produk == '0' ? 'checked' : ''  ?> name="nama_produk" id="nama_produk_0" value="0"> Tidak</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left">2. Komposisi <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="ket_komposisi_1"><input type="radio" name="ket_komposisi" id="ket_komposisi_1" value="1" <?= $irtp->ket_komposisi == '1' ? 'checked' : ''  ?>> Ya</label>
                                <label class="radio-inline" for="ket_komposisi_0"><input type="radio" name="ket_komposisi" id="ket_komposisi_0" value="0" <?= $irtp->ket_komposisi == '0' ? 'checked' : ''  ?>> Tidak</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left">3. Berat bersih/isi bersih <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="isi_bersih_1"><input type="radio" <?= $irtp->isi_bersih == '1' ? 'checked' : ''  ?> name="isi_bersih" id="isi_bersih_1" value="1"> Ya</label>
                                <label class="radio-inline" for="isi_bersih_0"><input type="radio" <?= $irtp->isi_bersih == '0' ? 'checked' : ''  ?> name="isi_bersih" id="isi_bersih_0" value="0"> Tidak</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left">4. Halal <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="halal_1"><input type="radio" <?= $irtp->halal == '1' ? 'checked' : ''  ?> name="halal" id="halal_1" value="1"> Ya</label>
                                <label class="radio-inline" for="halal_0"><input type="radio" <?= $irtp->halal == '0' ? 'checked' : ''  ?> name="halal" id="halal_0" value="0"> Tidak</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left">5. Tanggal dan Kode Produksi <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="tgl_produksi_1"><input type="radio" <?= $irtp->tgl_produksi == '1' ? 'checked' : ''  ?> name="tgl_produksi" id="tgl_produksi_1" value="1"> Ya</label>
                                <label class="radio-inline" for="tgl_produksi_0"><input type="radio" <?= $irtp->tgl_produksi == '0' ? 'checked' : ''  ?> name="tgl_produksi" id="tgl_produksi_0" value="0"> Tidak</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left">6. Keterangan Kadaluarsa <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="ket_kadaluarsa_1"><input type="radio" <?= $irtp->ket_kadaluarsa == '1' ? 'checked' : ''  ?> name="ket_kadaluarsa" id="ket_kadaluarsa_1" value="1"> Ya</label>
                                <label class="radio-inline" for="ket_kadaluarsa_0"><input type="radio" <?= $irtp->ket_kadaluarsa == '0' ? 'checked' : ''  ?> name="ket_kadaluarsa" id="ket_kadaluarsa_0" value="0"> Tidak</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left">7. Asal usul bahan pangan tertentu <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="asal_usul_1"><input type="radio" <?= $irtp->asal_usul == '1' ? 'checked' : ''  ?> name="asal_usul" id="asal_usul_1" value="1"> Ya</label>
                                <label class="radio-inline" for="asal_usul_0"><input type="radio" <?= $irtp->asal_usul == '0' ? 'checked' : ''  ?> name="asal_usul" id="asal_usul_0" value="0"> Tidak</label>
                              </div>
                            </td>
                          </tr>
						  <tr>
                            <td class="text-left">8. Nama Produsen <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="nama_produsen_1"><input type="radio" <?= $irtp->nama_produsen == '1' ? 'checked' : ''  ?> name="nama_produsen" id="nama_produsen_1" value="1"> Ya</label>
                                <label class="radio-inline" for="nama_produsen_0"><input type="radio" <?= $irtp->nama_produsen == '0' ? 'checked' : ''  ?> name="nama_produsen" id="nama_produsen_0" value="0"> Tidak</label>
                              </div>
                            </td>
                          </tr>
						  <tr>
                            <td class="text-left">9. Alamat Produsen <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="alamat_produsen_1"><input type="radio" <?= $irtp->alamat_produsen == '1' ? 'checked' : ''  ?>  name="alamat_produsen" id="alamat_produsen_1" value="1"> Ya</label>
                                <label class="radio-inline" for="alamat_produsen_0"><input type="radio" <?= $irtp->alamat_produsen == '0' ? 'checked' : ''  ?> name="alamat_produsen" id="alamat_produsen_0" value="0"> Tidak</label>
                              </div>
                            </td>
                          </tr>
                          
                          <tr>
                            <td class="text-left">10. Informasi Nilai Gizi <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="informasi_nilai_gizi_1"><input type="radio" <?= $irtp->informasi_nilai_gizi == '1' ? 'checked' : ''  ?> name="informasi_nilai_gizi" id="informasi_nilai_gizi_1" value="1"> Ya</label>
                                <label class="radio-inline" for="informasi_nilai_gizi_0"><input type="radio" <?= $irtp->informasi_nilai_gizi == '0' ? 'checked' : ''  ?> name="informasi_nilai_gizi" id="informasi_nilai_gizi_0" value="0"> Tidak</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left">11. Keterangan Lainnya <font color="red"><sup>*</sup></font></td>
                            <td class="text-right">
                              <div class="form-group mb-0">
                                <label class="radio-inline" for="kel_lainnya_1"><input type="radio" <?= $irtp->kel_lainnya == '1' ? 'checked' : ''  ?> name="kel_lainnya" id="kel_lainnya_1" value="1">
                                  Ya</label>
                                <label class="radio-inline" for="kel_lainnya_0"><input type="radio" <?= $irtp->kel_lainnya == '0' ? 'checked' : ''  ?> name="kel_lainnya" id="kel_lainnya_0" value="0"> Tidak</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left">12. Upload Rancangan Label (Format file : <b>jpg, jpeg, png</b>) <font color="red"><sup>* Kosongkan jika tidak ada perubahan</sup></font></td>
                            <td class="text-right">
                              <input type="file" name="upload_rancangan" id="upload_rancangan" placeholder="">
                              <a href="<?= base_url('uploads/labelproduk/') . $irtp->upload_rancangan ?>" target="_BLANK" class="btn btn-warning"><?= $irtp->upload_rancangan ?></a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="form-group clearfix">
                    <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                    <a href="javascript:;" class="form-wizard-next-btn float-right">Next</a>
                  </div>
                </fieldset>
                <fieldset class="wizard-fieldset" data-wizard="4">
                  <h5>Konfirmasi</h5>
                  <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-12">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" <?= $irtp->status_konfirmasi == 1 ? 'checked' : '' ?> value="1" id="status_konfirmasi" name="status_konfirmasi" required>
                        <label class="custom-control-label" for="status_konfirmasi">Dengan ini saya menyatakan siap untuk memenuhi komitmen berupa:</label>
                        <p></p>
                        <ul>
                          <li>1. Mengikuti Penyuluhan Keamanan Pangan</li>
                          <li>2. Memenuhi persyaratan Cara Produksi Pangan yang Baik untuk Industri rumah Tangga (CPPB-IRT) atau higiene, sanitasi dan dokumentasi.</li>
                          <li>3. Memenuhi ketentuan label dan iklan pangan olahan.</li>
                        </ul><br>
                        <p>akan melaksanakannya dalam waktu 3 bulan.</p> <br>
                      </div>
                    </div>
                  </div>
                  <div class="form-group clearfix">
                    <a href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                    <a href="javascript:;" class="form-wizard-submit float-right">Submit</a>
                  </div>
                </fieldset>
                <fieldset class="wizard-fieldset" data-wizard="5">
                  <h5></h5>
                  <h2 class="purple-text text-center"><strong id="status"></strong></h2> <br>
                  <div class="row justify-content-center">
                    <div class="col-4" id="check"> </div>
                  </div> <br><br>
                  <div class="row justify-content-center">
                    <div class="col-8 text-center" id="msg">
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<?php $isi_bersih_produk = json_encode(explode(',', $irtp->isi_bersih_produk));?>
<script>
  jQuery(document).ready(function() {
    tagify.addTags(<?= $isi_bersih_produk ?>)
    $('#isi_bersih_produk').val(<?= $isi_bersih_produk ?>).trigger('change')
    var id_kategori_jenis_pangan = '<?= $irtp->id_kategori_jenis_pangan ?>'
    var id_jenis_pangan = '<?= $irtp->id_jenis_pangan ?>'
    loadJenisPangan(id_kategori_jenis_pangan, id_jenis_pangan)
    // click on next button
    jQuery('.form-wizard-next-btn').click(function() {
      var parentFieldset = jQuery(this).parents('.wizard-fieldset');
      var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
      var page = $(parentFieldset).attr('data-wizard')
      // console.log(page);
      var next = jQuery(this);
      var nextWizardStep = true;
      var emailValid = true;
      if (page == 3) {
        var formData = new FormData($('.form-pengajuan-irtp')[0]);
        $.ajax({
          url: `${base_url}backend/Irtp/cekLabel`,
          type: 'post',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          async:true,
          success: function(response){
            if (response.success) {
              nextWizardStep = true
              next.parents('.wizard-fieldset').removeClass("show", "400");
              currentActiveStep.removeClass('active').addClass('activated').next().addClass('active', "400");
              next.parents('.wizard-fieldset').next('.wizard-fieldset').addClass("show", "400");
              jQuery(document).find('.wizard-fieldset').each(function() {
                if (jQuery(this).hasClass('show')) {
                  var formAtrr = jQuery(this).attr('data-tab-content');
                  jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function() {
                    if (jQuery(this).attr('data-attr') == formAtrr) {
                      jQuery(this).addClass('active');
                      var innerWidth = jQuery(this).innerWidth();
                      var position = jQuery(this).position();
                      jQuery(document).find('.form-wizard-step-move').css({
                        "left": position.left,
                        "width": innerWidth
                      });
                    } else {
                      jQuery(this).removeClass('active');
                    }
                  });
                }
              });
            }else{
              error(response.msg)
              nextWizardStep = false
            }
          }
        });
      }else{
        parentFieldset.find('.wizard-required').each(function() {
          var thisName = jQuery(this).attr('name');
            if (thisName != undefined) {
              if(thisName == 'email'){
                var rs = $('#email').val();
                var atps=rs.indexOf("@");
                var dots=rs.lastIndexOf(".");
                if (atps<1 || dots<atps+2 || dots+2>=rs.length) {
                  emailValid = false;
                  nextWizardStep = false;
                }
              }else{
                  var thisValue = jQuery(`#${thisName.replace('[]','')}`).val();
                  // console.log(thisName, thisValue);
                  if (thisValue == "") {
                    var nama = $(`#${thisName.replace('[]','')}`).attr('nama');
                    // error(nama)
                    jQuery(`.${thisName.replace('[]','')}_error`).html(`<i class="fa fa-exclamation"></i> ${nama} belum diisi`).slideDown();
                    nextWizardStep = false;
                  } else {
                    if (thisName.replace('[]','') == 'nama_produk_pangan' && $(`.${thisName.replace('[]','')}_error`).text()) {
                      nextWizardStep = false;

                    }else{

                      jQuery(`.${thisName.replace('[]','')}_error`).html(``).slideDown();
                    }
                    
                  }
              }
            }

          // console.log(thisValue)
        });
            if (nextWizardStep) {
              next.parents('.wizard-fieldset').removeClass("show", "400");
              currentActiveStep.removeClass('active').addClass('activated').next().addClass('active', "400");
              next.parents('.wizard-fieldset').next('.wizard-fieldset').addClass("show", "400");
              jQuery(document).find('.wizard-fieldset').each(function() {
                if (jQuery(this).hasClass('show')) {
                  var formAtrr = jQuery(this).attr('data-tab-content');
                  jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function() {
                    if (jQuery(this).attr('data-attr') == formAtrr) {
                      jQuery(this).addClass('active');
                      var innerWidth = jQuery(this).innerWidth();
                      var position = jQuery(this).position();
                      jQuery(document).find('.form-wizard-step-move').css({
                        "left": position.left,
                        "width": innerWidth
                      });
                    } else {
                      jQuery(this).removeClass('active');
                    }
                  });
                }
              });
            } else {
              if(emailValid){
                error('Form Belum Terisi Semua')
              }else{
                error('Alamat email tidak valid.')
              }
            }

      }


    });
    //click on previous button
    jQuery('.form-wizard-previous-btn').click(function() {
      var counter = parseInt(jQuery(".wizard-counter").text());;
      var prev = jQuery(this);
      var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
      prev.parents('.wizard-fieldset').removeClass("show", "400");
      prev.parents('.wizard-fieldset').prev('.wizard-fieldset').addClass("show", "400");
      currentActiveStep.removeClass('active').prev().removeClass('activated').addClass('active', "400");
      jQuery(document).find('.wizard-fieldset').each(function() {
        if (jQuery(this).hasClass('show')) {
          var formAtrr = jQuery(this).attr('data-tab-content');
          jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function() {
            if (jQuery(this).attr('data-attr') == formAtrr) {
              jQuery(this).addClass('active');
              var innerWidth = jQuery(this).innerWidth();
              var position = jQuery(this).position();
              jQuery(document).find('.form-wizard-step-move').css({
                "left": position.left,
                "width": innerWidth
              });
            } else {
              jQuery(this).removeClass('active');
            }
          });
        }
      });
    });
    //click on form submit button
    jQuery('.form-wizard-submit').click(function() {

      var parentFieldset = jQuery(this).parents('.wizard-fieldset');
      var currentActiveStep = jQuery(this).parents('.form-wizard').find('.form-wizard-steps .active');
      var next = jQuery(this);
      var nextWizardStep = true;
      $('#id_prov').attr('disabled', false)
      $('#id_kota').attr('disabled', false)

      var val = $('#status_konfirmasi:checked').val()
      if (val) {
        var formData = new FormData($('.form-pengajuan-irtp')[0]);
        $.ajax({
          url: `${base_url}backend/Irtp/simpanPengajuan`,
          type: 'post',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {

            if (response.error) {
              error(response.msg)
            } else {
              next.parents('.wizard-fieldset').removeClass("show", "400");
              currentActiveStep.removeClass('active').addClass('activated').next().addClass('active', "400");
              next.parents('.wizard-fieldset').next('.wizard-fieldset').addClass("show", "400");
              jQuery(document).find('.wizard-fieldset').each(function() {
                if (jQuery(this).hasClass('show')) {
                  var formAtrr = jQuery(this).attr('data-tab-content');
                  jQuery(document).find('.form-wizard-steps .form-wizard-step-item').each(function() {
                    if (jQuery(this).attr('data-attr') == formAtrr) {
                      jQuery(this).addClass('active');
                      var innerWidth = jQuery(this).innerWidth();
                      var position = jQuery(this).position();
                      jQuery(document).find('.form-wizard-step-move').css({
                        "left": position.left,
                        "width": innerWidth
                      });
                    } else {
                      jQuery(this).removeClass('active');
                    }
                  });
                }
              });
              if (response.success) {
                $('#status').text('BERHASIL')
                $('#check').html(`<img src="https://i.imgur.com/GwStPmg.png" class="fit-image">`)
                $('#msg').text(response.msg)
              } else {
                $('#status').text('DITOLAK')
                $('#check').html(`<img src="${base_url}assets/backend/image/danger.png" class="fit-image">`)
                $('#msg').html(`<h5 class="purple-text text-center">${response.msg}</h5>`)
              }
            }

          }
        })
      }else{
        error('Pernyataan belum di ceklis')
      }
      
    });
    // focus on input field check empty or not
    jQuery(".form-control").on('focus', function() {
      var tmpThis = jQuery(this).val();
      if (tmpThis == '') {
        jQuery(this).parent().addClass("focus-input");
      } else if (tmpThis != '') {
        jQuery(this).parent().addClass("focus-input");
      }
    }).on('blur', function() {
      var tmpThis = jQuery(this).val();
      if (tmpThis == '') {
        jQuery(this).parent().removeClass("focus-input");
        jQuery(this).siblings('.wizard-form-error').slideDown("3000");
      } else if (tmpThis != '') {
        jQuery(this).parent().addClass("focus-input");
        jQuery(this).siblings('.wizard-form-error').slideUp("3000");
      }
    });
  });
  $('#id_kategori_jenis_pangan').change(function() {
    var id_kategori_jenis_pangan = $(this).val()
    loadJenisPangan(id_kategori_jenis_pangan)
  })

  function loadJenisPangan(id_kategori_jenis_pangan, id_jenis_pangan = null) {
    $.ajax({
      url: `${base_url}backend/General/getJenisPangan/` + id_kategori_jenis_pangan,
      dataType: 'json',
      success: function(response) {
        var data = response.data
        var html = `

     <option value="" data-desc="">Pilih...</option>`;
        for (i = 0; i < data.length; i++) {
          html += `<option value="${data[i].id_jenis_pangan}" data-desc="${data[i].deskripsi}" ${data[i].id_jenis_pangan == id_jenis_pangan ? 'selected' : ''}>${data[i].nama_jenis_pangan}</option>`;
        }
        $('#id_jenis_pangan').html(html);
        const desc = $('#id_jenis_pangan option:selected').data('desc');
        if (desc) {
          $('#show-deskripsi-jenis-pangan').html(`
      <div class="alert alert-light" role="alert">
    Keterangan:<br>
    <i>${desc}</i>
  </div>
       
        `);
        } else {
          $('#show-deskripsi-jenis-pangan').html('');
        }
      }
    })
  }


  $('#id_jenis_pangan').change(function() {
    const desc = $('#id_jenis_pangan option:selected').data('desc');
    $('#show-deskripsi-jenis-pangan').html(`
      <label class="text-label">Deskripsi Jenis Pangan<font color="red"><sup> *</sup></font></label>
      <textarea name="deskripsi_jenis_pangan" rows="5" disabled class="form-control wizard-required" nama="Deskripsi Jenis Pangan" id="deskripsi_jenis_pangan">${desc}</textarea>
      <div class="deskripsi_jenis_pangan_error text-danger"></div>
      `);
  })

  function error(nama) {
    toastr.warning(`${nama}`, "Error", {
      timeOut: 3000,
      closeButton: !0,
      debug: !1,
      newestOnTop: !0,
      progressBar: !0,
      positionClass: "toast-top-right",
      preventDuplicates: !0,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
      tapToDismiss: !1
    })

  }

  function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        if (evt.which == 32){
            return false;
        }
        return true;
    }
</script>