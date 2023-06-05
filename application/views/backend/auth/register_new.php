<link href="<?= base_url('assets/backend/public/') ?>vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
<style type="text/css" media="screen">
  .form-isian {
    padding-top: 3px;
    padding-bottom: 3px ;
    margin-top: 5px;
  }
  .label-keterangan {
    font-size: small;
  }
</style>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.html">Home</a></li>
          <li>Registrasi</li>
        </ol>
        <h2>Registrasi Akun SPPIRT</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
      <div class="container" id="register">
        <div class="alert alert-success">
          <strong>Success! NIB TERVERIFIKASI.</strong> Data yang tampil di bawah ini adalah data berbasis NIB yang tersinkronasi dengan data dari sistem OSS. Mohon diisi dengan lengkap form ini untuk memudahkan Dinas Kesehatan dan PTSP dalam upaya koordinasi ke depannya.
        </div>

        <?php
        $message = $this->session->flashdata('message');
        if (isset($message)) {
        ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $message; ?>
            </div>
        <?php } ?>
        <br>
        <form action="<?php echo base_url('action-register/' . $token); ?>" method="POST" class="auth-form">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">NIB</label>
                  <input type="text" name="nib" class="form-control form-isian" placeholder="NIB" value="<?php echo isset($data->nib) ? $data->nib : ''; ?>" readonly>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">Nama Pelaku Usaha</label>
                  <input type="text" name="nama_pelaku_usaha" class="form-control form-isian" placeholder="Nama Pelaku Usaha" value="<?php echo isset($data->nama_penanggung_jwb) ? $data->nama_penanggung_jwb : ''; ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">NIK (Nomor KTP)</label>
                  <input type="text" name="nik" class="form-control form-isian" placeholder="Nomor KTP (NIK)" value="<?php echo isset($data->nik_penanggung_jwb) ? $data->nik_penanggung_jwb : ''; ?>">
              </div>
              </div>
            <div class="col-lg-6">
                <div class="form-group">
                  <label class="label">Nama Usaha <font color="red" class="label-keterangan"><i><sup>*</sup>Nama usaha perorangan sesuai dengan nama pelaku usaha</i></font></label>
                  <input type="text" name="nama_usaha" class="form-control form-isian" placeholder="Nama" value="<?php echo isset($data->nama_perseroan) ? $data->nama_perseroan : ''; ?>" readonly>
                </div>
              </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">No. Whatsapp <font color="red" class="label-keterangan"><i><sup>*</sup>Gunakan nomor whatsapp yang aktif untuk verifikasi secara sistem</i></font></label>
                  <input type="text" name="no_telp" class="form-control form-isian" placeholder="Contoh: 08123456789" value="<?php echo isset($phone) ? $phone : ''; ?>">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">Email <font color="red" class="label-keterangan"><i><sup>*</sup>Pastikan email aktif dan valid</i></font></label>
                  <input type="text" name="email" class="form-control form-isian" placeholder="Email" value="<?php echo isset($data->email_user_proses) ? $data->email_user_proses : ''; ?>">
                </div>
              </div>
            </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">Provinsi <font color="red" class="label-keterangan"><i><sup>*</sup>Sesuaikan dengan lokasi usaha</i></font></label>
                  <select name="id_prov" class="form-control form-isian" id="id_provinsi" onchange="selectProvinsi()" required>
                      <option value="">Pilih ...</option>
                      <?php foreach ($provinsi as $key => $value) { ?>
                          <option value="<?php echo $value->id_prov; ?>" <?php if (isset($id_provinsi) && $id_provinsi == $value->id_prov) { ?> selected <?php } ?>><?php echo $value->nama_prov; ?></option>
                      <?php } ?>
                  </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">Kabupaten/Kota <font color="red" class="label-keterangan"><i><sup>*</sup>Sesuaikan dengan lokasi usaha</i></font></label>
                  <select name="id_kota" class="form-control form-isian" id="id_kab_kota" onchange="selectKota()">
                      <option value="">Pilih ...</option>
                      <?php if (isset($id_kota)) { ?> <option value="<?php echo $id_kota; ?>" selected><?php echo $id_kota; ?></option> <?php } ?>
                  </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">Kecamatan <font color="red" class="label-keterangan"><i><sup>*</sup>Sesuaikan dengan lokasi usaha</i></font></label>
                  <select name="id_kecamatan" class="form-control form-isian" id="id_kecamatan" onchange="selectKecamatan()">
                      <option value="">Pilih ...</option>
                      <?php if (isset($id_kecamatan)) { ?> <option value="<?php echo $id_kecamatan; ?>" selected><?php echo $id_kecamatan; ?></option> <?php } ?>
                  </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">Desa <font color="red" class="label-keterangan"><i><sup>*</sup>Sesuaikan dengan lokasi usaha</i></font></label>
                  <select name="id_desa" class="form-control form-isian" id="id_desa">
                      <option value="">Pilih ...</option>
                      <?php if (isset($id_desa)) { ?> <option value="<?php echo $id_desa; ?>" selected><?php echo $id_desa; ?></option> <?php } ?>
                  </select>
              </div>
            </div>
          </div>
              <div class="form-group">
                  <label class="label">Alamat Usaha <font color="red" class="label-keterangan"><i style="background-color:yellow"><sup>*</sup>Mohon alamat dilengkapi detail sampai dengan kecamatan, kelurahan, RT dan RW untuk memudahkan petugas Dinas Kesehatan/ PTSP</i></font></label>
                  <textarea name="alamat_usaha" class="form-control form-isian" rows="5" style="line-height: 1.3em;"><?php echo isset($data->alamat_penanggung_jwb) ? $data->alamat_penanggung_jwb : ''; ?></textarea>
              </div>
              <div class="form-group">
                  <label class="label">Username <font color="red" class="label-keterangan"><i><sup>*</sup>NIB akan otomatis sebagai username</i></font></label>
                  <input type="text" name="username" class="form-control" placeholder="Nama" value="<?php echo isset($data->nib) ? $data->nib : ''; ?>" readonly>
              </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">Password <font color="red" class="label-keterangan"><i><sup>*</sup>Password harus minimal 8 karakter, minimal mengandung satu huruf besar, terdiri dari kombinsasi huruf dan angka,  minimal mengandung satu spesial karakter</i></font></label>
                  <input type="password" name="password" class="form-control form-isian">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                  <label class="label">Retype Password <font color="red" class="label-keterangan"><i><sup>*</sup><br>Ulangi isian password harus sama</i></font></label>
                  <input type="password" name="re_password" class="form-control form-isian">
              </div>
            </div>
          </div>

              <div style="margin-top: 20px; margin-bottom: 20px">
                  <?php echo $widget; ?>
                  <?php echo $script; ?>
              </div>

              <button type="submit" class="btn btn-success btn-block mb-6 mt-6" style="padding:10px;">
                  Register
              </button>

        </form>
        <label for="username" class="bawah form-isian" style="margin-top: 20px;">Sudah punya akun? <a href="<?= base_url() ?>login">Login Disini</a></label>

      </div>
    </section><!-- End Team Section -->

  </main><!-- End #main -->


<script type="text/javascript">
    function selectProvinsi() {

        var id_provinsi = $('#id_provinsi').val();
        var id_kab_kota = $('#id_kab_kota').val();

        $('#id_kecamatan').prop('selectedIndex',0);
        $('#id_desa').prop('selectedIndex',0);
        selectKota();
        selectKecamatan();

        $.ajax({
            type: "POST",
            type: 'ajax',
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

    function selectKota() {

        var id_kab_kota = $('#id_kab_kota').val();
        var id_kecamatan = $('#id_kecamatan').val();

        $.ajax({
            type: "POST",
            type: 'ajax',
            url: "<?php echo base_url(); ?>load-kecamatan",
            data: JSON.stringify({
                id_kab_kota: id_kab_kota,
                id_kecamatan: id_kecamatan
            }),
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(res) {
                $('#id_kecamatan').html(res.data)
            }

        })

    }

    function selectKecamatan() {

        var id_kecamatan = $('#id_kecamatan').val();
        var id_desa = $('#id_desa').val();

        $.ajax({
            type: "POST",
            type: 'ajax',
            url: "<?php echo base_url(); ?>load-desa",
            data: JSON.stringify({
                id_kecamatan: id_kecamatan,
                id_desa: id_desa
            }),
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(res) {
                $('#id_desa').html(res.data)
            }

        })

    }
    setTimeout(function() {
        selectProvinsi();
        // selectKota();
        // selectKecamatan();
    }, 100);
</script>

<script src="<?= base_url('assets/backend/public/') ?>vendor/sweetalert2/dist/sweetalert2.min.js"></script>
  <?php if ($this->session->flashdata('error')) { ?>
    <script language='JavaScript'>
      swal({
        type: 'error',
        title: 'Oops...',
        text: "<?php echo $this->session->flashdata('error'); ?>",
      });
    </script>
  <?php } else if ($this->session->flashdata('success')) { ?>
    <script language='JavaScript'>
      swal({
        type: 'success',
        title: 'Success',
        text: "<?php echo $this->session->flashdata('success'); ?>",
      });
    </script>
  <?php } ?>