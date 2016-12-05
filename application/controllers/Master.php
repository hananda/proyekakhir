<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

	public function index()
	{
		
	}

	public function stopword()
	{
		$data = array();
		$data['content'] = $this->load->view('stopwords',null,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	public function sentiwordnet()
	{
		$data = array();
		$data['content'] = $this->load->view('sentiwordnet',null,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	public function smartphone()
	{
		$data = array();
		$data['content'] = $this->load->view('smartphone',null,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	public function prefsuffix()
	{
		$data = array();
		$data['content'] = '';
		$this->load->view('main', $data, FALSE);
	}

}

/* End of file master.php */
/* Location: ./application/controllers/master.php */