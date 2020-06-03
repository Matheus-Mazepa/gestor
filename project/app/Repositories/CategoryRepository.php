<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends Repository
{
    protected function getClass()
    {
        return Category::class;
    }

    public function toVSelect($criterias = [])
    {
        $categories = $this->pushCriteria($criterias)->all(['id', 'name', 'parent_id']);

        $categories = $categories->map(function ($category) {
            $label = ($category->parent)
                ? "{$category->parent->name} > $category->name"
                : $category->name;

            return ['label' => $label, 'id' => $category->id];
        });

        $categories = $categories->sortBy('label')->values();

        return $categories;
    }
}
