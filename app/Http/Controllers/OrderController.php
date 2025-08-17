<?php

namespace App\Http\Controllers;

use App\Application\UseCases\PlaceOrder;
use App\Domain\DTOs\PlaceOrderDTO;
use App\Http\Requests\PlaceOrderRequest;
use App\Http\Resources\OrderResource;
use DomainException;

class OrderController extends Controller
{
    public function store(PlaceOrderRequest $request, PlaceOrder $useCase)
    {
        $dto = new PlaceOrderDTO(
            products: $request->validated('products'),
            paidCents: $request->validated('paid_cents'),
        );

        try {
            $order = $useCase->handle($dto);
            return new OrderResource($order);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}