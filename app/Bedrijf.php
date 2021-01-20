<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bedrijf extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function nummerplaats()
    {
        return $this->hasMany('App\Nummerplaat');
    }
}
