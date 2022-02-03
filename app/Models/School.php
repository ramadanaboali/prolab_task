<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App as FacadesApp;
use Illuminate\Database\Eloquent\SoftDeletes;
class School extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    
}
