<?php
class Database {
    //Variables
    private $hostname;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function connect(){
        //variable initialization
        $this->hostname = 'localhost';
        $this->dbname = 'performance_sheet';
        $this->username = 'root';
        $this->password = '';

        $this->conn = new mysqli($this->hostname,$this->username,$this->password,$this->dbname);
        if ($this->conn->connect_errno) {
            print_r($this->conn->connect_errno);
            exit;
        } else {
            return $this->conn;
        }
    }

    public function connect_pdo(){
        //variable initialization
        $this->hostname = 'localhost';
        $this->dbname = 'performance_sheet';
        $this->username = 'root';
        $this->password = '';

        try {
            $this->conn = new PDO("mysql:host=$this->hostname;dbname=$this->dbname",$this->username,$this->password);
            return $this->conn;
        } catch (PDOException $e){
            print_r($e->getMessage());
            exit;
        }
    }


}
?>