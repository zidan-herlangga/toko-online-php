<?php
  require "session.php";
  require "../koneksi.php";

  // Ambil data transaksi dari database
  $queryCustomer = mysqli_query($con, "SELECT id, nama, email, password, no_telp FROM users_customer");
  $jumlahCustomer = mysqli_num_rows($queryCustomer);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Customer</title>
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
          Akun
        </li>
      </ol>
    </nav>
  </div>

  <div class="container my-5">
    <h2 class="fw-bold">Data Customer</h2>

    <div class="table-responsive mt-4">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Password</th>
            <th>No. Telepon</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($jumlahCustomer == 0) :?>
            <tr>
              <td colspan='5' class='text-center'>Tidak ada data transaksi.</td>
            </tr>
          <?php else : ?>
            <?php $no = 1 ?>
            <?php while ($data = mysqli_fetch_array($queryCustomer)) :?>
              <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $data['nama'] ?></td>
                <td><?php echo $data['email'] ?></td>
                <td><?php echo $data['password'] ?></td>
                <td><?php echo $data['no_telp'] ?></td>
              </tr>
            <?php $no++ ?>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
