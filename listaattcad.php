<?php
session_start();
include_once 'func/funcattcad.php';
include_once 'func/funcoes.php';

if (isset($_SESSION['buscafeita'])):
  $numcad = $_SESSION['cad'];
  $numemp = $_SESSION['emp'];
  $col = $_SESSION['col'];
  $numcpf = $_SESSION['numcpf'];
  $razemp = $_SESSION['razemp'];
else:
  header('Location: http://portal.capitalhumano.com.br/tela_nlog.php');
endif;

$dados = DadosColaborador($numemp, $numcad);
$dadosest = DadosEstrangeiro($numemp, $numcad);
$dadosdep = DadosDependente($numemp, $numcad);
$fechapag = 0;

if (!isset($_POST['btn_gerarel'])){
  $fechapag = 1;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include '_headLogin.php'; ?>
        <style> 
            body {
                font-family: Arial;  
            }  
        </style>
        <style media="print">
          .noprint { display:none; }
        </style>
    </head>
    <body> 
        <input hidden="true" value="<?php echo $fechapag?>" id="fecha_pag">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">                     
                    <div class="panel-heading">
                        <b> <?php echo $numemp . " - " . $razemp; ?> </b>
                        <div align="center" style="font-size: 22px;"> <b>Verificação Cadastral </b> </div>
                        <b> Cadastro: </b><?php echo $numcad; ?><br/><b>Nome: </b> <?php echo $col; ?>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Campo</th>
                                        <th>Alteração</th>                                        
                                        <th>Descrição</th>
                                        <th>Caminho</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($_POST["nomfun"] != $dados[0]['NOMFUN']) { ?>    
                                        <tr>
                                            <td>Nome</td>
                                            <td><?php echo $_POST["nomfun"]; ?></td>
                                            <td>Nome do Colaborador</td>
                                            <td>Ficha Básica</td>                                        
                                        </tr>
                                    <?php } ?> 
                                    <?php if ($_POST["datnas"] != $dados[0]['DATNAS']) { ?>    
                                        <tr>
                                            <td>Data de Nascimento</td>
                                            <td><?php echo $_POST["datnas"]; ?></td>
                                            <td>Data de Nascimento do Colaborador</td>
                                            <td>Ficha Básica</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["endrua"] != $dados[0]['ENDRUA']) { ?>    
                                        <tr>
                                            <td>Endereço</td>
                                            <td><?php echo $_POST["endrua"]; ?></td>
                                            <td>Endereço Residencial</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["endcpl"] != $dados[0]['ENDCPL']) { ?>    
                                        <tr>
                                            <td>Complemento</td>
                                            <td><?php echo $_POST["endcpl"]; ?></td>
                                            <td>Complemento do Endereço</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["endnum"] != $dados[0]['ENDNUM']) { ?>    
                                        <tr>
                                            <td>Número do Endereço</td>
                                            <td><?php echo $_POST["endnum"]; ?></td>
                                            <td>Número do Endereço</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["endcep"] != $dados[0]['ENDCEP']) { ?>    
                                        <tr>
                                            <td>CEP</td>
                                            <td><?php echo $_POST["endcep"]; ?></td>
                                            <td>CEP do Endereço</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["nombai"] != $dados[0]['NOMBAI']) { ?>    
                                        <tr>
                                            <td>Bairro</td>
                                            <td><?php echo $_POST["nombai"]; ?></td>
                                            <td>Nome do Bairro</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["nomcid"] != $dados[0]['NOMCID']) { ?>    
                                        <tr>
                                            <td>Cidade</td>
                                            <td><?php echo $_POST["nomcid"]; ?></td>
                                            <td>Nome da Cidade</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["estcid"] != $dados[0]['ESTCID']) { ?>    
                                        <tr>
                                            <td>Estado</td>
                                            <td><?php echo $_POST["estcid"]; ?></td>
                                            <td>Nome do Estado</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["dddtel"] != $dados[0]['DDDTEL']) { ?>    
                                        <tr>
                                            <td>DDD 1</td>
                                            <td><?php echo $_POST["dddtel"]; ?></td>
                                            <td>DDD do Telefone 1</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["numtel"] != $dados[0]['NUMTEL']) { ?>    
                                        <tr>
                                            <td>Telefone 1</td>
                                            <td><?php echo $_POST["numtel"]; ?></td>
                                            <td>Número do Telefone 1</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["nmddd2"] != $dados[0]['NMDDD2']) { ?>    
                                        <tr>
                                            <td>DDD 2</td>
                                            <td><?php echo $_POST["nmddd2"]; ?></td>
                                            <td>DDD do Telefone 2</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["nmtel2"] != $dados[0]['NMTEL2']) { ?>    
                                        <tr>
                                            <td>Telefone 2</td>
                                            <td><?php echo $_POST["nmtel2"]; ?></td>
                                            <td>Número do Telefone 2</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["emapar"] != $dados[0]['EMAPAR']) { ?>    
                                        <tr>
                                            <td>E-mail</td>
                                            <td><?php echo $_POST["emapar"]; ?></td>
                                            <td>E-mail</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["numcpf"] != $dados[0]['NUMCPF']) { ?>    
                                        <tr>
                                            <td>CPF</td>
                                            <td><?php echo $_POST["numcpf"]; ?></td>
                                            <td>CPF do Colaborador</td>
                                            <td>Ficha Básica</td>                                        
                                        </tr>
                                    <?php } ?> 
                                    <?php if ($_POST["numcid"] != $dados[0]['NUMCID']) { ?>    
                                        <tr>
                                            <td>RG</td>
                                            <td><?php echo $_POST["numcid"]; ?></td>
                                            <td>Número da Carteira de Identidade</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["emicid"] != $dados[0]['EMICID']) { ?>    
                                        <tr>
                                            <td>Órgão Emissor</td>
                                            <td><?php echo $_POST["emicid"]; ?></td>
                                            <td>Órgão Emissor da Carteira de Identidade</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["estcrg"] != $dados[0]['ESTCRG']) { ?>    
                                        <tr>
                                            <td>Estado do Órgão Emissor</td>
                                            <td><?php echo $_POST["estcrg"]; ?></td>
                                            <td>Estado do Órgão Emissor da Carteira de Identidade</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["dexcid"] != $dados[0]['DEXCID']) { ?>    
                                        <tr>
                                            <td>Data de Expedição</td>
                                            <td><?php echo $_POST["dexcid"]; ?></td>
                                            <td>Data de Expedição da Carteira de Identidade</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["numpis"] != $dados[0]['NUMPIS']) { ?>    
                                        <tr>
                                            <td>PIS/PASEP</td>
                                            <td><?php echo $_POST["numpis"]; ?></td>
                                            <td>Número do PIS/PASEP</td>
                                            <td>Ficha Básica</td>                                        
                                        </tr>
                                    <?php } ?> 
                                    <?php if ($_POST["numele"] != $dados[0]['NUMELE']) { ?>    
                                        <tr>
                                            <td>Título de Eleitor</td>
                                            <td><?php echo $_POST["numele"]; ?></td>
                                            <td>Número do Título de Eleitor</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["zonele"] != $dados[0]['ZONELE']) { ?>    
                                        <tr>
                                            <td>Zona</td>
                                            <td><?php echo $_POST["zonele"]; ?></td>
                                            <td>Zona do Título de Eleitor</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["secele"] != $dados[0]['SECELE']) { ?>    
                                        <tr>
                                            <td>Seção</td>
                                            <td><?php echo $_POST["secele"]; ?></td>
                                            <td>Seção do Título de Eleitor</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["numres"] != $dados[0]['NUMRES']) { ?>    
                                        <tr>
                                            <td>Reservista</td>
                                            <td><?php echo $_POST["numres"]; ?></td>
                                            <td>Número do Certificado de Reservista</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["numctp"] != $dados[0]['NUMCTP']) { ?>    
                                        <tr>
                                            <td>Carteira de Trabalho</td>
                                            <td><?php echo $_POST["numctp"]; ?></td>
                                            <td>Número da Carteira de Trabalho</td>
                                            <td>Ficha Básica</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["serctp"] != $dados[0]['SERCTP']) { ?>    
                                        <tr>
                                            <td>Série</td>
                                            <td><?php echo $_POST["serctp"]; ?></td>
                                            <td>Série da Carteira de Trabalho</td>
                                            <td>Ficha Básica</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["numcnh"] != $dados[0]['NUMCNH']) { ?>    
                                        <tr>
                                            <td>Carteira de Habilitação</td>
                                            <td><?php echo $_POST["numcnh"]; ?></td>
                                            <td>Número da Carteira de Habilitação</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["datcnh"] != $dados[0]['DATCNH']) { ?>    
                                        <tr>
                                            <td>Data de Expedição</td>
                                            <td><?php echo $_POST["datcnh"]; ?></td>
                                            <td>Data de Expedição da Carteira de Habilitação</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["vencnh"] != $dados[0]['VENCNH']) { ?>    
                                        <tr>
                                            <td>Data de Validade</td>
                                            <td><?php echo $_POST["vencnh"]; ?></td>
                                            <td>Data de Validade da Carteira de Habilitação</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["pricnh"] != $dados[0]['PRICNH']) { ?>    
                                        <tr>
                                            <td>Data Primeira Habilitação</td>
                                            <td><?php echo $_POST["pricnh"]; ?></td>
                                            <td>Data da Primeira Carteira de Habilitação</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["catcnh"] != $dados[0]['CATCNH']) { ?>    
                                        <tr>
                                            <td>Categoria</td>
                                            <td><?php echo $_POST["catcnh"]; ?></td>
                                            <td>Categoria da Carteira de Habilitação</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["grains"] != $dados[0]['GRAINS']) { ?>    
                                        <tr>
                                            <td>Grau de Instrução</td>
                                            <td><?php $desgi = retDesGraIns($_POST["grains"]); echo $_POST["grains"]." - ".acentuacaook($desgi[0]['DESGRA']);?></td>
                                            <td>Grau de Instrução do Colaborador</td>
                                            <td>Ficha Básica</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["estciv"] != $dados[0]['ESTCIV']) { ?>    
                                        <tr>
                                            <td>Estado Civil</td>
                                            <td><?php echo $_POST["estciv"]." - ". retDesEstCiv($_POST["estciv"]); ?></td>
                                            <td>Estado Civil do Colaborador</td>
                                            <td>Ficha Básica</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["desnac"] != $dados[0]['DESNAC']) { ?>    
                                        <tr>
                                            <td>Nacionaliadde</td>
                                            <td><?php echo $_POST["desnac"]; ?></td>
                                            <td>Nacionalidade do Colaborador</td>
                                            <td>Ficha Básica</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["cidnat"] != $dados[0]['CIDNAT']) { ?>    
                                        <tr>
                                            <td>Cidade de Nascimento</td>
                                            <td><?php echo $_POST["cidnat"]; ?></td>
                                            <td>Cidade de Nascimento</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["estnat"] != $dados[0]['ESTNAT']) { ?>    
                                        <tr>
                                            <td>Estado de Nascimento</td>
                                            <td><?php echo $_POST["estnat"]; ?></td>
                                            <td>Estado de Nascimento</td>
                                            <td>Ficha Complementar</td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["regest"] != $dadosest[0]['REGEST']) { ?>    
                                        <tr>
                                            <td>Carteira de Estrangeiro</td>
                                            <td><?php echo $_POST["regest"]; ?></td>
                                            <td>Carteira de Estrangeiro do Colaborador</td>
                                            <td>Ficha Básica / Estrangeiro </td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["emiest"] != $dadosest[0]['EMIEST']) { ?>    
                                        <tr>
                                            <td>Órgão Emissor</td>
                                            <td><?php echo $_POST["emiest"]; ?></td>
                                            <td>Órgão Emissor do Registro de Estrangeiro</td>
                                            <td>Ficha Básica / Estrangeiro </td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["datest"] != $dadosest[0]['DATEST']) { ?>    
                                        <tr>
                                            <td>Data de Expedição</td>
                                            <td><?php echo $_POST["datest"]; ?></td>
                                            <td>Data de Expedição do Registro de Estrangeiro</td>
                                            <td>Ficha Básica / Estrangeiro </td>                                        
                                        </tr>
                                    <?php } ?>
                                    <?php if ($_POST["datche"] != $dadosest[0]['DATCHE']) { ?>    
                                        <tr>
                                            <td>Data de Chegada</td>
                                            <td><?php echo $_POST["datche"]; ?></td>
                                            <td>Data de Chegada ao Brasil</td>
                                            <td>Ficha Básica / Estrangeiro </td>                                        
                                        </tr>
                                    <?php } ?> 
                                    
<!--                                   /********** Dependentes **********/ -->

                                 <?php for ($x = 0;$x < count($dadosdep);$x++){
                                       
                                       if ($_POST["nomdep".$x] != $dadosdep[$x]['NOMDEP']) { ?>    
                                          <tr>
                                            <td>Nome</td>
                                            <td><?php echo $_POST["nomdep".$x]; ?></td>
                                            <td>Nome do Dependente <?php echo " - Cód. ".$dadosdep[$x]['CODDEP']; ?></td>
                                            <td>Ficha Familiar</td>                                        
                                          </tr>                                                                                                                             
                                    <?php } if ($_POST["dnadep".$x] != $dadosdep[$x]['DATNAS']) { ?>    
                                          <tr>
                                            <td>Data de Nascimento</td>
                                            <td><?php echo $_POST["dnadep".$x]; ?></td>
                                            <td>Data de Nascimento do Dependente <?php echo " - Cód. ".$dadosdep[$x]['CODDEP']; ?></td>
                                            <td>Ficha Familiar</td>                                        
                                          </tr>
                                    <?php } if ($_POST["grapar".$x] != $dadosdep[$x]['GRAPAR']) { ?>    
                                          <tr>
                                            <td>Grau de Parentesco</td>
                                            <td><?php echo retDescGP($_POST["grapar".$x]); ?></td>
                                            <td>Grau de Parentesco do Dependente <?php echo " - Cód. ".$dadosdep[$x]['CODDEP']; ?></td>
                                            <td>Ficha Familiar</td>                                        
                                          </tr> 
                                 
                                    <?php } if ($_POST["cpfdep".$x] != $dadosdep[$x]['NUMCPF']) { ?>    
                                          <tr>
                                            <td>CPF</td>
                                            <td><?php echo $_POST["cpfdep".$x]; ?></td>
                                            <td>CPF do Dependente <?php echo " - Cód. ".$dadosdep[$x]['CODDEP']; ?></td>
                                            <td>Ficha Familiar</td>                                        
                                          </tr>
                                    <?php } if ($_POST["limirf".$x] != $dadosdep[$x]['LIMIRF']) { ?>    
                                          <tr>
                                            <td>Dependente de Imp. Renda</td>
                                            <td><?php echo $_POST["limirf".$x]; ?></td>
                                            <td>Idade Limite de Dependente de Imp. Renda <?php echo "<b> - Cód. ".$dadosdep[$x]['CODDEP']."</b>"; ?></td>
                                            <td>Ficha Familiar</td>                                        
                                          </tr>
                                    <?php }                                    
                                                                              } ?> 
<!--                                   /********** Fim Dependente **********/-->
                                </tbody>
                            </table>
                        </div>
                    </div>                  
                </div> 
                <h5 align="center"> Obs.: Alterações ou inclusões nos campos (Endereço, Documentos, Informações Complementares, Dependentes)
                    devem ser apresentados a cópia dos documentos <b>comprobatórios</b>.</h4>
                <h4 align="center"> Autorizo a atualização de minhas informações cadastrais conforme informadas acima. </h5>
                <div class="col-md-12 col-sm-6" align="center">
                    <div class="panel-heading" align="center">
                      _________________________________________________ <br>
                     <?php echo $col; ?> <br>
                     <?php echo MostrarCpf($numcpf,1); ?>
                    </div>                                 
                </div>
                <br> <br>
                <div class="col-md-12">
                <div align="center" class="noprint">  
                  <a class="btn btn-success" href ="javascript:window.print()">Imprimir</a>
                  <button class="btn btn-danger btn_fecha" name="btn_fecha">Fechar</button> 
                </div>
                </div>    
            </div>
        </div>
        <script>
          var fechap = $("#fecha_pag").val();
            
          if (fechap == 1){
            window.close();    
          }  

          $('.btn_fecha').click (function() {   
            window.close();
          });
        </script>
    </body>
</html>


