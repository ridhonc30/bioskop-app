<?php
class Pemesanan {
    public static function pesan($conn, $user_id, $jadwal_id, $kursi) {
        $stmt = $conn->prepare("INSERT INTO pemesanan (user_id, jadwal_tayang_id, nomor_kursi) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $jadwal_id, $kursi);
        return $stmt->execute();
    }

    public static function kursiTerpesan($conn, $jadwal_id) {
        $stmt = $conn->prepare("SELECT nomor_kursi FROM pemesanan WHERE jadwal_tayang_id = ?");
        $stmt->bind_param("i", $jadwal_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $kursi = [];
        while ($row = $result->fetch_assoc()) {
            $kursi[] = $row['nomor_kursi'];
        }
        return $kursi;
    }

    public static function riwayat($conn, $user_id) {
    $sql = "SELECT p.*, j.tanggal, j.jam, s.nama_studio AS nama_studio, f.judul 
        FROM pemesanan p 
        JOIN jadwal_tayang j ON p.jadwal_tayang_id = j.id
        JOIN studios s ON j.studio_id = s.id
        JOIN films f ON j.film_id = f.id
        WHERE p.user_id = ? 
        ORDER BY p.waktu_pesan DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

}
