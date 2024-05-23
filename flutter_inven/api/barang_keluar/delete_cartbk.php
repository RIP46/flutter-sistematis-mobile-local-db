<?php
require_once('../../setup/koneksi.php');
$id = $_POST['id'];
$query  = mysqli_query($koneksi, "DELETE FROM tmp WHERE id_tmp = '$id'");
if($query){
    $respons=[
        'success'  => 1,
        'message' => "Berhasil hapus"
    ];
    echo json_encode($respons);
}else{
    $respons=[
        'success'  => 0,
        'message' => "Gagal hapus"
    ];
    echo json_encode($respons);
}