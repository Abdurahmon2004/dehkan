<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class About extends Model
{
    use HasTranslations;
    protected $fillable = ['image', 'description'];

    public $translatable = ['description'];

    protected $casts = [
        'image' => 'array', // Rasm array sifatida saqlanadi
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->image) {
                foreach ($model->image as $image) {
                    $image_path = public_path('/storage/'.$image);
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
            }
        });
    }

}
