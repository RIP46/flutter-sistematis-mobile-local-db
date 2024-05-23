<?php
require_once('../../setup/koneksi.php');

// $jenis = $_POST['jenis'];

// header('Content-Type: text/xml');

$query = mysqli_query($koneksi, "SELECT * FROM tbl_admin JOIN tbl_user ON tbl_user.id_user = tbl_admin.id_admin JOIN tbl_level ON tbl_level.id_level = tbl_user.level"); 
$respons = [];
while ($a = mysqli_fetch_array($query)){
    $a  = [
        'id_admin' => $a['id_admin'],
        'nama' => $a['nama'],
        'username' => $a['username'],
        'lvl' => $a['lvl'],
        
    ];
    array_push($respons, $a);
}
echo json_encode($respons);