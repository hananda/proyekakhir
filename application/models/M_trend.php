<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_trend extends CI_Model {

	public function save_trend($dataparam = array())
	{
		$this->db->insert('data_trend', $dataparam);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function history()
	{
		$dataorder = array();
        $dataorder[0] = "data_trend_tanggal";
        $dataorder[2] = "data_trend_tanggal";
        // $dataorder[4] = "tgl_akhir_beasiswa";

		$search = $this->input->post("search");

        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
        $start = intval($_REQUEST['start']);
        $order = $this->input->post('order');

		$query = "SELECT *
				FROM data_trend";
		if($search['value'] != ""){
            $query .=preg_match("/WHERE/i",$query)? " AND ":" WHERE ";
			$query .= "(data_trend_produk like '%". $search['value'] ."%')";
		}
        // OR PROGRAM_TAHUN LIKE '%". strtolower($search) ."%'
		// var_dump($order);
		if($order[0]['column']){
            $query.= " order by 
                ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
        }

        $iTotalRecords = $this->db->query("SELECT COUNT(*) AS JUMLAH FROM (".$query.") A")->row()->JUMLAH;

        $query .= " LIMIT ". ($start) .",".($iDisplayLength);
        
        $data = $this->db->query($query)->result_array();
        $i = $start + 1;
        $result = array();
        foreach ($data as $d) {
			$r[0] = $i;
			$r[1] = trim($d['data_trend_produk']);
			$r[2] = trim($d['data_trend_tanggal']);
			$r[3] = trim($d['data_trend_jml_komentar']);
			$r[4] = '<a class="btn btn-info btndetail" href="'.base_url().'trend/detailtrend/'.$d['data_trend_id'].'">Detail</a>';
            array_push($result, $r);
            $i++;
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
	}

	function detail_trend()
	{
        $filedata = @file_get_contents("./setting.txt");
        $setting = json_decode($filedata);
		$idtrend = $this->input->post('idtrend');
		$dataorder = array();
        // $dataorder[3] = "tgl_awal_beasiswa";
        // $dataorder[4] = "tgl_akhir_beasiswa";

		$search = $this->input->post("search");

        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
        $start = intval($_REQUEST['start']);
        $order = $this->input->post('order');

		$query = "SELECT data_search.*,m_produk.*,((data_search_pos*".$setting->bobotpositif.")+(data_search_neg*".$setting->bobotnegatif.")+(data_search_net*".$setting->bobotnetral.")) as bobot
				FROM data_search 
				LEFT join m_produk on data_search.data_search_id_produk = m_produk.m_produk_id
				where data_search_id_trend = '".$idtrend."'";
		if($search['value'] != ""){
            $query .=preg_match("/WHERE/i",$query)? " AND ":" WHERE ";
			$query .= "(stopword = '". $search['value'] ."')";
		}
        // OR PROGRAM_TAHUN LIKE '%". strtolower($search) ."%'
		// var_dump($order);
		// if($order[0]['column']){
            $query.= " order by bobot desc";
  //       }

        $iTotalRecords = $this->db->query("SELECT COUNT(*) AS JUMLAH FROM (".$query.") A")->row()->JUMLAH;

        $query .= " LIMIT ". ($start) .",".($iDisplayLength);
        
        $data = $this->db->query($query)->result_array();
        $i = $start + 1;
        $result = array();
        foreach ($data as $d) {
            $btnbayes = '';
            if (!$d['data_search_naive_bayes']) {
                $btnbayes = '<button class="btn btn-success btnbayes" data-id="'.$d['data_search_id'].'">Hitung Naive Bayes</button>';
            }else{
                $btnbayes = '<button class="btn btn-success btnbayes" data-id="'.$d['data_search_id'].'">Hitung Ulang Naive Bayes</button>';
            }
            $r = array();
            $posbayes = '';
            $netbayes = '';
            $negbayes = '';
            $sentbayes = '';
            if ($d['data_search_pos_bayes']) {
                $posbayes = '|'.$d['data_search_pos_bayes'];
            }
            if ($d['data_search_net_bayes']) {
                $netbayes = '|'.$d['data_search_net_bayes'];
            }
            if ($d['data_search_neg_bayes']) {
                $negbayes = '|'.$d['data_search_neg_bayes'];
            }
            if ($d['data_search_sentiment_bayes']) {
                $sentbayes = '|'.$d['data_search_sentiment_bayes'];
            }
			$r[0] = $i;
			$r[1] = trim($d['m_produk_nama']);
			$r[2] = trim($d['data_search_pos']).$posbayes;
			$r[3] = trim($d['data_search_neg']).$negbayes;
			$r[4] = trim($d['data_search_net']).$netbayes;
			$r[5] = trim($d['data_search_sentiment']).$sentbayes;
            $r[6] = '<a class="btn btn-info btndetail" href="'.base_url().'klasifikasi/detailklasifikasi/'.$d['data_search_id'].'">Detail</a>'.$btnbayes;
            array_push($result, $r);
            $i++;
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
	}

}

/* End of file M_trend.php */
/* Location: ./application/models/M_trend.php */