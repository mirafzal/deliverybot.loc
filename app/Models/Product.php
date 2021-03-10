<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name', 'info'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function options() {
        return $this->hasMany(Option::class);
    }
}
