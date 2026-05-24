<?php
require_once '../db/koneksi.php'; 
require_once '../models/Studio.php'; 

if (isset($_POST['simpan'])) { 
    $studio = new Studio($_POST['nama_studio'], $_POST['jumlah_kursi'], $_POST['status']); 

    $studio->simpan($conn); 
    header("Location: ../views/admin/kelola_studio.php"); //redirect
    exit;
}

if (isset($_GET['hapus'])) { 
    Studio::hapus($conn, $_GET['hapus']); 
    header("Location: ../views/admin/kelola_studio.php"); //redirect
    exit;
}
?>
