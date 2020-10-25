# BE take-home coding challenge
   
 
## Problem  Description:
Write a program that can price a cart of products, accept multiple products, combine offers, and display a total detailed bill in different currencies (based on user selection).

## Solution:
 Our Solution accepts the orders and the desired currencies from the users, Accepts offers listed in the problem definition, Print a detailed bill of the subtotal, tax, products of the order and discounts details if its available
 
 ## Please note that this task is BackEnd only 
 ## Laravel Framework v(8.11.2). Developed to be accessed with REST API  
 
 ###  **Models Used Generated**
 - Product
 - Order
 - Discount
 
 ### **Tables created**
 - products
 - orders
 - discounts
 - order_product

## To test the following task don't forget
 1. Create localhost on your machine
 2. Create database name it by "yashry"
 3. Run the following commands respectively 
    
        $ php artisan migrate
        $ php artisan db:seed
        
  4. Using Postman use the following Url with ***POST*** Request:   http://yashry/api/order  -***Make sure to clear the cache of the Postman***-
  
  5. **Parameters to be sent** (note that the parameters' __keys__ are case sensitive)
      1. Parameter **"order"** with the array of data you want to make an order with (eg. Key=order,  Value = [T-shirt,Pants,Jacket]):
      2. Parameter **"currency"** with the value or the desired currency USD or EGP (eg. Key=currency, Value = egp) 
    
    Example:
    
    Parameters:
     
    { 
        "order": "[T-shirt, T-shirt, Shoes, Jacket]",
        "currency": usd
    }
       
    The output of this order will be:
        
        "sub_total": 66.96,
        "taxes": 9.3744,
        "total": 63.84039999999999,
        "products": [
            {
                "product_name": "Tshirt",
                "egp_price": "175.84",
                "usd_price": "10.99"
            },
            {
                "product_name": "Tshirt",
                "egp_price": "175.84",
                "usd_price": "10.99"
            },
            {
                "product_name": "Jacket",
                "egp_price": "319.84",
                "usd_price": "19.99"
            },
            {
                "product_name": "Shoes",
                "egp_price": "399.84",
                "usd_price": "24.99"
            }
        ],
        "discounts": {
            "discount_shoes": "-2.50",
            "discount_jacket": "-10.00"
        }
        
        
### Note That we assumed that 1USD = 16EGP

**Things we missed:**

1. The unit tests are missing
2. The Discounts are made static not dynamic
3. User Authentication
 4. API Authentication


