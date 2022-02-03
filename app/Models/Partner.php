<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;
    protected $fillable=['name_en','name_ar','photo','url','active'];
    public $appends=['name','logo'];
    public function services()
    {
        return $this->hasMany('App\Models\Service', 'partner_id', 'id');
    }


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
        return $this->attributes['photo'] != null ? asset('storage/partner/images/'.$this->attributes['photo'] ) : null;

    }
}
