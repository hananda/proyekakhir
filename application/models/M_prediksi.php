<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_prediksi extends CI_Model {

	public function save_prediksi($dataparam = array())
	{
		$this->db->insert('data_prediksi', $dataparam);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function history()
	{
		$dataorder = array();
        $dataorder[0] = "data_prediksi_tanggal";
        $dataorder[2] = "data_prediksi_tanggal";
        // $dataorder[4] = "tgl_akhir_beasiswa";

		$search = $this->input->post("search");

        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
        $start = intval($_REQUEST['start']);
        $order = $this->input->post('order');

		$query = "SELECT *
				FROM data_prediksi";
		if($search['value'] != ""){
            $query .=preg_match("/WHERE/i",$query)? " AND ":" WHERE ";
			$query .= "(data_prediksi_produk like '%". $search['value'] ."%')";
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
			$r[1] = trim($d['data_prediksi_produk']);
			$r[2] = trim($d['data_prediksi_tanggal']);
			$r[3] = trim($d['data_prediksi_jml_komentar']);
			$r[4] = '<a class="btn btn-info btndetail" href="'.base_url().'prediksi/detailprediksi/'.$d['data_prediksi_id'].'">Detail</a>';
            array_push($result, $r);
            $i++;
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
	}

	function detail_prediksi()
	{
		$idprediksi = $this->input->post('idprediksi');
		$dataorder = array();
        // $dataorder[3] = "tgl_awal_beasiswa";
        // $dataorder[4] = "tgl_akhir_beasiswa";

		$search = $this->input->post("search");

        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
        $start = intval($_REQUEST['start']);
        $order = $this->input->post('order');

		$query = "SELECT *
				FROM data_search 
				LEFT join m_produk on data_search.data_search_id_produk = m_produk.m_produk_id
				where data_search_id_prediksi = '".$idprediksi."'";
		if($search['value'] != ""){
            $query .=preg_match("/WHERE/i",$query)? " AND ":" WHERE ";
			$query .= "(stopword = '". $search['value'] ."')";
		}
        // OR PROGRAM_TAHUN LIKE '%". strtolower($search) ."%'
		// var_dump($order);
		// if($order[0]['column']){
            $query.= " order by data_search_pos desc";
  //       }

        $iTotalRecords = $this->db->query("SELECT COUNT(*) AS JUMLAH FROM (".$query.") A")->row()->JUMLAH;

        $query .= " LIMIT ". ($start) .",".($iDisplayLength);
        
        $data = $this->db->query($query)->result_array();
        $i = $start + 1;
        $result = array();
        foreach ($data as $d) {
            $r = array();
			$r[0] = $i;
			$r[1] = trim($d['m_produk_nama']);
			$r[2] = trim($d['data_search_pos']);
			$r[3] = trim($d['data_search_neg']);
			$r[4] = trim($d['data_search_net']);
			$r[5] = trim($d['data_search_sentiment']);
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

/* End of file M_prediksi.php */
/* Location: ./application/models/M_prediksi.php */