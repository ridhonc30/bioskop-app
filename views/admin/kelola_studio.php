<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once '../../db/koneksi.php';
require_once '../../models/Studio.php';
require_once '../../models/Aktivitas.php';

$studioList = Studio::semua($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tambah studio
    if (isset($_POST['simpan'])) {
        $nama_studio = $_POST['nama_studio'];
        $jumlah_kursi = $_POST['jumlah_kursi'];
        $status = $_POST['status'];
        $studioBaru = new Studio($nama_studio, $jumlah_kursi, $status);
        $studioBaru->simpan($conn);

        Aktivitas::catat($conn, "Admin menambahkan studio '$nama_studio' dengan status $status");

        header("Location: kelola_studio.php");
        exit();
    }

    // Hapus studio
    if (isset($_POST['hapus_id'])) {
        $id = $_POST['hapus_id'];

        // ambil nama studio sebelum dihapus
        $query = $conn->prepare("SELECT nama_studio FROM studios WHERE id = ?");
        $query->bind_param("i", $id);
        $query->execute();
        $result = $query->get_result();
        $studio = $result->fetch_assoc();
        $nama_studio = $studio['nama_studio'] ?? 'Tanpa Nama';

        Studio::hapus($conn, $id);
        Aktivitas::catat($conn, "Admin menghapus studio '$nama_studio'");

        header("Location: kelola_studio.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kelola Studio</title>
  <link rel="stylesheet" href="admin_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    .status-badge {
      padding: 6px 12px;
      border-radius: 12px;
      color: white;
      font-size: 13px;
      font-weight: bold;
      display: inline-block;
    }
    .active-status {
      background-color: #28a745;
    }
    .inactive-status {
      background-color: #dc3545;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="sidebar-header">
      <h2>Admin Panel</h2>
    </div>
    <ul class="nav-links">
      <li><a href="dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
      <li><a href="kelola_film.php"><i class="fas fa-film"></i> <span>Kelola Film</span></a></li>
      <li><a href="kelola_jadwal.php"><i class="fas fa-calendar-alt"></i> <span>Kelola Jadwal</span></a></li>
      <li><a href="kelola_studio.php" class="active"><i class="fas fa-tv"></i> <span>Kelola Studio</span></a></li>
      <li><a href="/bioskop-app/views/admin/logout_admin.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span>
  </a>
</li>

    </ul>
  </div>

  <div class="main-content">
    <header class="navbar">
      <button class="menu-toggle" aria-label="Toggle Menu"><i class="fas fa-bars"></i></button>
      <h1>Kelola Studio</h1>
    </header>

    <div class="content-section">
        <h2>Tambah Studio</h2>
        <form method="POST" class="form-flex" style="display: flex; flex-direction: column; gap: 20px; max-width: 600px;">
            
            <div style="display: flex; flex-direction: column;">
                <label for="nama_studio" style="font-weight: bold; margin-bottom: 5px;">Nama Studio</label>
                <input type="text" name="nama_studio" id="nama_studio" placeholder="Masukkan nama studio" required class="form-input" style="padding: 10px; border-radius: 8px;">
            </div>

            <div style="display: flex; flex-direction: column;">
                <label for="jumlah_kursi" style="font-weight: bold; margin-bottom: 5px;">Jumlah Kursi</label>
                <input type="number" name="jumlah_kursi" id="jumlah_kursi" placeholder="Masukkan jumlah kursi" required class="form-input" style="padding: 10px; border-radius: 8px;">
            </div>

            <div style="display: flex; flex-direction: column;">
                <label for="status" style="font-weight: bold; margin-bottom: 5px;">Status Studio</label>
                <select name="status" id="status" required class="form-input" style="padding: 10px; border-radius: 8px;">
                    <option value="" disabled selected>-- Pilih Status --</option>
                    <option value="aktif">Aktif</option>
                    <option value="tidak">Tidak Aktif</option>
                </select>
            </div>

            <button type="submit" class="btn primary-btn" name="simpan" style="padding: 12px 25px; align-self: flex-start;">
                <i class="fas fa-plus"></i> Simpan
            </button>
        </form>
    </div>


    <div class="content-section">
      <h2>Daftar Studio</h2>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Studio</th>
              <th>Jumlah Kursi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($studioList as $studio): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($studio['nama_studio']) ?></td>
                <td><?= $studio['jumlah_kursi'] ?></td>
                <td>
                  <?php
                  $status = strtolower(trim($studio['status']));
                  if ($status === 'aktif') {
                    echo '<span class="status-badge active-status">Aktif</span>';
                  } elseif ($status === 'tidak') {
                    echo '<span class="status-badge inactive-status">Tidak Aktif</span>';
                  } else {
                    echo '<span class="status-badge" style="background-color: gray;">Tidak Diketahui</span>';
                  }
                  ?>
                </td>
                <td>
                  <form method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus studio ini?');">
                    <input type="hidden" name="hapus_id" value="<?= $studio['id'] ?>">
                    <button type="submit" class="btn danger-btn"><i class="fas fa-trash"></i> Hapus</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
