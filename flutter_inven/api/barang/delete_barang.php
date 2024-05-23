<?php
require_once('../../setup/koneksi.php');
$id = $_POST['id_barang'];
$f = mysqli_query($koneksi, "SELECT foto FROM tbl_barang WHERE id_barang = '$id'");
$img = mysqli_fetch_array($f);
$ci = mysqli_query($koneksi, "SELECT barang FROM tbl_barang_masuk WHERE barang = '$id'");
$di = mysqli_num_rows($ci);
$co = mysqli_query($koneksi, "SELECT barang FROM tbl_barang_keluar WHERE barang = '$id'");
$do = mysqli_num_rows($co);
if ($di >= 1 || $do >= 1) {
    $respons = [
        'success' => 0,
        'message' => "Gagal Hapus!!!, Barang ini sudah terhubung ke Transaksi Masuk atau Keluar"
    ];
    echo json_encode($respons);
} elseif ($di == 0 || $do == 0) {
    unlink('../../images/' . $img['foto']);
    $query = mysqli_query($koneksi, "DELETE FROM tbl_barang WHERE id_barang = '$id'");
    if ($query) {
        $delStok = mysqli_query($koneksi, "DELETE FROM tbl_stok WHERE barang = '$id'");
        $respons = [
            'success' => 1,
            'message' => "berhasil update"
        ];
        echo json_encode($respons);
}
}