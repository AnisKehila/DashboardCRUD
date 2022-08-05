<?php
session_start();
class Database {
    private $dsn = "mysql:host=localhost;dbname=etudiants";
    private $user = "root";
    private $pass = "";
    public $conn;
    public function __construct()
    {
        try {
            $this->conn= new PDO($this->dsn,$this->user,$this->pass);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function userid() {
        $sql = "SELECT id FROM connexion WHERE user=:user";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user'=>$_SESSION['user']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result) {
            $userid = $result['id'];
            return $userid;
        }
    }
    public function register($username ,$pwd) {
        $sql = "INSERT INTO connexion (user,password) VALUES (:username,:pwd)";
        $stmt = $this->conn->prepare($sql);
        $reg = $stmt->execute(['username' => $username , 'pwd'=>$pwd]);
        if($reg){
            return true;
        } else {
            return false;
        }
    }
    public function login($username,$pwd) {
        $sql = "SELECT * FROM connexion WHERE user=:user AND password = :pwd";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user'=>$username,
                        'pwd' => $pwd ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        if($count > 0) {
            return true ;
        } else {
            return false;
        }    
    }
    public function insert($fname , $lname,$email) {
        $id_user = $this->userid();
        $sql = "INSERT INTO etudiants (nom,prenom,email,id_user) 
        VALUES (:lname,:fname,:email,:id_user)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fname' => $fname , 'lname'=>$lname , 'email'=>$email , 'id_user' => $id_user]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function read() {
        $id_user = $this->userid();
        $data = array();
        $sql = "SELECT * FROM etudiants WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id_user' => $id_user]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getStudentsById($id) {
        $sql = "SELECT * FROM etudiants WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function update($id,$fname,$lname,$email) {
        $sql = "UPDATE etudiants SET nom = :lname , prenom = :fname , email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['lname'=>$lname, 'fname'=>$fname , 'email'=>$email , 'id' => $id]);
        return true;
    }
    public function delete($id) {
        $sql = "DELETE FROM etudiants WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id'=>$id]);
        return true;
    }
    public function totalRowCount() {
        $sql = "SELECT * FROM etudiants";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $t_rows = $stmt->rowCount();
        return $t_rows;
    }
}


