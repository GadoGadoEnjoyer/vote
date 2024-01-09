<?php 
require_once dirname(__DIR__).'/core/Controller.php';
require_once dirname(__DIR__).'/core/Database.php';
require_once dirname(__DIR__).'/core/Constants.php';



class Migration{
    private $db;
    public function __construct(){
        print_r("Migration constructor called\n");
        $this->db = new Database;
        try{
            if(!$this->tableExist('Users')){
                $this->db->query('CREATE TABLE Users (
                    `id` INT PRIMARY KEY AUTO_INCREMENT,
                    `name` VARCHAR(50) UNIQUE,
                    `password` VARCHAR(255),
                    `ip_address` VARCHAR(15) UNIQUE,
                    `email` VARCHAR(50) UNIQUE NULL
                )');
                $this->db->execute();   
                print_r("User table created\n");
            } 
            
            if(!$this->tableExist('Posts')){
                if($this->tableExist('Users')){
                    $this->db->query('CREATE TABLE Posts (
                        `id` INT PRIMARY KEY AUTO_INCREMENT,
                        `user_id` INT,
                        `title` VARCHAR(255),
                        `body` TEXT NULL,
                        FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
                    )');
                    $this->db->execute();
                    print_r("Posts table created\n"); 
                }
            }

            if(!$this->tableExist('Options')){
                if($this->tableExist('Posts')){
                    $this->db->query('CREATE TABLE Options (
                        `id` INT PRIMARY KEY AUTO_INCREMENT,
                        `post_id` INT,
                        `option_name` VARCHAR(255),
                        `value` INT DEFAULT 0,
                        FOREIGN KEY (post_id) REFERENCES Posts(id) ON DELETE CASCADE
                    )');
                    $this->db->execute();
                    print_r("Options table created\n"); 
                }
            }

            if(!$this->tableExist('Record')){
                if($this->tableExist('Users') && $this->tableExist('Posts')){
                    $this->db->query('CREATE TABLE Record (
                        `id` INT PRIMARY KEY AUTO_INCREMENT,
                        `user_id` INT,
                        `post_id` INT,
                        FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
                        FOREIGN KEY (post_id) REFERENCES Posts(id) ON DELETE CASCADE,
                        UNIQUE KEY `unique_key`(`user_id`, `post_id`)
                    )');
                    $this->db->execute();
                    print_r("Record table created\n"); 
                }
            }

            if(!$this->tableExist('Images')){
                if($this->tableExist('Posts')){
                    $this->db->query('CREATE TABLE Images (
                        `id` INT PRIMARY KEY AUTO_INCREMENT,
                        `option_id` INT,
                        `image` VARCHAR(255),
                        FOREIGN KEY (option_id) REFERENCES Options(id) ON DELETE CASCADE
                    )');
                    $this->db->execute();
                    print_r("Images table created\n"); 
                }
            }

            if(!$this->tableExist('Comments')){
                if($this->tableExist('Users') && $this->tableExist('Posts')){
                    $this->db->query('CREATE TABLE Comments (
                        `id` INT PRIMARY KEY AUTO_INCREMENT,
                        `user_id` INT,
                        `post_id` INT,
                        `comment` TEXT,
                        FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
                        FOREIGN KEY (post_id) REFERENCES Posts(id) ON DELETE CASCADE
                    )');
                    $this->db->execute();
                    print_r("Comments table created\n"); 
                }
            }
        }catch(PDOException $e){
            print_r($e);
        }
    }

    public function tableExist($table){
        $this->db->query('SHOW TABLES LIKE :table');
        $this->db->bind(':table', $table);
        if($this->db->rowcount() > 0){
            return true;
        }else{
            return false;
        }
    }
    
}

$migration = new Migration();