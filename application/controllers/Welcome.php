<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data = array();
		$data['content'] = $this->load->view('dashboard', null,TRUE);
		$this->load->view('main',$data,FALSE);
	}

	public function error_page()
	{
		$data = array();
		$data['content'] = $this->load->view('404_err',null,TRUE);
		$this->load->view('main', $data, FALSE);
	}

	public function read_excel()
	{
		$file = './files/test.xlsx';
		//load the excel library
		$this->load->library('excel');
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
		    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		    //header will/should be in row 1 only. of course this can be modified to suit your need.
		    if ($row == 1) {
		        $header[$row][$column] = $data_value;
		    } else {
		        $arr_data[$row][$column] = $data_value;
		    }
		}
		//send the data in an array format
		$data['header'] = $header;
		$data['values'] = $arr_data;
	}

	public function read_csv()
	{
		$csv = array_map('str_getcsv', file('./corpus.csv'));
		foreach ($csv as $key => $value) {
			$getdok = @file_get_contents('./rawdata/'.$value[2].'.json');
			if ($getdok) {
				$getdok = str_replace("\\\"","\"",$getdok);
				$getdok = str_replace("\\","",$getdok);
				$getdok = explode('"text":"',$getdok);
				if (@$getdok[1]) {
					$getdokk = explode('","truncated', $getdok[1]);
					$data = array(
						'produk'=>$value[0],
						'sentiment'=>$value[1],
						'id_twitter'=>$value[2],
						'comment'=>$getdokk[0]
					);
					$this->db->insert('data_training', $data);
					if ($this->db->affected_rows()>0) {
						echo 'sukses';
					}else{
						echo 'gagal';
					}
				}
				// $json = json_decode($getdok,true);
				// var_dump($json);
			}else{
				echo 'false<br/>';
			}
		}
	}

	public function insert_simplesentiword()
	{
		$filename = './daftarkata.txt';
		$contents = file($filename);

		foreach($contents as $line) {
		    $data = explode(" ", $line);
		    $data[1] = round($data[1],3);
		    // var_dump($data);echo "<br>";
		    // $this->db->query("INSERT INTO simple_sentiword VALUES('','".str_replace("'","''",$data[0])."','".$data[1]."')");
		    // if ($this->db->affected_rows() > 0) {
		    // 	echo "berhasil simpan data <br>";
		    // }else{
		    // 	echo "gagal simpan data <br>";
		    // }
		}
	}
}
