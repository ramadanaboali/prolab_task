<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_languages');
    }
}
