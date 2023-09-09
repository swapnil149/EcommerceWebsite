<?php
    require_once('config/db.php');
    $query = "select Order_table.order_id, Order_item.item_id, Product.product_name, Order_item.item_quantity, Order_table.ordered_date, Product.product_price FROM Order_table INNER JOIN Order_item ON Order_table.order_id = Order_item.order_id INNER JOIN Product ON Order_item.item_id = Product.product_id";
    $result = mysqli_query($conn,$query);
    $orderQuery = "select order_id, ordered_date FROM Order_table ORDER BY Order_table.ordered_date DESC, Order_table.order_id DESC";
    $orderResult = mysqli_query($conn,$orderQuery);
    $totalPriceArr = array();
    $data = array(); // Create an array to store fetched data
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['order_id'];
        $quantity = $row['item_quantity'] ? $row['item_quantity'] : 0;
        $item_price = $row['product_price'] ? $row['product_price'] : 0;
        $total_price = $quantity * $item_price;
        if(array_key_exists($id, $totalPriceArr)){
            $totalPricePerOrder = $totalPriceArr[$id] ? $totalPriceArr[$id]: 0;
            $totalPriceArr[$id] = $totalPricePerOrder + $total_price;
        } else {
            $totalPriceArr[$id] = $total_price;
        }
        // Add the fetched row to the data array
        $data[] = $row;
    }
?>

<!DOCTYPE html>

</html>
<head>
    <meta charset="UTF-8">
    <title>Orders Page</title>
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

        .order-list {
            list-style: none;
            margin: 0;
            display: flex;
            flex-direction: column;
            padding-inline-start: 0px;
            height: 100%;
            width: 75%;
        }
        .order {
            display: flex;
            flex-direction: row;
            align-items: center;
            text-align: center;
            margin: 10px;
            justify-content: space-around;
            width: 100%;
        }
        .orderEle {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            /* margin: 10px; */
            justify-content: space-around;
            width: 100%;
            padding: 20px;
        }
        .orderContainer {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: 20px;
            justify-content: space-around;
        }

        .product-info {
            width: 100%;
            padding: 25px;
        }
        .border-1 {
            border: 1px solid black;
            width: 100%;
        }
        .mb-10 {
            margin-bottom: 10px;
        }
        .fontWeight-600 {
            font-weight: 600;
        }
        .fontSize-18 {
            font-size: 18px;
        }
        .border-2 {
            border: 2px solid black;
        }
    </style>
</head>
<body>
    <div class = "container"> hello
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
                <ul class="order-list">
                    <?php
                        while($orderRow = mysqli_fetch_assoc($orderResult)){
                    ?>
                    <li>
                        <div class="orderContainer border-2">
                            <div class = "order">
                                <div class = "orderEle">
                                    <div class = "mb-10 fontWeight-600">ORDER ID</div>
                                    <div><?php echo $orderRow['order_id']; ?></div>
                                </div>
                                <div class = "orderEle">
                                    <div class = "mb-10 fontWeight-600">ORDER PLACED</div>
                                    <div><?php echo $orderRow['ordered_date']; ?></div>
                                </div>
                                <div class = "orderEle">
                                    <div class = "mb-10 fontWeight-600">TOTAL AMOUNT</div>
                                    <div><?php echo '$' . $totalPriceArr[$orderRow['order_id']]; ?></div>
                                </div>
                            </div>
                            <div class = "border-1"></div>
                            <ul class= "order-list product-info">
                                <?php
                                    foreach($data as $row) {
                                        if($row['order_id'] == $orderRow['order_id']){
                                ?>
                                            <li>
                                                <div class = "orderContainer">
                                                    <div class="fontSize-18"><b>Item name: </b><?php echo $row['product_name']; ?></div>
                                                    <div class="fontSize-18"><b>Item quantity: </b><?php echo $row['item_quantity']; ?></div>
                                                    <div class="fontSize-18"><b>Item price: </b><?php echo '$' . $row['product_price']; ?></div>
                                                </div>
                                            </li>
                                <?php
                                        }
                                    }
                                ?>
                            </ul>
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
    </script>
</body>

</html>