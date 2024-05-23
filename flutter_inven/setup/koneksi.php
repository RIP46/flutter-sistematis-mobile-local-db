<?php

$koneksi =mysqli_connect('localhost', 'root','','flutter_inven', $port = 4306);
if($koneksi != true){
echo "gagal";
}