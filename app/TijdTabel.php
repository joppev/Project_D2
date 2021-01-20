<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TijdTabel extends Model
{
    public function Plannings()
    {
        return $this->hasMany('App\Planning');
    }
}
