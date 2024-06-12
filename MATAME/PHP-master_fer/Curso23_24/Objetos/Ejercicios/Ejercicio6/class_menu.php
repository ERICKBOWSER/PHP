<?php


class Menu
{

    private $array = array();

    public function cargar($url, $nombre)
    {
        $this->array[$nombre] = $url;
    }


    public function horizontal()
    {
        $imprimir = "";
        foreach ($this->array as $nombre => $url) {
            $imprimir.="<a href='" . $url . "'>" . $nombre . "</a> - ";
        }
        echo "<p>" . substr($imprimir,0,-2) . "</p>";
    }

    public function vertical()
    {
        echo "<p>";
        foreach ($this->array as $nombre => $url) {
            echo "<a href='" . $url . "'>" . $nombre . "</a></br>";
        }
        echo "</p>";
    }
}
