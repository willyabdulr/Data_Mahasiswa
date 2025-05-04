<?php
$koneksi = mysqli_connect("localhost", "root", "", "data_kelas_07");

if (mysqli_connect_error()) {
    echo "Koneksi Gagal : " . mysqli_connect_error();
}
?>
