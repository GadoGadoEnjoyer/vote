<?php
session_start();
class Whoopsie extends Controller{
    public function index(){
        $this->view('404/index');
    }
}