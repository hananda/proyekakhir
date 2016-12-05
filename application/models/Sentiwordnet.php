<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sentiwordnet extends CI_Model {

	function _get()
	{
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
				FROM sentiword";
		if($search['value'] != ""){
            $query .=preg_match("/WHERE/i",$query)? " AND ":" WHERE ";
			$query .= "(synsetterms = '". $search['value'] ."')";
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
            $r = array();
			$r[0] = $i;
			$r[1] = $d['POS'];
			$r[2] = $d['posscore'];
			$r[3] = $d['negscore'];
			$r[4] = $d['synsetterms'];
			$r[5] = $d['gloss'];
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

/* End of file sentiwordnet.php */
/* Location: ./application/models/sentiwordnet.php */