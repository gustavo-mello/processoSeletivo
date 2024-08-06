<?php
require_once("No.php");
class TreeMap
{
    private $raiz;


    public function __construct()
    {
        $this->raiz = null;
    }

    public function inserir($chave, $valor)
    {
        $this->raiz = $this->inserirRecursivo($this->raiz, $chave, $valor);
    }

    private function inserirRecursivo($no, $chave, $valor)
    {
        if ($no == null) {
            return new No($chave, $valor);
        }

        if ($valor < $no->valor) {
            $no->noEsquerda = $this->inserirRecursivo($no->noEsquerda, $chave, $valor);
        } else if ($valor > $no->valor) {
            $no->noDireita = $this->inserirRecursivo($no->noDireita, $chave, $valor);
        } else {
            $no->chave = $chave;
        }

        return $no;
    }

    public function obter($chave)
    {
        $no = $this->obterRecursivo($this->raiz, $chave);

        return $no ? $no->valor : null;
    }

    private function obterRecursivo($no, $chave)
    {
        if ($no == null) {
            return null;
        }

        if ($chave < $no->chave) {
            return $this->obterRecursivo($no->noEsquerda, $chave);
        } else if ($chave > $no->chave) {
            return $this->obterRecursivo($no->noDireita, $chave);
        } else {
            return $no;
        }
    }

    public function remover($chave)
    {
        $this->raiz = $this->removerRecursivo($this->raiz, $chave);
    }

    private function removerRecursivo($no, $chave)
    {
        if ($chave < $no->chave) {
            $no->noEsquerda = $this->removerRecursivo($no->noEsquerda, $chave);
        } else if ($chave > $no->chave) {
            $no->noDireita = $this->removerRecursivo($no->noDireita, $chave);
        } else {
            if ($no->noEsquerda == null) {
                return $no->noDireita;
            } else if ($no->noDireita == null) {
                return $no->noEsquerda;
            }

            $menorNoMaior = $this->obterMenor($no->noDireita);
            $no->chave = $menorNoMaior->chave;
            $no->valor = $menorNoMaior->valor;

            $no->noDireita = $this->removerRecursivo($no->noDireita, $menorNoMaior->chave);
        }

        return $no;
    }

    private function obterMenor($no)
    {
        while ($no->noEsquerda != null) {
            $no = $no->noEsquerda;
        }

        return $no;
    }


    public function contemChave($chave)
    {
        return $this->obterRecursivo($this->raiz, $chave) != null;
    }

    private function converteParaArray($no){
        if($no == null){
            return null;
        }

        $array = [
            "chave" => $no->chave,
            "valor" => $no->valor,
            "noEsquerda" => $this->converteParaArray($no->noEsquerda),
            "noDireita" => $this->converteParaArray($no->noDireita)
        ];

        return $array;
    }

    public function converteParaJSON(){
        $array = $this->converteParaArray($this->raiz);

        return json_encode($array);
    }
}
