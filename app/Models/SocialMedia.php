<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $fillable = ['name', 'url', 'icon'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->icon && file_exists(public_path('/storage/'.$model->icon))) {
                unlink(public_path('/storage/'.$model->icon));
            }
        });
    }

}
