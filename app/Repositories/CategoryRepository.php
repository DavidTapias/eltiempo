<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{
    public function getAllCategories()
    {
        return response()->json(["data" => Category::get(["id", "name"])],200);
    }
}