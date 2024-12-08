<?php
  session_start();
  
  require "../koneksi.php";
  require "config.php";

  // Periksa apakah user sudah login
  if (!isset($_SESSION['user_id'])) {
    header('location: ../');
    exit();
  }

  // Periksa apakah data checkout tersedia
  if (!isset($_SESSION['checkout_data'])) {
    header('location: ../');
    exit();
  }

  // Data Transaksi
  $checkoutData = $_SESSION['checkout_data'];

  // Pastikan data produk tersedia
  if (!isset($checkoutData['produk'])) {
    echo "Data produk tidak ditemukan.";
    exit();
  }

  // Mendapatkan jumlah produk yang dibeli (quantity)
  $quantity = isset($checkoutData['produk']['quantity']) ? (int)$checkoutData['produk']['quantity'] : 1;

  // Menghitung total harga berdasarkan quantity
  $totalPrice = (int) $checkoutData['produk']['harga'] * $quantity;

  $transactionDetails = [
    'order_id' => uniqid('ORDER-'), // Pastikan order_id unik
    'gross_amount' => (int) $checkoutData['produk']['harga']
  ];

  $itemDetails = [
    [
      'id' => 'PROD-' . $checkoutData['produk']['id'],
      'price' => (int) $checkoutData['produk']['harga'],
      'quantity' => $quantity,
      'name' => htmlspecialchars($checkoutData['produk']['nama'])
    ]
  ];

  $customerDetails = [
    'first_name' => htmlspecialchars($checkoutData['nama_pembeli']),
    'email' => htmlspecialchars($checkoutData['email']),
    'phone' => htmlspecialchars($checkoutData['no_telp']),
    'address' => htmlspecialchars($checkoutData['alamat'])
  ];

  // Generate Snap Token
  try {
    $snapParams = [
      'transaction_details' => $transactionDetails,
      'item_details' => $itemDetails,
      'customer_details' => $customerDetails
    ];
    $snapToken = \Midtrans\Snap::getSnapToken($snapParams);
  }
  catch (Exception $e) {
    echo "Error saat memproses pembayaran: " . $e->getMessage();
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran | Toko Online</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eaJdzOPkfg4wBkfG"></script>
</head>
<body>
  <div class="container shadow">
    <div class="d-flex justify-content-center align-items-center flex-column vh-100 w-100">
      <h1 class="text-center mb-4">Pembayaran</h1>
      <button id="pay-button" class="btn btn-success btn-lg">Bayar Sekarang</button>
      <p class="text-dark mt-3">Batalkan pesanan? <a href="javascript:void(0);" onclick="window.location.href = document.referrer;">klik disini.</a></p>

      <a href="https://simulator.sandbox.midtrans.com/v2/qris/index" target="_blank">Pembayaran virtual</a>
      <div class="mt-5">
        <a href="../privacy-policy" class="text-dark ms-3 ">Privacy policy</a>
        <a href="../term-of-service" class="text-dark ms-3 me-3">Terms of service</a>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('pay-button').onclick = function() {
      snap.pay('<?php echo $snapToken; ?>', {
        onSuccess: function(result) {
          console.log(result);
          window.location.href = "success.php"; // Redirect ke halaman sukses
        },
        onPending: function(result) {
          console.log(result);
          alert("Pembayaran Anda tertunda.");
        },
        onError: function(result) {
          console.log(result);
          alert("Pembayaran gagal.");
        },
        onClose: function() {
          alert("Anda menutup popup tanpa menyelesaikan pembayaran.");
        }
      });
    };
  </script>
</body>
</html>
