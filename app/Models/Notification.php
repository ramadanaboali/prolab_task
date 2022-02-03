<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    protected $table='notifications';
    protected $fillable =
        [

            'type',
            'user_id',
            'sender_id',
            'message'


        ];
    public function user()

    {

        return $this->belongsTo('App\User', 'user_id', 'id')->withTrashed();;

    }

    public function sender()

    {

        return $this->belongsTo('App\User', 'sender_id', 'id')->withTrashed();;

    }
}
