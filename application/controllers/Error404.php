<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller {

	public function index()
	{

		$this->load->view('includes/header');

		$this->load->view('error404_view');// we MUST past an array that  as an argument as we load the view...

		$this->load->view('includes/footer');
	}
}
