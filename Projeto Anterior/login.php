<?php
session_start();
include_once "func/funcoes.php";

if (isset($_POST['btn_acessar'])) {
  $codemp = $_POST['codemp'];
  $numcol = $_POST['numcol'];
  $senha = $_POST['senha'];
	
  $vd = VerificaDemitido($numcol,$codemp);
	
  if($vd == '')
    $verifica = buscacollogin($numcol, md5($senha), $codemp);
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
            <div class="row text-center ">
                <div class="col-md-12">
                    <br /><br />                   
                    <img src="imagens/cc.png"></src>
                    <h5>(Acesso ao Portal Capital Humano)</h5>
                        <br />                       
                </div>
            </div>
            <div class="row ">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong> Utilize os dados para acesso </strong>                          
                        </div>
                        <div class="panel-body">
                            <form role="form" method="POST" action="login.php" id="formulario">
                                <br />
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                    <input type="text" id="codemp" name ="codemp" class="form-control" placeholder="Código da Empresa " maxlength="9" OnKeyDown='return SomenteNumero(event)' />
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                    <input type="text" id="numcol" name="numcol" class="form-control"placeholder="Código do Usuário (Matrícula/RE)" maxlength="15" OnKeyDown='return SomenteNumero(event)' />
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" />
                                </div>
                                <div class="form-group">                              
                                    <span class="pull-right">
                                        <a href="confirmadados.php" >Esqueceu a senha ? </a> 
                                    </span>
                                </div>
                                <button class="btn btn-primary" id="btn_acessar" name="btn_acessar"> Acessar </button>							
                                <?php if ($verifica <> '') { ?>
                                    <br />
                                    <br />
                                    <div class="alert alert-danger alert-dismissable">
                                        <?php echo $verifica ?>
                                    </div>																													
                                <?php } ?>
                                <hr />							
                                Não possui senha ? <a href="confirmadados.php" > Clique Aqui </a> 
                                <!--<hr/><span id="siteseal" style="padding-left: 36px;"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=cHTmAKkKhfg6ADyMjVY15eQaMVAYRgAMzZqMIwjcC4O91IXt6RzZU70TKLVX"></script></span>-->
                            </form>                           
                        </div>                        
                    </div>
                </div>
            </div>
        </div>        
        <script>
          $("#formulario").submit (function() {
          var ret = 0;
          var msg = 'Preencher os campos obrigatórios: \n';
                
          if($('#codemp').val().trim() == ''){
            ret = 1;
            msg += '\n Código da Empresa';                                  
          }
				
	  if($('#numcol').val().trim() == ''){
            ret = 1;
            msg += '\n Código do Colaborador';                                  
          }
				
	  if($('#senha').val().trim() == ''){
            ret = 1;
            msg += '\n Senha';                                  
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
       
           if ((tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105) || (e.which == 8) || (e.which == 9) || (e.which == 46)) 
             return true;
           else 
             return false;              
            };
        </script>
        <script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>
    </body>
</html>