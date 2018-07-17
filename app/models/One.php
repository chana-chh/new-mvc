<?php

class One extends Model {

    protected $table = 'one';

    // protected $pk = 'id';

    public function many() {
        return $this->hasMany('Many', 'one_id');
    }

}
