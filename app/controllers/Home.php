<?php
session_start();
class Home extends Controller{
    public function index(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $search = $_POST['search'];
            header('Location: '.BASEURL.'/Post/'.$search);
        }
        else{
            return $this->view('Home/index');
        }
    }
    public function register() {
        // TY GPT
        $message = "<h1>Your registration failed!</h1><h2>Possible reasons : </h2><ul><li>Username already taken</li><li>IP address already registered</li><li>You use Indihome and have a crappy internet speed (idk about this one)</li></ul>"; 
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->rateLimit();
            $name = $_POST['name'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $ip_address = $_POST['ip_address'];
            $user = $this->model('User_model');
    
            if ($user->Register($name, $password, $ip_address)) {
                header('Location: ' . BASEURL . '/Home/login');
                exit(); 
            } else {
                echo($message);
            }
        }
        return $this->view('Home/register', ['message' => $message]);
    }
    
    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->rateLimit();
            $name = $_POST['name'];
            $password = $_POST['password'];
            $user = $this->model('User_model');
            if($user->Login($name, $password)){
                $_SESSION['user_id'] = $user->getID($name);
                header('Location: '.BASEURL.'/Home/index');
                exit();
            }
            else{
                header('Location: '.BASEURL.'/Home/login');
                exit();
            };
        }
        else{
            return $this->view('Home/login');
        }
    }
    public function logout(){
        session_destroy();
        header('Location: '.BASEURL.'/Home/login');
        exit();
    }
}