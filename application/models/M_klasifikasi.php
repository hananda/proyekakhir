<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_klasifikasi extends CI_Model {

	function save_tweet($dataparam=array())
	{
		extract($dataparam);
		$data['data_tweet_text'] = $text;
		$data['data_tweet_user'] = $user;
		$data['data_tweet_id_search'] = $idsearch;
		$data['data_tweet_date_post'] = $datepost;
		$this->db->insert('data_tweet', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function save_search($dataparam=array())
	{
		extract($dataparam);
		$data['data_search_query'] = $query;
		$data['data_search_id_produk'] = $idproduk;
		$data['data_search_remote_host'] = $_SERVER['REMOTE_ADDR'];
		$data['data_search_tgl'] = date('Y-m-d H:i:s');
		$data['data_search_id_trend'] = $this->input->post('idtrend');
		$data['data_search_id_prediksi'] = $this->input->post('idprediksi');
		$this->db->insert('data_search', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function _get_list_tweet()
	{
		$idsearch = $this->input->post('idsearch');
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
				FROM data_tweet where data_tweet_id_search = '".$idsearch."'";
		if($search['value'] != ""){
            $query .=preg_match("/WHERE/i",$query)? " AND ":" WHERE ";
			$query .= "(stopword = '". $search['value'] ."')";
		}
        // OR PROGRAM_TAHUN LIKE '%". strtolower($search) ."%'
		// var_dump($order);
		// if($order[0]['column']){
  //           $query.= " order by 
  //               ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
  //       }

        $iTotalRecords = $this->db->query("SELECT COUNT(*) AS JUMLAH FROM (".$query.") A")->row()->JUMLAH;

        $query .= " LIMIT ". ($start) .",".($iDisplayLength);
        
        $data = $this->db->query($query)->result_array();
        $i = $start + 1;
        $result = array();
        foreach ($data as $d) {
            $r = array();
			$r[0] = $i;
			$r[1] = trim($d['data_tweet_text']);
			$r[2] = trim($d['data_tweet_index_pos']);
			$r[3] = trim($d['data_tweet_index_neg']);
			$r[4] = trim($d['data_tweet_index_net']);
			$r[5] = trim($d['data_tweet_sentiment']);
            array_push($result, $r);
            $i++;
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
	}

	function _get_list_tweet_bayes()
	{
		$idsearch = $this->input->post('idsearch');
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
				FROM data_tweet where data_tweet_id_search = '".$idsearch."'";
		if($search['value'] != ""){
            $query .=preg_match("/WHERE/i",$query)? " AND ":" WHERE ";
			$query .= "(stopword = '". $search['value'] ."')";
		}
        // OR PROGRAM_TAHUN LIKE '%". strtolower($search) ."%'
		// var_dump($order);
		// if($order[0]['column']){
  //           $query.= " order by 
  //               ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
  //       }

        $iTotalRecords = $this->db->query("SELECT COUNT(*) AS JUMLAH FROM (".$query.") A")->row()->JUMLAH;

        $query .= " LIMIT ". ($start) .",".($iDisplayLength);
        
        $data = $this->db->query($query)->result_array();
        $i = $start + 1;
        $result = array();
        foreach ($data as $d) {
            $r = array();
			$r[0] = $i;
			$r[1] = trim($d['data_tweet_text']);
			$r[2] = trim($d['data_tweet_index_pos_bayes']);
			$r[3] = trim($d['data_tweet_index_neg_bayes']);
			$r[4] = trim($d['data_tweet_index_net_bayes']);
			$r[5] = trim($d['data_tweet_sentiment_bayes']);
            array_push($result, $r);
            $i++;
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
	}

	function history()
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
				FROM data_search";
		if($search['value'] != ""){
            $query .=preg_match("/WHERE/i",$query)? " AND ":" WHERE ";
			$query .= "(data_search_query like '%". $search['value'] ."%')";
		}
        // OR PROGRAM_TAHUN LIKE '%". strtolower($search) ."%'
		// var_dump($order);
		// if($order[0]['column']){
  //           $query.= " order by 
  //               ".$dataorder[$order[0]["column"]]." ".$order[0]["dir"];
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
			$r[1] = trim($d['data_search_query']);
			$r[2] = trim($d['data_search_tgl']);
			$r[3] = trim($d['data_search_pos']).$posbayes;
			$r[4] = trim($d['data_search_neg']).$negbayes;
			$r[5] = trim($d['data_search_net']).$netbayes;
			$r[6] = trim($d['data_search_sentiment']).$sentbayes;
			$r[7] = '<a class="btn btn-info btndetail" href="'.base_url().'klasifikasi/detailklasifikasi/'.$d['data_search_id'].'">Detail</a>'.$btnbayes;
            array_push($result, $r);
            $i++;
        }

        $records["data"] = $result;
        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        return $records;
	}

	public function analyzetweet($idsearch='')
	{
		$this->db->where('data_tweet_id_search', $idsearch);
		$datatweet = $this->db->get('data_tweet');
		$tweetclear = array();
		foreach ($datatweet->result() as $r) {
			$data['id'] = $r->data_tweet_id;
			$data['word'] = $this->preprocessing($r->data_tweet_text);
			array_push($tweetclear, $data);
		}
		$hitung = $this->text_classification($tweetclear,$idsearch);
		$result = $this->db->query("SELECT data_search_pos,data_search_neg,data_search_net,data_search_sentiment from data_search where data_search_id = ".$idsearch);
		return $result->row();
	}

	public function analyzetweet_bayes($idsearch='')
	{
		$this->db->where('data_tweet_id_search', $idsearch);
		$datatweet = $this->db->get('data_tweet');
		$tweetclear = array();
		foreach ($datatweet->result() as $r) {
			$data['id'] = $r->data_tweet_id;
			$data['word'] = $this->preprocessing($r->data_tweet_text);
			array_push($tweetclear, $data);
		}
		$this->text_classification_naivebayes($tweetclear,$idsearch);
		$this->db->query("UPDATE data_search set data_search_naive_bayes = 1 where data_search_id = '".$idsearch."'");
		if ($this->db->affected_rows() > 0) {
			$result = array('msg'=>true);
		}else{
			$result = array('msg'=>false);
		}
		return $result;
	}

	public function analyzetraining()
	{
		$this->db->where('data_testing_analis_index_case', 'kelima');
		$datatweet = $this->db->get('data_testing_analis');
		$tweetclear = array();
		foreach ($datatweet->result() as $r) {
			$data['word'] = $this->preprocessing($r->data_testing_analis_text);
			$data['id'] =$r->data_testing_analis_id;
			array_push($tweetclear, $data);
		}
		$hitung = $this->text_classification_training($tweetclear);
		return array('msg'=>'ok');
	}

	public function analyzetweet_trainingbayes()
	{
		$this->db->where('data_testing_analis_index_case', 'ketiga');
		$datatweet = $this->db->get('data_testing_analis');
		$tweetclear = array();
		foreach ($datatweet->result() as $r) {
			$data['word'] = $this->preprocessing($r->data_testing_analis_text);
			$data['id'] =$r->data_testing_analis_id;
			array_push($tweetclear, $data);
		}
		$hitung = $this->text_classification_bayestraining($tweetclear);
		return array('msg'=>'ok');
	}

	function preprocessing($word='')
	{
		if (!$word) {
			$word = 'Another mention for Apple Store: http://t.co/fiIOApKt - RT @floridamike Once again getting great customer service from the @apple #store ...';
		}
		$word = strtolower($word);
		$word = preg_replace('((www\.[^\s]+)|(https?://[^\s]+))', '', $word); //hapus url
		$word = preg_replace('(@[^\s]+)','', $word); // hapus mention
		$word = str_replace(array('.',',',"!","?",";"),array('','','','',''), $word);
		// $word = str_replace(array('.',',',"'","!"),array('','',"''",''), $word);
		// $word = preg_replace('([\s]+)', '', $word); // hapus withe spaces
		$word = preg_replace('(#([^\s]+))', '', $word); // hapus #
		return $word;
	}

	function text_classification($data=array(),$idsearch=0)
	{
		$searchpos = 0;
		$searchneg = 0;
		$searchnet = 0;
		$getstopword = $this->db->get('stopwords');
		$stopword = array();
		foreach ($getstopword->result() as $r) {
			array_push($stopword, $r->stopword);
		}
		$getdictionaryword = $this->db->get("simple_sentiword");
		$dictionaryword = array();
		foreach ($getdictionaryword->result() as $r) {
			$dictionaryword[$r->simple_sentiword_word] = $r->simple_sentiword_score;
		}
		foreach ($data as $key => $value) {
			$word = explode(" ", $value['word']);
			$totalpos = 0;
			$totalneg = 0;
			$totalnet = 0;
			$totalscore = 0;
			foreach ($word as $key1 => $value1) {
				if (in_array($value1, $stopword)) { //jika stopword maka lewati
				    continue;
				}
				$temptotal = 0;
				if (@$dictionaryword[$value1."#a"]) {
					$temptotal += $dictionaryword[$value1."#a"];
				}
				if (@$dictionaryword[$value1."#n"]) {
					$temptotal += $dictionaryword[$value1."#n"];
				}
				if (@$dictionaryword[$value1."#r"]) {
					$temptotal += $dictionaryword[$value1."#r"];
				}
				if (@$dictionaryword[$value1."#v"]) {
					$temptotal += $dictionaryword[$value1."#v"];
				}
				if ($temptotal == 0) {
					$totalnet++;
				}else if($temptotal > 0){
					$totalpos++;
				}else if($temptotal < 0){
					$totalneg++;
				}
				$totalscore += $temptotal;
			}
			$dataupdate = array();
			$dataupdate['data_tweet_index_pos'] = $totalpos;
			$dataupdate['data_tweet_index_neg'] = $totalneg;
			$dataupdate['data_tweet_index_net'] = $totalnet;
			$dataupdate['data_tweet_score'] = $totalscore;
			if ($totalscore == 0) {
				$searchnet++;
				$dataupdate['data_tweet_sentiment'] = 'NETRAL';
			}else if($totalscore > 0){
				$searchpos++;
				$dataupdate['data_tweet_sentiment'] = 'POSITIF';
			}else if($totalscore < 0){
				$searchneg++;
				$dataupdate['data_tweet_sentiment'] = 'NEGATIF';
			}
			if ($totalpos == 0 && $totalneg == 0) {
				$dataupdate['data_tweet_issentiment'] = 0;
			}
			$this->db->where('data_tweet_id', $value['id']);
			$this->db->update('data_tweet', $dataupdate);
		}
		$tertinggi = max(array($searchpos,$searchneg,$searchnet));
		if ($tertinggi == $searchpos) {
			$sentiment = 'POSITIF';
		}else if($tertinggi == $searchneg) {
			$sentiment = 'NEGATIF';
		}else if($tertinggi == $searchnet) {
			$sentiment = 'NETRAL';
		}
		$dataupdate = array();
		$dataupdate['data_search_pos'] = $searchpos;
		$dataupdate['data_search_neg'] = $searchneg;
		$dataupdate['data_search_net'] = $searchnet;
		$dataupdate['data_search_sentiment'] = $sentiment;
		$this->db->where('data_search_id', $idsearch);
		$this->db->update('data_search', $dataupdate);
		return true;
	}

	function text_classification_training($data=array())
	{
		// var_dump($data);
		$getstopword = $this->db->get('stopwords');
		$stopword = array();
		foreach ($getstopword->result() as $r) {
			array_push($stopword, $r->stopword);
		}
		$getdictionaryword = $this->db->get("simple_sentiword");
		$dictionaryword = array();
		foreach ($getdictionaryword->result() as $r) {
			$dictionaryword[$r->simple_sentiword_word] = $r->simple_sentiword_score;
		}
		foreach ($data as $key => $value) {
			$word = explode(" ", $value['word']);
			$totalpos = 0;
			$totalneg = 0;
			$totalnet = 0;
			$totalscore = 0;
			foreach ($word as $key1 => $value1) {
				if (in_array($value1, $stopword)) { //jika stopword maka lewati
				    continue;
				}
				$temptotal = 0;
				if (@$dictionaryword[$value1."#a"]) {
					$temptotal += $dictionaryword[$value1."#a"];
				}
				if (@$dictionaryword[$value1."#n"]) {
					$temptotal += $dictionaryword[$value1."#n"];
				}
				if (@$dictionaryword[$value1."#r"]) {
					$temptotal += $dictionaryword[$value1."#r"];
				}
				if (@$dictionaryword[$value1."#v"]) {
					$temptotal += $dictionaryword[$value1."#v"];
				}
				if ($temptotal == 0) {
					$totalnet++;
				}else if($temptotal > 0){
					$totalpos++;
				}else if($temptotal < 0){
					$totalneg++;
				}
				$totalscore += $temptotal;
			}
			$dataupdate = array();
			$dataupdate['data_testing_analis_index_pos'] = $totalpos;
			$dataupdate['data_testing_analis_index_neg'] = $totalneg;
			$dataupdate['data_testing_analis_index_net'] = $totalnet;
			if ($totalscore == 0) {
				$dataupdate['data_testing_analis_sentiment_sentiword'] = 'NETRAL';
			}else if($totalscore > 0){
				$dataupdate['data_testing_analis_sentiment_sentiword'] = 'POSITIF';
			}else if($totalscore < 0){
				$dataupdate['data_testing_analis_sentiment_sentiword'] = 'NEGATIF';
			}

			$this->db->where('data_testing_analis_id', $value['id']);
			$this->db->update('data_testing_analis', $dataupdate);
		}
		return true;
	}

	function text_classification_naivebayes($data=array(),$idsearch = 0)
	{
		$searchpos = 0;
		$searchneg = 0;
		$searchnet = 0;
		$getstopword = $this->db->get('stopwords');
		$stopword = array();
		foreach ($getstopword->result() as $r) {
			array_push($stopword, $r->stopword);
		}
		
		$totaltrain = (int)$this->db->query("select count(*) as jumlah from data_train")->row()->jumlah;
        $totalposs = (int)$this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'POSITIF'")->row()->jumlah;
        $totalnegg = (int)$this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'NEGATIF'")->row()->jumlah;
        $totalnett = (int)$this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'NETRAL'")->row()->jumlah;

		foreach ($data as $key => $value) {
			$word = explode(" ", $value['word']);
			$totalpos = 0;
			$totalneg = 0;
			$totalnet = 0;
			$scorebayes = 0;
			foreach ($word as $key1 => $value1) {
				if (in_array($value1, $stopword)) { //jika stopword maka lewati
				    continue;
				}
				$ppos = (int)$this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value1)."%' and train_sentiment_desc = 'POSITIF'")->row()->jumlah;
	            $pneg = (int)$this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value1)."%' and train_sentiment_desc = 'NEGATIF'")->row()->jumlah;
	            $pnet = (int)$this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value1)."%' and train_sentiment_desc = 'NETRAL'")->row()->jumlah;
				
				if ($ppos == 0) {
	            	$probabilitypos = 0;
	            }else{
	                $probabilitypos = (double)(($ppos/$totalposs) * ($totalposs/$totaltrain));
	            }
	            if ($pneg == 0) {
	            	$probabilityneg = 0;
	            }else{
	                $probabilityneg = (double)(($pneg/$totalnegg) * ($totalnegg/$totaltrain));
	            }
	            if ($pnet == 0) {
	            	$probabilitynet = 0;
	            }else{
	                $probabilitynet = (double)(($pnet/$totalnett) * ($totalnett/$totaltrain));
	            }
	            $tertinggi = max(array($probabilitynet,$probabilitypos,$probabilityneg));
	            $finalsentiment='';
	            if ($tertinggi == 0) {
	            	$totalnet++;
	            }else{
	                if ($tertinggi == $probabilitypos) {
						$totalpos++;
	                }else if($tertinggi == $probabilityneg){
						$totalneg++;
	                }else if($tertinggi == $probabilitynet){
						$totalnet++;
	                }else{
						$totalnet++;
					}
				}

				$scorebayes+=$tertinggi;
			}
			$dataupdate = array();
			$dataupdate['data_tweet_index_pos_bayes'] = $totalpos;
			$dataupdate['data_tweet_index_neg_bayes'] = $totalneg;
			$dataupdate['data_tweet_index_net_bayes'] = $totalnet;
			$dataupdate['data_tweet_score_bayes'] = $scorebayes;
			if ($totalpos == $totalneg) {
				$dataupdate['data_tweet_sentiment_bayes'] = 'NETRAL';
				$searchnet++;
			}else if($totalpos > $totalneg){
				$dataupdate['data_tweet_sentiment_bayes'] = 'POSITIF';
				$searchpos++;
			}else if($totalpos < $totalneg){
				$dataupdate['data_tweet_sentiment_bayes'] = 'NEGATIF';
				$searchneg++;
			}
			// if ($totalpos == 0 && $totalneg == 0) {
			// 	$dataupdate['data_tweet_issentiment'] = 0;
			// }
			$this->db->where('data_tweet_id', $value['id']);
			$this->db->update('data_tweet', $dataupdate);
		}
		$tertinggi = max(array($searchpos,$searchneg,$searchnet));
		if ($tertinggi == $searchpos) {
			$sentiment = 'POSITIF';
		}else if($tertinggi == $searchneg) {
			$sentiment = 'NEGATIF';
		}else if($tertinggi == $searchnet) {
			$sentiment = 'NETRAL';
		}
		$dataupdate = array();
		$dataupdate['data_search_pos_bayes'] = $searchpos;
		$dataupdate['data_search_neg_bayes'] = $searchneg;
		$dataupdate['data_search_net_bayes'] = $searchnet;
		$dataupdate['data_search_sentiment_bayes'] = $sentiment;
		$this->db->where('data_search_id', $idsearch);
		$this->db->update('data_search', $dataupdate);
		return true;
	}

	function text_classification_bayestraining($data=array())
	{
		$getstopword = $this->db->get('stopwords');
		$stopword = array();
		foreach ($getstopword->result() as $r) {
			array_push($stopword, $r->stopword);
		}
		$gettotal = $this->db->query("select final_sentiword_sentiment,count(final_sentiword_sentiment) as jumlah from final_sentiword group by final_sentiword_sentiment
					union select 'TOTAL',count(*) from final_sentiword");
		$datatotal = array();
		foreach ($gettotal->result() as $r) {
			$datatotal[$r->final_sentiword_sentiment] = $r->jumlah;
		}
		foreach ($data as $key => $value) {
			$word = explode(" ", $value['word']);
			$totalpos = 0;
			$totalneg = 0;
			$totalnet = 0;
			foreach ($word as $key1 => $value1) {
				if (in_array($value1, $stopword)) { //jika stopword maka lewati
				    continue;
				}
				$gettotalsentimen = $this->db->query("SELECT 'POSITIF' as sentiment,count(final_sentiword_sentiment) as jumlah FROM final_sentiword WHERE final_sentiword_word = '".str_replace("'", "''", $value1)."' AND final_sentiword_sentiment ='POSITIF'
				UNION ALL SELECT 'NEGATIF',count(final_sentiword_sentiment) as jumlah FROM final_sentiword WHERE final_sentiword_word = '".str_replace("'", "''", $value1)."' AND final_sentiword_sentiment ='NEGATIF'
				UNION ALL SELECT 'NETRAL',count(final_sentiword_sentiment) as jumlah FROM final_sentiword WHERE final_sentiword_word = '".str_replace("'", "''", $value1)."' AND final_sentiword_sentiment ='NETRAL'");
				$nilai = array();
				// foreach ($gettotalsentimen->result() as $r) {
				// 	$hasilhitung = ($r->jumlah / $datatotal[$r->sentiment]) * ($datatotal[$r->sentiment] / $datatotal['TOTAL']);
				// 	array_push($nilai, $hasilhitung);
				// }
				if ($gettotalsentimen->num_rows() > 0) {
					foreach ($gettotalsentimen->result() as $r) {
						$hasilhitung = ($r->jumlah / $datatotal[$r->sentiment]) * ($datatotal[$r->sentiment] / $datatotal['TOTAL']);
						array_push($nilai, $hasilhitung);
					}
				}else{
					array_push($nilai, 0);
				}
				// var_dump($nilai);
				$sentimen_tinggi = max($nilai);
				if ($sentimen_tinggi) {
					if (array_search($sentimen_tinggi, $nilai) == 0) {
						$totalpos++;
					}else if(array_search($sentimen_tinggi, $nilai) == 1){
						$totalneg++;
					}else if(array_search($sentimen_tinggi, $nilai) == 2){
						$totalnet++;
					}
				}else{
					$totalnet++;
				}
			}
			$dataupdate = array();
			$dataupdate['data_testing_analis_index_pos_bayes'] = $totalpos;
			$dataupdate['data_testing_analis_index_neg_bayes'] = $totalneg;
			$dataupdate['data_testing_analis_index_net_bayes'] = $totalnet;
			if ($totalpos == $totalneg) {
				$dataupdate['data_testing_analis_sentiment_bayes'] = 'NETRAL';
			}else if($totalpos > $totalneg){
				$dataupdate['data_testing_analis_sentiment_bayes'] = 'POSITIF';
			}else if($totalpos < $totalneg){
				$dataupdate['data_testing_analis_sentiment_bayes'] = 'NEGATIF';
			}

			$this->db->where('data_testing_analis_id', $value['id']);
			$this->db->update('data_testing_analis', $dataupdate);
		}
		return true;
	}

	function text_classification_single($word='')
	{
		$result = array();
		$result['data'] = array();
		$getstopword = $this->db->get('stopwords');
		$stopword = array();
		foreach ($getstopword->result() as $r) {
			array_push($stopword, $r->stopword);
		}
		$getdictionaryword = $this->db->get("simple_sentiword");
		$dictionaryword = array();
		foreach ($getdictionaryword->result() as $r) {
			$dictionaryword[$r->simple_sentiword_word] = $r->simple_sentiword_score;
		}

		$word = explode(" ", $word);
		$totalpos = 0;
		$totalneg = 0;
		$totalnet = 0;
		$totalscore = 0;
		foreach ($word as $key1 => $value1) {
			if (in_array($value1, $stopword)) { //jika stopword maka lewati
			    continue;
			}
			$temptotal = 0;
			if (@$dictionaryword[$value1."#a"]) {
				$temptotal += $dictionaryword[$value1."#a"];
			}
			if (@$dictionaryword[$value1."#n"]) {
				$temptotal += $dictionaryword[$value1."#n"];
			}
			if (@$dictionaryword[$value1."#r"]) {
				$temptotal += $dictionaryword[$value1."#r"];
			}
			if (@$dictionaryword[$value1."#v"]) {
				$temptotal += $dictionaryword[$value1."#v"];
			}
			if ($temptotal == 0) {
				$sentiment = 'Netral';
			}else if($temptotal > 0){
				$sentiment = 'Positif';
			}else if($temptotal < 0){
				$sentiment = 'Negatif';
			}
			$tempresult = array();
			$tempresult['kata'] = $value1;
			$tempresult['index'] = $temptotal;
			$tempresult['sentiment'] = $sentiment;
			$totalscore += $temptotal;
			array_push($result['data'], $tempresult);
		}

		if ($totalscore == 0) {
			$result['kesimpulan'] = 'Netral';
		}else if($totalscore > 0){
			$result['kesimpulan'] = 'Positif';
		}else if($totalscore < 0){
			$result['kesimpulan'] = 'Negatif';
		}
		return $result;
	}

// 	function text_classification_bayes_single($word='')
// 	{
// 		$result = array();
// 		$result['data'] = array();
// 		$getstopword = $this->db->get('stopwords');
// 		$stopword = array();
// 		foreach ($getstopword->result() as $r) {
// 			array_push($stopword, $r->stopword);
// 		}
// 		// $gettotal = $this->db->query("select final_sentiword_sentiment,count(final_sentiword_sentiment) as jumlah from final_sentiword group by final_sentiword_sentiment
// 		// 			union select 'TOTAL',count(*) from final_sentiword");
// 		$gettotal = $this->db->query("select 'POSITIF' as final_sentiword_sentiment,sum(final_sentiword_jumlah_pos) as jumlah from final_sentiword union
// select 'NEGATIF' as final_sentiword_sentiment,sum(final_sentiword_jumlah_neg) as jumlah from final_sentiword union
// select 'NETRAL' as final_sentiword_sentiment,sum(final_sentiword_jumlah_net) as jumlah from final_sentiword
// 					union select 'TOTAL' as final_sentiword_sentiment,sum(final_sentiword_jumlah_neg+final_sentiword_jumlah_net+final_sentiword_jumlah_pos) from final_sentiword");
// 		$datatotal = array();
// 		foreach ($gettotal->result() as $r) {
// 			$datatotal[$r->final_sentiword_sentiment] = $r->jumlah;
// 		}

// 		$word = explode(" ", $word);
// 		$totalpos = 0;
// 		$totalneg = 0;
// 		$totalnet = 0;
// 		foreach ($word as $key1 => $value1) {
// 			if (in_array($value1, $stopword)) { //jika stopword maka lewati
// 			    continue;
// 			}
// 			$gettotalsentimen = $this->db->query("SELECT 'POSITIF' as sentiment,final_sentiword_jumlah_pos as jumlah FROM final_sentiword WHERE final_sentiword_word = '".str_replace("'", "''", $value1)."'
// 			UNION ALL SELECT 'NEGATIF',final_sentiword_jumlah_neg as jumlah FROM final_sentiword WHERE final_sentiword_word = '".str_replace("'", "''", $value1)."'
// 			UNION ALL SELECT 'NETRAL',final_sentiword_jumlah_net as jumlah FROM final_sentiword WHERE final_sentiword_word = '".str_replace("'", "''", $value1)."'");
// 			$nilai = array();
// 			if ($gettotalsentimen->num_rows() > 0) {
// 				foreach ($gettotalsentimen->result() as $r) {
// 					$hasilhitung = ($r->jumlah / $datatotal[$r->sentiment]) * ($datatotal[$r->sentiment] / $datatotal['TOTAL']);
// 					array_push($nilai, $hasilhitung);
// 				}
// 			}else{
// 				array_push($nilai, 0);
// 			}
// 			$sentimen_tinggi = max($nilai);
// 			if ($sentimen_tinggi) {
// 				if (array_search($sentimen_tinggi, $nilai) == 0) {
// 					$sentiment = 'Positif';
// 					$totalpos++;
// 				}else if(array_search($sentimen_tinggi, $nilai) == 1){
// 					$sentiment = 'Negatif';
// 					$totalneg++;
// 				}else if(array_search($sentimen_tinggi, $nilai) == 2){
// 					$sentiment = 'Netral';
// 					$totalnet;
// 				}
// 			}else{
// 				$sentiment = 'Netral';
// 				$totalnet++;
// 			}
// 			$tempresult = array();
// 			$tempresult['kata'] = $value1;
// 			$tempresult['index'] = $sentimen_tinggi;
// 			$tempresult['sentiment'] = $sentiment;
// 			array_push($result['data'], $tempresult);
// 		}
// 		if ($totalpos == $totalneg) {
// 			$result['kesimpulan'] = 'Netral';
// 		}else if($totalpos > $totalneg){
// 			$result['kesimpulan'] = 'Positif';
// 		}else if($totalpos < $totalneg){
// 			$result['kesimpulan'] = 'Negatif';
// 		}

// 		return $result;
// 	}

	function text_classification_bayes_single($word='')
	{
		$result = array();
		$result['data'] = array();
		$getstopword = $this->db->get('stopwords');
		$stopword = array();
		foreach ($getstopword->result() as $r) {
			array_push($stopword, $r->stopword);
		}
		
		$totaltrain = (int)$this->db->query("select count(*) as jumlah from data_train")->row()->jumlah;
        $totalposs = (int)$this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'POSITIF'")->row()->jumlah;
        $totalnegg = (int)$this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'NEGATIF'")->row()->jumlah;
        $totalnett = (int)$this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'NETRAL'")->row()->jumlah;

		$word = explode(" ", $word);
		$totalpos = 0;
		$totalneg = 0;
		$totalnet = 0;
		foreach ($word as $key1 => $value1) {
			if (in_array($value1, $stopword)) { //jika stopword maka lewati
			    continue;
			}
			$ppos = (int)$this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value1)."%' and train_sentiment_desc = 'POSITIF'")->row()->jumlah;
            $pneg = (int)$this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value1)."%' and train_sentiment_desc = 'NEGATIF'")->row()->jumlah;
            $pnet = (int)$this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value1)."%' and train_sentiment_desc = 'NETRAL'")->row()->jumlah;
			
			if ($ppos == 0) {
            	$probabilitypos = 0;
            }else{
                $probabilitypos = (double)(($ppos/$totalposs) * ($totalposs/$totaltrain));
            }
            if ($pneg == 0) {
            	$probabilityneg = 0;
            }else{
                $probabilityneg = (double)(($pneg/$totalnegg) * ($totalnegg/$totaltrain));
            }
            if ($pnet == 0) {
            	$probabilitynet = 0;
            }else{
                $probabilitynet = (double)(($pnet/$totalnett) * ($totalnett/$totaltrain));
            }
            $tertinggi = max(array($probabilitynet,$probabilitypos,$probabilityneg));
            $finalsentiment='';
            if ($tertinggi == 0) {
                $sentiment = 'Netral';
            	$totalnet++;
            }else{
                if ($tertinggi == $probabilitypos) {
					$totalpos++;
                    $sentiment = 'Positif';
                }else if($tertinggi == $probabilityneg){
                    $sentiment = 'Negatif';
					$totalneg++;
                }else if($tertinggi == $probabilitynet){
                    $sentiment = 'Netral';
					$totalnet++;
                }else{
                	$sentiment = 'Netral';
					$totalnet++;
				}
			}

			$tempresult = array();
			$tempresult['kata'] = $value1;
			$tempresult['index'] = $tertinggi;
			$tempresult['sentiment'] = $sentiment;
			array_push($result['data'], $tempresult);
		}
		if ($totalpos == $totalneg) {
			$result['kesimpulan'] = 'Netral';
		}else if($totalpos > $totalneg){
			$result['kesimpulan'] = 'Positif';
		}else if($totalpos < $totalneg){
			$result['kesimpulan'] = 'Negatif';
		}

		return $result;
	}

	public function get_data_search($where=array())
	{
		if (count($where) > 0) {
			$this->db->where($where);
		}
		$result = $this->db->get('data_search');
		if ($result->num_rows() > 0) {
			return $result->row();
		}else{
			return false;
		}
	}

	public function analyzetweet_trainingbayesnew()
	{
		$this->db->where('data_testing_analis_index_case', 'keenam');
		$datatweet = $this->db->get('data_testing_analis');
		$tweetclear = array();
		foreach ($datatweet->result() as $r) {
			$data['word'] = $this->preprocessing($r->data_testing_analis_text);
			$data['id'] =$r->data_testing_analis_id;
			array_push($tweetclear, $data);
		}
		$hitung = $this->text_classification_bayestrainingnew($tweetclear);
		return array('msg'=>'ok');
	}

	function text_classification_bayestrainingnew($data=array())
	{
		$getstopword = $this->db->get('stopwords');
		$stopword = array();
		foreach ($getstopword->result() as $r) {
			array_push($stopword, $r->stopword);
		}
		$totaltrain = (int)$this->db->query("select count(*) as jumlah from data_train")->row()->jumlah;
        $totalposs = (int)$this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'POSITIF'")->row()->jumlah;
        $totalnegg = (int)$this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'NEGATIF'")->row()->jumlah;
        $totalnett = (int)$this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'NETRAL'")->row()->jumlah;

		foreach ($data as $key => $value) {
			$word = explode(" ", $value['word']);
			$totalpos = 0;
			$totalneg = 0;
			$totalnet = 0;
			foreach ($word as $key1 => $value1) {
				if (in_array($value1, $stopword)) { //jika stopword maka lewati
				    continue;
				}
				$value1 = $this->stemmerr->stem($value1);
				$ppos = (int)$this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value1)."%' and train_sentiment_desc = 'POSITIF'")->row()->jumlah;
                $pneg = (int)$this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value1)."%' and train_sentiment_desc = 'NEGATIF'")->row()->jumlah;
                $pnet = (int)$this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value1)."%' and train_sentiment_desc = 'NETRAL'")->row()->jumlah;

                if ($ppos == "0") {
                	$probabilitypos = 0;
                }else{
	                $probabilitypos = (double)(($ppos/$totalposs) * ($totalposs/$totaltrain));
	            }
	            if ($pneg == "0") {
	            	$probabilityneg = 0;
	            }else{
	                $probabilityneg = (double)(($pneg/$totalnegg) * ($totalnegg/$totaltrain));
	            }
	            if ($pnet == "0") {
	            	$probabilitynet = 0;
	            }else{
	                $probabilitynet = (double)(($pnet/$totalnett) * ($totalnett/$totaltrain));
	            }
                $tertinggi = max(array($probabilitynet,$probabilitypos,$probabilityneg));
                $finalsentiment='';
                if ($tertinggi == 0) {
                	$totalnet++;
                }else{
	                if ($tertinggi == $probabilitypos) {
						$totalpos++;
	                    $finalsentiment = 'POSITIF';
	                }else if($tertinggi == $probabilityneg){
	                    $finalsentiment = 'NEGATIF';
						$totalneg++;
	                }else if($tertinggi == $probabilitynet){
	                    $finalsentiment = 'NETRAL';
						$totalnet++;
	                }else{
						$totalnet++;
					}
				}
			}
			$dataupdate = array();
			$dataupdate['data_testing_analis_index_pos_bayes'] = $totalpos;
			$dataupdate['data_testing_analis_index_neg_bayes'] = $totalneg;
			$dataupdate['data_testing_analis_index_net_bayes'] = $totalnet;
			if ($totalpos == $totalneg) {
				$dataupdate['data_testing_analis_sentiment_bayes'] = 'NETRAL';
			}else if($totalpos > $totalneg){
				$dataupdate['data_testing_analis_sentiment_bayes'] = 'POSITIF';
			}else if($totalpos < $totalneg){
				$dataupdate['data_testing_analis_sentiment_bayes'] = 'NEGATIF';
			}

			$this->db->where('data_testing_analis_id', $value['id']);
			$this->db->update('data_testing_analis', $dataupdate);
		}
		return true;
	}

	function _get_list_tweet_pdf($idsearch)
	{
		$query = "SELECT *
				FROM data_tweet where data_tweet_id_search = '".$idsearch."'";
		$records = $this->db->query($query);
        return $records;
	}

	function _get_list_tweet_bayes_pdf($idsearch)
	{
		$query = "SELECT *
				FROM data_tweet where data_tweet_id_search = '".$idsearch."'";
		$records = $this->db->query($query);
        return $records;
	}
}

/* End of file m_klasifikasi.php */
/* Location: ./application/models/m_klasifikasi.php */