<?php
    require_once('config/db.php');
    $query = "select * from Product";
    $result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Product Page</title>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "myStyle.css"></link>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
    <style>
        .mainContent {
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .product-list {
            list-style: none;
            margin: 0;
            display: flex;
            flex-direction: column;
            padding-inline-start: 0px;
            height: 100%;
        }

        .product {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: 10px;
            justify-content: space-around;
        }

        .product-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 75%;
        }

        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }

        .product-name {
            font-size: 18px;
            margin-top: 15px;
            font-weight: bold;
        }

        .product-price {
            margin-top: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        .description {
            margin-top: 15px;
            font-size: 15px;
            display: none;
        }
        .visible {
            display: block;
        }
        .less {
            display: none;
        }
        button {
            padding: 10px 20px;
            border: 1px solid black;
            cursor: pointer;
            margin-top: 15px;
        }
        .bold {
            font-weight: bold;
        }
        .mr-10 {
            margin-right: 5px;
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
            <div class = "mainContent">
                <ul class="product-list">
                    <?php
                        while($row = mysqli_fetch_assoc($result))
                        {
                    ?>
                    <li>
                        <div class="product">
                            <img src=<?php echo $row['product_image']; ?> alt=<?php echo $row['product_name']; ?> class="product-image">
                            <div class="product-info">
                                <div id = <?php echo "itemName" . $row['product_id']; ?> class="product-name">
                                    <?php echo $row['product_name']; ?>
                                </div>
                                <div class="product-price">
                                    <div class = "bold mr-10">Item price:</div>
                                    <div id = <?php echo "itemPrice" . $row['product_id']; ?>><?php echo '$' . $row['product_price']; ?></div>
                                </div>
                                <button id = <?php echo "addToCartButton" . $row['product_id']; ?> class = "addToCart">
                                    Add to Cart
                                </button>
                                <button id = <?php echo "moreButton" . $row['product_id']; ?> class = "more">
                                    Show more
                                </button>
                                <div id = <?php echo "description" . $row['product_id']; ?> class = "description">
                                    <?php echo $row['product_description']; ?>
                                </div>
                                <button id = <?php echo "lessButton" . $row['product_id']; ?> class = "less">
                                    Show less
                                </button>
                            </div>
                        </div>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </div> 
    </div>
    <script>
        function myFunction() {
          var x = document.getElementById("myTopnav");
          if (x.className === "topnav") {
            x.className += " responsive";
          } else {
            x.className = "topnav";
          }
        }
        function onClickAddMoreButton(event) {
            event.preventDefault();
            var buttonId = event.target.id;
            if(buttonId.includes("moreButton")){
                var id = buttonId.substring(10, buttonId.length);
                var description = document.getElementById(`description${id}`)
                description.style.display = "block";
                document.getElementById(`${buttonId}`).style.display = "none";
                document.getElementById(`lessButton${id}`).style.display = "block";
            } else if(buttonId.includes("addToCartButton")){
                var id = buttonId.substring(15, buttonId.length);
                var itemName = document.getElementById("itemName" + id).innerText;
                var price = document.getElementById("itemPrice" + id).innerText;
                var itemPrice = parseInt(price.substring(1, price.length));
                var currItem = localStorage.getItem(id) ? JSON.parse(localStorage.getItem(id)) : null;
                var quantity = currItem ? currItem.quantity : 0;
                var obj = {'itemId': parseInt(id), 'itemName': itemName, 'itemPrice': itemPrice, 'quantity': parseInt(quantity) + 1};
                localStorage.setItem(id, JSON.stringify(obj));
                window.location.href = "cart.php";
            } else if(buttonId.includes("lessButton")){
                var id = buttonId.substring(10, buttonId.length);
                var description = document.getElementById(`description${id}`)
                description.style.display = "none";
                document.getElementById(`${buttonId}`).style.display = "none";
                document.getElementById(`moreButton${id}`).style.display = "block";
            }
        }
        window.onload = function () {
            var buttons = document.getElementsByTagName("button");
            var buttonArray = [...buttons];
            buttonArray.forEach(button => button.addEventListener('click', onClickAddMoreButton));
        }
    </script>
</body>