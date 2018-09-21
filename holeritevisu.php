<?php
session_start();
include_once "func/funcoes.php";

if (isset($_SESSION['buscafeita'])):
    $col = $_SESSION['col'];
    $cad = $_SESSION['cad'];
    $emp = $_SESSION['emp'];
    $razemp = $_SESSION['razemp'];
    $codbanco = $_SESSION['codban'];
    $conbanco = $_SESSION['conban'];
    $digbanco = $_SESSION['digban'];
else:
    header('Location: http://portal.capitalhumano.com.br/tela_nlog.php');
endif;

/*$gbase = 0;
$implinha = 0;*/
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	    <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title> VISUALIZAR / IMPRIMIR </title>
        <link href="assets/css/poshole.css" rel="stylesheet"> 
    </head>
    <body>
	   <b> Para imprimir o demonstrativo, </b> <a href="javascript:window.print()">Clique aqui</a>.
		<hr>
        <div id="holeimg">
          <img src="imagens/f1_1.jpg"> </img>
            <?php
              if (isset($_GET['codcal'])) {
                // ----- CARREGA AS VARIAVEIS COM O RESULTADO DAS FUNÇÕES PARA MOSTRAR NO HOLERITE
                $codcal = $_GET['codcal'];
                $a = MostraEve($codcal, $emp, $cad); // MOSTRA OS EVENTOS			 
                $mesref = CarregaMesRef($codcal, $emp);
                $mostraref = $mesref[0]['PERREF']; // MES/ANO
                $bassal = CarregaBaseSal($codcal, $emp, $cad);

                // GAMB. COM A DATA DA ADM E O BUG 1969
                $ddat = RetornaDatAdm($emp, $cad);
                $datadm = $ddat[0]['DATADM'];
                $compref = date('m-d-Y', (strtotime($mostraref)));
                $compadm = date('d-m-Y', (strtotime(DataBanco2($datadm))));

                if (strtotime($compref) < strtotime($compadm))
                  $loc = $datadm;
                else
                  $loc = $mostraref;
                // FIM DA GAMB.

                $nomebanco = CarregaBanco($codbanco); // CARREGA NOME DO BANCO
                $nomelocal = CarregaLocal($emp, $cad, $loc); // CARREGA O LOCAL REF. AO PERIODO DO HOL.
                $cargo = CarregaCargo($cad, $emp, $loc); // CARREGA O CARGO REF. AO PERIODO DO HOL.

                $mostraref = substr($mostraref, 3);
                // ------------------- CABEÇALHO -----------------			 
                echo "<a class=\"datref\">" . $mostraref . "</a>";  // 1º LINHA
                echo "<a class=\"nomemp\">" . $emp . " - " . acentuacaook($razemp) . "</a>";
                echo "<a class=\"nomloc\">" . acentuacaook($nomelocal[0]["NOMLOC"]) . "</a>"; // 2º LINHA
                echo "<a class=\"numcad\">" . $cad . "</a>";
                echo "<a class=\"nomcol\">" . $col . "</a> ";
                echo "<a class=\"datadm\">" . $datadm . "</a>"; // 3º LINHA
                echo "<a class=\"descar\">" . acentuacaook($cargo[0]['TITRED']) . "</a>";
                echo "<a class=\"desban\">" . $nomebanco[0]['NOMBAN'] . "</a>"; // 4º LINHA PT1
                echo "<a class=\"conban\">" . $conbanco . "</a>";
                echo "<a class=\"digban\">" . $digbanco . "</a>"; // 4º LINHA PT2
                // ------------------- EVENTOS -------------------
                $ptopcod = 128;

                foreach ($a as $b):
                  /*$naoimp1 = 0;*/
                    
                  /*if (($gbase == 0) && (($b["TIPEVE"] == 5) || $b["CODEVE"] == 300)){
                    $ptopcod += 3;  
                    $gbase = 1;
                    echo "<a style=\"position: absolute; top: " . $ptopcod . "px; left: 40px;\"> --- ------------ Base / Outros ------------ --- </a>";
                    $ptopcod += 15; 
                  }*/
                  
                  if ($b["CODEVE"] == 220)
                    $sbfgts = $b["VALEVE"]; 
                    
                  if (($b['TIPEVE'] != 4) && ($b['CODEVE'] != 300)){
                    echo "<a style=\"position: absolute; top: " . $ptopcod . "px; left: 9px;\">" . $b["CODEVE"] . "</a>";
                    echo "<a style=\"position: absolute; top: " . $ptopcod . "px; left: 40px;\">" . acentuacaook($b["DESEVE"]) . "</a>";
                    echo "<a style=\"position: absolute; top: " . $ptopcod . "px; left: 252px; float: right; width: 50px; text-align: right;\">" . str_replace('.', ',', AjustaZerado($b["REFEVE"])) . "</a>";
                  
                    /*$naoimp1 = 1;*/                    
                  }

                  if (($b["TIPEVE"] == 1) || ($b["TIPEVE"] == 2)) {
                    $totvenc = $totvenc + $b["VALEVE"];
                    echo "<a style=\"position: absolute; top: " . $ptopcod . "px; left: 338px; float: right; width: 60px; text-align: right;\">" . AjustaZerado($b["VALEVE"]) . "</a>";
                  }
                  
                  if (($b["TIPEVE"] == 3)) {
                    $totdesc = $totdesc + $b["VALEVE"];
                    echo "<a style=\"position: absolute; top: " . $ptopcod . "px; left: 448px; float: right; width: 50px; text-align: right;\">" . AjustaZerado($b["VALEVE"]) . "</a>";
                  }
                  
                  if (($b["TIPEVE"] == 5) || ($b["TIPEVE"] == 6)) {
                   /* $implinha = 1; */  
                      
                    if ($b["VALEVE"] < 99999) 
                      $bugppx = "448px;";
                    else
                      $bugppx = "443px";                      
                      
                    echo "<a style=\"position: absolute; top: " . $ptopcod . "px; left: ".$bugppx."; float: right; width: 50px; text-align: right;\">" . AjustaZerado($b["VALEVE"]) . "</a>";                                                                           
                  } 
                  
                  if(($b["CODEVE"]) == 300){
                    /*$implinha = 1;*/
                    echo "<a style=\"position: absolute; top: 625px; left: 139px; float: right; width: 60px; text-align: right;\">" . AjustaZerado($b["VALEVE"]) . "</a>";  
                  }
                  
                  /*if ($naoimp1 == 1)*/
                  $ptopcod += 12;
                endforeach;
                
                /*if (($gbase == 0) && ($implinha == 1)){
                  $ptopcod += 3;
                  $gbase = 1;
                  echo "<a style=\"position: absolute; top: " . $ptopcod . "px; left: 40px;\"> --- ------------ Base / Outros ------------ --- </a>";
                  $ptopcod += 15; 
                }*/             
                
                 /*--- BASES ---*/
                
                /* Base FGTS */
                $valeve = BuscaBaseEv($emp, $cad, $codcal, "INCFGM");
                $resbase = $valeve[0]['SOMA'] - $valeve[0]['DIMINUI'];                 
                if ($resbase > 0)                  
                  $basfgts = $resbase + $sbfgts;                           
                
                /* Base FGTS 13º Salário */ 
                $valeve = BuscaBaseEv($emp, $cad, $codcal, "INCFGD");
                $resbase = $valeve[0]['SOMA'] - $valeve[0]['DIMINUI'];
                if ($resbase > 0)                  
                  $basfgts13 = $resbase;                
                    
                /* Base IRRF */ 
                $valeve = BuscaBaseEv($emp, $cad, $codcal, "INCIRM");
                $resbase = $valeve[0]['SOMA'] - $valeve[0]['DIMINUI'];
                if ($resbase > 0)                                   
                  $basirrf = $resbase;
                
                /* Base IRRF 13º */
                $valeve = BuscaBaseEv($emp, $cad, $codcal, "INCIRD");
                $resbase = $valeve[0]['SOMA'];
                if ($resbase > 0)                  
                  $basirrf13 = $resbase;               
                
                /* Base INSS */ 
                $valeve = BuscaBaseEv($emp, $cad, $codcal, "INCINM");
                $resbase = $valeve[0]['SOMA'] - $valeve[0]['DIMINUI'];
                $tetoinss = buscaTetoInss("01/".$mostraref);               
                if ($resbase > 0){ 
                  if ($resbase > $tetoinss[0]['TETFAI'])
                    $valinss = $tetoinss[0]['TETFAI'];
                  else
                    $valinss = $resbase;                 
                }
                
                /* Base INSS 13º */ 
                $valeve = BuscaBaseEv($emp, $cad, $codcal, "INCIND");
                $resbase = $valeve[0]['SOMA'] - $valeve[0]['DIMINUI'];
                
                if ($resbase > 0){ 
                  if ($resbase > $tetoinss[0]['TETFAI'])
                    $valinss13 = $tetoinss[0]['TETFAI'];
                  else
                    $valinss13 = $resbase;
                }    
                
                /* POSICAO DAS BASES */
                if ($basfgts13 == 0 && $basfgts > 0)
                  echo "<a style=\"position: absolute; top: 625px; left: 37px; float: right; width: 60px; text-align: right;\">" . AjustaZerado($basfgts) . "</a>";  
                else if ($basfgts13 > 0)
                  echo "<a style=\"position: absolute; top: 625px; left: 37px; float: right; width: 60px; text-align: right;\">" . AjustaZerado($basfgts13) . "</a>";    
                
                if ($basirrf13 == 0 && $basirrf > 0)
                  echo "<a style=\"position: absolute; top: 625px; left: 267px; float: right; width: 60px; text-align: right;\">" . AjustaZerado($basirrf) . "</a>";  
                else if ($basirrf13 > 0)
                  echo "<a style=\"position: absolute; top: 625px; left: 267px; float: right; width: 60px; text-align: right;\">" . AjustaZerado($basirrf13) . "</a>";    
                
                if ($valinss13 == 0 && $valinss > 0)
                  echo "<a style=\"position: absolute; top: 601px; left: 139px; float: right; width: 60px; text-align: right;\">" . AjustaZerado($valinss) . "</a>";  
                else if ($valinss13 > 0)
                  echo "<a style=\"position: absolute; top: 601px; left: 139px; float: right; width: 60px; text-align: right;\">" . AjustaZerado($valinss13) . "</a>";                                                  
                /* --- FIM BASES --- */                

                // ------------------- RESUMO DOS VALORES --------
                echo "<a class=\"bassal\">" . number_format($bassal[0]['SALEMP'], 2, ',', '.') . "</a>";
                echo "<a class=\"totvenc\">" . number_format($totvenc, 2, ',', '.') . "</a>";
                echo "<a class=\"totdesc\">" . number_format($totdesc, 2, ',', '.') . "</a>";
                $valliq = $totvenc - $totdesc;
                echo "<a class=\"valliq\"><b>" . number_format($valliq, 2, ',', '.') . "</b></a>";
                /*echo "<a class=\"ffrase\"><b> O valor líquido foi depositado em sua conta bancária. </b></a>";*/

                // ------------------- VERIFICA ANIVERSÁRIO ------
                // ------------------- RODA PÉ -------------------
//                echo "<a class=\"rvalli\">" . number_format($valliq, 2, ',', '.') . "</a>";
//                echo "<a class=\"rncol\">" . $col . "</a> ";
            }
            ?>	
        </div>  
    </body>
</html>
