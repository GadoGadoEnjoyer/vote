<?php 

class Post_Model{
    private $table = 'Posts';
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function Create($user_id, $title, $body){
        try {
            $this->db->query('INSERT INTO ' . $this->table . ' (user_id, title, body) VALUES (:user_id, :title, :body)');
        
            // Bind parameters with their values
            $this->db->bind('user_id', $user_id);
            $this->db->bind('title', $title);
            $this->db->bind('body', $body);

            if(!$this->db->execute()){
                //IDK WHY ITS LIKE THIS DONT ASK

                $post_id = $this->db->getlastid();
                return $post_id;
            }
            else{
                return false;
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function Read($id){
        try {
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
            $this->db->bind('id', $id);
            $this->db->execute();
            $result = $this->db->resultSingle();
            return $result;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    public function ReadAll(){
        try {
            $this->db->query('SELECT * FROM ' . $this->table);
            $this->db->execute();
            $result = $this->db->resultSet();
            return $result;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}

?>