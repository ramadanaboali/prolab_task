<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Info extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public $appends=['name','logo'];

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


    public function getLogoAttribute()
    {
        if(\App::isLocale('en'))
        {
            return $this->attributes['logo_en'] != null ? asset('storage/info/images/'.$this->attributes['logo_en'] ) : null;

        }
        else{
            return $this->attributes['logo_ar'] != null ? asset('storage/info/images/'.$this->attributes['logo_ar'] ) : null;
        }


    }
}
