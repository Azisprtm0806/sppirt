<div class="auth-form-section">
    <div class="text-center">
        <div class="logo">
            <img src="<?= base_url() ?>assets/frontend/img/logoSPPIRT.png" class="img-fluid" alt="Logo SPPIRT" width="250" />
        </div>
        <h4 class="text-center mb-4">Form Registrasi Akun SPPIRT</h4>
        <!-- <div>
            <i>Data yang ditampilkan berikut ini sesuai dengan data NIB dari Sistem OSS. Silahkan diupdate jika ada perubahan. Semua field <b>WAJIB</b> diisi.</i>
        </div><br> -->
    </div>
    <?php
    $message = $this->session->flashdata('message');
    if (isset($message)) {
    ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <form action="<?php echo base_url('action-register/' . $token); ?>" method="POST" class="auth-form">
        <div class="form-group">
            <label class="label">NIB</label>
            <input type="text" name="nib" class="form-control" placeholder="NIB" value="<?php echo isset($data->nib) ? $data->nib : ''; ?>" readonly>
        </div>
        <div class="form-group">
            <label class="label">Nama Pelaku Usaha</label>
            <input type="text" name="nama_pelaku_usaha" class="form-control" placeholder="Nama Pelaku Usaha" value="<?php echo isset($data->nama_penanggung_jwb) ? $data->nama_penanggung_jwb : ''; ?>">
        </div>
        <div class="form-group">
            <label class="label">NIK (Nomor KTP)</label>
            <input type="text" name="nik" class="form-control" placeholder="Nomor KTP (NIK)" value="<?php echo isset($data->nik_penanggung_jwb) ? $data->nik_penanggung_jwb : ''; ?>">
        </div>
        <div class="form-group">
            <label class="label">No. Handphone</label>
            <input type="text" name="no_telp" class="form-control" placeholder="" value="<?php echo isset($phone) ? $phone : ''; ?>">
        </div>
		<div class="form-group">
            <label class="label">Email</label>
            <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo isset($data->email_user_proses) ? $data->email_user_proses : ''; ?>">
        </div>
        <div class="form-group">
            <label class="label">Nama Usaha</label>
            <input type="text" name="nama_usaha" class="form-control" placeholder="Nama" value="<?php echo isset($data->nama_perseroan) ? $data->nama_perseroan : ''; ?>">
        </div>
        <div class="form-group">
            <label class="label">Provinsi</label>
            <select name="id_prov" class="form-control" id="id_provinsi" onchange="selectProvinsi()" required>
                <option value="">Pilih ...</option>
                <?php foreach ($provinsi as $key => $value) { ?>
                    <option value="<?php echo $value->id_prov; ?>"><?php echo $value->nama_prov; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label class="label">Kabupaten/Kota</label>
            <select name="id_kota" class="form-control" id="id_kab_kota">
                <option value="">Pilih ...</option>'
            </select>
        </div>
        <div class="form-group">
            <label class="label">Alamat Usaha</label>
            <textarea name="alamat_usaha" class="form-control" rows="5"><?php echo isset($data->alamat_perseroan) ? $data->alamat_perseroan : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label class="label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Nama" value="<?php echo isset($data->nib) ? $data->nib : ''; ?>" readonly>
        </div>
        <div class="form-group">
            <label class="label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label class="label">Retype Password</label>
            <input type="password" name="re_password" class="form-control">
        </div>

        <div style="margin-top: 20px; margin-bottom: 20px">
            <?php echo $widget; ?>
            <?php echo $script; ?>
        </div>

        <button type="submit" class="btn btn-success btn-block mb-3 mt-3">
            Register
        </button>

    </form>
    <label for="username" class="bawah">Sudah punya akun? <a href="<?= base_url() ?>login">Login Disini</a></label>
</div>

<script type="text/javascript">
    function selectProvinsi() {

        var id_provinsi = $('#id_provinsi').val();

        $.ajax({
            type: "POST",
            type: 'ajax',
            url: "<?php echo base_url(); ?>load-kab-kota",
            data: JSON.stringify({
                id_provinsi: id_provinsi
            }),
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(res) {
                $('#id_kab_kota').html(res.data)
            }

        })

    }
</script>