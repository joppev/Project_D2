<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gebruiker extends Model
{
    public function bedrijf()
    {
        return $this->belongsTo('App\Bedrijf')->withDefault();
    }

    public function Plannings()
    {
        return $this->hasMany('App\Planning');
    }
}
