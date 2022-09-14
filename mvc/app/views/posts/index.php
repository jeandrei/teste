<?php require APPROOT . '/views/inc/header.php';?>
<!-- message é o nome da menságem está lá no controller -->
<?php flash('message'); ?>
<!-- mb-3 marging bottom -->
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Postagens</h1>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary float-end">
            <i class="fa fa-pencil"></i> Adicionar Postagem
        </a>
    </div>
</div>

<?php foreach($data as $post) : ?>
    <div class="card card-body mb-3">

        <div class="row text-center mb-4">
            <h4 class="card-title"><?php echo $post['title']; ?></h4>
        </div>

        <?php if($post['image']->file) :?>
        <div class="row">
            <div class="col-sm-4">
                <img
                    src="data:image/jpeg;base64,<?php echo base64_encode($post['image']->file); ?>" width="375" height="250"
                    class="w-100 shadow-1-strong rounded mb-4"
                    alt="Boat on Calm Water"
                />
            </div>
            <div class="col-sm-8">  
                <p class="card-text"><?php echo $post['body']; ?></p>
            </div>
        </div> 
        <?php else: ?>  
            <div class="col-12">  
                <p class="card-text"><?php echo $post['body']; ?></p>
            </div>     
        <?php endif; ?>
        
        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post['id']; ?>" class="btn btn-dark">
        Visualizar este post - (<?php echo (($post['n_image'])>1)? $post['n_image'].' imagens':$post['n_image'].' imagem';?>)</a>  
        
        <div class="bg-light p-2 mb-3">
            Escrito por <?php echo $post['name']->name; ?> em <?php echo date('d/m/Y h:i:s', strtotime($post['created_at'])); ?>
        </div>
    
    </div>
<?php endforeach; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
