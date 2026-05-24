<?php
class Aktivitas { 
    public static function catat($conn, $deskripsi) { 

        $stmt = $conn->prepare("INSERT INTO aktivitas_admin (deskripsi) VALUES (?)");
        
        $stmt->bind_param("s", $deskripsi); 
        $stmt->execute(); 
    }
}
