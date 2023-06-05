
            <div class="auth-form-section">
              <div class="text-center">
                <div class="logo">
                  <img
                    src="<?= base_url() ?>assets/frontend/img/logoSPPIRT.png"
                    class="img-fluid"
                    alt="Unplug UI"
                    width="250"
                  />
                </div>
                <p>Gunakan Akun Login Anda</p>
              </div>
              <form action="<?php echo base_url('authentication'); ?>" method="POST" class="auth-form">
                <div class="form-group">
                  <label for="username" class="label">Username</label>
                  <input
                    type="username"
                    name="username"
                    id="username"
                    class="form-control"
                    placeholder="Masukan Username"
                  />
                </div>
                <div class="form-group">
                  <label for="password" class="label">Password</label>
                  <input
                    type="password"
                    name="userPassword"
                    id="userPassword"
                    class="form-control"
                    placeholder="Masukan Password"
                  />
                </div>

                <div style="margin-top: 20px; margin-bottom: 20px">
                    <?php echo $widget;?>
                    <?php echo $script;?>
                </div>

                <button type="submit" class="btn btn-success btn-block mb-3 mt-3">
                  Login
                </button>
                <div class="d-md-flex justify-content-between">
                  <div class="form-check"></div>
                  <a href="<?= base_url() ?>forgot-password" class="lupapassword">Lupa Password?</a>
                </div>
              </form>
              <!--<label for="username" class="bawah">Belum punya akun? <a href="<?= base_url() ?>register">Register</a></label
              >-->
			  <label for="username" class="bawah">Belum punya akun? <a href="https://oss.go.id" target="_blank">Daftar akun melalui Sistem OSS</a></label>
            </div>
