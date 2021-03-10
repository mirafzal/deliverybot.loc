<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
