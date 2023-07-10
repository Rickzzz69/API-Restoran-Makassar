<?php
   session_start();

   $uname = $_POST['uname'];
   $pwd = $_POST['pwd'];

   // koneksi db
   $servername = "localhost";
   $username = "root";
   $password = "12345";
   $dbname = "restoranmks";

   // bikin koneksi
   $conn = new mysqli($servername, $username, $password, $dbname);

   // cek user
   $sql = "SELECT * FROM user WHERE username='$uname' AND password='$pwd'";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      $_SESSION['uname'] = $uname;
      $_SESSION['pwd'] = $pwd;
   } else {
      // Blokir akses jika login salah
      header("Location: user_login.php"); // Ganti login.php dengan halaman login yang sesuai
      exit();
   }
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

   <div class="container mt-5">
      <div class="card mx-auto" style="max-width: 400px;">
         <div class="card-header bg-primary text-white text-center">
            <h2 class="card-title">Generate API Key</h2>
         </div>
         <div class="card-body">
            <div class="text-center mb-4">
               <p class="fw-bold">Selamat datang, <?php echo $_SESSION['uname']; ?></p>
            </div>
            <form action="user_generate_key.php" method="post">
               <input type="hidden" name="uname" value="<?php echo $_SESSION['uname']; ?>">
               <input type="hidden" name="pwd" value="<?php echo $_SESSION['pwd']; ?>">
               
               <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-primary">Generate Key/Token</button>
               </div>
            </form>
         </div>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
