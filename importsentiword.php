<?php 
$conn = mysqli_connect("localhost","root","inimysql");
$db = mysqli_select_db($conn,"proyekakhir");

$file_handle = fopen("SentiWordNet_3.0.0_20130122.txt", "r");
while (!feof($file_handle)) {
   $line = fgets($file_handle);
   $line = explode("\t", $line);
   $query = mysqli_query($conn,"INSERT INTO sentiword values ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."','".mysqli_escape_string($conn,$line[4])."','".mysqli_escape_string($conn,$line[5])."')");
   if ($query) {
   	echo "sukses<br>";
   }else{
   	echo "gagal ".mysqli_error($conn)."<br>";
   }
}
fclose($file_handle);
?>