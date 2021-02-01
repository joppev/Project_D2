<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    public function gebruiker()
    {
        return $this->belongsTo('App\Gebruiker')->withDefault();
    }

    public function soort()
    {
        return $this->belongsTo('App\Soort')->withDefault();
    }

    public function kade()
    {
        return $this->belongsTo('App\Kade')->withDefault();
    }
    public function tijdTabel()
    {
        return $this->belongsTo('App\TijdTabel')->withDefault();
    }
}
