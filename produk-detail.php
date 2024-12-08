<?php
  session_start();
  require "koneksi.php";

  $nama = htmlspecialchars($_GET['nama']);

  // Ambil data produk dari database
  $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama' ");

  // Periksa apakah user login
  $isLoggedIn = isset($_SESSION['user_id']);

  if (!$isLoggedIn) {
    header('location: ../backup-toko-online');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Produk | Toko Online</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/all.min.css">
  <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
  <!-- Navbar -->
  <?php require "navbar.php" ?>

  <!-- Produk Container -->
  <div class="container my-5">
    <div class="row">
      <?php while ($data = mysqli_fetch_array($queryProduk)): ?>
        <div class="col-md-5 mb-4">
          <img src="image/<?php echo $data['foto']?>" height="400" alt="" class="w-100 shadow">    
        </div>
        <div class="col-md-6 offset-md-1">
          <h1 class="fw-bold"> <?php echo $data['nama']?> </h1>
          <p> <?php echo $data['detail']?> </p>
          <p class="fw-bold fs-5">Rp <?php echo number_format($data['harga'], 0, ',', '.');?> </p>
          <p>Status: <strong><?php echo $data['ketersediaan_stok']?></strong></p>
          <hr>

          <?php if ($data["ketersediaan_stok"] == "Habis") : ?>
            <p>Produk belum tersedia.</p>
          <?php else : ?>  
            <a href="transaksi/checkout.php?nama=<?php echo urlencode($data['nama']); ?>" class="btn btn-outline-dark mt-3">
            <i class="fa-solid fa-cart-arrow-down"></i> Beli Produk
            </a>
          <?php endif; ?>
        </div>
      <?php endwhile;?>
    </div>
  </div>

  <!-- Footer -->
  <?php require "footer.php"; ?>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="fontawesome/js/all.min.js"></script>
</body>
</html>