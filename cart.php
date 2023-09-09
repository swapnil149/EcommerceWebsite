<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart Page</title>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "myStyle.css"></link>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
    <style>
        .mainContent {
            padding: 20px;
        }

        .cart-list {
            list-style: none;
            margin: 0;
            display: flex;
            flex-direction: column;
            padding-inline-start: 0px;
        }

        .cartItem {
            display: flex;
            justify-content: center;

        }

        .productList {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }
        .listStyle {
            font-size: 15px;
            margin-top: 10px;
        }
        .cartButton {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
            justify-content: center;
            align-items: center;
        }
        button, .checkout {
            width: 24%;
            padding: 10px;
            border: 1px solid black;
            cursor: pointer;
            margin-top: 15px;
        }
        .mr-10 {
            margin-right: 10px;
        }
        .center {
            text-align: center;
        }
        .totalOrderPriceContainer {
            display: flex;
            justify-content: center;
        }
        .emptyCart {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            margin-top: 10px;
        }
        .bold {
            font-weight: bold;
        }
        .mr-20 {
            margin-right: 20px;
        }
        .checkoutSection {
            border-top: 1px solid black; 
            margin-top: 20px;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }
        .width-100{
            width: 100%;
        }
    </style>
</head>
<body>
    <div class = "container">
            <div class = "header">
                <div class = "companyLogo">
                    <a href="product.php">
                        <img class = "logo" src="Images/WeddingMelodiesLogo.jpeg" alt = "Company Logo"/>
                    </a>
                </div>
                <div class = "topnav" id = "myTopnav">
                    <div class = "topnavBox">
                        <a class = "home" href="product.php">Products</a>
                        <a class = "team" href="cart.php">Shopping Cart</a>
                        <a class = "songs" href="order.php">Orders</a>
                        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div id = "mainEle" class = "mainContent">
                <div id = "nonEmptyCart">
                    <div class = 'title'>Shopping Cart</div>
                    <ul id = "cartList" class="cart-list"></ul>
                    <div class = "checkoutSection">
                        <div class = "totalOrderPriceContainer">
                            <div class = "listStyle bold mr-10">Total Order Price:</div>
                            <div id = "totalOrderPrice" class = "listStyle"></div>
                        </div>
                        <form id="checkoutForm" class = "cartButton">
                            <input class = "checkout" type="submit" value="Checkout">
                        </form>
                        <div class = 'cartButton'>
                            <button id = "continueShopping" onclick="continueShopping()">Continue Shopping</button>
                        </div>
                    </div>
                </div>
                <div id = "emptyCart" class = "emptyCart">
                    <div>Your Shopping Cart is empty.</div>
                    <div>
                        <button id = "addProduct" class = "width-100">Continue Shopping</button>
                    </div>
                </div>
            </div> 
    </div>
    <script>
        var itemList = [];
        Object.keys(localStorage).forEach(key => {
            var obj = localStorage.getItem(key) ? JSON.parse(localStorage.getItem(key)) : null;
            if(obj) {
                itemList.push(obj);
            }
        })
        function renderCart(){
            var listEle = "";
            var totalOrderPrice = 0;
            var totalPrice = 0;
            if(itemList.length > 0){
                for(let item of itemList){
                    totalPrice = item.itemPrice * item.quantity;
                    totalOrderPrice += totalPrice;
                    listEle += `<li>
                                    <div class='productList'>
                                        <div class = "cartItem">  
                                            <div class = "mr-20">
                                                <div class='listStyle bold'>Item Name:</div>
                                                <div class='listStyle bold'>Price Per Item:</div>
                                                <div class='listStyle bold'>Quantity:</div>
                                                <div class = 'listStyle bold'>Total Price:</div>
                                            </div>
                                            <div>
                                                <div class='listStyle'>${item.itemName}</div>
                                                <div class='listStyle'>${'$' + item.itemPrice}</div>
                                                <div class='listStyle'>${item.quantity}</div>
                                                <div class = 'listStyle'>${'$' + totalPrice}</div>
                                            </div>
                                        </div>
                                        <div class = 'cartButton'>
                                            <button id = ${'decreaseQuantity' + item.itemId} onclick="decreaseItemQuantity(${item.itemId})" class = "buttonQuantity">Decrease Quantity</button>
                                            <button id = ${'removeItem' + item.itemId} onclick="removeItem(${item.itemId})" class = "buttonRemoveItem">Remove item from cart</button>
                                        </div>
                                    </div>
                                </li>`;
                }
                document.getElementById("cartList").innerHTML= listEle;
                document.getElementById("totalOrderPrice").innerHTML= '$' + totalOrderPrice;
                document.getElementById("checkoutForm").addEventListener("submit", function(event) {
                    event.preventDefault();
                    checkout();
                });
            } else {
                document.getElementById('nonEmptyCart').style.display = 'none';
                var emptyCartEle = document.getElementById('emptyCart');
                var mainEle = document.getElementById('mainEle');
                emptyCartEle.style.display = 'flex';
                mainEle.style.justifyContent = 'center';
                document.getElementById("addProduct").addEventListener("click", function(event) {
                    event.preventDefault();
                    continueShopping();
                });
            }
        }
        function continueShopping() {
            window.location.href = "product.php";
        }
        function checkout() {
            // Create a new XMLHttpRequest object
            var xhttp = new XMLHttpRequest();

            // Configure the AJAX request
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    // Clear the local storage after successful checkout
                    localStorage.clear();
                    // Redirect to the order page after successful checkout
                    window.location.href = `order.php?x=${Math.floor(Math.random() * 1000) + 1}`;
                }
            };

            // Open the AJAX request with the PHP script URL and POST method
            xhttp.open("POST", "config/checkout.php", true);

            // Set the request header for POST data (if needed)
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            // Prepare the data to send to the PHP script
            var data = "itemList=" + JSON.stringify(itemList);

            // Send the AJAX request with the data
            xhttp.send(data);
        }

        function removeItem(id) {
            var index = itemList.findIndex(item => item.itemId === id);
            if (index !== -1) {
                itemList.splice(index, 1);
                localStorage.removeItem(id);
                renderCart();
            }
        }
        function decreaseItemQuantity(id) {
            var item = itemList.find(item => item.itemId === id);
            if (item) {
                item.quantity = item.quantity - 1;
                if (item.quantity <= 0) {
                    removeItem(id);
                } else {
                    localStorage.setItem(id, JSON.stringify(item));
                    renderCart();
                }
            }
        }
        function myFunction() {
          var x = document.getElementById("myTopnav");
          if (x.className === "topnav") {
            x.className += " responsive";
          } else {
            x.className = "topnav";
          }
        }
        renderCart();
    </script>
</body>
</html>