<?php
session_start();
include_once "func/funcoes.php";

  $codemp = ''; 
  $numcad = '';
  $numcpf = '';
  $numcid = '';
  $datnas = '';
  $nommae = '';	
  $verifica = '';

if (isset($_POST['btn_prosseguir'])) { 	
  $codemp = $_POST['codemp'];
  $numcad = $_POST['numcad'];
  $numcpf = $_POST['numcpf'];
  $numcid = $_POST['numcid'];
  $datnas = $_POST['datnas'];
  $nommae = $_POST['nommae'];

  $vd = VerificaDemitido($numcad,$codemp);	
  if ($vd == ''){

    $numcpf = AjustaCPF($numcpf);
    $numcid = str_replace("." , "" , $numcid);
    $numcid = str_replace("-" , "" , $numcid);	
	
    $ajustarg = AjustaRG1($numcad,$codemp);
    $rgcorreto = $ajustarg[0]['NUMCID'];
    $rgcorreto = str_replace("." , "" , $rgcorreto);
    $rgcorreto = str_replace("-" , "" , $rgcorreto);
    $rgcorreto = str_replace(";" , "" , $rgcorreto);
	
    if($rgcorreto == $numcid)
      $verifica = verDadosSenha($numcad, $codemp, $numcpf, $datnas, TratarString($nommae));
    else
      $verifica = 'Acesso negado: Informações incorretas;';
                }
  else 
    $verifica = $vd;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include '_headLogin.php'; ?>
    </head>
    <body>
        <div class="container">
            <div class="row text-center  ">
                <div class="col-md-12">
                    <br /><br />
                    <img src="imagens/cc.png"></src>
                        <h5>(Acesso ao Portal Capital Humano)</h5>
                        <br />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>  Novo usuário ou perdeu a senha ? </strong>  
                        </div>
                        <div class="panel-body">
                            <form role="form" method="POST" action="confirmadados.php" id="formulario">
                                <br/>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-building"  ></i></span>
                                    <input id="codemp" name="codemp" type="text" class="form-control" placeholder="Código da Empresa" value="<?php echo $codemp ?>" maxlength="4" OnKeyDown='return SomenteNumero(event)'/>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                    <input id="numcad" name="numcad" type="text" class="form-control" placeholder="Código do Usuário (Matrícula/RE)" value="<?php echo $numcad ?>" maxlength="15" OnKeyDown='return SomenteNumero(event)'/>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-bars"  ></i></span>
                                    <input id="numcpf" name="numcpf" type="text" class="form-control" placeholder="CPF" value="<?php echo $numcpf ?>" maxlength="14" OnKeyDown='return SomenteNumero(event)'/>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                                    <input id="numcid" name="numcid" type="text" class="form-control" placeholder="RG (Somente Números)" value="<?php echo $numcid ?>" maxlength="15" OnKeyDown='return SomenteNumero(event)'/>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"  ></i></span>
                                    <input id="datnas" name="datnas" type="text" class="form-control" placeholder="Data de Nascimento" value="<?php echo $datnas ?>"/>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-female"  ></i></span>
                                    <input id="nommae" name="nommae" type="text" class="form-control" placeholder="Nome da mãe (Completo)" value="<?php echo $nommae ?>" maxlength="40"/>
                                </div>
                                <button class="btn btn-primary" name="btn_prosseguir">Prosseguir</button>
                                <?php if ($verifica <> '') { ?>
                                    <br />
                                    <br />
                                    <div class="alert alert-danger alert-dismissable">
                                        <?php echo $verifica ?>
                                    </div>																													
                                <?php } ?>
                                <hr />                               
                                  Já possui senha ?  <a href="login.php" >Acesse Aqui</a>                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
	    $('#datnas').mask('99/99/9999');
	    $('#numcpf').mask('999.999.999-99');		
		
            $("#formulario").submit (function() {
                var ret = 0;
                var msg = 'Preencher os campos obrigatórios: \n';
                
                if($('#codemp').val().trim() == ''){
                    ret = 1;
                    msg += '\n Código da Empresa';                                  
                }
				
                if($('#numcad').val().trim() == ''){
                    ret = 1;
                    msg += '\n Código do Colaborador';                                  
                }
				
                if($('#numcpf').val().trim() == ''){
                    ret = 1;
                    msg += '\n Número do CPF';                                  
                }
				
                if($('#numcid').val().trim() == ''){
                    ret = 1;
                    msg += '\n Número do RG';                                  
                }
				
                if($('#datnas').val().trim() == ''){
                    ret = 1;
                    msg += '\n Data de Nascimento';                                  
                }
				
                if($('#nommae').val().trim() == ''){
                    ret = 1;
                    msg += '\n Nome da Mãe';                                  
                }
                
                if(ret == 1){
                    alert(msg);
                    return false;
                }
            });
			
            function SomenteNumero(e) {

                var tecla;
                if (e.which) 
                    tecla = e.which;          
                else 
                    tecla = e.keyCode;
       
                if ((tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105) || (e.which == 8) || (e.which == 9) || (e.which == 88) || (e.which == 46)) 
                    return true;
                else 
                    return false;              
            }			
        </script>
    </body>
</html>