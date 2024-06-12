<?php

require "class_fruta.php";

class Uva extends Fruta{

    private $tieneSemilla;

    public function __construct($nuevo_color,$nuevo_tamanyo,$tiene){
        $this->tieneSemilla=$tiene;
        parent::__construct($nuevo_color,$nuevo_tamanyo); //parent es cuando hereda de otro objeto
    }


    public function tieneSemilla(){
        return $this->tieneSemilla;
    }



}
?>