<?php

class Many2 extends Model {

    protected $table = 'many2';

    // protected $pk = 'actor_id';

    public function many1() {
        return $this->belongsToMany('Many1', 'many_many', 'many2_id', 'many1_id');
    }

}
