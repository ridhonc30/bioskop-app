<?php
$koneksi = new mysqli("localhost", "root", "", "bioskop");
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

$totalFilm = $koneksi->query("SELECT COUNT(*) AS total FROM films")->fetch_assoc()['total'];
$totalJadwal = $koneksi->query("SELECT COUNT(*) AS total FROM jadwal_tayang")->fetch_assoc()['total'];
$totalStudioAktif = $koneksi->query("SELECT COUNT(*) AS total FROM studios WHERE status = 'Aktif'")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
  <div class="sidebar">
    <div class="sidebar-header">
      <h2>Admin Panel</h2>
    </div>
    <ul class="nav-links">
      <li><a href="dashboard.php" class="active"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
      <li><a href="kelola_film.php"><i class="fas fa-film"></i> <span>Kelola Film</span></a></li>
      <li><a href="kelola_jadwal.php"><i class="fas fa-calendar-alt"></i> <span>Kelola Jadwal</span></a></li>
      <li><a href="kelola_studio.php"><i class="fas fa-tv"></i> <span>Kelola Studio</span></a></li>
      <li><a href="../../logout_admin.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
    </ul>
  </div>

  <div class="main-content">
    <header class="navbar">
      <button class="menu-toggle" aria-label="Toggle Menu"><i class="fas fa-bars"></i></button>
      <h1>Welcome, Admin!</h1>
    </header>

    <div class="content-section" id="dashboard-overview">
      <h2>Dashboard Overview</h2>

      <div class="dashboard-cards">
        <div class="card">
          <h3>Total Films</h3>
          <p><?= $totalFilm ?></p>
          <i class="fas fa-film"></i>
        </div>
        <div class="card">
          <h3>Upcoming Schedules</h3>
          <p><?= $totalJadwal ?></p>
          <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="card">
          <h3>Active Studios</h3>
          <p><?= $totalStudioAktif ?></p>
          <i class="fas fa-tv"></i>
        </div>
      </div>

      <div class="recent-activity">
        <h3>Recent Activities</h3>
        <ul>
          <?php
          $result = $koneksi->query("SELECT deskripsi, waktu FROM aktivitas_admin ORDER BY waktu DESC LIMIT 5");
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<li>" . htmlspecialchars($row['deskripsi']) . " - " . date("d M Y H:i", strtotime($row['waktu'])) . "</li>";
            }
          } else {
            echo "<li>Tidak ada aktivitas terbaru.</li>";
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
