<?php 
    class Datatables extends Controller{
        public function __construct(){            
            $this->dataModel = $this->model('Datatable');
        }

        //Carrega o view index
        public function index(){             
            
            $this->view('datatables/index');         
        }    

        //Método carregado lá no index no script do datatable url:
        public function datatable(){  
           
             // Reading value vem lá do index
            $draw = intval($_POST['draw']);
            $row = intval($_POST['start']);
            $rowperpage = intval($_POST['length']); // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value

            $searchArray = array();

             // Search 
            //Atualize os campos devem ser os mesmos que estão no index
            // columns { "data": "pessoaNome" },
            $searchQuery = " ";
            if($searchValue != ''){
                $searchQuery = " AND (pessoaEmail LIKE :pessoaEmail OR 
                    pessoaNome LIKE :pessoaNome OR
                    pessoaMunicipio LIKE :pessoaMunicipio OR 
                    pessoaLogradouro LIKE :pessoaLogradouro ) ";
                $searchArray = array( 
                    'pessoaEmail'=>"%$searchValue%",
                    'pessoaNome'=>"%$searchValue%",
                    'pessoaMunicipio'=>"%$searchValue%",
                    'pessoaLogradouro'=>"%$searchValue%"
                );
            }

            //Retorna o total de registros da tabela
            $totalRecords = $this->dataModel->totalRecords('pessoa');

            //Retorna o total de registros da tabela aplicando o filtro do campo buscar
            $totalRecordwithFilter = $this->dataModel->totalRecordwithFilter('pessoa',$searchQuery,$searchArray);

            //Retorna os dados para serem apresentados na tabela, pode ser aplicado filtro do acmpo buscar
            $empRecords = $this->dataModel->empRecords('pessoa',$searchQuery,$searchArray,$columnName,$columnSortOrder,$row,$rowperpage);
            
       
            //Formata os dados para serem apresentados na tabela
            $data = array();

            //Aqui coloque todos os camopos do bd que deseja utilizar
            //pessoaAcoes são os botões de editar e excluir
            foreach ($empRecords as $row) {
                $data[] = array(
                    "pessoaEmail"=>$row->pessoaEmail,
                    "pessoaNome"=>$row->pessoaNome,
                    "pessoaMunicipio"=>$row->pessoaMunicipio,
                    "pessoaLogradouro"=>$row->pessoaLogradouro,
                    "pessoaAcoes"=>    '<a href="'.URLROOT.'/pessoas/edit/'.$row->pessoaId.'">
                                        <buton type="button" class="btn btn-primary">Editar</button>
                                        </a>
                                        <a href="'.URLROOT.'/pessoas/delete/'.$row->pessoaId.'">
                                        <buton type="button" class="btn btn-danger">Excluir</button>
                                        </a>'
                );
            }
            
            // Array de resposta com todos os dados necessários
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
             
            //Echo com os dados que serão apresentados
            echo json_encode($response); 
        }








        public function add(){
            $this->view('datatables/add');
        }

        public function edit(){            
            $this->view('datatables/edit');
        }       
    }
?>