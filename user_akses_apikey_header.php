<?php

   $header = apache_request_headers();
   $key = $header['key'];
   // echo $key;

   // koneksi db
   $servername = "localhost";
   $username = "root";
   $password = "12345";
   $dbname = "restoranmks";

   // bikin koneksi
   $conn = new mysqli($servername, $username, $password, $dbname);

   // cek user
   $sql = "SELECT * FROM user WHERE key_token='$key'";
   $result = $conn->query($sql);

   if($result->num_rows > 0){
      echo "key/token valid";
   }else{
      echo "key/token not valid";
   }


?>