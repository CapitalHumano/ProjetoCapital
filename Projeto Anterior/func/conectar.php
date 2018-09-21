<?php

function conectarComPdo () {
   try{
    $conectar = new PDO("dblib:host=172.16.0.5;dbname=Capital", "senior_capital", "Ch#Ql1k%S3n");
    $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conectar;
 }catch(PDOException $e){
    echo "Erro ao conectar ao banco  ".BD."  ".$e->getMessage();
 }           
                           }                        
?>
