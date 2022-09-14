<?php
class Ajax {
    private $db;

    public function __construct(){
        //inicia a classe Database
        $this->db = new Database;
    }

    public function gravaPessoa($data){
        $this->db->query('
                        INSERT INTO pessoa SET
                        pessoaNome          = :pessoaNome, 
                        pessoaEmail         = :pessoaEmail, 
                        pessoaTelefone      = :pessoaTelefone,
                        pessoaCelular       = :pessoaCelular,
                        pessoaMunicipio     = :pessoaMunicipio                            
        ');
        $this->db->bind(':pessoaNome',$data['pessoaNome']);
        $this->db->bind(':pessoaEmail',$data['pessoaEmail']);
        $this->db->bind(':pessoaTelefone',$data['pessoaTelefone']);
        $this->db->bind(':pessoaCelular',$data['pessoaCelular']);
        $this->db->bind(':pessoaMunicipio',$data['pessoaMunicipio']);
       
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }





}
?>