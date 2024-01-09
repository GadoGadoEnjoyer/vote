<?php 

class Record_Model{
    private $table = 'Record';
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function AddRecord($user_id, $post_id){
        try {
            $this->db->query('INSERT INTO ' . $this->table . ' (user_id, post_id) VALUES (:user_id, :post_id)');
        
            // Bind parameters with their values
            $this->db->bind('user_id', $user_id);
            $this->db->bind('post_id', $post_id);

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

    public function CheckRecord($user_id, $post_id){
        try {
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE user_id = :user_id AND post_id = :post_id');
            $this->db->bind('user_id', $user_id);
            $this->db->bind('post_id', $post_id);
            $this->db->execute();
            $result = $this->db->resultSingle();
            if($result){
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
}
?>