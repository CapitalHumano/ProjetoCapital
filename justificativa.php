<?php 
session_start();
include_once "func/funcoes.php";
$cont = 0;

if (isset($_SESSION['buscafeita'])):
  $col = $_SESSION['col'];
  $cad = $_SESSION['cad'];
  $emp = $_SESSION['emp'];
  $razemp = $_SESSION['razemp'];
  $codbanco = $_SESSION['codban'];
  $conbanco = $_SESSION['conban'];
  $digbanco = $_SESSION['digban'];
  $codesc = $_SESSION['codesc'];
else:
  header('Location: http://portal.capitalhumano.com.br/tela_nlog.php');
endif;

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title> </title>
        <!-- BOOTSTRAP STYLES-->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
        <link href="assets/css/custom.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
        
        <style media="print">
          .noprint { display:none; }
        </style>
        
        <title> Justificativa do Ponto </title>
    </head>
    <body>
        <div class="noprint"> <b> Para imprimir as justificativas,</b> <a href ="javascript:window.print()">Clique aqui</a>.
    <hr />
        </div>
    
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        JUSTIFICATIVA DO PONTO <?php echo "(".date("d/m/Y").")";?>
                    </div>
                    <div class="panel-body">
                        <label> Empresa: </label> <text> <?php echo $razemp; ?> </text>
                        <br />
                        <label> RE - Colaborador: </label> <text> <?php echo $cad." - ".$col; ?> </text> 
                    </div>
                    <div class="panel-body">
                       <?php while (isset($_GET[$cont])){ ?> 
                        
                        <div class="col-md-12 col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    (<?php echo $_GET[$cont]?>) - <b>Marcações:</b> 
                                    <?php                                     
                                      $diahor = retcodhordia($cad, $emp, 1, databanco($_GET[$cont]));
                                      $dtmec = databanco($_GET[$cont]);
                                    
                                    if (empty($diahor)){
                                      $diahor = retcodhordia($cad, $emp, 1, databanco3($_GET[$cont]));
                                      $dtmec = databanco3($_GET[$cont]);                                      
                                    }
                                    
                                    // Verifica novamente, caso tenha ficado vazio ainda // 
                                    if(empty($diahor)){
                                      $diahor = retcodhordia($cad, $emp, 1, databanco4($_GET[$cont]));
                                      $dtmec = databanco4($_GET[$cont]); 
                                    }
 
                                    echo montamarc($cad, $emp, 1, $diahor[0]['HORDAT'], $dtmec); ?>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">                                           
                                        <label class="checkbox-inline">
                                            <input type="checkbox"/> Falta
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox"/> Falta de marcação
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox"/> Atraso
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox"/> Saída Antecipada
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox"/> Outro: <input type="text" maxlength="19"/>
                                        </label>
                                    </div>
                                    <label> Justificativas </label>
                                    <input type="text" class="form-control" maxlength="144"/>                                   
<!--                                <p style="border-top: 0px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
                                    <p style="border-top: 1px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
                                    <p style="border-top: 1px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>     -->
                                </div>
                            </div>
                        </div>
                       <?php 
                       $cont++;
                       } ?>
                        
                        <div class="col-md-6 col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading" align="center">
                                    _________________________________________________ <br>
                                    <?php echo $cad." - ".$col; ?> 
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading" align="center">
                                    _________________________________________________ <br>
                                    <?php echo $razemp; ?>
                                </div>                                
                            </div>
                        </div>                        
                    </div>  
                </div>
            </div>
        </div>  
    

        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- JQUERY SCRIPTS -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="assets/js/jquery.metisMenu.js"></script>
        <!-- CUSTOM SCRIPTS -->
        <script src="assets/js/custom.js"></script>
    </body>
</html>