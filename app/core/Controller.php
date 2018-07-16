<?php

class Controller {
    protected $app;
    protected $view;

    public function __construct() {
        $this->app = App::instance();
        $this->view = $this->app->view;
    }

    public function csrf() {
        $method = $this->app->getRouteMethod();
        if ($method === 'POST') {
            $params = $this->app->getRequestParams();
            if (!isset($params['csrf_token'])) {
                greska('CSRF');
            }
            if (!$this->app->csrf->isValid($params['csrf_token'])) {
                greska('CSRF');
            }
        }
    }

    public function before() {

    }

    public function after() {

    }

}
