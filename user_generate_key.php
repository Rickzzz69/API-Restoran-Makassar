<?php
   session_start();

   // Cek apakah user telah login atau belum
   if (!isset($_SESSION['uname']) || !isset($_SESSION['pwd'])) {
      // Redirect ke halaman login jika belum login
      header("Location: user_login.php");
      exit();
   }

   if (isset($_POST['logout'])) {
      // Hancurkan session dan arahkan ke halaman login
      session_unset();
      session_destroy();
      header("Location: user_login.php"); // Ganti login.php dengan halaman login yang sesuai
      exit();
   }

   $uname = $_SESSION['uname'];
   $pwd = $_SESSION['pwd'];

   $token = md5($uname.$pwd);

   // koneksi db
   $servername = "localhost";
   $username = "root";
   $password = "12345";
   $dbname = "restoranmks";

   // bikin koneksi
   $conn = new mysqli($servername, $username, $password, $dbname);

   // cek user
   $sql = "UPDATE user SET key_token='$token' WHERE 
            username='$uname' AND password = '$pwd'";
   $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>Generate API Key</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

   <div class="container mt-5 p-3">
      <div class="card mx-auto" style="max-width: 500px;">
         <div class="card-header bg-white text-center">
            <h2 class="text-primary">Generate API Key</h2>
         </div>
         <div class="card-body">
            <p class="text-center">Key/Token API Anda: <?php echo $token; ?></p>
            <form action="" method="post" class="text-center">
               <button type="submit" name="logout" class="btn btn-primary">Logout</button>
            </form>
         </div>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
