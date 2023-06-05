<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <ol>
                <li><a href="index.html">Home</a></li>
                <li>Kontak Kami</li>
            </ol>
            <h2>Kontak Kami</h2>

        </div>
    </section><!-- End Breadcrumbs -->
    <section id="contact" class="contact">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>Kontak Kami</h2>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="info-box mb-4">
                        <i class="bx bx-map"></i>
                        <h3>Alamat Kami</h3>
                        <p>Direktorat Pemberdayaan Masyarakat dan Pelaku Usaha. Badan Pengawas Obat dan Makanan Republik Indonesia, Jl. Percetakan Negara No. 23 Jakarta Pusat 10560</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="info-box  mb-4">
                        <i class="bx bx-envelope"></i>
                        <h3>Email Kami</h3>
                        <p>
                            subditp3d.pmpu@gmail.com</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="info-box  mb-4">
                        <i class="bx bx-phone-call"></i>
                        <h3>Kontak Kami</h3>
                        <p>(+62) 21 42878701 / 42875738</p>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <form id="form" class="php-email-form">
                        <h3 class="text-center"><b>Saran dan Masukan</b></h3><br>
                        <div class="form-row">
                            <div class="col form-group">
                                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama Anda" data-rule="minlen:1" data-msg="Nama Masih Kosong" />
                                <div class="validate"></div>
                            </div>
                            <div class="col form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Masukan Email Anda" data-rule="email" data-msg="Email Masih Kosong" />
                                <div class="validate"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Masukan Nomor Telpon Anda" data-rule="minlen:1" data-msg="Nomor Telpon Masih Kosong" />
                            <div class="validate"></div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="komentar" id="komentar" rows="5" data-rule="required" data-rule="minlen:1" data-msg="Komentar Masih Kosong" placeholder="Komentar"></textarea>
                            <div class="validate"></div>
                        </div>

                        <div class="text-center btn-submit"><button type="submit">Kirim Pesan</button></div>
                    </form>
                </div>

                <div class="col-lg-6 ">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3129.869694262233!2d106.85742891400344!3d-6.188580295519772!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4596128c679%3A0xd23cd73b07e914c3!2sBpom%20Percetakan%20Negara!5e1!3m2!1sid!2sid!4v1632182072508!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>

            </div>

        </div>
    </section>
    <!-- ======= Blog Section ======= -->

    <!-- End Blog Section -->

</main><!-- End #main -->

<script>
    $('.btn-submit').click(function() {
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: `${base_url}Home/TambahSaran`,
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    sukses(response.alert);
                    $('#modal-form').modal('hide')
                    $('#form')[0].reset()
                } else {
                    var error = response.error
                }
            }
        })
    })

    function sukses(msg) {
        toastr.success(msg, "Berhasil dikirim", {
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
</script>