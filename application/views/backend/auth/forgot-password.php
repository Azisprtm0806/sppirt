
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
							<p>Silahkan masuk email anda untuk mendapatkan link Reset Password</p>
						</div>

						<?php if(form_error('nib')){ ?>
						<div class="alert alert-danger" role="alert">
							<?php echo str_replace("<p>", "",str_replace("</p>", "", form_error('nib'))) ; ?>
						</div>
						<?php } ?>

						<?php 
                                        $message = $this->session->flashdata('message');
                                        if(isset($message)){
                                    ?>
						<div class="alert alert-danger" role="alert">
							<?php echo $message; ?>
						</div>
						<?php } ?>

						<form action="<?php echo base_url('action-forgot-password'); ?>" method="POST" class="auth-form">

                            <div class="form-group">
								<label for="email" class="label">Email</label>
								<input type="email" name="email" id="email" class="form-control"
									placeholder="Masukan email anda" />
							</div>
                            
                            <button type="submit" class="btn btn-success btn-block mb-3 mt-4">
								Submit
							</button>
						</form>

						<label for="username" class="bawah">Sudah punya akun? <a href="<?= base_url() ?>AuthController">Login Disini</a></label>
					</div>
