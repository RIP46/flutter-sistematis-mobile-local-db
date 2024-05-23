<?php
require_once('../../setup/koneksi.php');
require ('../../dompdf/vendor/autoload.php');
$id = $_GET['i'];
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$query = mysqli_query($koneksi,"SELECT * FROM tbl_barang_keluar inner JOIN tbl_barang ON tbl_barang_keluar.barang = tbl_barang.id_barang inner JOIN tbl_brand ON tbl_barang.brand = tbl_brand.id_brand WHERE id_barang_keluar='$id'");
$query1 = mysqli_query($koneksi,"SELECT * FROM `tbl_transaksi` inner JOIN tbl_admin ON tbl_transaksi.user = tbl_admin.id_admin inner JOIN tbl_tujuan ON tbl_transaksi.jenis_transaksi = tbl_tujuan.id_tujuan WHERE id_transaksi='$id'");
$b = mysqli_fetch_array($query1);
$html = '<style>body{font-family: sans-serif;}table {margin: 20px auto; border-collapse: collapse;}table th, table td {border: 1px solid #3c3c3c;padding: 3px 8px;
}table .table{border: 0px;}</style>';
$html .= '<center><h3>Berita Acara<br>Transaksi Barang Keluar</h3></center>';
$html .= '<p> Pada Tanggal ' .date('d-m-Y', strtotime($b['tgl_transaksi'])). 'telah dilakukan ' .strtoupper($b['tujuan']). 'dengan rincian barang sebagai berikut : </p>';
$html .= '<table border ="1" width="100%">
<tr>
<th> No</th>
<th>Kode Barang</th>
<th>Nama Barang</th>
<th>Jumlah Keluar</th>
</tr>';
$no =1;
while ($a = mysqli_fetch_array($query))
{
    $html .="<tr>
    <td style ='border:1px solid #3c3c3c;padding: 3px 8px;'>".$no. "</td>
    <td>".$a['id_barang']."</td>
    <td>".$a['nama_barang']."</td>
    <td>".$a['jumlah_keluar']."</td>
</tr>";
$no++;
}
$html .= "
</table>";
$html .= '<p>Dengan keterangan ' .$b['keterangan']. ', demikian Berita Acara ini dibuat untuk dapat digunakan sebgaimana mestinya </p> <br> <br>';
$html .= '<p> Surabaya, '.date('d-m-Y').'
</p>'.
'<p>
<br>
</p>'.
'<p>('.$b['nama'].'
)<p>
';
$html .='
</table>';
$html .= "
</html>";
$dompdf ->loadhtml($html);
//setting ukuran dan orientasi kertas
$dompdf ->SetPaper('A4', 'potrait');
$dompdf ->render ();
$dompdf ->stream('BA_barang_keluar.pdf');
?>
