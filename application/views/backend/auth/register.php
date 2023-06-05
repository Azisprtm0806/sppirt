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
            <label class="label">No. Whatsapp <font color="red"><i><sup>*</sup>Gunakan nomor whatsapp yang aktif untuk verifikasi secara sistem</i></font></label>
            <input type="text" name="no_telp" class="form-control" placeholder="Contoh: 08123456789" value="<?php echo isset($phone) ? $phone : ''; ?>">
        </div>
        <div class="form-group">
            <label class="label">Email <font color="red"><i><sup>*</sup>Pastikan email aktif dan valid</i></font></label>
            <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo isset($data->email_user_proses) ? $data->email_user_proses : ''; ?>">
        </div>
        <div class="form-group">
            <label class="label">Nama Usaha <font color="red"><i><sup>*</sup></i></font></label>
            <input type="text" name="nama_usaha" class="form-control" placeholder="Nama" value="<?php echo isset($data->nama_perseroan) ? $data->nama_perseroan : ''; ?>">
        </div>
        <div class="form-group">
            <label class="label">Provinsi <font color="red"><i><sup>*</sup>Sesuaikan dengan lokasi usaha</i></font></label>
            <select name="id_prov" class="form-control" id="id_provinsi" onchange="selectProvinsi()" required>
                <option value="">Pilih ...</option>
                <?php foreach ($provinsi as $key => $value) { ?>
                    <option value="<?php echo $value->id_prov; ?>" <?php if (isset($id_provinsi) && $id_provinsi == $value->id_prov) { ?> selected <?php } ?>><?php echo $value->nama_prov; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label class="label">Kabupaten/Kota <font color="red"><i><sup>*</sup>Sesuaikan dengan lokasi usaha</i></font></label>
            <select name="id_kota" class="form-control" id="id_kab_kota" onchange="selectKota()">
                <option value="">Pilih ...</option>
                <?php if (isset($id_kota)) { ?> <option value="<?php echo $id_kota; ?>" selected><?php echo $id_kota; ?></option> <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label class="label">Kecamatan <font color="red"><i><sup>*</sup>Sesuaikan dengan lokasi usaha</i></font></label>
            <select name="id_kecamatan" class="form-control" id="id_kecamatan" onchange="selectKecamatan()">
                <option value="">Pilih ...</option>
                <?php if (isset($id_kecamatan)) { ?> <option value="<?php echo $id_kecamatan; ?>" selected><?php echo $id_kecamatan; ?></option> <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label class="label">Desa <font color="red"><i><sup>*</sup>Sesuaikan dengan lokasi usaha</i></font></label>
            <select name="id_desa" class="form-control" id="id_desa">
                <option value="">Pilih ...</option>
                <?php if (isset($id_desa)) { ?> <option value="<?php echo $id_desa; ?>" selected><?php echo $id_desa; ?></option> <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label class="label">Alamat Usaha <font color="red"><i><sup>*</sup>Mohon alamat dilengkapi detail sampai dengan kecamatan, kelurahan, RT dan RW</i></font></label>
            <textarea name="alamat_usaha" class="form-control" rows="5" style="line-height: 1.3em; background: #FF6"><?php echo isset($data->alamat_penanggung_jwb) ? $data->alamat_penanggung_jwb : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label class="label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Nama" value="<?php echo isset($data->nib) ? $data->nib : ''; ?>" readonly>
        </div>
        <div class="form-group">
            <label class="label">Password <font color="red"><i><sup>*</sup>Minimal 6 karakter alpha numerik</i></font></label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label class="label">Retype Password <font color="red"><i><sup>*</sup>Pastikan isian sama</i></font></label>
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