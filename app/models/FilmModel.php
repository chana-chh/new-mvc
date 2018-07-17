<?php

class FilmModel extends Model {

    protected $table = 'film';
    protected $pk = 'film_id';

    public function actors() {
        return $this->belongsToMany('ActorModel', 'film_actor', 'film_id', 'actor_id');
    }

}
