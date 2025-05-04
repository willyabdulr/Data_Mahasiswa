<?php
session_start();

// Validasi umum: apakah sudah login
if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    header("Location: index.php?pesan=belum_login");
    exit();
}

// Validasi akses khusus berdasarkan level
$halaman = basename($_SERVER['PHP_SELF']);

$akses = [
    'halaman_admin.php' => 'admin',
    'halaman_mahasiswa.php' => 'mahasiswa',
    'halaman_pengurus.php' => 'pengurus'
];

if (isset($akses[$halaman]) && $_SESSION['level'] !== $akses[$halaman]) {
    header("Location: index.php?pesan=akses_ditolak");
    exit();
}
?>
