<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\App;

class Country extends Model
{
   
    public $timestamps=false;
    protected $guarded = [];
    public $appends=['name'];
   


    public function getNameAttribute()
    {

        if(\App::isLocale('en'))
        {
            return $this->attributes['name_en'] ?? $this->attributes['name_ar'];

        }
        else{
            return $this->attributes['name_ar'] ?? $this->attributes['name_en'];

        }

    }

   
   

   }
