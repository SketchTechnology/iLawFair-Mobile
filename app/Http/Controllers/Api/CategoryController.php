<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;


class CategoryController extends Controller
{
    public function mainCategories()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $categoriesResource = CategoryResource::collection($categories);
        return ApiResponse::sendResponse(200, 'Main categories retrieved successfully', $categoriesResource);
    }

    public function subCategories(Category $category)
    {
        $subCategories = $category->children;
        $subCategoriesResource = CategoryResource::collection($subCategories);
        return ApiResponse::sendResponse(200, 'Subcategories retrieved successfully', $subCategoriesResource);
    }
}
