<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasTranslations;
    protected $fillable = ['image', 'description', 'title'];

    public $translatable = ['description', 'title'];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->image && file_exists(public_path('/storage/'.$model->image))) {
                unlink(public_path('/storage/'.$model->image));
            }
        });
    }

}
