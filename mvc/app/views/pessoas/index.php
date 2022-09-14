<!-- HEADER -->
<?php require APPROOT . '/views/inc/header.php';?>


<script>
/**
 * Funções para manipulação do formulário
 * limpar - limpa os campos com valores do formulário
 * focofield - seta o foco em um campo do formulário
 * 
 */
function limpar(){
        document.getElementById('pessoaNome').value = "";                
        focofield("pessoaNome");
    }    
    
    window.onload = function(){
        focofield("pessoaNome");
    }     

</script>




<!-- FLASH MESSAGE -->
<!-- pessoa_message é o nome da menságem está lá no controller -->
<?php flash('message'); ?>
<!-- mb-3 marging bottom -->



<!-- ADD NEW -->
<div class="row mb-3">
    <div class="col-md-6">
        <h1><?php echo $data['titulo']; ?></h1>
    </div>  

    <div class="col-md-6">
        <a href="<?php echo URLROOT; ?>/pessoas/add" class="btn btn-primary float-end">
            <i class="fa fa-pencil"></i> Adicionar Pessoa
        </a>
    </div>
</div>


<!-- FORMULÁRIO -->
<form id="filtrar" action="<?php echo URLROOT; ?>/pessoas/index" method="get" enctype="multipart/form-data">
  <div class="row mt-2">
    <div class="col-md-3">
      <label for="pessoaNome">
        Buscar por Nome:
      </label>
      <input
        type="text"
        name="pessoaNome"
        id="pessoaNome"
        class="form-control"
        value="<?php echo $_GET['pessoaNome'];?>"
      >
      <span class="invalid-feedback">

      </span>
    </div>


    <div class="col-md-3">
      <label for="pessoaMunicipio">
        Buscar por Município:
      </label>
      <input
        type="text"
        name="pessoaMunicipio"
        id="pessoaMunicipio"
        class="form-control"
        value="<?php echo $_GET['pessoaMunicipio'];?>"
      >
      <span class="invalid-feedback">

      </span>
    </div>
  </div> 
  
  <div class="col-md-6 align-self-end mt-2" style="padding-left:5;">
           
      <input type="submit" class="btn btn-primary" value="Atualizar">                   
      <input type="button" class="btn btn-primary" value="Limpar" onClick="limpar()">       
                                                       
  </div> 
  
  <!-- Número de registros por página -->
  <div class="row align-items-center">
    <div class="col-10">
     <span class="float-end">Número de Linhas:</span>
    </div>
    <div class="col-2">
      <select class="form-select" name="numRows">
        <?php
        for($i=1;$i<=10;$i++){
          $val = $i * 10;
          if($val == $_SESSION['numRows']){            
            echo "<option value='$val' selected>$val</option>";
          } else {
            echo "<option value='$val'>$val</option>";
          }
            
        }
        ?>
      </select>     
    </div>
    
  </div>

</form>






<?php 


$results = '';
if(!empty($data['results'])){
  foreach($data['results'] as $row){
    $results.='<tr>
                  <td>'.$row['pessoaNome'].'</td>
                  <td>'.$row['pessoaNascimento'].'</td>
                  <td>'.$row['pessoaMunicipio'].'</td>
                  <td>'.$row['pessoaLogradouro'].'</td>
                  <td>
                      <input 
                          type=text 
                          class=form-control
                          name=observacao
                          onkeyup=update(this.id,this.value)
                          id='.$row['pessoaId'].'
                          value='.$row['pessoaObservacao'].'                         
                      >
                      <span id='.$row['pessoaId'].'_msg>
                  </td>
                  <td>'.$row['pessoaDeficiencia'].'</td>
                  <td>
                    <a href="'.URLROOT.'/pessoas/edit/'.$row['pessoaId'].'">
                      <buton type="button" class="btn btn-primary">Editar</button>
                    </a>
                    <a href="'.URLROOT.'/pessoas/delete/'.$row['pessoaId'].'">
                      <buton type="button" class="btn btn-danger">Excluir</button>
                    </a>
                  </td>
                 
                </tr>
              ';
  }
}else {
  $results = '<tr>
  <td colspan="7" class="text-center">
      Nenhuma vaga encontrada
  </td>';  
}   
 

?>



<!-- TABELA -->
<table class="table table-striped">
  <thead>
    <tr>      
      <th scope="col">Nome</th>
      <th scope="col">Nascimento</th>
      <th scope="col">Municipio</th>
      <th scope="col">Logradouro</th>
      <th scope="col">Observação</th>
      <th scope="col">PCD</th>
      <th scope="col">Ações</th>      
    </tr>
  </thead>
  <tbody>
      <?php echo $results; ?>
  </tbody>
</table>




<!-- PAGINAÇÃO -->
<?php
    $pagination = $data['pagination'];     
    // no index a parte da paginação é só essa    
    echo '<p>'.$pagination->links_html.'</p>';   
    echo '<p style="clear: left; padding-top: 10px;">Total de Registros: '.$pagination->total_results.'</p>';   
    echo '<p>Total de Paginas: '.$pagination->total_pages.'</p>';
    echo '<p style="clear: left; padding-top: 10px; padding-bottom: 10px;">-----------------------------------</p>';
?>



<!-- FOOTER -->
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
  /* script executa a cada 3 segundos a variavel timer e a 
    constante waitTimer tem que ficar fora da função */
  let timer;
  const waitTimer = 3000;
  function update(id,data){
    /**
     * Toda vez que o usuário digita alguma coisa, qualquer tecla a primeria cois
     * que entra na função é redefinir a variável timer que recebe o que será 
     * executado no setTimeout, então fica nesse looping cada vez que o usuário digita alguma coisa
     * a variável timer é rezetada e o setTimeout inicia a contagem de três segundos
     * se tiver no dois segundos e o usuário digitar algo reinicia a contagem pois timer é zerado
     * só se efetiva a operação quando da 3 segundos e a variável timer recebe o valor do
     * setTimeout
     * 
     */
    clearTimeout(timer);
    /* depois de 3 segundos executa a função */
    timer = setTimeout(function(){ 
      $(document).ready(function() { 
          $.ajax({
              //para que controller os dados serão enviados
              url: '<?php echo URLROOT; ?>/pessoas/gravaobs',
              //O método que será usado, nesse caso post
              method:'POST',
              //os dados que serão passados através do post no controller para pegar é só
              //usar o post $id=$_POST['id'] 
              data:{
                  id:id,
                  data:data
              },
              success: function(retorno_php){
                //retorno_php vem através do echo no controller
                var responseObj = JSON.parse(retorno_php);
                /* lá no span eu monto o id sendo id_msg exemplo id=4 fica 4_msg
                então aqui eu monto a string para alterar o valor do span $("#4_msg") */
                $("#"+id+"_msg")
                //removo todas as classes
                .removeClass()
                //adiciono a classe que vem da resposta la do arquivo do controller\pessoas\gravaobs()
                .addClass(responseObj.classe) 
                //adiciono o texto que vem de retorno do controller\pessoas\gravaobs()
                .html(responseObj.message) 
                //defino um tempo para dar a mensagem nesse caso para aparecer 2 segundos e sumir 4
                .fadeIn(2000).fadeOut(4000);                
              }//sucess
          });//Fecha o ajax  
      });//Fecha document ready function
    }, waitTimer);//feche timer = setTimeout
    
  }
</script>