<?php 

class Controller{
    
    public function view($view,$data = []){
        require_once dirname(__DIR__,1).'/views/'.$view.'.php';
    }

    public function model($model){
        require_once dirname(__DIR__,1).'/models/'.$model.'.php';
        return new $model;
    }

    public function isLoggedin(){
        if(isset($_SESSION['user_id'])){
            return true;
        }
        else{
            header('Location: '.BASEURL.'/Home/login');
            exit();
        }
    }
    public function rateLimit(){
        //Ty GPT
        if(isset($_SESSION['last_request'])){
            $last_request = $_SESSION['last_request'];
            $current_time = time();
            $time_diff = $current_time - $last_request;
            if($time_diff < RATELIMITIME){
                $this->view('404/ratelimit');
                exit();
            }
            else{
                $_SESSION['last_request'] = $current_time;

            }
        }
        else{
            $_SESSION['last_request'] = time();
        }
    }   
}