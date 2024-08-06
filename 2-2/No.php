<?php
    class No{
        public $chave;
        public $valor;
        public $noEsquerda;
        public $noDireita;

        public function __construct($chave, $valor)
        {
            $this->chave = $chave;
            $this->valor = $valor;
            $this->noEsquerda = null;
            $this->noDireita = null;
        }
    }
?>