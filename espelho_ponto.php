<?php
session_start();
include_once "func/funcoes.php";
$cp1 = 1;

if (isset($_SESSION['buscafeita'])){
  $col = $_SESSION['col'];
  $cad = $_SESSION['cad'];
  $emp = $_SESSION['emp'];
  $razemp = $_SESSION['razemp'];
  $codbanco = $_SESSION['codban'];
  $conbanco = $_SESSION['conban'];
  $digbanco = $_SESSION['digban'];
  $codesc = $_SESSION['codesc'];
  
  if (($emp == 21) || ($emp == 253))
    header('Location: http://portal.capitalhumano.com.br/tela_nlog.php');
}
else{
  header('Location: http://portal.capitalhumano.com.br/tela_nlog.php');
}

if (isset($_POST['btn_sair'])){
  if(isset($_SESSION['buscafeita'])){
    $_SESSION = array();  
    session_unset();
    header('Location: http://portal.capitalhumano.com.br/login.php');
  } 
}

if (isset($_POST['btn_voltames'])){   
  $cphj = carregaep($emp);   
  $alterabotao = 0; 
}

if (isset($_POST['btn_mesant'])){   
  $codcal = carregaep($emp);   
  $cphj = carregaepant($emp, $codcal[0]['CODCAL']);
  $alterabotao = 1;
} else {
  $cphj = carregaep($emp);
}

$lista_apu = retornaapu($cad, $emp, 1, $cphj[0]['INIAPU'], $cphj[0]['FIMAPU']);
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
                <form role="form" action="espelho_ponto.php" method="POST">                  
                <div style="color: white;
                  padding: 15px 50px 5px 50px;
                  float: right;
                  font-size: 16px;"><?php echo "Bem vindo(a), " . $col; ?> &nbsp; <button class="btn btn-danger square-btn-adjust" name="btn_sair">Sair</button> </div>
		</form>	 
            </nav>
            
            <?php include '_menulateral.php'; ?>
            
            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Espelho do Ponto</h2>   
                            <h5>Aqui você pode verificar suas marcações do ponto.</h5>
                        </div>
                    </div>                   
                    <hr />
                    <form role="form" method="POST" action="espelho_ponto.php" id="formulario">
                    <div class="row">
                      <div class="col-md-12">
                          <?php if ($alterabotao == 0) {?>
                          <h5> <button class="btn btn-default" name="btn_mesant">Apuração Anterior</button>   
                               <button class="btn btn-default" name="btn_mesant" disabled="">Apuração Atual</button> / Consultar Marcações </h5>  <br>
                          <?php } else {?> 
                          <h5> <button class="btn btn-default" name="btn_voltames" disabled >Apuração Anterior</button> 
                               <button class="btn btn-default" name="btn_voltames">Apuração Atual</button> / Consultar Marcações </h5> <br>
                          <?php } ?>    
                      </div>
                    </div> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <?php if ($alterabotao == 0) echo "Mês Atual"; else echo "Mês Anterior"; ?>
                        </div>
                        <div class="panel-body">                            
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Dia Sem.</th>
                                                <th>Marcações &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</th>
                                                <th>Ajuste</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php for ($i=0; $i < count($lista_apu); $i++) { ?>    
                                          <tr class="odd gradeX">
                                            <td><?php $dtapu = gambmonstra($lista_apu[$i]['DATAPU'], 2); echo $dtapu?></td> 
                                            <td><?php echo diasemana($lista_apu[$i]['DATAPU']);?></td>
                                            <td><?php echo montamarc($cad, $emp, 1, $lista_apu[$i]['HORDAT'], $lista_apu[$i]['DATAPU']); ?></td>
                                            <td align="center"> <input type="checkbox" name="chb[]" value="<?php echo $dtapu ?>"/> </td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
                                          </tr>
                                        <?php } ?>    
                                        </tbody>
                                    </table>
                                </div> 
                            <div align="right"> <button align="right" class="btn btn-primary" name="gera_inf"> Gerar Justificativa </button> </div>
                          <?php 
                            if (isset($_POST['gera_inf'])){
    
                                if (isset($_POST['chb'])){
                                  for($j = 0; $j < count($_POST['chb']); $j++){
                                   $datasap .= $j."=".$_POST['chb'][$j]."&";                                      
                                                                              }                                         
                                   echo "<script> window.location=\"justificativa.php?".$datasap."\" </script>";      
                                                         }                                                       
                                                          }
                          ?>
                        </div>
                      </form> 
                    </div>
                </div>
            </div>	
    </body>
</html>