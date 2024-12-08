<?php
  require "session.php";
  require "../koneksi.php";

  // Ambil data kategori
  $query = mysqli_query($con, "SELECT * FROM kategori");
  $jumlahKategori = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kategori</title>
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
          Kategori
        </li>
      </ol>
    </nav>
  </div>

  <div class="container my-5">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
      <i class="fa-solid fa-plus"></i> Tambah Kategori
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Kategori</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="" method="post">
              <label for="kategori">Nama Kategori</label>
              <input type="text" name="kategori" id="kategori" class="form-control mt-2" placeholder="Masukkan Kategori" required>
              <div class="modal-footer">
                <button type="submit" name="tambahbtn" class="btn btn-success">Tambah</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php 
    if (isset($_POST["tambahbtn"])) {
        $kategori = htmlspecialchars($_POST['kategori']);
        
        // Cek apakah kategori sudah ada
        $cek = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");
        if (mysqli_num_rows($cek) > 0) {
            echo "<div class='alert alert-danger mt-3'>Kategori sudah ada!</div>";
        } else {
            // Tambahkan kategori baru
            $insert = mysqli_query($con, "INSERT INTO kategori (nama) VALUES ('$kategori')");
            if ($insert) {
                echo "<div class='alert alert-success mt-3'>Kategori berhasil ditambahkan!</div>";
                header("Refresh: 2"); // Reload halaman
            } else {
                echo "<div class='alert alert-danger mt-3'>Gagal menambahkan kategori!</div>";
            }
        }
    }
    ?>
  </div>

  <div class="container mt-3">
    <h2 class="fw-bold">List Kategori</h2>

    <div class="table-responsive mt-5">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if ($jumlahKategori == 0) {
              echo "<tr>
                      <td colspan='3' class='text-center'>Tidak ada data kategori.</td>
                    </tr>";
          } else {
              $no = 1;
              while ($data = mysqli_fetch_array($query)) {
                  echo "<tr>
                          <td>{$no}</td>
                          <td>{$data['nama']}</td>
                          <td>
                            <a href='kategori-detail.php?id={$data['id']}' class='btn btn-info'>
                              <i class='fa-solid fa-search'></i>
                            </a>
                             <a href='kategori-hapus.php?id={$data['id']}' class='btn btn-danger'>
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
