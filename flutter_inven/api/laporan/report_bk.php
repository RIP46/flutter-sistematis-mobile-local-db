<?php
require_once('../../setup/koneksi.php');
require ('../../dompdf/vendor/autoload.php');
$d1 = date('d-m-Y',strtotime($_GET['t1']));
$d2 = date('d-m-Y',strtotime($_GET['t2']));
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$sm = mysqli_query($koneksi, "SELECT SUM(total_item) AS tl FROM tbl_transaksi WHERE tgl_transaksi BETWEEN '$_GET[t1]' AND '$_GET[t2]' AND tipe='M'");
$sum = mysqli_fetch_array($sm);
$query = $query = mysqli_query($koneksi,"SELECT * FROM tbl_transaksi JOIN tbl_barang_keluar ON tbl_barang_keluar.id_barang_keluar = tbl_transaksi.id_transaksi JOIN tbl_barang ON tbl_barang_keluar.barang= tbl_barang.id_barang JOIN tbl_brand ON tbl_barang.brand = tbl_brand.id_brand JOIN tbl_admin ON tbl_transaksi.user = tbl_admin.id_admin WHERE tgl_transaksi BETWEEN '$_GET[t1]' AND '$_GET[t2]'");
$html ='<style>body{font-family: sans-serif;}table{margin:20px auto;border-collapse: collapse;}table th,table td {border: 1px solid #3c3c3c;padding: 3px 8px;
}</style>';
$html .= '<center><h3>Laporan Barang keluar<br>periode '.$d1.' s/d '.$d2.' </h3></center>';
$html .= '<table border="1" width="100%">
<tr>
<th>No</th>
<th>Kode Barang keluar</th>
<th>Kode Barang</th>
<th>Nama Barang</th>
<th>Jumlah keluar</th>
<th>Tgl keluar</th>
<th>Keterangan</th>
<th>User Input</th>
</tr>';
$no =1;
while($a =mysqli_fetch_array($query))
{
    $html .= "<tr>
    <td>".$no."</td>
    <td>".$a['id_barang_keluar']."</td>
    <td>".$a['id_barang']."</td>
    <td>".$a['nama_barang']." (".$a['nama_brand'].")"."</td>
    <td>".$a['jumlah_keluar']."</td>
    <td>".$a['tgl_transaksi']."</td>
    <td>".$a['keterangan']."</td>
    <td>".$a['nama']."</td>
    </tr>";
    $no++;
}
$html .= "<tr>
<td colspan=4>Total</td>
<td colspan=4>" .$sum['tl']."</td>
</tr>";
$html.= "</html>";
$dompdf->LoadHtml($html);
//setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
//setting 
$dompdf->render();
//melakukan output  file pdf
$dompdf->stream('laporan_barang_keluar.pdf');
?>
