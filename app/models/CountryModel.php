<?php

class CountryModel extends Model
{
    protected $table = 'country';
    protected $pk = 'country_id';

    public function cities()
    {
        return $this->hasMany('CityModel', 'country_id');
    }

}
