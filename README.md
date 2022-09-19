# Simple Ecommerce Retail API
## How to use ?

```
# Clone the repository
$ git clone https://github.com/nandes007/ecommerce-backend.git

# Move into repository
$ cd ecommerce-backend

# Remove the current origin repository
$ git remote remove origin
```

After the you can install the dependecies using composer
```
# Install dependecies
composer install

# Copy .env.example to .env for configuration
$ cp .env.example .env

# Generate APP_KEY
$ php artisan key:generate
```

```
# Migration table
$ php artisan migrate

# Start the development server
$ php artisan serve
```

Example hint to endpoint :
```
# example request to products endpoint using curl
curl -v http://127.0.0.1:8000/api/products

# example response
{
    "status": true,
    "message": null,
    "data": [
        {
            "id": "0100004",
            "product_name": "PEACH HALVES I/SYRUP 12/29OZ",
            "slug": "peach-halves-isyrup-1229oz",
            "tax": 0,
            "avgcost": "76000.00",
            "price": "82000.00",
            "weight": "2200.00",
            "stock": 48,
            "description": "Soluta vel sed est veniam aut. Veniam deleniti aut dolorem sequi.",
            "product_images": [
                {
                    "id": 1,
                    "product_id": "0100004",
                    "path": "uploads/images/original/product1.jpg"
                }
            ]
        },
        {
            "id": "0100245",
            "product_name": "SALAK BALI 24/565GR",
            "slug": "salak-bali-24565gr",
            "tax": 1,
            "avgcost": "71000.00",
            "price": "47000.00",
            "weight": "6300.00",
            "stock": 21,
            "description": "In atque blanditiis amet. Molestiae aliquid voluptatum rem rem ratione pariatur cum eos.",
            "product_images": [
                {
                    "id": 2,
                    "product_id": "0100245",
                    "path": "uploads/images/original/product2.jpg"
                }
            ]
        }
    ]
}
```
See more in **routes/api.php** file.

Before generate database. Make sure you have created a database and configure it in .env file.
Note: Unsure you have fill **MAIL** configuration and have **RAJA_ONGKIR_API** in .env file.

## Front-End

Here link to see font-end source code. [Ecommerce Front-End](https://github.com/nandes007/ecommerce-frontend).
