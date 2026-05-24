<?php
// views/admin/logout_admin.php
session_start();

/* bersihkan session */
$_SESSION = [];
if (ini_get('session.use_cookies')) {
  $p = session_get_cookie_params();
  setcookie(session_name(), '', time()-42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

/* base url project */
$BASE_URL   = '/bioskop-app/'; // GANTI jika nama foldermu berbeda
$loginAdmin = $BASE_URL . 'views/admin/login.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Logout - Admin Dashboard</title>
  <link rel="stylesheet" href="admin_dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <meta http-equiv="refresh" content="2; url=<?= htmlspecialchars($loginAdmin) ?>">
</head>
<body>
  <div class="sidebar">
    <div class="sidebar-header"><h2>Admin Panel</h2></div>
    <ul class="nav-links">
      <li><a href="dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
      <li><a href="kelola_film.php"><i class="fas fa-film"></i> <span>Kelola Film</span></a></li>
      <li><a href="kelola_jadwal.php"><i class="fas fa-calendar-alt"></i> <span>Kelola Jadwal</span></a></li>
      <li><a href="kelola_studio.php"><i class="fas fa-tv"></i> <span>Kelola Studio</span></a></li>
      <li><a href="/bioskop-app/views/admin/logout_admin.php" class="active"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
    </ul>
  </div>

  <div class="main-content">
    <header class="navbar"><h1>Logout</h1></header>
    <div class="content-section active">
      <h2>Logout Berhasil</h2>
      <p>Anda telah berhasil keluar dari sesi admin.</p>
      <p class="logout-message">Anda akan diarahkan ke halaman login dalam beberapa detik...</p>
    </div>
  </div>
</body>
</html>
