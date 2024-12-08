<?php
session_start();
require "koneksi.php";

// Ambil data produk dari database
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

// Periksa apakah user login
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kategori</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/all.min.css">
  <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
  <!-- Navbar -->
  <?php require "navbar.php" ?>

  <!-- Hero Section -->
  <div class="hero">
    <h1>Kategori</h1>
  </div>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>