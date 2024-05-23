<?php
require_once('../../setup/koneksi.php');
if($_POST['barang'] == '' || $_POST['jumlah'] =="0"){
    $respons =[
        'success' => 0,
        'message' => "Data Input Tidak Boleh Kosong!!"
    ];
    echo json_encode($respons);
}else{
    $br = $_POST['barang'];
    $jm =$_POST['jumlah'];
    $adm = $_POST['id'];
    $in = mysqli_query($koneksi, "INSERT INTO tmp(kode_br, jumlah,jenis,user) VALUES('$br', '$jm', '1', '$adm')");
    if($in){
        $respons =[
            'success'  => 1,
            'message' => "Berhasil input keranjang barang masuk"
        ];
        echo json_encode($respons);
    }else{
        $respons = [
            'success'  => 0,
            'message' => "gagal!!"
        ];
        echo json_encode($respons);
    }
}