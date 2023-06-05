<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

	function loadTestimoni()
	{
		if ($this->input->is_ajax_request()) {
			$testimonials = $this->db->limit('6')->order_by('created_at', 'DESC')->get_where('tb_testimoni', ['deleted_at' => null])->result_array();
			// var_dump($this->db->last_query($testimonials));die;
			$html = '';
			foreach ($testimonials as $testimoni) {
				$html .= '
				<div class="col-lg-6 mt-4">
				  <div class="testimonial-item mt-4">
				    <img src="'.base_url() .'uploads/testimoni/'.$testimoni['foto_testimoni'].'" class="testimonial-img" alt="">
				    <h3>'.$testimoni['nama_testimoni'].'</h3>
				    <h4>Pelaku Usaha</h4>
				    <p>
				      <i class="bx bxs-quote-alt-left quote-icon-left"></i>
				     	'.$testimoni['komentar_testimoni'].'
				      <i class="bx bxs-quote-alt-right quote-icon-right"></i>
				    </p>
				  </div>
				</div>';
			}
			echo $html;
		}else{
			exit('error');
		}
	}

	function loadBerita()
	{
		if ($this->input->is_ajax_request()) {
			$news = $this->db->limit('3')->order_by('created_at', 'DESC')->get_where('tb_berita', ['deleted_at' => null])->result_array();
			// var_dump($this->db->last_query($news));die;
			$html = '';
			foreach ($news as $new) {
				$html .= '
				<div class="col-lg-4 entries">
				  <article class="entry">

				    <div class="entry-img">
				      <img src="'.base_url('uploads/berita/thumbnail/') . $new['gambar_berita'] .'" alt="" class="img-fluid">
				    </div>

				    <h2 class="entry-title">
				      <a href="#">'.$new['judul_berita'].'</a>
				    </h2>

				    <div class="entry-meta">
				      <ul>
				        <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="blog-single.html">Admin</a></li>
				        <li class="d-flex align-items-center"><i class="icofont-wall-clock"></i> <a href="blog-single.html"><time datetime="2020-01-01">'.$new['tgl_berita'].'</time></a></li>
				      </ul>
				    </div>

				    <div class="entry-content">
				      <p>
				        '.substr($new['deskripsi_berita'], 0, 100).'
				      </p>
				      <div class="read-more">
				        <a href="'.base_url('Home/detail_berita/') . $new['slug_berita'].'">Read More</a>
				      </div>
				    </div>

				  </article><!-- End blog entry -->
				</div>
				';
			}
			echo $html;
		}else{
			exit('error');
		}
	}


	function loadAccordion($tipe)
	{
		if ($this->input->is_ajax_request()) {
			$kategori = $this->db->get_where('tb_kategori_'.$tipe, ['deleted_at' => null])->result_array();
			$html = '';
			foreach ($kategori as $kat) {
				$html .= '
				<div class="accordion" id="accordionExample'.$kat['id_kategori_'.$tipe].'">
				  <div class="card mb-3">
				    <div class="card-header" id="heading'.$kat['id_kategori_'.$tipe].'">
				      <h5 class="mb-0">
				        <button class="btn" type="button" data-toggle="collapse" data-target="#collapse'.$kat['id_kategori_'.$tipe].'" aria-expanded="true" aria-controls="collapse'.$kat['id_kategori_'.$tipe].'" style="width: 100%; text-align:left">
				        	'.$kat['nama_kategori_'.$tipe].'
				        </button>
				      </h5>
				    </div>
				    ';
				$regulasi = $this->db->get_where('tb_'.$tipe, ['id_kategori' => $kat['id_kategori_'.$tipe], 'deleted_at' => null])->result_array();    

				foreach ($regulasi as $reg) {
					// code...
				$html.='

				    <div id="collapse'.$kat['id_kategori_'.$tipe].'" class="collapse show" aria-labelledby="heading'.$kat['id_kategori_'.$tipe].'" data-parent="#accordionExample'.$kat['id_kategori_'.$tipe].'">
				      <div class="card-body">
				        <div class="list-group list-group-flush">
				            <a href="'.base_url('uploads/regulasi/').$reg[$tipe == 'regulasi' ? 'file_'.$tipe : 'file'].'" target="_BLANK" class="list-group-item list-group-item-action">
				               <i class="icofont-file-pdf text-danger"></i> '.$reg[$tipe == 'regulasi' ? 'judul_'.$tipe : 'judul'].'</a>
				        </div>
				      </div>
				    </div>
				  
				';
				}
				$html .= '
				</div>
				</div>
				';
			}
			if (empty($html)) {
				$html = '
				  <div class="text-center">
				    Belum Ada Data
				  </div>
				';
			}
			echo $html;
		}else{
			exit('error');
		}
	}


	function loadFaq()
	{
		if ($this->input->is_ajax_request()) {
			$faqs = $this->db->get_where('tb_faq', ['deleted_at' => null])->result_array();
			$html = '';
			foreach ($faqs as $faq) {
				$html .= '
				<div class="accordion" id="accordionExample'.$faq['id_faq'].'">
				  <div class="card">
				    <div class="card-header" id="heading'.$faq['id_faq'].'">
				      <h5 class="mb-0">
				        <button class="btn" type="button" data-toggle="collapse" data-target="#collapse'.$faq['id_faq'].'" aria-expanded="true" aria-controls="collapse'.$faq['id_faq'].'" style="width: 100%; text-align:left">
				         <i class="icofont-audio text-danger"></i>  '.$faq['pertanyaan_faq'].'
				        </button>
				      </h5>
				    </div>
				    
				    <div id="collapse'.$faq['id_faq'].'" class="collapse show" aria-labelledby="heading'.$faq['id_faq'].'" data-parent="#accordionExample'.$faq['id_faq'].'">
				      <div class="card-body">
				      	<div class="list-group list-group-flush">
				            <div class="list-group-item list-group-item-action">
				               <i class="icofont-audio text-danger"></i> '.$faq['jawaban_faq'].'</div>
				        </div>
				      </div>
				    </div>
				  </div>
				</div>';
			}

			if (empty($html)) {
				$html = '
				  <div class="text-center">
				    Belum Ada Data
				  </div>
				';
			}
			echo $html;
		}else{
			exit('error');
		}
	}
}
