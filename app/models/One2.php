<?php

class One2 extends Model {

    protected $table = 'one2';

    // protected $pk = 'id';

    public function one1() {
        return $this->belongsTo('One1', 'one1_id');
    }

}
