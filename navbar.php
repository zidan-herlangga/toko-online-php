<div class="container-fluid bg-dark">
  <div class="container">

    <div class="mt-2">
      <?php if ($isLoggedIn): ?>
        <span class="text-white mt-3"  style="border-bottom: 1px solid #eaeaea;">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?></span>
      <?php else: ?>
        <span class="text-white"></span>
      <?php endif; ?>
    </div>
  </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="../backup-toko-online">Toko Online</a>

    <button class="navbar-toggler btn-outline-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark w-100" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header" style="border-bottom: 1px solid #eaeaea;">
        <div class="d-flex flex-column justify-content-start">

          <?php if ($isLoggedIn): ?>
            <span class="my-2 tetx-white">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?></span>
            <?php endif; ?>
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Toko Online</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        
        <!-- Sosial Media -->
        <div class="d-flex justify-content-start mb-3" style="position: fixed; bottom: 30px;" >
          <li class="list-group">
            <a href="https://wa.me/6285161334009" class="text-white fs-5">
              <i class="fa-brands fa-whatsapp"></i>
            </a>
          </li>
          <li class="list-group">
            <a href="https://instagram.com/zidanherlangga_" class="text-white ms-4 fs-5">
              <i class="fa-brands fa-instagram"></i>
            </a>
          </li>
          <li class="list-group">
            <a href="https://x.com/dansec04_" class="text-white ms-4 fs-5">
              <i class="fa-brands fa-x-twitter"></i>
            </a>
          </li>
        </div>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav me-auto">
          <?php if ($isLoggedIn): ?>
          <li class="nav-item">
            <a class="nav-link active" href="../backup-toko-online">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="produk.php">Produk</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="kategori.php">Kategori</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="status.php"><i class="fa-solid fa-cart-flatbed"></i> Status</a>
          </li> -->
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</nav>
