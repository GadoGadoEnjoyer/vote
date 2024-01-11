<?php
session_start();
class Post extends Controller{
    public function index($id = null){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->isLoggedin();
            $this->rateLimit();
            $option_id = $_POST['option'];
            $option = $this->model('Option_model');
            $record = $this->model('Record_model');
            $comment = $this->model('Comment_model');
            if($_POST['comment'] != null){
                if($comment->Create($_SESSION['user_id'], $id, $_POST['comment'])){
                    header('Location: '.BASEURL.'/Post/index/'.$id);
                    exit();
                }
                else{
                    echo("Failed to post comment");
                    exit();
                }
            }
            else{
                if($record->AddRecord($_SESSION['user_id'], $id)){
                    if($option->AddPoint($option_id)){
                        header('Location: '.BASEURL.'/Post/index/'.$id);
                        exit();
                    }
                }
                else{
                    header('Location: '.BASEURL.'/Post/index/'.$id);
                    exit();
                }
            }
            
        }
        else{
            if($id != null){
                $data['posts'] = $this->model('Post_model')->Read($id);
                $data['options'] = $this->model('Option_model')->Read($id);
                foreach($data['options'] as $option){
                    $data['img'][$option['id']] = $this->model('Image_model')->Display($option['id']);
                    if($data['img'][$option['id']] == null){
                        $data['img'][$option['id']]['image'] = 'default.jpg';
                    }
                }
                $data['comments'] = htmlspecialchars($this->model('Comment_model')->Read($id), ENT_QUOTES, 'UTF-8');

                //THANK YOU SO MUCH GPT FOR TELLING ME THAT ADDING & MAKE THE ARRAY EDITABLE INSTEAD OF WHATEVER IT WAS!!!! ALHAMDULILLAH
                foreach($data['comments'] as &$user){
                    $user['username'] = htmlspecialchars($this->model('User_model')->GetName($user['user_id']), ENT_QUOTES, 'UTF-8');
                }
            
                if($data['posts'] == null){
                    $this->view('404/index');
                    exit();
                }
                $record = $this->model('Record_model');
                if($record->CheckRecord($_SESSION['user_id'], $id)){
                    $data['voted'] = true;
                }
                else{
                    $data['voted'] = false;
                }
                return $this->view('Post/index', $data);
            }
            else{
                $this->view('404/index');
                exit();
            }
        }

    }
    
    public function create(){
        $this->isLoggedin();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->rateLimit();
            $title = $_POST['title'];
            $body = $_POST['body'];
            $option_names = $_POST['option_name'];
            $user_id = $_SESSION['user_id'];

            $post = $this->model('Post_model');
            $option = $this->model('Option_model');
            if($post_id = $post->create($user_id, $title, $body)){
                for($i = 1; $i <= count($option_names); $i++){
                    $option_id = $option->create($post_id, $option_names[$i],0);
                    if($_FILES['option_image']['name'][$i] != null){
                        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];
                        $maxFileSize = 5 * 1024 * 1024; // 5 MB
                        if($_FILES['option_image']['error'][$i] == 0 && in_array($_FILES['option_image']['type'][$i], $allowedMimeTypes) && $_FILES['option_image']['size'][$i] <= $maxFileSize){
                            $destinationDirectory = (dirname(__DIR__,2)) . "/public/assets";
                            $filename = uniqid() . '_' . $_FILES['option_image']['name'][$i];
                            $targetPath = $destinationDirectory . '/' . $filename;
                            if (move_uploaded_file($_FILES['option_image']['tmp_name'][$i], $targetPath)) {
                                if($this->model('Image_model')->Create($option_id,$filename)){
                                    echo 'Image uploaded successfully!';
                                }
                                else{
                                    echo 'Error uploading file to database.';
                                }
                            }
                            else{
                                echo 'Error uploading file.';
                            }
                        }
                    }   
                }
                header('Location: '.BASEURL.'/post/'.$post_id);
            }
            else{
                echo 'Error creating post.';
            }
        }
        else{
            return $this->view('Post/create');
        }
    }
}