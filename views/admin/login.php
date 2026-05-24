<?php
session_start();
$errorMessage = '';
if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Admin - Bioskop Keren</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      /* Background gradien biru tua yang elegan */
      background: linear-gradient(135deg, #0A192F 0%, #172A45 100%); /* Deep Blue Sea / Midnight Blue */
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      color: #E0E7F9; /* Teks terang untuk kontras */
      overflow: hidden;
      position: relative;
    }

    /* Efek cahaya latar belakang yang halus, disesuaikan dengan biru tua */
    body::before {
      content: '';
      position: absolute;
      top: -50px;
      left: -50px;
      width: 300px;
      height: 300px;
      background: rgba(60, 90, 150, 0.1); /* Biru transparan */
      border-radius: 50%;
      filter: blur(100px);
      z-index: 0;
    }

    body::after {
      content: '';
      position: absolute;
      bottom: -70px;
      right: -70px;
      width: 350px;
      height: 350px;
      background: rgba(25, 40, 70, 0.2); /* Biru tua gelap transparan */
      border-radius: 50%;
      filter: blur(120px);
      z-index: 0;
    }

    /* Container login utama */
    .login-container {
      /* Background gelap transparan dengan efek blur (frosted glass) */
      background-color: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(15px);
      border-radius: 25px; /* Sudut lebih membulat */
      padding: 3rem 2.5rem; /* Padding lebih besar */
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.7); /* Shadow lebih dalam dan kuat */
      width: 100%;
      max-width: 450px; /* Lebar sedikit lebih besar dari sebelumnya */
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.15); /* Border tipis yang elegan */
      animation: fadeInScale 0.7s ease-out forwards;
      z-index: 1;
      position: relative;
      overflow: hidden; /* Pastikan konten tidak keluar dari border-radius */
    }

    /* Garis aksen di bagian atas container */
    .login-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(to right, #4A90E2, #1E3A8A); /* Biru cerah ke biru tua */
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
    }

    @keyframes fadeInScale {
      from {
        opacity: 0;
        transform: scale(0.9);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    /* Styling untuk judul H2 */
    .login-container h2 {
      font-size: 2.5rem; /* Ukuran font lebih besar */
      font-weight: 700;
      margin-bottom: 2.5rem;
      color: #90B8F8; /* Biru terang untuk judul */
      text-shadow: 0 3px 5px rgba(0, 0, 0, 0.4);
      letter-spacing: 0.02em;
    }

    /* Styling untuk label input */
    .login-container form label {
      display: block;
      text-align: left;
      margin-bottom: 0.6rem;
      font-weight: 500;
      color: #B0C4DE; /* Biru keabu-abuan */
      font-size: 1rem;
    }

    /* Styling untuk input text dan password */
    .login-container form input[type="text"],
    .login-container form input[type="password"] {
      width: calc(100% - 2.4rem); /* Sesuaikan padding */
      padding: 1rem 1.2rem; /* Padding lebih besar */
      margin-bottom: 1.8rem;
      border: 1px solid rgba(74, 144, 226, 0.4); /* Border biru transparan */
      border-radius: 10px; /* Sudut lebih membulat */
      background-color: rgba(255, 255, 255, 0.1); /* Background input transparan */
      color: #ffffff; /* Teks putih */
      font-size: 1.05rem;
      transition: all 0.3s ease;
      outline: none;
      box-shadow: inset 0 1px 3px rgba(0,0,0,0.2); /* Inner shadow */
    }

    /* Styling saat input di-fokus */
    .login-container form input[type="text"]:focus,
    .login-container form input[type="password"]:focus {
      border-color: #4A90E2; /* Biru cerah saat fokus */
      box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.5), inset 0 1px 3px rgba(0,0,0,0.3); /* Focus ring lebih menonjol */
      background-color: rgba(255, 255, 255, 0.15);
    }

    /* Styling untuk placeholder */
    .login-container form input::placeholder {
        color: #A3B8E0; /* Warna placeholder biru muda */
        opacity: 0.8;
    }

    /* Styling untuk tombol submit */
    .login-container form button[type="submit"] {
      width: 95%;
      padding: 1.1rem; /* Padding tombol lebih besar */
      /* Gradien biru tua yang solid dan kuat */
      background: linear-gradient(to right, #4A90E2, #1E3A8A);
      color: white;
      border: none;
      border-radius: 12px; /* Sudut lebih membulat */
      font-size: 1.25rem; /* Ukuran font tombol lebih besar */
      font-weight: 700; /* Lebih tebal */
      cursor: pointer;
      transition: all 0.3s ease;
      letter-spacing: 0.08em; /* Spasi antar huruf lebih lebar */
      text-transform: uppercase;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5); /* Shadow tombol lebih kuat */
    }

    /* Styling saat tombol di-hover */
    .login-container form button[type="submit"]:hover {
      background: linear-gradient(to right, #1E3A8A, #0A192F); /* Gradien lebih gelap saat hover */
      transform: translateY(-5px); /* Efek naik lebih tinggi */
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.7); /* Shadow lebih dalam saat hover */
    }

    /* Styling untuk pesan error */
    .error-message {
      color: #FFC4C4; /* Merah terang untuk error */
      margin-top: 1.8rem;
      font-size: 1rem;
      background-color: rgba(239, 68, 68, 0.2); /* Background merah transparan */
      border: 1px solid #EF4444; /* Border merah */
      padding: 1rem; /* Padding lebih besar */
      border-radius: 10px;
      animation: shake 0.5s;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-8px); }
      40%, 80% { transform: translateX(8px); }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>
      <svg class="w-10 h-10 mr-3 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M12 11.5c.83 0 1.5-.67 1.5-1.5S12.83 8.5 12 8.5 10.5 9.17 10.5 10s.67 1.5 1.5 1.5zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" clip-rule="evenodd"></path>
      </svg>
      Admin Login
    </h2>
    <form action="../../controllers/AuthController.php" method="POST">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" placeholder="Masukkan username admin" required autofocus>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Masukkan password admin" required>

      <button type="submit" name="login_admin">Masuk</button>

      <?php if (!empty($errorMessage)): ?>
        <p class="error-message"><?= htmlspecialchars($errorMessage) ?></p>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>