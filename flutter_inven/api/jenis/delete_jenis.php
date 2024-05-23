<?php

require_once('../../setup/koneksi.php');

$id = $_POST['id_jenis'];
header('Content-Type: text/xml');
// $jenis = $_POST['jenis'];
$c = mysqli_query($koneksi, "SELECT  jenis FROM tbl_barang WHERE jenis='$id'");
$d =mysqli_num_rows($c);
if ($d >=1) {
      $respons = [
          'success' => 0,
           'message' => "Gagal  Hapus!! dataini sudah terhubung ke table barang"
 ];
          echo json_encode($respons);
} elseif($d == 0){
            $query = mysqli_query($koneksi, "DELETE FROM tbl_jenis WHERE id_jenis='$id'");              
if($query){
            $respons = [
            'success' => 1,
                'message' => "berhasil delete"
                      ];
                  echo json_encode($respons);

}
}

