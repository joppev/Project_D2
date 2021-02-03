<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kade extends Model
{


    public function plannings()
    {
        return $this->hasMany('App\Planning');   // a genre has many records
    }


}
