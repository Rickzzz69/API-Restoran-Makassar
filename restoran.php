<?php
   // Header hasil berbentuk json
   header("Content-Type: application/json");

   // Tangkap key/token
   $header = apache_request_headers();
   $key = isset($header['key']) ? $header['key'] : '';

   $method = $_SERVER['REQUEST_METHOD'];

   // Membuat Variabel Hasil 
   $result = array();

   // Start: Koneksi Database
   $servername = "localhost";
   $username = "root";
   $password = "12345";
   $dbname = "restoranmks";     
   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);
   // End: Koneksi Database 

   // Cek apakah key/token ada
   if (!empty($key)) {
      // Cek apakah key/token valid
      $sql = "SELECT * FROM user WHERE key_token='$key'";
      $user = $conn->query($sql);

      if ($user->num_rows > 0) {
         // Key/Token valid

         // Pengecekan Metode Akses Yang digunakan
         if ($method == 'GET') {
            // Jika Metodenya Sesuai 
            $result['Status'] = array(
               "Code" => 200,
               "Description" => 'Request Valid'
            );

            // Buat query
            $sql = "SELECT * FROM resto";
            // Eksekusi query
            $hasil_query = $conn->query($sql);

            // Hitung total data
            $total_data = mysqli_num_rows($hasil_query);

            // Masukkan total data ke dalam array result
            $result['total_data'] = $total_data;

            // Masukkan data restoran ke dalam array result
            $result['restoran'] = $hasil_query->fetch_all(MYSQLI_ASSOC);
         } else {
            // Jika Metodenya tidak Sesuai
            $result['Status'] = array(
               "Code" => 400,
               "Description" => 'Request Not Valid'
            );
         }
      } else {
         // Key/Token tidak valid
         $result['Status'] = array(
            "Code" => 400,
            "Description" => 'API Key/Token Not Valid'
         );
      }
   } else {
      // Key/Token tidak ada
      $result['Status'] = array(
         "Code" => 400,
         "Description" => 'API Key/Token Not Provided'
      );
   }

   // Menampilkan hasil dalam format JSON
   echo json_encode($result);
?>
