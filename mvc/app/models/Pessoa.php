<?php
class Pessoa {
    private $db;
    private $pag;

    public function __construct(){
        //inicia a classe Database
        $this->db = new Database;       
    }

    public function getPessoas(){
        $this->db->query('SELECT *                          
                          FROM pessoa                                                
                          ORDER BY pessoa.pessoaNome ASC
                          ');
        $results = $this->db->resultSet(); 
        return $results;           
    }

    //Retorna o número de registros da instrução sql
    public function getTotalRows($sql){
        $this->db->query($sql);      
        $this->db->resultSet();      
        if($this->db->rowCount() > 0){
            return $this->db->rowCount();
        } else {
            return false;
        } 
    }  


    //Monta a SQL conforme os parâmetros passados por $options['named_params']
    //que vem lá do controller, executa a query e retorna a paginação
    public function getPessoasPag($page,$options){ 
        $sql = 'SELECT * FROM pessoa WHERE 1';

        $order = ' ORDER BY pessoa.pessoaNome ASC ';

        //SE QUISER FAZER MANUAL SEM O SQL BUILDER
        /* if(!empty($options['named_params'][':pessoaNome'])){
            $where .= ' AND pessoaNome = :pessoaNome';
        } */

        /**
         * MONTA O SQL
         */
        $bind=[];
        foreach($options['named_params'] as $key=>$value){
            if(!empty($value)){
            //SE TIVER ALGUM VALOR REMOVO O : DA CHAVE por exemplo :pessoaNome deixo como pessoaNome
            $and = str_replace(':','',$key);
            //ADICIONO AO SQL AND pessoaNome = :pessoaNome
            $sql .= ' AND ' . $and.' = '.$key; 
            //aqui dou um merge para cada linha existente no options['name_params'] montando um novo array
            // que vai ficar algo assim [":pessoaNome"]=> string(5) "TESTE" [":pessoaMunicipio"]=> string(5) "penha"
            $bind = array_merge($bind,[$key => $value]); 
            }                   
            
        } 
        
        //Adiciona a clauusula order by
        $sql .= $order;        

        //TENTA EXECUTAR A PAGINAÇÃO 
        try
        {
            $this->pag = new Pagination($page,$sql, $options);  
        }
        catch(paginationException $e)
        {
            echo $e;
            exit();
        }



        //faz o bind com cada linha armazendada dentro do array bind
         foreach($bind as $key=>$value){            
            $this->pag->bindParam($key, $value, PDO::PARAM_STR, 12);            
        } 


        //SE FIZER MANUAL UTILIZE ESSA LINHA COMO EXEMPLO PARA O BIND
        // $pagination->bindParam(':pessoaNome', 'Pessoa 01', PDO::PARAM_STR, 12);

        //EXECUTA A PAGINAÇÃO
        $this->pag->execute();
        //RETORNA A PAGINAÇÃO
        return $this->pag;      
        
    } 

    public function getPessoaById($id){
        $this->db->query('
                        SELECT
                                *
                        FROM
                                pessoa
                        WHERE 
                                pessoaId = :id
                        ');
        $this->db->bind(':id', $id);

        $row = $this->db->single();
        //verificq se teve algum resultado
        if($this->db->rowCount() > 0){
            return $row;
        } else {
            return false;
        }         
    }


    public function register($data){      
       $this->db->query('
                            INSERT INTO pessoa SET
                            pessoaNome          = :pessoaNome, 
                            pessoaEmail         = :pessoaEmail, 
                            pessoaTelefone      = :pessoaTelefone,
                            pessoaCelular       = :pessoaCelular,
                            pessoaMunicipio     = :pessoaMunicipio,
                            bairroId            = :bairroId,
                            pessoaLogradouro    = :pessoaLogradouro,
                            pessoaNumero        = :pessoaNumero,
                            pessoaUf            = :pessoaUf,
                            pessoaNascimento    = :pessoaNascimento,
                            pessoaDeficiencia   = :pessoaDeficiencia,
                            pessoaCpf           = :pessoaCpf,
                            pessoaCnpj          = :pessoaCnpj,
                            pessoaTermo         = :pessoaTermo                      
                        ');
        $this->db->bind(':pessoaNome',$data['pessoaNome']);
        $this->db->bind(':pessoaEmail',$data['pessoaEmail']);
        $this->db->bind(':pessoaTelefone',$data['pessoaTelefone']);
        $this->db->bind(':pessoaCelular',$data['pessoaCelular']);
        $this->db->bind(':pessoaMunicipio',$data['pessoaMunicipio']);
        $this->db->bind(':bairroId',$data['bairroId']);
        $this->db->bind(':pessoaLogradouro',$data['pessoaLogradouro']);
        $this->db->bind(':pessoaNumero',$data['pessoaNumero']);
        $this->db->bind(':pessoaUf',$data['pessoaUf']);
        $this->db->bind(':pessoaNascimento',$data['pessoaNascimento']);
        
        if(empty($data['pessoaDeficiencia'])){
            $this->db->bind(':pessoaDeficiencia','n');
        } else {
            $this->db->bind(':pessoaDeficiencia',$data['pessoaDeficiencia']);
        } 
        
        if(empty($data['pessoaTermo'])){
            $this->db->bind(':pessoaTermo','n');
        } else {
            $this->db->bind(':pessoaTermo',$data['pessoaTermo']);
        }   
        
        $this->db->bind(':pessoaCpf',$data['pessoaCpf']);
        $this->db->bind(':pessoaCnpj',$data['pessoaCnpj']);       

        if($this->db->execute()){//$this->db->lastId vem lá do database execute armazena lastid como propriedade da classe
            if($this->regInteresses($data['pessoaInteresses'],$this->db->lastId)){
                return true;
            } else {
                return false;
            }
            
        } else {
            return false;
        }
        
    }


    public function update($data){        
        $this->db->query('
                             UPDATE pessoa SET
                             pessoaNome          = :pessoaNome, 
                             pessoaEmail         = :pessoaEmail, 
                             pessoaTelefone      = :pessoaTelefone,
                             pessoaCelular       = :pessoaCelular,
                             pessoaMunicipio     = :pessoaMunicipio,
                             bairroId            = :bairroId,
                             pessoaLogradouro    = :pessoaLogradouro,
                             pessoaNumero        = :pessoaNumero,
                             pessoaUf            = :pessoaUf,
                             pessoaNascimento    = :pessoaNascimento,
                             pessoaDeficiencia   = :pessoaDeficiencia,
                             pessoaCpf           = :pessoaCpf,
                             pessoaCnpj          = :pessoaCnpj,
                             pessoaTermo         = :pessoaTermo 
                             WHERE pessoaId = :pessoaId                      
                         ');
         $this->db->bind(':pessoaId',$data['pessoaId']);                
         $this->db->bind(':pessoaNome',$data['pessoaNome']);
         $this->db->bind(':pessoaEmail',$data['pessoaEmail']);
         $this->db->bind(':pessoaTelefone',$data['pessoaTelefone']);
         $this->db->bind(':pessoaCelular',$data['pessoaCelular']);
         $this->db->bind(':pessoaMunicipio',$data['pessoaMunicipio']);
         $this->db->bind(':bairroId',$data['bairroId']);
         $this->db->bind(':pessoaLogradouro',$data['pessoaLogradouro']);
         $this->db->bind(':pessoaNumero',$data['pessoaNumero']);
         $this->db->bind(':pessoaUf',$data['pessoaUf']);
         $this->db->bind(':pessoaNascimento',$data['pessoaNascimento']);
         
         if(empty($data['pessoaDeficiencia'])){
             $this->db->bind(':pessoaDeficiencia','n');
         } else {
             $this->db->bind(':pessoaDeficiencia',$data['pessoaDeficiencia']);
         }    
         
         if(empty($data['pessoaTermo'])){
            $this->db->bind(':pessoaTermo','n');
        } else {
            $this->db->bind(':pessoaTermo',$data['pessoaTermo']);
        }    
         
         $this->db->bind(':pessoaCpf',$data['pessoaCpf']);
         $this->db->bind(':pessoaCnpj',$data['pessoaCnpj']);       
 
         if($this->db->execute()){                
            if($this->regInteresses($data['pessoaInteresses'],$data['pessoaId'])){
                return true;
            } else {
                return false;
            }                        
         } else {
             return false;
         }
         
     }

     //função para gravar e atualizar os interesses de uma pessoa
     public function regInteresses($interesses,$id){           
       
       //primeiro apago todos os registros dos interesses da pessoa
       $this->db->query('
                            DELETE
                            FROM
                            pessoaInteresses
                            WHERE
                            pessoaId = :pessoaId
                        ');
        $this->db->bind(':pessoaId', $id);
        $this->db->execute();
            
        //depois gravo os interesses novamente
        if(!empty($interesses)){    
            $i=0;
            //depois gravo cada um no banco
            foreach($interesses as $row){
                $i++;
                $this->db->query('
                                INSERT INTO pessoaInteresses SET
                                interesseId	 = :interesseId,
                                pessoaId	 = :pessoaId  
                            ');
                $this->db->bind(':interesseId',$row);
                $this->db->bind(':pessoaId',$id);
                $this->db->execute();
            }
            //se o número de interações feitas pelo foreach for igual ao número de ítens do array
            //quer dizer que todos os ítens foram adicionados no banco de dados
            //se todos os ítens foram adicionados retorno true caso contrário retorno false
            if($i == count($interesses)){
                return true;
            } else {
                return false;
            }

        } return true;
             
    }

    public function getInteressesPessoa($id){
            
            $this->db->query('
                                SELECT
                                        interesseId
                                FROM
                                        pessoaInteresses
                                WHERE 
                                        pessoaId = :id
                            ');
            $this->db->bind(':id', $id);

            $results = $this->db->resultSet();

            //verificq se teve algum resultado
            if($this->db->rowCount() > 0){
                //crio um novo array para retornar apenas os ids
                $interesses=[];
                foreach($results as $row){
                    array_push($interesses, $row->interesseId);               
                } 
                //retorna um array com apenas os ids dos interesses rray(4) { [0]=> string(1) "1" [1]=> string(1) "2" [2]=> string(1) "3" [3]=> string(1) "4" }   
                return $interesses;
            } else {
                return [];
            }
    }


     public function delete($id){        
       $this->db->query('
                            DELETE
                            FROM
                                pessoa
                            WHERE
                                pessoaId = :pessoaId   
                        ');
        $this->db->bind(':pessoaId', $id);

        $row = $this->db->execute();

        // Check row
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
     }

     /**
      * grava os dados do campo observação através do ajax
      */
     public function gravaObs($id,$data){         
        $this->db->query('UPDATE pessoa SET pessoa.pessoaObservacao = :pessoaObservacao WHERE pessoaId=:id');
        $this->db->bind(':id',$id); 
        $this->db->bind(':pessoaObservacao',$data);                        
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
     }
           
    
}
?>