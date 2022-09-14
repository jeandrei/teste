<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <?php // Segunda parte da menságem        
            flash('message');
            ?>
            <h2>Recuperação de senha</h2>
            <p>Por favor informe seu email</p>
            <form id="enviarSenha" action="<?php echo URLROOT; ?>/users/enviasenha" method="post" enctype="multipart/form-data">
                
                <!--EMAIL-->
                <div class="form-group">   
                    <label 
                        for="email"><b class="obrigatorio">*</b> Email: 
                    </label>                        
                    <input 
                        type="text" 
                        name="email" 
                        id="email" 
                        class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"                             
                        placeholder="Informe seu email",
                        value="<?php echo $data['email'];?>"
                    >
                    <span class="invalid-feedback">
                        <?php echo $data['email_err']; ?>
                    </span>
                </div>
                
                <!--BUTTONS-->
                <div class="row mt-3">
                    <div class="col">
                    <button type="submit" class="btn btn-success btn-block">Eviar a senha para meu e-mail</button>                          
                    </div>                         
                </div> 
                
            </form>
        </div>
    </div>
</div>        
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>  
 $(document).ready(function(){
	$('#enviarSenha').validate({
		rules : {			
			email : {
				required : true,
				email : true
			}		  
		},
		messages : {			
			email : {
				required : 'Por favor informe o seu e-mail.',
				email : 'Informe um e-mail válido.'
			}		
        }
    });
});
</script>
