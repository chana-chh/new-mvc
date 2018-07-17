<?php

class Many1 extends Model {

    protected $table = 'many1';

    // protected $pk = 'actor_id';

    public function many2() {
        return $this->belongsToMany('Many2', 'many_many', 'many1_id', 'many2_id');
    }

}
