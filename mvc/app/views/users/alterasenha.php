<?php require APPROOT . '/views/inc/header.php';?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-2">
                <h2>Alterar a Senha</h2>
                <p>Por favor informe sua nova senha</p> 
                <form id="alterarSenha" action="<?php echo URLROOT; ?>/users/alterasenha" method="post" enctype="multipart/form-data" onsubmit="return validation()">   
                                         
                    <!--PASSWORD-->
                    <div class="form-group mt-2">   
                        <label 
                            for="password"><b class="obrigatorio">*</b> Senha: 
                        </label>                        
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            placeholder="Informe sua senha",
                            class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"                             
                            value="<?php echo $data['password'];?>"
                        >
                        <span class="invalid-feedback">
                            <?php echo $data['password_err']; ?>
                        </span>
                    </div>

                    <!--CONFIRM PASSWORD-->
                    <div class="form-group mt-2">   
                        <label 
                            for="confirm_password"><b class="obrigatorio">*</b> Confirma Senha: 
                        </label>                        
                        <input 
                            type="password" 
                            name="confirm_password" 
                            id="confirm_password"
                            placeholder="Informe sua senha",
                            class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>"                             
                            value="<?php echo $data['confirm_password'];?>"
                        >
                        <span class="invalid-feedback">
                            <?php echo $data['confirm_password_err']; ?>
                        </span>
                    </div>
                                        
                    <!--BUTTONS-->
                    <div class="row mt-2">
                        <div class="col">                            
                            <button type="submit" class="btn btn-success btn-block">Salvar</button>                       
                        </div>                        
                    </div>

                </form>
            </div>
        </div>
    </div>   
<?php require APPROOT . '/views/inc/footer.php'; ?>
<!-- 
IMPORTANTE PARA FUNCIONAR O CONFIRM_PASSWORD 
TANTO O INPUT DO PASSWORD COMO O INPUT DO CONFIRM PASSWORD
TEM QUE TER ID
 -->
<script>  
 $(document).ready(function(){
	$('#alterarSenha').validate({
		rules : {			
			password : {
				required : true,
				minlength : 6,
				maxlength : 30
			},
			confirm_password : {
				required : true, 
				equalTo : '#password'
            }   
		},
		messages : {			
			password : {
				required : 'Por favor informe sua senha.',
				minlength : 'A senha deve ter, no mínimo, 6 caracteres.',
				maxlength : 'A senha deve ter, no máximo, 20 caracteres.'
			},
			confirm_password : {
				required : 'Confirme a sua senha.',
				equalTo : 'As senhas não se correspondem.'
            }
        }
    });
});
</script>