<?php

function conectarComPdo () {
   try{
    $conectar = new PDO("sqlsrv:Server=172.16.0.5;Database=Capital;ConnectionPooling=0", "senior_capital", "Ch#Ql1k%S3n");
    $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conectar;
 }catch(PDOException $e){
    echo "Erro ao conectar ao banco  ".BD."  ".$e->getMessage();
 }           
                           }                       
?>