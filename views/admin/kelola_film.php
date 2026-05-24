<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once '../../db/koneksi.php';
require_once '../../models/Film.php';
require_once '../../models/Aktivitas.php';

$filmList = Film::semua($conn);

// Hapus film
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if (Film::hapus($conn, $id)) {
        $username = ucfirst($_SESSION['admin']['username']);
        Aktivitas::catat($conn, "$username menghapus film dengan ID $id");
    }
    header("Location: kelola_film.php");
    exit;
}

// Tambah film baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $durasi = $_POST['durasi'];
    $poster = null;

    if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
        $posterName = time() . '_' . basename($_FILES['poster']['name']);
        $uploadDir = '../../uploads/poster/';
        $uploadPath = $uploadDir . $posterName;

        if (move_uploaded_file($_FILES['poster']['tmp_name'], $uploadPath)) {
            $poster = $posterName;
        }
    }

    $filmBaru = new Film($judul, $genre, $durasi, $poster);
    if ($filmBaru->simpan($conn)) {
        $username = ucfirst($_SESSION['admin']['username']);
        Aktivitas::catat($conn, "$username menambahkan film baru: $judul");
    }

    header("Location: kelola_film.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kelola Film</title>
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
      <li><a href="kelola_film.php" class="active"><i class="fas fa-film"></i> <span>Kelola Film</span></a></li>
      <li><a href="kelola_jadwal.php"><i class="fas fa-calendar-alt"></i> <span>Kelola Jadwal</span></a></li>
      <li><a href="kelola_studio.php"><i class="fas fa-tv"></i> <span>Kelola Studio</span></a></li>
      <li><a href="/bioskop-app/views/admin/logout_admin.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span>
  </a>
</li>

    </ul>
  </div>

  <div class="main-content">
    <header class="navbar">
      <button class="menu-toggle" aria-label="Toggle Menu"><i class="fas fa-bars"></i></button>
      <h1>Kelola Film</h1>
    </header>

    <div class="content-section">
        <h2>Tambah Film</h2>
        <form method="POST" enctype="multipart/form-data" class="form-flex" style="display: flex; flex-direction: column; gap: 20px; max-width: 600px;">
            
            <div style="display: flex; flex-direction: column;">
                <label for="judul" style="font-weight: bold; margin-bottom: 5px;">Judul Film</label>
                <input type="text" id="judul" name="judul" placeholder="Masukkan judul film" required class="form-input" style="padding: 10px; border-radius: 8px;">
            </div>

            <div style="display: flex; flex-direction: column;">
                <label for="genre" style="font-weight: bold; margin-bottom: 5px;">Genre</label>
                <input type="text" id="genre" name="genre" placeholder="Contoh: Aksi, Drama, Komedi" required class="form-input" style="padding: 10px; border-radius: 8px;">
            </div>

            <div style="display: flex; flex-direction: column;">
                <label for="durasi" style="font-weight: bold; margin-bottom: 5px;">Durasi (menit)</label>
                <input type="number" id="durasi" name="durasi" placeholder="Contoh: 120" required class="form-input" style="padding: 10px; border-radius: 8px;">
            </div>

            <div style="display: flex; flex-direction: column;">
                <label for="poster" style="font-weight: bold; margin-bottom: 5px;">Upload Poster Film</label>
                <input type="file" id="poster" name="poster" accept="image/*" class="form-input" style="padding: 10px; border-radius: 8px;">
            </div>

            <button type="submit" class="btn primary-btn" name="simpan" style="padding: 12px 25px; align-self: flex-start;">
                <i class="fas fa-plus"></i> Simpan
            </button>
        </form>
    </div>


    <div class="content-section">
      <h2>Daftar Film</h2>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Poster</th>
              <th>Judul</th>
              <th>Genre</th>
              <th>Durasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($filmList as $i => $film): ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td>
                  <?php if ($film['poster']): ?>
                    <img src="../../uploads/poster/<?= htmlspecialchars($film['poster']) ?>" alt="Poster" style="width: 60px;">
                  <?php else: ?>
                    <span>Tidak Ada</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($film['judul']) ?></td>
                <td><?= htmlspecialchars($film['genre']) ?></td>
                <td><?= $film['durasi'] ?> menit</td>
                <td>
                  <a href="?hapus=<?= $film['id'] ?>" class="btn danger-btn" onclick="return confirm('Hapus film ini?')"><i class="fas fa-trash-alt"></i> Hapus</a>
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
