<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Maintenance extends CI_Controller
{
	function index()
	{
		//$this->template->load('','views/under/index');
		// echo view('under/index');
		$this->load->view('under/index');
	}
}