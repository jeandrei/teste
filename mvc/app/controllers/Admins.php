<?php 
    class Admins extends Controller{
        
      public function __construct(){            
            $this->adminModel = $this->model('Admin');
        }

        /* 
        APENAS PARA FAZER O REDIRECIONAMENTO PARA QUANDO O USUÁRIO
        QUISER ACESSAR O ADMIN PODER DIGITAR NA URL /admins
        */

        public function index(){  

          if(!isLoggedIn()){               
            redirect('users/login');
          }          
        
          if(isLoggedIn()){
              redirect('posts');
          } 
         
      } 

        
    }

   
?>