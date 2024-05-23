<?php
require_once('../../setup/koneksi.php');
$qs = mysqli_query($koneksi, "SELECT SUM(stok) AS ts FROM tbl_stok");
$ds = mysqli_fetch_array($qs);
$qbm = mysqli_query($koneksi, "SELECT SUM(jumlah_masuk) AS tbm FROM tbl_barang_masuk");
$dbm = mysqli_fetch_array($qbm);
$qbk = mysqli_query($koneksi, "SELECT SUM(jumlah_keluar) AS tbk FROM tbl_barang_keluar");
$dbk = mysqli_fetch_array($qbk);
$respons = [];
$a = [
    'stok' => $ds['ts'],
    'jm' => $dbm['tbm'],
    'jk' => $dbk['tbk'],
];
array_push($respons, $a);
echo json_encode($respons);