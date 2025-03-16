<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Video extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id'];

    public $translatable = ['text'];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->video && file_exists(public_path('/storage/'.$model->video))) {
                unlink(public_path('/storage/'.$model->video));
            }
            if ($model->thumbnail && file_exists(public_path('/storage/'.$model->thumbnail))) {
                unlink(public_path('/storage/'.$model->thubnail));
            }
        });
    }
}

