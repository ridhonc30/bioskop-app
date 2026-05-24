<?php
session_start();
if (!isset($_SESSION['penonton'])) { header("Location: login_user.php"); exit; }
$id = (int)($_GET['id'] ?? 0);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Konfirmasi Pemesanan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{margin:0;background:#0f0f0f;color:#e8e8e8;font-family:Arial}
    .wrap{max-width:700px;margin:0 auto;padding:32px}
    .card{background:#1c1c1c;border:1px solid #2c2c2c;border-radius:16px;padding:24px}
    .btn{display:inline-block;margin-top:14px;background:#e50914;color:#fff;text-decoration:none;padding:10px 14px;border-radius:10px;font-weight:700}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <h2>Pemesanan Berhasil 🎉</h2>
      <p>Nomor pemesanan: <b>#<?= $id ?></b></p>
      <a class="btn" href="riwayat.php">Lihat Riwayat</a>
      <a class="btn" style="background:#444" href="jadwal.php">Pesan Lagi</a>
    </div>
  </div>
</body>
</html>
