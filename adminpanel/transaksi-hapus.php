<?php
  require "session.php";
  require "../koneksi.php";

  $id = $_GET["id"];
  $query = mysqli_query($con, "SELECT * FROM transaksi WHERE id='$id'");
  $data = mysqli_fetch_array($query);

  // Check if the form is submitted to delete the category
    // Delete the category from the database
    $deleteQuery = mysqli_query($con, "DELETE FROM transaksi WHERE id='$id'");

    if ($deleteQuery) {
      // Redirect to the category listing page after successful deletion
      header("Location: transaksi.php");
      exit;
    } else {
      $error = "Gagal hapus kategori: " . mysqli_error($con);
    }
?>

