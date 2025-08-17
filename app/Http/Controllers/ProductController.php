<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Infrastructure\Persistence\Eloquent\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('category', 'extras');

        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($categoryId = $request->query('category_id')) {
            $query->where('category_id', $categoryId);
        }
        if ($extras = $request->query('extras')) {
            $extraIds = is_array($extras) ? $extras : [$extras];
            $query->whereHas('extras', function ($relation) use ($extraIds) {
                $relation->whereIn('extras.id', $extraIds);
            });
        }

        return ProductResource::collection($query->paginate($request->integer('per_page', 15)));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        $product->extras()->sync($request->input('extras', []));

        return new ProductResource($product->load('category', 'extras'));
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load('category', 'extras'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        $product->extras()->sync($request->input('extras', []));

        return new ProductResource($product->load('category', 'extras'));
    }

    public function destroy(Product $product)
    {
        if ($product->orders()->exists()) {
            return response()->json(['message' => 'Product cannot be deleted'], 400);
        }
        $product->extras()->detach();
        $product->delete();
        return response()->noContent();
    }
}
