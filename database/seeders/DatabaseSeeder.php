<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\{Category, Product, Extra};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $cinnamon = Extra::create([
            'name' => 'Cinnamon',
            'price_cents' => 50,
        ]);
        $yellowSugar = Extra::create([
            'name' => 'Yellow Sugar',
            'price_cents' => 20,
        ]);
        $syrup = Extra::create([
            'name' => 'Syrup',
            'price_cents' => 70,
        ]);
        $whipped = Extra::create([
            'name' => 'Whipped Cream',
            'price_cents' => 50,
        ]);

        $espressoDrinks = Category::create(['name' => 'Espresso Drinks']);
        Product::create([
            'category_id' => $espressoDrinks->id,
            'name' => 'Latte',
            'price_cents' => 500,
            'stock' => 100,
        ])
            ->extras()
            ->attach([$cinnamon->id, $syrup->id, $whipped->id]);
        Product::create([
            'category_id' => $espressoDrinks->id,
            'name' => 'Mocha',
            'price_cents' => 580,
            'stock' => 80,
        ])
            ->extras()
            ->attach([$cinnamon->id, $syrup->id, $whipped->id]);
        Product::create([
            'category_id' => $espressoDrinks->id,
            'name' => 'Macchiato',
            'price_cents' => 400,
            'stock' => 100,
        ])
            ->extras()
            ->attach([$cinnamon->id, $whipped->id]);
        Product::create([
            'category_id' => $espressoDrinks->id,
            'name' => 'Cappuccino',
            'price_cents' => 450,
            'stock' => 100,
        ])
            ->extras()
            ->attach([$cinnamon->id, $whipped->id]);
        Product::create([
            'category_id' => $espressoDrinks->id,
            'name' => 'Americano',
            'price_cents' => 300,
            'stock' => 100,
        ])
            ->extras()
            ->attach([$yellowSugar->id]);
        Product::create([
            'category_id' => $espressoDrinks->id,
            'name' => 'Espresso',
            'price_cents' => 250,
            'stock' => 100,
        ]);

        $brewedCoffee = Category::create(['name' => 'Brewed Coffee']);
        Product::create([
            'category_id' => $brewedCoffee->id,
            'name' => 'Filter Coffee',
            'price_cents' => 250,
            'stock' => 200,
        ])
            ->extras()
            ->attach([$cinnamon->id, $whipped->id]);
        Product::create([
            'category_id' => $brewedCoffee->id,
            'name' => 'Coffee Misto',
            'price_cents' => 300,
            'stock' => 200,
        ])
            ->extras()
            ->attach([$whipped->id]);

        $tea = Category::create(['name' => 'Tea']);
        $mint = Product::create([
            'category_id' => $tea->id,
            'name' => 'Mint',
            'price_cents' => 250,
            'stock' => 150,
        ])
            ->extras()
            ->attach([$cinnamon->id, $yellowSugar->id]);
        Product::create([
            'category_id' => $tea->id,
            'name' => 'Chamomile Herbal',
            'price_cents' => 300,
            'stock' => 50,
        ])
            ->extras()
            ->attach([$cinnamon->id, $yellowSugar->id]);
        Product::create([
            'category_id' => $tea->id,
            'name' => 'Earl Grey',
            'price_cents' => 300,
            'stock' => 50,
        ])
            ->extras()
            ->attach([$cinnamon->id, $yellowSugar->id]);
    }
}
