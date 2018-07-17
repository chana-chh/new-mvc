<?php

class SqlController extends Controller {

    public function sqlTest() {

        $model_one1 = new One1();
        $model_one2 = new One2();

//        $this->app->db->beginTransaction();
//        for ($i = 1; $i <= 300000; $i++) {
//            $data1 = ['id' => $i, 'naziv' => 'one1 naziv ' . $i];
//            $model_one1->insert($data1);
//            $data2 = ['id' => $i, 'naziv' => 'one2 naziv ' . $i, 'one1_id' => $i];
//            $model_one2->insert($data2);
//        }
//        $this->app->db->commit();
//        die('KRAJ');

        $sql = "SELECT `one1`.*, `one2`.naziv AS o2 FROM `one1`, `one2` WHERE `one2`.`one1_id` = `one1`.`id` ORDER BY `one1`.`id` ASC;";

        $data = $model_one1->select($sql);

        $this->view->render('sql/pocetna', compact('data'));
    }

    public function sqlTestPost($request) {
        echo e($request['korisnik']);
    }

}
