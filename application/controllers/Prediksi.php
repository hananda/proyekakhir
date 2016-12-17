<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prediksi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->library('PorterStemmer');
		$this->load->model('m_prediksi');
	}

	function index()
	{
		$this->load->model('smartphone');
		$data = array();
		$data['produk'] = $this->smartphone->getproduk();
		$data['content'] = $this->load->view('prediksi',$data,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	function history()
	{
		$data = array();
		$data['content'] = $this->load->view('history_prediksi',$data,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	function detailprediksi($idprediksi='')
	{
		$data = array();
		$data['idprediksi'] = $idprediksi;
		$data['content'] = $this->load->view('detailprediksi',$data,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	function createprediksi()
	{
		$msg = array();
		$dataparam = array();
		$q = $this->input->post('q');
		// $arridkey = array();
		$dataparam['data_prediksi_tanggal'] = $this->input->post('tgl');
		$dataparam['data_prediksi_jml_komentar'] = $this->input->post('count');
		$dataparam['data_prediksi_tipe'] = $this->input->post('tipe');
		$dataparam['data_prediksi_produk'] = $this->input->post('q');
		$idprediksi = $this->m_prediksi->save_prediksi($dataparam);
		if (!$idprediksi) {
			$msg['tipe'] = 'danger';
			$msg['msg'] = 'gagal insert data prediksi';
			$this->output->set_content_type('application/json')->set_output(json_encode($msg));return;
		}
		$dataproduk = $this->db->query("SELECT * from m_produk where UPPER(m_produk_nama) = '".strtoupper($dataparam['data_prediksi_produk'])."'")->row();

		$getsimproduk = $this->db->query(
			"SELECT m_produk_nama from m_produk WHERE m_produk_nama <> '".$dataproduk->m_produk_nama."' and 
			m_produk_screen_size between ".($dataproduk->m_produk_screen_size - $this->config->item('range_size'))." and ".($dataproduk->m_produk_screen_size + $this->config->item('range_size'))." AND 
			m_produk_camera between ".($dataproduk->m_produk_camera - $this->config->item('range_camera'))." and ".($dataproduk->m_produk_camera + $this->config->item('range_camera'))." AND 
			m_produk_ram between ".($dataproduk->m_produk_ram - $this->config->item('range_ram'))." and ".($dataproduk->m_produk_ram + $this->config->item('range_ram'))." AND 
			m_produk_battery between ".($dataproduk->m_produk_battery - $this->config->item('range_battery'))." and ".($dataproduk->m_produk_battery + $this->config->item('range_battery'))." AND 
			m_produk_sensors between ".($dataproduk->m_produk_sensors - $this->config->item('range_sensor'))." and ".($dataproduk->m_produk_sensors + $this->config->item('range_sensor'))." AND 
			(m_produk_mem_internal = ".$dataproduk->m_produk_mem_internal." or m_produk_mem_internal1 = ".$dataproduk->m_produk_mem_internal1." or m_produk_mem_internal2 = ".$dataproduk->m_produk_mem_internal2.")
		 order by m_produk_screen_size,m_produk_camera,m_produk_ram,m_produk_battery,m_produk_sensors desc limit ".$this->config->item('jml_sim_phone'))->result();
		$arrproduk = array();
		foreach ($getsimproduk as $r) {
			array_push($arrproduk, $r->m_produk_nama);
		}
		$msg['tipe'] = 'success';
		$msg['msg'] = 'Berhasil Menyimpan Data prediksi';
		$msg['idprediksi'] = $idprediksi;
		$msg['produk'] = $arrproduk;
		$msg['tgl'] = $this->input->post('tgl');
		$msg['jmlkomen'] = $this->input->post('count');
		$msg['tipe'] = $this->input->post('tipe');
		$this->output->set_content_type('application/json')->set_output(json_encode($msg));
	}
}

/* End of file Prediksi.php */
/* Location: ./application/controllers/Prediksi.php */