# Starbucks API — SOLID + Patterns

Example API with CRUD for **Categories**, **Products** and **Extras**, and **Order** endpoint with price calculation (product + extras), stock verification and change.

## About

It tries to follow as the best coding practices.
The decision to make money int, like banks, is because float problem when rounding.
There's a Postman collection named `Starbucks.postman_collection` in this root folder.

## Requirements

- Docker Desktop
- macOS (works on Linux/Windows with adjustments)

## Setting up the project

```bash
# Run the docker container
./vendor/bin/sail up -d

# Generate APP_KEY
./vendor/bin/sail artisan key:generate

# Run migrations and seed
./vendor/bin/sail artisan migrate --seed

# To run tests
sail artisan test

# To refresh the database
sail artisan migrate:fresh --seed
```

- You can start using the application. Order example with cURL:

```bash
curl -X POST http://localhost/api/orders \
  -H "Content-Type: application/json" \
  -d '{
    "products":[
        {
            "id": 1,
            "quantity": 2,
            "extras": [
                1,
                2
            ]
        },
        {
            "id": 2,
            "quantity": 1
        }
    ],
    "paid_cents": 2000
  }'
```

## Endpoints

### Categories

- GET /api/categories?search=latte&per_page=20
- POST /api/categories
    - Request payload

```json
{
    "name": "Espresso Drinks"
}
```

- GET /api/categories/{id}
- PUT/PATCH /api/categories/{id} — { "name": "New name" }
- DELETE /api/categories/{id}

### Products

- GET /api/products?category_id=1&search=latte&per_page=20
- POST /api/products
    - Request payload

```json
{
    "category_id": 1,
    "name": "Latte",
    "price_cents": 350,
    "stock": 50,
    "extras": [1, 2]
}
```

- GET /api/products/{id}
- PUT/PATCH /api/products/{id}
    - Request payload has the same structure as the `POST` endpoint
- DELETE /api/products/{id}

### Extras

- GET /api/extras?is_active=1&search=syrup&per_page=20
- POST /api/extras —

```json
{
    "name": "Syrup",
    "price_cents": 70,
    "is_active": true
}
```

- GET /api/extras/{id}
- PUT/PATCH /api/extras/{id}
    - Request payload has the same structure as the `POST` endpoint
- DELETE /api/extras/{id}

### Orders

- POST /api/orders
    - Request and response payloads

```json
{
    "products": [
        {
            "id": 1,
            "quantity": 2,
            "extras": [1, 2]
        },
        {
            "id": 2,
            "quantity": 1
        }
    ],
    "paid_cents": 2000
}
```

```json
{
    "data": {
        "id": 1,
        "total_cents": 940,
        "paid_cents": 1200,
        "change_cents": 260,
        "status": "completed",
        "items": [
            {
                "product": { "id": 1, "name": "Latte" },
                "quantity": 2,
                "unit_price_cents": 350,
                "line_total_cents": 940,
                "extras": [
                    { "id": 1, "name": "Cinnamon", "price_cents": 50 },
                    { "id": 2, "name": "Syrup", "price_cents": 70 }
                ]
            }
        ]
    }
}
```
