<?php
session_start();
require_once '../../db/koneksi.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 'penonton'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    // plaintext sesuai skema kamu sekarang
    if ($user && $password === $user['password']) {
        $_SESSION['penonton'] = $user;
        header("Location: jadwal.php");
        exit;
    } else {
        $error = "Username atau password salah";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Penonton</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--bg:#0f0f0f;--panel:#1a1a1a;--muted:#2a2a2a;--text:#e8e8e8;--accent:#e50914}
    *{box-sizing:border-box} body{margin:0;background:var(--bg);color:var(--text);font-family:Arial,Helvetica,sans-serif}
    .wrap{min-height:100vh;display:grid;place-items:center;padding:24px}
    .card{background:var(--panel);border:1px solid #2c2c2c;border-radius:16px;padding:28px;max-width:420px;width:100%;box-shadow:0 8px 24px rgba(0,0,0,.4)}
    h1{margin:0 0 16px} label{display:block;margin:14px 0 6px}
    input{width:100%;background:#181818;border:1px solid #333;border-radius:10px;color:var(--text);padding:12px}
    .btn{width:100%;margin-top:18px;background:var(--accent);border:0;color:#fff;padding:12px;border-radius:10px;font-weight:700;cursor:pointer}
    .err{margin-top:10px;color:#ff7373}
    .link{display:block;text-align:center;margin-top:12px;color:#9f9f9f;text-decoration:none}
  </style>
</head>
<body>
  <div class="wrap">
    <form method="POST" class="card">
      <h1>Login Penonton</h1>
      <label>Username</label>
      <input type="text" name="username" required autofocus>
      <label>Password</label>
      <input type="password" name="password" required>
      <button class="btn" type="submit">Masuk</button>
      <?php if ($error): ?><div class="err"><?= htmlspecialchars($error) ?></div><?php endif; ?>
      <a href="../admin/login.php" class="link">Login Admin</a>
    </form>
  </div>
</body>
</html>
