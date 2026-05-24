<?php
// FILE: views/user/jadwal.php
session_start();
if (!isset($_SESSION['penonton'])) { header("Location: login_user.php"); exit; }

require_once '../../db/koneksi.php';

// ==== KONFIGURASI: ganti jika nama folder projek bukan "bioskop-app"
$BASE_URL = '/bioskop-app/';               // contoh: '/bioskop-app/' atau '/myapp/'
$POSTER_DIR_URL = $BASE_URL . 'uploads/poster/';
$PLACEHOLDER_URL = $POSTER_DIR_URL . 'no-poster.png'; // siapkan file ini

// Ambil jadwal (JOIN film & studio)
$sql = "SELECT jt.id, jt.film_id, f.judul, f.poster, s.nama_studio, jt.tanggal, jt.jam
        FROM jadwal_tayang jt
        JOIN films f ON jt.film_id = f.id
        JOIN studios s ON jt.studio_id = s.id
        ORDER BY jt.tanggal ASC, jt.jam ASC";
$jadwal = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

// Helper kecil buat menentukan URL poster aman
function poster_url($poster, $POSTER_DIR_URL, $PLACEHOLDER_URL) {
    $poster = trim((string)$poster);
    if ($poster === '') return $PLACEHOLDER_URL;
    // Jika sudah URL absolut (http/https), pakai apa adanya
    if (stripos($poster, 'http://') === 0 || stripos($poster, 'https://') === 0) return $poster;
    // Jika hanya nama file/relative, ambil dari uploads/poster
    return $POSTER_DIR_URL . rawurlencode(basename($poster));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Jadwal Tayang</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--bg:#0f0f0f;--panel:#151515;--card:#1c1c1c;--text:#e8e8e8;--muted:#aaa;--accent:#e50914}
    *{box-sizing:border-box} body{margin:0;background:var(--bg);color:var(--text);font-family:Arial,Helvetica,sans-serif}
    .container{max-width:1100px;margin:0 auto;padding:24px}
    .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
    .btn{background:var(--accent);color:#fff;border:0;padding:10px 14px;border-radius:10px;text-decoration:none;font-weight:700}
    .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px}
    .card{background:var(--card);border:1px solid #2c2c2c;border-radius:16px;padding:14px;display:flex;gap:12px;align-items:center}
    .poster{width:64px;height:96px;background:#222;border-radius:8px;object-fit:cover}
    .title{font-size:18px;margin:0 0 6px}
    .muted{color:var(--muted);font-size:13px}
  </style>
</head>
<body>
  <div class="container">
    <div class="topbar">
      <h2>Jadwal Tayang</h2>
      <div>
        <span style="margin-right:10px">Halo, <b><?= htmlspecialchars($_SESSION['penonton']['username']) ?></b></span>
        <a class="btn" href="riwayat.php">Riwayat</a>
        <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>logout_user.php" style="background:#444;margin-left:8px">Logout</a>
      </div>
    </div>

    <?php if (!$jadwal): ?>
      <p>Belum ada jadwal tayang.</p>
    <?php else: ?>
      <div class="grid">
        <?php foreach ($jadwal as $j): 
          $src = poster_url($j['poster'] ?? '', $POSTER_DIR_URL, $PLACEHOLDER_URL);
        ?>
          <div class="card">
            <img class="poster" src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars($j['judul']) ?>">
            <div style="flex:1">
              <div class="title"><?= htmlspecialchars($j['judul']) ?></div>
              <div class="muted"><?= htmlspecialchars($j['nama_studio']) ?> · <?= htmlspecialchars($j['tanggal']) ?> · <?= htmlspecialchars(substr($j['jam'],0,5)) ?></div>
            </div>
            <a class="btn" href="pesan_tiket.php?jadwal_id=<?= urlencode($j['id']) ?>&film_id=<?= urlencode($j['film_id']) ?>">Pesan</a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
