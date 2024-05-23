<?php
require_once('../../setup/koneksi.php');

// $jenis = $_POST['jenis'];

// header('Content-Type: text/xml');

$query = mysqli_query($koneksi, "SELECT * FROM tbl_level"); 
      $respons = [];
while ($a = mysqli_fetch_array($query)){
    $a  = [
        'id_level' => $a['id_level'],
        'lvl' => $a['lvl']
    ];
    array_push($respons, $a);
}
echo json_encode($respons);