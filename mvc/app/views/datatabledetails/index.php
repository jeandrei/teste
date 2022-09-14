<!-- HEADER -->
<?php require APPROOT . '/views/inc/header.php';?>

<!-- jquery.dataTable css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- FLASH MESSAGE -->
<!-- pessoa_message é o nome da menságem está lá no controller -->
<?php flash('message'); ?>
<!-- mb-3 marging bottom -->

<!-- TÍTULO -->
<div class="row text-center">
    <h1><?php echo $data['titulo']; ?></h1>
</div>

<!-- Tabela com os campos de cabeçalho 
IMPORTANTE a primeira sempre tem que ficar vazio para acomodar o botão + <th></th>
Atento também ao id da tabela tem que ser igual aqui e nas linhas:
var table = $('#idDaTabela') e
$('#idDaTabela tbody')
-->
<div class="container mt-5 mb-3">		
    <table id="idDaTabela" class="display" style="width:100%">
        <thead>
            <tr>
                <th></th>
                <th>Nome</th>
                <th>Nascimento</th>
                <th>Município</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
    </table>
</div>

<!-- jquery.dataTable.min.js -->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- SCRIPT DATATABLE -->
<script>

   /* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    /* aqui expande os dados na tabela ao clicar */
    
   
    /**
     * Coloque os campos que irao aparecer no detalhe
     * 
     */
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Celular:</td>'+
            '<td>'+d.pessoaCelular+'</td>'+
            '<td>Telefone Fixo:</td>'+
            '<td>'+d.pessoaTelefone+'</td>'+            
        '</tr>'+
        '<tr>'+
            '<td>Município:</td>'+
            '<td>'+d.pessoaMunicipio+'</td>'+
            '<td>Rua:</td>'+
            '<td>'+d.pessoaLogradouro+'</td>'+
            '<td>Número:</td>'+
            '<td>'+d.pessoaNumero+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>CPF:</td>'+
            '<td>'+d.pessoaCpf+'</td>'+
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#idDaTabela').DataTable( {
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url':'<?php echo URLROOT; ?>/datatabledetails/datatable'//controller/método que vai buscar os dados datatable                    
        },
            "oLanguage": {//tradução para o português
            "sProcessing":      "Procesando...",
            "sLengthMenu":      "Mostrando _MENU_ registros por página",
            "sEmptyTable":      "Nenhum dado disponível na tabela",
            "sZeroRecords":     "Ops! Nada encontrado.",
            "sInfo":            "Mostrando de _START_ a _END_ de _TOTAL_ registros",
            "sInfoEmpty":       "Mostrando de 0 até 0 de 0 records",
            "sInfoFiltered":    "(filtrados de _MAX_ registros no total)",
            "sSearch":          "Buscar:",
            "sUrl":             "",
            "sInfoThousands":   ",",
            "sLoadingRecords":  "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            }
        },
        
       
        /**
         * Atualize os campos que irão aparecer na tabela principal 
         * depois aqui mesmo vá para o passo 3
         */
        "columns": [
            {
                "className":      'dt-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "pessoaNome" },
            { "data": "pessoaNascimento" },
            { "data": "pessoaMunicipio"},
            { "data": "pessoaEmail"},
            { "data": "pessoaAcoes" }
        ],
        "order": [[1, 'asc']]
    } );
     
    // Add event listener for opening and closing details
    $('#idDaTabela tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
} );

</script>

<!-- FOOTER -->
<?php require APPROOT . '/views/inc/footer.php'; ?>