<?php 
session_start();
include_once "func/funcoes.php";
include_once "_modal_ferias.php";

$cp1 = 4;
$msg = '';

if (isset($_SESSION['buscafeita'])){
  $col = $_SESSION['col'];
  $cad = $_SESSION['cad'];
  $emp = $_SESSION['emp'];
  $razemp = $_SESSION['razemp'];
  
  if (($emp == 21) || ($emp == 253))
    header('Location: http://portal.capitalhumano.com.br/tela_nlog.php');
}
else{
  header('Location: http://portal.capitalhumano.com.br/tela_nlog.php');
}

$listafer = retornaPerFerias($emp, 1, $cad);

for ($j=0; $j < count($listafer); $j++){
  if(isset($_POST['exc'.$j])){     
      $datasug = DateTime::createFromFormat('d/m/Y', $_POST['datModalSolicitar'.$j]);
      $dthoje = Datetime::createFromFormat('d/m/Y', date('d/m/Y'));
            
      if(!isset($_POST['datModalSolicitar'.$j]))
        $msg = 'Data Incorreta.';
      else if (is_null($_POST['datModalSolicitar'.$j]) || $_POST['datModalSolicitar'.$j] == 0)
        $msg = 'Data deve ser preenchida.';
      else if ($datasug < $dthoje)
        $msg = 'Data deve ser superior a data de hoje.';
      else if (!filter_var($_POST['emaModalSolicitar'.$j], FILTER_VALIDATE_EMAIL))
        $msg = 'E-mail inválido.';
      else if (!filter_var($_POST['ccModalSolicitar'.$j], FILTER_VALIDATE_EMAIL) && $_POST['ccModalSolicitar'.$j] !== '')
        $msg = 'E-mail cópia inválido.';               
      else {       
        $msg = enviaremail($_POST['emaModalSolicitar'.$j],$_POST['datModalSolicitar'.$j], $_POST['ccModalSolicitar'.$j], $col, 
                           $listafer[$j]['INIPER'], $listafer[$j]['FIMPER'],$listafer[$j]['QTDDIR'], $listafer[$j]['QTDDEB'], 
                           $listafer[$j]['QTDSLD'], $listafer[$j]['DATLIM']);  
      }
  }    
}
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
                <form role="form" action="relferias.php" method="POST">
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
                            <h2>Períodos de Férias</h2>   
                            <h5><b>Para garantir o cumprimento dos prazos legais, favor solicitar a programação das férias que já se encontram vencidas.</b></h5>
                        </div>
                    </div>
                    <hr />
                    <div class="panel panel-default">                       
                        <div class="panel-body">
                            <form role="form" method="POST" action="relferias.php" id="formulario">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Data Início</th>
                                                <th>Data Fim</th>
                                                <th>Dias Direito</th>
                                                <th>Dias Débito</th>
                                                <th>Dias Saldo</th>
                                                <th>Data Limite</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>                                          
                                        <?php for($i=0;$i < count($listafer);$i++){ ?>
                                          <tr class="odd gradeX">
                                              <td><?php echo $listafer[$i]['INIPER'];?></td>
                                              <td><?php echo $listafer[$i]['FIMPER'];?></td>
                                              <td><?php echo $listafer[$i]['QTDDIR'];?></td>
                                              <td><?php echo $listafer[$i]['QTDDEB'];?></td>
                                              <td><?php echo $listafer[$i]['QTDSLD'];?></td>
                                              <td><?php echo $listafer[$i]['DATLIM'];?></td>
                                              <td align="center"><a href class="btn btn-success" data-toggle="modal" data-target="<?php echo '#ModalSolicitar'.$i; ?>">
                                                                 Solicitar
                                                                 </a>
                                              <?php echo retornamodal("exc".$i, "ModalSolicitar".$i, "cc".$i);?>    
                                              </td>                                         
                                          </tr>
                                        <?php }?>                                                                                                                                                                        
                                        </tbody>
                                    </table>
                                </div>
                            </form>  
                         <?php if (($msg !== '') && ($msg !== 1)){?>
                           <div class="alert alert-danger">
                             <?php echo $msg; ?>  
                           </div>  
                         <?php } else if ($msg == 1){ ?>
                            <div class="alert alert-success">
                             <?php echo "E-mail enviado com sucesso !"; ?>  
                           </div>                             
                         <?php } ?>   
                        </div>                     
                    </div>                 
                </div>
            </div>
        </div>
      <script> 
        $('#datModalSolicitar0').mask('99/99/9999');
        $('#datModalSolicitar1').mask('99/99/9999');
        $('#datModalSolicitar2').mask('99/99/9999');
        $('#datModalSolicitar3').mask('99/99/9999');
        $('#datModalSolicitar4').mask('99/99/9999');
      </script>       
    </body>
</html>