<?php
class Combodinamico {
    private $db;

    public function __construct(){
        //inicia a classe Database
        $this->db = new Database;
    }

    public function getRegioes(){
        $this->db->query('SELECT *                          
                          FROM regiao                                                
                          ORDER BY regiao.regiao ASC
                          ');
        $results = $this->db->resultSet(); 

        if($this->db->rowCount() > 0){
            return $results;
        } else {
            return false;
        }            
    }


    public function getEstadosRegiaoById($regiaoId){        
        $this->db->query('SELECT *                          
                          FROM 
                                estados 
                          WHERE 
                               regiaoId = :regiaoId                                               
                          ORDER BY 
                                estados.estado 
                          ASC
                          ');

        $this->db->bind(':regiaoId', $regiaoId);
        
        $results = $this->db->resultSet();         

        if($this->db->rowCount() > 0){
            return $results;
        } else {
            return false;
        }       

    }

    public function getMunicipiosEstadoById($estadoId){        
        $this->db->query('SELECT *                          
                          FROM 
                                municipios 
                          WHERE 
                               estadoId = :estadoId                                               
                          ORDER BY 
                                municipios.municipio 
                          ASC
                          ');

        $this->db->bind(':estadoId', $estadoId);
        
        $results = $this->db->resultSet();         

        if($this->db->rowCount() > 0){
            return $results;
        } else {
            return false;
        }       

    }
}
?>