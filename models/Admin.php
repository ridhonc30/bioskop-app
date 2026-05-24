<?php
require_once 'User.php'; 

class Admin extends User { 
    public function login($conn) { 

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=? AND role='admin'"); 
        $stmt->bind_param("ss", $this->username, $this->password); 

        $stmt->execute(); 
        return $stmt->get_result()->fetch_assoc(); 
    }
}
?>
