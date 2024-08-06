<?php

namespace numeroIndoArabico;

class NumeroRomano
{
    private $numero;

    public function getNumero()
    {
        return $this->numero;
    }
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function converterNumero()
    {

        $simbolos = [
            1000 => 'M', 900 => 'CM', 500 => 'D', 400 => 'CD', 100 => 'C', 90 => 'XC', 50 => 'L', 40 => 'XL', 10 => 'X', 9 => 'IX', 5 => 'V', 4 => 'IV', 1 => 'I'
        ];

        $numero = $this->getNumero();

        $numeroConvertido = "";

        foreach ($simbolos as $valor => $letra) {
            while ($numero >= $valor) {
                $numeroConvertido .= $letra;
                $numero -= $valor;
            }
        }

        return $numeroConvertido;
    }
}
