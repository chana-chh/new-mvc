<?php

class StatickeStraniceController extends Controller {

    public function pocetna() {
        $data311 = [
            'chana' => 'Chana',
            'mikica' => 'Mikica',
            'marijana' => 'Marijana',
        ];

        $this->view->render('home/pocetna', compact('data311'));
    }

    public function oNama() {
        $this->view->render('home/o_nama');
    }

    public function kontakt() {
        $this->view->render('home/kontakt');
    }

    public function test($id, $name) {
        $this->view->render('test/test', compact('id', 'name'));
    }

}
