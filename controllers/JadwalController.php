<?php
require_once '../db/koneksi.php'; 
require_once '../models/JadwalTayang.php'; 

if (isset($_POST['simpan'])) { 
    $jadwal = new JadwalTayang($_POST['film_id'], $_POST['studio_id'], $_POST['tanggal'], $_POST['jam']); 
    $jadwal->simpan($conn); 
    header("Location: ../views/admin/kelola_jadwal.php"); //redirect
    exit;
}

if (isset($_GET['hapus'])) { 
    JadwalTayang::hapus($conn, $_GET['hapus']);
    header("Location: ../views/admin/kelola_jadwal.php"); //redirect
    exit;
}
?>
