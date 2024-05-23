<?php
require_once('../../setup/koneksi.php');
$id = $_POST['id'];
$get = mysqli_query($koneksi, "SELECT * FROM tbl_barang_keluar WHERE id_barang_keluar='$id'");
while ($d = mysqli_fetch_array($get)) {
    $qstok = mysqli_query($koneksi, "SELECT * FROM tbl_stok WHERE barang ='$d[barang]'");
    $x = mysqli_fetch_array($qstok);
    $stok = $x['stok'] + $d['jumlah_keluar'];
    $ups = mysqli_query($koneksi, "UPDATE tbl_stok SET stok ='$stok' WHERE barang = '$d[barang]'");
}
$query = mysqli_query($koneksi, "DELETE FROM tbl_barang_keluar WHERE id_barang_keluar = '$id'");
$query = mysqli_query($koneksi, "DELETE FROM tbl_transaksi WHERE id_transaksi = '$id'");
if ($query) {
    $respons = [
        'success' => 1,
        'message' => "berhasil Hapus"
    ];
    echo json_encode($respons);
} else {
    $respons = [
        'success' => 0,
        'message' => "Gagal Hapus"
    ];
    echo json_encode($respons);
}