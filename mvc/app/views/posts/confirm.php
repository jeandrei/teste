<?php require APPROOT . '/views/inc/header.php';?>
<main>
  
    <h2 class="mt-2">Excluir Post</h2>

    <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['id']; ?>" method="post">
        <div class="form-group">
            <p>Você deseja realmente excluir o post?</p>
            <p><strong><?php echo $data['title']; ?></strong></p>
        </div>

        <div class="form-group mt-3">
        
        <a href="<?php echo URLROOT ?>/posts">
            <button type="button" class="btn btn-success">Cancelar</button>
        </a>
        
            <button type="submit" name="delete" id="delete" class="btn btn-danger">Excluir</button>
        </div>
        

    </form>

</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>