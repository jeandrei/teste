<?php 
    class Pessoas extends Controller{
        public function __construct(){            
            $this->pessoaModel = $this->model('Pessoa');
            $this->bairroModel = $this->model('Bairro');
        }

        public function index(){

            //IMPEDE O ACESSO A POSTS SE NÃO ESTIVER LOGADO
            // isLoggedIn está no arquivo session_helper            
            if(!isLoggedIn()){               
                redirect('users/login');  
            }
            
           
            /** 01
             * IMPORTANTE O MÉTODO DO FORMULÁRIO TEM QUE SER GET
             * E O **NOME DOCAMPO DE BUSCA TEM QUE SER IGUAL AO DO BANCO DE DADOS**
             * verifica a página que está passando se não tiver
             * página no get vai passar pagina 1
             */
            if(isset($_GET['page']))  
            {  
                $page = $_GET['page'];  
            }  
            else  
            {  
                $page = 1;  
            }  

            //Para permitir armazenar o número de linhas da paginação eu verifico
            //se foi passado o numRows pelo get se sim armazeno no Session para não perder
            //o valor quando clicado no link de paginação
            if(isset($_GET['numRows'])){
                $_SESSION['numRows'] = $_GET['numRows'];
            } else {
                $_SESSION['numRows'] = 10;
            }

            /** 02
             * 
             * passo o array com as opções 
             * 
             */            
            $options = array(
                'results_per_page' => ($_GET['numRows'])?($_GET['numRows']):($_SESSION['numRows']),
                'url' => URLROOT . '/pessoas/index.php?page=*VAR*&pessoaNome=' . $_GET['pessoaNome'] . $_GET['pessoaMunicipio'],
                'using_bound_params' => true,
                'named_params' => array(
                                        ':pessoaNome' => $_GET['pessoaNome'],
                                        ':pessoaMunicipio' => $_GET['pessoaMunicipio']                                  
                                    )     
            );
            
            /** 03
             * 
             * Chamo o método da paginação que está no model
             */
            $pagination = $this->pessoaModel->getPessoasPag($page,$options);           

            /** 04
             * 
             * Verifico se obteve sucesso
             */
            if($pagination->success == true){
                //Aqui passo apenas a paginação
                $data['pagination'] = $pagination; 
               
                
                //Aqui pego apenas os resultados do banco de dados
                $results = $pagination->resultset->fetchAll();
                
                
                //Monto o array data['results'][] com os resultados
                if(!empty($results)){
                    foreach($results as $row){
                        $data['results'][] = [
                            'pessoaId' => $row['pessoaId'],
                            'pessoaNome' => $row['pessoaNome'],
                            'pessoaNascimento' => formatadata($row['pessoaNascimento']),
                            'pessoaMunicipio' => $row['pessoaMunicipio'],
                            'pessoaLogradouro' => $row['pessoaLogradouro'],
                            'pessoaBairro' => $this->bairroModel->getBairroById($row['bairroId']),
                            'pessoaDeficiencia' => ($row['pessoaDeficiencia'] == 'n') ? 'Não' : 'Sim',
                            'pessoaObservacao' => $row['pessoaObservacao']
                        ];
                    }
                }
                     
            } else {
                $data['results'] = false;
            }
            /**
             * 05 
             * Lá no final do view eu imprimo a paginação
             * 
             */       
            
            $data['titulo'] = "Exemplo de Cadastro com Paginação";         

            $this->view('pessoas/index', $data);
        }

        public function add(){              
            
            // Check for POST            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //SANITIZE POST impede códigos maliciosos
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //TRATO OS DADOS SE NECESSÁRIO POSSO EXECUTAR MÉTODOS NO MODEL PARA RETORNAR VALORES
                //EXEMPLO "campoteste" => $this->model->getNome($id);
                
                //limpo o array $data
                unset($data);
                $data = [
                    'titulo'                => 'Exemplo adicionar novo',
                    'bairros'               => $this->bairroModel->getBairros(),
                    'pessoaNome'            => html($_POST['pessoaNome']),
                    'pessoaEmail'           => html($_POST['pessoaEmail']),
                    'pessoaTelefone'        => html($_POST['pessoaTelefone']),
                    'pessoaCelular'         => html($_POST['pessoaCelular']),
                    'pessoaMunicipio'       => html($_POST['pessoaMunicipio']),
                    'bairroId'              => html($_POST['bairroId']),
                    'pessoaLogradouro'      => html($_POST['pessoaLogradouro']),
                    'pessoaNumero'          => html($_POST['pessoaNumero']),
                    'pessoaUf'              => html($_POST['pessoaUf']),
                    'pessoaNascimento'      => html($_POST['pessoaNascimento']),                    
                    'pessoaDeficiencia'     => html($_POST['pessoaDeficiencia']),
                    'pessoaCpf'             => html($_POST['pessoaCpf']),
                    'pessoaCnpj'            => html($_POST['pessoaCnpj']),
                    'pessoaInteresses'      => $_POST['pessoaInteresses'],
                    'pessoaTermo'           => html($_POST['pessoaTermo']),                    
                ];

                //VALIDAÇÃO PHP
                
                //valida pessoaNome              
                $data['pessoaNome_err'] = validate($data['pessoaNome'],['required',['isstring','min'=>10]]); 
             
                //valida pessoaEmail
                $data['pessoaEmail_err'] = validate($data['pessoaEmail'],['required','email']);
                
                //valida pessoaTelefone
                $data['pessoaTelefone_err'] = validate($data['pessoaTelefone'],['required','phone']);
              
                //valida pessoaCelular
                $data['pessoaCelular_err'] = validate($data['pessoaCelular'],['required','cphone']);
                
                //valida pessoaMunicipio
                $data['pessoaMunicipio_err'] = validate($data['pessoaMunicipio'],['required',['isstring','min'=>3]]);
        
                //valida bairroId
                $data['bairroId_err'] = validate($data['bairroId'],['required']);
              
                //valida pessoaLogradouro
                $data['pessoaLogradouro_err'] = validate($data['pessoaLogradouro'],['required',['isstring','min'=>3]]);
              
                //valida pessoaNumero
                $data['pessoaNumero_err'] = validate($data['pessoaNumero'],['required',['isnumeric','min'=>1]]);
                
                //valida pessoaUf
                $data['pessoaUf_err'] = validate($data['pessoaUf'],['required']);
                
                //valida pessoaNascimento
                $data['pessoaNascimento_err'] = validate($data['pessoaNascimento'],['required',['date','min'=>18,'futuredate'=>false]]);
                
                //valida pessoaCpf
                $data['pessoaCpf_err'] = validate($data['pessoaCpf'],['required','cpf']);                

                //valida pessoaCnpj
                $data['pessoaCnpj_err'] = validate($data['pessoaCnpj'],['required','cnpj']);
                

                //valida os interesses
                if($data['pessoaInteresses'] == NULL){
                    $data['pessoaInteresses_err'] = 'Por favor informe ao menos um interesse!';
                } 

                //valida o termo
                if($data['pessoaTermo'] == NULL){
                    $data['pessoaTermo_err'] = 'Por favor informe se aceita os termos!';
                }

                if(
                    empty($data['pessoaNome_err'])&&
                    empty($data['pessoaEmail_err'])&&
                    empty($data['pessoaTelefone_err'])&&
                    empty($data['pessoaCelular_err'])&&
                    empty($data['pessoaMunicipio_err'])&&
                    empty($data['bairroId_err'])&&
                    empty($data['pessoaLogradouro_err'])&&
                    empty($data['pessoaNumero_err'])&&
                    empty($data['pessoaUf_err'])&&
                    empty($data['pessoaNascimento_err'])&&
                    empty($data['pessoaCpf_err'])&&
                    empty($data['pessoaCnpj_err'])&&
                    empty($data['pessoaInteresses_err'])&&
                    empty($data['pessoaTermo_err'])
                ){

                    try {
                        if($this->pessoaModel->register($data)){
                            flash('message', 'Cadastro realizado com sucesso!');                     
                            $this->view('pessoas/add',$data);
                        } else {
                            throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
                        }

                    } catch (Exception $e) {
                        $erro = 'Erro: '.  $e->getMessage(). "\n";
                        flash('message', $erro,'alert alert-danger');
                        $this->view('pessoas/add');
                    }                  
                } else {
                    //Validação falhou
                    flash('message', 'Erro ao efetuar o cadastro, verifique os dados informados!','alert alert-danger');                     
                    $this->view('pessoas/add',$data);
                }                
                
            } else {//Se não for POST é a primeira vez que o formulário está sendo carregado
                //limpo o array $data
                unset($data);
                $data = [
                    'titulo'    => 'Exemplo adicionar novo',
                    'bairros'   => $this->bairroModel->getBairros()                    
                ];
                $this->view('pessoas/add', $data);
            }            
            
        }

        public function edit($id){
            // Check for POST            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //SANITIZE POST impede códigos maliciosos
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //TRATO OS DADOS SE NECESSÁRIO POSSO EXECUTAR MÉTODOS NO MODEL PARA RETORNAR VALORES
                //EXEMPLO "campoteste" => $this->model->getNome($id);
                unset($data);
                $data = [
                    'titulo'                => 'Exemplo editando',
                    'bairros'               => $this->bairroModel->getBairros(),
                    'pessoaId'              =>$id,
                    'pessoaNome'            => html($_POST['pessoaNome']),
                    'pessoaEmail'           => html($_POST['pessoaEmail']),
                    'pessoaTelefone'        => html($_POST['pessoaTelefone']),
                    'pessoaCelular'         => html($_POST['pessoaCelular']),
                    'pessoaMunicipio'       => html($_POST['pessoaMunicipio']),
                    'bairroId'              => html($_POST['bairroId']),
                    'pessoaLogradouro'      => html($_POST['pessoaLogradouro']),
                    'pessoaNumero'          => html($_POST['pessoaNumero']),
                    'pessoaUf'              => html($_POST['pessoaUf']),
                    'pessoaNascimento'      => html($_POST['pessoaNascimento']),                    
                    'pessoaDeficiencia'     => html($_POST['pessoaDeficiencia']),
                    'pessoaCpf'             => html($_POST['pessoaCpf']),
                    'pessoaCnpj'            => html($_POST['pessoaCnpj']),
                    'pessoaInteresses'      => $_POST['pessoaInteresses'],
                    'pessoaTermo'           => html($_POST['pessoaTermo']),                   
                ];

                //VALIDAÇÃO PHP
                
               //valida pessoaNome              
               $data['pessoaNome_err'] = validate($data['pessoaNome'],['required',['isstring','min'=>10]]); 
             
               //valida pessoaEmail
               $data['pessoaEmail_err'] = validate($data['pessoaEmail'],['required','email']);
               
               //valida pessoaTelefone
               $data['pessoaTelefone_err'] = validate($data['pessoaTelefone'],['required','phone']);
             
               //valida pessoaCelular
               $data['pessoaCelular_err'] = validate($data['pessoaCelular'],['required','cphone']);
               
               //valida pessoaMunicipio
               $data['pessoaMunicipio_err'] = validate($data['pessoaMunicipio'],['required',['isstring','min'=>3]]);
       
               //valida bairroId
               $data['bairroId_err'] = validate($data['bairroId'],['required']);
             
               //valida pessoaLogradouro
               $data['pessoaLogradouro_err'] = validate($data['pessoaLogradouro'],['required',['isstring','min'=>3]]);
             
               //valida pessoaNumero
               $data['pessoaNumero_err'] = validate($data['pessoaNumero'],['required',['isnumeric','min'=>1]]);
               
               //valida pessoaUf
               $data['pessoaUf_err'] = validate($data['pessoaUf'],['required']);
               
               //valida pessoaNascimento
               $data['pessoaNascimento_err'] = validate($data['pessoaNascimento'],['required',['date','min'=>18,'futuredate'=>false]]);
               
               //valida pessoaCpf
               $data['pessoaCpf_err'] = validate($data['pessoaCpf'],['required','cpf']);                

               //valida pessoaCnpj
               $data['pessoaCnpj_err'] = validate($data['pessoaCnpj'],['required','cnpj']);
               

               //valida os interesses
               if($data['pessoaInteresses'] == NULL){
                   $data['pessoaInteresses_err'] = 'Por favor informe ao menos um interesse!';
               } 

               //valida o termo
               if($data['pessoaTermo'] == NULL){
                   $data['pessoaTermo_err'] = 'Por favor informe se aceita os termos!';
               }
               if(
                    empty($data['pessoaNome_err'])&&
                    empty($data['pessoaEmail_err'])&&
                    empty($data['pessoaTelefone_err'])&&
                    empty($data['pessoaCelular_err'])&&
                    empty($data['pessoaMunicipio_err'])&&
                    empty($data['bairroId_err'])&&
                    empty($data['pessoaLogradouro_err'])&&
                    empty($data['pessoaNumero_err'])&&
                    empty($data['pessoaUf_err'])&&
                    empty($data['pessoaNascimento_err'])&&
                    empty($data['pessoaCpf_err'])&&
                    empty($data['pessoaCnpj_err'])&&
                    empty($data['pessoaInteresses_err'])&&
                    empty($data['pessoaTermo_err'])
                ){
                    
                try {
                    if($this->pessoaModel->update($data)){
                        flash('message', 'Dados atualizados com sucesso!');                     
                        $this->view('pessoas/edit',$data); 
                    } else {
                        throw new Exception('Ops! Algo deu errado ao tentar atualizar os dados!');
                    }

                } catch (Exception $e) {
                    $erro = 'Erro: '.  $e->getMessage(). "\n";
                    flash('message', $erro,'alert alert-danger');
                    $this->view('pessoas/edit',$data);    
                }                  
                } else {
                    //Validação falhou
                    flash('message', 'Erro ao efetuar a atualização, verifique os dados informados!','alert alert-danger');                     
                    $this->view('pessoas/edit',$data);   
                }    

            } else {
                //Se não for POST temos que buscar os dados no banco de dados e popular os fields
                      
                //VALIDAÇÃO DO ID               
                if(!is_numeric($id)){
                    $erro = 'ID Inválido!'; 
                } else if (!$pessoa = $this->pessoaModel->getPessoaById($id)){
                    $erro = 'ID inexistente';
                }
    
                if($erro){
                    flash('message', $erro , 'alert alert-danger'); 
                    $this->view('pessoas/index');
                    exit();
                }   
                //Limpo o array data
                unset($data);
                $data = [
                    'titulo'                => 'Exemplo Editando',
                    'bairros'               => $this->bairroModel->getBairros(),
                    'pessoaId'              => $id,
                    'pessoaNome'            => $pessoa->pessoaNome,
                    'pessoaEmail'           => $pessoa->pessoaEmail,
                    'pessoaTelefone'        => $pessoa->pessoaTelefone,
                    'pessoaCelular'         => $pessoa->pessoaCelular,
                    'pessoaMunicipio'       => $pessoa->pessoaMunicipio,
                    'bairroId'              => $pessoa->bairroId,
                    'pessoaLogradouro'      => $pessoa->pessoaLogradouro,
                    'pessoaNumero'          => $pessoa->pessoaNumero,
                    'pessoaUf'              => $pessoa->pessoaUf,
                    'pessoaNascimento'      => $pessoa->pessoaNascimento,
                    'pessoaDeficiencia'     => $pessoa->pessoaDeficiencia,
                    'pessoaCpf'             => $pessoa->pessoaCpf,
                    'pessoaCnpj'            => $pessoa->pessoaCnpj,
                    'pessoaInteresses'      => $this->pessoaModel->getInteressesPessoa($id),
                    'pessoaTermo'           => $pessoa->pessoaTermo                    
                ];
                $this->view('pessoas/edit',$data);            
            }   
        }
        
        public function delete($id){            
           
            //VALIDAÇÃO DO ID
            if(!is_numeric($id)){
               $erro = 'ID Inválido!'; 
            } else if (!$data = $this->pessoaModel->getPessoaById($id)){
                $erro = 'ID inexistente';
            }

            if($erro){
                flash('message', $erro , 'alert alert-danger'); 
                $this->view('pessoas/index');
                exit();
            }  
            
            //esse $_POST['delete'] vem lá do view('confirma');
            if(isset($_POST['delete'])){
                try {
                    if($this->pessoaModel->delete($id)){
                        flash('message', 'Registro excluido com sucesso!', 'alert alert-success'); 
                        redirect('pessoas/index');
                    } else {
                        throw new Exception('Ops! Algo deu errado ao tentar excluir os dados!');
                    }
                } catch (Exception $e) {
                    $erro = 'Erro: '.  $e->getMessage(). "\n";
                    flash('message', $erro,'alert alert-danger');
                    $this->view('pessoas/index');
                }                
           } else {   
            $this->view('pessoas/confirm',$data);
            exit();
           }  

        }

        /**
         * Grava os dados através do ajax passando id e data
         */
        public function gravaobs(){
            $id = $_POST['id'];
            $data= $_POST['data'];
            try{

                if($this->pessoaModel->gravaObs($id,$data)){
                    //para acessar esses valores no jquery
                    //exemplo responseObj.message
                    $json_ret = array(
                                        'classe'=>'text-success', 
                                        'message'=>'Dados gravados com sucesso',
                                        'error'=>false
                                    );                     
                    
                    echo json_encode($json_ret); 
                } else {
                  throw new Exception('Ops! Algo deu errado ao tentar gravar os dados!');
                }    
              } catch (Exception $e) {
                $erro = 'Erro: '.  $e->getMessage(). "\n";
                $json_ret = array(
                        'classe'=>'text-danger', 
                        'message'=>$erro,
                        'error'=>true
                        );                     
                echo json_encode($json_ret); 
              }
        }//gravaobs
       
    }
?>