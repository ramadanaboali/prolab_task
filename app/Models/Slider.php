<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Slider extends Model
{
    use SoftDeletes;
    protected $fillable=['photo','name_en','name_ar','text_ar','text_en','active'];
    public $appends=['name','logo','text'];



    public function getTextAttribute(){
        if(App::isLocale('en'))
        {
            return $this->attributes['text_en'] ?? $this->attributes['text_en'];

        }
        else{
            return $this->attributes['text_ar'] ?? $this->attributes['text_ar'];

        }
    }

    public function getNameAttribute()
    {

        if(App::isLocale('en'))
        {
            return $this->attributes['name_en'] ?? $this->attributes['name_en'];

        }
        else{
            return $this->attributes['name_ar'] ?? $this->attributes['name_ar'];

        }

    }


    public function getLogoAttribute()
    {
        return $this->attributes['photo'] != null ? asset('storage/slider/images/'.$this->attributes['photo'] ) : null;

    }
}
