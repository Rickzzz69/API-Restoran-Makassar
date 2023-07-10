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
if ($method == 'GET') {

   // pengecekan parameter
   if (isset($_GET['search'])) {
      // Tangkap parameter
      $search = $_GET['search'];

      // Jika Metodenya Sesuai 
      $result['Status'] = [
         "Code" => 200,
         "Description" => 'Request Valid'
      ];

      // Buat query untuk mendapatkan data restoran berdasarkan pencarian string
      $sql_resto = "SELECT * FROM resto WHERE nama_resto LIKE '%$search%'";
      $hasil_query_resto = $conn->query($sql_resto);
      $data_resto = array();

      // Memasukkan data restoran ke dalam array result
      while ($row_resto = $hasil_query_resto->fetch_assoc()) {
         $id_resto = $row_resto['id_resto'];

         // Buat query untuk mendapatkan data review berdasarkan id_resto
         $sql_review = "SELECT nama_pengguna, komentar, rating FROM review WHERE id_resto='$id_resto'";
         $hasil_query_review = $conn->query($sql_review);
         $data_review = array();

         // Memasukkan data review ke dalam array data_resto
         while ($row_review = $hasil_query_review->fetch_assoc()) {
            $data_review[] = array(
               'nama_pengguna' => $row_review['nama_pengguna'],
               'komentar' => $row_review['komentar'],
               'rating' => $row_review['rating']
            );
         }

         // Buat query untuk mendapatkan data menu berdasarkan id_resto
         $sql_menu = "SELECT nama_menu, harga FROM menu WHERE id_resto='$id_resto'";
         $hasil_query_menu = $conn->query($sql_menu);
         $data_menu = array();

         // Memasukkan data menu ke dalam array data_resto
         while ($row_menu = $hasil_query_menu->fetch_assoc()) {
            $data_menu[] = array(
               'nama_menu' => $row_menu['nama_menu'],
               'harga' => $row_menu['harga']
            );
         }

         // Menambahkan data restoran, review, dan menu ke dalam array data_resto
         $data_resto[] = array(
            'id_resto' => $row_resto['id_resto'],
            'nama_resto' => $row_resto['nama_resto'],
            'deskripsi' => $row_resto['deskripsi'],
            'alamat' => $row_resto['alamat'],
            'lokasi_maps' => $row_resto['lokasi_maps'],
            'no_telpon' => $row_resto['no_telpon'],
            'jam_buka' => $row_resto['jam_buka'],
            'review' => $data_review,
            'menu' => $data_menu
         );
      }

      // Memeriksa jika data restoran ditemukan atau tidak
      if (empty($data_resto)) {
         $result['Status'] = [
            "Code" => 404,
            "Description" => 'Data Not Found'
         ];
         $result['data_ditemukan'] = 0;
      } else {
         // Menambahkan data restoran ke dalam array result
         $result['data_ditemukan'] = count($data_resto);
         $result['restoran'] = $data_resto;
        
      }
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
