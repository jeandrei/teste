<?php require APPROOT . '/views/inc/header.php';?>    

<?php flash('message');  ?>



<!-- aqui para usar o mesmo arquivo addfile.php
a única coisa que muda do adicionar para o editar é o botão voltar
então eu verifico se editar eu imprimo a url /edit/id caso contário eu imprimo /posts -->
<?php if($_GET['btn'] == 'edit') : ?>
    <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']?>" class="btn btn-light"><i class="fa fa-backward"></i>Voltar</a>
<?php else :?>
    <a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i>Voltar</a>
<?php endif;?>
<div class="card card-body bg-light mt-5">       
<h2>Adicionar Arquivos ao Post</h2>  




<!-- Para funcionar o envio de arquivo aqui no form tem que ter enctype="multipart/form-data" -->
<form id="addFilePost" action="<?php echo URLROOT; ?>/posts/addfile/<?php echo $data['id'];?>" method="post" enctype="multipart/form-data" onsubmit="return Validate();">


    <!--TITLE-->
    <div class="form-group">   
        <label 
            for="title"><b class="obrigatorio">*</b> Título: 
        </label>                        
        <input 
            type="text" 
            name="title" 
            id="title" 
            placeholder="Informe um título para o arquivo",
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


    <!-- Adicionar arquivo-->
    <div class="row" style="margin:5px;">  
        <!-- Mensagem -->    
        <div class="alert alert-warning mt-2" role="alert">
            Arquivos permitidos com extenção <strong>jpg, png e pdf</strong>, e no máximo com <strong>20 MB</strong>.
        </div>
        <!-- Input file -->
        <div class="input-group mb-3">
            <label class="input-group-text" for="file_post">Upload</label>
            <input 
                type="file" 
                class="form-control" 
                id="file_post"
                name="file_post"                
            ><!-- A função fileValidation está no arquivo main.js-->                   
        </div><!--onchange="return fileValidation('file_post','file_post_err');" -->
        <!-- Span para caso tenha erros -->
        <span id="file_post_err" name="file_post_err" class="text-danger">
            <?php echo $data['file_post_err']; ?>
        </span>

    </div><!-- row -->            
    <!-- Fim Adicionar arquivo -->


    <input type="submit" class="btn btn-success" value="Enviar">




</form>
        
         

<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
/* valida apenas se não foi enviado nenhum arquivo, a validação do tipo do arquivo
é feita no evento onchange do input  fileValidation('file_post','file_post_err')*/
function Validate(){
   let file_post = document.getElementById('file_post').value;
   if(file_post == ""){
    document.getElementById("file_post_err").innerHTML = "Selecione um arquivo!";
    return false;
   } else {
       return true;
   }
   
}
</script>