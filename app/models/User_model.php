<?php 

class User_Model{
    private $table = 'Users';
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function Register($name, $password, $ip_address){
        try {
            $this->db->query('INSERT INTO ' . $this->table . ' (name, password, ip_address) VALUES (:name, :password, :ip_address)');
        
            // Bind parameters with their values
            $this->db->bind('name', $name);
            $this->db->bind('password', $password);
            $this->db->bind('ip_address', $ip_address);

            if(!$this->db->execute()){
                //IDK WHY ITS LIKE THIS DONT ASK
                return true;
            }
            else{
                return false;
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function Login($name, $password){
        try {
            $this->db->query('SELECT `password` FROM ' . $this->table . ' WHERE name = :name');
            $this->db->bind('name', $name);
            $this->db->execute();
            $result = $this->db->resultSingle();
            if(password_verify($password,$result['password'])){
                return true;
            }
            else{
                return false;
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function GetID($name){
        try {
            $this->db->query('SELECT `id` FROM ' . $this->table . ' WHERE name = :name');
            $this->db->bind('name', $name);
            $this->db->execute();
            $result = $this->db->resultSingle();
            return $result['id'];
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function GetName($id){
        try {
            $this->db->query('SELECT `name` FROM ' . $this->table . ' WHERE id = :id');
            $this->db->bind('id', $id);
            $this->db->execute();
            $result = $this->db->resultSingle();
            return $result['name'];
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}

?>