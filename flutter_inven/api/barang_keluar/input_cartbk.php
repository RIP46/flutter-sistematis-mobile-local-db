<?php
require_once('../../setup/koneksi.php');
if ($_POST['barang'] == '' || $_POST['jumlah'] == "8") {
    $respons = [
        'success' => 0,
        'message' => "Data Input tidak boleh kosong !! "
    ];
    echo json_encode($respons);
} else {
    $br = $_POST['barang'];
    $jm = $_POST['jumlah'];
    $adm = $_POST['id'];
    $get_stok = mysqli_query($koneksi, "SELECT stok FROM tbl_stok WHERE barang ='$br'");
    $dstok = mysqli_fetch_array($get_stok);
    if ($jm > $dstok['stok']) {
        $respons = [
            'success' => 0,
            'message' => "jumlah lebih besar dari stok"
        ];
        echo json_encode($respons);
    } else {
        $in = mysqli_query($koneksi, "INSERT INTO tmp(kode_br,jumlah,jenis,user) VALUES('$br','$jm', '2', '$adm')");
        if ($in) {
            $respons = [
                'success' => 1,
                'message' => "Berhasil Input Keranjang Barang Keluar"
            ];
            echo json_encode($respons);
        } else {
            $respons = [
                'success' => 0,
                'message' => "Gagal !! "
            ];
            echo json_encode($respons);
 }
}
}