<?php
try {
  session_start();
} 
catch (Exception $erross){
  header('Location: http://portal2.capitalhumano.com.br/tela_nlog.php');      
}

include_once "func/funcoes.php";

$cp1 = 0;
$tiphole = 0;

if (isset($_SESSION['buscafeita'])):
    $col = $_SESSION['col'];
    $cad = $_SESSION['cad'];
    $emp = $_SESSION['emp'];
    $razemp = $_SESSION['razemp'];
    $codbanco = $_SESSION['codban'];
    $conbanco = $_SESSION['conban'];
    $digbanco = $_SESSION['digban'];
else:
    header('Location: https://portal.capitalhumano.com.br/tela_nlog.php');
endif;

if (isset($_POST['btn_sair'])){
  if(isset($_SESSION['buscafeita'])){
    $_SESSION = array();  
    session_regenerate_id();
    session_unset();
    session_destroy(); 
    header('Location: https://portal.capitalhumano.com.br/login.php');
  } 
}

if (($emp == 26) || ($emp == 201))
  $tiphole = 2;
else 
  $tiphole = 1;
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include '_headLogin.php'; ?>
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand">Portal - CH</a> 
                </div>
	       <form role="form" action="novoholerite.php" method="POST">
                <div style="color: white;
                     padding: 15px 50px 5px 50px;
                     float: right;
                     font-size: 16px;"><?php echo "Bem vindo(a), " . $col; ?> &nbsp; <button class="btn btn-danger square-btn-adjust" name="btn_sair">Sair</button> </div>
	       </form>	 
            </nav> 
            <input type="hidden" id="tiphole" value="<?php echo $tiphole;?>">
            <?php include '_menulateral.php'; ?>
            
            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Recibo de Pagamento</h2>   
                            <h5>Aqui você pode visualizar seu holerite.</h5>
                        </div>
                    </div>
                    <hr />
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Recibo de Pagamento
                        </div>
                        <div class="panel-body">
                            <form role="form" method="POST" action="novoholerite.php" id="formulario">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Competência Ref.</th>
                                                <th>Data do Pagamento</th>
                                                <th>Tipo do Pagamento</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            carregacb1html($emp,$cad,$tiphole);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>   							
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script>
  $('.btn_visu').click (function() {   
    var url = $(this).attr("href");
     if (document.getElementById("tiphole").value == 1)
       window.open(url,'pagina',"width=517, height=700, top=10, left=10, scrollbars=no");
     else
       window.open(url,'pagina',"width=542, height=780, top=10, left=10, scrollbars=no");  
    return false;
  });
</script>		
    </body>
</html>
