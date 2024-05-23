<?php
require_once('../../setup/koneksi.php');
$id = $_POST['id_barang'];
$nama = $_POST['nama'];
$brand = $_POST['brand'];
$jenis = $_POST['jenis'];
$f = mysqli_query($koneksi, "SELECT foto FROM tbl_barang WHERE id_barang = '$id'");
$image = mysqli_fetch_array($f);
if (!isset($_FILES['foto']['name'])){
  $query = mysqli_query($koneksi,"UPDATE tbl_barang SET nama_barang = '$nama', jenis = '$jenis', brand = '$brand' WHERE id_barang = '$id'");
  if($query){
    $respons = [
      'success' => 1,
      'message' => "berhasil update"
    ];
    echo json_encode($respons);
  }else{
    $respons = [
      'success' => 0,
      'message' => "gagal update"
    ];
    echo json_encode($respons) ;
  }
}elseif(isset($_FILES['foto']['name'])) {
  $rand = rand();
  $ekstensi = ['png', 'jpg', 'jpeg'];
  $filename = str_replace(" ", "",$_FILES['foto']['name']);
  $ukuran = $_FILES['foto']['size'];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);
  $img = $rand.$filename;
  $Path ="../../images/" . $img;
  if(!in_array($ext,$ekstensi) ) {
    $respons = [
      'success' => 0,
      'message' => "tipe file tidak cocok"
    ];
    echo json_encode($respons);
  }else{
    if($ukuran < 1044070){
      unlink('../../images/' . $image['foto']);
      move_uploaded_file($_FILES['foto']['tmp_name'], $Path);
      $query = mysqli_query($koneksi, "UPDATE tbl_barang SET nama_barang = '$nama', foto = '$img', jenis = '$jenis', brand = '$brand' WHERE id_barang = '$id'");
      if($query){
        $respons = [
          'success' => 1,
          'message' => "berhasil update"
        ];
        echo json_encode($respons);
      }else {
        $respons = [
          'success' => 0,
          'message' => "gagal update barang"
        ];
        echo json_encode($respons);
      }
    }else{
      $respons = [
        'success' => 0,
        'message' => "file terlalu besar"
      ];
      echo json_encode($respons);
}
}
}