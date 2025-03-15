<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'image'];

    public $translatable = ['title', 'description'];

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
