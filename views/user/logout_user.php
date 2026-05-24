<?php
// views/user/logout_user.php
session_start();

/* bersihkan session */
$_SESSION = [];
if (ini_get('session.use_cookies')) {
  $p = session_get_cookie_params();
  setcookie(session_name(), '', time()-42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

/* base url project */
$BASE_URL      = '/bioskop-app/'; // GANTI jika nama foldermu berbeda
$loginPenonton = $BASE_URL . 'views/user/login_user.php';

/* redirect langsung */
header("Location: $loginPenonton");
exit;
