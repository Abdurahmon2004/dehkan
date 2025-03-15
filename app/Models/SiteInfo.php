<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SiteInfo extends Model
{
    use HasTranslations;
    protected $fillable = ['logo', 'phone', 'email', 'address', 'description'];
    public $translatable = ['address', 'description'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->logo && file_exists(public_path('/storage/'.$model->logo))) {
                unlink(public_path('/storage/'.$model->logo));
            }
        });
    }
}
