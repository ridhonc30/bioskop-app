<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require_once '../../db/koneksi.php';
require_once '../../models/Film.php';
require_once '../../models/Studio.php';
require_once '../../models/JadwalTayang.php';
require_once '../../models/Aktivitas.php';

$filmList = Film::semua($conn);
$studioList = Studio::semuaAktif($conn);
$jadwalList = JadwalTayang::semua($conn);

// Tambah Jadwal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $film_id = $_POST['film_id'];
    $studio_id = $_POST['studio_id'];
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];

    $jadwal = new JadwalTayang($film_id, $studio_id, $tanggal, $jam);
    if ($jadwal->simpan($conn)) {
        // ambil judul film
        $film = $conn->query("SELECT judul FROM films WHERE id = $film_id")->fetch_assoc();
        $judul = $film ? $film['judul'] : "ID $film_id";

        $admin = ucfirst($_SESSION['admin']['username']);
        Aktivitas::catat($conn, "$admin menambahkan jadwal tayang film $judul");
    }
    header("Location: kelola_jadwal.php");
    exit;
}

// Hapus Jadwal
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // ambil info film sebelum dihapus
    $jadwalData = $conn->query("SELECT f.judul FROM jadwal_tayang jt JOIN films f ON jt.film_id = f.id WHERE jt.id = $id")->fetch_assoc();
    $judul = $jadwalData ? $jadwalData['judul'] : "ID $id";

    if (JadwalTayang::hapus($conn, $id)) {
        $admin = ucfirst($_SESSION['admin']['username']);
        Aktivitas::catat($conn, "$admin menghapus jadwal tayang film $judul");
    }
    header("Location: kelola_jadwal.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kelola Jadwal</title>
  <link rel="stylesheet" href="admin_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
  <div class="sidebar">
    <div class="sidebar-header">
      <h2>Admin Panel</h2>
    </div>
    <ul class="nav-links">
      <li><a href="dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
      <li><a href="kelola_film.php"><i class="fas fa-film"></i> <span>Kelola Film</span></a></li>
      <li><a href="kelola_jadwal.php" class="active"><i class="fas fa-calendar-alt"></i> <span>Kelola Jadwal</span></a></li>
      <li><a href="kelola_studio.php"><i class="fas fa-tv"></i> <span>Kelola Studio</span></a></li>
      <li><a href="/bioskop-app/views/admin/logout_admin.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span>
  </a>
</li>

  </a>
</li>

    </ul>
  </div>

  <div class="main-content">
    <header class="navbar">
      <button class="menu-toggle" aria-label="Toggle Menu"><i class="fas fa-bars"></i></button>
      <h1>Kelola Jadwal</h1>
    </header>

    <div class="content-section">
        <h2>Tambah Jadwal Tayang</h2>
        <form method="POST" class="form-flex" style="display: flex; flex-direction: column; gap: 20px; max-width: 600px;">
            
            <div style="display: flex; flex-direction: column;">
                <label for="film_id" style="font-weight: bold; margin-bottom: 5px;">Pilih Film</label>
                <select name="film_id" id="film_id" required class="form-input" style="padding: 10px; border-radius: 8px;">
                    <option value="" disabled selected>-- Pilih Film --</option>
                    <?php foreach ($filmList as $film): ?>
                        <option value="<?= $film['id'] ?>"><?= htmlspecialchars($film['judul']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: flex; flex-direction: column;">
                <label for="studio_id" style="font-weight: bold; margin-bottom: 5px;">Pilih Studio</label>
                <select name="studio_id" id="studio_id" required class="form-input" style="padding: 10px; border-radius: 8px;">
                    <option value="" disabled selected>-- Pilih Studio --</option>
                    <?php foreach ($studioList as $studio): ?>
                        <option value="<?= $studio['id'] ?>">Studio <?= htmlspecialchars($studio['nama_studio']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: flex; flex-direction: column;">
                <label for="tanggal" style="font-weight: bold; margin-bottom: 5px;">Tanggal Tayang</label>
                <input type="date" id="tanggal" name="tanggal" required class="form-input" style="padding: 10px; border-radius: 8px;">
            </div>

            <div style="display: flex; flex-direction: column;">
                <label for="jam" style="font-weight: bold; margin-bottom: 5px;">Jam Tayang</label>
                <input type="time" id="jam" name="jam" required class="form-input" style="padding: 10px; border-radius: 8px;">
            </div>

            <button type="submit" class="btn primary-btn" name="simpan" style="padding: 12px 25px; align-self: flex-start;">
                <i class="fas fa-plus"></i> Simpan
            </button>
        </form>
    </div>


    <div class="content-section">
      <h2>Daftar Jadwal</h2>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Film</th>
              <th>Studio</th>
              <th>Tanggal</th>
              <th>Jam</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($jadwalList as $i => $jadwal): ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($jadwal['judul']) ?></td>
                <td><?= htmlspecialchars($jadwal['nama_studio']) ?></td>
                <td><?= $jadwal['tanggal'] ?></td>
                <td><?= substr($jadwal['jam'], 0, 5) ?></td>
                <td>
                  <a href="kelola_jadwal.php?hapus=<?= $jadwal['id'] ?>" onclick="return confirm('Hapus jadwal ini?')" class="btn danger-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    const toggleBtn = document.querySelector(".menu-toggle");
    const sidebar = document.querySelector(".sidebar");
    const mainContent = document.querySelector(".main-content");

    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed");
      mainContent.classList.toggle("shifted");
    });
  </script>
</body>
</html>
