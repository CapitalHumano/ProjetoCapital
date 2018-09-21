<?php

include_once "conectar.php";

function AuxDatIni() {
    $inicial = '01/01/2017';
    return date('m/d/Y', strtotime($inicial));
}

function AuxDatFim() {
    $final = '12/31/2017';
    return date('m/d/Y', strtotime($final));
}

function maskcpf($xcpf, $xtipo){       
   
  if ($xcpf == 0){ 
    if($xtipo == 1)
      $cpf = "000.000.000-00";    
    if($xtipo == 2)   
      $cpf = " ";
  }
  else if (strlen($xcpf) < 11) {
    $j = strlen($xcpf);
    $azero = "";
    
    while ($j != 11){
      $azero .= "0";
      $j++;
    }
   
    $cpf = $azero.$xcpf;                                
    $cpf = mask($cpf,'###.###.###-##');               
    } else { 
      $cpf = mask($xcpf,'###.###.###-##');
    }   
    
  return $cpf;  
}

function maskcnpj($xcnpj){
    
  if (strlen($xcnpj) < 15) {
    $j = strlen($xcnpj);
    $azero = "";
    
    while ($j != 15){
      $azero .= "0";
      $j++;
    }
   
    $cnpj = $azero.$xcnpj;                                
    $cnpj = mask($cnpj,'###.###.###/####-##');               
    } else { 
      $cnpj = mask($xcnpj,'###.###.###/####-##');
    }  
 
  return $cnpj;  
}

function DadosFilial($numemp, $codfil) {

    $con = conectarComPdo();
    try {
        $sql = $con->prepare("SELECT R030FIL.NUMCGC, R030FIL.RAZSOC, R030FIL.DDITEL, R030FIL.DDDTEL, 
                                     R030FIL.NUMTEL, R030FIL.ENDFIL, R030FIL.ENDNUM, R030EMP.POREMP, 
                                     R074BAI.NOMBAI, R074CID.NOMCID, R074CID.ESTCID
                                FROM R030FIL, R074BAI, R074CID, R030EMP
                               WHERE R030EMP.NUMEMP = R030FIL.NUMEMP
                                 AND R030FIL.CODBAI = R074BAI.CODBAI
                                 AND R030FIL.CODCID = R074CID.CODCID
                                 AND R074BAI.CODCID = R074CID.CODCID
                                 AND R030FIL.NUMEMP = ?
                                 AND R030FIL.CODFIL = ?");
        $sql->bindValue(1, $numemp);
        $sql->bindValue(2, $codfil);

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $sql->execute();

        return $sql->fetchAll();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function RedimentosInforme($numemp, $numcad, $datfim) {
    $con = conectarComPdo();
    try {
        $sql = $con->prepare("SELECT R050REC.CODREC, R050REC.DESREC, R051BEN.CODRET, 
                                     R034FUN.NUMCAD, R034FUN.NUMEMP, R051COL.ANOREN,
                                     R051COL.TIPIRF, R051COL.CPFCGC, R051COL.ORIANU
                                FROM R034FUN, R051COL, R050REC, R051BEN
                               WHERE R034FUN.NUMCAD = R051COL.NUMCAD
                                 AND R034FUN.NUMEMP = R051COL.NUMEMP
                                 AND R034FUN.TIPCOL = R051COL.TIPCOL
                                 AND R051COL.NUMEMP = R051BEN.NUMEMP
                                 AND R051COL.CODFIL = R051BEN.CODFIL
                                 AND R051COL.CODRET = R051BEN.CODRET
                                 AND R051COL.TIPIRF = R051BEN.TIPIRF
                                 AND R051COL.CPFCGC = R051BEN.CPFCGC
                                 AND R051COL.ORIANU = R051BEN.ORIANU
                                 AND R051BEN.CODRET = R050REC.CODREC
                                 AND R051BEN.CODRET <> 1889  
                                 AND R051BEN.CODRET <> 3562 
                                 AND R034FUN.NUMEMP = ?
                                 AND R034FUN.NUMCAD = ?
                                 AND R051COL.ANOREN = ?");
        $sql->bindValue(1, $numemp);
        $sql->bindValue(2, $numcad);
        $sql->bindValue(3, $datfim);

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $sql->execute();

        return $sql->fetchAll();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function RetornaR051BEN($numemp, $codfil, $codret, $tipirf, $cpfcgc, $datini, $datfim) {

    $con = conectarComPdo();
    try {
        $sql = $con->prepare("SELECT SUM(BASIRF) AS BASIRF, SUM(BASFER) BASFER, SUM(BAS13S) BAS13S, SUM(VALIRF) VALIRF, 
                                     SUM(IRFFER) IRFFER, SUM(IRF13S) IRF13S, SUM(PENJUD) PENJUD, SUM(PEN13S) PEN13S,
                                     SUM(LUCREA) LUCREA, SUM(IRFLRE) IRFLRE, SUM(ABOVTR) ABOVTR, SUM(ABOPEC) ABOPEC,
                                     SUM(VALPIS) VALPIS, SUM(SALFAM) SALFAM, SUM(RENISE) RENISE, SUM(PARLUC) PARLUC,
                                     SUM(LUCARB) LUCABR, SUM(RENEXT) RENEXT, SUM(CONPRE) CONPRE, SUM(PREPRI) PREPRI,
                                     SUM(APOREF) APOREF, SUM(DIAAJU) DIAAJU, SUM(APOINV) APOINV, SUM(RENTEX) RENTEX,
                                     SUM(INDRCS) INDRCS, SUM(AVIPRE) AVIPRE, SUM(VAL13S) VAL13S, SUM(EXDEPA) EXDEPA,
                                     SUM(EXDEPP) EXDEPP, SUM(EXBASI) EXBASI, SUM(EXDEDI) EXDEDI, SUM(EXDFTA) EXDFTA,
                                     SUM(EXDPJU) EXDPJU, SUM(EXBA13) EXBA13, SUM(EXDE13) EXDE13, SUM(EXDF13) EXDF13,
                                     SUM(EXDP13) EXDP13, SUM(EXPP13) EXPP13, SUM(EXPA13) EXPA13, SUM(EXDD13) EXDD13,
                                     SUM(APOIRF) APOIRF, SUM(APOFER) APOFER, SUM(APO13S) APO13S, SUM(APOLUC) APOLUC,
                                     SUM(API13S) API13S, SUM(ISEFER) ISEFER, SUM(VALDEP) VALDEP, SUM(VOLCOP) VOLCOP,
                                     SUM(MEDRES) MEDRES 
                                FROM R051REN
                               WHERE NUMEMP = ? 
                                 AND CODFIL = ? 
                                 AND CODRET = ? 
                                 AND TIPIRF = ? 
                                 AND CPFCGC = ? 
                                 AND CMPREN >= ? 
                                 AND CMPREN <= ? 
                                 AND CODRET <> 1889 
                                 AND CODRET <> 3562 
                                 AND ORIANU <> 4");
        $sql->bindValue(1, $numemp);
        $sql->bindValue(2, $codfil);
        $sql->bindValue(3, $codret);
        $sql->bindValue(4, $tipirf);
        $sql->bindValue(5, $cpfcgc);
        $sql->bindValue(6, $datini);
        $sql->bindValue(7, $datfim);

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $sql->execute();

        return $sql->fetchAll();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function RetornaPLR($numemp, $codfil, $tipirf, $cpfcgc, $datini, $datfim) {

    $con = conectarComPdo();
    try {
        $sql = $con->prepare("SELECT SUM(PENLUC) PENLUC, SUM(PARLUC) PARLUC 
                                FROM R051REN 
                               WHERE NUMEMP = ?
	                         AND CODFIL = ? 
	                         AND CODRET = 3562 
	                         AND TIPIRF = ?
	                         AND CPFCGC = ?
	                         AND CMPREN >= ? 
	                         AND CMPREN <= ?");
        $sql->bindValue(1, $numemp);
        $sql->bindValue(2, $codfil);
        $sql->bindValue(3, $tipirf);
        $sql->bindValue(4, $cpfcgc);
        $sql->bindValue(5, $datini);
        $sql->bindValue(6, $datfim);

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $sql->execute();

        return $sql->fetchAll();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function Ver1InformacoesComp ($numemp, $codfil, $codret, $tipirf, $cpfcgc, $orianu) {
    
    if (($codret !== 422) && ($codret !== 473) && ($codret !== 481) && ($codret !== 490) && ($codret !== 5192) && ($codret !== 5286) &&
        ($codret !== 9412) && ($codret !== 9427) && ($codret !== 9453) && ($codret !== 9466) && ($codret !== 9478)){
        
      $con = conectarComPdo();
      try {
          $sql = $con->prepare("SELECT * FROM R051COL
                                 WHERE NUMEMP = ?
                                   AND CODFIL = ?
                                   AND CODRET = ?
                                   AND TIPIRF = ?
                                   AND CPFCGC = ?
                                   AND ORIANU = ?
                                   AND ANOREN = ?
                                 ORDER BY SEQCOL");
          $sql->bindValue(1, $numemp);
          $sql->bindValue(2, $codfil);
          $sql->bindValue(3, $codret);
          $sql->bindValue(4, $tipirf);
          $sql->bindValue(5, $cpfcgc);
          $sql->bindValue(6, $orianu);
          $sql->bindValue(7, AuxDatFim());
          
          $sql->setFetchMode(PDO::FETCH_ASSOC);
          $sql->execute();
                     
          return $sql->fetchAll();                
          
        } catch (Exception $ex) {
            echo "Erro: " . $ex->getMessage();   
          }
    }       
}

function TransfInfComp ($numemp, $tipcol, $numcad, $empatu, $cadatu, $datalt) {
            
      $con = conectarComPdo();
      try {
          $sql = $con->prepare("SELECT R038HFI.DATALT, R034FUN.DATADM 
                                  FROM R038HFI, R034FUN 
                                 WHERE R038HFI.NUMEMP = R034FUN.NUMEMP 
                                   AND R038HFI.TIPCOL = R034FUN.TIPCOL 
                                   AND R038HFI.NUMCAD = R034FUN.NUMCAD 
                                   AND R038HFI.NUMEMP = ? 
                                   AND R038HFI.TIPCOL = ?
                                   AND R038HFI.NUMCAD = ?
                                   AND R038HFI.EMPATU = ?
                                   AND R038HFI.CADATU = ?
                                   AND R038HFI.DATALT <= ? 
                                 ORDER BY R038HFI.DATALT");
          $sql->bindValue(1, $numemp);
          $sql->bindValue(2, $tipcol);
          $sql->bindValue(3, $numcad);
          $sql->bindValue(4, $empatu);
          $sql->bindValue(5, $cadatu);
          $sql->bindValue(6, $datalt);
          
          $sql->setFetchMode(PDO::FETCH_ASSOC);
          $sql->execute();
                     
          return $sql->fetchAll();                
          
        } catch (Exception $ex) {
            echo "Erro: " . $ex->getMessage();   
          }       
}

function PlanoSaudeInfComp ($numemp, $tipcol, $numcad, $datini, $datfim) {
            
      $con = conectarComPdo();
      try {
          $sql = $con->prepare("SELECT R032OEM.NUMCGC, R032OEM.NOMOEM, 1 TIPO, R034FUN.NUMCPF, CONVERT(VARCHAR(10),R034FUN.DATNAS,103) DATNAS, R034FUN.NUMCAD CAD, R034FUN.NOMFUN NOME,
                                       SUM(R051SAC.VALDES) MENS, SUM(R051SAC.VALCOP) COPART
                                  FROM R051SAC, R044CAL, R032OEM, R034FUN
                                 WHERE R051SAC.NUMEMP = ?
                                   AND R051SAC.TIPCOL = ?
                                   AND R051SAC.NUMCAD = ?
                                   AND R044CAL.NUMEMP = R051SAC.NUMEMP 
				   AND R044CAL.CODCAL = R051SAC.CODCAL 
				   AND R044CAL.DATPAG >= ? 
				   AND R044CAL.DATPAG <= ?
				   AND R032OEM.CODOEM = R051SAC.CODOEM 
				   AND R034FUN.NUMEMP = R051SAC.NUMEMP 
				   AND R034FUN.TIPCOL = R051SAC.TIPCOL 
				   AND R034FUN.NUMCAD = R051SAC.NUMCAD 
                              GROUP BY R032OEM.NUMCGC, R032OEM.NOMOEM, R034FUN.NUMCPF, R034FUN.DATNAS, R034FUN.NUMCAD,  R034FUN.NOMFUN    
                                 UNION 
                                SELECT R032OEM.NUMCGC, R032OEM.NOMOEM, 2 TIPO, R036DEP.NUMCPF, CONVERT(VARCHAR(10), R036DEP.DATNAS, 103) DATNAS, R036DEP.CODDEP CAD, R036DEP.NOMDEP NOME,
                                       SUM(R051SAD.VALDES) MENS, SUM(R051SAD.VALCOP) COPART
                                  FROM R051SAD, R044CAL, R032OEM, R036DEP
                                 WHERE R051SAD.NUMEMP = ? 
				   AND R051SAD.TIPCOL = ? 
				   AND R051SAD.NUMCAD = ?
		          	   AND R044CAL.NUMEMP = R051SAD.NUMEMP 
		 	           AND R044CAL.CODCAL = R051SAD.CODCAL 
				   AND R044CAL.DATPAG >= ?
				   AND R044CAL.DATPAG <= ?
				   AND R032OEM.CODOEM = R051SAD.CODOEM 
				   AND R036DEP.NUMEMP = R051SAD.NUMEMP 
				   AND R036DEP.TIPCOL = R051SAD.TIPCOL 
				   AND R036DEP.NUMCAD = R051SAD.NUMCAD 
				   AND R036DEP.CODDEP = R051SAD.CODDEP
                              GROUP BY R032OEM.NUMCGC, R032OEM.NOMOEM, R036DEP.NUMCPF, R036DEP.DATNAS, R036DEP.CODDEP,  R036DEP.NOMDEP 
                              ORDER BY 1, 3, 4, 5, 6");
          
          $sql->bindValue(1, $numemp);
          $sql->bindValue(2, $tipcol);
          $sql->bindValue(3, $numcad);
          $sql->bindValue(4, $datini);
          $sql->bindValue(5, $datfim);
          $sql->bindValue(6, $numemp);
          $sql->bindValue(7, $tipcol);
          $sql->bindValue(8, $numcad);
          $sql->bindValue(9, $datini);
          $sql->bindValue(10, $datfim);
          
          $sql->setFetchMode(PDO::FETCH_ASSOC);
          $sql->execute();
                     
          return $sql->fetchAll();                
          
        } catch (Exception $ex) {
            echo "Erro: " . $ex->getMessage();   
          }       
}

function TotalizadorCol ($numemp, $codfil, $codret, $cpf, $tipirf,$rentot) {
            
      $con = conectarComPdo();
      try {
          $sql = $con->prepare("SELECT R051TOT.CODTOT, R051TOT.FILCMP, R008TOT.DESTOT, SUM(R051TOT.VALTOT) VALTOT
                                  FROM R051TOT, R008TOT
                                 WHERE R008TOT.TABEVE = R051TOT.TABEVE AND R008TOT.CODTOT = R051TOT.CODTOT 
                                   AND R051TOT.NUMEMP = ?
                                   AND R051TOT.CODFIL = ?
                                   AND R051TOT.CODRET = ? 
                                   AND R051TOT.CPFCGC = ?
                                   AND R051TOT.RENTOT = ? 
                                   AND R051TOT.TIPIRF = ?
                                   AND R051TOT.CMPREN >= ?
                                   AND R051TOT.CMPREN <= ?
                              GROUP BY R051TOT.CODTOT, R051TOT.FILCMP, R008TOT.DESTOT 
                              ORDER BY R051TOT.CODTOT, R051TOT.FILCMP");          
          $sql->bindValue(1, $numemp);
          $sql->bindValue(2, $codfil);
          $sql->bindValue(3, $codret);
          $sql->bindValue(4, $cpf);
          $sql->bindValue(5, $rentot);
          $sql->bindValue(6, $tipirf);
          $sql->bindValue(7, AuxDatIni());
          $sql->bindValue(8, AuxDatFim());
          
          $sql->setFetchMode(PDO::FETCH_ASSOC);
          $sql->execute();
                     
          return $sql->fetchAll();                
          
        } catch (Exception $ex) {
            echo "Erro: " . $ex->getMessage();   
          }       
}

function DepPensao ($numemp, $numcad) {
            
      $con = conectarComPdo();
      try {
          $sql = $con->prepare("SELECT CODDEP, NOMDEP, NUMCPF, DATNAS 
                                  FROM R036DEP 
                                 WHERE NUMEMP = ?
                                   AND TIPCOL = 1  
                                   AND NUMCAD = ? 
                                   AND PENJUD = 'S'");          
          $sql->bindValue(1, $numemp);
          $sql->bindValue(2, $numcad);
          
          $sql->setFetchMode(PDO::FETCH_ASSOC);
          $sql->execute();
                     
          return $sql->fetchAll();                
          
        } catch (Exception $ex) {
            echo "Erro: " . $ex->getMessage();   
          }       
}

function ValorDepPensao ($numemp, $numcad, $coddep) {
            
      $con = conectarComPdo();
      try {
          $sql = $con->prepare("SELECT SUM(VALPEN) VALPEN, TIPPEN FROM R051DEP
                                  WHERE NUMEMP = ?
                                    AND TIPCOL = 1
                                    AND NUMCAD = ?
                                    AND CODDEP = ?  
                                    AND CMPREN >= ?
                                    AND CMPREN <= ?
                               GROUP BY TIPPEN");          
          $sql->bindValue(1, $numemp);
          $sql->bindValue(2, $numcad);
          $sql->bindValue(3, $coddep);
          $sql->bindValue(4, AuxDatIni());
          $sql->bindValue(5, AuxDatFim());
          
          $sql->setFetchMode(PDO::FETCH_ASSOC);
          $sql->execute();
                     
          return $sql->fetchAll();                
          
        } catch (Exception $ex) {
            echo "Erro: " . $ex->getMessage();   
          }       
}

function PrevidenciaPriv ($numemp, $codfil, $codret, $tipirf, $cpf) {
    
  $con = conectarComPdo();
  try {
    $sql = $con->prepare("SELECT R032OEM.NOMOEM, R032OEM.NUMCGC, R051TOT.RENTOT, R051TOT.TIPPAG, SUM(R051TOT.VALTOT) VALTOT
                            FROM R051TOT, R032OEM 
                           WHERE R032OEM.CODOEM = R051TOT.CODOEM
                             AND R051TOT.NUMEMP = ?
                             AND R051TOT.CODFIL = ?
                             AND R051TOT.CODRET = ?
                             AND R051TOT.TIPIRF = ? 
                             AND R051TOT.CPFCGC = ? 
                             AND R051TOT.CMPREN >= ?
                             AND R051TOT.CMPREN <= ?
                             AND R051TOT.RENTOT IN ('P', 'F', 'S', 'A', 'E', 'D', 'U', 'R')
                             AND ORIANU <> 4
                        GROUP BY R032OEM.NOMOEM, R032OEM.NUMCGC, R051TOT.RENTOT, R051TOT.TIPPAG
                        ORDER BY R032OEM.NOMOEM, R051TOT.RENTOT, R051TOT.TIPPAG");
    
          $sql->bindValue(1, $numemp);
          $sql->bindValue(2, $codfil);
          $sql->bindValue(3, $codret);
          $sql->bindValue(4, $tipirf);
          $sql->bindValue(5, $cpf);
          $sql->bindValue(6, AuxDatIni());
          $sql->bindValue(7, AuxDatFim());
          
          $sql->setFetchMode(PDO::FETCH_ASSOC);
          $sql->execute();
                     
          return $sql->fetchAll();                
          
        } catch (Exception $ex) {
            echo "Erro: " . $ex->getMessage();   
          }        
}

function CodFilTransf ($cpf) {
    
  $con = conectarComPdo();
  try {
    $sql = $con->prepare("SELECT CPFCGC,CODFIL FROM R051REN 
                           WHERE CPFCGC = ?
                        GROUP BY CPFCGC, CODFIL");
    
          $sql->bindValue(1, $cpf);
          
          $sql->setFetchMode(PDO::FETCH_ASSOC);
          $sql->execute();
                     
          return $sql->fetchAll();                
          
        } catch (Exception $ex) {
            echo "Erro: " . $ex->getMessage();   
          }        
}