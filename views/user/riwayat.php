<?php
session_start();
if (!isset($_SESSION['penonton'])) { header("Location: login_user.php"); exit; }

require_once '../../db/koneksi.php';

$user_id = (int)$_SESSION['penonton']['id'];
$sql = "SELECT p.id, p.nomor_kursi, p.waktu_pesan,
               j.tanggal, j.jam, s.nama_studio, f.judul
        FROM pemesanan p
        JOIN jadwal_tayang j ON p.jadwal_tayang_id = j.id
        JOIN studios s ON j.studio_id = s.id
        JOIN films f ON j.film_id = f.id
        WHERE p.user_id = ?
        ORDER BY p.waktu_pesan DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Pemesanan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--bg:#0f0f0f;--panel:#151515;--card:#1c1c1c;--text:#e8e8e8;--muted:#aaa;--accent:#e50914}
    body{margin:0;background:var(--bg);color:var(--text);font-family:Arial,Helvetica,sans-serif}
    .container{max-width:1000px;margin:0 auto;padding:24px}
    .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
    .btn{background:var(--accent);color:#fff;border:0;padding:10px 14px;border-radius:10px;text-decoration:none;font-weight:700}
    table{width:100%;border-collapse:collapse;background:#1c1c1c;border:1px solid #2c2c2c;border-radius:12px;overflow:hidden}
    th,td{padding:12px;border-bottom:1px solid #2a2a2a;text-align:left}
    th{background:#191919}
    tr:hover{background:#202020}
    .muted{color:var(--muted)}
  </style>
</head>
<body>
  <div class="container">
    <div class="topbar">
      <h2>Riwayat Pemesanan</h2>
      <div>
        <a class="btn" href="jadwal.php" style="background:#444">← Kembali</a>
        <a class="btn" href="../../logout_user.php">Logout</a>
      </div>
    </div>

    <?php if (!$rows): ?>
      <p class="muted">Belum ada pemesanan.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Film</th>
            <th>Studio</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Kursi</th>
            <th>Waktu Pesan</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach ($rows as $r): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($r['judul']) ?></td>
            <td><?= htmlspecialchars($r['nama_studio']) ?></td>
            <td><?= htmlspecialchars($r['tanggal']) ?></td>
            <td><?= htmlspecialchars(substr($r['jam'],0,5)) ?></td>
            <td><?= htmlspecialchars($r['nomor_kursi']) ?></td>
            <td><?= htmlspecialchars($r['waktu_pesan']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
