<?php

class Csrf {
    private $csrf_token;

    public function __construct(int $length = 32) {
        $token = bin2hex(random_bytes($length));
        $_SESSION['csrf_token'] = $token;
        $this->csrf_token = $token;
    }

    public function isValid($csrf_token) {
        return $_SESSION['csrf_token'] === $csrf_token;
    }

    public function csrfToken() {
        return $this->csrf_token;
    }

    public function metaTag() {
        return '<meta name="csrf" content="' . $this->csrf_token . '">';
    }

    public function inputTag() {
        return '<input type="hidden" name="csrf_token" value="' . $this->csrf_token . '">';
    }

}
