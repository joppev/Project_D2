<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nummerplaat extends Model
{
    public function bedrijf()
    {
        return $this->belongsTo('App\Bedrijf')->withDefault();
    }
}
