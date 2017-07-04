<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trend extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->library('PorterStemmer');
		$this->load->model('m_trend');
	}

	function index()
	{
		$this->load->model('smartphone');
		$data = array();
		$data['produk'] = $this->smartphone->getproduk();
		if (!file_exists('./setting.txt')) {
			$data['content'] = "Setting belum ditentukan !!";
		}else{
			$data['content'] = $this->load->view('trend',$data,TRUE);
		}
		$this->load->view('main', $data, FALSE);
	}

	function history()
	{
		$data = array();
		if (!file_exists('./setting.txt')) {
			$data['content'] = "Setting belum ditentukan !!";
		}else{
			$data['content'] = $this->load->view('history_trend',$data,TRUE);
		}
		$this->load->view('main', $data, FALSE);
	}

	function detailtrend($idtrend='')
	{
		$data = array();
		$data['idtrend'] = $idtrend;
		$data['content'] = $this->load->view('detailtrend',$data,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	function createtrend()
	{
		$msg = array();
		$dataparam = array();
		$q = $this->input->post('q');
		// $arridkey = array();
		$dataparam['data_trend_tanggal'] = $this->input->post('tgl');
		$dataparam['data_trend_jml_komentar'] = $this->input->post('count');
		$dataparam['data_trend_tipe'] = $this->input->post('tipe');

		// for ($i=0; $i < count($q); $i++) { 
		// 	$idproduk = $this->db->query("SELECT m_produk_id from m_produk where UPPER(m_produk_nama) = '".strtoupper($q[$i])."'")->row()->m_produk_id;
		// 	array_push($arridkey, $idproduk);
		// }
		$dataparam['data_trend_produk'] = implode($q, ",");
		$idtrend = $this->m_trend->save_trend($dataparam);
		if (!$idtrend) {
			$msg['tipe'] = 'danger';
			$msg['msg'] = 'gagal insert data Trend';
			$this->output->set_content_type('application/json')->set_output(json_encode($msg));return;
		}
		$msg['tipe'] = 'success';
		$msg['msg'] = 'Berhasil Menyimpan Data Trend';
		$msg['idtrend'] = $idtrend;
		$msg['produk'] = $q;
		$msg['tgl'] = $this->input->post('tgl');
		$msg['jmlkomen'] = $this->input->post('count');
		$msg['tipe'] = $this->input->post('tipe');
		$this->output->set_content_type('application/json')->set_output(json_encode($msg));
	}

}

/* End of file Trend.php */
/* Location: ./application/controllers/Trend.php */