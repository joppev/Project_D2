<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User')->withDefault();
    }

    public function kade()
    {
        return $this->belongsTo('App\Kade')->withDefault();
    }
    public function TijdTabel()
    {
        return $this->belongsTo('App\Tijdtabel')->withDefault();
    }
}
