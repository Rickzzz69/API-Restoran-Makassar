<?php

// Header hasil berbentuk json
header("Content-Type: application/json");

 // Tangkap key/token
 $header = apache_request_headers();
 $key = isset($header['key']) ? $header['key'] : '';

$method = $_SERVER['REQUEST_METHOD'];

 // Start: Koneksi Database
 $servername = "localhost";
 $username = "root";
 $password = "12345";
 $dbname = "restoranmks";
 // Create connection
 $conn = new mysqli($servername, $username, $password, $dbname);
 // End: Koneksi Database 

// Membuat Variabel Hasil 
$result = array();

// Cek apakah key/token ada
if (!empty($key)) {
   // Cek apakah key/token valid
   $sql = "SELECT * FROM user WHERE key_token='$key'";
   $user = $conn->query($sql);

   if ($user->num_rows > 0) {
      // Key/Token valid

      // Pengecekan Metode Akses Yang digunakan
if ($method == 'POST') {

   // pengecekan parameter
   if (isset($_POST['id_resto']) AND isset($_POST['nama_pengguna']) 
         AND isset($_POST['komentar']) AND isset($_POST['rating'])) {
     
      // Tangkap parameter
      $id_resto = $_POST['id_resto'];
      $nama_pengguna = $_POST['nama_pengguna'];
      $komentar = $_POST['komentar'];
      $rating = $_POST['rating'];
      
      // Jika Metodenya Sesuai 
      $result['Status'] = [
         "Code" => 200,
         "Description" => '1 Data Telah Berhasil ditambahkan'
      ];

      // Buat query 
      $sql = "INSERT INTO review (id_resto, nama_pengguna, komentar, rating)
               VALUES ('$id_resto', '$nama_pengguna', '$komentar', '$rating')";
      
      // Melakukan eksekusi query
      $conn->query($sql);
      // Masukkan ke array result
      $result['result'] = [
         "id_resto" => $id_resto,
         "nama_pengguna" => $nama_pengguna,
         "komentar" => $komentar,
         "rating" => $rating
      ];

   } else {
      // Jika Metodenya tidak Sesuai
      $result['Status'] = [
         "Code" => 400,
         "Description" => 'Parameter Not Valid'
      ];
   }
} else {
   // Jika Metodenya tidak Sesuai
   $result['Status'] = [
      "Code" => 400,
      "Description" => 'Request Not Valid'
   ];
}
   } else {
      // Key/Token tidak valid
      $result['Status'] = [
         "Code" => 400,
         "Description" => 'API Key/Token Not Valid'
      ];
   }
} else {
   // Key/Token tidak ada
   $result['Status'] = [
      "Code" => 400,
      "Description" => 'API Key/Token Not Provided'
   ];
}

// Menampilkan hasil dalam format JSON
echo json_encode($result);

?>