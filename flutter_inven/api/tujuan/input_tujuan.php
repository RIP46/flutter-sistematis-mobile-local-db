<?php
require_once('../../setup/koneksi.php');
$tujuan = $_POST['tujuan'];
if ($_POST['tipe'] == "Masuk") {
    $_POST['tipe'] = "M";
} elseif ($_POST['tipe'] == "Keluar") {
    $_POST['tipe'] = "K";
}
$tipe = $_POST['tipe'];
header('Content.Type: text/xml');
$query = mysqli_query($koneksi, "INSERT INTO tbl_tujuan(tujuan,tipe) VALUES('$tujuan', '$tipe')");
if ($query) {
    $respons = [
        'success' => 1,
        'message' => "berhasil simpan"
    ];
    echo json_encode($respons);
}else {
    $respons =[
        'success' => 1,
        'message' => "gagal simpan"
    ];
    echo json_encode($respons);
}