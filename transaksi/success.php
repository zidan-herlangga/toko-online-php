<?php
session_start();
require "../koneksi.php";

$isLoggedIn = $_SESSION["user_id"];

// Pastikan user sudah login
if (!$isLoggedIn) {
    header('location: ../');
    exit();
}

// Pastikan data checkout tersedia di session
if (!isset($_SESSION['checkout_data'])) {
    header('location: ../produk.php');
    exit();
}

// Ambil data checkout
$checkoutData = $_SESSION['checkout_data'];

// Hapus sesi checkout untuk menghindari pengulangan pembayaran
unset($_SESSION['checkout_data']);

// Ambil data dari session dan checkout data
$isLoggedIn = $_SESSION['user_id'];  // ID user yang login
$produkId = $checkoutData['produk']['id'];
$namaPembeli = htmlspecialchars($checkoutData['nama_pembeli']);
$email = htmlspecialchars($checkoutData['email']);
$noTelp = htmlspecialchars($checkoutData['no_telp']);
$alamat = htmlspecialchars($checkoutData['alamat']);
$harga = (int) $checkoutData['produk']['harga'];
$tanggal = date('Y-m-d H:i:s');
$orderId = uniqid('ORDER-'); // Order ID unik

// Query untuk memasukkan transaksi
$query = $con->prepare("INSERT INTO transaksi (order_id, produk_id, customer_id, nama_pembeli, email, no_telp, alamat, total_harga, tanggal, status)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
$query->bind_param("siissssds", $orderId, $produkId, $isLoggedIn, $namaPembeli, $email, $noTelp, $alamat, $harga, $tanggal);

if ($query->execute()) {
    // Jika berhasil, redirect ke halaman sukses atau detail pesanan
    header('Location: success.php?order_id=' . $orderId);
    exit();
} else {
    echo "Terjadi kesalahan dalam pemrosesan transaksi!";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran Sukses | Toko Online</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
  <div class="container my-5">
    <div class="text-center">
      <h1 class="text-success mb-4">Pembayaran Berhasil!</h1>
      <p class="fs-5">Terima kasih telah melakukan pembelian, <strong><?php echo $namaPembeli; ?></strong>.</p>
      <p class="fs-6">Detail pesanan Anda telah kami terima dan akan segera diproses.</p>
      <p class="fw-bold">Order ID: <?php echo $orderId; ?></p>
      <hr>
      <p>Jika Anda memiliki pertanyaan, silakan hubungi layanan pelanggan kami.</p>
      <a href="../produk.php" class="btn btn-outline-primary me-3">Lanjut Belanja</a>
      <a href="order-detail.php?order_id=<?php echo $orderId; ?>" class="btn btn-primary">Lihat Detail Pesanan</a>
    </div>
  </div>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
