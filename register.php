<?php
require "koneksi.php";

// Proses pendaftaran
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST["nama"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["ulang_password"];
    $no_telp = htmlspecialchars($_POST["no_telp"]);

    // Cek apakah password dan konfirmasi password cocok
    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Cek apakah email sudah digunakan
        $checkEmail = mysqli_query($con, "SELECT * FROM users_customer WHERE email = '$email'");
        if (mysqli_num_rows($checkEmail) > 0) {
            $error = "Email sudah terdaftar, gunakan email lain.";
        } else {
            // Enkripsi password
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Masukkan data ke dalam database menggunakan prepared statement untuk keamanan
            $stmt = $con->prepare("INSERT INTO users_customer (nama, email, password, no_telp) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $email, $password_hashed, $no_telp);
            
            if ($stmt->execute()) {
                header("Location: login.php?success=1");
                exit();
            } else {
                $error = "Gagal mendaftarkan pengguna. Silakan coba lagi.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        /* Flexbox layout for image and form side by side */
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 0 20px;
            overflow-y: hidden;
        }

        .register-image {
            flex: 1; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            background: url('image/online_shopping_03.jpg') no-repeat center center; background-size: cover; 
            height: 100%;
        }

        .register-form {
            /* padding: 70px; */
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .register-form h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-label {
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            margin-bottom: 18px;
            font-size: 16px;
            color: #333;
        }

        .form-control:focus {
            outline: none;
            border-color: #007bff;
            background-color: #fff;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 12px 0;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }
            .register-image {
                height: 200px; /* Sesuaikan untuk tampilan mobile */
            }
        }
    </style>
</head>

<body>
    <div class="container register-container">
        <div class="register-image"></div>
        <!-- Register Form Section -->
        <div class="register-form">
            <h2 class="text-center mb-4">Register</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="ulang_password" class="form-label">Masukkan Ulang Password</label>
                    <input type="password" name="ulang_password" id="ulang_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">Nomor Telepon</label>
                    <input type="number" name="no_telp" id="no_telp" class="form-control" required>
                </div>
                <button type="submit" class="btn w-100">Register</button>
                <p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>