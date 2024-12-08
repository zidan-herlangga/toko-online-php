<?php
  require "../koneksi.php"; // Menghubungkan dengan file koneksi database
  require "session.php"; // Menghubungkan dengan file untuk pengecekan session

  // Mendapatkan ID transaksi dari URL
  $id = $_GET["id"];

  // Mengambil data transaksi berdasarkan ID dari database
  $query = mysqli_query($con, "SELECT * FROM transaksi WHERE id='$id'");
  $data = mysqli_fetch_array($query); // Mengambil data transaksi sebagai array

  // Memeriksa apakah form telah disubmit untuk memperbarui status transaksi
  if (isset($_POST["editbtn"])) {
    // Mengambil nilai yang diupdate dari form
    $status = htmlspecialchars($_POST["status"]); // Mengamankan inputan dari XSS

    // Memeriksa apakah ada perubahan pada status transaksi
    if ($data["status"] != $status) {
      // Jika ada perubahan, lakukan update pada database
      $updateQuery = mysqli_query($con, "UPDATE transaksi SET status='$status' WHERE id='$id'");

      // Memeriksa apakah query update berhasil
      if ($updateQuery) {
        // Jika berhasil, redirect ke halaman transaksi setelah update
        header("Location: transaksi.php");
        exit; // Pastikan tidak ada kode lain yang dieksekusi setelah redirect
      } else {
        // Jika gagal, tampilkan pesan error
        $error = "Gagal update transaksi: " . mysqli_error($con);
      }
    } else {
      // Jika tidak ada perubahan, beri pesan bahwa tidak ada perubahan
      $error = "Tidak ada perubahan pada status transaksi.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Transaksi</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"> <!-- Menambahkan link ke bootstrap -->
</head>
<body>
  <!-- Navbar (menggunakan file navbar.php untuk menampilkan navigasi) -->
  <?php require "navbar.php"; ?>

  <div class="container mt-5">
    <h2 class="fw-bold">Edit Transaksi</h2>
    
    <div class="row mt-5">
      <div class="col-12 col-md-6">
        <!-- Form untuk update status transaksi -->
        <form method="POST" action="">
          <!-- Dropdown untuk memilih status transaksi -->
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
              <option value="Pending" <?php echo ($data['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
              <option value="Sukses" <?php echo ($data['status'] == 'Sukses') ? 'selected' : ''; ?>>Sukses</option>
            </select>
          </div>

          <!-- Tombol untuk submit form -->
          <button type="submit" name="editbtn" class="btn btn-primary">Edit Status</button>

          <?php 
            // Menampilkan pesan error jika ada masalah dengan proses update
            if (isset($error)) {
              echo "<div class='mt-3 text-danger'>$error</div>";
            }
          ?>
        </form>
      </div>
    </div>
  </div>

  <!-- Menambahkan script bootstrap -->
  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
