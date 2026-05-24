<?php
class Film { 
    private $id; 
    private $judul; 
    private $genre; 
    private $durasi; 
    private $poster; 

    public function __construct($judul, $genre, $durasi, $poster = null) {
        $this->judul = $judul;
        $this->genre = $genre;
        $this->durasi = $durasi;
        $this->poster = $poster;
    }
    

    public function simpan($conn) {
        $stmt = $conn->prepare("INSERT INTO films (judul, genre, durasi, poster) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $this->judul, $this->genre, $this->durasi, $this->poster);
        return $stmt->execute();
    }
    

    public static function semua($conn) {
        $result = $conn->query("SELECT * FROM films");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public static function hapus($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM films WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
