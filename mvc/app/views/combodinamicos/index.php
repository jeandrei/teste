<!-- HEADER -->
<?php require APPROOT . '/views/inc/header.php';?>

<script>

    /* Quando o documento for carregado */
    $(document).ready(function(){
        //CARREGA OS ESTADOS
        /* No evento change do select de id  regiaoId*/
        $('#regiaoId').change(function(){
            /* adiciona ao select de id  municipioId o option Selecione um Município
            toda vez que o regiaoId é alterado para que sempre os dois sequentes fiquem com
            o option Selecione.... */
           $('#municipioId').html("<option>Selecione um Estado</option");
           /* Manda para o controller combodinamicos e método estadosRegiao o regiaoId
           selecionado, o que for retornado através do echo será incorporado ao select
           de id estadoId*/
           $('#estadoId').load('<?php echo URLROOT; ?>/combodinamicos/estadosRegiao/'+$('#regiaoId').val());
        });

        //CARREGA OS MUNICÍPIOS
        $('#estadoId').change(function(){           
           $('#municipioId').load('<?php echo URLROOT; ?>/combodinamicos/municipiosEstado/'+$('#estadoId').val());
        });
    });

</script>

<!-- FLASH MESSAGE -->
<!-- pessoa_message é o nome da menságem está lá no controller -->
<?php flash('message'); ?>
<!-- mb-3 marging bottom -->

<!-- TÍTULO -->
<div class="row text-center">
    <h1><?php echo $data['titulo']; ?></h1>
</div>


<form name="combodinamico" id="combodinamico">

    <!-- SELECT DA REGIÃO 1º SELECT DO COMBO-->
    <div class="row">
        <div class="col-sm-4">
        <label for="regiaoId">Região</label>
            
            <select
            name="regiaoId"
            id="regiaoId"
            class="form-control"
            >
                <!-- Primeiro Option da lista -->
                <option value="NULL">Selecione uma Região</option>
                
                <?php foreach($data['regioes'] as $regiao) : ?>
                    <option value="<?php echo $regiao->regiaoId ?>" >                
                        <?php echo $regiao->regiao; ?>
                    </option>
                <?php endforeach; ?>  
            </select>
        
        <!-- FECHA col -->
        </div>       
    <!-- FECHA row -->
    </div>

    <!-- SELECT DO ESTADO 2º SELECT DO COMBO -->
    <div class="row">
        <div class="col-sm-4">
            <label for="estadoId">Estado</label>
            <select name="estadoId" id="estadoId" class="form-control">
                <option value="NULL">Selecione uma Região</option>
            </select>                
        <!-- FECHA col -->
        </div>
    <!-- FECHA row -->
    </div>

    <!-- SELECT DO MUNICÍPIO 3º SELECT DO COMBO -->
    <div class="row">
        <div class="col-sm-4">
            <label for="municipioId">Município</label>
            <select name="municipioId" id="municipioId" class="form-control">
                <option value="NULL">Selecione um Estado</option>
            </select>                
        <!-- FECHA col -->
        </div>
    <!-- FECHA row -->
    </div>

</form>


<!-- FOOTER -->
<?php require APPROOT . '/views/inc/footer.php';?>