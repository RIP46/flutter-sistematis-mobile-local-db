<?php
require_once('../../setup/koneksi.php');
$username = mysqli_real_escape_string($koneksi,$_POST['username']);
$pass = mysqli_real_escape_string($koneksi,$_POST['pass']);
$get_usr = mysqli_query($koneksi,"SELECT password FROM tbl_user WHERE username='$username'");
$get_pass = mysqli_fetch_array($get_usr);
$num_usr = mysqli_fetch_array($get_usr);
$num_usr = mysqli_num_rows($get_usr);
if($num_usr ==1){
    if(password_verify($pass,$get_pass['password'])){
        $pass = $get_pass['password'];
    }else{
        $respons = [
            'success' => 0,
            'message' => "username atau password anda salah"
        ];
        echo json_encode($respons);
    }
    $usr = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username ='$username' AND password='$pass'");
    $cekusr = mysqli_num_rows($usr);
    $user = mysqli_fetch_array($usr);
    if($cekusr == 1){
        $qadm =mysqli_query($koneksi, "SELECT * FROM tbl_user JOIN tbl_admin ON tbl_user.id_user = tbl_admin.id_admin WHERE id_user = '$user[id_user]'");
        $adm = mysqli_fetch_array($qadm);
        $respons = [
            'nama' => $adm['nama'],
            'level' => $adm['level'],
            'id'=> $adm['id_admin'],
            'success' => 1,
            'message' => "berhasil login"
        ];
        echo json_encode($respons);
    }
    }else{
        $respons = [
            'success' => 0,
            'message' => "username atau password anda salah"
        ];
        echo json_encode($respons);
    
}
