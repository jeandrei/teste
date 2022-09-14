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
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate title
                if(empty($data['title'])){
                    $data['title_err'] = 'Por favor informe o título';
                }

                  // Validate body
                  if(empty($data['body'])){
                    $data['body_err'] = 'Por favor informe o texto';
                }
                
                // Make sure no errors
                if(empty($data['title_err']) && empty($data['body_err'])){
                    // Validate
                    if($lastId = $this->postModel->addPost($data)){
                         //passo o lastId para poder adicionar arquivos no post   
                         $data['lastId'] = $lastId;     
                         flash('post_message', 'Post Adicionado');
                         $this->view('posts/add', $data);
                    } else {
                     die('Algo de errado aconteceu');
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
                if(empty($data['title'])){
                    $data['title_err'] = 'Por favor informe o título';
                }

                  // Validate body
                  if(empty($data['body'])){
                    $data['body_err'] = 'Por favor informe o texto';
                }


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
                            if(!$this->postModel->addFilesPost($data['id'],$data)){
                                die('Erro ao tentar registraro arquivo!');
                            }
                        }
                    flash('post_message', 'Arquivo Adicionado');
                    $data = [
                        'id' => $id_post,
                        'title' => '',
                        'boddy' => ''
                    ];
                    $this->view("posts/addfile",$data);
                  
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
            //se não pertencer ao dono do post redireciono para o início
            if($owner != $_SESSION[SE.'user_id']){
                redirect('posts');
            } 

            $idpost = $this->postModel->deleteFile($id);            
            redirect('posts/edit/'.$idpost->post_id);            
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
                if(empty($data['title'])){
                    $data['title_err'] = 'Por favor informe o título';
                }

                  // Validate body
                  if(empty($data['body'])){
                    $data['body_err'] = 'Por favor informe o texto';
                }
                
                // Make sure no errors
                if(empty($data['title_err']) && empty($data['body_err'])){
                   // Validate
                   if($this->postModel->updatePost($data)){
                    flash('post_message', 'Post Atualizado');
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
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            // Get existing post from model
            $post = $this->postModel->getPostById($id);           
            // Check for owner
            // se não for dono do post ele redireciona para o posts
            if($post->user_id != $_SESSION[SE.'user_id']){
                redirect('posts');
            }                
                if($this->postModel->deletePost($id)){
                    flash('post_message', 'Post Removido');
                    redirect('posts');
                } else {
                    die('Algo de errado aconteceu');
                }
            } else {
                $post = $this->postModel->getPostById($id);                
                $data = [
                    'id'=>$id,
                    'title'=>$post->title
                ]; 
                if($post->user_id != $_SESSION[SE.'user_id']){
                    redirect('posts');
                }               
                $this->view('posts/confirm',$data);
            }
        }
    
    
    
    
    }

?>