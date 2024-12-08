<?php

  // Periksa apakah user login
  $isLoggedIn = isset($_SESSION['user_id']);

  if (!$isLoggedIn) {
    header('location: ../');
  }

?>