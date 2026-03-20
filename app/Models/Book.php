<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "cover",
        "title",
        "slug",
        "description",
        "price",
        "url",
        "num_pages",
        "category_id"
    ];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    protected function cover(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => "http://eltiempo.test/storage/" . $value,
        );
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => "http://eltiempo.test/storage/" . $value,
        );
    }
}
