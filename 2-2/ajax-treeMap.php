<?php

require_once("TreeMap.php");

session_start();


if(!isset($_SESSION["treeMap"])){
    $_SESSION["treeMap"] = serialize(new TreeMap);
}

$treeMap = unserialize($_SESSION["treeMap"]);



$acao = $_POST["acao"];
$chave = $_POST["chave"];
$valor = $_POST["valor"];

switch ($acao) {
    case "inserir":

        if ($chave && $valor) {
            $treeMap->inserir($chave, $valor);
        }
        break;

    case "obter":
        if($chave){
            $resultado = $treeMap->obter($chave);

            if($resultado){

            }
        }
    
        break;
    case "remover":
        if($chave){
            
            if($treeMap->contemChave($chave)){
                $treeMap->remover($chave);
            }
        }
        break;
}
$_SESSION['treeMap'] = serialize($treeMap);

echo $treeMap->converteParaJSON();
