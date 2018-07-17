<?php

class One1 extends Model {

    protected $table = 'one1';

    // protected $pk = 'id';

    public function one2() {
        return $this->hasOne('One2', 'one1_id');
    }

}
