<?php

require_once('../../setup/koneksi.php');
header('Content-Type: text/xml');
$id = $_POST['id_jenis'];
$jenis = $_POST['jenis'];
$query = mysqli_query($koneksi, "UPDATE tbl_jenis SET nama_jenis = '$jenis' WHERE id_jenis = '$id'");
if ($query) {
      $respons = [
          'success' => 1,
           'message' => "berhasil update"
 ];
          echo json_encode($respons);
} else {
        $respons = [
                'success' => 0,
                'message' => "gagal update"
                      ];
                  echo json_encode($respons);

}

