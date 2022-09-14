<!-- HEADER -->
<?php require APPROOT . '/views/inc/header.php';?>


<!-- FLASH MESSAGE -->
<!-- pessoa_message é o nome da menságem está lá no controller -->
<?php flash('mensagem'); ?>
<!-- mb-3 marging bottom -->

<!-- TÍTULO -->
<div class="row text-center">
    <h1><?php echo $data['titulo']; ?></h1>
</div>


<!-- FORMULÁRIO nonvalidate é para impedir a validação direta do navegador-->
<form id="filtrar" action="<?php echo URLROOT; ?>/pessoas/add" method="POST" novalidate enctype="multipart/form-data">

    <legend>Dados da Pessoa</legend>
    <fieldset class="bg-light p-2"><!-- grupo de dados -->
        <!-- PRIMEIRA LINHA -->
        <div class="row">
            
            <!--pessoaNome-->        
            <div class="col-md-8">    
                <div class="mb-3">   
                    <label 
                        for="pessoaNome"><b class="obrigatorio">*</b> Nome: 
                    </label>                        
                    <input 
                        type="text" 
                        name="pessoaNome" 
                        id="pessoaNome" 
                        class="form-control <?php echo (!empty($data['pessoaNome_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php echo htmlout($data['pessoaNome']);?>"
                        onkeydown="upperCaseF(this)" 
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaNome_err']; ?>
                    </span>
                </div>
            </div><!-- col -->
            
            <!--pessoaEmail-->
            <div class="col-md-4">            
                <div class="mb-3">   
                    <label 
                        for="pessoaEmail"><b class="obrigatorio">*</b> Email: 
                    </label>                        
                    <input 
                        type="email" 
                        name="pessoaEmail" 
                        id="pessoaEmail" 
                        class="form-control <?php echo (!empty($data['pessoaEmail_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php htmlout($data['pessoaEmail']);?>"
                        onkeydown="lowerCaseF(this)"
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaEmail_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->
        </div><!-- row -->

        <!-- SEGUNDA LINHA -->
        <div class="row">
            
            <!--pessoaTelefone-->
            <div class="col-md-4">             
                <div class="mb-3">   
                    <label 
                        for="pessoaTelefone"><b class="obrigatorio">*</b> Telefone: 
                    </label>                        
                    <input 
                        type="text" 
                        name="pessoaTelefone" 
                        id="pessoaTelefone" 
                        class="form-control telefone <?php echo (!empty($data['pessoaTelefone_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php htmlout($data['pessoaTelefone']);?>"
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaTelefone_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->

            <!--pessoaCelular-->
            <div class="col-md-4">             
                <div class="mb-3">   
                    <label 
                        for="pessoaCelular"><b class="obrigatorio">*</b> Celular: 
                    </label>                        
                    <input 
                        type="text" 
                        name="pessoaCelular" 
                        id="pessoaCelular" 
                        class="form-control celular <?php echo (!empty($data['pessoaCelular_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php htmlout($data['pessoaCelular']);?>"
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaCelular_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->
                        
            <!--pessoaMunicipio-->
            <div class="col-md-4">            
                <div class="mb-3">   
                    <label 
                        for="pessoaMunicipio"><b class="obrigatorio">*</b> Município: 
                    </label>                        
                    <input 
                        type="text" 
                        name="pessoaMunicipio" 
                        id="pessoaMunicipio" 
                        class="form-control <?php echo (!empty($data['pessoaMunicipio_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php htmlout($data['pessoaMunicipio']);?>"
                        onkeydown="upperCaseF(this)"
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaMunicipio_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->

        </div><!-- row -->

        <!-- TERCEIRA LINHA -->
        <div class="row">
            
            <!--bairroId-->
            <div class="col-md-4">             
                <div class="mb-3">   
                    <label 
                        for="bairroId"><b class="obrigatorio">*</b> Bairro: 
                    </label>                        
                    <select
                        name="bairroId"
                        id="bairroId"
                        class="form-select <?php echo (!empty($data['bairroId_err'])) ? 'is-invalid' : ''; ?>"
                    >
                        <option value="null">Selecione o Bairro</option>

                        <?php foreach($data['bairros'] as $bairro) : ?>
                        <option 
                            value="<?php htmlout($bairro->bairroId); ?>"
                            <?php echo ($data['bairroId']) == $bairro->bairroId ? 'selected' : '';?>
                        >
                        <?php htmlout($bairro->bairroNome); ?>
                        </option>
                        <?php endforeach; ?>  
                    </select>
                    <span class="invalid-feedback">
                        <?php echo $data['bairroId_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->
            
            <!--pessoaLogradouro-->
            <div class="col-md-4">             
                <div class="mb-3">   
                    <label 
                        for="pessoaLogradouro"><b class="obrigatorio">*</b> Logradouro: 
                    </label>                        
                    <input 
                        type="text" 
                        name="pessoaLogradouro" 
                        id="pessoaLogradouro" 
                        class="form-control <?php echo (!empty($data['pessoaLogradouro_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php htmlout($data['pessoaLogradouro']);?>"
                        onkeydown="upperCaseF(this)"
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaLogradouro_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->

            <!--pessoaNumero-->
            <div class="col-md-2">             
                <div class="mb-3">   
                    <label 
                        for="pessoaNumero"><b class="obrigatorio">*</b> Número: 
                    </label>                        
                    <input 
                        type="number" 
                        name="pessoaNumero" 
                        id="pessoaNumero" 
                        class="form-control <?php echo (!empty($data['pessoaNumero_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php htmlout($data['pessoaNumero']);?>"
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaNumero_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->

            <!--pessoaUf-->
            <div class="col-md-2">            
                <div class="mb-3">   
                    <label 
                        for="pessoaUf"><b class="obrigatorio">*</b> UF: 
                    </label>                        
                    <select
                        class="form-select <?php echo (!empty($data['pessoaUf_err'])) ? 'is-invalid' : ''; ?>" 
                        name="pessoaUf"
                        id="pessoaUf"
                    >
                    <option value="null">UF</option> 
                    <!-- essa funcao imprimeuf está no arquivo helpers\functions.php -->               
                    <?php echo imprimeuf($data['pessoaUf']); ?>                
                    </select>                
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaUf_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->

            <!--pessoaNascimento-->
            <div class="col-md-2">            
                <div class="mb-3">   
                    <label 
                        for="pessoaNascimento"><b class="obrigatorio">*</b> Nascimento: 
                    </label>                        
                    <input 
                        type="date" 
                        name="pessoaNascimento" 
                        id="pessoaNascimento" 
                        class="form-control <?php echo (!empty($data['pessoaNascimento_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php htmlout($data['pessoaNascimento']);?>"
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaNascimento_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->

            <!--pessoaCpf-->
            <div class="col-md-2">            
                <div class="mb-3">   
                    <label 
                        for="pessoaCpf"><b class="obrigatorio">*</b> CPF: 
                    </label>                        
                    <input 
                        type="text" 
                        name="pessoaCpf" 
                        id="pessoaCpf" 
                        class="form-control cpf <?php echo (!empty($data['pessoaCpf_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php htmlout($data['pessoaCpf']);?>"
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaCpf_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->

            <!--pessoaCnpj-->
            <div class="col-md-3">            
                <div class="mb-3">   
                    <label 
                        for="pessoaCnpj"><b class="obrigatorio">*</b> CNPJ: 
                    </label>                        
                    <input 
                        type="text" 
                        name="pessoaCnpj" 
                        id="pessoaCnpj" 
                        class="form-control cnpj <?php echo (!empty($data['pessoaCnpj_err'])) ? 'is-invalid' : ''; ?>"                             
                        value="<?php htmlout($data['pessoaCnpj']);?>"
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['pessoaCnpj_err']; ?>
                    </span>
                </div>           
            </div><!-- col -->       
        
        </div><!-- row -->

        <!-- QUARTA LINHA -->
        <div class="row">
            
            <!--pessoaDeficiencia-->
            <div class="form-group col-md-12">
                <div class="alert alert-warning" role="alert">
                <div class="checkbox checkbox-primary checkbox-inline">
                <input id="pessoaDeficiencia" type="checkbox" name="pessoaDeficiencia" value="s" >
                <label for="pessoaDeficiencia">
                    <strong>Pessoa com nnecessidades especiais?</strong>
                </label>
            </div><!-- col -->

        </div><!-- row -->    

    </fieldset><!-- fim do grup de dados 1 -->

    <!-- BOTÕES -->
    <div class="form-group mt-3 mb-3">
        <button type="submit" class="btn btn-success">Enviar</button>
        <a href="<?php echo URLROOT ?>/pessoas">
            <button type="button" class="btn bg-warning">Voltar</button>
        </a>
    </div>     
    
</form>





<!-- FOOTER -->
<?php require APPROOT . '/views/inc/footer.php'; ?>