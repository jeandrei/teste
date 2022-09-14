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
                            'pessoaNascimento' => date('d/m/Y', strtotime($row['pessoaNascimento'])),
                            'pessoaMunicipio' => $row['pessoaMunicipio'],
                            'pessoaLogradouro' => $row['pessoaLogradouro'],
                            'pessoaBairro' => $this->bairroModel->getBairroById($row['bairroId']),
                            'pessoaDeficiencia' => ($row['pessoaDeficiencia'] == 'n') ? 'Não' : 'Sim'                        
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
                    'pessoaNome_err'        => '',
                    'pessoaEmail_err'       => '',
                    'pessoaTelefone_err'    => '',
                    'pessoaCelular_err'     => '',
                    'pessoaMunicipio_err'   => '',
                    'bairroId_err'          => '',
                    'pessoaLogradouro_err'  => '',
                    'pessoaNumero_err'      => '',
                    'pessoaUf_err'          => '',
                    'pessoaNascimento_err'  => '',
                    'pessoaCpf_err'         => '',
                    'pessoaCnpj_err'        => '' 
                ];

                //VALIDAÇÃO PHP
                
                //valida pessoaNome
                if(empty($data['pessoaNome'])){
                    $data['pessoaNome_err'] = 'Por favor informe o nome da pessoa!';
                }

                //valida pessoaEmail
                if(empty($data['pessoaEmail'])){
                $data['pessoaEmail_err'] = 'Por favor informe o Email!';
                } else {
                    if(!validaemail($data['pessoaEmail'])){
                        $data['pessoaEmail_err'] = 'Email inválido!'; 
                    }
                }

                //valida pessoaTelefone
                if(empty($data['pessoaTelefone'])){
                    $data['pessoaTelefone_err'] = 'Por favor informe o telefone!';
                } else {
                    if(!validatelefone($data['pessoaTelefone'])){
                        $data['pessoaTelefone_err'] = 'Telefone inválido!'; 
                    }
                }

                //valida pessoaCelular
                if(empty($data['pessoaCelular'])){
                    $data['pessoaCelular_err'] = 'Por favor informe o celular!';
                }else {
                    if(!validacelular($data['pessoaCelular'])){
                        $data['pessoaCelular_err'] = 'Celular inválido!'; 
                    }
                }

                //valida pessoaMunicipio
                if(empty($data['pessoaMunicipio'])){
                    $data['pessoaMunicipio_err'] = 'Por favor informe o município!';
                }

                //valida bairroId
                if(($data['bairroId']=='null')){
                    $data['bairroId_err'] = 'Por favor informe o bairro!';
                }

                //valida pessoaLogradouro
                if(empty($data['pessoaLogradouro'])){
                    $data['pessoaLogradouro_err'] = 'Por favor informe o logradouro!';
                }

                //valida pessoaNumero
                if(empty($data['pessoaNumero'])){
                    $data['pessoaNumero_err'] = 'Por favor informe o número!';
                } else {
                    if($data['pessoaNumero'] < 1){
                        $data['pessoaNumero_err'] = 'Número inválido!';
                    }
                }

                //valida pessoaUf
                if($data['pessoaUf']=='null'){
                    $data['pessoaUf_err'] = 'Por favor informe a Unidade Federativa!';
                }

                //valida pessoaNascimento
                if(empty($data['pessoaNascimento'])){
                    $data['pessoaNascimento_err'] = 'Por favor informe o nascimento!';
                } else {
                    if(idadeMinima($data['pessoaNascimento'],18)){
                        $data['pessoaNascimento_err'] = 'Só é permitido cadastro de pessoas maiores de idade!';
                    }
                }
               
                //valida pessoaCpf
                if(empty($data['pessoaCpf'])){
                    $data['pessoaCpf_err'] = 'Por favor informe o CPF!';
                } else {                    
                    if(!validaCPF($data['pessoaCpf'])){                        
                        $data['pessoaCpf_err'] = 'CPF inválido!';
                    }
                }

                //valida pessoaCnpj
                if(empty($data['pessoaCnpj'])){
                    $data['pessoaCnpj_err'] = 'Por favor informe o CNPJ!';
                } else {                    
                    if(!validaCNPJ($data['pessoaCnpj'])){                        
                        $data['pessoaCnpj_err'] = 'CNPJ inválido!';
                    }
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
                    empty($data['pessoaCnpj_err'])
                ){
                    //se passar a validação registra no banco de dados                    
                    if($this->pessoaModel->register($data)){
                        flash('message', 'Cadastro realizado com sucesso!');                     
                        $this->view('pessoas/add',$data);
                    } else {
                        flash('message', 'Erro ao efetuar o cadastro!','alert alert-danger');                     
                        $this->view('pessoas/add',$data);
                    }
                } else {
                    //Validação falhou
                    flash('message', 'Erro ao efetuar o cadastro, verifique os dados informados!','alert alert-danger');                     
                    $this->view('pessoas/add',$data);
                }
                
                
            } else {//Se não for POST é a primeira vez que o formulário está sendo carregado
                $data = [
                    "titulo"                => 'Exemplo adicionar novo',
                    "bairros"               => $this->bairroModel->getBairros(),
                    "pessoaNome"            => '',
                    "pessoaEmail"           => '',
                    "pessoaTelefone"        => '',
                    "pessoaCelular"         => '',
                    "pessoaMunicipio"       => '',
                    "bairroId"              => '',
                    "pessoaLogradouro"      => '',
                    "pessoaNumero"          => '',
                    "pessoaUf"              => '',
                    "pessoaNascimento"      => '',
                    "pessoaDeficiencia"     => '',
                    "pessoaCpf"             => '',
                    "pessoaCnpj"            => '',
                    'pessoaNome_err'        => '',
                    'pessoaEmail_err'       => '',
                    'pessoaTelefone_err'    => '',
                    'pessoaCelular_err'     => '',
                    'pessoaMunicipio_err'   => '',
                    'bairroId_err'          => '',
                    'pessoaLogradouro_err'  => '',
                    'pessoaNumero_err'      => '',
                    'pessoaUf_err'          => '',
                    'pessoaNascimento_err'  => '',
                    'pessoaCpf_err'         => '',
                    'pessoaCnpj_err'        => '' 
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
                    'pessoaNome_err'        => '',
                    'pessoaEmail_err'       => '',
                    'pessoaTelefone_err'    => '',
                    'pessoaCelular_err'     => '',
                    'pessoaMunicipio_err'   => '',
                    'bairroId_err'          => '',
                    'pessoaLogradouro_err'  => '',
                    'pessoaNumero_err'      => '',
                    'pessoaUf_err'          => '',
                    'pessoaNascimento_err'  => '',
                    'pessoaCpf_err'         => '',
                    'pessoaCnpj_err'        => '' 
                ];

                //VALIDAÇÃO PHP
                
                //valida pessoaNome
                if(empty($data['pessoaNome'])){
                    $data['pessoaNome_err'] = 'Por favor informe o nome da pessoa!';
                }

                //valida pessoaEmail
                if(empty($data['pessoaEmail'])){
                $data['pessoaEmail_err'] = 'Por favor informe o Email!';
                } else {
                    if(!validaemail($data['pessoaEmail'])){
                        $data['pessoaEmail_err'] = 'Email inválido!'; 
                    }
                }

                //valida pessoaTelefone
                if(empty($data['pessoaTelefone'])){
                    $data['pessoaTelefone_err'] = 'Por favor informe o telefone!';
                } else {
                    if(!validatelefone($data['pessoaTelefone'])){
                        $data['pessoaTelefone_err'] = 'Telefone inválido!'; 
                    }
                }

                //valida pessoaCelular
                if(empty($data['pessoaCelular'])){
                    $data['pessoaCelular_err'] = 'Por favor informe o celular!';
                }else {
                    if(!validacelular($data['pessoaCelular'])){
                        $data['pessoaCelular_err'] = 'Celular inválido!'; 
                    }
                }

                //valida pessoaMunicipio
                if(empty($data['pessoaMunicipio'])){
                    $data['pessoaMunicipio_err'] = 'Por favor informe o município!';
                }

                //valida bairroId
                if(($data['bairroId']=='null')){
                    $data['bairroId_err'] = 'Por favor informe o bairro!';
                }

                //valida pessoaLogradouro
                if(empty($data['pessoaLogradouro'])){
                    $data['pessoaLogradouro_err'] = 'Por favor informe o logradouro!';
                }

                //valida pessoaNumero
                if(empty($data['pessoaNumero'])){
                    $data['pessoaNumero_err'] = 'Por favor informe o número!';
                } else {
                    if($data['pessoaNumero'] < 1){
                        $data['pessoaNumero_err'] = 'Número inválido!';
                    }
                }

                //valida pessoaUf
                if($data['pessoaUf']=='null'){
                    $data['pessoaUf_err'] = 'Por favor informe a Unidade Federativa!';
                }

                //valida pessoaNascimento
                if(empty($data['pessoaNascimento'])){
                    $data['pessoaNascimento_err'] = 'Por favor informe o nascimento!';
                } else {
                    if(idadeMinima($data['pessoaNascimento'],18)){
                        $data['pessoaNascimento_err'] = 'Só é permitido cadastro de pessoas maiores de idade!';
                    }
                }
               
                //valida pessoaCpf
                if(empty($data['pessoaCpf'])){
                    $data['pessoaCpf_err'] = 'Por favor informe o CPF!';
                } else {                    
                    if(!validaCPF($data['pessoaCpf'])){                        
                        $data['pessoaCpf_err'] = 'CPF inválido!';
                    }
                }

                //valida pessoaCnpj
                if(empty($data['pessoaCnpj'])){
                    $data['pessoaCnpj_err'] = 'Por favor informe o CNPJ!';
                } else {                    
                    if(!validaCNPJ($data['pessoaCnpj'])){                        
                        $data['pessoaCnpj_err'] = 'CNPJ inválido!';
                    }
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
                    empty($data['pessoaCnpj_err'])
                ){ 
                    //se passar a validação registra no banco de dados                    
                    if($this->pessoaModel->update($data)){
                        flash('message', 'Dados atualizados com sucesso!');                     
                        $this->view('pessoas/edit',$data); 
                    } else {
                        flash('message', 'Erro ao efetuar a atualização!','alert alert-danger');                     
                        $this->view('pessoas/edit',$data);                    }
                } else {
                    //Validação falhou
                    flash('message', 'Erro ao atualizar, verifique os dados informados!','alert alert-danger');                     
                    $this->view('pessoas/edit',$data);                }
                
                
            } else {
                //Se não for POST temos que buscar os dados no banco de dados e popular os fields
               
                //verifico se o id passado existe               

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
                
                $data = [
                    "titulo"                => 'Exemplo Editando',
                    "bairros"               => $this->bairroModel->getBairros(),
                    'pessoaId'              => $id,
                    "pessoaNome"            => $pessoa->pessoaNome,
                    "pessoaEmail"           => $pessoa->pessoaEmail,
                    "pessoaTelefone"        => $pessoa->pessoaTelefone,
                    "pessoaCelular"         => $pessoa->pessoaCelular,
                    "pessoaMunicipio"       => $pessoa->pessoaMunicipio,
                    "bairroId"              => $pessoa->bairroId,
                    "pessoaLogradouro"      => $pessoa->pessoaLogradouro,
                    "pessoaNumero"          => $pessoa->pessoaNumero,
                    "pessoaUf"              => $pessoa->pessoaUf,
                    "pessoaNascimento"      => $pessoa->pessoaNascimento,
                    "pessoaDeficiencia"     => $pessoa->pessoaDeficiencia,
                    "pessoaCpf"             => $pessoa->pessoaCpf,
                    "pessoaCnpj"            => $pessoa->pessoaCnpj,
                    'pessoaNome_err'        => '',
                    'pessoaEmail_err'       => '',
                    'pessoaTelefone_err'    => '',
                    'pessoaCelular_err'     => '',
                    'pessoaMunicipio_err'   => '',
                    'bairroId_err'          => '',
                    'pessoaLogradouro_err'  => '',
                    'pessoaNumero_err'      => '',
                    'pessoaUf_err'          => '',
                    'pessoaNascimento_err'  => '',
                    'pessoaCpf_err'         => '',
                    'pessoaCnpj_err'        => '' 
                ];
                $this->view('pessoas/edit',$data);            }           
            
            
        }
        
        public function delete($id){
            
            //validação do id
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
                if($this->pessoaModel->delete($id)){
                    flash('message', 'Registro excluido com sucesso!', 'alert alert-success'); 
                } else {
                    flash('message', 'Erro ao tentar excluir o registro!', 'alert alert-danger');
                }      
                redirect('pessoas/index');
           }else{   
            $this->view('pessoas/confirm',$data);
            exit();
           }     


        }
       
    }
?>