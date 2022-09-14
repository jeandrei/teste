<?php require APPROOT . '/views/inc/header.php';?>    

    
    <?php 
    
    flash('message'); 
    
    ?>

    <a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i>Voltar</a>
    <div class="card card-body bg-light mt-5">       
        <h2>Adicionar Postagem</h2>
        <p>Crie um Postagem</p>                               
         <!-- Para funcionar o envio de arquivo aqui no form tem que ter enctype="multipart/form-data" -->
         <form id="addPost" action="<?php echo URLROOT; ?>/posts/add" method="post" enctype="multipart/form-data">  
                  
                      
            <!--TITLE-->
            <div class="form-group">   
                <label 
                    for="title"><b class="obrigatorio">*</b> Título: 
                </label>                        
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    placeholder="Informe um título para o post",
                    class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>"                             
                    value="<?php echo $data['title'];?>"
                >
                <span class="invalid-feedback">
                    <?php echo $data['title_err']; ?>
                </span>
            </div>

            <!--Body-->
            <div class="form-group">   
                <label 
                    for="body"><b class="obrigatorio">*</b> Texto: 
                </label>                        
                <textarea name="body" id="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body'];?></textarea>
                
                <span class="invalid-feedback">
                    <?php echo $data['body_err']; ?>
                </span>
            </div>

           
            

             <!-- SE JÁ EXISTE O POST DAMOS A OPÇÃO DE ADICIONAR ARQUIVOS -->
            <?php if (isset($data['lastId'])) : ?>
               <a href="<?php echo URLROOT;?>/posts/addfile/<?php echo $data['lastId'];?>" class="btn btn-success">Adicionar Arquivos</a>
            <?php else:?>
            <!-- CASO NÃO TENHA LASTID O USUÁRIO NÃO ADICIONOU O POST AINDA ENTÃO DAMOS A OPÇÃO DE EIVIAR -->
             <input type="submit" class="btn btn-success" value="Enviar">
            <?php endif; ?>
          
            
        </form>
    </div>          
<?php require APPROOT . '/views/inc/footer.php'; ?>

<!-- custommsg está no main.js -->
<script> 
 $(document).ready(function(){
	$('#addPost').validate({
		rules : {
			title : {
				required : true,
				minlength : 3
			},
            body : {
				required : true,
				minlength : 30
			}   
		},
		messages : {
			title : {
				required : custommsg['required'],
				minlength : custommsg['minlength'] + ' {0} caracteres!'
			},
            body : {
				required : custommsg['required'],
				minlength : custommsg['minlength'] + ' {0} caracteres!'
			}
        }
    });
});
</script>