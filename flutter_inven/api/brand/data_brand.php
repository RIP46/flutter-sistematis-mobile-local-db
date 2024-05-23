<?php
require_once('../../setup/koneksi.php');

// $jenis = $_POST['jenis'];

// header('Content-Type: text/xml');

$query = mysqli_query($koneksi, "SELECT * FROM tbl_brand"); 
      $respons = [];
while ($a = mysqli_fetch_array($query)){
    $a  = [
        'id_brand' => $a['id_brand'],
        'nama_brand' => $a['nama_brand'],
 
        
    ];
    array_push($respons, $a);
}
echo json_encode($respons);