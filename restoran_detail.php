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
         // Pengecekan parameter
         if (isset($_GET['id_resto'])) {
            // Tangkap parameter
            $id_resto = $_GET['id_resto'];

            // Jika Metodenya Sesuai 
            $result['Status'] = [
               "Code" => 200,
               "Description" => 'Request Valid'
            ];

            // Buat query untuk mendapatkan data restoran
            $sql_resto = "SELECT * FROM resto WHERE id_resto='$id_resto'";
            $hasil_query_resto = $conn->query($sql_resto);
            $data_resto = $hasil_query_resto->fetch_assoc();

            // Menambahkan data restoran ke dalam array result
            $result['restoran'] = $data_resto;

            // Buat query untuk mendapatkan data review berdasarkan id_resto
            $sql_review = "SELECT nama_pengguna, komentar, rating FROM review WHERE id_resto='$id_resto'";
            $hasil_query_review = $conn->query($sql_review);
            $data_review = array();

            // Memasukkan data review ke dalam array result
            while ($row_review = $hasil_query_review->fetch_assoc()) {
               $data_review[] = array(
                  'nama_pengguna' => $row_review['nama_pengguna'],
                  'komentar' => $row_review['komentar'],
                  'rating' => $row_review['rating']
               );
            }
            $result['restoran']['review'] = $data_review;

            // Buat query untuk mendapatkan data menu berdasarkan id_resto
            $sql_menu = "SELECT nama_menu, harga FROM menu WHERE id_resto='$id_resto'";
            $hasil_query_menu = $conn->query($sql_menu);
            $data_menu = array();

            // Memasukkan data menu ke dalam array result
            while ($row_menu = $hasil_query_menu->fetch_assoc()) {
               $data_menu[] = array(
                  'nama_menu' => $row_menu['nama_menu'],
                  'harga' => $row_menu['harga']
               );
            }
            $result['restoran']['menu'] = $data_menu;
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
