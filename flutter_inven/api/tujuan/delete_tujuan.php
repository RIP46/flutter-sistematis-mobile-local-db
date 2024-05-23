<?php 
require_once('../../setup/koneksi.php');
$id = $_POST['id_tujuan'];
header('Content-Type: text/xml');
$c = mysqli_query($koneksi,"SELECT jenis_transaksi FROM tbl_transaksi inner JOIN tbl_tujuan ON tbl_transaksi.jenis_transaksi  = tbl_tujuan.id_tujuan WHERE jenis_transaksi ='$id'");
$d = mysqli_num_rows($c);
if ($d == 1){
    $respons = [
        'success' => 0,
        'message' => "Gagal Hapus!!!, tujuan ini sudah terhubung ke table transaksi"
    ];
    echo json_encode($respons);
}elseif($d ==  0){
    $query = mysqli_query($koneksi, "DELETE FROM tbl_tujuan WHERE id_tujuan = '$id'");
    if($query){
        $respons = [
            'success' => 1,
            'message' => "berhasil delete"
        ];
        echo json_encode($respons);
}
}