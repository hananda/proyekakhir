<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(-1);

class Klasifikasi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->library('PorterStemmer');
		$this->load->model('m_klasifikasi');
	}

	function index()
	{
		$this->load->model('smartphone');
		$data = array();
		$data['produk'] = $this->smartphone->getproduk();
		$data['content'] = $this->load->view('klasifikasi',$data,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	function history()
	{
		$data = array();
		$data['content'] = $this->load->view('history',$data,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	function cek_kata()
	{
		$data = array();
		$data['content'] = $this->load->view('cek_kata',$data,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	function text_processing()
	{
		$data = array();
		$data['content'] = $this->load->view('text_processing',$data,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	function text_processing_proses()
	{
		$word = $this->input->post('kata');
		$getstopword = $this->db->get('stopwords');
		$liststopword = array();
		foreach ($getstopword->result() as $r) {
			array_push($liststopword, $r->stopword);
		}
		$word = $this->m_klasifikasi->preprocessing($word);
		$tokenizing = explode(" ", $word);
		$stemming = array();
		$stopword = array();
		$lastword = array();
		$unknown = array();
    	// echo $coba->stem('connecting');
		foreach ($tokenizing as $key => $value) {
			if (in_array($value, $liststopword)) { //jika stopword maka lewati
			    array_push($stopword, $value);
			    continue;
			}
			$r_stem = $this->porterstemmer->stem($value);
			if ($r_stem != $value) {
				array_push($stemming, array('kataawal'=>$value,'kataakhir'=>$r_stem));
				$value = $r_stem;
			}
			$cekkata = $this->db->query("select * from final_sentiword where final_sentiword_word = '".$value."'");
			if ($cekkata->num_rows() == 0) {
				array_push($unknown, $value);
			}
			array_push($lastword, $value);
		}
		$data['tokenizing'] = $tokenizing;
		$data['stemming'] = $stemming;
		$data['stopword'] = $stopword;
		$data['unknown'] = $unknown;
		$data['lastword'] = $lastword;
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function detailklasifikasi($idsearch=0)
	{
		$data = array();
		$data['idsearch'] = $idsearch;
		$data['datasearch'] = $this->m_klasifikasi->get_data_search(array('data_search_id'=>$idsearch));
		$data['content'] = $this->load->view('detailklasifikasi',$data,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	function testing($word='')
	{
		if (!$word) {
			$word = 'Another mention for Apple Store: http://t.co/fiIOApKt - RT @floridamike Once again getting great customer service from the @apple #store ...';
		}
		$word = strtolower($word);
		$word = preg_replace('((www\.[^\s]+)|(https?://[^\s]+))', 'URL', $word); //hapus url
		$word = preg_replace('(@[^\s]+)','AT_USER', $word); // hapus mention
		$word = preg_replace('([\s]+)', ' ', $word); // hapus withe spaces
		$word = preg_replace('(#([^\s]+))', '\1', $word); // hapus #
		echo $word;
	}

	function search()
	{
		$this->load->library('Twitter_Lib');
		$msg = array();
		$dataparam = array();
		$dataparam['until'] = $this->input->post('tgl');
		$dataparam['q'] = $this->input->post('q');
		$dataparam['count'] = $this->input->post('count');
		$idproduk = $this->db->query("SELECT m_produk_id from m_produk where UPPER(m_produk_nama) = '".strtoupper($dataparam['q'])."'")->row()->m_produk_id;

		$data = json_decode($this->twitter_lib->search_tweet($dataparam));
		
		$datasearch['query'] = json_encode($dataparam);
		$datasearch['idproduk'] = $idproduk;
		$idsearch = $this->m_klasifikasi->save_search($datasearch);
		if (!$idsearch) {
			$msg['tipe'] = 'danger';
			$msg['msg'] = 'gagal insert data';
			$this->output->set_content_type('application/json')->set_output(json_encode($msg));return;
		}
		if (count($data->statuses) == 0) {
			$msg['tipe'] = 'danger';
			$msg['msg'] = 'Tidak Menemukan tweet';
			$this->output->set_content_type('application/json')->set_output(json_encode($msg));return;
		}
		foreach ($data->statuses as $key => $value) {
			$datatweet = array();
			$datatweet['text'] = $value->text;
			$datatweet['user'] = $value->user->name;
			$datatweet['idsearch'] = $idsearch;
			$datatweet['datepost'] = date('Y-m-d',strtotime($value->created_at));
			$idtweet = $this->m_klasifikasi->save_tweet($datatweet);
		}
		// var_dump($data);
		$msg['tipe'] = 'success';
		$msg['msg'] = 'Berhasil Mengambil Tweet';
		$msg['idsearch'] = $idsearch;
		$this->output->set_content_type('application/json')->set_output(json_encode($msg));
	}

	public function search_gsmarena()
	{
		$msg = array();
		$dataparam = array();
		$dataparam['q'] = $this->input->post('q');
		$dataparam['count'] = $this->input->post('count');
		$dataproduk = $this->db->query("SELECT * from m_produk where UPPER(m_produk_nama) = '".strtoupper($dataparam['q'])."'")->row();
		$urlreviews = $dataproduk->m_produk_url_reviews;
		$sisa = $dataparam['count'] % 20;
		$jmlhal = ($dataparam['count'] - $sisa) / 20;
		$jmltotal = $jmlhal+1;
		// echo $sisa.'<br>';4
		// echo $jmlhal.'<br>';2
		// echo $jmltotal.'<br>';3
		// die();
		$datasearch['query'] = json_encode($dataparam);
		$datasearch['idproduk'] = $dataproduk->m_produk_id;
		$idsearch = $this->m_klasifikasi->save_search($datasearch);
		if (!$idsearch) {
			$msg['tipe'] = 'danger';
			$msg['msg'] = 'gagal insert data';
			$this->output->set_content_type('application/json')->set_output(json_encode($msg));return;
		}
		$run_count = 0;
		for($i=1;$i<=$jmltotal;$i++){
			$urlreviewss = '';
			if ($i==1) {
				$urlreviewss = $urlreviews;
			}else{
				$urlreviewss = str_replace(".php", "p".$i.".php", $urlreviews);
			}
			$grab = file_get_contents($urlreviewss);
			$grab = explode('
<div id="all-opinions">', $grab);
			$grab = explode('</div>
</div>
<div class="sub-footer no-margin-bottom">',$grab[1]);
			$grab = explode('<div class="user-thread"', $grab[0]);

			$j = 0;
			foreach ($grab as $key => $value) {
				if ($j == 0) {
					$j++;
					continue;
				}
				if ($run_count == $dataparam['count']) {
					break;
				}
				// echo $value;
				$grabkomen = $this->getBetween($value,'<p class="uopin">','</p>');
				$grabkomen = explode("</span>", $grabkomen);
				$grabkomen = $grabkomen[(count($grabkomen)-1)];
				$grabnamauser = $this->getBetween($value,'<li class="uname">','</li>');
				if (!$grabnamauser) {
					$grabnamauser = $this->getBetween($value,'<li class="uname2">','</li>');
				}
				$tgl = $this->getBetween($value,'<time>','</time>');
				// echo $grabkomen.'<br>';
				// echo $grabnamauser.'<br>';
				
				$datatweet = array();
				$datatweet['text'] = $grabkomen;
				$datatweet['user'] = $grabnamauser;
				$datatweet['idsearch'] = $idsearch;
				$datatweet['datepost'] = date('Y-m-d',strtotime($tgl));
				$idtweet = $this->m_klasifikasi->save_tweet($datatweet);
				$run_count++;
				$j++;
			}
		}
		// var_dump($data);
		$msg['tipe'] = 'success';
		$msg['msg'] = 'Berhasil Mengambil Tweet';
		$msg['idsearch'] = $idsearch;
		$this->output->set_content_type('application/json')->set_output(json_encode($msg));
		// $grab = file_get_contents($dataproduk->m_produk_url_reviews);
	}

	function getBetween($content,$start,$end){
	    $r = explode($start, $content);
	    if (isset($r[1])){
	        $r = explode($end, $r[1]);
	        return str_replace('<br>', " ", $r[0]);
	    }
	    return '';
	}

	public function hitungdata($idsearch='')
	{
		// $idsearch = 2;
		$result = $this->m_klasifikasi->analyzetweet($idsearch);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function hitungdata_bayes($idsearch='')
	{
		error_reporting(-1);
		// $idsearch = 3;
		$result = $this->m_klasifikasi->analyzetweet_bayes($idsearch);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function final_sentiword()
	{
		ini_set('memory_limit', '-1');
		$getdictionaryword = $this->db->get("simple_sentiword");
		$dictionaryword = array();
		foreach ($getdictionaryword->result() as $r) {
			$dictionaryword[$r->simple_sentiword_word] = $r->simple_sentiword_score;
		}
        $batas = 0;
		foreach ($getdictionaryword->result() as $r) {
            // if ($batas == 10000) {
            //     break;
            // }
            $state='insert';
            $totalkatapos = 0;
            $totalkataneg = 0;
            $totalkatanet = 0;
			$word = explode("#", $r->simple_sentiword_word);
			$wordword = str_replace("'","''",$word[0]);
			$cekwordexist = $this->db->query("select *  from final_sentiword where final_sentiword_word = '".$wordword."'");
			if ($cekwordexist->num_rows() > 0) {
				$state = 'update';
			}
			$totalscore = 0;

			if (isset($dictionaryword[$word[0]."#a"])) {
				$totalscore += $dictionaryword[$word[0]."#a"];
                if ($dictionaryword[$word[0]."#a"] > 0) {
                    $totalkatapos++;
                }else if($dictionaryword[$word[0]."#a"] < 0){
                    $totalkataneg++;
                }else if($dictionaryword[$word[0]."#a"] == 0){
                    $totalkatanet++;
                }
			}
			if (isset($dictionaryword[$word[0]."#n"])) {
				$totalscore += $dictionaryword[$word[0]."#n"];
                if ($dictionaryword[$word[0]."#n"] > 0) {
                    $totalkatapos++;
                }else if($dictionaryword[$word[0]."#n"] < 0){
                    $totalkataneg++;
                }else if($dictionaryword[$word[0]."#n"] == 0){
                    $totalkatanet++;
                }
			}
			if (isset($dictionaryword[$word[0]."#r"])) {
				$totalscore += $dictionaryword[$word[0]."#r"];
                if ($dictionaryword[$word[0]."#r"] > 0) {
                    $totalkatapos++;
                }else if($dictionaryword[$word[0]."#r"] < 0){
                    $totalkataneg++;
                }else if($dictionaryword[$word[0]."#r"] == 0){
                    $totalkatanet++;
                }
			}
			if (isset($dictionaryword[$word[0]."#v"])) {
				$totalscore += $dictionaryword[$word[0]."#v"];
                if ($dictionaryword[$word[0]."#v"] > 0) {
                    $totalkatapos++;
                }else if($dictionaryword[$word[0]."#v"] < 0){
                    $totalkataneg++;
                }else if($dictionaryword[$word[0]."#v"] == 0){
                    $totalkatanet++;
                }
			}

			$datainsert = array();
			if ($totalscore == 0) {
				$datainsert['final_sentiword_sentiment'] = 'NETRAL';
			}else if($totalscore > 0){
				$datainsert['final_sentiword_sentiment'] = 'POSITIF';
			}else if($totalscore < 0){
				$datainsert['final_sentiword_sentiment'] = 'NEGATIF';
			}
			$datainsert['final_sentiword_score'] = $totalscore;
            $datainsert['final_sentiword_jumlah_pos'] = $totalkatapos;
            $datainsert['final_sentiword_jumlah_neg'] = $totalkataneg;
            $datainsert['final_sentiword_jumlah_net'] = $totalkatanet;
            if ($state == 'insert') {
                $datainsert['final_sentiword_word'] = $word[0];
                $this->db->insert('final_sentiword', $datainsert);
            }else if($state == 'update'){
                $cekwordexist = $cekwordexist->row();
                $this->db->where('final_sentiword_id', $cekwordexist->final_sentiword_id);
                $this->db->update('final_sentiword', $datainsert);
            }
            $batas++;
		}
	}

	public function hitungdatatraining()
	{
		// $idsearch = 2;
		// $result = $this->m_klasifikasi->analyzetraining();
        // $result = $this->m_klasifikasi->analyzetweet_trainingbayes();
		$result = $this->m_klasifikasi->analyzetweet_trainingbayesnew();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function cek_kata_single()
	{
		$word = $this->input->post('kata');
		$word = $this->m_klasifikasi->preprocessing($word);
        $hitung['sentiword'] = $this->m_klasifikasi->text_classification_single($word);
		$hitung['naivebayes'] = $this->m_klasifikasi->text_classification_bayes_single($word);
		$this->output->set_content_type('application/json')->set_output(json_encode($hitung));
	}

    public function learning()
    {
        $totaltrain = $this->db->query("select count(*) as jumlah from data_train")->row()->jumlah;
        $totalpos = $this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'POSITIF'")->row()->jumlah;
        $totalneg = $this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'NEGATIF'")->row()->jumlah;
        $totalnet = $this->db->query("select count(*) as jumlah from data_train where train_sentiment_desc = 'NETRAL'")->row()->jumlah;
        $getdata = $this->db->query("select * from data_train where train_learn = 0 limit 10");
        $getdata = $getdata->result();
        foreach ($getdata as $r) {
            $word = explode(" ", $r->train_phrase);
            foreach ($word as $key => $value) {
                $sudahlearn = $this->db->query("select * from data_learn where data_learn_word = '".str_replace("'", "''", $value)."'");
                if ($sudahlearn->num_rows() > 0) {
                    continue;
                }
                $ppos = $this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value)."%' and train_sentiment_desc = 'POSITIF'")->row()->jumlah;
                $pneg = $this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value)."%' and train_sentiment_desc = 'NEGATIF'")->row()->jumlah;
                $pnet = $this->db->query("select count(*) as jumlah from data_train where train_phrase like '%".str_replace("'", "''", $value)."%' and train_sentiment_desc = 'NETRAL'")->row()->jumlah;
                $probabilitypos = ($ppos/$totalpos) * ($totalpos/$totaltrain);
                $probabilityneg = ($pneg/$totalneg) * ($totalneg/$totaltrain);
                $probabilitynet = ($pnet/$totalnet) * ($totalnet/$totaltrain);
                $tertinggi = max(array($probabilitynet,$probabilitypos,$probabilityneg));
                $finalsentiment='';
                if ($tertinggi == $probabilitypos) {
                    $finalsentiment = 'POSITIF';
                }else if($tertinggi == $probabilityneg){
                    $finalsentiment = 'NEGATIF';
                }else if($tertinggi == $probabilitynet){
                    $finalsentiment = 'NETRAL';
                }
                $this->db->query("insert into data_learn values ('','".str_replace("'", "''", $value)."','POSITIF','".$probabilitypos."','".$finalsentiment."')");
                $this->db->query("insert into data_learn values ('','".str_replace("'", "''", $value)."','NEGATIF','".$probabilityneg."','".$finalsentiment."')");
                $this->db->query("insert into data_learn values ('','".str_replace("'", "''", $value)."','NETRAL','".$probabilitynet."','".$finalsentiment."')");
            }
            $this->db->query("update data_train set train_learn = 1 where train_id = ".$r->train_id);
        }
    }

    public function pdfsentriword($idsearch=0)
    {
    	require_once __DIR__."/../third_party/mpdf60/mpdf.php";
    	// echo __DIR__."/../third_party/mpdf60/mpdf.php";
    	$mpdf=new mPDF('c'); 
    	$data = $this->m_klasifikasi->_get_list_tweet_pdf($idsearch);
    	$template = '
			<!DOCTYPE html>
			<html>
			<head>
			</head>
			<body>
				<table border="1" style="border-collapse:collapsed;">
					<thead>
						<tr>
							<th>No</th>
                            <th>Komentar </th>
                            <th>Pos </th>
                            <th>Neg </th>
                            <th>Net </th>
                            <th>Kesimpulan </th>
						</tr>
					</thead>
					<tbody>';
		if ($data->num_rows() > 0) {
			$i=1;
			foreach ($data->result() as $r) {
				$template.= '<tr>
							<td>'.$i++.'</td>
							<td>'.$r->data_tweet_text.'</td>
							<td>'.$r->data_tweet_index_pos.'</td>
							<td>'.$r->data_tweet_index_neg.'</td>
							<td>'.$r->data_tweet_index_net.'</td>
							<td>'.$r->data_tweet_sentiment.'</td>
						</tr>';
			}
		}
		$template.=	'</tbody>
				</table>
			</body>
			</html>';
		$mpdf->WriteHTML($template);
		$mpdf->Output();
    }

    public function pdfbayes($idsearch=0)
    {
    	require_once __DIR__."/../third_party/mpdf60/mpdf.php";
    	// echo __DIR__."/../third_party/mpdf60/mpdf.php";
    	$mpdf=new mPDF('c'); 
    	$data = $this->m_klasifikasi->_get_list_tweet_bayes_pdf($idsearch);
    	$template = '
			<!DOCTYPE html>
			<html>
			<head>
			</head>
			<body>
				<table border="1" style="border-collapse:collapsed;">
					<thead>
						<tr>
							<th>No</th>
                            <th>Komentar </th>
                            <th>Pos </th>
                            <th>Neg </th>
                            <th>Net </th>
                            <th>Kesimpulan </th>
						</tr>
					</thead>
					<tbody>';
		if ($data->num_rows() > 0) {
			$i=1;
			foreach ($data->result() as $r) {
				$template.= '<tr>
							<td>'.$i++.'</td>
							<td>'.$r->data_tweet_text.'</td>
							<td>'.$r->data_tweet_index_pos.'</td>
							<td>'.$r->data_tweet_index_neg.'</td>
							<td>'.$r->data_tweet_index_net.'</td>
							<td>'.$r->data_tweet_sentiment.'</td>
						</tr>';
			}
		}
		$template.=	'</tbody>
				</table>
			</body>
			</html>';
		$mpdf->WriteHTML($template);
		$mpdf->Output();
    }

}

/* End of file klasifikasi.php */
/* Location: ./application/controllers/klasifikasi.php */