<?php
class JadwalTayang {
    private $film_id;
    private $studio_id;
    private $tanggal;
    private $jam;

    public function __construct($film_id, $studio_id, $tanggal, $jam) {
        $this->film_id = $film_id;
        $this->studio_id = $studio_id;
        $this->tanggal = $tanggal;
        $this->jam = $jam;
    }

    public function simpan($conn) {
        $stmt = $conn->prepare("INSERT INTO jadwal_tayang (film_id, studio_id, tanggal, jam) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $this->film_id, $this->studio_id, $this->tanggal, $this->jam);
        return $stmt->execute();
    }

    public static function semua($conn) {
        $query = "SELECT jt.id, f.judul, s.nama_studio, jt.tanggal, jt.jam
                  FROM jadwal_tayang jt
                  JOIN films f ON jt.film_id = f.id
                  JOIN studios s ON jt.studio_id = s.id";
        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function hapus($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM jadwal_tayang WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function semuaLengkap($conn) {
    $query = "
        SELECT 
            jt.id AS id_jadwal_tayang,
            jt.film_id AS id_film,
            jt.tanggal,
            jt.jam,
            f.judul,
            f.genre,
            f.durasi,
            f.poster,
            s.nama_studio
        FROM jadwal_tayang jt
        JOIN films f ON jt.film_id = f.id
        JOIN studios s ON jt.studio_id = s.id
        ORDER BY jt.tanggal ASC, jt.jam ASC
    ";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function findWithFilm($conn, $id) {
    $sql = "SELECT j.*, f.judul, f.poster, f.genre, f.durasi, s.nama_studio
            FROM jadwal_tayang j
            JOIN films f ON j.film_id = f.id
            JOIN studios s ON j.studio_id = s.id
            WHERE j.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

}
?>
