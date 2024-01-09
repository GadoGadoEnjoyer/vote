<?php 

class Comment_Model{
    private $table = 'Comments';
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function Create($user_id, $post_id, $comment){
        try {
            $this->db->query('INSERT INTO ' . $this->table . ' (user_id, post_id, comment) VALUES (:user_id, :post_id, :comment)');
        
            // Bind parameters with their values
            $this->db->bind('user_id', $user_id);
            $this->db->bind('post_id', $post_id);
            $this->db->bind('comment', $comment);

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
}

?>