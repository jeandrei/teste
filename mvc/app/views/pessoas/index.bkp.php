<?php require APPROOT . '/views/inc/header.php';?>

<!-- pessoa_message é o nome da menságem está lá no controller -->
<?php flash('pessoa_message'); ?>
<!-- mb-3 marging bottom -->

<div class="row mb-3">
    <div class="col-md-6">
        <h1><?php echo $data['titulo']; ?></h1>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT; ?>/pessoas/add" class="btn btn-primary pull-right">
            <i class="fa fa-pencil"></i> Adicionar Pessoa
        </a>
    </div>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Nascimento</th>
      <th scope="col">Municipio</th>
      <th scope="col">Logradouro</th>
      <th scope="col">Bairro</th>
      <th scope="col">PCD</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $i=0; 
  foreach($data['results'] as $pessoa) : ?>
    <tr>
      <th scope="row"><?php $i++; echo $i;?></th>
      <td><?php echo $pessoa['pessoaNome']; ?></td>
      <td><?php echo $pessoa['pessoaNascimento'];?></td>
      <td><?php echo $pessoa['pessoaMunicipio']; ?></td>
      <td><?php echo $pessoa['pessoaLogradouro']; ?></td>
      <td><?php echo $pessoa['pessoaBairro']; ?></td>
      <td><?php echo $pessoa['pessoaDeficiencia']; ?></td>      
    </tr> 
  <?php endforeach; ?>  
  </tbody>
</table>



<?php require APPROOT . '/views/inc/footer.php'; ?>