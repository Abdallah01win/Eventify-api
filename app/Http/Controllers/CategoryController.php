<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends CrudController
{
    protected $table = 'categories';

    protected $modelClass = Category::class;

    protected function getTable()
    {
        return $this->table;
    }

    protected function getModelClass()
    {
        return $this->modelClass;
    }

    protected function getReadAllQuery(): Builder
    {
        return $this->model()->select('id', 'name');
    }
}
