<?php
require_once('../../setup/koneksi.php');
$query =mysqli_query($koneksi, "SELECT * FROM `tbl_stok` JOIN tbl_barang ON tbl_stok.barang=tbl_barang.id_barang JOIN tbl_jenis ON tbl_barang.jenis=tbl_jenis.id_jenis JOIN tbl_brand ON tbl_barang.brand =tbl_brand. id_brand");
$data =[];
if(mysqli_num_rows($query) > 0){
    $no =1;
    while($row =mysqli_fetch_array($query)){
        $a=[
        'no' => $no++,
        'id_barang' => $row['id_barang'],
        'nama_barang' => $row['nama_barang'],
        'nama_jenis' => $row ['nama_jenis'],
        'nama_brand' => $row['nama_brand'],
        'stok' => $row['stok']
        ];  
        array_push($data, $a);
    }
}

header('Content-Type: text/csv; charset:utf-8');
header("Content-Disposition: attachment; filename=laporan_stok_barang.csv");
$output = fopen('php://output', 'w');
fputcsv($output, array("Laporan Stok Barang"));
fputcsv($output, array('No','Nama Barang','Jenis','Brand','Stok'),";");
if(count($data) > 0){
    foreach($data as $row) {
        fputcsv($output, $row,";");
}
}
?>