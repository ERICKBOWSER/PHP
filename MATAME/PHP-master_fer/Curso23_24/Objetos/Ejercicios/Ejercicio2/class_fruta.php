<?php


class Fruta{

    private $color;
    private $tamanyo;

    public function __construct($color_nuevo,$tamanyo_nuevo){
        $this->color=$color_nuevo;
        $this->tamanyo=$tamanyo_nuevo;
        $this->imprimir();
    }

    public function set_color($color_nuevo){
        $this->color=$color_nuevo;
    }

    public function set_tamanyo($tamanyo_nuevo){
        $this->tamanyo=$tamanyo_nuevo;
    }

    public function get_color(){
        return $this->color;
    }

    public function get_tamanyo(){
        return $this->tamanyo;
    }

    private function imprimir(){
        echo "<p><strong>color: </strong>".$this->get_color()."</p>";
        echo "<p><strong>tamaño: </strong>".$this->get_tamanyo()."</p>";
    }
}




?>