<?php
require_once '../db/koneksi.php'; 
require_once '../models/Film.php'; 

if (isset($_POST['simpan'])) { 
    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $durasi = $_POST['durasi']; 

    $film = new Film($judul, $genre, $durasi); 
    $film->simpan($conn); 
    header("Location: ../views/admin/kelola_film.php"); 
    exit;
}

if (isset($_GET['hapus'])) { 
    Film::hapus($conn, $_GET['hapus']); 
    header("Location: ../views/admin/kelola_film.php"); 
    exit;
}
?>
