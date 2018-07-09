<?php

class StatickeStraniceController extends Controller {

    public function pocetna() {
        $this->view->render('home/pocetna');
    }

    public function statementsSelect() {
        $this->view->render('statements/select');
    }

}
