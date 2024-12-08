<?php
  session_start();
  require "koneksi.php";

  // Ambil data produk dari database
  $queryProduk = mysqli_query($con, "SELECT * FROM produk LIMIT 6");

  // Periksa apakah user login
  $isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Toko Online</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/all.min.css">
  <link rel="stylesheet" href="stylesheet/style.css">
</head>
<body>
  <!-- Navbar -->
  <?php require "navbar.php" ?>

  <!-- Hero Section -->
  <div class="hero banner">
    <div class="row">
      <h1 class="text-center">Selamat Datang di Toko Online Kami</h1>
      <p class="text-center">Apa yang kamu lihat, apa yang kamu lakukan.</p>
      <div class="col-md-8 offset-md-2">
        <form action="produk.php" method="get">
          <div class="input-group input-group-lg my-4">
            <input type="text" class="form-control" placeholder="Cari produk..." aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword" autocomplete="off">
            <button type="submit" class="btn btn-dark">Telusuri</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Kategori Terlaris -->
  <div class="container my-5">
    <h2 class="text-center mb-5">Kategori Terlaris</h2>
    <div class="row mt-5">
      <div class="col-md-4 mb-3">
        <div class="highlited-kategori kategori-baju-pria d-flex justify-content-center align-items-center">
          <h4>
            <a href="produk.php?kategori=baju pria" class="text-decoration-none text-white">Baju Pria</a>
          </h4>
        </div> 
      </div>
      <div class="col-md-4 mb-3">
        <div class="highlited-kategori kategori-baju-wanita d-flex justify-content-center align-items-center">
          <h4>
            <a href="produk.php?kategori=baju wanita" class="text-decoration-none text-white">Baju Wanita</a>
          </h4>
        </div> 
      </div>
      <div class="col-md-4 mb-3">
        <div class="highlited-kategori kategori-sepatu d-flex justify-content-center align-items-center">
          <h4>
            <a href="produk.php?kategori=sepatu" class="text-decoration-none text-white">Sepatu</a>
          </h4>
        </div> 
      </div>
    </div>
  </div>

  <!-- Tentang Kami -->
  <div class="container-fluid py-5 shadow border">
    <div class="container text-center">
      <h3>Tentang Kami</h3>
      <p>
        Selamat datang di Toko Online, destinasi utama Anda untuk busana berkualitas dan bergaya! Kami percaya bahwa setiap orang berhak tampil percaya diri dan nyaman dalam setiap kesempatan, itulah mengapa kami hadir dengan koleksi pakaian yang trendi, elegan, dan sesuai dengan berbagai selera.
        <br><br>
        Di Toko Online, kami menyediakan berbagai macam pilihan pakaian untuk pria, wanita, dan anak-anak, dari gaya kasual hingga formal, yang dibuat dengan bahan berkualitas tinggi dan desain yang up-to-date. Dengan berfokus pada kenyamanan dan kepuasan pelanggan, kami memastikan setiap produk yang kami tawarkan memberikan pengalaman berbelanja yang menyenangkan.
        <br><br>
        Kami berkomitmen untuk selalu menghadirkan koleksi terbaru dengan harga yang terjangkau, agar Anda tetap bisa tampil stylish tanpa menguras kantong. Dengan layanan pelanggan yang ramah dan pengiriman yang cepat, kami berharap bisa menjadi pilihan utama Anda dalam berbelanja pakaian.</p>
    </div>
  </div>

  <!-- Produk Container -->
  <div class="container my-5">
    <h2 class="text-center mb-5">Produk Kami</h2>
    <div class="row">
      <?php while ($data = mysqli_fetch_array($queryProduk)): ?>
        <div class="col-lg-3 col-sm-6 d-flex justify-content-center align-items-center">
          <div class="card product-card mb-4">
            <img src="image/<?php echo htmlspecialchars($data['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($data['nama']); ?>">
            <div class="card-body">
              <h5 class="card-title fw-bold"><?php echo htmlspecialchars($data['nama']); ?></h5>
              <p class="text-truncate"><?php echo htmlspecialchars($data["detail"]) ?></p>
              <p class="card-text">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></p>
              <?php if ($isLoggedIn): ?>
                <a href="produk-detail.php?nama=<?php echo $data['nama']?>" class="btn btn-outline-dark w-100">Lihat Detail</a>
              <?php else: ?>
                <p class="text-muted text-center"></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <div class="text-center">
      <a href="produk.php" class="btn btn-outline-dark">Lihat Produk</a>
    </div>
  </div>

  <!-- Cookie -->
  <div id="cookie-banner" class="cookie-banner">
    <p>
      Kami menggunakan cookies untuk meningkatkan pengalaman Anda di situs kami. Dengan melanjutkan menggunakan situs ini, Anda setuju dengan penggunaan cookies.
    </p>
    <button id="accept-btn">Setuju</button>
  </div>
  
  <!-- Button Top Scroll -->
  <?php include "top-scroll.html" ?>
  
  <!-- Footer -->
  <?php require "footer.php"; ?>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="fontawesome/js/all.min.js"></script>

  <script>
    // Cek apakah cookie sudah diset
    function checkCookieConsent() {
      const cookieConsent = getCookie('cookieConsent');
      if (cookieConsent === 'accepted') {
        // Jika cookie sudah diterima, sembunyikan banner
        document.getElementById('cookie-banner').style.display = 'none';
      } else {
        // Jika cookie belum diterima, tampilkan banner
        document.getElementById('cookie-banner').style.display = 'block';
      }
    }

    // Fungsi untuk mendapatkan nilai cookie berdasarkan nama
    function getCookie(name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      if (parts.length === 2) return parts.pop().split(';').shift();
      return '';
    }

    // Fungsi untuk menyimpan cookie
    function setCookie(name, value, days) {
      const d = new Date();
      d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000)); // Mengatur waktu kedaluwarsa cookie
      const expires = `expires=${d.toUTCString()}`;
      document.cookie = `${name}=${value}; ${expires}; path=/`;
    }

    // Event listener untuk tombol menerima cookies
    document.getElementById('accept-btn').addEventListener('click', function() {
      // Set cookie dengan nama 'cookieConsent' dan nilai 'accepted'
      setCookie('cookieConsent', 'accepted', 365);
      
      // Sembunyikan banner setelah tombol diklik
      document.getElementById('cookie-banner').style.display = 'none';
    });

    // Cek apakah pengguna sudah memberikan persetujuan cookie
    checkCookieConsent();

  </script>
</body>
</html>
