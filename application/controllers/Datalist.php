<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datalist extends CI_Controller {

	public function sentiwordnet()
	{
		$this->load->model('sentiwordnet');
		$records = $this->sentiwordnet->_get();
        $this->output->set_content_type('application/json')->set_output(json_encode($records));
	}
	
	public function smartphone()
	{
		$this->load->model('smartphone');
		$records = $this->smartphone->_get();
        $this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function stopword()
	{
		$this->load->model('stopword');
		$records = $this->stopword->_get();
        $this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function list_tweet()
	{
		$this->load->model('m_klasifikasi');
		$records = $this->m_klasifikasi->_get_list_tweet();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function list_tweet_bayes()
	{
		$this->load->model('m_klasifikasi');
		$records = $this->m_klasifikasi->_get_list_tweet_bayes();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function history()
	{
		$this->load->model('m_klasifikasi');
		$records = $this->m_klasifikasi->history();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function datahistorytrend()
	{
		$this->load->model('m_trend');
		$records = $this->m_trend->history();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function datahistoryprediksi()
	{
		$this->load->model('m_prediksi');
		$records = $this->m_prediksi->history();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function list_detail_trend()
	{
		$this->load->model('m_trend');
		$records = $this->m_trend->detail_trend();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}

	public function list_detail_prediksi()
	{
		$this->load->model('m_prediksi');
		$records = $this->m_prediksi->detail_prediksi();
		$this->output->set_content_type('application/json')->set_output(json_encode($records));
	}
}

/* End of file datalist.php */
/* Location: ./application/controllers/datalist.php */