<?php
require "session.php";
require "../koneksi.php";

// Ambil data produk
$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahProduk = mysqli_num_rows($query);

// Ambil data kategori
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

// Fungsi random nama file
function generateRandomString($length = 10) {
    $character = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $characterLength = strlen($character);
    $randomString = "";
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $character[rand(0, $characterLength - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk</title>
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
          Produk
        </li>
      </ol>
    </nav>
  </div>

  <!-- Button Tambah Produk -->
  <div class="container my-5">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
      <i class="fa-solid fa-plus"></i> Tambah Produk
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
              <label for="nama">Nama Produk</label>
              <input type="text" name="nama" id="nama" class="form-control mb-2" autocomplete="off" required>

              <label for="kategori">Kategori</label>
              <select name="kategori" id="kategori" class="form-control mb-2" required>
                <option disabled selected>Pilih Kategori</option>
                <?php while ($data = mysqli_fetch_array($queryKategori)): ?>
                  <option value="<?php echo $data["id"]; ?>"><?php echo $data['nama']; ?></option>
                <?php endwhile; ?>
              </select>
              
              <label for="harga">Harga</label>
              <input type="number" name="harga" id="harga" class="form-control mb-2" required>
              
              <label for="foto">Foto / Gambar</label>
              <input type="file" name="foto" id="foto" class="form-control mb-2" required>
              
              <label for="detail">Detail</label>
              <textarea name="detail" id="detail" class="form-control mb-2"></textarea>

              <label for="ketersediaan_stok">Ketersediaan</label>
              <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control mb-2" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Habis">Habis</option>
              </select>

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
        $nama = htmlspecialchars($_POST["nama"]);
        $kategori = htmlspecialchars($_POST["kategori"]);
        $harga = htmlspecialchars($_POST["harga"]);
        $detail = htmlspecialchars($_POST["detail"]);
        $ketersediaan_stok = htmlspecialchars($_POST["ketersediaan_stok"]);

        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/backup-toko-online/image/";
        $nama_file = basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $image_size = $_FILES["foto"]["size"];
        $random_name = generateRandomString();
        $new_name = $random_name . "." . $imageFileType;

        if ($image_size > 9000000) {
            echo "<script>alert('File tidak boleh lebih dari 100 kb.')</script>";
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<script>alert('File wajib bertipe jpg, jpeg, png, atau gif.')</script>";
        } else {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name)) {
                $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) 
                                                   VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$ketersediaan_stok')");
                if ($queryTambah) {
                    echo "<script>alert('Produk berhasil ditambahkan!'); window.location='produk.php';</script>";
                } else {
                    echo "<script>alert('Gagal menambahkan produk!')</script>";
                }
            } else {
                echo "<script>alert('Gagal mengunggah file!')</script>";
            }
        }
    }
    ?>
  </div>

  <div class="container mt-3">
    <h2 class="fw-bold">List Produk</h2>
    <div class="table-responsive my-5">
      <table class="table table-bordered table-striped">
        <thead class="table-dark"> 
          <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Ketersediaan Stok</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($jumlahProduk == 0): ?>
            <tr>
              <td colspan='6' class='text-center'>Tidak ada data produk.</td>
            </tr>";
          <?php else: ?>
            <?php $no = 1 ?>
            <?php while ($data = mysqli_fetch_array($query)): ?>
              <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $data['nama']?></td>
                <td><?php echo $data['nama_kategori']?></td>
                <td>Rp <?php echo number_format($data['harga'], 0, ',', '.')?></td>
                <td><?php echo $data['ketersediaan_stok']?></td>
                <td>
                  <a href="produk-detail.php?id=<?php echo $data['id']?>" class="btn btn-info">
                    <i class="fa-solid fa-search"></i>
                  </a>
                  <a href="produk-hapus.php?id=<?php echo $data['id']?>" class="btn btn-danger">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </td>
              </tr>
              <?php $no++; ?>
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
