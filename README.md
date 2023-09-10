# Interactive E-commerce Website

Welcome to the Interactive E-commerce Website project! This project showcases the development of an interactive e-commerce website integrated with a MySQL database. Users can explore products, add items to their cart, and place orders.

Website Link: http://swapnilg.sgedu.site/Project3/product.php

## Page 1: Products Page 

Products page displays all available products with their images, names, and prices. Each product listing includes two buttons: "Add to Cart" and "More."

- "Add to Cart" allows users to add products to their shopping cart list (stored as a session variable or in local storage). If an item is added multiple times, the quantity is updated.
- "More" reveals a detailed description of the product.

## Page 2: Cart Page

The Cart page lists items currently in the user's cart, retrieved from local storage or session variables. Each item is shown with its name, quantity, price, and total cost. There is also an option to remove items from the cart and adjust quantities.

- "Remove from Cart" removes the selected item.
- "Check Out" stores the order in the database, clears the cart, and redirects to the order page.
- "Continue Shopping" returns users to the Products page.

## Page 3: Orders Page

Orders page displays a comprehensive list of all orders, including order dates, order IDs, order totals, and item details (items ordered, quantity, and cost). Orders are sorted chronologically, with the most recent order appearing first.


