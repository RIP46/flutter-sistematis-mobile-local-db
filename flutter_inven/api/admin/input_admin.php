<?php
require_once('../../setup/koneksi.php');
$query = mysqli_query($koneksi, "SELECT MAX(id_admin) AS max_code FROM tbl_admin");
$data =  mysqli_fetch_array($query);
$a = $data['max_code'];
$urut= (int)substr($a,3,3);
$urut++;
$id ="ADM".sprintf("%03s", $urut);
$nama = $_POST['nama'];
$username = $_POST['username'];
$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
$level = $_POST['level'];
header('Content-Type: text/xml');
$query = mysqli_query($koneksi, "INSERT INTO tbl_admin(id_admin,nama) VALUES('$id','$nama')");
if($query){
    $user = mysqli_query($koneksi, "INSERT INTO tbl_user(id_user,username,password,level)VALUES('$id', '$username', '$password', '$level')");
    if($user){
        $respons = [
            'success' => 1,
            'message' => "berhasil simpan"
        ];
        echo json_encode($respons);
    }else{
        $respons = [
            'success' => 0,
            'message' => "gagal simpan"
        ];
        echo json_encode($respons);
    }
}else{
    $respons = [
        'success' => 0,
        'message' => "gagal simpan"
    ];
    echo json_encode($respons);
}

