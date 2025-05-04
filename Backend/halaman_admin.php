<?php 
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username']) || $_SESSION['level'] != "admin") {
    header("location:index.php?pesan=gagal");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

	<h1>Halaman Admin</h1>

	<p>Halo <b><?php echo $_SESSION['username']; ?></b>, Anda telah login sebagai <b><?php echo $_SESSION['level']; ?></b>.</p>
	<a href="logout.php">LOGOUT</a>
	<br/><br/>

</body>
</html>
