<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login multi out</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h1>Silah kan Login untuk masuk<br/> dalam sistem</h1>
 
 <?php 
 if(isset($_GET['pesan'])){
    if($_GET['pesan']=="gagal"){
        echo "<div class='alert'>Silahkan Login Terlebih Dahulu !</div>";
    } elseif ($_GET['pesan']=="logout") {
        echo "<div class='alert'>Anda telah berhasil logout.</div>";
    }
 }
 ?>

 <div class="kotak_login">
     <p class="tulisan_login">Silahkan login</p>

     <form action="cek_login.php" method="post">
         <label>Username</label>
         <input type="text" name="username" class="form_login" placeholder="Username .." required="required">

         <label>Password</label>
         <input type="password" name="password" class="form_login" placeholder="Password .." required="required">

         <input type="submit" class="tombol_login" value="LOGIN">

         <br/>
         <br/>
     </form>
     
 </div>
</body>
</html>