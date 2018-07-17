<?php

class Many extends Model {

    protected $table = 'many';

    // protected $pk = 'id';

    public function one() {
        return $this->belongsTo('One', 'one_id');
    }

}
