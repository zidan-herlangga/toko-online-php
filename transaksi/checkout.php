<?php
session_start();
require "../koneksi.php";

$isLoggedIn = $_SESSION["user_id"];

// Periksa apakah user sudah login
if (!$isLoggedIn) {
    header('location: ../');
    exit();
}

// Periksa apakah parameter 'nama' ada di URL
if (!isset($_GET['nama'])) {
    header('location: ../');
    exit();
}

$namaProduk = htmlspecialchars($_GET['nama'], ENT_QUOTES, 'UTF-8');

// Mencari produk berdasarkan nama
$queryProduk = $con->prepare("SELECT * FROM produk WHERE nama = ?");
$queryProduk->bind_param("s", $namaProduk);
$queryProduk->execute();
$dataProduk = $queryProduk->get_result()->fetch_assoc();

if (!$dataProduk) {
    echo "Produk tidak ditemukan!";
    exit();
}

// Proses saat form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi dan sanitasi input
    $namaPembeli = htmlspecialchars($_POST['nama_pembeli'], ENT_QUOTES, 'UTF-8');
    $noTelp = htmlspecialchars($_POST['no_telp'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $alamat = htmlspecialchars($_POST['alamat'], ENT_QUOTES, 'UTF-8');

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email tidak valid!";
        exit();
    }

    // Validasi nomor telepon (misalnya harus berupa angka dan panjang yang wajar)
    if (!preg_match("/^[0-9]{10,12}$/", $noTelp)) {
        echo "Nomor telepon tidak valid!";
        exit();
    }

    // Simpan data checkout ke session
    $_SESSION['checkout_data'] = [
        'nama_pembeli' => $namaPembeli,
        'no_telp' => $noTelp,
        'email' => $email,
        'alamat' => $alamat,
        'produk' => $dataProduk
    ];

    // Redirect ke halaman payment
    header('Location: payment.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout | Toko Online</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../fontawesome/css/all.min.css">
  <link rel="stylesheet" href="../stylesheet/style.css">
</head>
<body>
  <?php require "../navbar.php"; ?>

  <div class="container my-5">
    <h1 class="text-center mb-4">Checkout</h1>
    <div class="row">
      <div class="col-md-6">
        <h3><strong><?php echo htmlspecialchars($dataProduk['nama'], ENT_QUOTES, 'UTF-8'); ?></strong></h3>
        <img src="../image/<?php echo htmlspecialchars($dataProduk['foto'], ENT_QUOTES, 'UTF-8'); ?>" class="w-100 mb-3" height="450" alt="<?php echo htmlspecialchars($dataProduk['nama'], ENT_QUOTES, 'UTF-8'); ?>">
        <p>Harga: <strong>Rp <?php echo number_format($dataProduk['harga'], 0, ',', '.'); ?></strong></p>
        <p>
          Deskripsi: <br>
          <?php echo nl2br(htmlspecialchars($dataProduk['detail'], ENT_QUOTES, 'UTF-8')); ?>
        </p>
      </div>
      <div class="col-md-6">
        <form method="POST">
          <div class="mb-3">
            <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
            <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" required>
          </div>
          <div class="mb-3">
            <label for="no_telp" class="form-label">Nomor Telepon</label>
            <input type="tel" class="form-control" id="no_telp" name="no_telp" required pattern="[0-9]{10,12}">
            <small class="form-text text-muted">Masukkan nomor telepon yang valid (10-12 digit)</small>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-dark w-100 mb-3">Lanjutkan ke Pembayaran</button>
          <span><strong>Note: </strong>Jika sudah melakukan pembayaran, tolong screenshot sebagai bukti, lalu kirimkan transaksi tersebut ke kontak kami.</span>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require "../footer.php"; ?>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
