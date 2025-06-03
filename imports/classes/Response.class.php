<?php

class Response {

    public object $user;

    public function __construct(object $user) {
        $this->user = $user;
        
        if ($this->user->request->get_token() && empty($this->user->token)) {
            $this->redirect('index.php', []);
            exit;
        }
    }

    public function getLink(string $url, array $params): string {
        if (!empty($this->user->token) && !array_key_exists('token', $params)) {
            $params['token'] = $this->user->token;
        }

        if (!empty($params) && !str_contains($url, '?')) {
            $url .= '?';
        }

        foreach ($params as $prop => $value) {
            $url .= "{$prop}={$value}&";
        }

        return rtrim($url, '&');
    }

    public function redirect(string $url, array $params): void {
        header('Location: https://' . Request::req_host() . $this->getLink($url, $params));
    }
}

?>