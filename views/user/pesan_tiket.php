<?php
session_start();
if (!isset($_SESSION['penonton'])) { header("Location: login_user.php"); exit; }

require_once '../../db/koneksi.php';
require_once '../../models/Pemesanan.php';

$user_id   = $_SESSION['penonton']['id'];
$jadwal_id = (int)($_GET['jadwal_id'] ?? 0);
$film_id   = (int)($_GET['film_id'] ?? 0);

if ($jadwal_id <= 0) { header("Location: jadwal.php"); exit; }

// ambil info jadwal + film + studio
$sql = "SELECT j.*, f.judul, f.poster, s.nama_studio, s.jumlah_kursi
        FROM jadwal_tayang j
        JOIN films f   ON j.film_id   = f.id
        JOIN studios s ON j.studio_id = s.id
        WHERE j.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jadwal_id);
$stmt->execute();
$info = $stmt->get_result()->fetch_assoc();
if (!$info) { header("Location: jadwal.php"); exit; }

/* ============================
   URL POSTER (FIX PATH)
   ============================ */
$BASE_URL        = '/bioskop-app/';                // GANTI jika folder proyekmu beda
$POSTER_DIR_URL  = $BASE_URL . 'uploads/poster/';
$PLACEHOLDER_URL = $POSTER_DIR_URL . 'no-poster.png';

$poster = trim((string)($info['poster'] ?? ''));
if ($poster === '') {
  $poster_url = $PLACEHOLDER_URL;
} elseif (preg_match('~^https?://~i', $poster)) {
  $poster_url = $poster;                           // kalau sudah URL penuh
} else {
  $poster_url = $POSTER_DIR_URL . rawurlencode(basename($poster)); // nama file saja
}

// seats terpesan
$stmt2 = $conn->prepare("SELECT nomor_kursi FROM pemesanan WHERE jadwal_tayang_id = ?");
$stmt2->bind_param("i", $jadwal_id);
$stmt2->execute();
$res2 = $stmt2->get_result();
$booked = [];
while ($r = $res2->fetch_assoc()) $booked[$r['nomor_kursi']] = true;

// generate grid kursi (baris A-J, kolom 1-12) dibatasi jumlah_kursi studio
$rows = range('A','J');
$cols = range(1,12);
$max  = (int)$info['jumlah_kursi'];
$allSeats = [];
$count=0;
foreach ($rows as $r) {
  foreach ($cols as $c) {
    $seat = $r.$c;
    $count++;
    if ($count > $max) break 2;
    $allSeats[] = $seat;
  }
}

// handle submit
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seat = $_POST['seat'] ?? '';
    if (!$seat) {
        $msg = "Silakan pilih kursi.";
    } else {
        $ins = $conn->prepare("INSERT INTO pemesanan (user_id, jadwal_tayang_id, nomor_kursi) VALUES (?,?,?)");
        $ins->bind_param("iis", $user_id, $jadwal_id, $seat);
        if ($ins->execute()) {
            header("Location: konfirmasi.php?id=".$conn->insert_id);
            exit;
        } else {
            $msg = "Kursi sudah dipesan orang lain. Pilih kursi lain.";
            $booked[$seat] = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pilih Kursi — <?= htmlspecialchars($info['judul']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--bg:#0f0f0f;--panel:#151515;--card:#1c1c1c;--text:#e8e8e8;--muted:#aaa;--accent:#e50914}
    body{margin:0;background:var(--bg);color:var(--text);font-family:Arial,Helvetica,sans-serif}
    .container{max-width:1100px;margin:0 auto;padding:24px}
    .top{display:flex;gap:16px;align-items:center;margin-bottom:16px}
    .poster{width:72px;height:108px;background:#222;border-radius:8px;object-fit:cover}
    .muted{color:var(--muted)}
    .grid{display:grid;grid-template-columns:repeat(12,1fr);gap:8px;background:#121212;padding:16px;border:1px solid #2c2c2c;border-radius:16px}
    .seat{display:flex;align-items:center;justify-content:center;padding:12px;border-radius:8px;background:#2a2a2a;border:1px solid #3a3a3a;cursor:pointer}
    .seat:hover{outline:2px solid #444}
    .seat.sel{background:var(--accent);color:#fff;border-color:#b2070f}
    .seat.off{background:#3b3b3b;color:#777;border-color:#444;cursor:not-allowed}
    .actions{margin-top:16px;display:flex;gap:10px}
    .btn{background:var(--accent);color:#fff;border:0;padding:10px 14px;border-radius:10px;text-decoration:none;font-weight:700;cursor:pointer}
    .err{margin-top:10px;color:#ff7373}
    .legend{margin-top:8px;color:#bbb;font-size:13px}
    input[type="radio"]{display:none}
    label{user-select:none}
  </style>
</head>
<body>
  <div class="container">
    <a href="jadwal.php" class="btn" style="background:#444">← Kembali</a>
    <div class="top" style="margin-top:12px">
      <img class="poster" src="<?= htmlspecialchars($poster_url) ?>" alt="<?= htmlspecialchars($info['judul']) ?>">
      <div>
        <h2 style="margin:0"><?= htmlspecialchars($info['judul']) ?></h2>
        <div class="muted"><?= htmlspecialchars($info['nama_studio']) ?> · <?= htmlspecialchars($info['tanggal']) ?> · <?= htmlspecialchars(substr($info['jam'],0,5)) ?></div>
        <div class="legend">Kapasitas studio: <?= (int)$info['jumlah_kursi'] ?> kursi</div>
      </div>
    </div>

    <form method="POST">
      <div class="grid">
        <?php foreach ($allSeats as $s): $taken = isset($booked[$s]); ?>
          <label class="seat <?= $taken ? 'off':'' ?>">
            <input type="radio" name="seat" value="<?= $s ?>" <?= $taken ? 'disabled' : '' ?>
                   onchange="this.closest('.grid').querySelectorAll('.seat').forEach(el=>el.classList.remove('sel')); this.closest('.seat').classList.add('sel');">
            <?= $s ?>
          </label>
        <?php endforeach; ?>
      </div>
      <div class="actions">
        <button class="btn" type="submit">Pesan Tiket</button>
      </div>
      <?php if ($msg): ?><div class="err"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    </form>
  </div>
</body>
</html>
