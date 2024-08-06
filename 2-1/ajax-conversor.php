<?php

use numeroIndoArabico\NumeroRomano;
use numeroRomano\NumeroIndoArabico;

require_once("NumeroRomano.php");
require_once("NumeroIndoArabico.php");

$numeroRomano = new NumeroRomano;
$numeroIndoArabico = new NumeroIndoArabico;

$tipo = $_POST["tipo"];
$numero = $_POST["numero"];

$numeroConvertido = "";

switch ($tipo) {
    case '1':
        $numeroRomano->setNumero($numero);
        $numeroConvertido = $numeroRomano->converterNumero();
        break;

    case '2':
        $numeroIndoArabico->setNumero($numero);
        $numeroConvertido = $numeroIndoArabico->converterNumero();
        break;
}

echo json_encode($numeroConvertido);
