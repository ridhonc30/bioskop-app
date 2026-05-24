<?php
class Studio {
    private $nama_studio;
    private $jumlah_kursi;
    private $status;

    public function __construct($nama_studio, $jumlah_kursi, $status) {
        $this->nama_studio = $nama_studio;
        $this->jumlah_kursi = $jumlah_kursi;
        $this->status = $status;
    }

    public function simpan($conn) {
        $stmt = $conn->prepare("INSERT INTO studios (nama_studio, jumlah_kursi, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $this->nama_studio, $this->jumlah_kursi, $this->status);
        return $stmt->execute();
    }

    public static function semuaAktif($conn) {
        $sql = "SELECT * FROM studios WHERE status = 'Aktif'";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function semua($conn) {
        $result = $conn->query("SELECT * FROM studios");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function hapus($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM studios WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function findById($conn, $id) {
        $stmt = $conn->prepare("SELECT * FROM studios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // hasilnya dalam bentuk array asosiatif
    }
}
?>
