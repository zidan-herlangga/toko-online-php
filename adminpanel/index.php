<?php 
  require "../koneksi.php";
  require "session.php";

  $query = mysqli_query($con, "SELECT * FROM kategori");
  $jumlahKategori = mysqli_num_rows($query);

  $query = mysqli_query($con, "SELECT * FROM produk");
  $jumlahProduk = mysqli_num_rows($query);

  $query = mysqli_query($con, "SELECT * FROM transaksi");
  $jumlahTransaksi = mysqli_num_rows( $query);

  $query = mysqli_query($con, "SELECT * FROM users_customer");
  $jumlahCustomer = mysqli_num_rows( $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="../stylesheet/style.css">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<body>
  <!-- Navbar -->
  <?php require "navbar.php"; ?>

  <!-- Breadcrumb -->
  <div class="container mt-5">
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item text-black-50" aria-current="page">
        <i class="fa-solid fa-house"></i> Home
        </li>
      </ol>
    </nav>
    <h2 class="fw-bold">Halo <?php echo $_SESSION["username"]?></h2>
  </div>
  
  <!-- Daftar -->
  <div class="container mt-3">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-12 mb-3">
        <div class="summary p-3 bg-success">
          <div class="row justify-content-center align-items-center ">
            <div class="col-6 text-black-50">
              <i class="fa-solid fa-bars fa-5x"></i>
            </div>
            <div class="col-6 text-white">
              <h4>Kategori</h4>
              <p><?=$jumlahKategori;?> Kategori</p>
              <a href="kategori.php" class="text-decoration-none text-white">Lihat detail</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-12 mb-3">
        <div class="summary p-3 bg-info">
          <div class="row justify-content-center align-items-center">
            <div class="col-6 text-black-50">
              <i class="fa-solid fa-box fa-5x"></i>
            </div>
            <div class="col-6 text-white">
              <h4>Produk</h4>
              <p><?=$jumlahProduk;?> Produk</p>
              <a href="produk.php" class="text-decoration-none text-white">Lihat detail</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-12 mb-3">
        <div class="summary p-3 bg-warning">
          <div class="row justify-content-center align-items-center">
            <div class="col-6 text-black-50">
              <i class="fa-solid fa-dollar fa-5x"></i>
            </div>
            <div class="col-6 text-white">
              <h4>Transaksi</h4>
              <p><?=$jumlahTransaksi;?> Transaksi</p>
              <a href="transaksi.php" class="text-decoration-none text-white">Lihat detail</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-12 mb-3">
        <div class="summary p-3 bg-primary">
          <div class="row justify-content-center align-items-center">
            <div class="col-6 text-black-50">
              <i class="fa-solid fa-user-alt fa-5x"></i>
            </div>
            <div class="col-6 text-white">
              <h4>Akun</h4>
              <p><?=$jumlahCustomer;?> Customer</p>
              <a href="users-customer.php" class="text-decoration-none text-white">Coming Soon</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../javascript/script.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>