<?php
require_once('../../setup/koneksi.php');
$query = mysqli_query($koneksi, "SELECT * FROM tbl_transaksi inner JOIN tbl_tujuan ON tbl_transaksi.jenis_transaksi = tbl_tujuan.id_tujuan
INNER JOIN tbl_barang_keluar ON tbl_transaksi.id_transaksi = tbl_barang_keluar.id_barang_keluar 
INNER JOIN tbl_barang ON tbl_barang_keluar.barang = tbl_barang.id_barang WHERE tbl_transaksi.tipe='K'");
$respons = [];
while ($a = mysqli_fetch_array($query)) {
    $a = [
        'id_transaksi' => $a['id_transaksi'],
        'tujuan' => $a['tujuan'],
        'total_item' => $a['total_item'],
        'tgl_transaksi' => $a['tgl_transaksi'],
        'keterangan' => $a['keterangan'],
        'nama_barang' => $a['nama_barang']
    ];
    array_push($respons, $a);
}
echo json_encode($respons);