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
                            pessoaCnpj          = :pessoaCnpj                        
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
        
        $this->db->bind(':pessoaCpf',$data['pessoaCpf']);
        $this->db->bind(':pessoaCnpj',$data['pessoaCnpj']);       

        if($this->db->execute()){
            return true;
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
                             pessoaCnpj          = :pessoaCnpj  
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
         
         $this->db->bind(':pessoaCpf',$data['pessoaCpf']);
         $this->db->bind(':pessoaCnpj',$data['pessoaCnpj']);       
 
         if($this->db->execute()){
             return true;
         } else {
             return false;
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
           
    
}
?>