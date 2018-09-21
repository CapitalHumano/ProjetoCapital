<!-- /. NAV TOP  -->
<nav class="navbar-default navbar-side" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav" id="main-menu">
      <li class="text-center">
        <img src="imagens/ccb.png" class="user-image img-responsive"/>
      </li>
      <li>
        <a <?php if ($cp1 == 0) { echo "class=\"active-menu\""; } ?> href="novoholerite.php"><i class="fa fa-files-o fa-3x"></i> Recibo de Pagamento </a>
      </li>
      <?php if (($emp != 21) && ($emp != 253)){ ?>
      <li>
        <a <?php if ($cp1 == 1) { echo "class=\"active-menu\""; } ?> href="espelho_ponto.php"><i class="fa fa-clock-o fa-3x"></i> Espelho do Ponto </a>
      </li>
      <?php }?>
      <?php if ($emp == 17){ ?>
      <li>
        <a <?php if ($cp1 == 2) { echo "class=\"active-menu\""; } ?> href="informeteste1.php"><i class="fa fa-file-text fa-3x"></i> Informe de Rendimento </a>
      </li>
      <?php } ?>
      <li>
        <a <?php if ($cp1 == 3) { echo "class=\"active-menu\""; } ?> href="attcadastral.php"><i class="fa fa-pencil fa-3x"></i> Atualização Cadastral </a>
      </li>
      <?php if ($emp != 26) {?>
      <li>
        <a <?php if ($cp1 == 4) { echo "class=\"active-menu\"";} ?> href="relferias.php"><i class="fa fa-calendar fa-3x"></i> Períodos de Férias </a>
      </li> 
      <?php } ?>
  </div>          
</nav>       
<!-- /. NAV SIDE  -->