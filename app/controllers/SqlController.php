<?php

class SqlController extends Controller
{

    public function sqlTest(int $page)
    {
        $this->view->render('sql/pocetna');
    }

}
