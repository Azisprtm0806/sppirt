
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
		<p>Anda dapat mengecek validitas Nomor SPPIRT yang beredar di masyarakat.</p>
	</div>


	<form action="#" method="POST" class="auth-form">

        <div class="form-group">
			<label for="no_sppirt" class="label">Masukkan Nomor SPPIRT disini</label>
			<input type="text" name="no_sppirt" id="no_sppirt" class="form-control"
				placeholder="P-IRT 1083201XXXXXXX" />
		</div>
        
        <button type="button" onclick="onCheck()" class="btn btn-success btn-block mb-3 mt-4">
			CEK NOMOR SPPIRT
		</button>
	</form>

	 <div class="form-group box-no_sppirt" style="display:none;">
	 	<label for="no_sppirt" class="label">No SPPIRT Baru:  <b><span id="no_baru"></span></b></label>
		<label for="no_sppirt" class="label">No SPPIRT Lama: <b><span id="no_lama"></span></b></label>
		<!-- <label for="no_sppirt" class="label">Status Nomor SPPIRT: <b>BERUBAH</b></label> -->
	</div>

</div>

<script type="text/javascript">
    function onCheck() {

    	$('.box-no_sppirt').hide();

        var no_sppirt = $('#no_sppirt').val();
        if(no_sppirt=="" || no_sppirt==" "){

        	swal({
		        type: 'error',
		        title: 'Oops...',
		        text: 'No SPPIRT tidak boleh kosong',
	        });
        	return false;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>action-cek-no-sppirt",
            data: JSON.stringify({
                no_sppirt: no_sppirt,
            }),
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(res) {

            	if(res.status=='success'){

            		if(res.status_no_sppirt=="0"){

            			swal({
					        type: 'success',
					        title: res.no_sppirt,
					        text: 'No SPPIRT tervalidasi'
				        });

            		}else{
            			swal({
					        type: 'success',
					        title: 'VALID',
					        text: res.msg,
				        });

	            		$('.box-no_sppirt').show();
	            		$('#no_lama').html(res.no_sppirt_lama);
	            		$('#no_baru').html(res.no_sppirt);
            		}

            
            	}else{

            		swal({
				        type: 'error',
				        title: 'Oops...',
				        text: res.msg,
			        });
			        return false;
            		

            	}

            }

        })

    }

</script>
