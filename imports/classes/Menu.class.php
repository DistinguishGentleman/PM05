<?php

class Menu {

    public array $menu = [];
    public object $response;

    public function __construct(array $menu_arr, object $response) {
        $this->menu = $menu_arr;
        $this->response = $response;
    }

    public function menu_html() {
        $menu_items = '';

        foreach ($this->menu as $item) {
            $current_file = basename($_SERVER['SCRIPT_FILENAME']);
            $link = $this->response->getLink($item['file'], []);

            $is_guest_access = $this->response->user->isGuest && in_array('guest', $item['access']);
            $is_admin_access = $this->response->user->isAdmin && in_array('admin', $item['access']);
            $is_author_access = !$this->response->user->isGuest && !$this->response->user->isAdmin && in_array('author', $item['access']);

            if ($is_guest_access || $is_admin_access || $is_author_access) {
                $active_class = ($current_file == $item['file']) ? ' class="colorlib-active"' : '';
                $menu_items .= "<li{$active_class}><a href=\"{$link}\">{$item['title']}</a></li>";
            }
        }
        
        return "<ul>{$menu_items}</ul>";
    }
}

?>