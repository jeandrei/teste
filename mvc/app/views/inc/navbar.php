<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    
    <a class="navbar-brand" href="<?php echo URLROOT; ?>/posts"><?php echo SITENAME; ?></a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav flex-grow-1">
          
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/pages/index">Ver Minha Página</a>
          </li>

          <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/pages/about">Sobre</a>
          </li> 

          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Javascript
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">                
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/javascript/basico">Basico</a>
              </div>
          </li>
        
          
          <?php if(isset($_SESSION[SE.'user_id'])) : ?>  
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Cadastros
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/pessoas">Exemplo de Cadastro Paginação Classe</a>
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/datatables">Datatable MVC</a>
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/datatabledetails">Datatable MVC Detail Row</a>
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/ajaxs">Ajax</a>
                <a class="dropdown-item" href="<?php echo URLROOT; ?>/combodinamicos">Combo Dinâmico</a>             
              </div>
            </li>
          <?php endif; ?>         

           
          <div class="navbar-nav ms-auto"> 
          
          <?php if(isset($_SESSION[SE.'user_id'])) : ?>  
            <!-- DROPDOWN -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Bem vindo <?php echo $_SESSION[SE.'user_name']; ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?php echo URLROOT; ?>/users/alterasenha">Alterar a senha</a>
            </li>   
            <!-- DROPDOWN -->
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Sair</a>
            </li>          
          <?php else : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Se registrar</a>
            </li>
          <?php endif; ?>                           
                    
            
            <!-- 
            <li class="nav-item">
              <a class="nav-link" href="/logout">Logout</a>
            </li>
            -->     
          </div>               
      </ul>
    </div>
  </div>
</nav>