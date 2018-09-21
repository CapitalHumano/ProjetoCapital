<?php
session_start();
include_once 'func/funcattcad.php';
include_once 'func/funcoes.php';

if (isset($_SESSION['buscafeita'])):
    $numcad = $_SESSION['cad'];
    $numemp = $_SESSION['emp'];
    $emp = $numemp;
    $col = $_SESSION['col'];
else:
    header('Location: http://portal.capitalhumano.com.br/tela_nlog.php');
endif;

$dados = DadosColaborador($numemp, $numcad);
$dadosdep = DadosDependente($numemp, $numcad);
$sctins = TabelaGraIns();
$cp1 = 3;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include '_headLogin.php'; ?>
        <style> 
            hr {
                margin-bottom: 5px;
                padding-bottom: 5px;
                margin-top: 0;
                padding-top: 0;               
            }       
        </style>
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
            
            <?php include '_menulateral.php'; ?>

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Atualização Cadastral</h2>   
                            <h5>Aqui você pode verificar/atualizar suas informações.</h5>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <!--Titulo Panel-->    
                                </div>
                                <div class="panel-body">
                                    <form role="form" method="POST" action="listaattcad.php" id="formulario" target="_blank"> 
                                    <h4>Informações Básicas</h4>
                                    <hr/>                                
                                    <div class="row">                                       
                                        <div class="col-md-2">    
                                            <div class="form-group">
                                                Cadastro
                                                <input class="form-control" type="text" name="numcad" disabled value="<?php echo $dados[0]['NUMCAD']; ?>"/>
                                            </div>
                                        </div>                                                                            
                                        <div class="col-md-8">  
                                            <div class="form-group">
                                                Nome
                                                <input class="form-control" type="text" name="nomfun" value="<?php echo $dados[0]['NOMFUN']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2">                                               
                                            <div class="form-group">
                                                Nascimento
                                                <input class="form-control" type="text" id="datnas" name="datnas" value="<?php echo $dados[0]['DATNAS']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <h4>Endereço</h4>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-4">  
                                            <div class="form-group">
                                                Endereço
                                                <input class="form-control" type="text" name="endrua" value="<?php echo $dados[0]['ENDRUA']; ?>"/>
                                            </div>
                                            <div class="form-group">
                                                Complemento
                                                <input class="form-control" type="text" name="endcpl" value="<?php echo $dados[0]['ENDCPL']; ?>"/>
                                            </div>                                                                                                                               
                                        </div>
                                        <div class="col-md-2">  
                                            <div class="form-group">
                                                Nº
                                                <input class="form-control" type="text" name="endnum" value="<?php echo $dados[0]['ENDNUM']; ?>"/>
                                            </div>
                                        </div>                                      
                                        <div class="col-md-2">  
                                            <div class="form-group">
                                                CEP
                                                <input class="form-control" type="text" name="endcep" value="<?php echo $dados[0]['ENDCEP']; ?>"/>
                                            </div>
                                        </div>                                       
                                        <div class="col-md-4">  
                                            <div class="form-group">
                                                Bairro
                                                <input class="form-control" type="text" name="nombai" value="<?php echo $dados[0]['NOMBAI']; ?>"/>
                                            </div>
                                        </div> 
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                Cidade
                                                <input class="form-control" type="text" name="nomcid" value="<?php echo $dados[0]['NOMCID']; ?>"/>
                                            </div>
                                        </div> 
                                        <div class="col-md-2">  
                                            <div class="form-group">
                                                UF
                                                <input class="form-control" type="text" name="estcid" value="<?php echo $dados[0]['ESTCID']; ?>"/>
                                            </div>
                                        </div>                                                                                                                     
                                    </div>
                                    <h4>Contatos</h4>
                                    <hr/>                
                                    <div class="row">
                                        <div class="col-md-1">  
                                            <div class="form-group">
                                                DDD 1
                                                <input class="form-control" type="text" name="dddtel" value="<?php echo $dados[0]['DDDTEL']; ?>"/>
                                            </div>
                                            <div class="form-group">
                                                DDD 2
                                                <input class="form-control" type="text" name="nmddd2" value="<?php echo $dados[0]['NMDDD2']; ?>"/>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">  
                                            <div class="form-group">
                                                Telefone 1
                                                <input class="form-control" type="text" name="numtel" value="<?php echo $dados[0]['NUMTEL']; ?>"/>
                                            </div>
                                            <div class="form-group">
                                                Telefone 2
                                                <input class="form-control" type="text" name="nmtel2" value="<?php echo $dados[0]['NMTEL2']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-7">                                       
                                            <div class="form-group">
                                                E-mail Particular
                                                <input class="form-control" type="text" name="emapar" value="<?php echo $dados[0]['EMAPAR']; ?>"/>
                                            </div>
                                        </div>    
                                    </div>
                                    <h4>Documentos</h4>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                CPF
                                                <input class="form-control" type="text" name="numcpf" value="<?php echo MostrarCpf($dados[0]['NUMCPF'], 0); ?>"/>
                                            </div>                                                                                   
                                        </div> 
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                RG
                                                <input class="form-control" type="text" name="numcid" value="<?php echo $dados[0]['NUMCID']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                Org. Emissor
                                                <input class="form-control" type="text" name="emicid" value="<?php echo $dados[0]['EMICID']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-1">  
                                            <div class="form-group">
                                                UF
                                                <input class="form-control" type="text" name="estcrg" value="<?php echo $dados[0]['ESTCRG']; ?>"/>
                                            </div>                                                                                   
                                        </div>                                        
                                        <div class="col-md-2">  
                                            <div class="form-group">
                                                Expedição RG
                                                <input class="form-control" type="text" id="dexcid" name="dexcid" value="<?php echo $dados[0]['DEXCID']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                PIS
                                                <input class="form-control" type="text" name="numpis" value="<?php echo $dados[0]['NUMPIS']; ?>"/>
                                            </div>                                                                                   
                                        </div> 
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                Tít. Eletitor
                                                <input class="form-control" type="text" name="numele" value="<?php echo $dados[0]['NUMELE']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                Zona    
                                                <input class="form-control" type="text" name="zonele" value="<?php echo $dados[0]['ZONELE']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                Seção    
                                                <input class="form-control" type="text" name="secele" value="<?php echo $dados[0]['SECELE']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                CNH
                                                <input class="form-control" type="text" name="numcnh" value="<?php echo $dados[0]['NUMCNH']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-2">  
                                            <div class="form-group">
                                                Expedição CNH
                                                <input class="form-control" type="text" id="datcnh" name="datcnh" value="<?php echo $dados[0]['DATCNH']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-2">  
                                            <div class="form-group">
                                                Validade CNH
                                                <input class="form-control" type="text" id="vencnh" name="vencnh" value="<?php echo $dados[0]['VENCNH']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-2">  
                                            <div class="form-group">
                                                Primeira CNH
                                                <input class="form-control" type="text" id="pricnh" name="pricnh" value="<?php echo $dados[0]['PRICNH']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                Categoria CNH
                                                <input class="form-control" type="text" name="catcnh" value="<?php echo $dados[0]['CATCNH']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                CTPS
                                                <input class="form-control" type="text" name="numctp" value="<?php echo $dados[0]['NUMCTP']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                Série CTPS
                                                <input class="form-control" type="text" name="serctp" value="<?php echo $dados[0]['SERCTP']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                Reservista
                                                <input class="form-control" type="text" name="numres" value="<?php echo $dados[0]['NUMRES']; ?>"/>
                                            </div>                                                                                   
                                        </div>
                                    </div>
                                    <h4>Informações Complementares</h4>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                Escolaridade
                                                <select class="form-control" name="grains">
                                                    <option value="">--- Selecione ---</option>
                                                    <?php for ($i = 0; $i < count($sctins); $i++) { ?>    
                                                        <option value="<?php echo $sctins[$i]['GRAINS']; ?>" <?php if ($sctins[$i]['GRAINS'] == $dados[0]['GRAINS']) echo "selected"; ?>> 
                                                            <?php echo acentuacaook($sctins[$i]['DESGRA']); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>    
                                        </div> 
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                Estado Civil                                                
                                                <select class="form-control" name="estciv">
                                                    <option value="">--- Selecione ---</option>
                                                    <option value="1" <?php if ($dados[0]['ESTCIV'] == 1) echo "selected"; ?>>Solteiro</option>
                                                    <option value="2" <?php if ($dados[0]['ESTCIV'] == 2) echo "selected"; ?>>Casado</option>
                                                    <option value="3" <?php if ($dados[0]['ESTCIV'] == 3) echo "selected"; ?>>Divorciado</option>
                                                    <option value="4" <?php if ($dados[0]['ESTCIV'] == 4) echo "selected"; ?>>Viúvo</option>
                                                    <option value="5" <?php if ($dados[0]['ESTCIV'] == 5) echo "selected"; ?>>Concubinato</option>
                                                    <option value="6" <?php if ($dados[0]['ESTCIV'] == 6) echo "selected"; ?>>Separado</option>
                                                    <option value="7" <?php if ($dados[0]['ESTCIV'] == 7) echo "selected"; ?>>União Estável</option>
                                                    <option value="9" <?php if ($dados[0]['ESTCIV'] == 9) echo "selected"; ?>>Outros</option>                                                   
                                                </select>
                                            </div>    
                                        </div>
                                        <div class="col-md-4">  
                                            <div class="form-group">
                                                Naturalidade
                                                <input class="form-control" type="text" name="cidnat" value="<?php echo $dados[0]['CIDNAT']; ?>"/>
                                            </div>    
                                        </div> 
                                        <div class="col-md-2">  
                                            <div class="form-group">
                                                UF Nat.
                                                <input class="form-control" type="text" name="estnat" value="<?php echo $dados[0]['ESTNAT']; ?>"/>
                                            </div>    
                                        </div>
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                Nacionalidade
                                                <input class="form-control" type="text" name="desnac" value="<?php echo $dados[0]['DESNAC']; ?>"/>
                                            </div>    
                                        </div>
                                    </div>
                                    <?php
                                    if ($dados[0]['CODNAC'] != 10) {
                                        $dadosest = DadosEstrangeiro($numemp, $numcad);
                                        ?> 
                                        <h4>Estrangeiro</h4>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-md-3">  
                                                <div class="form-group">
                                                    Reg. Nacional Estrangeiro
                                                    <input class="form-control" type="text" name="regest" value="<?php echo $dadosest[0]['REGEST']; ?>"/>
                                                </div>    
                                            </div>
                                            <div class="col-md-3">  
                                                <div class="form-group">
                                                    Orgão Emissor
                                                    <input class="form-control" type="text" name="emiest" value="<?php echo $dadosest[0]['EMIEST']; ?>"/>
                                                </div>    
                                            </div>  
                                            <div class="col-md-3">  
                                                <div class="form-group">
                                                    Data Expedição
                                                    <input class="form-control" type="text" name="datest" value="<?php echo $dadosest[0]['DATEST']; ?>"/>
                                                </div>    
                                            </div> 
                                            <div class="col-md-3">  
                                                <div class="form-group">
                                                    Data Chegada
                                                    <input class="form-control" type="text" id="datche" name="datche" value="<?php echo $dadosest[0]['DATCHE']; ?>"/>
                                                </div>    
                                            </div>  
                                        </div><?php } ?>
                                    <h4>Dependentes</h4>
                                    <hr/> 
                                    <?php for($j = 0; $j < count($dadosdep); $j++) {?>
                                    <div class="row">
                                        <input type="hidden" value="<?php echo $dadosdep[$j]['CODDEP']; ?>" name="<?php echo "coddep".$j;?>" />
                                        <div class="col-md-8">  
                                            <div class="form-group">
                                                Filiação
                                                <input class="form-control" type="text" name="<?php echo "nomdep".$j;?>" value="<?php echo $dadosdep[$j]['NOMDEP']; ?>"/>
                                            </div>    
                                        </div>
                                        <div class="col-md-4">  
                                            <div class="form-group">
                                                Nascimento
                                                <input class="form-control" type="text" id="<?php echo "dnadep".$j;?>" name="<?php echo "dnadep".$j;?>" value="<?php echo $dadosdep[$j]['DATNAS']; ?>"/>
                                            </div>    
                                        </div>
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                Grau de Parentesco                                                
                                              <select class="form-control" name="<?php echo "grapar".$j;?>">
                                                <option value="">--- Selecione ---</option>
                                                <option value="1" <?php if ($dadosdep[$j]['GRAPAR'] == 1) echo "selected"; ?>>Filho(a)</option>
                                                <option value="2" <?php if ($dadosdep[$j]['GRAPAR'] == 2) echo "selected"; ?>>Cônjuge</option>
                                                <option value="3" <?php if ($dadosdep[$j]['GRAPAR'] == 3) echo "selected"; ?>>Pai/Mãe</option>
                                                <option value="4" <?php if ($dadosdep[$j]['GRAPAR'] == 4) echo "selected"; ?>>Avô/Avó</option>
                                                <option value="5" <?php if ($dadosdep[$j]['GRAPAR'] == 5) echo "selected"; ?>>Bisavô(ó)</option>
                                                <option value="6" <?php if ($dadosdep[$j]['GRAPAR'] == 6) echo "selected"; ?>>Sobrinho(a)</option>
                                                <option value="7" <?php if ($dadosdep[$j]['GRAPAR'] == 7) echo "selected"; ?>>Tio(a)</option>
                                                <option value="8" <?php if ($dadosdep[$j]['GRAPAR'] == 8) echo "selected"; ?>>Neto(a)</option>		
		                                <option value="9" <?php if ($dadosdep[$j]['GRAPAR'] == 9) echo "selected"; ?>>Sogro(a)</option>		
                                                <option value="10" <?php if ($dadosdep[$j]['GRAPAR'] == 10) echo "selected"; ?>>Genro/Nora</option>
                                                <option value="11" <?php if ($dadosdep[$j]['GRAPAR'] == 11) echo "selected"; ?>>Enteado(a)</option>
                                                <option value="12" <?php if ($dadosdep[$j]['GRAPAR'] == 12) echo "selected"; ?>>Irmão(a)</option>
                                                <option value="14" <?php if ($dadosdep[$j]['GRAPAR'] == 14) echo "selected"; ?>>Filho(a) Adotivo(a)</option>
                                                <option value="15" <?php if ($dadosdep[$j]['GRAPAR'] == 15) echo "selected"; ?>>Pensionistas</option>
                                                <option value="16" <?php if ($dadosdep[$j]['GRAPAR'] == 16) echo "selected"; ?>>Companheiro(a)</option>
                                                <option value="17" <?php if ($dadosdep[$j]['GRAPAR'] == 17) echo "selected"; ?>>Tutelado</option>		
	                                        <option value="18" <?php if ($dadosdep[$j]['GRAPAR'] == 18) echo "selected"; ?>>Menor sob Guarda</option>
                                                <option value="19" <?php if ($dadosdep[$j]['GRAPAR'] == 19) echo "selected"; ?>>Madastra</option>
                                                <option value="20" <?php if ($dadosdep[$j]['GRAPAR'] == 20) echo "selected"; ?>>Padastro</option>
                                                <option value="21" <?php if ($dadosdep[$j]['GRAPAR'] == 21) echo "selected"; ?>>Tutor</option>
                                                <option value="22" <?php if ($dadosdep[$j]['GRAPAR'] == 22) echo "selected"; ?>>Ex-Esposo(a)</option>
                                                <option value="23" <?php if ($dadosdep[$j]['GRAPAR'] == 23) echo "selected"; ?>>Bisneto(a)</option>
                                                <option value="24" <?php if ($dadosdep[$j]['GRAPAR'] == 24) echo "selected"; ?>>Ex-Companheiro(a)</option>
                                                <option value="25" <?php if ($dadosdep[$j]['GRAPAR'] == 25) echo "selected"; ?>>Concubino(a)</option>		
		                                <option value="26" <?php if ($dadosdep[$j]['GRAPAR'] == 26) echo "selected"; ?>>Curatelado</option>
                                                <option value="99" <?php if ($dadosdep[$j]['GRAPAR'] == 99) echo "selected"; ?>>Outros</option>		
                                              </select>
                                            </div>    
                                        </div>                                         
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                CPF
                                                <input class="form-control" type="text" name="<?php echo "cpfdep".$j;?>" value="<?php echo $dadosdep[$j]['NUMCPF']; ?>"/>
                                            </div>    
                                        </div>
                                        <div class="col-md-3">  
                                            <div class="form-group">
                                                Idade Limite do Imp. Renda
                                                <input class="form-control" type="text" name="<?php echo "limirf".$j;?>" value="<?php echo $dadosdep[$j]['LIMIRF']; ?>"/>
                                            </div>    
                                        </div>
                                    </div>
                                    <?php if($j < count($dadosdep)-1){ ?>
                                    <hr/>
                                    <?php } } ?>
                                </div>                                                               
                            </div>
                            <div align="right"> <button class="btn btn-success" name="btn_gerarel">Gerar Relatório de Alterações</button> </div>
                          </form>
                        </div> 
                    </div>                 
                </div>
            </div>
        </div>	
        <script> 
            $('#datnas').mask('99/99/9999');
            $('#dexcid').mask('99/99/9999');
            $('#datcnh').mask('99/99/9999');
            $('#vencnh').mask('99/99/9999');
            $('#pricnh').mask('99/99/9999');
            $('#datche').mask('99/99/9999');
            $('#dnadep0').mask('99/99/9999');
            $('#dnadep1').mask('99/99/9999');
            $('#dnadep2').mask('99/99/9999');
            $('#dnadep3').mask('99/99/9999');
            $('#dnadep4').mask('99/99/9999');
            $('#dnadep5').mask('99/99/9999');
            $('#dnadep6').mask('99/99/9999');
            $('#dnadep7').mask('99/99/9999');
            $('#dnadep8').mask('99/99/9999');
            $('#dnadep9').mask('99/99/9999');
        </script>
    </body>
</html>
