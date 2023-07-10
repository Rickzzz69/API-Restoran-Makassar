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
         if (isset($_GET['search'])) {
            // Tangkap parameter
            $search = $_GET['search'];

            // Jika Metodenya dan parameter sesuai
            $result['Status'] = [
               "Code" => 200,
               "Description" => 'Request Valid'
            ];

            // Buat query untuk melakukan pencarian berdasarkan string
            $sql_search = "SELECT * FROM resto WHERE nama_resto LIKE '%$search%' LIMIT 10";
            $hasil_query_search = $conn->query($sql_search);
            $data_search = array();

            // Memasukkan data hasil pencarian ke dalam array result
            while ($row_search = $hasil_query_search->fetch_assoc()) {
               $data_search[] = $row_search;
            }

            // Jika data pencarian tidak ditemukan
            if (empty($data_search)) {
               $result['search_results'] = "Data tidak ditemukan";
               $result['data_ditemukan'] = 0;
            } else {
               // Menambahkan data restoran ke dalam array result
               $result['data_ditemukan'] = count($data_search);
               $result['search_results'] = $data_search;
            }
         } else {
            // Jika parameter tidak lengkap
            $result['Status'] = [
               "Code" => 400,
               "Description" => 'Incomplete Parameters'
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
