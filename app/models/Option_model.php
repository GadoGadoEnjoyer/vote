<?php 

class Option_Model{
    private $table = 'Options';
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function Create($post_id, $option_name, $value){
        try {
            $this->db->query('INSERT INTO ' . $this->table . ' (post_id, option_name, value) VALUES (:post_id, :option_name, :value)');
            
            // Bind parameters with their values
            $this->db->bind('post_id', $post_id);
            $this->db->bind('option_name', $option_name);
            $this->db->bind('value', $value);

            if(!$this->db->execute()){
                //IDK WHY ITS LIKE THIS DONT ASK
                $option_id = $this->db->getlastid();
                return $option_id;
            }
            else{
                return false;
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function Read($post_id){
        try {
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE post_id = :post_id');
            $this->db->bind('post_id', $post_id);
            $this->db->execute();
            $result = $this->db->resultSet();
            return $result;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    public function AddPoint($id){
        try {
            $this->db->query('UPDATE ' . $this->table . ' SET value = value + 1 WHERE id = :id');
            $this->db->bind('id', $id);
            $this->db->execute();
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}

?>