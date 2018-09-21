<?php

include_once "conectar.php";
require 'PHPMailer/PHPMailerAutoload.php';


function buscacollogin($numcad,$senha,$numemp) {

  $con = conectarComPdo();
 
try{   
$sql = $con -> prepare ("SELECT R034FUN.NUMCAD,NOMFUN,R034FUN.NUMCPF,R034FUN.NUMEMP,CODESC,NOMEMP,CODBAN,CONBAN,DIGBAN,CODFIL,TIPADM                             
  			   FROM R034FUN,R030EMP,ACESSOSITE
                          WHERE R034FUN.NUMEMP = R030EMP.NUMEMP
                            AND R034FUN.NUMEMP = ACESSOSITE.NUMEMP                                                     
                            AND R034FUN.NUMCAD = ACESSOSITE.NUMCAD                                                           
                            AND R034FUN.TIPCOL = ACESSOSITE.TIPCOL
			    AND R034FUN.SITAFA <> 7
                            AND R034FUN.NUMCAD = :cad														
		            AND ACESSOSITE.SENUSU = :senha
			    AND R034FUN.NUMEMP = :emp");
$sql ->bindValue(":cad", $numcad);
$sql ->bindValue(":senha", $senha);
$sql ->bindValue(":emp", $numemp);
$sql ->execute();

if($sql ->rowCount() !== 0)
    {    
    $busca = $sql -> fetch(PDO::FETCH_ASSOC);
   
    $_SESSION['buscafeita'] = true;    
    $_SESSION['col'] = $busca['NOMFUN'];
    $_SESSION['cad'] = $busca['NUMCAD'];
    $_SESSION['emp'] = $busca['NUMEMP'];
    $_SESSION['razemp'] = $busca['NOMEMP'];
    $_SESSION['codban'] = $busca['CODBAN'];
    $_SESSION['conban'] = $busca['CONBAN'];
    $_SESSION['digban'] = $busca['DIGBAN'];
    $_SESSION['codesc'] = $busca['CODESC'];   
    $_SESSION['numcpf'] = $busca['NUMCPF'];
    $_SESSION['codfil'] = $busca['CODFIL'];
    $_SESSION['tipadm'] = $busca['TIPADM'];

    /*$numcpf = $busca['NUMCPF'];*/
	
    echo "<script> window.location=\"novoholerite.php\" </script>";	
     
    }
else{
    if (count($numcad) >= 1)
      {
       $msgerro = 'Usuário inválido ou Senha incorreta;'; 
       return $msgerro;
      }
    }
$con = null;
}    
catch(PDOException $e){
  echo "Erro: ".$e->getMessage();
}
}

function verDadosSenha($numcad,$numemp,$numcpf,$datnas,$nommae) {
    
  $con = conectarComPdo();

$datnas = DataBanco($datnas);
try{  
$sql = $con -> prepare ("SELECT R034FUN.NUMCAD,R034FUN.NUMEMP,R034FUN.TIPCOL FROM R034FUN,R034CPL,R036DEP
                                              WHERE R034FUN.NUMCAD = R034CPL.NUMCAD 
                                                AND R034FUN.NUMEMP = R034CPL.NUMEMP
                                                AND R034FUN.TIPCOL = R034CPL.TIPCOL
                                                AND R034FUN.NUMCAD = R036DEP.NUMCAD 
                                                AND R034FUN.NUMEMP = R036DEP.NUMEMP
                                                AND R034FUN.TIPCOL = R036DEP.TIPCOL
                                                AND R034FUN.NUMCAD = :cad
                                                AND R034FUN.NUMEMP = :emp
                                                AND R034FUN.NUMCPF = :cpf
                                                AND R034FUN.DATNAS = :dtnasc
                                                AND R036DEP.NOMDEP = :mae
                                                AND R036DEP.GRAPAR = 3
                                                AND R036DEP.TIPSEX = 'F'");
$sql ->bindValue(":cad", $numcad);
$sql ->bindValue(":emp", $numemp);
$sql ->bindValue(":cpf", $numcpf);
$sql ->bindValue(":dtnasc", $datnas);
$sql ->bindValue(":mae", $nommae);
$sql ->execute();

if($sql ->rowCount() !== 0)
    {    
    $busca = $sql -> fetch(PDO::FETCH_ASSOC);
   
    $_SESSION['dadosconf'] = true;
    $_SESSION['NUMCAD'] = $busca['NUMCAD'];
    $_SESSION['NUMEMP'] = $busca['NUMEMP'];
    $_SESSION['TIPCOL'] = $busca['TIPCOL'];
	
    echo "<script> window.location=\"alterasenha.php\" </script>"; 
     
    }
else{
    if (count($numcad) >= 1)
      {
	   $msgerro = 'Usuário inválido ou Senha incorreta;'; 
       return $msgerro;
      }
    }
$con = null;
}    
catch(PDOException $e){
  echo "Erro: ".$e->getMessage();
}
}

function InserirSenha($numcad,$numemp,$tipcol,$senha)
{
  $con = conectarComPdo();

try {
$sql = $con -> prepare("SELECT NUMCAD FROM ACESSOSITE 
                                     WHERE NUMCAD = :numcad
									   AND NUMEMP = :numemp 
									   AND TIPCOL = :tipcol");
$sql -> bindValue(':numcad',$numcad);
$sql -> bindValue(':numemp',$numemp);
$sql -> bindValue(':tipcol',$tipcol);
$sql -> execute();

if($sql -> rowCount() !== 0)
{
try {
$sql = $con -> prepare("UPDATE ACESSOSITE 
                           SET SENUSU = :senha
						 WHERE NUMCAD = :numcad 
						   AND NUMEMP = :numemp 
						   AND TIPCOL = :tipcol");
$sql -> bindValue(':numcad',$numcad);
$sql -> bindValue(':numemp',$numemp);
$sql -> bindValue(':tipcol',$tipcol);
$sql -> bindValue(':senha',$senha);
$sql -> execute();

$msg = "Senha atualizada com sucesso !";
}
catch(PDOException $e){
   echo "Erro: ".$e->getMessage();
}
}

else{

try {
$sql = $con -> prepare("INSERT INTO ACESSOSITE (NUMCAD,NUMEMP,TIPCOL,SENUSU,HORULT) VALUES (:numcad,:numemp,:tipcol,:senha,GETDATE())");
$sql -> bindValue(':numcad',$numcad);
$sql -> bindValue(':numemp',$numemp);
$sql -> bindValue(':tipcol',$tipcol);
$sql -> bindValue(':senha',$senha);
$sql -> execute();

$msg = "Senha cadastrada com sucesso !";
}
catch(PDOException $e){
   echo "Erro: ".$e->getMessage();
}
}

}
catch(PDOException $e){
   echo "Erro: ".$e->getMessage();
}

return $msg;
}

function DataBanco ($dataCon)
{
$dia = substr($dataCon,0,2);
$mes = substr($dataCon,3,2);
$ano = substr($dataCon,6);

$res = $mes."-".$dia."-".$ano;

return $res; 
}

function DataBanco2 ($dataCon)
{
$dia = substr($dataCon,0,2);
$mes = substr($dataCon,3,2);
$ano = substr($dataCon,6);

$res = $dia."-".$mes."-".$ano;

return $res; 
}

function DataBanco3 ($dataCon)
{
$dia = substr($dataCon,0,1);
$mes = substr($dataCon,2,2);
$ano = substr($dataCon,5);

$res = $mes."-".$dia."-".$ano;

return $res; 
}

function DataBanco4 ($dataCon)
{
$dia = substr($dataCon,0,2);
$mes = substr($dataCon,3,1);
$ano = substr($dataCon,5);

$res = $mes."-".$dia."-".$ano;

return $res; 
}

function RetornaDatAdm ($numemp, $numcad)
{
    
  $con = conectarComPdo();

try{   
$sql = $con -> prepare (" SELECT CONVERT(VARCHAR(10),R034FUN.DATADM,103) AS DATADM FROM R034FUN WHERE NUMCAD = :cad AND NUMEMP = :emp");
$sql ->bindValue(":cad", $numcad);
$sql ->bindValue(":emp", $numemp);
$sql ->execute();
      
    if($sql ->rowCount() !== 0)
    {      
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }
    
$con = null;    
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
}
}

function AjustaRG1 ($numcad,$numemp)
{
 
$con = conectarComPdo();

try{   
$sql = $con -> prepare ("SELECT NUMCID FROM R034CPL WHERE NUMCAD = :cad AND NUMEMP = :emp");
$sql ->bindValue(":cad", $numcad);
$sql ->bindValue(":emp", $numemp);
$sql ->execute();
  
    if($sql ->rowCount() !== 0)
    { 	
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }
    
$con = null;    
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
}
}

function CarregaCB($numemp, $numcad) 
{
    
$con = conectarComPdo();

try{   
$sql = $con -> prepare (" SELECT DISTINCT(R044CAL.CODCAL),TIPCAL,R044CAL.DATPAG AS ORDENAR, 
                          CONVERT(VARCHAR(10),R044CAL.DATPAG,103) AS DATPAG,
                          CONVERT(VARCHAR(10),R044CAL.INICMP,103) AS INICMP, 
						  CONVERT(VARCHAR(10),R044CAL.PERREF,103) AS PERREF FROM R044CAL,R046VER
                                                                           WHERE R044CAL.NUMEMP = R046VER.NUMEMP
                                                                             AND R044CAL.CODCAL = R046VER.CODCAL
                                                                             AND R044CAL.NUMEMP = :emp
                                                                             AND R046VER.NUMCAD = :cad
                                                                             AND R044CAL.DATPAG <= GETDATE() 
																			 AND R044CAL.SITCAL = 'T'
                                                                        ORDER BY ORDENAR DESC");
$sql ->bindValue(":cad", $numcad);
$sql ->bindValue(":emp", $numemp);
$sql ->execute();
      
    if($sql ->rowCount() !== 0)
    {      
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }
    
$con = null;    
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
}
}

function carregacb1html($emp,$cad,$tiphole) 
{ 
  $carregacb1 = CarregaCB($emp,$cad);
  $i = 0;
  $a = 0;
  
  $tt = databanco2($carregacb1[0]['PERREF']); 
  $tt = date('d/m/Y', strtotime($tt.'-6 months'));  
  
 while($a != 1)
 { 
    $id = $carregacb1[$i]['CODCAL'];
    $desc = $carregacb1[$i]['DATPAG'];
    $tip = $carregacb1[$i]['TIPCAL'];
    $comp1 = $carregacb1[$i]['PERREF'];
	
	$versix = databanco2($comp1);
	$versix = date('d/m/Y', strtotime($versix));  

    if ($tip == 11)
      $desccomp = "Mensal";
	if ($tip == 31)
	  $desccomp = "Adiantamento do 13º";
	if ($tip == 32)
	  $desccomp = "13º Integral";
	if ($tip == 91)
	  $desccomp = "Adiantamento Salarial";
	if ($tip == 0)
	  $desccomp = " - ";
	
    if($id != ''){
      echo "<tr class=\"odd gradeX\">";
      echo "<td>" . RetornaMesExt($comp1);
      ".</td>";
      echo "<td>$desc</td>";
      echo "<td>$desccomp</td>";
      if ($tiphole == 1)
        echo "<td align=\"center\"><a href=\"holeritevisu.php?codcal=".$id."\" class=\"btn btn-success btn_visu\"> Visualizar </a>";
      else
        echo "<td align=\"center\"><a href=\"holeritevisu2.php?codcal=".$id."\" class=\"btn btn-success btn_visu\"> Visualizar </a>";
      echo "</tr>";
	}
	
	$tip = 0;
	
	 if(($tt == $versix) || ($i == 16))
	  $a = 1;
	
	$i++;
	}  
}

function RetornaMesExt ($var){
  $res = substr($var, 3, 2);
  $mes = '';
 
  if($res == 01)
    $mes = 'Janeiro';
  if($res == 02)
    $mes = 'Fevereiro'; 
  if($res == 03)
    $mes = 'Março'; 
  if($res == 04)
    $mes = 'Abril'; 
  if($res == 05)
    $mes = 'Maio'; 
  if($res == 06)
    $mes = 'Junho'; 
  if($res == 07)
    $mes = 'Julho';	
  if($res == 8)
    $mes = 'Agosto'; 
  if($res == 9)
    $mes = 'Setembro';	
  if($res == 10)
    $mes = 'Outubro'; 
  if($res == 11)
    $mes = 'Novembro'; 
  if($res == 12)
    $mes = 'Dezembro';  
 
 return $mes;
}

function MostraEve ($codcal, $numemp, $numcad)
{
	
  $con = conectarComPdo();

try{
$sql = $con -> prepare ("SELECT R008EVC.DESEVE, R046VER.VALEVE, R046VER.CODEVE, R046VER.REFEVE, R008EVC.TIPEVE,
                                R008EVC.CRTEVE 
                           FROM R046VER, R008EVC
                          WHERE R046VER.TABEVE = R008EVC.CODTAB
                            AND R046VER.CODEVE = R008EVC.CODEVE
		            AND R046VER.CODCAL = :codcal 
			    AND R046VER.NUMEMP = :numemp 
			    AND R046VER.NUMCAD = :numcad                             
                          ORDER BY R008EVC.TIPEVE, R008EVC.CRTEVE, R046VER.CODEVE");
$sql ->bindValue(":codcal", $codcal);
$sql ->bindValue(":numemp", $numemp);
$sql ->bindValue(":numcad", $numcad);
$sql ->execute();

if($sql ->rowCount() !== 0)
    {      
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }
    
$con = null;													
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
}
}

function CarregaMesRef ($codcal, $numemp)
{ 
    
  $con = conectarComPdo();

try{
$sql = $con -> prepare (" SELECT CONVERT(VARCHAR(10),R044CAL.INICMP,103) AS INICMP, 
                                 CONVERT(VARCHAR(10),R044CAL.DATPAG,103) AS DATPAG,
                                 CONVERT(VARCHAR(10),R044CAL.PERREF,103) AS PERREF, TIPCAL                 
                                                                              FROM R044CAL
                                                                             WHERE R044CAL.CODCAL = :codcal                                                                            
																			   AND R044CAL.NUMEMP = :numemp ");
$sql ->bindValue(":codcal", $codcal);
$sql ->bindValue(":numemp", $numemp);

$sql ->execute();

if($sql ->rowCount() !== 0)
    {      
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }
    
$con = null;													
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
} 
}

function CarregaBanco ($codbanco)
{ 
  
  $con = conectarComPdo();

try{
$sql = $con -> prepare (" SELECT NOMBAN FROM R012BAN WHERE CODBAN = :codbanco");
$sql ->bindValue(":codbanco", $codbanco);

$sql ->execute();

if($sql ->rowCount() !== 0)
    {      
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }
    
$con = null;													
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
} 
}

function CarregaLocal ($numemp,$numcad,$datref)
{
	
  $con = conectarComPdo();

$datref = DataBanco($datref);
try{
$sql = $con -> prepare ("SELECT NOMLOC, CODLOC 
                           FROM R038HLO, R016HIE, R016ORN 
                          WHERE R038HLO.NUMEMP = :numemp
                            AND R038HLO.NUMCAD = :numcad  
                            AND R038HLO.TABORG = R016HIE.TABORG  
                            AND R038HLO.NUMLOC = R016HIE.NUMLOC  
                            AND R038HLO.TABORG = R016ORN.TABORG  
                            AND R038HLO.NUMLOC = R016ORN.NUMLOC   
                            AND R016HIE.DATINI <= :datref 
                            AND R016HIE.DATFIM >= :datref1  
                            AND R038HLO.DATALT = (SELECT MAX(HLO.DATALT)  
                                                    FROM R038HLO HLO 
                                                   WHERE HLO.NUMEMP = :numemp1  
                                                     AND HLO.NUMCAD = :numcad1
                                                     AND HLO.DATALT <= :datref2)");
$sql -> bindValue(":numemp", $numemp);
$sql -> bindValue(":numcad", $numcad);
$sql -> bindValue(":datref", $datref);
$sql -> bindValue(":datref1", $datref);
$sql -> bindValue(":numemp1", $numemp);
$sql -> bindValue(":numcad1", $numcad);
$sql -> bindValue(":datref2", $datref);
$sql -> execute();

if($sql ->rowCount() !== 0)
    {
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }

$con = null;													
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
} 
}

function EstCargo ($emp,$dat)
{
	
$con = conectarComPdo();

$dat = DataBanco($dat);
try{
$sql = $con -> prepare (" SELECT ESTCAR FROM R030CAR 
                           WHERE NumEmp = :emp1
                             AND DatAlt <= :dat1 
                             AND DatAlt = (SELECT MAX(DatAlt) 
                                             FROM R030CAR 
                                            WHERE NumEmp = :emp2 
                                              AND DatAlt <= :dat2)");
$sql ->bindValue(":emp1", $emp);
$sql ->bindValue(":dat1", $dat);
$sql ->bindValue(":emp2", $emp);
$sql ->bindValue(":dat2", $dat);

$sql ->execute();

if($sql ->rowCount() !== 0)
    {      
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }
    
$con = null;													
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
} 
}

function HistCargo ($emp,$cad,$dat)
{
	
  $con = conectarComPdo();

$dat = DataBanco($dat);
try{
$sql = $con -> prepare (" SELECT CODCAR FROM R038HCA 
                                       WHERE NumEmp = :emp1 
                                         AND NumCad = :cad1
                                         AND DatAlt <= :dat1 
                                         AND DatAlt = (SELECT MAX(DatAlt)  
                                                         FROM R038HCA 
                                                        WHERE NumEmp = :emp2 
                                                          AND NumCad = :cad2 
                                                          AND DatAlt <= :dat2)");
								
$sql ->bindValue(":emp1", $emp);
$sql ->bindValue(":cad1", $cad);
$sql ->bindValue(":dat1", $dat);
$sql ->bindValue(":emp2", $emp);
$sql ->bindValue(":cad2", $cad);
$sql ->bindValue(":dat2", $dat);

$sql ->execute();

if($sql ->rowCount() !== 0)
    {      
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }
    
$con = null;													
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
} 
}

function CarregaCargo ($cad,$emp,$dat)
{
	
  $con = conectarComPdo();

$estcar = EstCargo($emp,$dat);
$codcar = HistCargo($emp,$cad,$dat);
try{
$sql = $con -> prepare (" SELECT TITRED 
                            FROM R024CAR 
                           WHERE EstCar = :estcar 
			     AND CodCar = :codcar");
$sql ->bindValue(":estcar", $estcar[0]['ESTCAR']);
$sql ->bindValue(":codcar", $codcar[0]['CODCAR']);
$sql ->execute();

if($sql ->rowCount() !== 0)
    {      
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }
    
$con = null;													
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
} 
}

function CarregaBaseSal ($codcal, $numemp, $numcad)
{
	
  $con = conectarComPdo();

try{
$sql = $con -> prepare (" SELECT SALEMP, BASINS 
                            FROM R046INF
                           WHERE CODCAL = :codcal 
			     AND NUMEMP = :numemp 
			     AND NUMCAD = :numcad ");
$sql ->bindValue(":codcal", $codcal);
$sql ->bindValue(":numemp", $numemp);
$sql ->bindValue(":numcad", $numcad);
$sql ->execute();

if($sql ->rowCount() !== 0)
    {      
      return $sql -> fetchAll(PDO::FETCH_ASSOC);  
    }
    
$con = null;													
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
}
}

function AjustaZerado ($valor)
{
  if ($valor == ".00")
    $re = " ";			   
  elseif ($valor < 1) 
    $re = "0".$valor;
  else 
    $re = ValorDecimal($valor);
	
  return $re;
}

function AjustaCPF ($numcpf)
{
  $numcpf = str_replace("." , "" , $numcpf );
  $numcpf = str_replace("-" , "" , $numcpf );
  $passou = 0;
  $ver = substr($numcpf,0,1);
  $res = $numcpf;
  
  if($ver == 0){
    $res = substr($numcpf,1);
	$passou = 1;
	}
	
  $ver = substr($numcpf,1,1);
  
  if($ver == 0 && $passou == 1)
    $res = substr($numcpf,2);	

return $res;
}

function VerificaDemitido($numcad,$numemp)
{
	
  $con = conectarComPdo();

try{   
$sql = $con -> prepare ("SELECT NUMCAD FROM R034FUN 
                                      WHERE NUMCAD = :cad 
				        AND NUMEMP = :emp
				        AND SITAFA = 7");
$sql ->bindValue(":cad", $numcad);
$sql ->bindValue(":emp", $numemp);
$sql ->execute();

if($sql ->rowCount() !== 0)
    {   	
      return 'Usuário inválido ou Senha incorreta;';  
    }
	
$con = null;    
}catch (PDOException $e) {
  echo "Erro: ".$e->getMessage();   
}
}

function ajustehora($min){ 

    $min += 180;
    return date("H:i", ($min * 60));

}

function mask($val, $mask) {
  
  $maskared = '';
  $k = 0;

  for($i = 0; $i<=strlen($mask)-1; $i++) {
    if($mask[$i] == '#') {      
      if(isset($val[$k]))    
          $maskared .= $val[$k++];
        }else{
          if(isset($mask[$i]))
            $maskared .= $mask[$i];
          }
  }
return $maskared;
}

function gambmonstra($databugada, $tip){   

$mes = substr($databugada,0,3);

  if($mes == 'Jan')
    $mesn = '01';  
  if($mes == 'Feb')
    $mesn = '02';  
  if($mes == 'Mar')
    $mesn = '03';
  if($mes == 'Apr')
    $mesn = '04';
  if($mes == 'May')
    $mesn = '05';
  if($mes == 'Jun')
    $mesn = '06';
  if($mes == 'Jul')
    $mesn = '07';
  if($mes == 'Aug')
    $mesn = '08';
  if($mes == 'Sep')
    $mesn = '09';
  if($mes == 'Oct')
    $mesn = '10';
  if($mes == 'Nov')
    $mesn = '11';
  if($mes == 'Dec')
    $mesn = '12'; 
  
$dia = substr($databugada,4,2);
$ano = substr($databugada,7,4);

if ($tip == 1) 
  $res = trim($mesn)."/".trim($dia)."/".trim($ano);
if ($tip == 2)
  $res = trim($dia)."/".trim($mesn)."/".trim($ano);

return $res;    
}

function diasemana($datac){  
  $diasemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'); 
  $diasemana_numero = date('w', strtotime(gambmonstra($datac,1)));

  return $diasemana[$diasemana_numero];  
}

function retornaapu($numcad, $numemp, $tipcol, $dapuini, $dapufim){
    
   $con = conectarComPdo();
   
try {
  $comando = "SELECT HORDAT, CODESC, DATAPU
                FROM R066APU
               WHERE NUMCAD = ?
                 AND NUMEMP = ?
                 AND TIPCOL = ?
                 AND DATAPU BETWEEN ? AND ?
            ORDER BY DATAPU";
  $sql = $con->prepare($comando);
  $sql->bindValue(1, $numcad);
  $sql->bindValue(2, $numemp);
  $sql->bindValue(3, $tipcol);
  $sql->bindValue(4, $dapuini);
  $sql->bindValue(5, $dapufim);
  $sql->setFetchMode(PDO::FETCH_ASSOC);
  
  $sql->execute();
  
  return $sql->fetchAll();
        
} catch (PDOException $ex) {
  echo "Erro: ".$ex->getMessage();
}
    
}

function retcodhordia($numcad, $numemp, $tipcol, $diahor){
    
   $con = conectarComPdo();
   
try {
  $comando = "SELECT HORDAT, CODESC, DATAPU
                FROM R066APU
               WHERE NUMCAD = ?
                 AND NUMEMP = ?
                 AND TIPCOL = ?
                 AND DATAPU = ?";
  $sql = $con->prepare($comando);
  $sql->bindValue(1, $numcad);
  $sql->bindValue(2, $numemp);
  $sql->bindValue(3, $tipcol);
  $sql->bindValue(4, $diahor);
  $sql->setFetchMode(PDO::FETCH_ASSOC);
  
  $sql->execute();
  
  return $sql->fetchAll();
        
} catch (PDOException $ex) {
  echo "Erro: ".$ex->getMessage();
}
    
}

function retornamarc($numcad,$numemp,$tipcol,$dmarc){
 
  $con = conectarComPdo();

try {    
  $comando = "SELECT DATACC, HORACC, DATAPU 
                FROM R070ACC 
               WHERE NUMCAD = ?
                 AND NUMEMP = ?
                 AND TIPCOL = ?
                 AND DATACC = ?
               ORDER BY HORACC";
  
  $sql = $con->prepare($comando);
  $sql->bindValue(1, $numcad);
  $sql->bindValue(2, $numemp);
  $sql->bindValue(3, $tipcol);
  $sql->bindValue(4, $dmarc);
  
  $sql->setFetchMode(PDO::FETCH_ASSOC);
  
  $sql->execute();
  
  return $sql->fetchAll(); 
    
} catch (PDOException $ex) {
  echo "Erro: ".$ex->getMessage();
}    
}

function montamarc($numcad, $numemp, $tipcol, $codhor, $dat){
 
  $lista_m = retornamarc($numcad, $numemp, $tipcol, $dat);
   
  for($j=0; $j < count($lista_m); $j++){
    $x1 .= ajustehora($lista_m[$j]['HORACC'])."  ";      
  }
  
  if ($x1 == ''){      
    if($codhor == 9996)
      $x1 = 'Folga';
    if($codhor == 9997)
      $x1 = 'Feriado';
    if($codhor == 9998)
      $x1 = 'Compensado';
    if($codhor == 9999)
      $x1 = 'DSR';   
  }
  
  if ($j % 2 != 0)
    $x1 .= " ***";  
            
   return $x1;
}

function carregaep($numemp){

  $con = conectarComPdo();    
    
  try {    
    $comando = "SELECT INIAPU, FIMAPU, CODCAL FROM R044CAL
                 WHERE NUMEMP = ?
                   AND TIPCAL = 11
                   AND ? >= INIAPU
                   AND ? <= FIMAPU";
  
    $sql = $con->prepare($comando);
    $sql->bindValue(1, $numemp);
    $sql->bindValue(2, date('m/d/y'));
    $sql->bindValue(3, date('m/d/y'));
  
    $sql->setFetchMode(PDO::FETCH_ASSOC);
  
    $sql->execute();
  
    return $sql->fetchAll(); 
    
  } catch (PDOException $ex) {
    echo "Erro: ".$ex->getMessage();
  }        
}

function carregaepant($numemp, $codcal){

  $con = conectarComPdo();    
    
  try {    
    $comando = "SELECT INIAPU, FIMAPU FROM R044CAL 
                 WHERE NUMEMP = ?
                   AND TIPCAL = 11
                   AND INIAPU < ?
                   AND CODCAL = (SELECT MAX(CODCAL) 
                                   FROM R044CAL 
                                  WHERE NUMEMP = ?
                                    AND TIPCAL = 11
                                    AND INIAPU < ?
                                    AND CODCAL <> ?)";  
    $sql = $con->prepare($comando);
    $sql->bindValue(1, $numemp);
    $sql->bindValue(2, date('m/d/y'));
    $sql->bindValue(3, $numemp);    
    $sql->bindValue(4, date('m/d/y'));
    $sql->bindValue(5, $codcal);
  
    $sql->setFetchMode(PDO::FETCH_ASSOC);
  
    $sql->execute();
  
    return $sql->fetchAll(); 
    
  } catch (PDOException $ex) {
    echo "Erro: ".$ex->getMessage();
  }        
}

function acentuacaook ($string) {
  return htmlentities($string, ENT_QUOTES, 'ISO-8859-1', true);
}

function ValorDecimal($valor) {
  return number_format($valor, 2, ',', '.');
}

function MostrarCpf ($cpf, $opmask){
  if (strlen($cpf) < 11){
    $tam = strlen($cpf);
    $qtdzero = 11 - $tam;
    
    for ($i = 0; $i < $qtdzero; $i++){
      $cpf = "0".$cpf;  
    }    
  }
 
  if ($opmask == 1){
  $cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . 
                '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
  }  
    
  return $cpf; 
}

function TratarString($str) {
  # Remove palavras suspeitas de injection.
  $str = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i", "", $str);
  // $str = trim($str);        # Remove espaços vazios.
  $str = htmlspecialchars($str);
  $str = strip_tags($str);  # Remove tags HTML e PHP.
  //$str = addslashes($str);  # Adiciona barras invertidas à uma string.
 
  return $str;
}

function BuscaBaseEv ($numemp, $numcad, $codcal, $campo) {
    
  if ($campo == "INCIRM")
    $exc = "AND FF.CODEVE NOT IN (302)";     
    
  $con = conectarComPdo();
  try {
    $select = "SELECT SUM(FF.VALEVE) SOMA, (SELECT SUM(FF.VALEVE)
                                              FROM R046VER FF, R008INC IC
                                             WHERE FF.TABEVE = IC.CODTAB
                                               AND FF.CODEVE = IC.CODEVE
                                               AND IC.CMPINC = (SELECT MAX(CMPINC) 
                                                                  FROM R008INC IC1 
                                                                 WHERE IC1.CODTAB = IC.CODTAB
                                                                   AND IC1.CODEVE = IC.CODEVE
                                                                   AND IC1.SEQINC = (SELECT MAX(SEQINC)
                                                                                       FROM R008INC IC2
                                                                                      WHERE IC2.CODTAB = IC1.CODTAB
                                                                                        AND IC2.CODEVE = IC1.CODEVE))
                                                                   AND IC.SEQINC = (SELECT MAX(SEQINC)
                                                                                      FROM R008INC IC3
                                                                                     WHERE IC3.CODTAB = IC.CODTAB
                                                                                       AND IC3.CODEVE = IC.CODEVE) 
                                                                   AND IC.".$campo." = '-'
                                                                   ".$exc."
                                                                   AND FF.NUMEMP = ?
                                                                   AND FF.NUMCAD = ?
                                                                   AND FF.TIPCOL = 1
                                                                   AND FF.CODCAL = ?) DIMINUI
                 FROM R046VER FF, R008INC IC
                WHERE FF.TABEVE = IC.CODTAB
                  AND FF.CODEVE = IC.CODEVE
                  AND IC.CMPINC = (SELECT MAX(CMPINC) 
                                     FROM R008INC IC1 
                                    WHERE IC1.CODTAB = IC.CODTAB
                                      AND IC1.CODEVE = IC.CODEVE
                                      AND IC1.SEQINC = (SELECT MAX(SEQINC)
                                                          FROM R008INC IC2
                                                         WHERE IC2.CODTAB = IC1.CODTAB
                                                           AND IC2.CODEVE = IC1.CODEVE))
                  AND IC.SEQINC = (SELECT MAX(SEQINC)
                                     FROM R008INC IC3
                                    WHERE IC3.CODTAB = IC.CODTAB
                                      AND IC3.CODEVE = IC.CODEVE) 
                  AND IC.".$campo." = '+'
                  AND FF.NUMEMP = ?
                  AND FF.NUMCAD = ?
                  AND FF.TIPCOL = 1
                  AND FF.CODCAL = ?";
    
    $sql = $con->prepare($select);
    
    $sql->bindValue(1, $numemp);
    $sql->bindValue(2, $numcad);
    $sql->bindValue(3, $codcal);
    $sql->bindValue(4, $numemp);
    $sql->bindValue(5, $numcad);
    $sql->bindValue(6, $codcal);
         
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $sql->execute();
                    
    return $sql->fetchAll();                
          
    } catch (Exception $ex) {
      echo "Erro: " . $ex->getMessage();   
    }        
}

function buscaTetoInss ($perref) {
    
  $con = conectarComPdo();
  try { 
    $sql = $con->prepare("SELECT TETFAI
                            FROM R026INF
                           WHERE CODFAI = 3
                             AND PERREF = (SELECT MAX(PERREF) 
                                             FROM R026INF
                                            WHERE PERREF <= ?)");  
    $sql->bindValue(1, $perref);
         
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $sql->execute();
                    
    return $sql->fetchAll();                
          
    } catch (Exception $ex) {
      echo "Erro: " . $ex->getMessage();   
    }        
}

function AddTentBloq($numcad, $numemp, $tipcol){
  $con = conectarComPdo();
try {    
  $sql = $con -> prepare("UPDATE ACESSOSITE 
                             SET QTDTET = QTDTET +1,
                                 HORULT = GETDATE()
						 WHERE NUMCAD = :numcad
						   AND NUMEMP = :numemp
						   AND TIPCOL = :tipcol");
$sql -> bindValue(':numcad',$numcad);
$sql -> bindValue(':numemp',$numemp);
$sql -> bindValue(':tipcol',$tipcol);
$sql -> execute();
    
} catch (PDOException $ex) {
  echo "Erro: ".$ex->getMessage();
}      
    
}

function ZeraTentativas ($numcad, $numemp, $tipcol){
  $con = conectarComPdo();
try {    
  $sql = $con -> prepare("UPDATE ACESSOSITE 
                             SET QTDTET = 0,
                                 HORULT = GETDATE()
						 WHERE NUMCAD = :numcad
						   AND NUMEMP = :numemp
						   AND TIPCOL = :tipcol");
$sql -> bindValue(':numcad',$numcad);
$sql -> bindValue(':numemp',$numemp);
$sql -> bindValue(':tipcol',$tipcol);
$sql -> execute();
    
} catch (PDOException $ex) {
  echo "Erro: ".$ex->getMessage();
}      
    
}

function tempobloqueio($numcad,$numemp,$tipcol){
  $con = conectarComPdo();
try {    
  $comando = "SELECT NUMCAD, DATEDIFF(SECOND, HORULT, GETDATE()) AS TEMPBLOQ, QTDTET
                FROM ACESSOSITE 
               WHERE NUMCAD = ?
                 AND NUMEMP = ?
                 AND TIPCOL = ?";
  
  $sql = $con->prepare($comando);
  $sql->bindValue(1, $numcad);
  $sql->bindValue(2, $numemp);
  $sql->bindValue(3, $tipcol);
  
  $sql->setFetchMode(PDO::FETCH_ASSOC);
  
  $sql->execute();
  
  return $sql->fetchAll(); 
    
} catch (PDOException $ex) {
  echo "Erro: ".$ex->getMessage();
}    
}

function retornaPerFerias($numemp,$tipcol,$numcad){
 
  $con = conectarComPdo();

try {    
  $comando = "SELECT CONVERT(VARCHAR(10),INIPER,103) INIPER, CONVERT(VARCHAR(10),FIMPER,103) FIMPER, QTDDIR, QTDDEB, QTDSLD, 
                     CONVERT(VARCHAR(10), DATEADD (YEAR, 1,(FIMPER - 30)),103) AS DATLIM
                FROM R040PER
               WHERE R040PER.NUMEMP = ?
                 AND R040PER.TIPCOL = ?
                 AND R040PER.NUMCAD = ?
                 AND R040PER.QTDSLD > 0
               ORDER BY INIPER";
  
  $sql = $con->prepare($comando);
  $sql->bindValue(1, $numemp);
  $sql->bindValue(2, $tipcol);
  $sql->bindValue(3, $numcad);
  
  $sql->setFetchMode(PDO::FETCH_ASSOC);
  
  $sql->execute();
  
  return $sql->fetchAll(); 
    
} catch (PDOException $ex) {
  echo "Erro: ".$ex->getMessage();
}    
}

function enviaremail($dest,$datasug,$cc,$nomcol,$col1,$col2,$col3,$col4,$col5,$col6){    
    
  $mail = new PHPMailer(true);
  try{
    $mail->isSMTP();
    $mail->isHTML();
    $mail->Host = 'smtp.capitalhumano.com.br';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'gestaodepessoas@capitalhumano.com.br';
    $mail->Password = 'pimentel@2018';
    $mail->Port = 587;
  
    $mail->From = 'gestaodepessoas@capitalhumano.com.br';
    $mail->FromName = 'Portal Capital Humano';
    
    $mail->AddAddress($dest);
    
    if($cc !== '')
      $mail->addCC($cc);
    
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Solicitação de Férias de Colaborador';
    $mail->Body = '<head>
                     <style> 
                       body {
                             font-family: Arial;  
                            }              
                       p {
                           text-indent: 50px;
                           margin: 6px;
                         }
                     </style>
                   </head>
                   <body> 
                     <b>Prezado Gestor,</b> <br>
                     <p>Para garantir o cumprimento dos prazos legais de gozo de férias, favor 
                        analisar a solicitação de programação de férias do colaborador.</p><br> 

                     <p style="margin: 10px;"><b>Data de Início Solicitada:</b> '.$datasug.'</p>
                     <p><b>Início Período Aquisitivo:</b> '.$col1.'</p>
                     <p><b>Fim Período Aquisitivo:</b> '.$col2.'</p>
                     <p><b>Dias Direito:</b> '.$col3.'</p>
                     <p><b>Dias Débito:</b> '.$col4.'</p>
                     <p><b>Dias Saldo:</b> '.$col5.'</p>
                     <p><b>Data Limite:</b> '.$col6.'</p>

                     <br> Colaborador Solicitante: '.$nomcol.'

                    </body>';
    if($mail->Send()){
      return 1;
    }   
    
  } catch (Exception $ex) {
    return 'Erro: '.$mail->ErrorInfo;
    
  }         
}