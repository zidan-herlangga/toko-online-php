<?php
  require "session.php";
  require "../koneksi.php";

  $id = $_GET["id"];
  $query = mysqli_query($con, "SELECT * FROM produk WHERE id='$id'");
  $data = mysqli_fetch_array($query);
  $deleteQuery = mysqli_query($con, "DELETE FROM produk WHERE id='$id'");

  if ($deleteQuery) {
    header("Location: produk.php");
    exit;
  } else {
    $error = "Gagal hapus produk: " . mysqli_error($con);
  }
?>

