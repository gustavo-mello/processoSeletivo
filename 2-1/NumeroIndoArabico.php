<?php

namespace numeroRomano;

class NumeroIndoArabico
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
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ];

        $i = 0;
        $numero = 0;
        $numeroRomano = $this->getNumero();
        $tamanho = strlen($numeroRomano);

        while ($i < $tamanho) {
            if ($i + 1 < $tamanho && isset($simbolos[$numeroRomano[$i] . $numeroRomano[$i + 1]])) {
                $numero += $simbolos[$numeroRomano[$i] . $numeroRomano[$i + 1]];
                $i += 2;
            } else {
                $numero += $simbolos[$numeroRomano[$i]];
                $i++;
            }
        }

        return $numero;
    }
}
