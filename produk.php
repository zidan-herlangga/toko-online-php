<?php
  session_start();
  require "koneksi.php";

  // Ambil data kategori dari database
  $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

  // Ambil data produk dari database
  $queryProduk = mysqli_query($con, "SELECT * FROM produk");

  // Periksa apakah user login
  $isLoggedIn = isset($_SESSION['user_id']);

  // Ambil produk dari keyword/pencarian
  if (isset($_GET["keyword"])) {
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%' ");
  }
  // Ambil produk dari kategori
  elseif (isset($_GET["kategori"])) {
    $queryGetKategori_ID = mysqli_query($con, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");

    if ($queryGetKategori_ID && mysqli_num_rows($queryGetKategori_ID) > 0) {
      $kategori_ID = mysqli_fetch_array($queryGetKategori_ID);
      
      $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$kategori_ID[id]'");
    }
  }
  
  // Ambil produk bawaan
  else {
    $queryProduk = mysqli_query($con, "SELECT * FROM produk");
  }

  $countData = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk | Toko Online</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/all.min.css">
  <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
  <!-- Navbar -->
  <?php require "navbar.php" ?>

  <!-- Hero Section -->
  <div class="hero">
    <h1>Produk</h1>
  </div>

  <!-- List Kategori Produk -->
  <div class="container my-5">
    <div class="row">
      <div class="col-lg-3">
        <h3 class="my-4">Kategori</h3>
        <hr>
        <ul class="list-group shadow mt-3">
          <?php while ($data = mysqli_fetch_array($queryKategori)): ?>
            <a href="produk.php?kategori=<?php echo $data['nama'] ?>" class="text-decoration-none">
              <li class="list-group-item"><?php echo $data['nama']?></li>
            </a>
          <?php endwhile; ?>
        </ul>
        <hr>
      </div>

      <div class="col-lg-9">
        <h3 class="text-center my-4">Produk</h3>
        <div class="row g-3">
          <?php if (!$countData): ?>
            <h5 class="fw-bold text-center my-5">Produk tidak tersedia.</h5>
          <?php endif; ?>
          
          <?php while ($data = mysqli_fetch_array($queryProduk)): ?>
            <div class="col-md-4 d-flex justify-content-center">
              <div class="card product-card shadow-sm  mb-4">
                <img src="image/<?php echo htmlspecialchars($data['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($data['nama']); ?>">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title fw-bold text-truncate"><?php echo htmlspecialchars($data['nama']); ?></h5>
                  <p class="text-truncate text-muted mb-3"><?php echo htmlspecialchars($data["detail"]); ?></p>
                  <p class="card-text fw-bold">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></p>
                  <div class="mt-auto">
                    <?php if ($isLoggedIn): ?>
                      <a href="produk-detail.php?nama=<?php echo $data['nama']?>" class="btn btn-outline-dark w-100">Lihat Detail</a>
                    <?php else: ?>
                      <p class="text-muted text-center">Login untuk melihat detail.</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Button Top Scroll -->
  <?php include "top-scroll.html" ?>

  <!-- Footer -->
  <?php require "footer.php";?>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="fontawesome/js/all.min.js"></script>
</body>
</html>