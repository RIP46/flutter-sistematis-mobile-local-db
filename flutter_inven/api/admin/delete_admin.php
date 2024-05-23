<?php
require_once('../../setup/koneksi.php');
$id = $_POST['id_admin'];
$query = mysqli_query($koneksi, "DELETE FROM tbl_admin  WHERE id_admin = '$id'");

if($query){
    $del = mysqli_query($koneksi, "DELETE FROM tbl_user WHERE id_user = '$id'");
    if($del){
        $respons = [
            'success' => 1,
            'message' => "berhasil delete"
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

