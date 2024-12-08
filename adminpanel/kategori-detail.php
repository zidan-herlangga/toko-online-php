<?php
  require "../koneksi.php";
  require "session.php";

  // Get the category ID from the URL
  $id = $_GET["id"];
  // Fetch the category details from the database
  $query = mysqli_query($con, "SELECT * FROM kategori WHERE id='$id'");
  $data = mysqli_fetch_array($query);

  // Check if the form was submitted to update the category
  if (isset($_POST["editbtn"])) {
    // Get the updated category name from the form
    $kategori = htmlspecialchars($_POST["kategori"]);

    // Check if the category name is the same as before
    if ($data["nama"] !== $kategori) {
      // If the category name has changed, update it in the database
      $updateQuery = mysqli_query($con, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");

      // Cek update jika sukses
      if ($updateQuery) {
        // Mengarakan ke file kategori jika sukses
        header("Location: kategori.php");
        exit;
      } else {
        // Menampilkan pesan error jika query tidak ada
        $error = "Gagal update kategori: " . mysqli_error($con);
      }
    } else {
      // Menampilkan peringatan jika produk ada yang sama
      $error = "Kategori sudah ada.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kategori Detail</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body>
  <!-- Navbar -->
  <?php require "navbar.php"; ?>

  <div class="container mt-5">
    <h2 class="fw-bold">Kategori Detail</h2>
    
    <div class="row mt-5">
      <div class="col-12 col-md-6">
        <form action="" method="post">
          <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" name="kategori" id="kategori" value="<?php echo htmlspecialchars($data['nama']); ?>" class="form-control">
          </div>

          <button type="submit" name="editbtn" class="btn btn-primary">Edit Kategori</button>

          <?php 
            // Menampilkan pesan error
            if (isset($error)) {
              echo "<div class='alert alert-danger mt-3'>$error</div>";
            }?>
        </form>
      </div>
    </div>
  </div>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
