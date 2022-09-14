<?php 
    class Ajaxs extends Controller{
        public function __construct(){            
            $this->ajaxModel = $this->model('Ajax');
        }

        public function index(){  
            $this->view('ajaxs/index');
        }
        
        public function gravar(){
             $data=[
                'pessoaNome'=>$_POST['pessoaNome'],
                'pessoaEmail'=>$_POST['pessoaEmail'],
                'pessoaTelefone'=>$_POST['pessoaTelefone'],
                'pessoaCelular'=>$_POST['pessoaCelular'],
                'pessoaMunicipio'=>$_POST['pessoaMunicipio']
            ];

            $error=[];

            //valida pessoaNome
            if(empty($data['pessoaNome'])){
                $error['pessoaNome_err'] = 'Por favor informe o nome da pessoa!';
            }


            //valida pessoaEmail
            if(empty($data['pessoaEmail'])){
                $error['pessoaEmail_err'] = 'Por favor informe o Email!';
            } else {
                if(!validaemail($data['pessoaEmail'])){
                    $error['pessoaEmail_err'] = 'Email inválido!'; 
                }
            }

            //valida pessoaTelefone
            if(empty($data['pessoaTelefone'])){
                $error['pessoaTelefone_err'] = 'Por favor informe o telefone!';
            } else {
                if(!validatelefone($data['pessoaTelefone'])){
                    $error['pessoaTelefone_err'] = 'Telefone inválido!'; 
                }
            }

            //valida pessoaCelular
            if(empty($data['pessoaCelular'])){
                $error['pessoaCelular_err'] = 'Por favor informe o celular!';
            }else {
                if(!validacelular($data['pessoaCelular'])){
                    $error['pessoaCelular_err'] = 'Celular inválido!'; 
                }
            }

             //valida pessoaTelefone
             if(empty($data['pessoaMunicipio'])){
                $error['pessoaMunicipio_err'] = 'Por favor informe seu município!';
            }




            if(
                empty($error['pessoaNome_err'])&&
                empty($error['pessoaEmail_err'])&&
                empty($error['pessoaTelefone_err'])&&
                empty($error['pessoaCelular_err'])&&
                empty($error['pessoaMunicipio_err'])                
                
                )
            {
                //Se não teve nenhum erro grava os dados
                try{

                    if($this->ajaxModel->gravaPessoa($data)){
                        //para acessar esses valores no jquery
                        //exemplo responseObj.message
                        $json_ret = array(
                                            'classe'=>'alert alert-success', 
                                            'message'=>'Dados gravados com sucesso',
                                            'error'=>false
                                        );                     
                        
                        echo json_encode($json_ret); 
                    }     
                } catch (Exception $e) {
                    $json_ret = array(
                            'classe'=>'alert alert-danger', 
                            'message'=>'Erro ao gravar os dados',
                            'error'=>$data
                            );                     
                    echo json_encode($json_ret); 
                }


                
            }   else {
                $json_ret = array(
                    'classe'=>'alert alert-danger', 
                    'message'=>'Erro ao tentar gravar os dados',
                    'error'=>$error
                );
                echo json_encode($json_ret);
            } 



            


           

                                
        }

        public function add(){
            $this->view('ajaxs/add');
        }

        public function edit(){            
            $this->view('ajaxs/edit');
        }       
    }
?>