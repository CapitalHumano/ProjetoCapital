<?php
session_start();
include "func/funcoes.php";
include "func/funcinforme.php";

$col = $_SESSION['col'];
$cad = $_SESSION['cad'];
$emp = $_SESSION['emp'];
$razemp = $_SESSION['razemp'];
$codbanco = $_SESSION['codban'];
$conbanco = $_SESSION['conban'];
$digbanco = $_SESSION['digban'];
$numcpf = $_SESSION['numcpf'];
$codfil = $_SESSION['codfil'];
$tipadm = $_SESSION['tipadm'];

$vl4 = 0;
$vl5 = 0;
$seqitem4 = 7;
$transferido = 0;

$nomlocal = CarregaLocal($emp, $cad, date('d/m/Y'));
$dadosfilial = DadosFilial($emp, $codfil);
$rendimentoinf = RedimentosInforme($emp, $cad, AuxDatFim());
$r051ben = RetornaR051BEN($emp, $codfil, $rendimentoinf[0]['CODREC'], $rendimentoinf[0]['TIPIRF'], $rendimentoinf[0]['CPFCGC'], AuxDatIni(), AuxDatFim());

/* -- TRATAMENTO PARA TRANSFERIDOS -- */
if (($r051ben[0]['basirf'] == 0) && (($tipadm == 3) || ($tipadm == 4))) {
  $transferido = 1;  
  $transf = CodFilTransf($numcpf);
  $codfil = $transf[0]['CODFIL']; 
  $r051ben = RetornaR051BEN($emp, $codfil, $rendimentoinf[0]['CODREC'], $rendimentoinf[0]['TIPIRF'], $rendimentoinf[0]['CPFCGC'], AuxDatIni(), AuxDatFim());
}
/* -- FIM TRATAMENTO TRANSFERIDOS --  */

$retplr = RetornaPLR($emp, $codfil, $rendimentoinf[0]['TIPIRF'], $rendimentoinf[0]['CPFCGC'], AuxDatIni(), AuxDatFim());
$totcolisen = TotalizadorCol($emp, $codfil, $rendimentoinf[0]['CODREC'], $rendimentoinf[0]['CPFCGC'], $rendimentoinf[0]['TIPIRF'],'I'); 
$totcol = TotalizadorCol($emp, $codfil, $rendimentoinf[0]['CODREC'], $rendimentoinf[0]['CPFCGC'], $rendimentoinf[0]['TIPIRF'],'C');
$depjud = DepPensao($emp, $cad);
$prevp = PrevidenciaPriv($emp, $codfil, $rendimentoinf[0]['CODREC'], $rendimentoinf[0]['TIPIRF'], $rendimentoinf[0]['CPFCGC']);

/* -- Informações Complementares -- */
$ver1ic = Ver1InformacoesComp($emp, $codfil, $rendimentoinf[0]['CODREC'], $rendimentoinf[0]['TIPIRF'], $rendimentoinf[0]['CPFCGC'], $rendimentoinf[0]['ORIANU']);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Informe de Rendimento</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <style>
            body {               
                margin: 5px; 
                margin-right: 10px;
                font-family: Courier New;
            }

            .img_topo {
                width: 100%;
            }

            .cabecalho1 {               
                margin-left: 50px;
                font-size: 12px;
            }

            .coluna2 {
                margin-left: 200px;
            }
            
            .colunavalor {
               float: right;
               width: 100px;               
               text-align: right;
            }
            
            .item{
               font-size: 11.5px;               
            }
            
            .quebra_pagina {
              page-break-inside: avoid;    
            }
            
            .titulo {
               font-size: 12px;
            }

        </style>      
        <style media="print">
          .noprint { display:none; }
        </style>
    </head>
    <body>
    <!-- CABECALHO 1-2 -->
      <img class="img_topo" src="imagens/topo_informe.jpg"></src>
      
      <p class="cabecalho1"> Verifique as condições e o prazo para apresentação da Declaração do Imposto sobre a Renda da
          Pessoa Física para este ano-calendário no sítio da Secretária da Receita Federal do Brasil na
          Internet, no endereço < www.receita.fazenda.gov.br >. </p>
      <div class="titulo"> <b>1. Fonte Pagadora Pessoa Jurídica ou Pessoa Física</b> </div>
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <br/>
      <div class="item">
        CNPJ/CPF: <?php echo maskcnpj($dadosfilial[0]['NUMCGC']);?> 
        <a class="coluna2">Fone: <?php echo $dadosfilial[0]['DDITEL']." (".$dadosfilial[0]['DDDTEL'].") ".mask($dadosfilial[0]['NUMTEL'], "####-####");; ?> </a><br/>
        Nome Empresa: <?php echo acentuacaook($dadosfilial[0]['RAZSOC']);?><br/> 
        Endereço: <?php echo $dadosfilial[0]['ENDFIL'].", ".$dadosfilial[0]['ENDNUM'];?><br/> 
        Bairro: <?php echo $dadosfilial[0]['NOMBAI']; ?> <a class="coluna2">Cidade: <?php echo $dadosfilial[0]['NOMCID']."-".$dadosfilial[0]['ESTCID']; ?></a><br/> <br/>
        <div class="titulo"> <b>2. Pessoa Física Beneficiária dos Rendimentos</b> </div>
        <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
        <br/>
        Local: <?php echo $nomlocal[0]['CODLOC']." - ".acentuacaook($nomlocal[0]['NOMLOC']); ?> <br/>
        CPF: <?php echo maskcpf($numcpf,1);?> <a class="coluna2">Cadastro: <?php echo $cad; ?></a><br/>
        Beneficiário: <?php echo $col; ?><br/> 
        Natureza do Rendimento: <?php echo $rendimentoinf[0]['CODREC']." - ".$rendimentoinf[0]['DESREC'];?> <br/>
      <br/>
      </div>
    <!-- ///-------------------------------------------------------------------------------------------\\\ -->
    
    <!-- Item 3 -->
    <div class="item">
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <div class="titulo"> <b>3. Rendimentos Tributáveis, Deduções e Imposto Retido na Fonte - VALORES EM REAIS </b> </div>
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <br/>
      01 Total dos Rendimentos (inclusive férias) <a class="colunavalor"> <?php echo ValorDecimal($r051ben[0]['BASIRF'] + $r051ben[0]['BASFER']); ?></a>
      <br/>
      02 Contribuição Previdenciaria Oficial <a class="colunavalor"> <?php echo ValorDecimal($r051ben[0]['CONPRE'] + $r051ben[0]['EXDEDI']); ?> </a>
      <br/>
      03 Contribuição Previd. Complem. pública ou privada e FAPI (Preencher quadro 7) <a class="colunavalor"> <?php echo ValorDecimal($r051ben[0]['PREPRI'] + $r051ben[0]['EXDEPP']); ?> </a>
      <br/>
      04 Pensão Alimentícia (Preencher também o quadro 7) <a class="colunavalor"> <?php echo ValorDecimal($r051ben[0]['PENJUD'] + $r051ben[0]['EXDEPA']); ?></a>
      <br/>
      05 Imposto sobre a Renda Retido na Fonte <a class="colunavalor"> <?php echo ValorDecimal((($r051ben[0]['VALIRF'] + $r051ben[0]['IRFFER']) - $r051ben[0]['EXDPJU'])); ?></a>
      <br/> <br/>
    </div>
    
    <!-- Item 4 -->
    <div class="item">
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <div class="titulo"> <b>4. Rendimentos Isentos e Não Tributáveis </b> </div>
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <br/>
      01 Parc. Isenta, Aposent.,Reserva, Reforma e Pensão (65 anos ou +) <a class="colunavalor"> 
      <?php echo ValorDecimal($r051ben[0]['APOIRF'] + $r051ben[0]['APOFER'] + $r051ben[0]['APO13S'] + $r051ben[0]['APOLUC']); ?> </a>
      <br/>
      02 Diárias e Ajuda de Custo <a class="colunavalor"> <?php echo ValorDecimal($r051ben[0]['DIAAJU']); ?> </a>
      <br/>
      03 Prov.Pensão, Aposent, Reforma molestia grave, inval.permanente
      <a class="colunavalor"> <?php echo ValorDecimal($r051ben[0]['APOREF'] + $r051ben[0]['APOINV']); ?> </a>
      <br/>
      <?php // Tratamento para os sub itens 4 e 5 
        if ($dadosfilial[0]['POREMP'] != 0){
            $vl5 = $r051ben[0]['RENTEX'];
            $vl4 = 0;
        } else {
            $vl5 = 0;
            $vl4 = $r051ben[0]['RENTEX']; 
        }                
      ?>
      04 Lucro e divid.a partir 1996 pg p/ PJ (Lucro Real,Pres.Arbitr.)
      <a class="colunavalor"> <?php echo ValorDecimal($vl4); ?> </a>
      <br/>
      05 Valores Sócio Microempresa ou Peq.Porte exceto pro labore
      <a class="colunavalor"> <?php echo ValorDecimal($vl5); ?> </a>
      <br/>
      06 Indenizações rescisão de contrato de trabalho, PDV, Acid. Trabalho
      <a class="colunavalor"> <?php echo ValorDecimal($r051ben[0]['INDRES'] + $r051ben[0]['AVIPRE'] + $r051ben[0]['API13S']); ?> </a>
      <br/>
      <?php
      if (count($totcolisen) > 0){
        for ($r = 0;$r < count($totcolisen); $r++){
          if(strlen($seqitem4) == 1){ echo str_pad($seqitem4, 2, 0, STR_PAD_LEFT); } else echo $seqitem4;         
          echo " ".acentuacaook($totcolisen[$r]['DESTOT'])."<a class=\"colunavalor\">".ValorDecimal($totcolisen[$r]['VALTOT'])."</a> <br/>";
          $seqitem4++;
        }        
        echo "<br/>";     
      } else {
        if ($r051ben[0]['ABOVTR'] != 0) { 
        if(strlen($seqitem4) == 1){ echo str_pad($seqitem4, 2, 0, STR_PAD_LEFT); } else echo $seqitem4; ?> Abono Vale Transporte <a class="colunavalor"> 
      <?php echo ValorDecimal($r051ben[0]['ABOVTR']); $seqitem4++; ?> </a>
      <br/>
      <?php } ?>
      <?php if ($r051ben[0]['ABOPEC'] != 0) { 
        if(strlen($seqitem4) == 1){ echo str_pad($seqitem4, 2, 0, STR_PAD_LEFT); } else echo $seqitem4; ?> Abono de Férias <a class="colunavalor"> 
      <?php echo ValorDecimal($r051ben[0]['ABOPEC']); $seqitem4++; ?> </a>
      <br/>
      <?php } ?>
      <?php if ($r051ben[0]['VALPIS'] != 0) { 
        if(strlen($seqitem4) == 1){ echo str_pad($seqitem4, 2, 0, STR_PAD_LEFT); } else echo $seqitem4; ?> Valor do PIS <a class="colunavalor"> 
      <?php echo ValorDecimal($r051ben[0]['VALPIS']); $seqitem4++; ?> </a>
      <br/>
      <?php } ?>
      <?php if ($r051ben[0]['SALFAM'] != 0) { 
        if(strlen($seqitem4) == 1){ echo str_pad($seqitem4, 2, 0, STR_PAD_LEFT); } else echo $seqitem4; ?> Salário Família <a class="colunavalor"> 
      <?php echo ValorDecimal($r051ben[0]['SALFAM']); $seqitem4++; ?> </a>
      <br/>
      <?php } ?>
      <?php if ($r051ben[0]['ISEFER'] != 0) { 
        if(strlen($seqitem4) == 1){ echo str_pad($seqitem4, 2, 0, STR_PAD_LEFT); } else echo $seqitem4; ?> Férias <a class="colunavalor"> 
      <?php echo ValorDecimal($r051ben[0]['ISEFER']); $seqitem4++; ?> </a>
      <br/>
      <?php } ?>
      <?php if ($r051ben[0]['VOLCOP'] != 0) { 
        if(strlen($seqitem4) == 1){ echo str_pad($seqitem4, 2, 0, STR_PAD_LEFT); } else echo $seqitem4; ?> Voluntário da Copa <a class="colunavalor"> 
      <?php echo ValorDecimal($r051ben[0]['VOLCOP']); $seqitem4++; ?> </a>
      <br/>
      <?php } ?>
      <?php if ($r051ben[0]['MEDRES'] != 0) { 
        if(strlen($seqitem4) == 1){ echo str_pad($seqitem4, 2, 0, STR_PAD_LEFT); } else echo $seqitem4; ?> Bolsa Médico-Residente <a class="colunavalor"> 
      <?php echo ValorDecimal($r051ben[0]['MEDRES']); $seqitem4++; ?> </a>
      <br/>
      <?php } ?>
      <?php if ($r051ben[0]['RENISE'] != 0) { 
        if(strlen($seqitem4) == 1){ echo str_pad($seqitem4, 2, 0, STR_PAD_LEFT); } else echo $seqitem4; ?> Participação Resultados <a class="colunavalor"> 
      <?php echo ValorDecimal($r051ben[0]['RENISE']); $seqitem4++; ?> </a>
      <br/>
      <?php } ?>
      <br/>
      
      <?php } ?>
    </div>
    
    <!-- Item 5 --> 
    <div class="item">
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <div class="titulo"><b>5. Rendimentos Sujeitos a Tributação Exclusiva (Rend. Líquido)</b> </div>
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <br/>
      01 Décimo Terceiro Salário <a class="colunavalor"> <?php echo ValorDecimal($r051ben[0]['VAL13S']); ?> </a>
      <br/>
      02 IRRF 13º Salário <a class="colunavalor"> <?php echo ValorDecimal($r051ben[0]['IRF13S']); ?> </a>
      <br/>
      <?php if ($retplr[0]['PARLUC'] != 0) { ?>
        03 Participação nos Lucros ou Resultador (PLR) <a class="colunavalor"> <?php echo ValorDecimal($retplr[0]['PARLUC']); ?> </a>
      <br/>
      <?php } ?>
      <br/>
    </div>
    
    <!-- Item 6 -->  
    <div class="item">
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <div class="titulo"><b>6.Rendimentos Recebidos Acumuladamente- Art.12-A da Lei nº7.713, de 1988 (sujeitos a trib. excl.) </b></div>
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>   
      <br/>
      6.1 Natureza do Processo:  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Quantidade de meses: <a class="colunavalor"> <?php echo ValorDecimal(0); ?> </a>
      <br/>
      Natureza do rendimento: 
      <br/>
      01 Total dos rendimentos tributáveis (inclusive férias e 13º salário) <a class="colunavalor"> <?php echo ValorDecimal(0); ?> </a>
      <br/>
      02 Exclusão: Despesas com a ação judicial <a class="colunavalor"> <?php echo ValorDecimal(0); ?> </a>
      <br/>
      03 Dedução: Contribuição previdenciária oficial <a class="colunavalor"> <?php echo ValorDecimal(0); ?> </a>
      <br/>
      04 Dedução: Pensão alimentícia (Preencher também o quadro 7) <a class="colunavalor"> <?php echo ValorDecimal(0); ?> </a>
      <br/>
      05 Imposto sobre a renda retido na fonte <a class="colunavalor"> <?php echo ValorDecimal(0); ?> </a>
      <br/>
      06 Rendimentos isentos de pensão, proventos de aposentadoria ou reforma por moléstia grave
      <br/>
      ou aposentadoria ou reforma por acidente em serviço <a class="colunavalor"> <?php echo ValorDecimal(0); ?> </a> 
      <br/><br/>
    <div/>
    
    <!-- Item 7 -->
    <div class="item">
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <div class="titulo"><b>7. Informações Complementares </b></div>
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <br/>     
      <?php 
      /* -- TOTALIZADORES -- */
      if (count($totcol) > 0){
        for ($k = 0;$k < count($totcol); $k++){
          echo "&nbsp&nbsp&nbsp".acentuacaook($totcol[$k]['DESTOT'])."<a class=\"colunavalor\">".ValorDecimal($totcol[$k]['VALTOT'])."</a> <br/>";        
        }
        
        echo "<br/>";     
      }      
      /* -- PENSAO JUDICIAL -- */
      $esp = 1;
      
      if (count($depjud) > 0){
        for($d=0;$d < count($depjud); $d++){             
          
          echo "Beneficiário/CPF Pensão: ".$depjud[$d]['NOMDEP']." / ".maskcpf($depjud[$d]['NUMCPF'], 1)."<br/>";                            
          $valorpen = ValorDepPensao($emp, $cad, $depjud[$d]['CODDEP']);      
          
          for($i=0;$i < count($valorpen); $i++){                            
              
            if ($valorpen[$i]['TIPPEN'] == 0){
              echo "Valor total Pensão (Sem 13º Salário) <a class=\"colunavalor\">". ValorDecimal($valorpen[$i]['VALPEN'])."</a> <br/>";    
            } else if ($valorpen[$i]['TIPPEN'] == 1){
              echo "Valor Pensão 13º Salário <a class=\"colunavalor\">". ValorDecimal($valorpen[$i]['VALPEN'])."</a> <br/>";
            }             
          }         
          if ($esp < count($depjud)){
            echo "<br/>"; 
            $esp++;
          }              
        }       
      }     
      /* -- PLANO DE SAUDE - EMPRESARIAL --  */
      for ($i = 0; $i < count($ver1ic); $i++){
        
        $planosic = PlanoSaudeInfComp($emp, 1, $cad, AuxDatIni(), AuxDatFim());
        
        if (count($planosic) > 0){ ?>
          Plano de Saúde - Empresarial <br/> <?php 
        }
        
        for ($i = 0; $i < count($planosic); $i++){
                      
          if($opeant !== $planosic[$i]['NUMCGC']){   
            echo "<br/> Operadora: ".maskcnpj($planosic[$i]['NUMCGC'])." / ".$planosic[$i]['NOMOEM']."<br/>";
            $opeant = $planosic[$i]['NUMCGC'];
          }  
          
          if ($planosic[$i]['CAD'] == $cad){
            echo "&nbsp&nbsp&nbsp&nbsp&nbspTitular <a class=\"colunavalor\">".ValorDecimal($planosic[$i]['MENS'] + $planosic[$i]['COPART'])."</a> <br/>";                    
          } 
          else {
            echo "&nbsp&nbsp&nbsp&nbsp&nbsp".maskcpf($planosic[$i]['NUMCPF'], 1)." - ".$planosic[$i]['NOME']."&nbsp&nbsp&nbsp&nbspNasc: ".$planosic[$i]['DATNAS']."<a class=\"colunavalor\">".ValorDecimal($planosic[$i]['MENS'] + $planosic[$i]['COPART'])."</a> <br/>";
          }          
        }                                                       
      }
      /* -- PREVIDENCIA PRIVADA -- */
      if (count($prevp) > 0)
        echo "Detalhamento da contribuição à previdência complementar e FAP: <br/>";  
      
      for ($i =0; $i < count($prevp); $i++){
        
          if($opeant !== $prevp[$i]['NUMCGC']){   
            echo "<br/> Operadora: ".maskcnpj($prevp[$i]['NUMCGC'])."&nbsp&nbsp".$prevp[$i]['NOMOEM']."<br/>";
            $opeant = $prevp[$i]['NUMCGC'];
          } 
            
          if ($prevp[$i]['RENTOT'] == 'P')        
            $auxprev = "Previdência Complementar ";    
          
          if ($prevp[$i]['RENTOT'] == 'F')           
            $auxprev = "Dedução - FAPI";              
          
          if ($prevp[$i]['RENTOT'] == 'S')         
            $auxprev = "Fundo Previdência Servidor Público";             
          
          if ($prevp[$i]['RENTOT'] == 'A')          
            $auxprev = "Contribuição Ente Público Patrocinador";             
          
          if ($prevp[$i]['RENTOT'] == 'E')          
            $auxprev = "Exigibilidade Previdência Privada";            
          
          if ($prevp[$i]['RENTOT'] == 'D')           
            $auxprev = "Exigibilidade Dedução - FAPI";          
          
          if ($prevp[$i]['RENTOT'] == 'U')          
            $auxprev = "Exigibilidade Fundo Previdência Servidor Público";             
          
          if ($prevp[$i]['RENTOT'] == 'R')          
            $auxprev = "Exigibilidade Contribuição Ente Público Patrocinador";
          
          if ($prevp[$i]['TIPPAG'] == 1)
            $auxprev .= "(Normal)";
          else
            $auxprev.= "(13º)";
          
          echo "&nbsp&nbsp&nbsp".$auxprev."<a class=\"colunavalor\">".ValorDecimal($prevp[$i]['VALTOT'])."</a> <br/>";         
      }
      
      ?>
    <br/>
    </div>   
    <!-- Item 8 -->
    <div class="item quebra_pagina">
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <div class="titulo"><b>8. Responsável pelas informações </b></div>
      <p style="border-top: 2px #000 solid; margin-top: 0px; margin-bottom: 0px;"></p>
      <br/>
      Nome: FRANCISCO DE ASSIS GODINHO PIMENTEL &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Data: 28/02/2018 &nbsp&nbsp&nbsp&nbsp&nbsp Assinatura:
      <br/>
      Dispensada a assinatura de acordo com IN RFB 1.215/2011 art. 2.
      <br/>
      Aprovado pela IN RFB nº 1.682, de 28 dezembro de 2016.     
    </div>   
    
<!-- ABRIR TELA DE IMPRESSÃO AO ABRIR A PÁGINA --> 
<script type="text/javascript">
  window.onload = function(){ javascript:window.print(); };
</script>   
    </body>
</html>