<?php

class ActorModel extends Model {

    protected $table = 'actor';
    protected $pk = 'actor_id';

    public function films() {
        return $this->belongsToMany('FilmModel', 'film_actor', 'actor_id', 'film_id');
    }

}
