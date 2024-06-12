<?php


class Fruta{

    private $color;
    private $tamanyo;

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
}




?>