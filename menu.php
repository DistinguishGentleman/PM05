<?php

class Menu
{
    public array $menu = [];
    
    public function __construct(array $menu) {
        $this->menu = $menu;
    }

    public function HTMLmenu(array $menu){
        $html = "<ul>";
        foreach($this->menu as $key => $value){
            $html .= "<li><a href='" . $key . "'>" . $value . "</a></li>";
        };
        $html .= "</ul>";
        return $html;
    }
}