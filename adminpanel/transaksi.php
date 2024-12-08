<?php
require "session.php";
require "../koneksi.php";

// Ambil data transaksi dari database
$queryTransaksi = mysqli_query($con, "SELECT t.id, t.order_id, p.nama AS nama_produk, t.nama_pembeli, t.no_telp, t.email, t.alamat, t.total_harga, t.status 
                                      FROM transaksi t
                                      JOIN produk p ON t.produk_id = p.id");

if (!$queryTransaksi) {
    die("Query error: " . mysqli_error($con));
}

$jumlahTransaksi = mysqli_num_rows($queryTransaksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Transaksi</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>
<body>
  <!-- Navbar -->
  <?php require "navbar.php"; ?>

  <!-- Breadcrumb -->
  <div class="container mt-5">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="../adminpanel/" class="text-decoration-none text-black-50">
            <i class="fa-solid fa-house"></i> Home
          </a>
        </li>
        <li class="breadcrumb-item text-black-50" aria-current="page">
          Transaksi
        </li>
      </ol>
    </nav>
  </div>

  <div class="container my-5">
    <h2 class="fw-bold">Data Transaksi</h2>

    <div class="table-responsive mt-4">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>No.</th>
            <th>Order ID</th>
            <th>Nama Produk</th>
            <th>Nama Pembeli</th>
            <th>No. Telepon</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if ($jumlahTransaksi == 0) {
              echo "<tr>
                      <td colspan='10' class='text-center'>Tidak ada data transaksi.</td>
                    </tr>";
          } else {
              $no = 1;
              while ($data = mysqli_fetch_array($queryTransaksi)) {
                  echo "<tr>
                          <td>{$no}</td>
                          <td>{$data['order_id']}</td>
                          <td>{$data['nama_produk']}</td>
                          <td>{$data['nama_pembeli']}</td>
                          <td>{$data['no_telp']}</td>
                          <td>{$data['email']}</td>
                          <td>{$data['alamat']}</td>
                          <td>Rp " . number_format($data['total_harga'], 0, ',', '.') . "</td>
                          <td>{$data['status']}</td>
                          <td>
                            <a href='transaksi-detail.php?id={$data['id']}' class='btn btn-info'>
                              <i class='fa-solid fa-search'></i>
                            </a>
                            <a href='transaksi-hapus.php?id={$data['id']}' class='btn btn-danger'>
                              <i class='fa-solid fa-trash'></i>
                            </a>
                          </td>
                        </tr>";
                  $no++;
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
