<style type="text/css" media="screen">
    p {
        color: grey
    }

    #heading {
        text-transform: uppercase;
        color: #3a7afe;
        font-weight: normal
    }

    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;
        position: relative
    }

    .form-card {
        text-align: left
    }

    #msform fieldset:not(:first-of-type) {
        display: none
    }

    #msform input,
    #msform textarea {
        padding: 8px 15px 8px 15px;
        border: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        /*font-family: montserrat;*/
        color: #2C3E50;
        background-color: #ECEFF1;
        font-size: 16px;
        letter-spacing: 1px
    }

    #msform input:focus,
    #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: 1px solid #3a7afe;
        outline-width: 0
    }

    #msform .action-button {
        width: 100px;
        background: #3a7afe;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 0px 10px 5px;
        float: right
    }

    #msform .action-button:hover,
    #msform .action-button:focus {
        background-color: #311B92
    }

    #msform .action-button-previous {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px 10px 0px;
        float: right
    }

    #msform .action-button-previous:hover,
    #msform .action-button-previous:focus {
        background-color: #000000
    }

    .card {
        z-index: 0;
        border: none;
        position: relative
    }

    .fs-title {
        font-size: 25px;
        color: #3a7afe;
        margin-bottom: 15px;
        font-weight: normal;
        text-align: left
    }

    .purple-text {
        color: #3a7afe;
        font-weight: normal
    }

    .steps {
        font-size: 25px;
        color: gray;
        margin-bottom: 10px;
        font-weight: normal;
        text-align: right
    }

    .fieldlabels {
        color: gray;
        text-align: left
    }

    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey
    }

    #progressbar .active {
        color: #3a7afe
    }

    #progressbar li {
        list-style-type: none;
        font-size: 15px;
        width: 25%;
        float: left;
        position: relative;
        font-weight: 400
    }

    #progressbar #account:before {
        /*font-family: FontAwesome;*/
        content: "1"
    }

    #progressbar #personal:before {
        /*font-family: FontAwesome;*/
        content: "2"
    }

    #progressbar #payment:before {
        /*font-family: FontAwesome;*/
        content: "3"
    }

    #progressbar #confirm:before {
        /*font-family: FontAwesome;*/
        content: "4"
    }

    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 20px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px
    }

    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1
    }

    #progressbar li.active:before,
    #progressbar li.active:after {
        background: #3a7afe
    }

    .progress {
        height: 20px
    }

    .progress-bar {
        background-color: #3a7afe
    }

    .fit-image {
        width: 100%;
        object-fit: cover
    }
</style>
    <div class="row justify-content-center">
        <div class="col-12 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2 id="heading">Sign Up Your User Account</h2>
                <p>Fill all form field to go to next step</p>
                <form id="msform" class="form-pengajuan-irtp">
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="active" id="account"><strong>Data Pelaku Usaha</strong></li>
                        <li id="personal"><strong>Data Produk</strong></li>
                        <li id="payment"><strong>Label Produk</strong></li>
                        <li id="confirm"><strong>4</strong></li>
                    </ul>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> <br> <!-- fieldsets -->
                    <div class="card-body">
                        
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Data Pelaku Usaha:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 1 - 4</h2>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                  <label class="text-label">Nama Pelaku Usaha*</label>
                                  <input type="text" class="form-control" id="nama_pelaku_usaha" name="nama_pelaku_usaha" value="<?= $pelakuusaha['nama_penanggung_jwb'] ?>"  placeholder="" required>
                                </div>
                              </div>
                              <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                  <label class="text-label">NIK*</label>
                                  <input type="text" class="form-control" id="nik" name="nik" maxlength="16" minlength="16" value="<?= $pelakuusaha['nik_penanggung_jwb'] ?>" placeholder="" required>
                                </div>
                              </div>
                              <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                  <label class="text-label">Nama Usaha*</label>
                                  <input type="text" class="form-control" id="nama_usaha" name="nama_usaha" value="<?= $pelakuusaha['nama_perseroan'] ?>" placeholder="" required>
                                </div>
                              </div>
                              <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                  <label class="text-label">NIB*</label>
                                  <input type="text" class="form-control" id="nib" name="nib" readonly value="<?= $pelakuusaha['nib'] ?>" placeholder="" required>
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
                        </div> 
                        <input type="button" name="next" class="next action-button" value="Next" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Data Produk:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 2 - 4</h2>
                                </div>
                            </div>
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
                        </div> 
                        <input type="button" name="next" class="next action-button" value="Next" /> 
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Label Produk:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 3 - 4</h2>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-12">
                                    <h5>Apakah label anda telah mencantumkan informasi berikut?</h5>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="text-left">1. Nama Produk</td>
                                                <td class="text-right">
                                                    <div class="form-group mb-0">
                                                        <label class="radio-inline" for="nama_produk_1"><input type="radio" name="nama_produk" id="nama_produk_1" value="1"> Ya</label>
                                                        <label class="radio-inline" for="nama_produk_0"><input type="radio" name="nama_produk" id="nama_produk_0" value="0"> Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">2. Komposisi</td>
                                                <td class="text-right">
                                                    <!-- <input type="checkbox" name="komposisi" id="komposisi" value="1"> Ya
                                                    <input type="checkbox" name="komposisi" id="komposisi" value="0"> Tidak -->
                                                    <div class="form-group mb-0">
                                                        <label class="radio-inline" for="komposisi_1"><input type="radio" name="komposisi" id="komposisi_1" value="1"> Ya</label>
                                                        <label class="radio-inline" for="komposisi_0"><input type="radio" name="komposisi" id="komposisi_0" value="0"> Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">3. Berat bersih/isi bersih</td>
                                                <td class="text-right">
                                                    <!-- <input type="checkbox" name="isi_bersih" id="isi_bersih" value="1"> Ya
                                                    <input type="checkbox" name="isi_bersih" id="isi_bersih" value="0"> Tidak -->
                                                    <div class="form-group mb-0">
                                                        <label class="radio-inline" for="isi_bersih_1"><input type="radio" name="isi_bersih" id="isi_bersih_1" value="1"> Ya</label>
                                                        <label class="radio-inline" for="isi_bersih_0"><input type="radio" name="isi_bersih" id="isi_bersih_0" value="0"> Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">4. Halal</td>
                                                <td class="text-right">
                                                    <!-- <input type="checkbox" name="halal" id="halal" value="1"> Ya
                                                    <input type="checkbox" name="halal" id="halal" value="0"> Tidak -->
                                                    <div class="form-group mb-0">
                                                        <label class="radio-inline" for="halal_1"><input type="radio" name="halal" id="halal_1" value="1"> Ya</label>
                                                        <label class="radio-inline" for="halal_0"><input type="radio" name="halal" id="halal_0" value="0"> Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">5. Tanggal dan Kode Produksi</td>
                                                <td class="text-right">
                                                    <!-- <input type="checkbox" name="tgl_produksi" id="tgl_produksi" value="1"> Ya
                                                    <input type="checkbox" name="tgl_produksi" id="tgl_produksi" value="0"> Tidak -->
                                                    <div class="form-group mb-0">
                                                        <label class="radio-inline" for="tgl_produksi_1"><input type="radio" name="tgl_produksi" id="tgl_produksi_1" value="1"> Ya</label>
                                                        <label class="radio-inline" for="tgl_produksi_0"><input type="radio" name="tgl_produksi" id="tgl_produksi_0" value="0"> Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">6. Keterangan Kadaluarsa</td>
                                                <td class="text-right">
                                                    <!-- <input type="checkbox" name="ket_kadaluarsa" id="ket_kadaluarsa" value="1"> Ya
                                                    <input type="checkbox" name="ket_kadaluarsa" id="ket_kadaluarsa" value="0"> Tidak -->
                                                    <div class="form-group mb-0">
                                                        <label class="radio-inline" for="ket_kadaluarsa_1"><input type="radio" name="ket_kadaluarsa" id="ket_kadaluarsa_1" value="1"> Ya</label>
                                                        <label class="radio-inline" for="ket_kadaluarsa_0"><input type="radio" name="ket_kadaluarsa" id="ket_kadaluarsa_0" value="0"> Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">7. Asal usul bahan pangan tertentu</td>
                                                <td class="text-right">
                                                    <!-- <input type="checkbox" name="asal_usul" id="asal_usul" value="1"> Ya -->
                                                    <!-- <input type="checkbox" name="asal_usul" id="asal_usul" value="0"> Tidak -->
                                                    <div class="form-group mb-0">
                                                        <label class="radio-inline" for="asal_usul_1"><input type="radio" name="asal_usul" id="asal_usul_1" value="1"> Ya</label>
                                                        <label class="radio-inline" for="asal_usul_0"><input type="radio" name="asal_usul" id="asal_usul_0" value="0"> Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">9. Informasi Nilai Gizi </td>
                                                <td class="text-right">
                                                    <!-- <input type="checkbox" name="informasi_nilai_gizi" id="informasi_nilai_gizi" value="1"> Ya
                                                    <input type="checkbox" name="informasi_nilai_gizi" id="informasi_nilai_gizi" value="0"> Tidak -->
                                                    <div class="form-group mb-0">
                                                        <label class="radio-inline" for="informasi_nilai_gizi_1"><input type="radio" name="informasi_nilai_gizi" id="informasi_nilai_gizi_1" value="1"> Ya</label>
                                                        <label class="radio-inline" for="informasi_nilai_gizi_0"><input type="radio" name="informasi_nilai_gizi" id="informasi_nilai_gizi_0" value="0"> Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">9. Keterangan Lainn1</td>
                                                <td class="text-right">
                                                    <!-- <input type="checkbox" name="kel_lainnya" id="kel_lainnya" value="1"> Ya -->
                                                    <!-- <input type="checkbo<div class="form-group mb-0">
                                                        <label class="radio-inline" for="nama_produk_1"><input type="radio" name="nama_produk" id="nama_produk_1" value="1"> Ya</label>
                                                        <label class="radio-inline" for="nama_produk_0"><input type="radio" name="nama_produk" id="nama_produk_0" value="0"> Tidak</label>
                                                    </div>x" name="kel_lainnya" id="kel_lainnya" value="0"> Tidak -->
                                                    <div class="form-group mb-0">
                                                        <label class="radio-inline" for="kel_lainnya_1"><input type="radio" name="kel_lainnya" id="kel_lainnya_1" value="1"> 
                                                        Ya</label>
                                                        <label class="radio-inline" for="kel_lainnya_0"><input type="radio" name="kel_lainnya" id="kel_lainnya_0" value="0"> Tidak</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">10. Upload Rancangan Label</td>
                                                <td class="text-right">
                                                    <input type="file" name="upload_rancangan" id="upload_rancangan" placeholder="">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                        <input type="button" name="next" id="submit" class="next action-button" value="Submit" /> 
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Finish:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 4 - 4</h2>
                                </div>
                            </div> <br><br>
                            <h2 class="purple-text text-center"><strong id="status"></strong></h2> <br>
                            <div class="row justify-content-center">
                                <div class="col-3" id="check"> </div>
                            </div> <br><br>
                            <div class="row justify-content-center">
                                <div class="col-7 text-center" id="msg">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);

        $(".next").click(function(){

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
            step: function(now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
            'display': 'none',
            'position': 'relative'
            });
            next_fs.css({'opacity': opacity});
            },
            duration: 500
            });
            setProgressBar(++current);
            console.log(current);
        });

        $(".previous").click(function(){

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
                },
                duration: 500
            });
            setProgressBar(--current);
        });

        function setProgressBar(curStep){
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
            .css("width",percent+"%")
        }

        });

        
            $('#id_kategori_jenis_pangan').change(function(){
                var id_kategori_jenis_pangan = $(this).val()
                $.ajax({
                    url:`${base_url}backend/General/getJenisPangan/`+id_kategori_jenis_pangan,
                    dataType:'json',
                    success:function(response){
                        var data = response.data
                            var html = `
                            <select name="id_jenis_pangan" class="form-control" id="id_jenis_pangan">
                            
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

            $('#submit').click(function(){
                var formData = new FormData($('.form-pengajuan-irtp')[0]);
                $.ajax({
                    url:`${base_url}backend/Irtp/simpanPengajuan`,
                    type:'post',
                    data:formData,
                    contentType: false,
                    processData: false,
                    dataType:'json',
                    success:function(response){
                        if (response.success) {
                            $('#status').text('Berhasil')
                            $('#check').html(`<img src="https://i.imgur.com/GwStPmg.png" class="fit-image">`)
                            $('#msg').text(response.msg)
                        }else{
                            $('#status').text('Gagal')
                            $('#check').html(`<img src="${base_url}assets/backend/image/danger.png" class="fit-image">`)
                            $('#msg').html(`<h5 class="purple-text text-center">${response.msg}</h5>`)
                        }
                    }
                })
            })
    </script>

