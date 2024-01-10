<?php
    class Fruta{
        private $color, $tamanio;

        public function __construct($colorNuevo, $tamanioNuevo){
            $this ->color = $colorNuevo;
            $this -> tamanio =$tamanioNuevo;
            $this->imprimir();
        }


        public function setColor($colorNuevo){
            $this -> color = $colorNuevo;
        }

        public function setTamanio($tamanioNuevo){
            $this -> tamanio = $tamanioNuevo;
        }

        public function getColor(){
            return $this -> color;
        }
        public function getTamanio(){
            return $this -> tamanio;
        }

        public function imprimir(){
            echo "<p><strong>Color: </strong>" . $this -> getColor(). "<br><strong>Tamaño: </strong>" . $this->getTamanio() . "</p>";
        }
    }



?>






































