<?php 
    class Cadastros extends Controller{
        public function __construct(){            
            $this->userModel = $this->model('Cadastro');
        }

        public function index(){           
            $this->view('cadastros/index');
        }

        public function add(){
            $this->view('cadastros/add');
        }

        public function edit(){            
            $this->view('cadastros/edit');
        }       
    }
?>