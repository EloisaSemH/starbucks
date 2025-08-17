<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExtraRequest;
use App\Http\Requests\UpdateExtraRequest;
use App\Http\Resources\ExtraResource;
use App\Infrastructure\Persistence\Eloquent\Models\Extra;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    public function index(Request $request)
    {
        $query = Extra::query();

        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        if (!is_null($request->query('is_active'))) {
            $query->where('is_active', (bool) $request->query('is_active'));
        }

        return ExtraResource::collection($query->paginate($request->integer('per_page', 15)));
    }

    public function store(StoreExtraRequest $request)
    {
        $extra = Extra::create($request->validated());
        return new ExtraResource($extra);
    }

    public function show(Extra $extra)
    {
        return new ExtraResource($extra);
    }

    public function update(UpdateExtraRequest $request, Extra $extra)
    {
        $extra->update($request->validated());
        return new ExtraResource($extra);
    }

    public function destroy(Extra $extra)
    {
        if ($extra->orderItems()->exists()) {
            return response()->json(['message' => 'Extra cannot be deleted'], 400);
        }

        $extra->delete();
        return response()->noContent();
    }
}
