<!-- HEADER -->
<?php require APPROOT . '/views/inc/header.php';?>


<!-- LINHA PARA A MENSÁGEM DO JQUERY -->
<div class="container">
    <div class="row" style="height: 50px;  margin-bottom: 25px;">
        <div class="col-12">
            <div role="alert" id="messageBox" style="display:none"></div>
        </div>
    </div>
</div>

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
                <span class="text-danger" id="pessoaNome_err">
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
                <span class="text-danger" id="pessoaEmail_err">
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
                <span class="text-danger" id="pessoaTelefone_err">
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
                <span class="err text-danger" id="pessoaCelular_err">
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
                <span class="text-danger" id="pessoaMunicipio_err">
                    <?php echo $data['pessoaMunicipio_err']; ?>
                </span>
            </div>           
        </div><!-- col -->

    </div><!-- row -->
<fieldset class="bg-light p-2">



<button 
    type="button" 
    class="btn btn-success btn-sm gravar"   
>                    
Gravar
</button>


<script>
    $( document ).ready(function() {    
        $('.gravar').click(function() {
            //Pego os valores dos inputs 
            var pessoaNome=$("#pessoaNome").val();  
            var pessoaEmail=$("#pessoaEmail").val(); 
            var pessoaTelefone=$("#pessoaTelefone").val(); 
            var pessoaCelular=$("#pessoaCelular").val(); 
            var pessoaMunicipio=$("#pessoaMunicipio").val(); 
            $.ajax({
                /* aqui em url passamos a url do controler e o método que iremos utilizar nesse caso ajaxs/gravar */
                
                url: '<?php echo URLROOT; ?>/ajaxs/gravar',
                /* aqui o método que utilizamos nesse caso POST */
                method:'POST', 
                //Aqui passamos os dados que queremos através do POST para o controller/método
                data:{
                    pessoaNome:pessoaNome,
                    pessoaEmail:pessoaEmail,
                    pessoaTelefone:pessoaTelefone,
                    pessoaCelular:pessoaCelular,
                    pessoaMunicipio:pessoaMunicipio
                },                                                   
                /* em retorno_php sempre receberemos o que for passado na linha lá do controller
                em  echo json_encode($json_ret);
                que sempre vai ser um array similar a este:
                {"classe":"alert alert-success","mensagem":"Dados gravados com sucesso"}
                O que a linha JSON.parse(retorno_php) faz é possibilitar o acesso aos valores como:
                responseObj.classe e responseObj.mensagem
                  */                   
                success: function(retorno_php){                     
                    var responseObj = JSON.parse(retorno_php);  
                    //console.log(responseObj.error);
                    
                                       
                    //se o status for true quer dizer que a validação passou
                    //se for false a validação falhou
                    if(responseObj.error!==false){                                              
                        /**
                        IMPORTANTE TEM QUE TER ID NO SPAN PARA FUNCIONAR
                        aqui key traz a chave exemplo pessoaNome_err
                        e value traz o erro exemplo Por favor informe o nome
                        então na linha  $("#"+key) ele monta $("#pessoaNome_err")
                        para cada erro que tiver no array responseObj.error que vem
                        do controller
                        */ 
                        for (let [key, value] of entries(responseObj.error)) {                            
                            $("#"+key) 
                                .addClass("text-danger")
                                .html(value)  
                                .fadeIn(4000).fadeOut(4000)                                                                            
                        }
                    }                   
                    
                    
                    //aqui o exemplo de como seria sem o for
                    /* if(responseObj.error.pessoaNome_err){                        
                        $("#pessoaNome_err")
                            .addClass("text-danger")
                            .html(responseObj.error.pessoaNome_err)  
                            .fadeIn(4000).fadeOut(4000)                                
                     */

                    //#messageBox é a id da <div role="alert" id="messageBox"
                    $("#messageBox")
                        .removeClass()
                        /* aqui em addClass adiciono a classe que vem do php se sucesso ou danger */
                        /* pode adicionar mais classes se precisar ficaria assim .addClass("confirmbox "+responseObj.classe) */
                        .addClass(responseObj.classe) 
                        /* aqui a mensagem que vem la do php responseObj.mensagem */                       
                        .html(responseObj.message) 
                        .fadeIn(2000).fadeOut(2000);
                }
            });//Fecha o ajax
        });//Fecha o .gravar click
    });//Fecha document ready function



    //Função necessária para rodar esse for  for (let [key, value] of entries(responseObj.error)) {
    function* entries(obj) {
        for (let key of Object.keys(obj)) {
            yield [key, obj[key]];
        }
    }
</script>





<!-- FOOTER -->
<?php require APPROOT . '/views/inc/footer.php';?>