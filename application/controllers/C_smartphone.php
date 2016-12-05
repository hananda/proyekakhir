<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_smartphone extends CI_Controller {

	public function index()
	{
		
	}

	public function ambilsmartphone()
	{
		require_once APPPATH."/libraries/simple_html_dom.php";
		$keyword = strtoupper($this->input->post('q'));
		$grab = file_get_contents("http://www.gsmarena.com/results.php3?sQuickSearch=yes&sName=".$keyword);
		$grab = explode('<div class="makers">
<ul>', $grab);
		if (@$grab[1]) {
			$grab = explode('</ul>
<br class="clear">', $grab[1]);
			if (@$grab[0]) {
				$grab = explode('</li>', $grab[0]);
				if (count($grab) > 0) {
					// $this->db->query("DELETE FROM m_produk WHERE m_produk_keyword = '".$keyword."'");
					foreach ($grab as $key => $value) {
						$namaproduk = $this->getBetween($value,'<span>','</span>');
						$url = $this->getBetween($value,'<li><a href="','"><img');
						$e_url = explode("-", $url);
						$url = 'http://www.gsmarena.com/'.$url;
						if (@$e_url[0]) {
							$urlreviews = 'http://www.gsmarena.com/'.$e_url[0].'-reviews-'.$e_url[1];
						}else{
							continue;
						}
						if (!$namaproduk) {
							continue;
						}

						//get spesifikasi
						$html = file_get_contents($url);
						$grab1 = explode("specs-spotlight-features", $html);
		$grab1 = explode("article-info-line page-specs", $grab1[1]);
		$data['size'] = $this->getBetween($grab1[0],'<i class="head-icon icon-touch-1"></i>
      <strong class="accent">','</strong>');
		$data['camera'] = $this->getBetween($grab1[0],'<strong class="accent accent-camera">','<span>');
		$data['ram'] = $this->getBetween($grab1[0],'<strong class="accent accent-expansion">','<span>');
		$data['battery'] = $this->getBetween($grab1[0],'<strong class="accent accent-battery">','<span>');
		$data['storage'] = $this->getBetween($grab1[0],'<i class="head-icon icon-sd-card-0"></i>','GB storage');
		$data['sensors'] = $this->getBetween($grab1[1],'Sensors</a></td>
<td class="nfo">','</td>
</tr><tr>
');
						$sensor = explode(",", $data['sensors']);
						$storage = explode("/", $data['storage']);
						$data['sensors'] = count($sensor);
						// end get spek
						$cekexist = $this->db->query("SELECT * FROM m_produk WHERE m_produk_nama = '".$namaproduk."' and m_produk_keyword = '".$keyword."'");
						if ($cekexist->num_rows() > 0) {
							$this->db->query(
								"UPDATE m_produk SET 
								m_produk_screen_size = '".$data['size']."',
								m_produk_camera = '".$data['camera']."',
								m_produk_ram = '".$data['ram']."',
								m_produk_battery = '".(is_numeric($data['battery']) ? $data['battery'] : 0)."',
								m_produk_sensors = '".$data['sensors']."',
								m_produk_mem_internal = '".(@$storage[0] ? $storage[0] : 0)."',
								m_produk_mem_internal1 = '".(@$storage[1] ? $storage[1] : 0)."',
								m_produk_mem_internal2 = '".(@$storage[2] ? $storage[2] : 0)."' where m_produk_nama = '".$namaproduk."'"
							);
						}else{
						$this->db->query("INSERT INTO m_produk VALUES ('','".$namaproduk."','".$keyword."','".$url."','".$urlreviews."',
							'".$data['size']."',
							'".$data['camera']."',
							'".$data['ram']."',
							'".(is_numeric($data['battery']) ? $data['battery'] : 0)."',
							'".$data['sensors']."',
							'".(@$storage[0] ? $storage[0] : 0)."',
							'".(@$storage[1] ? $storage[1] : 0)."',
							'".(@$storage[2] ? $storage[2] : 0)."')");
						}
					}
				}
				$msg['tipe'] = 'success';
				$msg['msg'] = 'Data berhasil masuk';
			}else{
				$msg['tipe'] = 'error';
				$msg['msg'] = 'Keyword tidak ditemukan';
			}
		}else{
			$msg['tipe'] = 'error';
			$msg['msg'] = 'Keyword tidak ditemukan';
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($msg));
	}

	function getBetween($content,$start,$end){
	    $r = explode($start, $content);
	    if (isset($r[1])){
	        $r = explode($end, $r[1]);
	        return str_replace('<br>', " ", $r[0]);
	    }
	    return '';
	}

	function test_simpledom()
	{
		
		$html = file_get_contents('http://www.gsmarena.com/nokia_c1-6885.php');
		$grab1 = explode("specs-spotlight-features", $html);
		$grab1 = explode("article-info-line page-specs", $grab1[1]);
		$data['size'] = $this->getBetween($grab1[0],'<i class="head-icon icon-touch-1"></i>
      <strong class="accent">','</strong>');
		$data['camera'] = $this->getBetween($grab1[0],'<strong class="accent accent-camera">','<span>');
		$data['ram'] = $this->getBetween($grab1[0],'<strong class="accent accent-expansion">','<span>');
		$data['battery'] = $this->getBetween($grab1[0],'<strong class="accent accent-battery">','<span>');
		$data['storage'] = $this->getBetween($grab1[0],'<i class="head-icon icon-sd-card-0"></i>','GB storage');
		$data['sensors'] = $this->getBetween($grab1[1],'Sensors</a></td>
<td class="nfo">','</td>
</tr><tr>
');
		var_dump($data);
	}

}

/* End of file C_smartphone.php */
/* Location: ./application/controllers/C_smartphone.php */