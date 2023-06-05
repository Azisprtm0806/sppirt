
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
                            <p>Form Reset Password. <br>Silahkan masukkan password baru anda.</p>
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

                        <form action="<?php echo base_url('action-reset-password'); ?>/<?php echo $token; ?>" method="POST" class="auth-form">

                            <div class="form-group">
                                <label for="email" class="label">New Password <font color="red" class="label-keterangan"><i><sup>*</sup>Password harus minimal 8 karakter, minimal mengandung satu huruf besar, terdiri dari kombinsasi huruf dan angka,  minimal mengandung satu spesial karakter</i></font></label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>

                            <div class="form-group">
                                <label for="email" class="label">Retype New Password</label>
                                <input type="password" name="re_password" class="form-control" placeholder="Password">
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-block mb-3 mt-4">
                                Reset Password
                            </button>
                        </form>

