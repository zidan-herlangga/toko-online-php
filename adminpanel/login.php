<?php
  session_start();
  require "../koneksi.php";

            if(isset($_POST["loginbtn"])) {
              $username = htmlspecialchars($_POST["username"]);
              $password = htmlspecialchars($_POST["password"]);

              $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
              
              $countdata = mysqli_num_rows($query);
              $data = mysqli_fetch_array($query);
              
              if ($countdata > 0) {
                if (password_verify( $password, $data["password"])) {
                  $_SESSION["username"] = $data["username"];
                  $_SESSION["login"] = true;
                  header("location: ../adminpanel");
                } 
                else {
                  echo "
                    <div class='alert alert-warning' role='alert'>
                      Usename atau Passrword salah!
                    </div>";
                }
              } 
              else { 
                echo "
                  <div class='alert alert-warning' role='alert'>
                    Usename atau Passrword salah!
                  </div>";              
              }
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<style>
  /* body {
    background: #FFB38E;
  } */
  
  .main {
    height: 100vh;
  }

  .login-box {
    background: #fff;
    width: 500px;
    height: auto;
    box-sizing: border-box;
    border-radius: 10px;
  }
</style>

<body>
  <div class="main d-flex justify-content-center align-items-center">
    <div class="login-box p-3 shadow">
      <div >
        <!-- <img src="image/admin-logo.png" alt="" height="100" width="100"> -->
        <h2 class="text-center fw-bold mb-4">Admin Panel</h2>
      </div>
      <hr>
      <form action="" method="post">
        <div class="mb-4">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" class="form-control">
        </div>
          
        <div class="mb-4">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="text-center">
          <button type="submit" name="loginbtn" class="btn btn-primary form-control mb-4">Login</button>          
        </div>
      </form>
    </div>
  </div>

  <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>