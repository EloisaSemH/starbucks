<?php

namespace App\Application\UseCases;

use App\Domain\DTOs\PlaceOrderDTO;
use App\Domain\Pricing\PriceCalculator;
use App\Domain\Specifications\HasSufficientStock;
use App\Domain\ValueObjects\Money;
use App\Infrastructure\Persistence\Contracts\{ProductRepository, ExtraRepository, OrderRepository};
use App\Infrastructure\Persistence\Eloquent\Models\Extra;
use App\Infrastructure\Persistence\Eloquent\Models\Order;
use Illuminate\Support\Facades\DB;

final class PlaceOrder
{
    public function __construct(
        private ProductRepository $products,
        private ExtraRepository $extras,
        private OrderRepository $orders,
        private PriceCalculator $calculator,
    ) {}

    public function handle(PlaceOrderDTO $dto): Order
    {
        $total = Money::fromInt(0);
        foreach ($dto->products as $requestedProduct) {
            $product = $this->products->findOrFail($requestedProduct['id']);

            if (!(new HasSufficientStock($product->stock))->isSatisfiedBy($requestedProduct['quantity'])) {
                throw new \DomainException('Insufficient stock');
            }

            $extraUnits = [];
            if (isset($requestedProduct['extras']) && count($requestedProduct['extras']) > 0) {
                $extras = $this->extras->findByIds($requestedProduct['extras']);
                $extraUnits = array_map(fn(Extra $extra) => Money::fromInt($extra->price_cents), $extras);
            }

            $unit = Money::fromInt($product->price->cents());
            $total = $total->add($this->calculator->compute($unit, $requestedProduct['quantity'], $extraUnits));
        }

        $paid = Money::fromInt($dto->paidCents);
        if (!$paid->greaterThanOrEqual($total)) {
            throw new \DomainException('Insufficient funds');
        }
        $change = $paid->minus($total);

        return DB::transaction(function () use ($dto, $extras, $unit, $total, $paid, $change) {
            /** @var Order $order */
            $order = $this->orders->create([
                'total_cents' => $total->cents(),
                'paid_cents' => $paid->cents(),
                'change_cents' => $change->cents(),
                'status' => 'completed',
            ]);
            foreach ($dto->products as $product) {
                $item = $order->items()->create([
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'unit_price_cents' => $unit->cents(),
                    'line_total_cents' => $total->cents(),
                ]);

                foreach ($extras as $extra) {
                    $item->extras()->create([
                        'extra_id' => $extra->id,
                        'price_cents' => $extra->price_cents,
                    ]);
                }

                $this->products->decrementStock($product['id'], $product['quantity']);
            }

            return $order->load('items.extras');
        });
    }
}
