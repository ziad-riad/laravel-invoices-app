<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $guarded = [];

    public function  sections()  //name of the function (name of column).
    {
        return $this->belongsTo('App\sections','section_id'); // after App/"the name of  model relation".
    }
}
