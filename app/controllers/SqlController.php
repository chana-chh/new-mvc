<?php

class SqlController extends Controller {

    public function sqlTest() {

        // $actor_model = new ActorModel();
        $film_model = new FilmModel();

        $data = $film_model->selectAll();

        $this->view->render('sql/pocetna', compact('data'));
    }

    public function sqlTestPost($request) {

        if ($this->app->csrf->isValid($request['csrf_token'])) {
            echo e($request['korisnik']);
        } else {
            greska('CSRF');
        }
    }

}
