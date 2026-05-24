<?php
abstract class User { 
    protected $username; 
    protected $password; 

    public function __construct($u, $p) {
        $this->username = $u; 
        $this->password = $p;
    }

    abstract public function login($conn); 
}
?>
