<!DOCTYPE html>
<html lang="en">
<head>
   <title>User API Sign Up</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

   <div class="container mt-5 p-5">
      <div class="card mx-auto" style="max-width: 500px;">
         <div class="card-header bg-white text-center">
            <h2 class="text-primary">User API Sign Up</h2>
         </div>
         <div class="card-body">
            <?php
               // Mengambil data dari form
               $username = $_POST['username'];
               $password = $_POST['password'];

               // Koneksi ke database
               $servername = "localhost";
               $username_db = "root";
               $password_db = "12345";
               $dbname = "restoranmks";

               $conn = new mysqli($servername, $username_db, $password_db, $dbname);

               // Memasukkan data ke tabel user
               $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
               $result = $conn->query($sql);

               // Menampilkan pesan berhasil atau gagal
               if ($result) {
                  echo '<div class="alert alert-success text-center" role="alert">
                           Sign up successful!
                        </div>';
                  echo '<div class="text-center mt-3">
                           <a href="user_login.php" class="btn btn-primary">Go to User Login</a>
                        </div>';
               } else {
                  echo '<div class="alert alert-danger text-center" role="alert">
                           Sign up failed!
                        </div>';
               }

               // Menutup koneksi ke database
               $conn->close();
            ?>
         </div>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
