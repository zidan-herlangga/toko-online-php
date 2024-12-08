<?php
	require "koneksi.php";

	// Proses login
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = htmlspecialchars($_POST["email"]);
		$password = $_POST["password"];

		// Cek apakah email terdaftar
		$query = mysqli_query($con, "SELECT * FROM users_customer WHERE email = '$email'");
		$user = mysqli_fetch_assoc($query);

		if ($user) {
			// Verifikasi password
			if (password_verify($password, $user["password"])) {
				// Set session user
				session_start();
				$_SESSION["user_id"] = $user["id"];
				$_SESSION["nama"] = $user["nama"];
				$_SESSION["email"] = $user["email"];
				header("Location: ../backup-toko-online");
				exit();
			} else {
				$error = "Password yang Anda masukkan salah.";
			}
		} else {
			$error = "Email tidak ditemukan.";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="stylesheet/style.css"> -->
  <style>
    body {
      background-color: #fff;
      font-family: 'Arial', sans-serif;
    }
    .login-content {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 0 20px;
      overflow-y: hidden;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      width: 400px;
      z-index: 1;
    }
    .login-image {
      flex: 1;
      background-image: url('image/online_shopping_03.jpg'); /* Ganti dengan path gambar Anda */
      background-size: cover;
      background-position: center;
      height: 500px;
    }
    .login-form h2 {
      margin-bottom: 1.5rem;
      color: #343a40;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
    .alert {
      margin-bottom: 1rem;
    }
    @media (max-width: 768px) {
      .login-content {
        flex-direction: column;
      }
      .login-image {
        height: 200px; /* Sesuaikan untuk tampilan mobile */
        border-radius: 8px 8px 0 0;
      }
      .login-container {
        width: 90%;
      }
    }
  </style>
</head>
<body>
  <div class="container login-content">
    <div class="login-image"></div>
    <div class="login-container">
      <div class="login-form">
        <h2 class="text-center">Login</h2>
        <?php if (isset($error)): ?>
          <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
          <p class="text-center mt-3">Belum punya akun? <a href="register.php">Daftar</a></p>
        </form>
      </div>
    </div>
  </div>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>