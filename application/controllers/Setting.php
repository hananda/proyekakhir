<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	public function index()
	{
		$data = array();
		$filedata = file_get_contents("./setting.txt");
		$data['setting'] = json_decode($filedata);
		$data['content'] = $this->load->view('setting',$data,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	public function save()
	{
		// var_dump($_POST);
		$file = fopen("./setting.txt", "w");
		$data = json_encode($_POST);
		fwrite($file, $data);
		fclose($file);
		redirect('setting','refresh');
	}
}

/* End of file setting.php */
/* Location: ./application/controllers/setting.php */