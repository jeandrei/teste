<?php require APPROOT . '/views/inc/header.php';?>
<main>
  
    <h2 class="mt-2">Excluir Pessoa</h2>

    <form action="<?php echo URLROOT; ?>/pessoas/delete/<?php echo $data->pessoaId;?>" method="post" enctype="multipart/form-data">
        
        <div class="form-group">
            <p>Você deseja realmente excluir a Pessoa <strong><?php echo $data->pessoaNome; ?>?</strong></p>
        </div>  
        
        <div class="form-group mt-3">
        
            <a class="btn btn-success" href="<?php echo URLROOT ?>/pessoas">
            Cancelar
            </a>
        
            <button type="submit" name="delete" id="delete" class="btn btn-danger">Excluir</button>
        </div>

    </form>

</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>