<?php
  $con = mysqli_connect("localhost", "root", "", "backup_toko_online"); // Hostname, Username, Password, Database

  if (mysqli_connect_errno()) {
    echo "Gagal untuk menghubungkan ke MySQL: " . mysqli_connect_error();
    exit();
  }
?>