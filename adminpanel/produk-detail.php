<?php
  require "../koneksi.php"; // Menghubungkan dengan file koneksi database
  require "session.php"; // Menghubungkan dengan file untuk pengecekan session

  // Mendapatkan ID produk dari URL
  $id = $_GET["id"];

  // Mengambil data produk berdasarkan ID dari database
  $query = mysqli_query($con, "SELECT * FROM produk WHERE id='$id'");
  $data = mysqli_fetch_array($query); // Mengambil data produk sebagai array

  // Memeriksa apakah form telah disubmit untuk memperbarui produk
  if (isset($_POST["editbtn"])) {
    // Mengambil nilai yang diupdate dari form
    $produk = htmlspecialchars($_POST["produk"]); // Mengambil nama produk dan mengamankan inputan dari XSS
    $harga = $_POST["harga"];  // Mengambil harga dari form
    $ketersediaan_stok = $_POST["ketersediaan_stok"];  // Mengambil ketersediaan stok dari form

    // Memeriksa apakah ada perubahan pada nama produk, harga, atau ketersediaan stok
    if ($data["nama"] != $produk || $data["harga"] != $harga || $data["ketersediaan_stok"] != $ketersediaan_stok || $data["detail"] != $detail) {
      // Jika ada perubahan, lakukan update pada database
      $updateQuery = mysqli_query($con, "UPDATE produk SET nama='$produk', harga='$harga', ketersediaan_stok='$ketersediaan_stok' WHERE id='$id'");

      // Memeriksa apakah query update berhasil
      if ($updateQuery) {
        // Jika berhasil, redirect ke halaman produk setelah update
        header("Location: produk.php");
        exit; // Pastikan tidak ada kode lain yang dieksekusi setelah redirect
      } else {
        // Jika gagal, tampilkan pesan error
        $error = "Gagal update produk: " . mysqli_error($con);
      }
    } else {
      // Jika tidak ada perubahan, beri pesan bahwa tidak ada perubahan
      $error = "Tidak ada perubahan pada produk.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"> <!-- Menambahkan link ke bootstrap -->
</head>
<body>
  <!-- Navbar (menggunakan file navbar.php untuk menampilkan navigasi) -->
  <?php require "navbar.php"; ?>

  <div class="container mt-5">
    <h2 class="fw-bold">Edit Produk</h2>
    
    <div class="row mt-5">
      <div class="col-12 col-md-6">
        <!-- Form untuk mengedit produk -->
        <form action="" method="post">
          <!-- Input untuk nama produk -->
          <div class="mb-3">
            <label for="produk" class="form-label">Nama Produk</label>
            <input type="text" name="produk" id="produk" value="<?php echo htmlspecialchars($data['nama']); ?>" class="form-control" required>
          </div>

          <!-- Input untuk harga produk -->
          <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" value="<?php echo htmlspecialchars($data['harga']); ?>" class="form-control" required>
          </div>

          <!-- Input untuk detail produk -->
          <div class="mb-3">
            <label for="detail" class="form-label">Detail</label>
            <textarea name="detail" id="detail" class="form-control"><?php echo $data["detail"]; ?></textarea>
          </div>

          <!-- Dropdown untuk memilih ketersediaan stok -->
          <div class="mb-3">
            <label for="ketersediaan_stok" class="form-label">Ketersediaan Stok</label>
            <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control" required>
              <option value="Tersedia" <?php echo ($data['ketersediaan_stok'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
              <option value="Habis" <?php echo ($data['ketersediaan_stok'] == 'Habis') ? 'selected' : ''; ?>>Habis</option>
            </select>
          </div>

          <!-- Tombol untuk submit form -->
          <button type="submit" name="editbtn" class="btn btn-primary">Edit Produk</button>

          <?php 
            // Menampilkan pesan error jika ada masalah dengan proses update
            if (isset($error)) {
              echo "<div class='mt-3 text-danger'>$error</div>";
            }
          ?>
        </form>
      </div>

      <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
        <?php
          // Memeriksa apakah ada gambar yang terkait dengan produk
          if (!empty($data['foto'])) {
            // Jika ada gambar, tampilkan gambar produk
            echo "<img src='../image/" . htmlspecialchars($data['foto']) . "' alt='Foto Produk' class='img-fluid img-thumbnail' style='max-width: 100%; height: 300px; object-fit: cover;'>";
          } else {
            // Jika tidak ada gambar, tampilkan placeholder
            echo "<img src='../images/no-image.png' alt='Tidak Ada Gambar' class='img-fluid' style='max-width: 100%; height: auto;'>";
          }
        ?>
      </div>
    </div>
  </div>

  <!-- Menambahkan script bootstrap -->
  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
