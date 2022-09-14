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

<!-- Tabela com os campos de cabeçalho -->
<div class="container mt-5 mb-3">
    <h2 style="margin-bottom: 30px;">DataTable com dados do banco de dados em php</h2>
    <table id="idDaTabela" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Email</th>
                <th>Nome</th>
                <th>Municipio</th>
                <th>Logradouro</th>
                <th>Ações</th>
            </tr>
        </thead>
    </table>
</div>

<!-- jquery.dataTable.min.js -->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- SCRIPT DATATABLE -->
<script>

$(document).ready(function() {   
    $('#idDaTabela').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'POST',
        'ajax': {
            'url':'<?php echo URLROOT; ?>/datatables/datatable'//controller/método que vai buscar os dados datatable                    
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
        'columns': [ //Colunas onde os dados serão populados
            { data: 'pessoaEmail' },
            { data: 'pessoaNome' },
            { data: 'pessoaMunicipio' },
            { data: 'pessoaLogradouro' },
            { data: "pessoaAcoes" }
        ]
    });
} );

</script>

<!-- FOOTER -->
<?php require APPROOT . '/views/inc/footer.php'; ?>