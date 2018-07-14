<?php

class SqlController extends Controller {

    public function sqlTest() {

        $actor_model = new ActorModel();
        $film_model = new FilmModel();



        $data = $actor_model->selectAll();

        $this->view->render('sql/pocetna', compact('data'));
    }

}
