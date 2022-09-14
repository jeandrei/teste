<?php
class Datatable {
    private $db;

    public function __construct(){
        //inicia a classe Database
        $this->db = new Database;
    }

    //Retorna o todal de registros de uma tabela
    public function totalRecords($tabela){
       $sql = "SELECT COUNT(*) AS allcount FROM " . $tabela; 
       $this->db->query($sql); 
       $row = $this->db->single();
       return $row->allcount;
    }

    //Retorna o total de registros de uma tabela aplicando o filtro do campo buscar
    public function totalRecordwithFilter($tabela,$searchQuery,$searchArray){
        $sql = "SELECT COUNT(*) AS allcount FROM ".$tabela." WHERE 1 ".$searchQuery;        
        $this->db->query($sql); 
        // Bind values
        foreach ($searchArray as $key=>$search) {
            $this->db->bind(':'.$key, $search);
        } 
        $row = $this->db->single();
        return $row->allcount;
    }

    //Retorna os dados do banco de dados para a paginação, pode ter aplicado filtro do campo buscar
    public function empRecords($tabela,$searchQuery,$searchArray,$columnName,$columnSortOrder,$row,$rowperpage){       
        $sql = "SELECT * FROM ".$tabela." WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset";
        $this->db->query($sql);   
        // Bind values
          foreach ($searchArray as $key=>$search) {
            $this->db->bind(':'.$key, $search);
        }  
        $this->db->bind(':limit', $row);
        $this->db->bind(':offset', $rowperpage);
        $empRecords = $this->db->resultSet();     
        return $empRecords;   
    }
        
}
?>