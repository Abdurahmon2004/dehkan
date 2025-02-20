<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SiteInfo extends Model
{
    use HasTranslations;
    protected $fillable = ['logo', 'phone', 'email', 'address'];
    public $translatable = ['address'];
}
