<?php
  // require "session.php";
  require "koneksi.php";

  // Ambil ID pengguna dari session
  $isLoggedIn = $_SESSION['user_id'];

  // Periksa apakah user sudah login dan $_SESSION['user_id'] sudah terisi
  if (!$isLoggedIn) {
    die("User tidak terautentikasi");
  }
  
  // Pastikan user_id adalah angka untuk mencegah SQL Injection
  if (!is_numeric($isLoggedIn)) {
      die("ID pengguna tidak valid");
  }

  // Query untuk mendapatkan data transaksi pengguna dengan prepared statements
  $query = $con->prepare("SELECT t.order_id, p.nama AS nama_produk, t.status, t.tanggal_estimasi, t.tanggal
                          FROM transaksi t
                          JOIN produk p ON t.produk_id = p.id
                          WHERE t.customer_id = ?");
  $query->bind_param("i", $isLoggedIn);  // 'i' menunjukkan tipe data integer untuk user_id
  $query->execute();
  $result = $query->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Pesanan</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>
<body>

  <?php require "navbar.php"; ?>

  <div class="container mt-5">
    <h2 class="fw-bold">Status Pesanan Anda</h2>
    <div class="table-responsive mt-4">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>No.</th>
            <th>Order ID</th>
            <th>Nama Produk</th>
            <th>Status</th>
            <th>Tanggal Estimasi</th>
            <th>Tanggal Pemesanan</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($result) == 0) {
              echo "<tr><td colspan='6' class='text-center'>Tidak ada pesanan yang ditemukan.</td></tr>";
          } else {
              $no = 1;
              while ($data = mysqli_fetch_array($result)) {
                  $status = $data['status'];
                  $tanggal_estimasi = $data['tanggal_estimasi'] ? date('d-m-Y', strtotime($data['tanggal_estimasi'])) : 'Belum Diperbarui';
                  $tanggal_pemesanan = date('d-m-Y', strtotime($data['tanggal']));
                  
                  echo "<tr>
                          <td>{$no}</td>
                          <td>{$data['order_id']}</td>
                          <td>{$data['nama_produk']}</td>
                          <td>{$status}</td>
                          <td>{$tanggal_estimasi}</td>
                          <td>{$tanggal_pemesanan}</td>
                        </tr>";
                  $no++;
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
