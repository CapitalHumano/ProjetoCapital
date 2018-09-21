<?php
session_start();
include_once "func/funcoes.php";

if (isset($_SESSION['dadosconf'])) {
    $numcad = $_SESSION['NUMCAD'];
    $numemp = $_SESSION['NUMEMP'];
    $tipcol = $_SESSION['TIPCOL'];
    

    if (isset($_POST['btn_salvar'])) {
        $senha = $_POST['senha'];
        InserirSenha($numcad, $numemp, $tipcol, md5($senha));
        session_destroy();
        echo "<script> window.location=\"login.php\" </script>";
    }
}else
    echo "<script> window.location=\"tela_nlog.php\" </script>";
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
                    <h5>( Acesso ao Recibo de Pagamento )</h5>
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
                            A senha deve possuir: 
                            <b>Mínimo 8 caracteres,<br>1 Letra Maiúscula,1 Caracter Especial e 1 Número.</b>
                            <form role="form" method="POST" action="alterasenha.php" id="formulario">
                                <br/>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha (Mínimo de 8 caracteres)" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" />
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                    <input type="password" name="novsenha" id="novsenha" class="form-control"  placeholder="Repita a Senha" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"/>
                                </div>
                                <button name="btn_salvar" class="btn btn-success">Salvar</button>
                                <hr />                               
                                  Já possui senha ?  <a href="login.php" >Acesse Aqui</a>                                                                                           
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#formulario').submit (function() {
                var ret = 0;
                var msg = '';
                var msgc = '';
	
                if(($('#senha').val().trim() == '') || ($('#senha').val().length < 8)){
                    ret = 1;
                    msgc += 'Senha; \n';	  
                }
	
                if(($('#novsenha').val().trim() == '') || ($('#novsenha').val().length < 8)){
                    ret = 1; 
                    msgc += 'Confirmação da Senha; \n'
                }
	
                if($('#novsenha').val() != $('#senha').val() && ret != 1){ 
                    ret = 2; 
                }		
    	
                if(ret != 0){
                    if(ret == 1){ 
                        msg = 'Preencher os campos obrigatórios: \n ## (Mínimo de 8 caracteres) ## \n \n';
                        alert(msg+msgc);
                    }
                    else {
                        msg = 'As senha não se coincidem;';
                        alert(msg);
                    }
	                 
                    return false;
                }	
            });
        </script>		
    </body>
</html>