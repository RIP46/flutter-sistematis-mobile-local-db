<?php
require_once('../../setup/koneksi.php');
$id = $_POST['id_admin'];
$nama = $_POST['nama'];
$username = $_POST['username'];
$level = $_POST['level'];
$query = mysqli_query($koneksi, "UPDATE tbl_admin SET nama = '$nama' WHERE id_admin = '$id'");

if($query){
    $query = mysqli_query($koneksi, "UPDATE tbl_user SET username = '$username', level = '$level' WHERE id_user = '$id'");
    if($query){
        $respons = [
            'success' => 1,
            'message' => "berhasil update"
        ];
        echo json_encode($respons);
    }else{
        $respons = [
            'success' => 0,
            'message' => "gagal "
        ];
        echo json_encode($respons);
    }
}else{
    $respons = [
        'success' => 0,
        'message' => "gagal"
    ];
    echo json_encode($respons);
}

