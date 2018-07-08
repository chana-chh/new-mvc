<?php

class CityModel extends Model
{
    protected $table = 'city';
    protected $pk = 'city_id';

    public function country()
    {
        return $this->hasOne('CountryModel', 'country_id');
    }

}
