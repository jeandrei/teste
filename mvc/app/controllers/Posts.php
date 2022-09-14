<?php 

    class Posts extends Controller {

        
        public function __construct(){
                       
            if(!isLoggedIn()){               
                redirect('users/login');
            }
           
            $this->postModel = $this->model('Post');           
            $this->userModel = $this->model('User');
        }

        public function index(){
           
            // Get posts
            $posts = $this->postModel->getPosts();
            
            
            foreach($posts as $post){
                $data[] = [
                    'id' => $post->post_id,
                    'user_id' => $post->user_id,
                    'title' => $post->title,
                    'body'=> $post->body,
                    'created_at' => $post->postCreated,
                    'image' => $this->postModel->getFirstFilePost($post->post_id),
                    'n_image' => $this->postModel->getNumImagesPost($post->post_id),                    
                    'name'=> $this->userModel->getUserById($post->user_id)
                ];
            }  
                   
            
            $this->view('posts/index', $data);
        }

        
       

        public function add(){ 
                      

            if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'title' => html($_POST['title']),
                    'body' => html($_POST['body']),
                    'user_id' => $_SESSION[SE.'user_id'],

                    'pessoaNascimento' => html($_POST['pessoaNascimento']),

                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate title validate está em helpers functions                            
                $data['title_err'] = validate($data['title'],['required']);               

                // Validate body
                $data['body_err'] = validate($data['body'],['required']);
              
                
                // Make sure no errors
                if(empty($data['title_err']) && empty($data['body_err']) && empty($data['teste_err'])){
                    try {
                        if($lastId = $this->postModel->addPost($data)){
                            $data['lastId'] = $lastId;     
                            flash('message', 'Post Adicionado');
                            $this->view('posts/add', $data);
                        } else {
                            throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
                        }
                    } catch (Exception $e) {
                        $erro = 'Erro: '.  $e->getMessage(). "\n";
                        flash('message', $erro,'alert alert-danger');
                        $this->view('posts/add');
                    }     
                 } else {
                     // Load view with errors
                     $this->view('posts/add', $data);
                 }
     
             } else {
 
             $data = [
                 'title' => '',
                 'boddy' => ''
             ];
 
             $this->view('posts/add', $data);
             }
 
         }



         //carrega o formulário para adicionar arquivos
        public function addfile($id_post){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){  
               

                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'id' => $id_post,
                    'title' => html($_POST['title']),
                    'body' => html($_POST['body']),                    
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate title
                $data['title_err'] = validate($data['title'],['required','isempty']);               

                // Validate body
                $data['body_err'] = validate($data['body'],['required','isempty']);


               /**
                * Faz o upload do arquivo do input id=file_post 
                * Utilizando a função upload_file que está no arquivo helpers/functions
                * Se tiver erro vai retornar o erro em $file['error'];
                */
                $file = $this->postModel->upload('file_post');                

                //se não tiver nenhum erro definimos os parâmetros do arquivo para inserir no bd
                if(empty($file['error'])){
                    $data['file_post_data'] = $file['data'];
                    $data['file_post_name'] = $file['nome'];
                    $data['file_post_type'] = $file['tipo'];
                    $data['file_post_err'] = '';
                //caso contrário retornamos o erro
                } else {
                    $data['file_post_err'] = $file['error'];
                }               
                                
                // Make sure no errors
                if(empty($data['title_err']) && empty($data['body_err']) && empty($data['file_post_err'])){
                    if(isset($data['id'])){                  
                        try{
                            if($this->postModel->addFilesPost($data['id'],$data)){
                                flash('message', 'Arquivo Adicionado com Sucesso!');
                                $data = [
                                    'id' => $id_post,
                                    'title' => '',
                                    'boddy' => ''
                                ];
                                $this->view("posts/addfile",$data);                                
                            } else {
                                throw new Exception('Ops! Algo deu errado ao tentar adicionar o arquivo!');
                            }
                        } catch (Exception $e) {
                            $erro = 'Erro: '.  $e->getMessage(). "\n";
                            flash('message', $erro,'alert alert-danger');
                            $this->view("posts/addfile",$data);
                        }
                    }                   
                } else {
                    // Load view with errors
                    $this->view("posts/addfile",$data);
                }
    
            } else {

            $data = [
                'id' => $id_post,
                'title' => '',
                'boddy' => ''
            ];
                $this->view('posts/addfile', $data);
            }
            
        }


        

        //deleta um arquivo de um post
        public function delfile($id){
            $owner = $this->postModel->getOwnerFile($id);
            $post_id = $this->postModel->getIdPostFile($id);
            
            //se não pertencer ao dono do post redireciono para o início
            if($owner != $_SESSION[SE.'user_id']){
                redirect('posts');
            } 

            try {
                if($idpost = $this->postModel->deleteFile($id)){
                    flash('message', 'Arquivo excluido com Sucesso!');
                    redirect('posts/edit/'.$post_id);
                } else {
                    throw new Exception('Ops! Algo deu errado ao tentar excluir o arquivo!');  
                }
            } catch (Exception $e) {
                $erro = 'Erro: '.  $e->getMessage(). "\n";
                flash('message', $erro,'alert alert-danger');
                redirect('posts/edit/'.$post_id);
            }

                      
                        
        }



        public function edit($id){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'id' => $id,
                    'title' => html($_POST['title']),
                    'body' => html($_POST['body']),
                    'user_id' => $_SESSION[SE.'user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate title
                $data['title_err'] = validate($data['title'],['required','isempty']);               

                // Validate body
                $data['body_err'] = validate($data['body'],['required','isempty']);
                
                // Make sure no errors
                if(empty($data['title_err']) && empty($data['body_err'])){
                   // Validate
                   if($this->postModel->updatePost($data)){
                    flash('message', 'Post Atualizado');
                    redirect('posts');
                   } else {
                    die('Algo de errado aconteceu');
                   }
                } else {
                    // Load view with errors
                    $this->view('posts/edit', $data);
                }
    
            } else {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);
            
            // Check for owner
            // se não for dono do post ele redireciona para o posts
            if($post->user_id != $_SESSION[SE.'user_id']){
                redirect('posts');
            }
            $data = [
                //id que vem da própria função public function edit($id){
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body,
                'files' => $this->postModel->getFilePostById($id)
            ];

            $this->view('posts/edit', $data);
            }
        }
    
    
        public function show($id){
            $post = $this->postModel->getPostById($id);
            $user = $this->userModel->getUserById($post->user_id);
           
            $data = [
                'post' => $post,
                'user' => $user,
                'files' => $this->postModel->getFilePostById($post->id)
            ];
            


            $this->view('posts/show' ,$data);
        }


        public function delete($id){   
            // Get existing post from model
            $post = $this->postModel->getPostById($id); 
            //set if owner's post
            $owner = ($post->user_id == $_SESSION[SE.'user_id']);                       

            if(!$owner){
                redirect('posts');
            }  

            if($_SERVER['REQUEST_METHOD'] == 'POST'){     
                try {
                    if($this->postModel->deletePost($id)){
                        flash('message', 'Post removido com Sucesso!');
                        redirect('posts');
                    } else {
                        throw new Exception('Ops! Algo deu errado ao tentar excluir o post!');  
                    }
                } catch (Exception $e) {
                    $erro = 'Erro: '.  $e->getMessage(). "\n";
                    flash('message', $erro,'alert alert-danger');
                    redirect('posts/show/'.$id);
                } 
            } 

            $data = [
                'id'=>$id,
                'title'=>$post->title
            ];
            $this->view('posts/confirm',$data);
        }
    
    
    
    
    }

?>