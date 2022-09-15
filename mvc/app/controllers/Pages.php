<?php

class Pages extends Controller{
    public function __construct(){
        //vai procurar na pasta model um arquivo chamado User.php e incluir
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }
    
    public function index(){         

       // Get posts
       $tag01 = $this->postModel->getPostsByTag('01');
       $tag02 = $this->postModel->getPostsByTag('02');
       $tag03 = $this->postModel->getPostsByTag('03');
       $tag04 = $this->postModel->getPostsByTag('04');

       $data = array (
        "tag01"=>$tag01,
        "tag02"=>$tag02,
        "tag03"=>$tag03,
        "tag04"=>$tag04,
        "title"=>"Home"
       );

      
            
        
/*
        $data = [
           'title' => 'Home',
           'description' => 'Uma Simples Rede Social construida em MVC'
       ];  
       */
       $this->view('pages/index' ,$data);
    }
   
    public function about(){
        $data = [
            'title' => 'Sobre Nós',
            'description' => 'App para compartilhar posts com outros usuários'
        ];            
        
        $this->view('pages/about', $data);
    }
 
    public function javascript(){     
        $this->view('pages/javascript');
    } 
    
}