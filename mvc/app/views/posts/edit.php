<?php require APPROOT . '/views/inc/header.php';?>  
<style>
/* style do carrocel */
@media (min-width: 768px) {
  .carousel-inner {
    display: flex;
  }
  .carousel-item {
    margin-right: 0;
    flex: 0 0 33.333333%;
    display: block;
  }
}

.carousel-inner{
    padding: 1em;
}
.card{
    margin: 0 .5em;
    box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
    border: none;
}
.carousel-control-prev, .carousel-control-next{
    background-color: #e1e1e1;
    width: 6vh;
    height: 6vh;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
}
</style> 

<?php  flash('message'); ?>

    <a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i>Voltar</a>
    
    <div class="card card-body bg-light mt-5">       
        <h2>Edit Post</h2>
        <p>Create a post with this form</p>                               
        <form id="editPost" action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="post">  
                    
            <!--EMAIL-->
            <div class="form-group">   
                <label 
                    for="title"><b class="obrigatorio">*</b> Título: 
                </label>                        
                <input 
                    type="text" 
                    name="title"
                    id="title"  
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
                    for="password"><b class="obrigatorio">*</b> Texto: 
                </label>                        
                <textarea name="body" id="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body'];?></textarea>
                
                <span class="invalid-feedback">
                    <?php echo $data['body_err']; ?>
                </span>
            </div>

            <input type="submit" class="btn btn-success" value="Submit">
            <a href="<?php echo URLROOT;?>/posts/addfile/<?php echo $data['id'];?>&btn=edit" class="btn btn-success">Adicionar Arquivos</a>
            
        </form>


        <!-- se existir algum arquivo -->
        <?php if($data['files']) : ?>   
            <!-- Monta o carrocel -->
            <div id="carouselExampleControls" class="carousel" data-bs-ride="carousel">
                <div class="carousel-inner">             
                <?php $i=0;?>
                <?php foreach($data['files'] as $file) : ?>                 
                    <div class="carousel-item <?php echo ($i==0)?"active":""?>">
                    <div class="card">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($file["file"]); ?>" class="d-block w-100" alt="..." >
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $file['title'];?></h5>
                            <p class="card-text"><?php echo $file['body'];?></p>
                            <a href="<?php echo URLROOT; ?>/posts/delfile/<?php echo $file['id'];?>" class="btn btn-danger">Excluir</a>
                        </div>
                    </div>                  
                    </div>
                <?php $i=1;?>
                <?php endforeach; ?>                
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <!-- fim carrocel -->
        <?php endif;?>
    </div>          
<?php require APPROOT . '/views/inc/footer.php'; ?>
<script>
/* jquery do carrocel 
fonte: https://codingyaar.com/bootstrap-carousel-multiple-items-increment-by-1/*/
var carouselWidth = $(".carousel-inner")[0].scrollWidth;
var cardWidth = $(".carousel-item").width();
var scrollPosition = 0;

$(".carousel-control-next").on("click", function () {
  if (scrollPosition < (carouselWidth - cardWidth * 4)) { //check if you can go any further
    scrollPosition += cardWidth;  //update scroll position
    $(".carousel-inner").animate({ scrollLeft: scrollPosition },600); //scroll left
  }
});

$(".carousel-control-prev").on("click", function () {
  if (scrollPosition > 0) {
    scrollPosition -= cardWidth;
    $(".carousel-inner").animate(
      { scrollLeft: scrollPosition },
      600
    );
  }
});

var multipleCardCarousel = document.querySelector(
  "#carouselExampleControls"
);
if (window.matchMedia("(min-width: 768px)").matches) {
  //rest of the code
  var carousel = new bootstrap.Carousel(multipleCardCarousel, {
    interval: false
  });
} else {
  $(multipleCardCarousel).addClass("slide");
}

</script>



<script>  
 $(document).ready(function(){
	$('#editPost').validate({
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