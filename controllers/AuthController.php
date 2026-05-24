<?php
session_start(); 
require_once '../db/koneksi.php'; 
require_once '../models/Admin.php'; 
require_once '../models/Penonton.php'; 

if (isset($_POST['login_admin'])) { 
    $admin = new Admin($_POST['username'], $_POST['password']); 
    $data = $admin->login($conn); 

    if ($data) {
        $_SESSION['admin'] = $data; 
        header("Location: ../views/admin/dashboard.php"); //redirect ke dashboard admin
        exit;
    } else {
        header("Location: ../views/admin/login.php?error=Username atau password salah");
        exit;
    }
}
?>
