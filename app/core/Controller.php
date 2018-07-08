<?php

class Controller
{
    protected $app;
    protected $view;

    public function __construct()
    {
        $this->app = App::instance();
        $this->view = $this->app->view;
    }

    public function before()
    {

    }

    public function after()
    {

    }

}
