<?php 

class Image_model{
    private $table = 'Images';
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function Create($option_id, $image_name){
        try {
            $this->db->query('INSERT INTO ' . $this->table . ' (option_id, image) VALUES (:option_id, :image_name)');
        
            // Bind parameters with their values
            $this->db->bind('option_id', $option_id);
            $this->db->bind('image_name', $image_name);

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

    public function Display($option_id){
        try {
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE option_id = :option_id');
        
            // Bind parameters with their values
            $this->db->bind('option_id', $option_id);

            $results = $this->db->resultSingle();
            return $results;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
?>