<?php

class Request {
    public bool $isPost = false;
    public bool $isGet = false;

    public function __construct() {
        $this->isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        $this->isGet = $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public static function clear_parameter($param) {
        return strip_tags(trim($param));
    }

    public function clear_array(array $arr) {
        foreach ($arr as &$value) {
            $value = is_array($value) && !empty($value) 
                   ? $this->clear_array($value) 
                   : $this->clear_parameter($value);
        }
        return $arr;
    }

    public function post($param = '') {
        if ($param === '') {
            return $this->clear_array($_POST);
        }
        return isset($_POST[$param]) 
             ? $this->clear_parameter($_POST[$param]) 
             : null;
    }

    public function get($param = '') {
        if ($param === '') {
            return $this->clear_array($_GET);
        }
        return isset($_GET[$param]) 
             ? $this->clear_parameter($_GET[$param]) 
             : null;
    }

    public static function req_host() {
        return $_SERVER['HTTP_HOST'];
    }

    public function get_token() {
        return isset($_GET['token']) 
             ? $this->clear_parameter($_GET['token']) 
             : null;
    }
}

?>