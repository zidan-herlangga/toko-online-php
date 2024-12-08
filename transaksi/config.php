<?php

  require "../koneksi.php";
  require "../vendor/midtrans/midtrans-php/Midtrans.php";

  // Konfigurasi Midtrans
  \Midtrans\Config::$serverKey = 'SB-Mid-server-MVLYtIx_aq535F6yjN_sysDk';
  \Midtrans\Config::$isProduction = false; // Ubah menjadi true jika di produksi
  \Midtrans\Config::$isSanitized = true;
  \Midtrans\Config::$is3ds = true;
?>