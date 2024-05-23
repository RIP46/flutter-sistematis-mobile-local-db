<?php
require_once('../../setup/koneksi.php');
header('Content-Type: text/xml');
$id = $_POST['id_tujuan'];
$tujuan = $_POST['tujuan'];
if ($_POST['tipe'] == "Masuk") {
    $_POST['tipe'] = "M";
} elseif ($_POST['tipe'] == "Keluar") {
    $_POST['tipe'] = "K";
}
$tipe = $_POST['tipe'];
$query = mysqli_query($koneksi, "UPDATE tbl_tujuan SET tujuan = '$tujuan',tipe= '$tipe' WHERE id_tujuan = '$id'");
if ($query) {
    $respons = [
        'success' => 1,
        'message' => "berhasil update"
    ];
    echo json_encode($respons);
} else {
    $respons = [
        'success' => 0,
        'message' => "gagal update"
    ];
    echo json_encode($respons);
}