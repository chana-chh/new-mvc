<?php

class SqlController extends Controller
{

    public function sqlTest(int $page)
    {
        $start = microtime(true);
        $drzave = new CountryModel();
        $gradovi = new CityModel();
        $rezultat = $drzave->selectAll();
        $broj = count($rezultat);
        $vreme = microtime(true) - $start . ' sec';
        $this->view->render('sql/pocetna', compact('rezultat', 'broj', 'vreme'));
    }

}
