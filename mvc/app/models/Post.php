<?php

    class Post {
        private $db;

        
        public function __construct(){
            $this->db = new Database;
        }


        public function getPostsActive(){
            $this->db->query('SELECT 
                                posts.title, 
                                posts.body, 
                                posts.id as postId,
                                posts.user_id as userId, 
                                posts.created_at as postCreated FROM 
                                    posts 
                                WHERE 
                                    active = 1 
                                ORDER BY 
                                    posts.created_at 
                                DESC
                              ');            
            $results = $this->db->resultSet(); 
            return $results;           
        }

        public function getPostsByTag($tag){
            $this->db->query('SELECT 
                                tags.tag, 
                                posts.title, 
                                posts.body, 
                                posts.id as postId, 
                                posts.user_id as userId,
                                posts.created_at as postCreated
                              FROM 
                                posts, tags 
                              WHERE 
                                posts.tag_id = tags.id 
                              AND 
                                tag = :tag 
                              AND 
                                posts.active = 1 
                              ORDER BY 
                                posts.created_at 
                              DESC
                              ');
            $this->db->bind(':tag',$tag);
            $results = $this->db->resultSet(); 

            if($this->db->rowCount() > 0){
                foreach($results as $post){
                    $rows[] = [
                        'id' => $post->postId,            
                        'title' => $post->title,
                        'body'=> $post->body,
                        'created_at' => $post->postCreated,
                        'image' => $this->getFirstFilePost($post->postId),
                        'n_image' => $this->getNumImagesPost($post->postId)
                    ];
                }
            } else {
                $rows[] = [
                    'id' => null,            
                    'title' => 'Tag inexistente',
                    'body'=> 'Verifique a tag informada'
                ];
            }
           
            return $rows;           
        }
        
        public function getPosts(){
            $this->db->query('SELECT *,
                              posts.id as post_id,
                              users.id as userId,
                              posts.created_at as postCreated,
                              users.created_at as userCreated
                              FROM posts
                              INNER JOIN users
                              ON posts.user_id = users.id
                              ORDER BY posts.created_at DESC
                              ');
            $results = $this->db->resultSet(); 
            return $results;           
        }

        //Pega a primeira imagem do post no banco de dados
        public function getFirstFilePost($post_id){
            
            $this->db->query('SELECT *
                              FROM file_post
                              WHERE post_id = :post_id
                              LIMIT 1
            ');
            $this->db->bind(':post_id',$post_id);

            $file = $this->db->single();
          
             // Check row
             if($this->db->rowCount() > 0){
                return $file;
            } else {
                return false;
            } 

        }

        //retorna todas os arquivos de um post
        public function getFilePostById($id_post){
            $this->db->query('SELECT * FROM file_post WHERE post_id = :id_post');
            $this->db->bind(':id_post', $id_post);

            $result = $this->db->resultSet();
            
            //verifica se obteve algum resultado
            if($result >0)
            {
                foreach ($result as $row)
                {
                $data[] = array(  
                        'id' => $row->id,
                        'title' => $row->title,
                        'body' => $row->body,
                        'file' => $row->file,
                        'file_name' => $row->file_name,
                        'file_type' => $row->file_type
                    );
                }                 
                return $data;
            }
            else
            {
                return false;
            }   
        }


        //Deleta um arquivo pelo seu id
        public function deleteFile($id){
            
            /* pego o id do post para poder retornar */
            $this->db->query('SELECT post_id FROM file_post WHERE id = :id');
            $this->db->bind(':id', $id);

            $postId = $this->db->single();  

            /* removo a imagem */
            $this->db->query('DELETE FROM file_post WHERE id = :id');
            // Bind values
            $this->db->bind(':id',$id);           
                      
            // Execute
            if($this->db->execute()){
                return $postId;
            } else {
                return false;
            }
        }

        //Retorna o número de imagens de um post no banco de dados
        public function getNumImagesPost($post_id){
            $this->db->query('SELECT count(id) as num
                              FROM file_post
                              WHERE post_id = :post_id                              
            ');
            $this->db->bind(':post_id',$post_id);
            $this->db->bind(':post_id',$post_id);

            $count = $this->db->single();
          
             // Check row
             if($this->db->rowCount() > 0){
                return $count->num;
            } else {
                return false;
            } 
        }

        public function addPost($data){
            $this->db->query('INSERT INTO posts (title, user_id, body) VALUES (:title, :user_id, :body)');
            // Bind values
            $this->db->bind(':title',$data['title']);
            $this->db->bind(':user_id',$data['user_id']);
            $this->db->bind(':body',$data['body']);
            
            // Execute
            if($this->db->execute()){
                return  $this->db->lastId;  
            } else {
                return false;
            }
        }

        //Retorna o id do post de um arquivo
        public function getIdPostFile($id){
            
            $this->db->query('SELECT posts.id FROM posts,file_post WHERE posts.id = file_post.post_id AND file_post.id = :id');
            $this->db->bind(':id',$id);
            $post_id = $this->db->single();            
            // Check row
            if($this->db->rowCount() > 0){
                return $post_id->id;
            } else {
                return false;
            } 

        }



        //Retorna o dono de um arquivo
        public function getOwnerFile($id){
            
            $this->db->query('SELECT user_id FROM posts,file_post WHERE posts.id = file_post.post_id AND file_post.id = :id');
            $this->db->bind(':id',$id);
            $owner = $this->db->single();            
            // Check row
            if($this->db->rowCount() > 0){
                return $owner->user_id;
            } else {
                return false;
            } 

        }

        //Adiciona os arquivos na tabela file_post
        public function addFilesPost($post_id,$data){           
            
            $this->db->query('
                                INSERT INTO 
                                file_post 
                                    (
                                        post_id,
                                        title, 
                                        body, 
                                        file,
                                        file_name,
                                        file_type
                                    ) 
                                VALUES 
                                    (
                                        :post_id,
                                        :title, 
                                        :body, 
                                        :file,
                                        :file_name,
                                        :file_type
                                    )'
                                );
            $this->db->bind(':post_id',$post_id);
            $this->db->bind(':title',$data['title']);
            $this->db->bind(':body',$data['body']);
            $this->db->bind(':file',$data['file_post_data']);
            $this->db->bind(':file_name',$data['file_post_name']);
            $this->db->bind(':file_type',$data['file_post_type']);

            // Execute
            
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }

        }

        public function updatePost($data){
            $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
            // Bind values
            $this->db->bind(':id',$data['id']);
            $this->db->bind(':title',$data['title']);            
            $this->db->bind(':body',$data['body']);

            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function getPostById($id){
            $this->db->query('SELECT * FROM posts WHERE id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();
          
            return $row;
        }

        public function deletePost($id){            
            
            //Deleto todos os arquivos de um post
            if(!$this->deleteFilesPost($id)){
                return false;
            }

            $this->db->query('DELETE FROM posts WHERE id = :id');
            // Bind values
            $this->db->bind(':id',$id);            

            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }

        }
        
        //Deleta todos os arquivos de um post
        public function deleteFilesPost($id){
           
            $this->db->query('DELETE FROM file_post WHERE post_id = :id');
            // Bind values
            $this->db->bind(':id',$id);  

            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
        
        
        public function upload($file){
            //array é os tipos de arquivos permitidos
            $file = $this->db->uploadFile($file,array('jpeg','jpg','png'),31457280);   
            return $file;                   
        }
    
    }

?>