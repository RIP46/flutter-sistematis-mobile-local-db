<?php
require_once('../../setup/koneksi.php');
$query = mysqli_query($koneksi, "SELECT MAX(id_barang) AS max_code FROM tbl_barang");
$data = mysqli_fetch_array($query);
$a = $data['max_code'];
$urut = (int)substr($a,2,3);
$urut++;
$id = "BR".sprintf("%03s", $urut);
$nama = $_POST['nama'];
$brand = $_POST['brand'];
$jenis = $_POST['jenis'];
$rand = rand();
$ekstensi = ['png','jpg','jpeg'];
$filename = str_replace(" ","",$_FILES['foto']['name']);
$ukuran = $_FILES['foto']['size'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);
$img = $rand.$filename;
$Path ="../../images/" . $img;
header('Content-Type: text/xml');
if(!in_array($ext,$ekstensi)){
    $respons =[
        'success' => 0,
        'message' => "tipe file tidak cocok"
    ];
    echo json_encode($respons);
}else{
    //validasi ukuran 1mb
    if($ukuran < 1044070){
        move_uploaded_file($_FILES['foto']['tmp_name'], $Path);
        $qin = mysqli_query($koneksi, "INSERT INTO tbl_barang(id_barang, nama_barang,foto,jenis,brand) VALUES('$id','$nama', '$img', 
        '$jenis','$brand')");  
    if($qin){
        $qs = mysqli_query($koneksi, "INSERT INTO tbl_stok(barang,stok) VALUES('$id',0)");
    if($qs){
        $respons =[
            'success' => 1,
            'message' => "berhasil simpan"
        ];
        echo json_encode($respons);
    }else{
    $respons =[
        'success' => 0,
        'message' => "gagal simpan ke tbl stok"
    ];
    echo json_encode($respons);
}
    }else{
    $respons =[
        'success' => 0,
        'message' => "gagal simpan ke tbl barang"
    ];
    echo json_encode($respons);
}
    }else{
    $respons =[
            'success' => 0,
            'message' => "file terlalu besar"
        ];
        echo json_encode($respons);
    }
}
