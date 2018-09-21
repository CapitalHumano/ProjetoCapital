<?php
include_once "conectar.php";

function DadosColaborador($numemp, $numcad) {

    $con = conectarComPdo();
    try {
        $sql = $con->prepare("SELECT BASI.NUMCAD, BASI.NOMFUN, CONVERT(VARCHAR(10),BASI.DATNAS,103) DATNAS, COMP.ENDRUA, COMP.ENDNUM, 
                                     COMP.ENDCPL, COMP.ENDCEP, BAIR.NOMBAI, CIDA.NOMCID, CIDA.ESTCID, 
                                     COMP.DDDTEL, COMP.NUMTEL, COMP.NMDDD2, COMP.NMTEL2, COMP.EMAPAR, 
                                     BASI.NUMCPF, COMP.NUMCID, COMP.EMICID, COMP.ESTCID ESTCRG, CONVERT(VARCHAR(10),COMP.DEXCID,103) DEXCID, 
                                     BASI.NUMPIS, COMP.NUMELE, COMP.ZONELE, COMP.SECELE, COMP.NUMRES, 
                                     BASI.NUMCTP, BASI.SERCTP, COMP.NUMCNH, CONVERT(VARCHAR(10),COMP.DATCNH,103) DATCNH, 
                                     CONVERT(VARCHAR(10),COMP.VENCNH,103) VENCNH, CONVERT(VARCHAR(10),COMP.PRICNH,103) PRICNH, 
                                     COMP.CATCNH, BASI.GRAINS, BASI.ESTCIV, BASI.CODNAC, NACI.DESNAC, 
	                             (SELECT R074CID.NOMCID FROM R074CID WHERE R074CID.CODCID = COMP.CCINAS) CIDNAT,
                                     (SELECT R074CID.ESTCID FROM R074CID WHERE R074CID.CODCID = COMP.CCINAS) ESTNAT   
                                FROM R034FUN BASI, R034CPL COMP, R074BAI BAIR, R074CID CIDA, R023NAC NACI
                               WHERE BASI.NUMEMP = COMP.NUMEMP
                                 AND BASI.NUMCAD = COMP.NUMCAD 
                                 AND BASI.TIPCOL = COMP.TIPCOL   
                                 AND COMP.CODBAI = BAIR.CODBAI
                                 AND COMP.CODCID = BAIR.CODCID
                                 AND COMP.CODCID = CIDA.CODCID
                                 AND BASI.CODNAC = NACI.CODNAC
                                 AND BASI.NUMEMP = ?
                                 AND BASI.NUMCAD = ?
                                 AND BASI.TIPCOL = 1");
        $sql->bindValue(1, $numemp);
        $sql->bindValue(2, $numcad);

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $sql->execute();

        return $sql->fetchAll();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function DadosDependente($numemp, $numcad) {

    $con = conectarComPdo();
    try {
        $sql = $con->prepare("SELECT DEP.CODDEP, DEP.NOMDEP, DEP.GRAPAR, CONVERT(VARCHAR(10),DEP.DATNAS,103) DATNAS, DEP.NUMCPF, DEP.LIMIRF 
                                FROM R036DEP DEP
                               WHERE DEP.NUMEMP = ?
                                 AND DEP.NUMCAD = ?
                                 AND DEP.TIPCOL = 1");
        $sql->bindValue(1, $numemp);
        $sql->bindValue(2, $numcad);

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $sql->execute();

        return $sql->fetchAll();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function DadosEstrangeiro($numemp, $numcad) {

    $con = conectarComPdo();
    try {
        $sql = $con->prepare("SELECT EST.REGEST, EST.EMIEST, CONVERT(VARCHAR(10),EST.DATEST,103) DATEST, CONVERT(VARCHAR(10),EST.DATCHE,103) DATCHE
                               FROM R034EST EST
                              WHERE EST.NUMEMP = ?
                                AND EST.NUMCAD = ?
                                AND EST.TIPCOL = 1");
        $sql->bindValue(1, $numemp);
        $sql->bindValue(2, $numcad);

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $sql->execute();

        return $sql->fetchAll();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function TabelaGraIns() {

    $con = conectarComPdo();
    try {
        $sql = $con->prepare("SELECT GRAINS, DESGRA FROM R022GRA");

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $sql->execute();

        return $sql->fetchAll();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function retDesGraIns($grains) {

    $con = conectarComPdo();
    try {
        $sql = $con->prepare("SELECT GRAINS, DESGRA FROM R022GRA WHERE GRAINS = ?");
        $sql->bindValue(1, $grains);

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $sql->execute();

        return $sql->fetchAll();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function retDescGP($grapar){
if ($grapar == 1)
  return "Filho(a)";
if ($grapar == 2)
  return "Cônjuge";
if ($grapar == 3)
  return "Pai/Mãe";
if ($grapar == 4)
  return "Avô/Avó";
if ($grapar == 5)
  return "Bisavô(ó)";
if ($grapar == 6)
  return "Sobrinho(a)";
if ($grapar == 7)
  return "Tio(a)";
if ($grapar == 8)
  return "Neto(a)";
if ($grapar == 9)
  return "Sogro(a)";
if ($grapar == 10)
  return "Genro/Nora";
if ($grapar == 11)
  return "Enteado(a)";
if ($grapar == 12)
  return "Irmão(a)";
if ($grapar == 14)
  return "Filho(a) Adotivo(a)";
if ($grapar == 15)
  return "Pensionistas";
if ($grapar == 16)
  return "Companheiro(a)";
if ($grapar == 17)
  return "Tutelado";
if ($grapar == 18)
  return "Menor sob Guarda";
if ($grapar == 19)
  return "Madastra";
if ($grapar == 20)
  return "Padastro";
if ($grapar == 21)
  return "Tutor"; 
if ($grapar == 22)
  return "Ex-Esposo(a)"; 
if ($grapar == 23)
  return "Bisneto(a)"; 
if ($grapar == 24)
  return "Ex-Companheiro(a)"; 
if ($grapar == 25)
  return "Concubino(a)"; 
if ($grapar == 26)
  return "Curatelado";
if ($grapar == 99)
  return "Outros";
}

function retDesEstCiv($estciv) {

if ($estciv == 1) { return "Solteiro"; }
if ($estciv == 2) { return "Casado"; }
if ($estciv == 3) { return "Divorciado"; }
if ($estciv == 4) { return "Viúvo"; }
if ($estciv == 5) { return "Concubinato"; }
if ($estciv == 6) { return "Separado"; }
if ($estciv == 7) { return "União Estável"; }
if ($estciv == 9) { return "Outros"; }     
}

function vrfCampob ($campo){
  $ehbranco = 0;
    
  if($campo == 0){
    $ehbranco = 1;
  }   
  if($campo == ""){
    $ehbranco = 1;
  }
  if($campo == " "){
    $ehbranco = 1;    
  }
  if($campo == "31/12/1900"){
    $ehbranco = 1;
  }
  if(empty($campo)){
    $ehbranco = 1;    
  }
  
  return $ehbranco;
}