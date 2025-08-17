<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Infrastructure\Persistence\Eloquent\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()->withCount('products');

        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        return CategoryResource::collection($query->paginate($request->integer('per_page', 15)));
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return new CategoryResource($category->loadCount('products'));
    }

    public function show(Category $category)
    {
        return new CategoryResource($category->loadCount('products')->load('products'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return new CategoryResource($category->loadCount('products'));
    }

    public function destroy(Category $category)
    {
        // TODO: soft delete category to not delete products
        if ($category->products()->exists()) {
            return response()->json(['message' => 'Category cannot be deleted'], 400);
        }
        $category->delete();
        return response()->noContent();
    }
}
